@extends('layouts.app')

@section('titulo')
Costos por producto
@endsection

@section('styles')
<style type="text/css">
	th, td {
		white-space: nowrap;
		overflow: hidden;
		text-overflow:ellipsis;
	}
</style>
@endsection

@section('content')
<section class="card card-custom">
	<article class="card-header">
		<div class="form-group row card-title">
			<div class="col-md-4">
				<input class="form-control" type="text" id="publicidad" placeholder="Fracción de publicidad">
			</div>
			<div class="col-md-4">
				<input class="form-control" type="text" id="embalaje" placeholder="Costo del embalaje">
			</div>
			<div class="col-md-4">
				<input class="form-control" type="text" id="pasaje" placeholder="Fracción de pasaje">
			</div>
		</div>
	</article>
	<article class="card-body">
		<table class="table table-hover table-responsive table-sm table-bordered">
			<thead>
				<tr>
					<th>Código del producto</th>
					<th>Nombre del producto</th>
					<th>Unidades pedidas</th>
					<th>Unidades efectivas</th>
					<th>Precio en China</th>
					<th>Envío a Venezuela</th>
					<th>Fracción de mercancía defectuosa</th>
					<th>Precio bruto</th>
					<th>Ganancia estimada</th>
					<th>Precio estimado</th>
					<th>Precio de venta actual</th>
					<th>Ganancia por unidad</th>
					<th>Ganancia por lote</th>
				</tr>
			</thead>
			<tbody>
				@foreach($productos as $index => $producto)
				<tr>
					<td>{{$producto->codigo}}</td>
					<td>{{$producto->nombre}}</td>
					<td>{{$cantidades[$producto->id][0]['cantidad']}}</td>
					<td>{{($cantidades[$producto->id][0]['cantidad'] - $cantidades[$producto->id][0]['defectuosos'])}}</td>
					<td>{{$compras[$index]->precio}}</td>
					<td>{{$compras[$index]->costo_envio}}</td>
					<td>{{$cantCompra[array_column($compras, 'compra_id', 'producto_id')[$producto->id]]}}</td>
					<td></td>
					<td></td>
					<td></td>
					<td>{{$producto->precio}}</td>
					<td></td>
					<td></td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</article>
</section>
@endsection