<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Product;
use App\Http\Models\Cart;
use App\Models\User;
use Validator,Auth, Str, Config, Image;

class ProductController extends Controller
{
    //Obtiene los datos de los productos, esto se visualiza al momento de querer ver algun producto en la tienda
    //Muestra el nombre, precio, imagenes, etc.
    public function getProduct($id){
        $product = Product::findOrFail($id);
        $data = ['product' => $product];
        return view ('product.product_single', $data);
    }
 
   //Permite agregar un producto al carrito junto a la cantidad de este.
    public function postProductCart( Request $request){
     
        $rules = [
            'quantity' => 'required'
        ];
        $messages = [
            'quantity.required' => 'La cantidad de productos es necesaria'
            
        ];
        $validator = Validator::make($request-> all(), $rules , $messages);
        if($validator ->fails()):
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')
            ->with( 'typealert', 'danger');
        else:
            $cart                 = new Cart;
            $cart -> user_id      = Auth::id();
            $cart -> product_id   = $request->input('product_id');
            $cart -> quantity     = $request->input('quantity');
            $cart -> price        = $request->input('price');
            $cart -> setTotal();        
           
              if($cart -> save()):
            
                return back()->with('message', 'Producto añadido al carrito con éxito')
                ->with( 'typealert', 'success');
              endif; 
            
        endif;
        
    }
   
}
