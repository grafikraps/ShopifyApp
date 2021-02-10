<?php

namespace Grafikr\ShopifyApp\Http\Controllers;

use Grafikr\ShopifyApp\Http\Middleware\RequireShopInput;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class AppController extends BaseController
{
    public function __construct()
    {
        $this->middleware(RequireShopInput::class)->except('login');
    }

    /**
     * Initialize the application.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
    {
        return Redirect::route('app.redirect', [
            'shop' => $request->input('shop'),
        ]);
    }

    /**
     * Show the app view.
     *
     * @param Request $request
     * @return Renderable
     */
    public function app(Request $request): Renderable
    {
        return View::make(config('shopify.views.app'), [
            'API_KEY' => config('shopify.public'),
            'SHOP_ORIGIN' => $request->input('shop'),
        ]);
    }

    /**
     * Show redirect view.
     *
     * @param Request $request
     * @return Renderable
     */
    public function redirect(Request $request): Renderable
    {
        return View::make('shopify-app::redirect', [
            'API_KEY' => config('shopify.public'),
            'SHOP_ORIGIN' => $request->input('shop'),
            'REDIRECT_URI' => URL::route('oauth.redirect'),
        ]);
    }

    /**
     * Show the login view.
     *
     * @return Renderable
     */
    public function login(): Renderable
    {
        return View::make(config('shopify.views.login'));
    }
}
