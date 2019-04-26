@extends('layouts.app-a')

@section('content')
<div class="container-fluid mt-3">
    <div class="row">
        @include('includes/slidebar-admin')
    <div class="col-12 col-md-9 col-lg-10 mb-3">

            <!--Titulo-->
            <div class="row ">
                <div class="col-12">
                    <strong class="navbar-brand p-0">{{count($categorias)}} categorias registradas</strong>
                </div>


            <div class="col-12 mt-2">

                    <div class="row">
                        <div class="col-12">
                            @if (session('resultado'))
                                <strong>
                                    <div class="alert alert-success">{{session('resultado')}}</div>
                                </strong>
                            @endif
                        </div>
                    </div>

                <table class="table table-responsive table-hover">
                    <thead class="thead-light">
                        <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Fecha de creación</th>
                        <th scope="col">Última actualización</th>
                        <th scope="col" colspan="2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                    @foreach ($categorias as $categoria)
                        <tr>
                            <td>{{$categoria->name}}</td>
                            <th scope="col">
                                @if ($categoria->state==1)
                                    Habilitado
                                @else
                                <strong class="text-danger">Deshabilitado</strong>
                                @endif
                            </th>
                            <td>{{$categoria->description}}</td>
                            <td>{{$categoria->created_at}}</td>
                            <td>{{$categoria->updated_at}}</td>

                            <td>
                                <a href="{{route('admin.restaurant.edit',["id" => $categoria->id ])}}" class="btn btn-sm btn-outline-primary">
                                    Editar
                                </a>
                            </td>
                            <td>
                                @if ($categoria->state==1)
                                    <a href="{{route('admin.categorias.update.state',["id" => $categoria->id ])}}" class="btn btn-outline-danger btn-sm">Deshabilitar</a>
                                @else
                                    <a href="{{route('admin.categorias.update.state',["id" => $categoria->id ])}}" class="btn btn-outline-success btn-sm">Habilitar</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>

            </div>
        </div>
        <!--Titulo-->
        </div>
    </div>
</div>
 @endsection