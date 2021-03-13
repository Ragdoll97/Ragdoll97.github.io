<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">
    <title>@yield('title') - {{ Config::get('cms.name')}} </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="routeName" content="{{ Route::currentRouteName() }}">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/b0d8aefb17.js" crossorigin="anonymous"> </script>
    <link rel="stylesheet" href="{{ url('/static/css/admin.css?v' . time()) }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;1,500&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script src="{{ url('/static/libs/ckeditor/ckeditor.js') }}"></script>

    <script src="{{ url('/static/js/admin.js?v' . time()) }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
      $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

    </script>
</head>

<body>
   
    <div class="wrapper">
        <div class="col1">@include('admin.sidebar')</div>
        <div class="col2">
            <nav class="navbar navbar-expand-lg shadow">
                <button class="navbar-toggler first-button" type="button" data-toggle="collapse" data-target="#navbarSupportedContent20"
                aria-controls="navbarSupportedContent20" aria-expanded="false" aria-label="Toggle navigation">
                <div class="animated-icon1"><span></span><span></span><span></span></div>
              </button>
            
                <div class="collapse navbar-collapse" id="navbarSupportedContent20">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a href="{{ url('/admin') }}" class="nav-link"><i class="fas fa-home"></i>Dashboard</a>
                        </li>
                    </ul>
                    <li class="nav-item link-acc2 link-user dropdown dropdown-list" >
                        <a href="{{ url('/logout') }}" class="nav-link btn  dropdown-toggle" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">{{ Auth::user()->name }} {{ Auth::user()->lastname }}
                            @if (is_null(Auth::user()->avatar))
                                <img src="{{ url('/static/images/avatar-icon2.png') }}"
                                    class="rounded-circle z-depth-0" height="40">
                            @else
                                <img src="{{ url('uploads_users/'.Auth::id().'/av_'.Auth::user()->avatar) }}"
                                    class="rounded-circle " >
                            @endif 
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink"  id="navbarSupportedContent20">
                            @if (Auth::user()->role == '1')
                                <li>
                                    <a class="dropdown-item" href="{{ url('/admin') }}">
                                        <i class="fas fa-user-cog"></i>Panel Administración
                                    </a>
                                </li>

                            @endif
                            <li>
                                <a class="dropdown-item" href="{{ url('/') }}">
                                    <i class="fas fa-home"></i>Ir a la Tienda
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('/account/edit') }}">
                                    <i class="fas fa-id-card"></i>Editar Perfil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('/logout') }}">
                                    <i class="fas fa-sign-out-alt"></i>Cerrar Sesión
                                </a>
                            </li>
                        </ul>
                    </li>

                </div>
                
            </nav>




            <div class="page">
                <div class="container-fluid">
                    <nav aria-label="breadcrumb shadow">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/admin') }}"><i class="fas fa-home"></i>Dashboard</a>
                            </li>
                            @section('breadcrumb')
                            @show
                        </ol>
                    </nav>
                </div>

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
                @section('content')
                @show
            </div>
        </div>
</body>

</html>
