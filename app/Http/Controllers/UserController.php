<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator, Image, Auth, Config, Str, Hash;

class UserController extends Controller
{
    //Constructor que verifica que el usuario ha iniciado sesión
   public function __Construct(){
       $this->middleware('auth');
   }


   //Función que obtiene los datos del usuario al momento de ingresar a editar perfil.
   public function getAccountEdit(){
       $birthday = (is_null(Auth::user()->birthday)) ? [null,null,null] :  explode('-', Auth::user()->birthday);
       $data = ['birthday' => $birthday];
       return view('user.account_edit', $data);
   }

   //Permite guardar una imagen como avatar.
   public function postAccountAvatar(Request $request){
  
    $rules = [
        'avatar' => 'required',

    ];
    $messages = [

        'avatar.required' => 'El archivo no es una imagen',

    ];

    $validator = Validator::make($request->all(), $rules, $messages);
    if ($validator->fails()) :
        return back()->withErrors($validator)->with('message', 'Se ha producido un error')
            ->with('typealert', 'danger')->withInput();

    else :
        if ($request->hasFile('avatar')) :
            $path = '/'.Auth::id();
            $fileExt = trim($request->file('avatar')->getClientOriginalExtension());
            $upload_path = Config::get('filesystems.disks.uploads_users.root');
            $name = Str::slug(str_replace($fileExt, '', $request->file('avatar')->getClientOriginalName()));
            $filename = rand(1, 999) . '_' . $name . '.' . $fileExt;
            $file_file = $upload_path . '/' . $path . '/' . $filename;

            $u = User::find(Auth::id());
            $actualAvatar = $u->avatar;
            $u->avatar = $filename;
            if ($u->save()) :

                if ($request->hasFile('avatar')) :
                    $fl = $request->avatar->storeAs($path, $filename, "uploads_users");
                    $img = Image::make($file_file);
                    $img->fit(256, 256, function ($constraint) {  //Se crea una miniatura de las imagenes guardadas
                        $constraint->upsize();
                    });
                    $img->save($upload_path.'/'.$path.'/av_'.$filename);
                endif;
                if(!is_null($actualAvatar)):
                    unlink($upload_path.'/'.$path.'/'.$actualAvatar);
                    unlink($upload_path.'/'.$path.'/av_'.$actualAvatar);
                    endif;
               
               
                return back()->with('message', 'Avatar actualizado con éxito')
                    ->with('typealert', 'success');
            endif;
        endif;
    endif;
   }

   //Permite cambiar la contraseña del usuario.
   public function postPasswordEdit(Request $request){
    $rules = [
        'apassword' => 'required|min:8',
        'password'  => 'required|min:8',
        'cpassword' => 'required|min:8'

    ];
    $messages = [

        'apassword.required' => 'Escriba su contraseña actual',
        'apassword.min' => 'La contraseña debe tener 8 caracteres como minimo.',
        'password.required' => 'Escriba su nueva contraseña ',
        'password.min' => 'La contraseña debe tener 8 caracteres como minimo.',
        'cpassword.required' => 'Confirme su nueva contraseña',
        'cpassword.min' => 'La contraseña debe tener 8 caracteres como minimo.',
        'cpassword.same'=> 'Las contraseñas no coinciden'

    ];

    $validator = Validator::make($request->all(), $rules, $messages);
    if ($validator->fails()) :
        return back()->withErrors($validator)->with('message', 'Se ha producido un error')
            ->with('typealert', 'danger')->withInput();

    else :
        $u = User::find(Auth::id());
        if(Hash::check($request->input('apassword'), $u->password)):
            $u->password = Hash::make($request->input('password'));
            if ($u->save()) :
                return back()->with('message', 'Contraseña actualizada con éxito')
                ->with('typealert', 'success');
            endif;
        else:
        return back()->withErrors('message', 'Su contraeña es erronea')->with('typealert', 'danger')->withInput();
        endif;
    endif;
   }
   //Permite cambiar la información de la cuenta del usuario.
   public function postAccountInfo(Request $request){
    $rules = [
        'name' => 'required',
        'lastname'  => 'required',
        'phone' => 'required|min:8',
        'year' => 'required',
        'day' => 'required'
        

    ];
    $messages = [

        'name.required' => 'El nombre es requerido.',
        'lastname.required' => 'Su apellido es requerido.',
        'phone.required' => 'Su número de telefóno es requerido.',
        'phone.min' => 'El número de telefóno debe tener 8 números como minimo.',
        'year.required'=> 'Su año de nacimiento es requerido',
        'day,required' => 'Su día de nacimiento es requerido'

    ];

    $validator = Validator::make($request->all(), $rules, $messages);
    if ($validator->fails()) :
        return back()->withErrors($validator)->with('message', 'Se ha producido un error')
            ->with('typealert', 'danger')->withInput();

    else :
        $date = $request->input('year').'-'.$request->input('month').'-'.$request->input('day');
        $u = User::find(Auth::id());
        $u -> name = e($request->input('name'));
        $u -> lastname = e($request->input('lastname'));
        $u -> phone = e($request->input('phone'));
        $u -> birthday = date("Y-m-d", strtotime($date));
        $u -> gender = e($request->input('gender'));
        if ($u->save()) :
            return back()->with('message', 'Infomación actualizada con éxito')
            ->with('typealert', 'success');
        endif;
    endif;
   }
}

