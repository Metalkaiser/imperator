@extends('layouts.app')

@section('titulo')
Listado de ventas
@endsection

@section('styles')
<style type="text/css">
	.swal-height {
		height: 80vh;
		width: 90%;
	}
	#swal2-html-container {
		max-height: 90%;
	}
</style>
@endsection

@section('scripts')
<script type="text/javascript">
	function mostrar(venta) {
		$.ajax({
			url: '/ventas/'+venta['id'],
			dataType : 'json',
			type : 'get',
			data : {
				'venta': venta,
			},
			success: function(response){
				Swal.fire({
					title: 'Detalles de la venta',
					customClass: 'swal-height',
					width: '90%',
					showCancelButton: true,
					confirmButtonText: 'Editar',
					cancelButtonText: 'Cerrar',
					html: response,
				}).then((result) => {
					if (result.isConfirmed) {
						window.location = "/ventas/" + venta.id + "/editar";
					}
				});
			},
			error: function(xhr,status,error){
				Swal.fire({
					icon: 'warning',
					title: 'Error',
					text: "Error " + xhr.status + ": " + error,
				});
			}
		});
	}
	$(document).ready(function(){
		$(".menu-item.menu-item-submenu").eq(3).addClass("menu-item-here");
	});
</script>
<script src="{{ asset('js/buscar.js') }}"></script>
@endsection

@section('content')
<section>
	@if(count($ventas) == 0)
	<article>
		<h3>No hay ventas registradas</h3>
		<div>
			<a href="{{route('ventas.create')}}" class="btn btn-outline-success">+ Agregar venta de producto</a>
		</div>
	</article>
	@endif
</section>
<section>
	<div class="card card-custom">
		<div class="card-body">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<input class="form-control" type="text" id="buscainput" onkeyup="buscar()" placeholder="Buscar..">
					</div>
				</div>
				<div class="col-md-4"></div>
				<div class="col-md-4"></div>
			</div>
			<table class="table table-hover table-responsive-lg table-sm" id="buscatable">
				<thead>
					<tr>
						<th scope="col">Fecha</th>
						<th scope="col">Nombre del cliente</th>
						<th scope="col">Ciudad del cliente</th>
						<th scope="col">Monto pagado</th>
						<th scope="col">Moneda</th>
						<th scope="col">Estado de la venta</th>
						<th scope="col"></th>
					</tr>
				</thead>
				<tbody>
					@foreach($ventas as $venta)
					<tr>
						<th class="align-middle"><?php 
						$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
						$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	 
						echo $dias[date('w',strtotime($venta->created_at))]
						. ", " . date('d',strtotime($venta->created_at))
						. " de "
						. $meses[date('n',strtotime($venta->created_at))-1]
						. " del " . date('Y',strtotime($venta->created_at));
						 ?></th>
						<th class="align-middle">{{$venta->nombre_cliente}}</th>
						<th class="align-middle">{{$venta->ciudad_cliente}}</th>
						<th class="align-middle">{{$venta->pagos->monto}}</th>
						<th class="align-middle">{{$venta->pagos->moneda}}</th>
						<th class="align-middle">{{$venta->status}}</th>
						<th class="align-middle">
							<button class="btn btn-outline-info" type="button" onclick="mostrar({{$venta}})">Detalles</button>
						</th>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<article>
		{{ $ventas->links('layouts.components.paginador') }}
	</article>
</section>
@endsection