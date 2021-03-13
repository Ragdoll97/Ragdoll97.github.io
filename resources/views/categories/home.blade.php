@extends('master')

@section('title', $categories->name)

@section('content')
    <div class="section">

<div class="row"></div>
        @foreach ($products as $prod)
            @if ($categories->name == $prod->categories)
                <div class="col-md-3   categories_productos mtop32" >
                    <div class="card shadow-lg" >
                        <div class="product" >
                            <tr >
                                <img src="{{ url('/uploads/' . $prod->path . '/t_' . $prod->image) }}" width="70">
                                <div class="title"><td >{{ $prod->name }}</td></div>
                                <br>
                                <td  >{{config('cms.currency')}}{{ $prod->price }} </td>
                                <hr>

                                <a href="{{ url('/product/' . $prod->prod_id . '/' . $prod->slug) }}" data-toggle="tooltip"
                                    data-placement="top" title="Ver Producto">
                                    <i class="far fa-eye"></i>
                                </a>
                               
                            </tr>
                            
                        </div>
                    </div>
                </div>
                
            @endif
        @endforeach

    </div>
@endsection
