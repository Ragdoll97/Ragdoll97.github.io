@extends('master')

@section('title', 'Tienda - '.$category->name)

@section('custom_meta')
<meta name="category_id" content="{{ $category->id}}">
@stop

@section('content')
<div class="store">
    <div class="row mtop32">
        <div class="col-md-3">
            <div class="categories_list">
                <h2 class="title"><i class="fas fa-stream"></i>{{$category->name}} </h2>
                <ul class="shadow-lg">
                    <ul>
                        @if ($category->parent !="0")
                        <li>
                            <a href="{{url('store/category/'.$category->getParent->id.'/'.$category->getParent->slug)}}"><i class="fas fa-arrow-left"></i> Regresar a {{$category->getParent->name}}</a>
                        </li>
                        @endif
                        @if ($category->parent =="0")
                        <li>
                            <a href="{{url('store/')}}">Regresar a la Tienda <i class="fas fa-arrow-left"></i></a>
                        </li>
                        @endif
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
                    <h2 class="home_title"><i class="fas fa-store"></i>{{$category->name}}</h2>
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
