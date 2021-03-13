@extends('admin.master')

@section('title', 'Listado Imagenes')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/sliders') }}"><i class="fas fa-images"></i>Gestión de Imagenes</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/sliders/{id}/edit') }}"><i class="fas fa-pen"></i>Edición de Imagenes</a>
    </li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @if (KeyValueFromJson(Auth::user()->permissions, 'slider_add'))
                    <div class="panel shadow">
                        <div class="header">
                            <h2 class="title"><i class="fas fa-pen"></i>Editar Imagenes</h2>
                        </div>

                        <div class="inside">
                            {!! Form::open(['url' => '/admin/slider/' . $slider->id . '/edit']) !!}
                            <label for="name">Nombre Imagen:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-keyboard"></i>
                                    </span>
                                </div>
                                {!! Form::text('name', $slider->name, ['class' => 'form-control']) !!}
                            </div>

                            <label for="status" class="mtop16">Visible:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                                {!! Form::select('status', ['0' => 'No visible', '1' => 'Visible'], $slider->status,
                                ['class' => 'form-control']) !!}

                            </div>

                            <label for="img" class="mtop16">Imagen:</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="{{ url('/uploads/' . $slider->file_path . '/' . $slider->file_name) }}"
                                        class="img-fluid">
                                </div>
                            </div>

                            <label for="content" class='mtop16'>Contenido:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-keyboard"></i>
                                    </span>
                                </div>
                                {!! Form::textarea('content', html_entity_decode($slider->content), ['class' =>
                                'form-control', 'rows' => '5']) !!}
                            </div>

                            <label for="sorder" class='mtop16'>Orden de presentación:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-sort-numeric-up-alt"></i>
                                    </span>
                                </div>
                                {!! Form::number('sorder', $slider->sorder, ['class' => 'form-control', 'min' => '0']) !!}
                            </div>

                            {!! Form::submit('Guardar', ['class' => 'btn btn-success mtop16']) !!}
                            {!! Form::close() !!}

                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>

@endsection
