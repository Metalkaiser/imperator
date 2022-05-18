@extends('layouts.app')

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
						window.location = "/compras/" + compra.id + "/edit";
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
</script>
@endsection

@section('content')
<section>
	<article>
		<div>
			<a href="/" class="btn btn-outline-danger">Volver atrás</a>
		</div>
		<div>
			<div>
				<a href="{{route('compras.create')}}" class="btn btn-outline-primary">+ Agregar compra al inventario</a>
			</div>
			<div>
				<a href="{{route('ventas.create')}}" class="btn btn-outline-success">+ Agregar venta de producto</a>
			</div>
		</div>
	</article>
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
	<article>
		<table class="table table-hover table-sm">
			<thead>
				<tr>
					<th scope="col">Fecha</th>
					<th scope="col">Total pagado</th>
					<th scope="col">Tipo de pago</th>
					<th scope="col">Empresa de envíos</th>
					<th scope="col">Moneda</th>
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
	</article>
	<article>
		{{ $compras->links() }}
	</article>
</section>
@endsection