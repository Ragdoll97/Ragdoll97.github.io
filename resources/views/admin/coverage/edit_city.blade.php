@extends('admin.master')

@section('title', 'Covertura de Envios')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/coverage') }}"><i class="fas fa-shipping-fast"></i>Covertura de Envios</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/coverage/'.$coverage->state_id.'/cities') }}"><i class="fas fa-city"></i>Región : {{$coverage->getState->name}}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/coverage/city/'.$coverage->id.'/edit') }}"><i class="fas fa-pen"></i>Editando : {{$coverage->name}}</a>
    </li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            @if (KeyValueFromJson(Auth::user()->permissions, 'coverage_city_edit'))
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fas fa-pen"></i>Editar Ciudad de envío</h2>
                    </div>
    
                    <div class="inside">
    
                        {!! Form::open(['url' => 'admin/coverage/city/'.$coverage->id.'/edit']) !!}
                        <label for="name">Nombre Cobertura:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-keyboard"></i>
                                </span>
                            </div>
                            {!! Form::text('name', $coverage->name, ['class' => 'form-control']) !!}
                        </div>
                        
                        <label for="name" class="mtop16">Estatus:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-keyboard"></i>
                                </span>
                            </div>
                            {!! Form::select('status', getCoverageStatus(), $coverage->status, ['class' => 'form-control']) !!}
                        </div>
                        <label for="name" class="mtop16">Valor de Envío:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-keyboard"></i>
                                </span>
                            </div>
                            {!! Form::number('shipping_value' ,$coverage->price, ['class' => 'form-control', 'min' => '0', 'step' => 'any' ]) !!}
                        </div>
                        <label for="name" class="mtop16">Días estimados de entrega:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-keyboard"></i>
                                </span>
                            </div>
                            {!! Form::number('days' ,$coverage->days, ['class' => 'form-control', 'min' => '0', 'step' => 'any' ]) !!}
                        </div>
    
                      
                        
                        {!!Form::submit('Guardar',['class' => 'btn btn-success mtop16'])!!}
                        {!! Form::close() !!}
    
                    </div>
                </div>
            @endif
        </div>
        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title" ><i class="fas fa-shipping-fast"></i>Información General</h2>
                </div>
                <div class="inside">
                    @if ($coverage->ctype == "1")
                        <p><strong>Tipo: </strong>Ciudad</p>
                        <p><strong>Región: </strong>{{$coverage->getState->name}}</p>
                    @endif
                </div>
            </div>
        </div>
       
    </div>
</div>

@endsection