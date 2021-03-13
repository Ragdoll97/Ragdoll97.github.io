@extends('admin.master')
@section('title', 'Usuarios')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/users/all') }}"><i class="fas fa-users"></i>Usuarios</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="panel shadow">
            <div class="header">
                <h2 class="title"><i class="fas fa-users"></i>Usuarios</h2>
            </div>
            <div class="inside">
                <div class="row">
                    <div class="col-md-2 offset-md-10">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width :100%;">
                                <i class="fas fa-filter"></i>Filtrar
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="{{ url('admin/users/all') }}"><i
                                        class="fas fa-stream"></i>Todos</a>
                                <a class="dropdown-item" href="{{ url('admin/users/0') }}"><i
                                        class="fas fa-user-check"></i>Verificados</a>
                                <a class="dropdown-item" href="{{ url('admin/users/1') }}"><i
                                        class="fas fa-user-alt-slash"></i>No Verificados</a>
                                <a class="dropdown-item" href="{{ url('admin/users/100') }}"><i
                                        class="fas fa-user-lock"></i>Suspendidos</a>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table mtop16">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td width="70"></td>
                            <td>Nombre</td>
                            <td>Apellido</td>
                            <td>Correo electronico</td>
                            <td>Rol</td>
                            <td>Estado</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    @if (is_null($user->avatar))
                                    <img src="{{ url('/static/images/avatar-icon2.png') }}"
                                        class="rounded-circle  img-fluid " height="40">
                                @else
                                    <img src="{{ url('uploads_users/'.$user->id.'/av_'.$user->avatar) }}"
                                        class="rounded-circle  img-fluid "height="40" >
                                @endif 

                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->lastname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ getRoleUserArray(null, $user->role) }}</td>
                                <td>{{ getUserStatusArray(null, $user->status) }}</td>
                                <td>
                                    <div class="opts">
                                        @if (KeyValueFromJson(Auth::user()->permissions, 'user_edit'))
                                            <a href="{{ url('/admin/users/' . $user->id . '/edit') }}" data-toogle="tooltip"
                                                data-placement="top" title="Editar"><i class="fas fa-pen"></i>
                                            </a>
                                        @endif
                                        @if (KeyValueFromJson(Auth::user()->permissions, 'user_permissions'))

                                            <a href="{{ url('/admin/users/' . $user->id . '/permissions') }}"
                                                data-toogle="tooltip" data-placement="top" title="Permisos de usuario"><i
                                                    class="fas fa-user-cog"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="7">{!! $users->render() !!}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
