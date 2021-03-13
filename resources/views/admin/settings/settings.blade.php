@extends('admin.master')

@section('title', 'Configuracion')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/products/1') }}"><i class="fas fa-cog"></i>Configuraciones</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="panel shadow">
            <div class="header">
                <h2 class="title"><i class="fas fa-cog"></i>Configuraciones</h2>
            </div>

            <div class="inside">
                {!! Form::open(['url' => '/admin/settings']) !!}
                <div class="row">
                    <div class="col-md-4">
                        <label for="name">Nombre de la Tienda:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-keyboard"></i>
                                </span>
                            </div>
                            {!! Form::text('name', Config::get('cms.name'), ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="company_phone">Número de Teléfono:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-phone"></i>
                                </span>
                            </div>
                            {!! Form::text('company_phone', Config::get('cms.company_phone'), ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="currency">Moneda:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>
                            </div>
                            {!! Form::text('currency', Config::get('cms.currency'), ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    
                </div>
                <div class="row mtop16">
                    <div class="col-md-4">
                        <label for="map">Ubicación:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>
                            </div>
                            {!! Form::text('map', Config::get('cms.map'), ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="maintance_mode">¿En Mantenimiento?:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-question"></i>
                                </span>
                            </div>
                            {!! Form::select('maintance_mode', ['0' => 'Desactivado', '1' => 'Activo'], Config::get('cms.maintance_mode'), ['class' => 'form-control']) !!}
                        </div>
                    </div>

                </div>

                <hr>

                <div class="row mtop16 ">
                    <div class="col-md-4">
                        <label for="products_page">Productos a mostrar en cada pagina:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-boxes"></i>
                                </span>
                            </div>
                            {!! Form::number('products_page', Config::get('cms.products_page'), ['class' => 'form-control', 'min' => '1', 'required']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="products_page_random">Productos a mostrar en cada pagina (Random):</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-random"></i>
                                </span>
                            </div>
                            {!! Form::number('products_page_random', Config::get('cms.products_page_random'), ['class' => 'form-control', 'min' => '1', 'required']) !!}
                        </div>
                    </div>
                </div>
                
                <hr>

                <div class="row mtop16">
                    <div class="col-md-4">
                        <label for="products_page">Configuración precio de envío:</label>
                        <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-boxes"></i>
                                </span>
                            {!! Form::select('shipping_method', getShippingMethod() ,Config::get('cms.shipping_method'), ['class' => 'form-control' ]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="products_page">Valor por defecto del producto:</label>
                        <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-boxes"></i>
                                </span>
                            {!! Form::number('shipping_default_value' ,Config::get('cms.shipping_default_value'), ['class' => 'form-control', 'min' => '1', 'required' ]) !!}
                        </div>
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
