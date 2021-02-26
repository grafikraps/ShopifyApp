<?php

namespace Grafikr\ShopifyApp\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Response as MakeResponse;
use Illuminate\Support\Str;

class ValidateJWT
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        try {
            [
                $header,
                $payload,
                $signature,
            ] = explode('.', Str::of($request->header('authorization'))->after('Bearer')->trim());
        } catch (\ErrorException $e) {
            return MakeResponse::make(status: Response::HTTP_UNAUTHORIZED);
        }

        if ($this->validate($header, $payload, $signature)) {
            $payload = json_decode(base64_decode($payload), true);
            $url = Arr::get(parse_url(Arr::get($payload, 'dest')), 'host');

            $request->merge(['shop' => $url]);
        } else {
            return MakeResponse::make(status: Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }

    /**
     * Validate JWT.
     *
     * @param string $header
     * @param string $payload
     * @param string $signature
     * @return bool
     */
    private static function validate(string $header, string $payload, string $signature): bool
    {
        $calculatedSignature = hash_hmac(
            'sha256',
            $header . '.' . $payload,
            config('shopify.private'),
            true
        );

        $calculatedSignatureBase64 = str_replace(
            ['+', '/', '='],
            ['-', '_', ''],
            base64_encode($calculatedSignature)
        );

        return hash_equals($calculatedSignatureBase64, $signature);
    }
}
