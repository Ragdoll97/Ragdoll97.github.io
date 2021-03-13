<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Orders extends Model
{
    use HasFactory;
    protected $date = ['deleted_at'];
    protected $table = 'orders';
    protected $hidden = ['created_at','updated_at'];

    public function getItems(){
        return $this->hasMany(Order_Items::class, 'order_id', 'id')->whereNull(['discount_until_date'])
        ->orWhere(function($query){$query->where('discount_until_date', '>=', date('Y-m-d'));})->with(['getProduct']);
    }
    public function getSubTotal(){
        return $this->hasMany(Order_Items::class, 'order_id', 'id')->whereNull(['discount_until_date'])
        ->orWhere(function($query){$query->where('discount_until_date', '>=', date('Y-m-d'));})->sum('total');
    }
}
