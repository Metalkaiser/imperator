@extends('layouts.app')

@section('content')
<section>
	<article>
		<a href="{{route('compras.create')}}" class="btn btn-outline-primary">+ Agregar compra al inventario</a>
	</article>
	<article>
		<button class="btn btn-outline-success">+ Agregar venta de producto</button>
	</article>
	@if(count($productos) == 0)
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
				@foreach($productos as $producto)
				<tr>
					<th>
						<img src="{{asset($producto->codigo)}}" alt="{{$producto->nombre}}">
					</th>
					<th>{{$producto->codigo}}</th>
					<th>{{$producto->nombre}}</th>
					<th>{{$tallas[$producto->codigo]}}</th>
					<th>{{array_sum($cantidades[$producto->codigo])}}</th>
					<th>{{$producto->precio}}</th>
					<th>
						<button class="btn btn-outline-info" type="button">Detalles</button>
					</th>
				</tr>
				@endforeach
			</tbody>
		</table>
	</article>
	<article>
		{{ $productos->links() }}
	</article>
</section>
@endsection