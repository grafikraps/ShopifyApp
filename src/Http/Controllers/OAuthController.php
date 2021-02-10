<?php

namespace Grafikr\ShopifyApp\Http\Controllers;

use Grafikr\ShopifyApp\Http\Requests\OAuthCallbackRequest;
use Grafikr\ShopifyApp\Models\Shop;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class OAuthController extends BaseController
{
    /**
     * Handle redirect request.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function redirect(Request $request): RedirectResponse
    {
        $nonce = Str::random(32);
        Session::put('nonce', $nonce);

        $url = 'https://' . $request->input('shop') . '/admin/oauth/authorize?' . http_build_query([
                'client_id' => config('shopify.public'),
                'scope' => implode(',', config('shopify.scope')),
                'redirect_uri' => URL::route('oauth.callback'),
                'state' => $nonce,
            ]);

        return Redirect::to($url);
    }

    /**
     * Confirm callback.
     *
     * @param OAuthCallbackRequest $request
     * @return RedirectResponse
     * @throws GuzzleException
     */
    public function callback(OAuthCallbackRequest $request): RedirectResponse
    {
        $client = new Client([
            'base_uri' => sprintf('https://%s/admin/', $request->input('shop')),
        ]);

        try {
            $response = $client->post('oauth/access_token', [
                'json' => [
                    'client_id' => config('shopify.public'),
                    'client_secret' => config('shopify.private'),
                    'code' => $request->input('code'),
                ],
            ])->getBody();
            $response = json_decode($response, true);
        } catch (GuzzleException $e) {
            return Redirect::route('initialize', [
                'shop' => $request->input('shop'),
            ]);
        }

        $shop = Shop::updateOrCreate(
            ['url' => $request->input('shop')],
            ['access_token' => Arr::get($response, 'access_token')],
        );

        // ShopInstalled::dispatch($shop);

        return Redirect::route('app', [
            'shop' => $request->input('shop'),
        ]);
    }
}
