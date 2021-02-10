<?php

namespace Grafikr\ShopifyApp\Events;

use Grafikr\ShopifyApp\Models\Shop;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ShopInstalled
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param Shop $shop
     */
    public function __construct(public Shop $shop)
    {
    }
}
