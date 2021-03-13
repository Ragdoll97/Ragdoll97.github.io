<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $date = ['deleted_at'];
    protected $table = 'products';
    protected $hidden = ['created_at','updated_at'];

    public function cat(){
          # Un producto tiene una categoria
        return $this->hasOne(Category::class, 'id','category_id');
    }
    public function getSubCategory(){
          # Un producto tiene una subcategoria
        return $this->hasOne(Category::class, 'id','subcategory_id');
    }

    public function getGallery(){
          # Un producto tiene muchas imagenes
        return $this->hasMany(ProductGallery::class, 'product_id','id');
    }

    public function getInventory(){
          # Un producto tiene muchos inventarios
        return $this->hasMany(Inventory::class, 'product_id','id')->orderBy('price', 'Asc');
    }
    public function getPrice(){
      # Un producto tiene muchos precios
    return $this->hasMany(Inventory::class, 'product_id','id');
}
}
