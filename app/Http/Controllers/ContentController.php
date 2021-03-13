<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Category;
use App\Http\Models\Slider;
use App\Http\Models\Product;
use App\Http\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Validator,Auth, Str, Config, Image;
class ContentController extends Controller
{
    //Tienda
    public function getStore(){
        $categories = Category::where('module', '0')->where('parent', '0')->orderBy('name', 'Asc')->get();
        $data = ['categories' => $categories];
        return view('store',$data);
    }


    //Función que muestra en la vista principal la galeria, las categorias y permite acceder a estas.
    public function getHome(){
        $categories = Category::where('module', '0')->where('parent', '0')->orderBy('name', 'Asc')->get();
        $sliders = Slider::where('status', 1)->orderBy('sorder', 'Asc')->get();
        $data = ['categories' => $categories, 'sliders' => $sliders];
        return view('home', $data);
    }

    //función que permite ingresar a los productos por medio de las categorias.
    public function getCategory($id, $slug){
        $category = Category::findOrFail($id);
        $categories = Category::where('module', '0')->where('parent', $id)->orderBy('name', 'Asc')->get();
        $data = ['categories' => $categories, 'category' => $category];
        return view('category',$data);
    }

    public function postSearch(Request $request){
        $products = Product::where('status', 1)->where('name', 'LIKE', '%'.$request->input('search_query').'%')->orderBy('id', 'Asc')->get();
        $data = ['query' => $request->input('search_query'), 'products' => $products];
        return view ('search', $data);
    }
}
