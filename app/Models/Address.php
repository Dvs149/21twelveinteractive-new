<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'address';

    public function user()
    {
        return $this->belongsTo(User::class,"user_id","id");
    }
    public function order()
    {
        return $this->hasMany(Order::class,"address_id","id");
    }
    

}
