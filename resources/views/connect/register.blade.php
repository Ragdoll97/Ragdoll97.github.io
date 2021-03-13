@extends('connect.master')

@section('title', 'Registrarse')

@section('content')

{{-- Creación del box que contiene el registro--}}
<div class="box box-register shadow-lg">
    <div class="header shadow">
        <a href="{{url('/')}}">
        <img src="{{url('/static/images/logo3.png')}}" alt="">Educambiental</a>
    </div>
{{-- Creación de los campos de texto e inserción de 
    iconos para dar forma al registro de usuarios --}}
    <div class="inside">
    {!! Form::open(['url' => '/register'])!!}
    <label for="name">Nombre</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text"><i class="fas fa-user"></i>
            </div>
        </div>
    {!! Form::text('name',null, ['class' => 'form-control', 'required'])!!}
    </div>
    <label for="lastname" class="mtop16">Apellido</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text"><i class="far fa-user"></i>
            </div>
        </div>
    {!! Form::text('lastname',null, ['class' => 'form-control','required'] )!!}
    </div>
    <label for="email" class="mtop16">Correo Electronico</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text"><i class="fas fa-envelope"></i>
            </div>
        </div>
    {!! Form::email('email',null, ['class' => 'form-control', 'required'])!!}
    </div>

    <label for="password" class="mtop16">Contraseña</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text"><i class="fas fa-key"></i>
            </div>
        </div>
    {!! Form::password('password', ['class' => 'form-control', 'required'])!!}
    </div>

    <label for="cpassword" class="mtop16">Confirmar Contraseña</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text"><i class="fas fa-key"></i>
            </div>
        </div>
    {!! Form::password('cpassword', ['class' => 'form-control', 'required'])!!}
    </div>
    {{-- Inserción del boton y accesos a registo y recuperación de contraseña --}}
    {!! Form::submit('Registrarse', ['class' => 'btn btn-success mtop16'])!!}
    {!! Form::close() !!}

    <div class="footer mtop16 ">
        <a href="{{url('/login')}}">¿Ya tienes cuenta? Inicia Sesion</a>

        @if(Session::has('message'))
        <div class="container">
            <div class="alert alert-{{ Session::get('typealert')}}" style="display=none;">
              {{Session::get('message')}}
              @if ($errors->any())
              <ul>
                  @foreach($errors->all() as $error)
                  <li>{{$error}} </li>
                  @endforeach
              </ul>
              @endif
              <script>
                  $('.alert').slideDown();
                  setTimeout(function(){$('.alert').slideUp();}, 10000);
              </script>
            </div>
        </div>
      @endif
    </div>
    </div>
</div>

@stop