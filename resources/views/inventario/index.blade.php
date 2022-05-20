@extends('layouts.app')

@section('titulo')
Lista de productos
@endsection

@section('styles')
<style type="text/css">
	.img-producto {
		height: 100px;
		width: 100px;
	}
</style>
@endsection

@section('scripts')
<script type="text/javascript">
	function mostrar(producto) {
		let cantidades = <?php echo json_encode($cantidades); ?>;

		$.ajax({
			url: '/inventario/'+producto['id'],
			dataType : 'json',
			type : 'get',
			data : {
				'producto': producto,
				'cantidades': cantidades,
			},
			success: function(response){
				Swal.fire({
					title: producto.nombre,
					imageUrl: 'imagenes/' + producto.nombre + '.jpg',
					imageWidth: 350,
					imageHeight: 350,
					width: '70%',
					imageAlt: producto.nombre,
					showCancelButton: true,
					confirmButtonText: 'Editar',
					cancelButtonText: 'Cerrar',
					html: response
				}).then((result) => {
					if (result.isConfirmed) {
						window.location = "/inventario/" + producto.id + "/editar";
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
	@if(count($paginas) == 0)
	<article>
		<h3>No hay nada en el inventario</h3>
		<h3>Agrega una compra al inventario</h3>
	</article>
	@endif
</section>
<section>
	<div class="card card-custom">
		<div class="card-body">
			<table class="table table-hover table-responsive-md table-sm">
				<thead>
					<tr>
						<th scope="col">Imagen</th>
						<th scope="col">Código del producto</th>
						<th scope="col">Nombre del producto</th>
						<th scope="col">Tallas</th>
						<th scope="col">Cantidad total</th>
						<th scope="col">Precio</th>
						<th scope="col"></th>
					</tr>
				</thead>
				<tbody>
					@foreach($paginas as $producto)
					<tr>
						<th class="text-center">
							<img class="img-producto" src="<?php echo asset('imagenes/' . $producto->nombre) . '.jpg'; ?>" alt="{{$producto->nombre}}">
						</th>
						<th class="align-middle">{{$producto->codigo}}</th>
						<th class="align-middle">{{$producto->nombre}}</th>
						<th class="align-middle">
							@if($tallas[$producto->codigo] == 0)
							Varias
							@else
							{{$tallas[$producto->codigo]}}
							@endif
						</th>
						<th class="align-middle">{{array_sum($cantidades[$producto->id])}}</th>
						<th class="align-middle">{{$producto->precio}}</th>
						<th class="align-middle">
							<button class="btn btn-outline-info" type="button" onclick="mostrar({{$producto}})">Detalles</button>
						</th>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<article>
	</article>
	<article>
		{{ $paginas->links('layouts.components.paginador') }}
	</article>
</section>
@endsection