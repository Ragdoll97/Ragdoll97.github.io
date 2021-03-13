@extends('admin.master')

@section('title', 'Categorias')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ url('/admin/categories/{module}') }}" ><i class="fas fa-folder-open"></i>Categorias</a>
</li>
@if ($cat->parent != '0')
<li class="breadcrumb-item">
    <a href="{{ url('/admin/category/'.$cat->parent.'/subs') }}" ><i class="fas fa-folder-open"></i>{{$cat->getParent->name}}</a>
</li>
<li class="breadcrumb-item">
    <a href="{{ url('/admin/category/'.$cat->id.'/edit') }}" ><i class="fas fa-folder-open"></i>Editando Categoria {{$cat->name}}</a>
</li>
@else
<li class="breadcrumb-item">
    <a href="{{ url('/admin/category/'.$cat->id.'/edit') }}" ><i class="fas fa-folder-open"></i>Editando Categoria {{$cat->name}}</a>
</li>
@endif
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"> <i class="fas fa-pen"></i>Editar Categoria</h2>
                </div>
    
                <div class="inside">         
                    {!!Form::open(['url' => 'admin/category/'.$cat ->id.'/edit', 'files' =>'true'])!!}
                    <label for="name">Nombre Categoria:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="fas fa-keyboard"></i>
                            </span>
                        </div>
                        {!! Form::text('name', $cat ->name, ['class' => 'form-control' ])!!}
                    </div>
                    
               
                    <label for="icon" class="mtop16">ícono:</label>
                    <div class="input-group">
                        <div class="custom-file">
                            {!! Form::file('icon', ['class' => 'custom-file-input', 'id' => 'customFile', 'accept' =>
                            'image/*']) !!}
                            <label class="custom-file-label" for="customFile">Elija una imagen</label>
                        </div>
                    </div>
                    <label for="name">Orden:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="fas fa-keyboard"></i>
                            </span>
                        </div>
                        {!! Form::number('order', $cat ->order, ['class' => 'form-control' ])!!}
                    </div>
                    {!!Form::submit('Guardar',['class' => 'btn btn-success mtop16'])!!}
                    {!!Form::close()!!}
                

                </div>
            </div>

            
    
        </div>
        @if(!is_null($cat -> icon))
        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"> <i class="fas fa-pen"></i>Icono</h2>
                </div>
    
                <div class="inside"> 
                    <img src="{{url('/uploads/'.$cat->file_path.'/'.$cat->icon)}}" class="img-fluid">        
                </div>
            </div>
        </div>
        @endif
    </div>

      
</div>
@endsection