@extends('admin.master')

@section('title', 'Productos')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/products/1') }}"><i class="fas fa-box"></i>Productos</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="panel shadow">
            <div class="header">
                <h2 class="title"><i class="fas fa-box"></i>Productos</h2>
                <ul>
                    @if (KeyValueFromJson(Auth::user()->permissions, 'product_add'))
                        <li>
                            <a href="{{ url('/admin/products/add') }}">
                                <i class="far fa-plus-square"></i>Agregar Producto
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href=""><i class="fas fa-angle-down"></i>Filtrar</a>
                        <ul class="shadow">
                            <li> <a href="{{ url('/admin/products/1') }}"><i class="fas fa-globe-americas"></i>Públicos</a>
                            </li>
                            <li><a href="{{ url('/admin/products/0') }}"><i class="fas fa-eraser"></i>Borradores</a></li>
                            <li><a href="{{ url('/admin/products/trash') }}"><i class="fas fa-trash"></i>Papelera</a></li>
                            <li><a href="{{ url('/admin/products/all') }}"><i class="fas fa-stream"></i>Todos</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" id="btn_search">
                            <i class="fas fa-search"></i>Buscar
                        </a>
                     
                    </li>
                </ul>
            </div>

            <div class="inside">

                <div class="form_search" id="form_search">
                    {!! Form::open(['url' => '/admin/products/search']) !!}
                    <div class="row">
                        <div class="col-md-4">
                            {!! Form::text('search', null, [
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese su busqueda', 'required'
                            ]) !!}
                        </div>
                        <div class="col-md-4">
                            {!! Form::select('filter', ['0' => 'Nombre del producto', '1' => 'Código'], 0, ['class' =>
                            'form-select']) !!}
                        </div>
                        <div class="col-md-2">
                            {!! Form::select('status', ['0' => 'Borrador', '1' => 'Público'], 0, ['class' =>
                            'form-select']) !!}
                        </div>
                        <div class="col-md-2">
                            {!! Form::submit('Buscar', ['class' => 'btn btn-outline-success']) !!}
                        </div>

                    </div>
                    {!! Form::close() !!}
                </div>
                
                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td></td>
                            <td>Nombre</td>
                            <td>Categoria</td>
                            <td>Precio</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $p)

                            <tr>
                                <td width="50">{{ $p->id }}</td>
                                <td width="64">
                                    <a href="{{ url('/uploads/'. $p->file_path . '/' . $p->image) }}"
                                        data-fancybox="gallery">
                                        <img src="{{ url('/uploads/' . $p->file_path . '/t_' . $p->image) }}" width="70">
                                    </a>
                                </td>
                                <td>{{ $p->name }}
                                    @if ($p->status == '0') <i class="fas fa-eraser"
                                            data-toggle="tooltip" data-placement="top" title="Estado: Borrador"></i>
                                    @endif
                                </td>
                                <td>{{ $p->cat->name }}@if($p->subcategory_id != "0") <i class="fas fa-angle-double-right"></i>{{$p->getSubCategory->name}} @endif</td>
                                <td>{{ $p->price }}</td>
                                <td>
                                    <div class="opts">
                                        @if (KeyValueFromJson(Auth::user()->permissions, 'product_edit'))
                                            @if (is_null($p->deleted_at))
                                                <a href="{{ url('/admin/products/' . $p->id . '/edit') }}"
                                                    data-toogle="tooltip" data-placement="top" title="Editar">
                                                    <i class="fas fa-pen"></i></a>
                                            @endif
                                        @endif
                                        @if (KeyValueFromJson(Auth::user()->permissions, 'product_delete'))
                                            @if (is_null($p->deleted_at))
                                                <a href="#" data-path="admin/products" data-action="delete"
                                                    data-object="{{ $p->id }}" data-toogle="tooltip" data-placement="top"
                                                    title="Eliminar" class="btn-deleted"><i class="fas fa-trash-alt"></i>
                                                </a>
                                            @else
                                                <a href="#" data-path="admin/products" data-action="restore"
                                                    data-object="{{ $p->id }}" data-toogle="tooltip" data-placement="top"
                                                    title="Restaurar" class="btn-deleted"><i
                                                        class="fas fa-trash-restore"></i>
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

@endsection
