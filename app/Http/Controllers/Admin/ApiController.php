<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Category;

class ApiController extends Controller
{
    //Constructor encargado de cargar los middleware
    //Auth se encarga de verificar si el usuario ha inciado sesión.
    //IsAdmin se encarga de verificar si el usuario cuenta con el rol de administrador
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isadmin');
    }
    
    //Función encargada de retornar las sub-categorias utilizando parent como medio.
    public function getSubCategories($parent){
        $categories = Category::where('parent', $parent)->get();
        return response()->json($categories);
    }
}
