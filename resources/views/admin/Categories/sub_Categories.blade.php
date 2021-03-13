@extends('admin.master')

@section('title', 'Categorias')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/categories/[id]') }}"><i class="fas fa-folder-open"></i>Categorias</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/categories/[id]') }}"><i class="fas fa-folder-open"></i>Categoria: {{ $category->name }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/categories/[id]') }}"><i class="fas fa-folder-open"></i>Sub Categorías</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fas fa-folder-open"></i>Sub Categoria de:
                            <strong>{{ $category->name }}</strong></h2>

                        <div class="inside">

                            <table class="table mtop16">
                                <thead>
                                    <tr>
                                        <td width='64'></td>
                                        <td>Nombre</td>
                                        <td width='170'></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($category->getSubCategories as $cat)
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
                                                            data-toogle="tooltip" data-placement="top"
                                                            title="Sub Categorias">
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
