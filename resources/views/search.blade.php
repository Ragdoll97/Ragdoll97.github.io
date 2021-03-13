@extends('master')

@section('title', 'Búsqueda')

@section('content')
<div class="store">
    <div class="row mtop32">
        <div class="col-md-3">
            <div class="categories_list">
                <h2 class="title"><i class="fas fa-stream"></i>Categorias</h2>
                <ul class="shadow-lg">
                   
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <div class="home_action_bar nomargin shadow">
                <div class="row">
                    <div class="col-md-12">
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

            <div class="store_white mtop32">
                <section>
                    <h2 class="home_title"><i class="fas fa-store"></i>Buscando: {{$query}}</h2>
                    <div class="col-md-12">
                        <div class="product_list" id="product_list">
                            @foreach ($products as $product)
                            <div class="product card shadow">
                                <div class="image">
                                    <div class="overlay">
                                        <div class="btns">
                                            <a href="{{url('/product/'.$product->id.'/'.$product->slug)}}" data-toggle="tooltip" data-placement="top" title="Ver Producto">
                                                <i class="far fa-eye"></i>
                                            </a>
                                            <a href="#" data-toggle="tooltip" data-placement="top" title="Agregar al Carrito">
                                                <i class="fas fa-cart-plus"></i>
                                            </a>
                                            @if(Auth::check())
                                                <a href="#" id="favorite_1_{{ $product->id }}" onclick="add_to_favorites({{ $product->id }}, '1'); return false;" data-toggle="tooltip" data-placement="top" title="Agregar a Favoritos">
                                                    <i class="fas fa-star"></i>
                                                </a>
                                            @else
                                                <a href="#" id="favorite_1_{{ $product->id }}" onclick="Swal.fire('Ops....','Hola invitado, para agregar a favoritos, crea o iniciar sesión con una cuenta.', 'warning');"  data-toggle="tooltip" data-placement="top" title="Agregar a Favoritos">
                                                    <i class="fas fa-star"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <img src="{{url('/uploads/'.$product->file_path.'/t_'.$product->image)}}" alt="">
                                </div>
                                <a href="{{url('/product/'.$product->id.'/'.$product->slug)}}">
                                <div class="title">{{$product->name}}</div>
                                <div class="price">{{Config::get('cms.currency')}}{{$product->price}}</div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
              </section>
            </div>
        </div>
    </div>
</div>
@endsection
