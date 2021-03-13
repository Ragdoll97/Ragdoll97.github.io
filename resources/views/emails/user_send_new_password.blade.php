@extends ('emails.master')
@section('content')

<p>Hola: <strong>{{$name}}</strong></p>
<p>Este es un correo electrónico que le entregará su nueva contraseña 
   para que pueda ingresar nuevamente a nuestro sitio web.</p>
<p><h2>{{$password}}</h2></p>
<p>Para iniciar sesión haga click en el siguiente botón</p>
<p><a href="{{url('/login')}}"style="
display: inline-block; 
background-color: #0D46F9;
color: #fff;
padding: 8px;
border-radius:4px
text-decoration: none;">Iniciar Sesión</a></p>
<p>Si el botón anterior no funciona, ingrese la siguiente url en la barra de búsqueda de su navegador.</p>
<p>{{ url('/login') }}</p>
@stop