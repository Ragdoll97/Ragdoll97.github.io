@extends('master')

@section('title', 'Carrito de Compras')

@section('content')

   <div class="cart">
       <div class="container mtop32">
           
        @if (count(collect($items)) == "0")
        <div class="no_items">
            <div class="inside">
                <p><i class="fas fa-shopping-bag"></i></p>
                <p><strong>Hola: {{Auth::user()->name}}</strong>, Aún no tienes ningun elemento agregado en tu carrito de Compras,
                    animate a agregar uno de nuestros increibles productos
                </p>
                <p><a href="{{url('/store')}}">Ir a la tienda</a></p>
            </div>
        </div>
        @else
       <div class="items mtop32">
            
                <div class="row">
                    <div class="col-md-9">
                        <div class="panel">
                            <div class="header">
                                <h2 class="title"><i class="fas fa-shopping-cart"></i>Carrito de Compras</h2>
                            </div>
                            <div class="inside">
                                <table class="table table-responsive  table-hover">
                                    <thead>
                                        <tr>
                                            <td></td>
                                            <td width="80"></td>
                                            <td><strong>Producto</strong></td>
                                            <td><strong>Cantidad</strong></td>
                                            <td width="90"><strong>Subtotal</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $item)
                                        <tr>
                                            <td><a href="{{url('/cart/item/'.$item->id.'/delete')}}" class="btn btn-delete"><i class="fas fa-trash-alt"></i></a></td>
                                            <td><img src="{{url('/uploads/'.$item->getProduct->file_path.'/t_'.$item->getProduct->image)}}" class="img-fluid rounded" alt=""></td>
                                            <td>
                                                <a href="{{url('/product/'.$item->getProduct->id.'/'.$item->getProduct->slug)}}">{{$item->label_item}}</a>
                                                <div class="price_discount">
                                                    @if ($item->discount_status == "1")
                                                    <span class="price_initial">{{config('cms.currency').' '.number_format($item->original_price, 0,'.',',')}}
                                                    </span>
                                                    @endif
                                                    <span class="price_unit">{{config('cms.currency').' '.number_format($item->price_unit, 0,'.',',')}}
                                                        @if ($item->discount_status == "1") ({{$item->discount}}% de descuento)
                                                        @endif
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-quantity">
                                                    {!!Form::open(['url' => '/cart/item/'.$item->id.'/update'])!!}
                                                    {!!Form::number('quantity' , $item->quantity, ['min' => '1', 'class' => 'form-control'])!!}
                                                    {!!Form::close()!!}
                                                </div>
                                            </td>
                                            <td><strong>{{config('cms.currency').' '.number_format($item->total, 0,'.',',')}}</strong></td>
                                            
                                        @endforeach
                                        <tr>
                                            <td colspan="3"></td>
                                            <td><strong>SubTotal:</strong></td>
                                            <td><strong>{{config('cms.currency').' '.number_format($order->getSubTotal(), 0,'.',',')}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td><strong>Precio de envío:</strong></td>
                                            <td><strong>{{config('cms.currency').' '.number_format(0, 0,'.',',')}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td><strong>Total de la orden:</strong></td>
                                            <td><strong>{{config('cms.currency').' '.number_format(0, 0,'.',',')}}</strong></td>
                                        </tr>
                                    </tbody>           
                                </table>
                            </div>
                        </div>
                        
                    </div>
                   
                    <div class="col-md-3">
                        {!!Form::open(['url' => '/cart'])!!}
                        <div class="panel">
                            <div class="header">
                                <h2 class="title"><i class="fas fa-map-marker-alt"></i>Dirección de envío</h2>
                            </div>
                            <div class="inside">
                            </div>
                        </div>
                        <div class="panel mtop16">
                            <div class="header">
                                <h2 class="title"><i class="fas fa-envelope-open"></i>Más</h2>
                            </div>
                            <div class="inside">
                                <label for="order_msg">Agregar Comentario</label>
                                {!!Form::textarea('order_msg', null,['class' => 'form-control', 'rows' => 3])!!}
                            </div>
                        </div>
                        <div class="panel mtop16">
                            <div class="inside">
                                {!!Form::submit('Completar Orden', ['class' => 'btn btn-success'])!!}
                            </div>
                        </div>
                        {!!Form::close()!!}
                    </div>
                </div>
            </div>
       </div>
        @endif
       </div>
   </div>

@stop
