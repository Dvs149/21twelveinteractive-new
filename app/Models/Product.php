<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'detail','image','price'
    ];

    protected $appends = ['product_image_url'];
    public function getProductImageUrlAttribute() {
        return url(config('custom.PRODUCT_IMAGE_PATH').$this->attributes['image']);
    }
    
    public function getCreatedAtAttribute( $value ) {
       return $this->attributes['date'] = (new Carbon($value))->format('d/m/y');
    }
    public function user()
    {
        return $this->belongsToMany(User::class);
    }
    public function order()
    {
        return $this->hasMany(Order::class,"product_id","id");
    }
}
