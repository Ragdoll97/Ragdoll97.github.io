<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Product;
use App\Http\Models\Inventory;
use App\Http\Models\Favorite;
use App\Http\Models\Category;
use Config, Auth;

class ApiJsController extends Controller
{
    //Constructor encargado de cargar los middleware
    //Auth se encarga de verificar si el usuario ha inciado sesión.
    public function __construct()
    {
        $this->middleware('auth')->except(['getProductSection']);
    }

    //Función que permite mostrar los productos en la pagina principal (Tienda)
    public function getProductSection($section, Request $request){
        
        $items_x_page = Config::get('cms.products_page');
        $items_x_page_random = Config::get('cms.products_page_random');
        switch ($section) :
            case 'home':
                $products = Product::where('status', 1)->inRandomOrder()->paginate($items_x_page_random);
                break;
            case 'store':
                $products = Product::where('status', 1)->orderBy('id', 'Desc')->paginate($items_x_page);
                break;
            case 'store_category':
                $products = $this->getProductCategory($request->get('object_id'), $items_x_page);
                break;
            
            default:
                $products = Product::where('status', 1)->inRandomOrder()->paginate($items_x_page_random);
                break;
        endswitch;
        return $products;
    }

    public function getProductCategory($id, $ipp){
        $category = Category::findOrFail($id);
        if($category->parent == "0"):
            $query = Product::where('status', 1)->where('category_id',$id)->orderBy('id', 'Desc')->paginate($ipp);
        else:
            $query = Product::where('status', 1)->where('subcategory_id',$id)->orderBy('id', 'Desc')->paginate($ipp);
        endif;
        return $query;
       
    }

    //Permite que los usuarios agregen productos a favoritos.
    function postFavoriteAdd($object, $module, Request $request){
        $query = Favorite::where('user_id', Auth::id())->where('module', $module)
        ->where('object_id', $object)->count();
        if($query > 0):
            $data = ['status' => 'error', 'msg' => 'Este elemento ya esta en favoritos'];
        else:
            $favorite = new Favorite;
            $favorite -> user_id = Auth::id();
            $favorite -> module = $module;
            $favorite -> object_id = $object;
            if($favorite->save()):
                $data = ['status' => 'success', 'msg' => 'Guardado en favoritos'];
            endif;
        endif;
        return response()->json($data);
    }

   public function postUserFavorites (Request $request){
     //Aqui haremos un arreglo, para pasar los objetos.
     //La función explode busca toda las " , " y crea un array apartir de ese punto, 
     //retornando la cantidad de objetos.
       $objects = json_decode($request->input('objects'),true);
       $query = Favorite::where('user_id', Auth::id())->where('module', $request->input('module'))
       ->whereIn('object_id', explode(",", $request->input('objects' )))->pluck('object_id');
       if (count(collect($query))> 0):
            $data = ['status' => 'success', 'count' => count(collect($query)), 'objects' => $query];
       else:
            $data = ['status' => 'success', 'count' => count(collect($query))];
       endif;
       return response()->json($data);
    }

    public function postProductInventoryVariant($id) {
        $query = Inventory::find($id);
        return response()->json($query->getVariant);
    }
}
