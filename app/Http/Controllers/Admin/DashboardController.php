<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Models\Product;

class DashboardController extends Controller
{
    //Constructor encargado de cargar los middleware
    //Auth se encarga de verificar si el usuario ha inciado sesión.
    //IsAdmin se encarga de verificar si el usuario cuenta con el rol de administrador
    //User Status verifica si el usuario esta bloqueado o activo dentro de la web.
    // User Permissions verifica los permisos del usuario.
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user.status');
        $this->middleware('user.permissions');
        $this->middleware('isadmin');
    }
    //función encargada de retornar al dashboard la cantidad de usuarios y productos
    //Tambien se puede retornar cualquier tipo de dato que se quiera mostrar en la pantalla principal
    //del panel administrativo.
    public function getDashboard()
    {
        
        $users = User::count();
        $products = Product::where('status', '1')->count();
        $data = ['users' => $users, 'products' => $products];
      
        return view('admin.dashboard', $data);
    }
    //función encargada de retornar los usuarios, necesario para mostrar la lista de estos en la vista usuarios
    //dentro del panel administrativo.
    public function getUsers()
    {
        $user = User::orderby('id', 'Desc')->get();
        return view('admin.users.home');

    }
}
