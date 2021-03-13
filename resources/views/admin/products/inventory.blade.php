@extends('admin.master')

@section('title', 'Gestión de Inventario')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/products/1') }}"><i class="fas fa-box"></i>Productos</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/products/'.$product->id.'/edit') }}"><i class="fas fa-boxes"></i>{{$product->name}}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/products/'.$product->id.'/inventory') }}"><i class="fas fa-box"></i>Inventario</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"> <i class="fas fa-pen"></i>Crear Inventario</h2>
                    </div>

                    <div class="inside">
                        {!!Form::open(['url' => '/admin/products/'.$product->id.'/inventory'])!!}
                        <label for="name">Nombre:</label>
                        <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-keyboard"></i>
                                </span>
                            {!! Form::text('name',null, ['class' => 'form-control']) !!}
                        </div>
                        <label for="quantity" class="mtop16">Cantidad en Inventario:</label>
                        <div class="input-group" >
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-keyboard"></i>
                                </span>
                            {!! Form::number('quantity', 1, ['class' => 'form-control', 'min' => '1']) !!}
                        </div>
                        <label for="price"  class="mtop16">Precio:</label>
                        <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-keyboard"></i>
                                </span>
                            {!! Form::number('price', 1, ['class' => 'form-control', 'min' => '1', 'step' => 'any']) !!}
                        </div>
                        <label for="name" class="mtop16">Limite de Inventario:</label>
                        <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-keyboard"></i>
                                </span>
                                {!! Form::select('limited', ['0' => 'Limitada', '1' => 'Ilimitada'],0,
                                ['class' => 'form-control']) !!}
                        </div>
                        <label for="name"  class="mtop16">Inventario Minimo:</label>
                        <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-keyboard"></i>
                                </span>
                            {!! Form::number('minimum',1,['class' => 'form-control', 'min' => '1']) !!}
                        </div>
                        {!! Form::submit('guardar', ['class' => 'btn btn-success mtop16']) !!}
                        {!!Form::close()!!}
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"> <i class="fas fa-pen"></i>Crear Inventario</h2>
                    </div>
                    <div class="inside">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Nombre</td>
                                <td>Existencias</td>
                                <td>Minimo</td>
                                <td>Precio</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product->getInventory as $inventory)
                            <tr>
                                <td>{{$inventory -> id}}</td>
                                <td>{{$inventory -> name}}</td>
                                <td>@if($inventory->limited =="1")
                                    Ilimitada
                                    @else
                                    {{$inventory -> quantity}}
                                    @endif
                                </td><td>@if($inventory->minimum =="1")
                                    Ilimitada
                                    @else
                                    {{$inventory -> minimum}}
                                    @endif
                                </td>
                                <td>{{config('cms.currency')}}{{$inventory -> price}}</td>
                                <td width="180">
                                    <div class="opts">
                                        <a href="{{ url('/admin/product/inventory/' . $inventory->id . '/edit') }}"
                                            data-toogle="tooltip" data-placement="top" title="Editar">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        
                                        <a href="#" data-path="admin/product/inventory" data-action="delete"
                                            data-object="{{ $inventory->id }}" data-toogle="tooltip" data-placement="top"
                                            title="Eliminar" class="btn-deleted">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
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
