@extends('admin.master')
@section('title', 'Permisos de Usuarios')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/users/all') }}"><i class="fas fa-users"></i>Usuarios</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/users/all') }}"><i class="fas fa-user-cog"></i>Permisos de Usuario : {{ $u->name }}</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page_user">
            <form action="{{ url('/admin/users/' . $u->id . '/permissions') }}" method="POST">
                @csrf
                <div class="row">
                    @foreach (user_permissions() as $key => $value)
                        <div class="col-md-4 d-flex mb16">
                            <div class="panel shadow">
                                <div class="header">
                                    <h2 class="title">{!! $value['icon'] !!}{{ $value['title'] }}</h2>
                                </div>
                                <div class="inside">
                                    @foreach ($value['keys'] as $k => $v)
                                        <div class="form-check">
                                            <input type="checkbox" value="true" name={{ $k }} @if (KeyValueFromJson($u->permissions, $k)) checked
                                    @endif>
                                   
                                    <label for="dashboard">{{ $v }}</label>
                                </div>
                    @endforeach
                </div>
        </div>
    </div>
    @endforeach
    </div>

    <div class="row mtop16">
        <div class="col-md-12">
            <div class="panel shadow">
                <div class="inside">
                    <input type="submit" value="Guardar" class="btn btn-primary">
                    
                    <input type="checkbox"  name="select-all" id="select-all" />  Selecionar Todo
                   
                </div>
            </div>
        </div>
    </div>
    </form>
    </div>
    </div>

@endsection
