@extends('layouts.app')

@section('titulo')
Panel de control
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $(".menu-item.menu-item-submenu").eq(0).addClass("menu-item-here");
    });
</script>
@endsection

@section('content')
<section>
    <div class="row">
    <div class="col-lg-6">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <!--begin::Header-->
            <div class="card-header h-auto">
                <!--begin::Title-->
                <div class="card-title py-5">
                    <h3 class="card-label">
                        Ventas (últimos 30 días)
                    </h3>
                </div>
                <!--end::Title-->
            </div>
            <!--end::Header-->
            <div class="card-body">
                <!--begin::Chart-->
                <div>
                    @if(count($ventas))
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Nombre del cliente</th>
                                <th>Estado de la venta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ventas as $venta)
                            <tr>
                                <td><?php echo date('d-m-Y',strtotime($venta->created_at)); ?></td>
                                <td>{{$venta->nombre_cliente}}</td>
                                @switch($venta->status)
                                @case("Pagado")
                                <td>
                                     <span class="label label-inline label-light-warning font-weight-bold">Pagado</span>
                                </td>
                                @break
                                @case("Enviado")
                                <td>
                                     <span class="label label-inline label-light-info font-weight-bold">Enviado</span>
                                </td>
                                @break
                                @case("Recibido")
                                <td>
                                     <span class="label label-inline label-light-success font-weight-bold">Recibido por el cliente</span>
                                </td>
                                @break
                                @default
                                <td>
                                     <span class="label label-inline label-light-danger font-weight-bold">{{$venta->status}}</span>
                                </td>
                                @break
                                @endswitch
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    No hay ventas en los últimos 30 días
                    @endif
                </div>
                <!--end::Chart-->
            </div>
        </div>
        <!--end::Card-->
    </div>
    <div class="col-lg-6">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">
                        Compras (últimos 30 días)
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <!--begin::Chart-->
                <div>
                    @if(count($compras))
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Monto total</th>
                                <th>Estado de la compra</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($compras as $compra)
                            <tr>
                                <td><?php echo date('d-m-Y',strtotime($compra->created_at)); ?></td>
                                <td>{{$compra->monto}}</td>
                                @switch($compra->status)
                                @case("China")
                                <td>
                                     <span class="label label-inline label-light-warning font-weight-bold">Saliendo de China</span>
                                </td>
                                @break
                                @case("Miami")
                                <td>
                                     <span class="label label-inline label-light-info font-weight-bold">En Miami</span>
                                </td>
                                @break
                                @case("Tienda")
                                <td>
                                     <span class="label label-inline label-light-success font-weight-bold">En inventario</span>
                                </td>
                                @break
                                @default
                                <td>
                                     <span class="label label-inline label-light-danger font-weight-bold">{{$compra->status}}</span>
                                </td>
                                @break
                                @endswitch
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    No hay compras en los últimos 30 días
                    @endif
                </div>
                <!--end::Chart-->
            </div>
        </div>
        <!--end::Card-->
    </div>
</div>
</section>
@endsection
