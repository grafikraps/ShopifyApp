<?php

namespace Grafikr\ShopifyApp\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'url',
        'access_token',
    ];
}
