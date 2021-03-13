<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Cart extends Model
{
    use HasFactory;
  
    protected $date = ['deleted_at'];
    protected $table = 'cart';
    protected $hidden = ['created_at','updated_at'];
     // Definimos la relacion entre un cart y sus detalles
     public function details(){
        #Un carrito tendrá muchos detalles  asociados
        return $this->hasMany(CartDetail::class);
    }

    public function getProduct(){
        # Un carrito tiene muchos productos
      return $this->hasOne(Product::class, 'id','product_id');
  }
    public function setTotal() {
        # Permite calcular el total de venta.
    return $this->total = $this->price * $this->quantity;
    }
    
    public function Price(){
        # Permite obtener el precio.
        return $this->hasOne(Product::class,'id', 'price');
    }

    

}
