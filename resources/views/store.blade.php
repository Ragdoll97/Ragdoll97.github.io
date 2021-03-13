@extends('master')

@section('title', 'Tienda')

@section('content')
<div class="store">
    <div class="row mtop32">
        <div class="col-md-3">
            <div class="categories_list">
                <h2 class="title"><i class="fas fa-stream"></i>Categorias</h2>
                <ul class="shadow-lg">
                    <ul>
                        @foreach ($categories as $category)
                        <li>
                            <a href="{{ url('/store/category/' . $category->id . '/' . $category->slug) }}">
                                <img src="{{ url('/uploads/' . $category->file_path . '/' . $category->icon) }}"
                                alt="">{{$category->name}}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <div class="store_white">
                <section>
                    <h2 class="home_title"><i class="fas fa-store"></i>Últimos productos agregados</h2>
                    <div class="col-md-12">
                        <div class="product_list" id="product_list"></div>
                    </div>
                    <div class="load_more_products">
                        <a href="#" id="load_more_products"><i class="fas fa-spinner"></i>Cargar mas Productos</a>
                    </div>
              </section>
            </div>
        </div>
    </div>
</div>
@endsection
