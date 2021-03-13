@extends('admin.master')

@section('title', 'dashboard')

@section('content')
<div class="container-fluid">
    @if(KeyValueFromJson(Auth::user()->permissions, 'dashboard_small_stats'))
    <div class="panel shadow">
        <div class="header">
            <h2 class="title"><i class="fas fa-chart-bar"></i>Estaditicas</h2>
        </div>
    </div>
    
    <div class="row mtop16">
        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fas fa-users"></i>Usuarios registrados</h2>
                </div>
                <div class="inside">
                    <div class="big_count">{{$users}}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fas fa-boxes"></i>Productos registrados</h2>
                </div>
                <div class="inside">
                    <div class="big_count">{{$products}}</div>
                </div>
            </div>
        </div>
        @if(KeyValueFromJson(Auth::user()->permissions, 'dashboard_factured_today'))
        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fas fa-shopping-basket"></i>Ordenes Hoy</h2>
                </div>
                <div class="inside">
                    <div class="big_count">0</div>
                </div>
            </div>
        </div>
        @endif
        @if(KeyValueFromJson(Auth::user()->permissions, 'dashboard_sell_today'))
        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fas fa-credit-card"></i>Facturado Hoy</h2>
                </div>
                <div class="inside">
                    <div class="big_count">0</div>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif
    
</div>
@endsection