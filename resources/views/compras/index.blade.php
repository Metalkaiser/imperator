@extends('layouts.app')

@section('titulo')
Listado de compras
@endsection

@section('scripts')
<script type="text/javascript">
	function mostrar(compra){
		$.ajax({
			url: '/compras/'+compra['id'],
			dataType : 'json',
			type : 'get',
			data : {
				'compra': compra,
			},
			success: function(response){
				Swal.fire({
					title: 'Detalles de la compra',
					width: '90%',
					showCancelButton: true,
					confirmButtonText: 'Editar',
					cancelButtonText: 'Cerrar',
					html: response,
				}).then((result) => {
					if (result.isConfirmed) {
						window.location = "/compras/" + compra.id + "/editar";
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
		$(".menu-item.menu-item-submenu").eq(2).addClass("menu-item-here");
	});
</script>
<script src="{{ asset('js/buscar.js') }}"></script>
@endsection

@section('content')
<section>
	@if(count($compras) == 0)
	<article>
		<h3>No hay compras registradas</h3>
		<div>
			<a href="{{route('compras.create')}}" class="btn btn-outline-success">+ Agregar compras al inventario</a>
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
			<table class="table table-hover table-responsive-md table-sm" id="buscatable">
				<thead>
					<tr>
						<th scope="col">Fecha</th>
						<th scope="col">Total pagado</th>
						<th scope="col">Tipo de pago</th>
						<th scope="col">Empresa de envíos</th>
						<th scope="col">Moneda</th>
						<th scope="col">Costo de envío ($)</th>
						<th scope="col">Estado de la compra</th>
						<th scope="col"></th>
					</tr>
				</thead>
				<tbody>
					@foreach($compras as $compra)
					<tr>
						<th class="align-middle"><?php 
						$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
						$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	 
						echo $dias[date('w',strtotime($compra->created_at))]
						. ", " . date('d',strtotime($compra->created_at))
						. " de "
						. $meses[date('n',strtotime($compra->created_at))-1]
						. " del " . date('Y',strtotime($compra->created_at));
						 ?></th>
						<th class="align-middle">{{$compra->total}}</th>
						<th class="align-middle">{{$compra->pagos->tipo}}</th>
						<th class="align-middle">{{$compra->carrier->nombre}}</th>
						<th class="align-middle">{{$compra->pagos->moneda}}</th>
						<th class="align-middle"><?php if ($compra->costo_envio == "") {
							echo "Costo sin declarar";
						}else {
							echo $compra->costo_envio;
						} ?></th>
						<th class="align-middle"><?php 
						switch ($compra->status) {
							case 'Tienda':
								echo "En inventario";
								break;
							case 'China':
								echo "Saliendo desde China";
								break;
							case 'Miami':
								echo "En Miami";
								break;
							default:
								echo "Otro";
								break;
						}
						?></th>
						<th class="align-middle">
							<button class="btn btn-outline-info" type="button" onclick="mostrar({{$compra}})">Detalles</button>
						</th>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<article>
		{{ $compras->links('layouts.components.paginador') }}
	</article>
</section>
@endsection