@extends('layouts.app-r')

@section('content')
    <div class="container">
        <div class="row mt-3">
            <div class="col-12 ">
                <h4>Detalle del pedido</h4>
            </div>

            <div class="col-12">
                <table class="table table-responsive table-hover">
                    <thead class="thead-light">
                        <tr>
                        <th scope="col" colspan="2">Plato</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">SubTotal</th>
                        {{-- <th scope="col">Tipo</th> --}}
                        </tr>
                    </thead>
                    <tbody>
@php
    $suma=0;
@endphp
                    @foreach ($pedidos as $pedido)
                        @php
                            $suma+=$pedido->cant*$pedido->price;
                        @endphp
                        <tr>
                            <th scope="row" class="p-0 pt-1 pl-2">
                                <img src="{{ route('dish.image',['filename'=>$pedido->image]) }}" width="50" class="img-fluid img-thumbnail shadow-sm avatar">
                            </th>
                            <th scope="row">{{$pedido->name}}</th>
                            <td>{{"S/. ".$pedido->price}}</td>
                            <td>{{sprintf('%03d',$pedido->cant)}}</td>
                            <td>{{"S/. ".number_format(($pedido->cant*$pedido->price),2)}}</td>
                            <td class="text-capitalize">{{$pedido->type}}</td>

                        </tr>
                    @endforeach
<tr><td colspan="5" class="alert alert-primary">
    <center>
        <h4>S/.{{$suma}}</h4>
    </center>

</td></tr>
                    </tbody>
                </table>

            </div>


        </div>
    </div>
@endsection
