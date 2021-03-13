@extends('admin.master')

@section('title', 'Covertura de Envios')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/coverage') }}"><i class="fas fa-shipping-fast"></i>Covertura de Envios</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/coverage/'.$state->id.'/cities') }}"><i class="fas fa-city"></i>Ciudades de: {{$state->name}}</a>
    </li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            @if (KeyValueFromJson(Auth::user()->permissions, 'coverage_city_add'))
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fas fa-plus-square"></i>Agregar Cobertura de envío</h2>
                    </div>
    
                    <div class="inside">
    
                        {!! Form::open(['url' => 'admin/coverage/city/add/']) !!}
                        {!!Form::hidden('state_id' ,$id)!!}
                        <label for="name">Nombre Cobertura:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-keyboard"></i>
                                </span>
                            </div>
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        </div>
                        
                       
                        <label for="name" class="mtop16">Valor de Envío:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-keyboard"></i>
                                </span>
                            </div>
                            {!! Form::number('shipping_value' ,Config::get('cms.shipping_default_value'), ['class' => 'form-control', 'min' => '0', 'step' => 'any' ]) !!}
                        </div>
                        <label for="name" class="mtop16">Días estimados de entrega:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-keyboard"></i>
                                </span>
                            </div>
                            {!! Form::number('days' ,1, ['class' => 'form-control', 'min' => '0', 'step' => 'any' ]) !!}
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
                    <h2 class="title"><i class="fas fa-shipping-fast "></i>Ciudades de: {{$state->name}}</h2>
                </div>

                <div class="inside">
                    <table class="table mtop16">
                        <thead>
                            <tr>
                                <td><strong>Estatus</strong></td>
                                <td><strong>Región</strong></td>
                                <td><strong>Valor del Envío</strong></td>
                                <td><strong>Días estimados de entrega:</strong></td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cities as $city)
                                <tr>
                                    <td>{{getCoverageStatus($city->status)}}</td>
                                    <td>{{$city->name}}</td>
                                    <td>{{config('cms.currency')}}{{number_format($city->price, 0,'.',',')}}</td>
                                    <td>{{$city->days}} Días</td>
                                    <td>
                                        <td> <div class="opts">
                                            @if (KeyValueFromJson(Auth::user()->permissions, 'coverage_edit'))
                                                    <a href="{{ url('/admin/coverage/city/' . $city->id . '/edit') }}"
                                                        data-toogle="tooltip" data-placement="top" title="Editar"><i class="fas fa-pen"></i></a>
                                            @endif
                                            @if (KeyValueFromJson(Auth::user()->permissions, 'coverage_delete'))
                                                    <a href="{{url('/admin/coverage/'.$city->id.'/delete')}}" data-path="admin/coverage" data-action="delete"
                                                        data-object="{{ $city->id }}" data-toogle="tooltip" data-placement="top"
                                                        title="Delete" class="btn-deleted"><i class="fas fa-trash-alt"></i>
                                                    </a>
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