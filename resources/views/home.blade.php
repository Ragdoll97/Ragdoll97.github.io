@extends('master')

@section('title', 'inicio')

@section('content')
    <section>
        <div class="home_action_bar shadow">
            <div class="row">
                <div class="col-md-3">
                    <div class="categories">
                        <a href="#"><i class="fas fa-stream"></i>Categorias</a>
                        <ul class="shadow">
                            @foreach ($categories as $category)
                                <li>
                                    <a href="{{ url('/categories/' . $category->id . '/' . $category->slug) }}">
                                        <img src="{{ url('/uploads/' . $category->file_path . '/' . $category->icon) }}"
                                            alt="">
                                        {{ $category->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
                    {!! Form::open(['url' => '/search']) !!}
                    <div class="input-group">
                        <i class="fas fa-search"></i></span>
                        {!! Form::text('search_query', null, ['class' => 'form-control', 'placeholder' => '¿Buscas Algo?',
                        'required']) !!}
                        <button class="btn " type="button" id="button-addon2">Buscar</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
    <section>
      @include('components/slider_home2')
    </section>
    <section>
        <div class="container-fluid Destacado shadow mtop16">
            <div class="titulo">Productos Destacados</div>
        </div>
        
        <div class="col-md-12">
            <div class="product_list" id="product_list"></div>
        </div>
        <div class="load_more_products">
            <a href="#" id="load_more_products"><i class="fas fa-spinner"></i>Cargar mas Productos</a>
        </div>
    </section>
@endsection
