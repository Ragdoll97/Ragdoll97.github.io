<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Category;
use Validator, Str, Config, Image;

class CategoriesController extends Controller
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
    //Función encargada de retornar a la vista home las categorias.
    public function getHome($module){
        $cats = Category::where('module',$module)->where('parent', '0')-> orderBy('order', 'Asc')->get();
        $data = ['cats'=> $cats, 'module' => $module];
        return view('admin.categories.home',$data);
    }
    //Función encargada de enviar los datos, al momento de agregar una nueva categoria
    //rules y messages sirve para mostrar los mensajes en pantalla y hacer que ciertas secciones sean obligatorias.
    public function postCategoryAdd(Request $request, $module){
        $rules = [
            'name' => 'required',
            'icon' => 'required'
        ];
        $messages = [
            'name.required' => 'El nombre de la categoria es obligatorio',
            'icon.required' => 'La categoria necesita un icono'
        ];
        $validator = Validator::make($request-> all(), $rules , $messages);
        if($validator ->fails()):
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')
            ->with( 'typealert', 'danger');
        else:
            $path = '/' . date('Y-m-d'); // organiza las imagenes en carpetas usando la fecha.
            $fileExt = trim($request->file('icon')->getClientOriginalExtension());
            $upload_path = Config::get('filesystems.disks.uploads.root');
            $name = Str::slug(str_replace($fileExt, '', $request->file('icon')->getClientOriginalName()));
            $filename = rand(1, 999).'-'.$name.'.'.$fileExt;
           

            $c = new Category;
            $c -> module = $module;
            $c -> parent = $request-> input('parent');
            $c -> name = e($request -> input ('name'));
            $c -> slug = Str::slug($request -> input ('name'));
            $c -> file_path = date('Y-m-d');
            $c -> icon = $filename;
            if($c -> save()):
                if ($request->hasFile('icon')) :
                    $fl = $request->icon->storeAs($path, $filename, "uploads");
                    
                endif;
                return back()->with('message', 'Guardado con éxito')
                ->with( 'typealert', 'success');
            endif;
        endif;
    }
    //Función encargada de retornar los datos de categorias para su posterior 
    //edición, esto necesario para cambiar datos o bien cambiar algun error de tipeo.
    //todo esto se muestra en la vista categorias/edit
    public function getCategoryEdit($id){
        $cat = Category::find($id);
        $data = ['cat'=> $cat];
        return view('admin.categories.edit',$data);

    }
    //Función encargada de enviar los datos al momento de editar alguna categoria, esto permite guardarlo
    //en la base de datos.
    public function postCategoryEdit(Request $request, $id){
        $rules = [
            'name' => 'required'
            
        ];
        $messages = [
            'name.required' => 'El nombre de la categoria es obligatorio'
        ];
        $validator = Validator::make($request-> all(), $rules , $messages);
        if($validator ->fails()):
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')
            ->with( 'typealert', 'danger');
        else:
            $c = Category::find($id);
           
            $c -> name = e($request -> input ('name'));
            $c -> slug = Str::slug($request -> input ('name'));
            if ($request->hasFile('icon')) :
                $actual_icon = $c -> icon;
                $actual_file_path = $c -> file_path;
                $path = '/' . date('Y-m-d'); // organiza las imagenes en carpetas usando la fecha.
                $fileExt = trim($request->file('icon')->getClientOriginalExtension());
                $upload_path = Config::get('filesystems.disks.uploads.root');
                $name = Str::slug(str_replace($fileExt, '', $request->file('icon')->getClientOriginalName()));
                $filename = rand(1, 999).'-'.$name.'.'.$fileExt;
                $fl = $request->icon->storeAs($path, $filename, "uploads");
                $c -> file_path = date('Y-m-d');
                $c -> icon = $filename;
                if(!is_null($actual_icon)):
                unlink($upload_path.'/'.$actual_file_path.'/'.$actual_icon);
                endif;
            endif;
            $c -> order = $request-> input('order');
            if($c -> save()):
            
                return back()->with('message', 'Guardado con éxito')
                ->with( 'typealert', 'success');
            endif;
        endif;
    }
    //Función encargada de retornar las sub-categorias, enviando los datos a la vista
    //categorias / sub-categorias
    public function getSubCategories($id){
        $cat = Category::findOrFail($id);
        $data = ['category'=> $cat];
        return view('admin.categories.sub_categories',$data);
    }
    //Función que permite eliminar categorias de la base de datos.
    public function getCategoryDelete($id){
        $c = Category::find($id);
        if($c -> delete()):
            return back()->with('message', 'Eliminado con éxito')
            ->with( 'typealert', 'success');
        endif;
    }
}
