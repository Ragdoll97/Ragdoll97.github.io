<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $date = ['deleted_at'];
    protected $table = 'product_inventory';
    protected $hidden = ['created_at','updated_at'];

    public function getProduct(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function getVariant(){
        return $this->hasMany(Variant::class, 'inventory_id', 'id');
    }
}
