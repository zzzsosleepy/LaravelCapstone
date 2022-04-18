<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShoppingCart extends Model
{

    public $table = 'shopping_cart';
    public $timestamps = false;

    public function items()
    {
        return $this->hasMany('\App\Item', 'id', 'item_id')->orderBy('title', 'ASC');
    }
}
