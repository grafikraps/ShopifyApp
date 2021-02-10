<?php

namespace Grafikr\ShopifyApp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;

class OAuthCallbackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Session::get('nonce') === $this->input('state') && $this->validateHMAC();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'shop' => [
                'required',
                'regex:/[a-zA-Z0-9][a-zA-Z0-9\-]*\.myshopify\.com/',
            ],
            'state' => [
                'required',
                'string',
            ],
            'hmac' => [
                'required',
                'string',
            ],
            'code' => [
                'required',
                'string',
            ],
        ];
    }

    /**
     * Validate HMAC.
     *
     * @return bool
     */
    private function validateHMAC(): bool
    {
        $fields = $this->all();
        Arr::forget($fields, 'hmac');

        $calculated_hmac = hash_hmac('sha256', http_build_query($fields), config('shopify.private'));

        return hash_equals($calculated_hmac, $this->input('hmac'));
    }
}
