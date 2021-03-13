<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator, Hash, Auth, Mail, Str;
use App\Mail\UserSendRecover;
use App\Mail\UserSendNewPassword;
use App\Models\User;

class ConnectController extends Controller
{
    //Constructor que verifica si el usuario es un invitado
    //Permitiendole iniciar sesión o crear una cuenta, etc.
    public function __construct()
    {
        $this->middleware('guest')->except(['getLogout']);
    }

    //Crear metodo GetLogin
    public function getLogin()
    {
        return view('connect.login');
    }

    //Crear metodo postLogin
    public function postLogin(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ];

        $messages = [
            'email.required' => "El correo es obligatorio",
            'email.email' => "Formato Invalido",
            'password.required' => "Por favor escriba su contraseña",
            'password.min' => "La contraseña debe ser de al menos 8 caracteres",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) :
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')
                ->with('typealert', 'danger');
        //Autenticacion de usuarios existente y de usuarios en si.
        else :
            if (Auth::attempt([
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ], true)) :
                if (Auth::user()->status == "100") :
                    return redirect('/logout');
                else :
                    return redirect('/');
                endif;
            else :
                return back()->with('message', 'Correo electronico o contraseña erronea')
                    ->with('typealert', 'danger');
            endif;
        endif;
    }

    //Crear metodo GetRegister
    public function getRegister()
    {
        return view('connect.register');
    }
    //Crear metodo postRegister
    //Se crean las reglas para cada campo requerido en el registro
    public function postRegister(Request $request)
    {
        $rules = [
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'cpassword' => 'required|min:8|same:password'
        ];

        $messages = [
            'name.required' => "El nombre es obligatorio",
            'lastname.required' => "El apellido es obligatorio",
            'email.required' => "El correo es obligatorio",
            'email.email' => "Formato Invalido",
            'password.required' => "Por favor escriba su contraseña",
            'password.min' => "La contraseña debe ser de al menos 8 caracteres",
            'cpassword.required' => "Por favor escriba nuevamente su contraseña",
            'cpassword.min' => "La contraseña debe ser de al menos 8 caracteres",
            'cpassword.same' => "Las contraseñas deben ser iguales"
        ];
        //Se crea la variable para validar los datos,
        // el cual compara las peticiones utilizando las reglas creadas anteriomente
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) :
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger');
        else :
            $user = new User;
            $user->name = e($request->input('name'));
            $user->lastname = e($request->input('lastname'));
            $user->email = e($request->input('email'));
            $user->password = Hash::make($request->input('password'));

            if ($user->save()) :
                return redirect('/login')->with(
                    'message',
                    'Su usuario se ha creado con exito'
                )->with('typealert', 'success');
            endif;
        endif;
    }

    // Cierre de sesion de usuarios
    public function getLogout()
    {
        $status = Auth::user()->status;
        Auth::logout();
        if($status == "100"):
            return redirect('/login')->with('message','Su usuario ha sido suspendido'
            )->with('typealert', 'danger');
        else:
            return redirect('/login');
        endif;
        
    }
    //Permite recuperar una contraseña, usando el codigo que se envia el correo.
    public function getRecover(){
        return view('connect.recover');
    }

   //Permite ingresar el correo que se desea recuperar.
    public function postRecover(Request $request){
        $rules = [
            'email' => 'required|email',
        ];

        $messages = [       
            'email.required' => "El correo es obligatorio",
            'email.email' => "Formato Invalido",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) :
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')
            ->with('typealert', 'danger');
        else :
            $user = User::where('email', $request->input('email'))->count();
            if($user == "1"):
                $user = User::where('email', $request->input('email'))->first();
                $code = rand(100000, 999999);
                $data =['name' => $user->name, 'email' => $user->email, 'code' => $code];
                $u = User::find($user->id);
                $u -> password_code = $code;
                if($u ->save()):
                Mail::to($user->email)->send(new UserSendRecover($data));
                return redirect('/reset?email='.$user->email)->
                with('message', 'Ingrese el código que hemos enviado a su correo electrónico')
                ->with('typealert', 'success');
                endif;
            else:
                return back()->withErrors($validator)->
                with('message', 'Este correo electronico no existe')->with('typealert', 'danger');
            endif;
        endif;
    }
    //función que envia una contraseña temporal al correo del usuario
    public function getReset(Request $request){

        $data = ['email' => $request->get('email')];
        return view('connect.reset', $data);
    }
    //Permite ingresar con la contraseña temporal.
    public function postReset(Request $request){
        $rules = [
            'email' => 'required|email',
            'code'  => 'required'
         ];

        $messages = [       
            'email.required' => "El correo es obligatorio",
            'email.email' => "Formato Invalido",
            'code.required' => "El codigo de recuperación es requerido"
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) :
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')
            ->with('typealert', 'danger');
        else :
            $user = User::where('email', $request->input('email'))->where('password_code', $request
            ->input('code'))->count();
            if ($user == "1"):
                $user = User::where('email', $request->input('email'))
                ->where('password_code', $request->input('code'))->first();
                $new_password = Str::random(8);
                $user-> password = hash::make($new_password);
                $user -> password_code = null;
                if ($user ->save()):
                    $data =['name' => $user->name, 'password' => $new_password];
                    Mail::to($user->email)->send(new UserSendNewPassword($data));
                    return redirect('/login')->
                    with('message', 'La nueva contraseña se ha enviado a su correo electrónico.')
                    ->with('typealert', 'success');
                endif;
            else:
                return back()->withErrors($validator)
                ->with('message', 'El código de activación o el correo electronico son erroneos')
                ->with('typealert', 'danger');
            endif;
        endif;
    }
}
