<?php

namespace App\Models;

use App\Models\Address;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';

    public function address()
    {
        return $this->belongsTo(Address::class,"address_id","id");
    }
    public function product()
    {
        return $this->belongsTo(Product::class,"product_id","id");
    }
}
