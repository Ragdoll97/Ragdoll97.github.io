@extends('admin.master')

@section('title', 'Agregar Productos')

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ url('/admin/products/add') }}"><i class="fas fa-box"></i>Productos</a>
    </li>

    <li class="breadcrumb-item">
        <a href="{{ url('/admin/products/add') }}"><i class="fas fa-plus-square"></i>Agregar Productos</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="panel shadow">
            <div class="header">
                <h2 class="title"><i class="fas fa-plus-square"></i>Agregar Productos</h2>
            </div>

            <div class="inside">
                {!! Form::open(['url' => 'admin/products/add', 'files' => true]) !!}
                <div class="row ">
                    <div class="col-md-12">
                        <label for="name">Nombre del Producto:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-keyboard"></i>
                                </span>
                            </div>
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="category">Categoria:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-folder-open"></i>
                                </span>
                            </div>
                            {!! Form::select('category', $cats, 0, ['class' => 'form-control', 'id' => 'category']) !!}
                            {!!Form::hidden('subcategory_actual',0, ['id' => 'subcategory_actual'])!!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="category">Sub-Categoría:</label>
                        <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-folder-open"></i>
                                </span>
                            {!! Form::select('subcategory',[], null, ['class' => 'form-control', 'id' => 'subcategory', 'required']) !!}
                        </div>
                    </div>

                   
                </div>

                <div class="row mtop16">
                    <div class="col-md-3">
                        <label for="indiscount">¿En Descuento?:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-question"></i>
                                </span>
                            </div>
                            {!! Form::select('indiscount', ['0' => 'No', '1' => 'Si'], 0, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="discount">Descuento:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-percentage"></i>
                                </span>
                            </div>
                            {!! Form::number('discount', 0, ['class' => 'form-control', 'min' => '0', 'step' => 'any'])
                            !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="code">Codigo de Sistema:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-barcode"></i>
                                </span>
                            </div>
                            {!! Form::text('code', 0, ['class' => 'form-control'])
                            !!}
                        </div>
                    </div>
                       
                    <div class="col-md-3">
                        <label for="title">Imagen Destacada:</label>
                        <div class="input-group">
                            <div class="custom-file">
                                {!! Form::file('img', ['class' => 'custom-file-input', 'id' => 'customFile', 'accept' =>
                                'image/*']) !!}
                                <label class="custom-file-label" for="customFile">Elija una imagen</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mtop16">
                    <div class="col-md-12">
                        <label for="content">Descripción:</label>
                        {!! Form::textarea('content', null, ['class' => 'form-control', 'id' => 'editor']) !!}

                    </div>
                </div>

                <div class="row mtop16">
                    <div class="col md 12">
                        {!! Form::submit('guardar', ['class' => 'btn btn-success']) !!}
                    </div>
                </div>

                {!! Form::close() !!}


            </div>
        </div>

    </div>

@endsection
