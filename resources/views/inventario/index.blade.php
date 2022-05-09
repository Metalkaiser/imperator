@extends('layouts.app')

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
	function mostrar(pid) {
		let productos = <?php echo json_encode($paginas); ?>;
		let cantidades = <?php echo json_encode($cantidades); ?>;
		let producto = {};
		$(productos.data).each(function(){
			this.id == pid ? producto = this : "";
		});
		var tallasObj = cantidades[pid];
		var tallas = Object.keys(tallasObj);
		var cantidad = Object.values(tallasObj);
		var filas = "";
		var talla = "";
		$(tallas).each(function(index,item){
			if (item == 0) {
				talla = "Varias"
			}else {
				talla = ""+item;
			}
			filas += '<tr><th class="text-center">'+talla+'</th>' +
			'<th class="text-center">'+cantidad[index]+'</th>' +
			'</tr>';
		});
		Swal.fire({
			title: producto.nombre,
			imageUrl: 'imagenes/' + producto.nombre + '.jpg',
			imageWidth: 350,
			imageAlt: producto.nombre,
			showCancelButton: true,
			confirmButtonText: 'Editar',
			cancelButtonText: 'Cerrar',
			html:
			    '<div><p>'+producto.descripcion+'</p>' +
				'<table class="table table-hover table-sm"><thead>' +
				'<tr><th scope="col">Talla</th>' +
				'<th scope="col">Cantidad</th></tr>' +
				'</thead><tbody>'+filas+'</tbody></table></div>',
		}).then((result) => {
			if (result.isConfirmed) {
				window.location = "/inventario/" + producto.id + "/edit";
			}
		});
	}
</script>
@endsection

@section('content')
<section>
	<article>
		<a href="{{route('compras.create')}}" class="btn btn-outline-primary">+ Agregar compra al inventario</a>
	</article>
	<article>
		<a href="{{route('ventas.create')}}" class="btn btn-outline-success">+ Agregar venta de producto</a>
	</article>
	@if(count($paginas) == 0)
	<article>
		<h3>No hay nada en el inventario</h3>
		<h3>Agrega una compra al inventario</h3>
	</article>
	@endif
</section>
<section>
	<article>
		<table class="table table-hover table-sm">
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
						<button class="btn btn-outline-info" type="button" onclick="mostrar({{$producto->id}})">Detalles</button>
					</th>
				</tr>
				@endforeach
			</tbody>
		</table>
	</article>
	<article>
		{{ $paginas->links() }}
	</article>
</section>
@endsection