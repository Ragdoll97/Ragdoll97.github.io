<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - {{ Config::get('cms.name')}} </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="routeName" content="{{ Route::currentRouteName() }}">
    <meta name="currency" content="{{ Config::get('cms.currency')}}">
    <meta name="auth" content="{{ Auth::check()}}">

    @yield('custom_meta')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/b0d8aefb17.js" crossorigin="anonymous"> </script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <link rel="stylesheet" href="{{ url('/static/css/style.css?v' . time()) }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;1,500&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="{{ url('/static/libs/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ url('/static/js/mdslider.js?v' . time()) }}"></script>
    <script src="{{ url('/static/js/site.js?v' . time()) }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>

<body>

    <div class="loader" id="loader">
        <div class="box">
            <div class="cart">
                <img src="{{url('/static/images/shopping-cart.png')}}" alt="">
            </div>
            <div class="load">
                <div class="spinner-border text-secundary" role="status"></div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg shadow">


        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ url('static/images/logo3.png') }}" class="img-fluid">Educambiental
        </a>
        <button class="navbar-toggler first-button" type="button" data-toggle="collapse" data-target="#navbarSupportedContent20"
        aria-controls="navbarSupportedContent20" aria-expanded="false" aria-label="Toggle navigation">
        <div class="animated-icon1"><span></span><span></span><span></span></div>
      </button>
    

        <div class="collapse navbar-collapse" id="navbarSupportedContent20">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a href="{{ url('/') }}" class="nav-link lk-home"><i class="fas fa-home"></i><span >Inicio</span></a>
                </li>
                <li class="nav-item ">
                    <a href="{{ url('/store') }}" class="nav-link lk-store lk-store_category lk-product_single"><i class="fas fa-store"></i><span>Tienda</span></a>
                </li>
                <li class="nav-item">
                    <a href="#Nosotros"  class="nav-link lk-nosotros"><i class="fas fa-info-circle"></i><span>Sobre Nosotros</span></a>
                </li>
                <li class="nav-item">
                    <a href="#Contacto"  class="nav-link lk-contact"><i class="fas fa-address-book"></i><span>Contactos</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/cart') }}" class="nav-link lk-cart"><i class="fas fa-shopping-cart"></i>
                    </a>
                </li>
                @if (Auth::guest())
                    <li class="nav-item link-acc">
                        <a href="{{ url('/login') }}" class="nav-link btn"><i class="fas fa-sign-in-alt"></i></i>Mi
                            cuenta</a>
                        <a href="{{ url('/register') }}" class="nav-link btn"><i
                                class="far fa-user-circle"></i>Registrarse</a>
                    </li>
                @else
                    <li class="nav-item link-acc2 link-user dropdown">
                        <a href="{{ url('/logout') }}" class="nav-link btn  dropdown-toggle" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if (is_null(Auth::user()->avatar))
                                <img src="{{ url('/static/images/avatar-icon2.png') }}"
                                    class="rounded-circle z-depth-0" height="35">
                            @else
                            <img src="{{ url('/uploads_users/'.Auth::id().'/av_'.Auth::user()->avatar) }}"  
                            class="rounded-circle z-depth-0" height="35">
                            @endif Bienvenido: {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            @if(Auth::user()->role=='1')
                            <li>
                                <a class="dropdown-item" href="{{ url('/admin') }}">
                                    <i class="fas fa-user-cog"></i>Panel Administración
                                </a>
                            </li>
                            
                            @endif
                            <li>
                                <a class="dropdown-item" href="{{ url('/account/favorites') }}">
                                    <i class="fas fa-star"></i>Favoritos
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('/account/edit') }}">
                                    <i class="fas fa-id-card lk-account_edit lk-password_edit lk-account_info_edit lk-account_avatar_edit"></i>Editar Perfil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('/logout') }}">
                                    <i class="fas fa-sign-out-alt"></i>Cerrar Sesión
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>

    </nav>
    @if (Session::has('message'))
        <div class="container-fluid">
            <div class="alert alert-{{ Session::get('typealert') }}" style="display=none;">
                {{ Session::get('message') }}
                @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }} </li>
                        @endforeach
                    </ul>
                @endif
                <script>
                    $('.alert').slideDown();
                    setTimeout(function() {
                        $('.alert').slideUp();
                    }, 10000);

                </script>
            </div>
        </div>
    @endif
    <div class="wrapper">
       <div class="container">
        @section('content')
        @show
       </div>
    </div>
    <div class="footer mtop16">
      <div class="row ">
          <div class="col-md-4 mtop32" >
              <div id="Nosotros" class="title">Sobre Nosotros</div>
              Lorem, ipsum dolor sit amet consectetur adipisicing elit. 
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias, temporibus sapiente facilis consectetur consequatur similique! Obcaecati officia in repudiandae inventore quod odit, provident sed sunt impedit, dolorem explicabo id iusto.
              Qui alias unde voluptas eaque ea doloremque autem repudiandae distinctio rerum reprehenderit, possimus, tempore aliquid sit sequi ad adipisci? Ut, a reprehenderit.
          </div>
          <div class="col-md-4 mtop32" id="Contacto">
              <div class="title">Nuestras Redes Sociales</div>

              <a href="#"><i class="fab fa-twitter"></i></a>
              <a href="#"><i class="fab fa-facebook"></i></a>
              <a href="#"><i class="fab fa-whatsapp"></i></a>
              <a href="#"><i class="fab fa-instagram"></i></a>

          </div>

          <div class="col-md-4 mtop32">
              <div class="title">Nos ubicamos en :</div>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum dolorum inventore omnis, ipsum illum, quam voluptatem corrupti soluta repellendus rerum iusto quibusdam quaerat quia sapiente! Voluptatum temporibus cumque autem nostrum!
          </div>
      </div>
      </div>
</body>

</html>
