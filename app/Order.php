<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    public $table = 'order_info';
    public $timestamps = false;

    public function items()
    {
        return $this->hasMany('\App\Item', 'id', 'item_id')->orderBy('title', 'ASC');
    }
}
