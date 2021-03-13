@extends('master')

@section('title', $product->name)
@section('custom_meta')
<meta name="product_id" content="{{ $product->id }}">
@stop
@section('content')

    <div class="product_single shadow-lg">
        <div class="inside">
            <div class="container">
                <div class="row">
                    <!-- Esta sección muestra la imagen destacada del producto y la galeria en caso de tenerla-->
                    <div class="col-md-4 paddingLeft0  shadow-lg">
                        <div class="slick-slider">
                            <div>
                                <a href="{{ url('/uploads/' . $product->file_path . '/' . $product->image) }}"
                                    data-fancybox="gallery">
                                    <img src="{{ url('/uploads/' . $product->file_path . '/' . $product->image) }}"
                                        class="img-fluid">
                                </a>
                            </div>
                            @if (count($product->getGallery) > 0)
                                @foreach ($product->getGallery as $gallery)
                                    <div>
                                        <a href="{{ url('/uploads/' . $gallery->file_path . '/' . $gallery->file_name) }}"
                                            data-fancybox="gallery">
                                            <img src="{{ url('/uploads/' . $gallery->file_path . '/t_' . $gallery->file_name) }}"
                                                class="img-fluid">
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="col-md-8 ">
                        <h2 class="title">{{ $product->name }}</h2>
                        <div class="category">
                            <ul>
                                <li><a href="{{ url('/') }}"><i class="fas fa-home"></i>Inicio</a></li>
                                <li><span class="next"><i class="fas fa-chevron-right"></i></span></li>
                                <li><a href="{{ url('/store') }}"><i class="fas fa-store-alt"></i>Tienda</a></li>
                                <li><span class="next"><i class="fas fa-chevron-right"></i></span></li>
                                <li><a href="{{ url('/store') }}"><i class="fas fa-folder"></i>{{ $product->cat->name }}</a>
                                </li>
                                @if ($product->subcategory_id != '0')
                                    <li><span class="next"><i class="fas fa-chevron-right"></i></span></li>
                                    <li><a href="{{ url('/store') }}"><i
                                                class="fas fa-folder-open"></i>{{ $product->getSubCategory->name }}</a></li>
                                @endif
                            </ul>
                        </div>
                        <div class="add_cart">
                            {!!Form::open(['url' => '/cart/product/'.$product->id.'/add'])!!}
                            {!!Form::hidden('inventory', null, ['id' => 'field_inventory'])!!}
                            {!!Form::hidden('variant', null, ['id' => 'field_variant'])!!}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="variants">
                                        <ul id="inventory">
                                            @foreach ($product->getInventory as $inventory)
                                            <li><a href="#" class="inventory" id="inventory_{{$inventory->id}}" 
                                                data-inventory-id="{{$inventory->id}}">{{$inventory->name}} - <span class="price"> {{config('cms.currency')}}{{number_format($inventory->price, 0,'.',',')}}</span></a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="variants hidden mtop16 btop1 ptop16" id="variants_div">
                                        <ul id="variants"></ul>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="before-quantity">
                                <h5 class="title mtop24">¿Qué cantidad deseas comprar?</h5>
                                <div class="row ">
                                    
                                    <div class="col-md-4">
                                        <div class="quantity">
                                            {!!Form::number('price',$product->price, ['hidden','id' => 'price'])!!}
                                            {!!Form::text('product_id',$product->id, ['hidden','id' => 'product_id'])!!}
                                            {!!Form::number('quantity','1', ['class' => 'form-control', 'min' => '1', 'id' => 'quantity'])!!}
                                          
                                        </div>
                                    </div>
                                    <div class="col-md-4 mtop24">
                                        <button type="submit "  class="btn btn-success"><i class="fas fa-shopping-cart"></i>Añadir al carrito</button>
                                    </div>
                                    <div class="col-md-4 mtop24 col-12">
                                        <a href="#" id="favorite_1_{{ $product->id }}" onclick="add_to_favorites({{ $product->id }}, '1'); return false;" class="btn btn-favorite">
                                            <i class="fas fa-star" >Agregar a Favoritos</i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            {!!Form::close()!!}
                        </div>
                        <div class="content">
                            {!!html_entity_decode($product -> content)!!}
                        </div>

                  
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
   
@endsection
