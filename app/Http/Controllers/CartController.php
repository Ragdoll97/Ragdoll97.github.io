<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Cart;
use App\Http\Models\Product;
use App\Http\Models\Orders;
use App\Http\Models\Order_Items;
use App\Http\Models\Inventory;
use App\Http\Models\Variant;
use Illuminate\Support\Facades\DB;
use Validator, Str, Config, Image, Auth;


class CartController extends Controller

{ 
    //Constructor que valida si el usuario ha iniciado sesión
    public function __construct()
    {
        $this->middleware('auth');
       
    }
    //Permite obtener los elementos del carrito.
   public function getCart(Request $request){

       $order = $this->getUserOrder();
       $items  = $order ->getItems;
       $data = ['order' => $order, 'items' => $items];
       return view('cart.home', $data);
   }
   public function getUserOrder(){
        $order = Orders::where('status', '0')->count();
        if($order == '0'):
            $order = new Orders;
            $order -> user_id = Auth::id();
            $order -> save();
        else:
            $order = Orders::where('status', '0')->first();
        endif;
        return $order;
   }

   public function postCartAdd(Request $request, $id){
       
       if(is_null($request->input('inventory'))):
            return back()->with('message', 'Seleccione alguna opción del producto.')->with('typealert', 'danger');
       else:
        //Aquí contamos si existe el inventario en la base de datos
            $inventory = Inventory::where('id',$request->input('inventory'))->count();
            if($inventory == "0"):
                //Si no existe, retorna el siguiente mensaje
                return back()->with('message', 'No hemos encontrado este producto.')->with('typealert', 'danger');
            else:
                $inventory = Inventory::find($request->input('inventory'));
                //Si existe, se hará una condicional, donde el inventario que viene en el campo oculto, pertenece al id del producto seleccionado
                if($inventory->product_id != $id):
                    //Si el id es diferente, entonces retorna el siguiente mensaje
                    return back()->with('message', 'No podemos agregar el producto.')->with('typealert', 'danger');
                //Si ninguna de las dos condicionales se realiza, se procedera a agregar el producto al carrito
                else:
                    $order = $this->getUserOrder();
                    $product = Product::find($id);
                    $variant_name = $inventory->name;
                    if($request->input('quantity') <1):
                        return back()->with('message', 'Es necesario ingresar la cantidad del producto.')->with('typealert', 'danger');
                    else:

                        if($inventory->limited == "0"):
                            if($request->input('quantity') > $inventory->quantity):
                                return back()->with('message', 'La selección supera la cantidad disponible del producto en inventario.')->with('typealert', 'danger');
                            endif;
                        endif;

                        if(count(collect($inventory->getVariant)) >"0"):
                            if(is_null($request->input('variant'))):
                                return back()->with('message', 'Seleccione alguna opción del producto.')->with('typealert', 'danger');
                            endif;
                        endif;

                        if(!is_null($request->input('variant'))):
                            $variant = Variant::where('id', $request->input('variant'))->count();
                            if($variant == "0"):
                                return back()->with('message', 'Selección no valida.')->with('typealert', 'danger');
                            else:
                                $variant = Variant::find( $request->input('variant'));
                                if($variant->inventory_id != $inventory->id):
                                    return back()->with('message', 'Selección no valida.')->with('typealert', 'danger');
                                endif;
                            endif;
                        endif;

                        $query = Order_Items::where('order_id', $order->id)->where('product_id', $product->id)->count();
                        if($query == "0"):
                            $oitem = new Order_Items;
                            $price = $this->getCalculatePrice($product->in_discount, $product->discount, $inventory->price);
                            $total = $price* $request->input('quantity');
                            if($request->input('variant')):
                                $variant = Variant::find($request->input('variant'));
                                $variant_label = ' / '.$variant->name;
                            else:
                                $variant_label = '';
                            endif;
                            $label = $product->name.' / '.$variant_name.$variant_label;
                            $oitem -> user_id = Auth::id();
                            $oitem -> order_id = $order->id;
                            $oitem -> product_id = $id;
                            $oitem -> inventory_id = $request->input('inventory');
                            $oitem -> variant_id = $request->input('variant');
                            $oitem -> label_item = $label;
                            $oitem -> quantity = $request->input('quantity');
                            $oitem -> discount_status = $product->in_discount;
                            $oitem -> discount = $product->discount;
                            $oitem -> discount_until_date = $product->discount_until_date;
                            $oitem -> original_price = $inventory->price;
                            $oitem -> price_unit = $price;
                            $oitem -> total = $total;
                            if($oitem->save()):
                                return back()->with('message', 'Producto Agregado con exito')->with('typealert', 'success');
                            endif;
                        else:
                            return back()->with('message', 'Este producto ya se encuentra en su carrito de compras')->with('typealert', 'danger');
                        endif;
                    endif;
                endif;
            endif;
        endif;
       
   }

   public function getCalculatePrice($in_discount, $discount, $price){
       $final_price = $price;
       if($in_discount == "1"):
            $discount_value = '0.'.$discount;
            $discount_calc = $price * $discount_value;
            $final_price = $price - $discount_calc;
       endif;
       return $final_price;

   }
   //Actualizar Cantidad productos en el carrito
   public function postCartItemQuantityUpdate($id, Request $request){
       $order = $this->getUserOrder();
       $oitem =  Order_Items::find($id);
       $inventory = Inventory::find($oitem->inventory_id);
       if($order->id != $oitem->order_id):
            return back()->with('message', 'No hemos podido actualizar el producto')->with('typealert', 'danger');
       else:
            if($inventory->limited == "0"):
                if($request->input('quantity') > $inventory->quantity):
                     return back()->with('message', 'La cantidad supera el inventario')->with('typealert', 'danger');
                endif;
            endif;
            $total = $oitem->price_unit * $request->input('quantity');
            $oitem -> quantity = $request->input('quantity');
            $oitem -> total = $total;
            if($oitem->save()):
                return back()->with('message', 'Cantidad Actualizada con éxito')->with('typealert', 'success');
            endif;
       endif;
   }

   //Permite eliminar productos del carrito usando el id.
   public function getCartItemDelete($id){
    $oitem =  Order_Items::find($id);
    if($oitem->delete()):
       
        return back()->with('message', 'Producto eliminado')->with('typealert', 'success');
    endif;

   }


  
}
