<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Slider;
use Validator, Auth,Str, Config, Image;

class SliderController extends Controller
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

    //Función encargada de retornar la vista 
    //para gestionar las imagenes de la galeria que se muestra en la tienda.
    public function getHome(){

        $sliders = Slider::orderBy('sorder', 'Asc')->get();
        $data = ['sliders' => $sliders];
        return view ('admin.slider.home', $data);

    }

    //Permite guardar las imagenes que se mostraran en la galeria.
    public function postSliderAdd(Request $request){
        $rules = [
            'name' => 'required',
            'img' => 'required|image',
            'content' => 'required',
            'sorder' => 'required'
        ];
        $messages = [
            'name.required' => 'El nombre de la imagen es requerido.',
            'img.image' => 'El archivo no es una imagen.',
            'img.required' => 'La imagen es obligatoria.',
            'content.required' => 'El contenido es obligatorio.',
            'sorder.required' => 'Es necesario definir un orden de presentación.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) :
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')
                ->with('typealert', 'danger')->withInput();
        else:
            $path = '/'.date('Y-m-d'); // organiza las imagenes en carpetas usando la fecha.
            $fileExt = trim($request->file('img')->getClientOriginalExtension());
            $upload_path = Config::get('filesystems.disks.uploads.root');
            $name = Str::slug(str_replace($fileExt, '', $request->file('img')->getClientOriginalName()));
            $filename = rand(1, 999).'-'.$name.'.'.$fileExt;

            $slider = new Slider;
            $slider -> user_id = Auth::id();
            $slider -> status = $request->input('status');
            $slider -> name = e($request->input('name'));
            $slider -> file_path =  date('Y-m-d');
            $slider -> file_name = $filename;
            $slider -> content = e($request->input('content'));
            $slider -> sorder = e($request->input('sorder'));
            if($slider -> save()):
                if ($request->hasFile('img')) :
                    $fl = $request->img->storeAs($path, $filename, "uploads");
                    
                endif;
                return back()->with('message', 'Guardado con éxito')
                ->with( 'typealert', 'success');
            endif;
        endif;

    }
    //Permite cambiar el nombre de la imagen y otros datos
    //Pero no se permite cambiar la imagen, ya que es preferible borrarla de la base de datos
    public function getEditSlider($id){
        $slider = Slider::findOrFail($id);
        $data = ['slider' => $slider];
        return view ('admin.slider.edit', $data);

    }

    //Función que guarda los datos al momento de editar un slider.
    public function postEditSlider(Request $request ,$id){
        $rules = [
            'name' => 'required',
            'content' => 'required',
            'sorder' => 'required'
        ];
        $messages = [
            'name.required' => 'El nombre de la imagen es requerido.',
            'content.required' => 'El contenido es obligatorio.',
            'sorder.required' => 'Es necesario definir un orden de presentación.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) :
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')
                ->with('typealert', 'danger')->withInput();
        else:
            $slider = Slider::find($id);
            $slider -> status = $request->input('status');
            $slider -> name = e($request->input('name'));
            $slider -> content = e($request->input('content'));
            $slider -> sorder = e($request->input('sorder'));
            if($slider -> save()):
                return back()->with('message', 'Guardado con éxito')
                ->with( 'typealert', 'success');
            endif;
        endif;
    }

    //Permite eliminar imagenes de la galeria utilizando su id.
    public function getDeleteSlider($id){
        $slider = Slider::findOrFail($id);
        if($slider->delete()):
           
            return back()->with('message', 'Imagen eliminada con exito')->with('typealert', 'success');
        endif;
    }
}
