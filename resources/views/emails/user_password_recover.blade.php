@extends ('emails.master')
@section('content')

<p>Hola: <strong>{{$name}}</strong></p>
<p>Este es un correo electrónico que le ayudará a recuperar la contraseña,
     para que pueda ingresar nuevamente a nuestro sitio web.</p>
<p>Haga click en el siguiente botón e ingrese el siguiente código:</p><h2>{{$code}}</h2>
<p><a href="{{url('/reset?email='.$email)}}"style="
display: inline-block; 
background-color: #0D46F9;
color: #fff;
padding: 8px;
border-radius:4px
text-decoration: none;">Cambiar Contraseña</a></p>
<p>Si el botón anterior no funciona, ingrese la siguiente url en la barra de búsqueda de su navegador.</p>
<p>{{ url('/reset?email='.$email) }}</p>
@stop