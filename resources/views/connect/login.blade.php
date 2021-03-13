@extends('connect.master')

@section('title', 'Login')

@section('content')

{{-- Creación del box que contiene el login--}}
<div class="box box-login shadow-lg">
    <div class="header shadow">
        <a href="{{url('/')}}">
        <img src="{{url('/static/images/logo3.png')}}" alt="">Educambiental</a>
    </div>
    
{{-- Creación de los campos de texto e inserción de iconos para dar forma al login --}}
    <div class="inside">
    {!! Form::open(['url' => '/login'])!!}
    <label for="email">Correo Electronico</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text"><i class="fas fa-envelope"></i>
            </div>
        </div>
    {!! Form::email('email',null, ['class' => 'form-control', 'required'])!!}
    </div>

    <label for="email" class="mtop16">Contraseña</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text"><i class="fas fa-key"></i>
            </div>
        </div>
    {!! Form::password('password', ['class' => 'form-control', 'required'])!!}
    </div>
    {{-- Inserción del boton y accesos a registo y recuperación de contraseña --}}
    {!! Form::submit('ingresar', ['class' => 'btn btn-success mtop16'])!!}
    {!! Form::close() !!}

    <div class="footer mtop16">
        <a href="{{url('/register')}}">Registrate</a>
        <a href="{{url('/recover')}}">Recuperar Contraseña</a>

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