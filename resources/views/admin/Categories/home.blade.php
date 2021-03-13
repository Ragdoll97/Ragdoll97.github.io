@extends('admin.master')

@section('title', 'Categorias')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/categories/[id]') }}"><i class="fas fa-folder-open"></i>Categorias</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                @if (KeyValueFromJson(Auth::user()->permissions, 'category_add'))
                    <div class="panel shadow">
                        <div class="header">
                            <h2 class="title"><i class="fas fa-plus-square"></i>Agregar Categoria</h2>
                        </div>

                        <div class="inside">

                            {!! Form::open(['url' => 'admin/categories/add/'.$module, 'files' => 'true']) !!}
                            <label for="name">Nombre Categoria:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-keyboard"></i>
                                    </span>
                                </div>
                                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            </div>

                            <label for="module" class="mtop16">Categoria Padre:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-keyboard"></i>
                                    </span>
                                </div>
                                <select name="parent" class="form-control">
                                    <option value="0">Sin sub categoría </option>
                                        @foreach ($cats as $cat)
                                        <option value="{{$cat -> id}}">{{$cat -> name}}
                                        @endforeach
                                </select>

                            </div>
                            <label for="module" class="mtop16">Módulo:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-keyboard"></i>
                                    </span>
                                </div>
                                {!! Form::select('module', getModulesArray(), $module, ['class' => 'form-control', 'disabled']) !!}

                            </div>
                            <label for="icon" class="mtop16">ícono:</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    {!! Form::file('icon', ['class' => 'custom-file-input', 'required', 'id' =>
                                    'customFile', 'accept' => 'image/*']) !!}
                                    <label class="custom-file-label" for="customFile">Elija una imagen</label>
                                </div>
                            </div>
                            {!!Form::submit('Guardar',['class' => 'btn btn-success mtop16'])!!}
                            {!! Form::close() !!}

                        </div>
                    </div>
                @endif


            </div>
            <div class="col-md-9">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fas fa-folder-open"></i>Categorias</h2>
                    </div>

                    <div class="inside">
                        <nav class="nav ">
                            @foreach (getModulesArray() as $m => $k)
                                <a class="nav-link" href="{{ url('/admin/categories/' . $m) }}"><i
                                        class="fas fa-list"></i>{{ $k }}</a>

                            @endforeach
                        </nav>
                        <table class="table mtop16">
                            <thead>
                                <tr>
                                    <td width='64'></td>
                                    <td>Nombre</td>
                                    <td width='170'></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cats as $cat)
                                    <tr>
                                        <td>
                                            @if (!is_null($cat->icon))
                                                <img src="{{ url('/uploads/' . $cat->file_path . '/' . $cat->icon) }}"
                                                    class="img-fluid">
                                            @endif
                                        </td>
                                        <td>{{ $cat->name }}</td>
                                        <td>
                                            <div class="opts">
                                                @if (KeyValueFromJson(Auth::user()->permissions, 'category_edit'))
                                                    <a href="{{ url('/admin/category/' . $cat->id . '/edit') }}"
                                                        data-toogle="tooltip" data-placement="top" title="Editar">
                                                        <i class="fas fa-pen"></i></a>

                                                    <a href="{{ url('/admin/category/' . $cat->id . '/subs') }}"
                                                        data-toogle="tooltip" data-placement="top" title="Sub Categorias">
                                                        <i class="fas fa-list-ul"></i></a>    
                                                @endif
                                                @if (KeyValueFromJson(Auth::user()->permissions, 'category_delete'))
                                                    <a href="{{ url('/admin/category/' . $cat->id . '/delete') }}"
                                                        data-toogle="tooltip" data-placement="top" title="Eliminar">
                                                        <i class="fas fa-trash-alt"></i></a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
