<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
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

    //Función que retorna a la vista home de configuraciones.
    public function getHome(){
        return view('admin.settings.settings');
    }

    //Permite crear el archivo maestro encargado de guardas los datos en configuraciones
    //Como en nombre de la tienda, numero de telefono, moneda utilizada, etc.
    //el archivo se ubica en /config/cms.php
    public function postHome(Request $request){
        if(!file_exists(config_path().'/cms.php')):
            fopen(config_path().'/cms.php', 'w');
        endif;
        $file = fopen(config_path().'/cms.php', 'w');
        fwrite($file, '<?php'.PHP_EOL);
        fwrite($file, 'return ['.PHP_EOL);
        foreach ($request->except(['_token'])as $key => $value):
            if(is_null($value)):
            fwrite($file, '\''.$key.'\'=>\'\','.PHP_EOL);
            else:
            fwrite($file, '\''.$key.'\'=>\''.$value.'\','.PHP_EOL);
            endif;
        endforeach;
        fwrite($file, ']'.PHP_EOL);
        fwrite($file, '?>'.PHP_EOL);
        fclose($file);
        return back()->with('message', "La configuración ha sido actualizada con éxito.")
        ->with('typealert', 'success');

    }
}
