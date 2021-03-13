<div class="sidebar shadow">
    <div class="section-top">
        <div class="logo">
            <img src="{{ url('static/images/logo3.png') }}" class="img-fluid">Educambiental
           
          
            <div class="user">

            </div>
        </div>
    </div>
    <div class="main">
        <ul>
            <li class="titlePanel">Panel de Administración</li>
            <li class="background"></li>
            @if(KeyValueFromJson(Auth::user()->permissions, 'dashboard'))
            <li>
                
                <a href="{{url('/admin')}}" class="lk-dashboard"><i class="fas fa-home"></i>Dashboard</a>
            </li>
            @endif
            @if(KeyValueFromJson(Auth::user()->permissions, 'products'))
            <li>
                <a href="{{url('admin/products/1')}}" 
                class="lk-products lk-product_add lk-product_edit lk-product_search lk-product_inventory lk-product_gallery_add">
                <i class="fas fa-box"></i>Productos</a>
            </li>
            @endif
            @if(KeyValueFromJson(Auth::user()->permissions, 'categories'))
            <li>
                <a href="{{url('admin/categories/0')}}" class="lk-categories lk-category_edit lk-category_add lk-category_delete"><i class="fas fa-folder-open"></i>Categorias</a>
            </li>
            @endif
            @if(KeyValueFromJson(Auth::user()->permissions, 'user_list'))
            <li>
                <a href="{{url('admin/users/all')}}" class="lk-user_list lk-user-edit lk-user_permissions"><i class="fas fa-users"></i>Usuarios</a>
            </li>
            @endif
            @if(KeyValueFromJson(Auth::user()->permissions, 'sliders'))
            <li>
                <a href="{{url('admin/sliders')}}" class="lk-sliders lk-slider_add lk-slider_edit lk-slider_deleted "><i class="far fa-images"></i>Gestión de imagenes</a>
            </li>
            @endif
            @if(KeyValueFromJson(Auth::user()->permissions, 'coverage_list'))
            <li>
                <a href="{{url('admin/coverage')}}" class="lk-coverage_list "><i class="fas fa-shipping-fast"></i>Cobertura de Envíos</a>
            </li>
            @endif
            @if(KeyValueFromJson(Auth::user()->permissions, 'settings'))
            <li>
                <a href="{{url('admin/settings')}}" class="lk-settings "><i class="fas fa-cog"></i>Configuraciones</a>
            </li>
            @endif
            @if(KeyValueFromJson(Auth::user()->permissions, 'orders'))
            <li>
                <a href="{{url('admin/orders')}}" class="lk-orders_list "><i class="fas fa-clipboard-list"></i>Ordenes</a>
            </li>
            @endif
            
          

        </ul>
       
    </div>
</div>
