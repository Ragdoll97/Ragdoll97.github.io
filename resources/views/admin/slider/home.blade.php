@extends('admin.master')

@section('title', 'Listado Imagenes')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/sliders') }}"><i class="fas fa-images"></i>Gestión de Imagenes</a>
    </li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                @if (KeyValueFromJson(Auth::user()->permissions, 'slider_add'))
                    <div class="panel shadow">
                        <div class="header">
                            <h2 class="title"><i class="fas fa-plus-square"></i>Agregar Imagenes</h2>
                        </div>

                        <div class="inside">
                            {!! Form::open(['url' => 'admin/slider/add', 'files' => 'true']) !!}
                            <label for="name">Nombre Imagen:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-keyboard"></i>
                                    </span>
                                </div>
                                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            </div>

                            <label for="status" class="mtop16">Visible:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                                {!! Form::select('status', ['0' => 'No visible', '1' => 'Visible'], 1, ['class' =>
                                'form-control']) !!}

                            </div>

                            <label for="img" class="mtop16">Imagen:</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    {!! Form::file('img', ['class' => 'custom-file-input', 'id' => 'customFile', 'accept' =>
                                    'image/*']) !!}
                                    
                                    <label class="custom-file-label" for="customFile">Elija una imagen</label>
                                </div>
                            </div>

                            <label for="content" class='mtop16'>Contenido:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-keyboard"></i>
                                    </span>
                                </div>
                                {!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => '5']) !!}
                            </div>

                            <label for="sorder" class='mtop16'>Orden de presentación:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-sort-numeric-up-alt"></i>
                                    </span>
                                </div>
                                {!! Form::number('sorder', 0, ['class' => 'form-control', 'min' => '0']) !!}
                            </div>

                            {!! Form::submit('Guardar', ['class' => 'btn btn-success mtop16']) !!}
                            {!! Form::close() !!}

                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-9">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fas fa-images"></i>Imagenes</h2>
                    </div>

                    <div class="inside">
                        <div class="table">
                            <table>
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Contenido</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sliders as $slider)
                                        <tr>
                                            <td width="25%">
                                                <a href="{{ url('/uploads/' . $slider->file_path . '/' . $slider->file_name) }}"
                                                    data-fancybox="gallery">
                                                    <img width="180"
                                                        src="{{ url('/uploads/' . $slider->file_path . '/' . $slider->file_name) }}"
                                                        class="img-fluid">
                                                </a>
                                            </td>
                                            <td >
                                                <div class="slider_content">
                                                    <h1>{{ $slider->name }}</h1> 
                                                    {!! html_entity_decode($slider->content) !!}
                                                </div>
                                            </td>

                                            <td width="20%">
                                                <div class="opts">
                                                    @if (KeyValueFromJson(Auth::user()->permissions, 'slider_edit'))
                                                        @if (is_null($slider->deleted_at))
                                                            <a href="{{ url('/admin/slider/' . $slider->id . '/edit') }}"
                                                                data-toogle="tooltip" data-placement="top" title="Editar">
                                                                <i class="fas fa-pen"></i></a>
                                                        @endif
                                                    @endif
                                                    @if (KeyValueFromJson(Auth::user()->permissions, 'slider_delete'))
                                                        @if (is_null($slider->deleted_at))
                                                            <a href="#" data-path="admin/slider" data-action="deleted"
                                                                data-object="{{ $slider->id }}" data-toogle="tooltip"
                                                                data-placement="top" title="Eliminar" class="btn-deleted"><i
                                                                    class="fas fa-trash-alt"></i>
                                                            </a>
                                                        @endif
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
    </div>

@endsection
