<?php 

function getModulesArray(){
    $a =[
        '0' => 'Productos',
        '1' => 'Blogs',
        '2' => 'Libros'
    ];
    return $a;
}

function getRoleUserArray($mode, $id){
    $roles =[
        '0' => 'Cliente',
        '1' => 'Administrador'
    ];
    if(!is_null($mode)):
        return $roles;
    else:
        return $roles[$id];
    endif;

}

function getUserStatusArray($mode, $id){
    $status =[
        '0' => 'Usuario Registrado',
        '1' => 'Usuario Verificado',
        '100' => 'Usuario Baneado'
    ];
    if(!is_null($mode)):
        return $status;
    else:
        return $status[$id];

    endif;
    
}

function KeyValueFromJson($json, $key){
    if($json ==null):
    return null;
    else:
        $json = $json;
        $json = json_decode($json, true);
        if(array_key_exists($key, $json)):
            return $json[$key];
        else:
            return null;
        endif;
    endif;


}

function user_permissions(){
    $p = [
        'dashboard' => [
            'icon' => '<i class="fas fa-home"></i>',
            'title' => 'Modulo de Dashboard',
            'keys' => [
                'dashboard' => 'Puede ver el Dashboard',
                'dashboard_small_stats' => 'Puede ver las estadisticas',
                'dashboard_factured_today' => 'Puede ver la facturación',
                'dashboard_sell_today' => 'Puede ver la venta del día'
            ]
            ],

        'products' => [
            'icon' => '<i class="fas fa-box"></i>',
            'title' => 'Modulo de Productos',
            'keys' => [
                'products' => 'Puede ver el listado de productos',
                'product_add' => 'Puede agregar nuevos productos',
                'product_edit' => 'Puede editar productos',
                'product_inventory' => 'Puede gestionar el inventario de productos',
                'product_search' => 'Puede buscar producto',
                'product_delete' => 'Puede eliminar productos',
                'product_gallery_add' => 'Puede agregar imagenes a los productos',
                'product_gallery_delete' => 'Puede eliminar imagenes de los productos',
            ]
            ],
        'categories' => [
            'icon' => '<i class="fas fa-folder-open"></i>',
            'title' => 'Modulo de Categorias',
            'keys' => [
                'categories' => 'Puede ver las categorias',
                'category_edit' => 'Puede editar categorias',
                'category_delete' => 'Puede eliminar categorias',
                'category_add' => 'Puede agregar nuevas categorias',
            ]
            ],
        'users' => [
            'icon' => '<i class="fas fa-users"></i>',
            'title' => 'Modulo de Usuarios',
            'keys' => [
                'user_list' => 'Puede ver la lista de usuarios ',
                'user_edit' => 'Puede editar los usuarios',
                'user_permissions' => 'Puede gestionar los permisos de usuarios',
                'user_banned' => 'Puede bloquear y/o desbloquear usuarios',

            ]
            ],
        'sliders' => [
            'icon' => '<i class="far fa-images"></i>',
            'title' => 'Modulo de Gestión de Imagenes',
            'keys' => [
                'sliders' => 'Puede ver el listado de imagenes',
                'slider_add' => 'Puede agregar imagenes en el carrusel',
                'slider_edit' => 'Puede editar las imagenes',
                'slider_delete' => 'Puede eliminar las imagenes'

        ]
            ],
        'settings' => [
            'icon' => '<i class="fas fa-cog"></i>',
            'title' => 'Modulo de Configuraciones',
            'keys' => [
                'settings' => 'Puede ver la lista de configuración '

        ]
            ],
        'coverage' => [
            'icon' => '<i class="fas fa-shipping-fast"></i>',
            'title' => 'Cobertura de Envíos',
            'keys' => [
                'coverage_list' => 'Puede ver la lista covertura de envíos ',
                'coverage_add' => 'Puede Agregar Nuevas Coberturas de Envíos',
                'coverage_edit' => 'Puede Editar las Coberturas de Envíos',
                'coverage_delete' => 'Puede Eliminar las Coberturas de Envíos',
                'coverage_city' => 'Puede gestionar las ciudades ',
                'coverage_city_add' => 'Puede Agregar Ciudades',
                'coverage_city_edit' => 'Puede Editar Ciudades'
        ]
            ],
            
        'orders' => [
            'icon' => '<i class="fas fa-clipboard-list"></i>',
            'title' => 'Modulo de Ordenes',
            'keys' => [
                'orders' => 'Puede ver la lista de ordenes '
            ]
        ]


    ];
    return $p;


}

function getUserYears(){
    $year = date('Y');
    $year_min = $year - 18;
    $year_old = $year_min - 62;
    return [$year_min, $year_old];
}

function getMonths($mode, $key){
    $m = [
        1 =>'Enero',
        2 =>'Febrero',
        3 =>'Marzo',
        4 =>'Abril',
        5 =>'Mayo',
        6 =>'Junio',
        7 =>'Julio',
        8 =>'Agosto',
        9 =>'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Septiembre',
    ];
    if($mode == 'list'){
        return $m;
    }else{
        return $m[$key];
    }
}

function getShippingMethod($method = null){
    $status =[
        '0' => 'Gratis',
        '1' => 'Valor Fijo',
        '2' => 'Precio Variable por Ubicación',
        '3' => 'Valor Fijo por Producto'
    ];
    if(is_null($method)):
        return $status;
    else:
        return $status[$method];

    endif;
}
function getCoverageType($typeC = null){
    $status =[
        '0' => 'Región',
        '1' => 'Ciudad' 
    ];
    if(is_null($typeC)):
        return $status;
    else:
        return $status[$typeC];

    endif;
}

function getCoverageStatus($status = null){
    $list =[
        '0' => 'No Activo',
        '1' => 'Activo' 
    ];
    if(is_null($status)):
        return $list;
    else:
        return $list[$status];

    endif;
}


