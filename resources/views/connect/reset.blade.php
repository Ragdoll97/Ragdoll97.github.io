@extends('connect.master')

@section('title', 'Recuperar Contraseña')

@section('content')

<div class="box box-login shadow-lg">
    <div class="header shadow">
        <a href="{{url('/')}}">
        <img src="{{url('/static/images/logo3.png')}}" alt="">Educambiental</a>
    </div>
    <div class="inside">
    {!! Form::open(['url' => '/reset'])!!}
    <label for="email">Correo Electronico</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text"><i class="fas fa-envelope"></i>
            </div>
        </div>
    {!! Form::email('email',$email, ['class' => 'form-control', 'required'])!!}
    </div>

    <label for="code" class="mtop16">Código de Recuperación</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text"><i class="fas fa-envelope"></i>
            </div>
        </div>
    {!! Form::number('code',null, ['class' => 'form-control', 'required'])!!}
    </div>

    {!! Form::submit('Ingresar Codigo', ['class' => 'btn btn-success mtop16'])!!}
    {!! Form::close() !!}

    <div class="footer mtop16">
        <a href="{{url('/register')}}">¿No tienes una cuenta?, Registrate</a>
        <a href="{{url('/login')}}">Ingresar</a>

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