<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
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
    //Función que retorna los usuarios a la vista usuarios, estos se pueden filtrar.
    public function getUsers($status)
    {
        if($status =='all'):
            $users = User::orderBy('id', 'Desc')->paginate(10);
        else:
            $users = User::where('status', $status)->orderBy('id', 'Desc')->paginate(10);
        endif;
        $data =['users' => $users];
        return view('admin.users.home', $data);

    }

    //Permite obtener los datos de un usuario para poder cambiarlos, como bloquearlos o cambiar el tipo de usuario.
    public function getUserEdit($id){
        $u = User::findOrFail($id);
        $data = ['u' => $u];
        return view ('admin.users.user_edit', $data);

    }

    //Cambia los cambios efectuados en el usuario.
    public function postUserEdit (Request $request, $id ){
        $u = User::findOrFail($id);
        $u -> role = $request -> input('user_type');
        if($request ->input('user_type') == "1"):
            if(is_null($u -> permissions)):
                $permissions = [
                    //Gestión modulo dashboard
                    'dashboard' => true
               
                ];
                $permissions = json_encode($permissions);
                $u -> permissions =$permissions;
            endif;
        else:
            $u -> permissions =null;
        endif;
            if ($u->save()):
                if($request->input('user_type')== '1'):
                    return redirect('/admin/users/'.$u->id.'/permissions')->with('message', "El rol del usuario se ha actualizado con exito.")
                ->with('typealert', 'success');
                else:
                    return back()->with('message', "Los permisos del usuario fueron actualizados con éxito.")
                ->with('typealert', 'success');
                endif;
            endif;
      
           
    }
    //Permite cambiar el estado de un usuario a bloqueado o activo.
    public function getUserBanned($id){
        $u = User::findOrfAil($id);
        if($u->status == "100"):
        $u->status = "0";
        $msg = "Usuario Activado.";
        else:
        $u->status = "100";
        $msg = "Usuario suspendido con éxito.";
        endif;

        if ($u->save()) :
            return back()->with('message', $msg)
                ->with('typealert', 'success');
        endif;
    }
    //Función que muestra los permisos del usuario
    public function getUserPermissions($id){
        $u = User::findOrFail($id);
        $data = ['u' => $u];
        return view ('admin.users.user_permissions', $data);
    }
    //La función permite otorgar o quitar permisos a los usuarios.
    public function postUserPermissions(Request $request, $id){
        $u = User::findOrFail($id);
        $u -> permissions =$request ->except('_token');
        if ($u->save()) :
            return back()->with('message', "Los permisos del usuario fueron actualizados con éxito.")
            ->with('typealert', 'success');
        endif;
    }


}

