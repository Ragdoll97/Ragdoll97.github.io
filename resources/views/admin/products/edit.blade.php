@extends('admin.master')

@section('title', 'Editar Productos')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/products/1') }}"><i class="fas fa-box"></i>Productos</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"> <i class="fas fa-pen"></i>Editar Productos</h2>
                    </div>

                    <div class="inside">
                        {!! Form::open(['url' => 'admin/products/' . $p->id . '/edit', 'files' => true]) !!}
                        <div class="row ">
                            <div class="col-md-12">
                                <label for="name">Nombre del Producto:</label>
                                <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-keyboard"></i>
                                        </span>
                                    {!! Form::text('name', $p->name, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="col-md-6">
                                <label for="category">Categoría:</label>
                                <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-folder-open"></i>
                                        </span>
                                    {!! Form::select('category', $cats, $p->category_id, ['class' => 'form-control', 'id' => 'category']) !!}
                                    {!! Form::hidden('subcategory_actual',$p->subcategory_id, ['id' => 'subcategory_actual'])!!}
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
                                <label for="price">Precio:</label>
                                <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    {!! Form::number('price', $p->price, ['class' => 'form-control', 'min' => '0', 'step'
                                    => 'any']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="indiscount">¿En Descuento?:</label>
                                <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-question"></i>
                                        </span>
                                    {!! Form::select('indiscount', ['0' => 'No', '1' => 'Si'], $p->in_discount, ['class' =>
                                    'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="discount">Descuento:</label>
                                <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-percentage"></i>
                                        </span>
                                    {!! Form::number('discount', $p->discount, ['class' => 'form-control', 'min' => '0',
                                    'step' => 'any']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="discount">Fecha Termino Descuento:</label>
                                <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-calendar-alt"></i>
                                        </span>
                                    {!! Form::date('discount_until_date', $p->discount_until_date, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>


                        <div class="row mtop16">
                            <div class="col-md-6">
                                <label for="status">Estado:</label>
                                <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    {!! Form::select('status', ['0' => 'Borrador', '1' => 'Publico'], $p->status,
                                    ['class' => 'form-control']) !!}
                                  
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="code">Codigo de Sistema:</label>
                                <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-barcode"></i>
                                        </span>
                                    {!! Form::text('code', $p->code, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="col-md-12">
                                <label for="title">Imagen destacada:</label>
                                <div class="custom-file">
                                    {!! Form::file('img', ['class' => 'custom-file-input', 'id' => 'customFile', 'accept' =>
                                    'image/*']) !!}
                                    <label class="custom-file-label" for="customFile">Elija una imagen</label>
                                </div>
                            </div>
                      
                        </div>
                        
                        <div class="row mtop16">
                            <div class="col-md-12">
                                <label for="content">Descripción:</label>
                                {!! Form::textarea('content', $p->content, ['class' => 'form-control', 'id' => 'editor'])
                                !!}

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
            <div class="col-md-3">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"> <i class="far fa-image"></i>Imagen Destacada</h2>
                    </div>
                    <div class="inside">
                        <img src="{{ url('/uploads/' . $p->file_path . '/' . $p->image) }}" class="img-fluid">
                    </div>
                </div>
                <div class="panel shadow mtop16">
                    <div class="header">
                        <h2 class="title"><i class="far fa-images"></i>Galeria</h2>
                    </div>
                    <div class="inside product_gallery">
                        @if (KeyValueFromJson(Auth::user()->permissions, 'product_gallery_add'))
                            {!! Form::open(['url' => '/admin/products/' . $p->id . '/gallery/add', 'files' => true, 'id' =>
                            'form_product_gallery']) !!}
                            {!! Form::file('file_image', ['id' => 'product_file_image', 'accept' => 'image/*', 'style' =>
                            'display: none;', 'required']) !!}
                            {!! Form::close() !!}

                            <div class="btn-submit">
                                <a href="#" id='btn_product_file_image'><i class="fas fa-plus"></i></a>
                            </div>
                        @endif

                        <div class="tumbs">
                            @foreach ($p->getGallery as $img)
                                <div class="tumb">
                                    @if (KeyValueFromJson(Auth::user()->permissions, 'product_gallery_add'))
                                        <a href="{{ url('/admin/products/' . $p->id . '/gallery/' . $img->id . '/delete') }}"
                                            data-toogle="tooltip" data-placement="top" title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    @endif
                                    <img src="{{ url('/uploads/' . $img->file_path . '/t_' . $img->file_name) }}">

                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
