@extends('layouts.app')

@section('scripts')
<script type="text/javascript">
	function defectuosos(el){
		$(el).parent().next().toggle();
	}
</script>
@endsection

@section('content')
<section>
	<article>
		<div>
			<a href="/compras" class="btn btn-outline-danger">Volver atrás</a>
		</div>
	</article>
</section>
<section>
	<article>
		<h4>Editando compra de fecha: <?php 
					$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
					$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 
					echo $dias[date('w',strtotime($compra->created_at))]
					. ", " . date('d',strtotime($compra->created_at))
					. " de "
					. $meses[date('n',strtotime($compra->created_at))-1]
					. " del " . date('Y',strtotime($compra->created_at));
					 ?></h4>
	</article>
	<article>
		<table class="table table-hover table-sm">
			<thead>
				<tr>
					<th>Plataforma de pago</th>
					<th>Monto total</th>
					<th>Moneda</th>
					<th>Casillero</th>
					<th>Estado actual de la compra</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>{{$compra->pagos->tipo}}</td>
					<td>{{$compra->total}}</td>
					<td>{{$compra->pagos->moneda}}</td>
					<td>{{$compra->carrier->casillero}}</td>
					@if($compra->status == "Tienda")
					<td>En inventario</td>
					@else
					<td>{{$compra->status}}</td>
					@endif
				</tr>
			</tbody>
		</table>
	</article>
	<article>
		<form method="POST" action="{{route('compras.update',$compra->id)}}">
			@csrf
			@method('put')
			@foreach($productos as $indice => $producto)
			<div>
				<div>
					<h5>{{$producto->codigo}} {{$producto->nombre}}</h5>
					<button type="button" class="btn btn-warning" onclick="defectuosos(this)">Declarar producto defectuoso</button>
				</div>
				<div style="display: none;">
					<input type="hidden" name="producto[{{$indice}}]" value="{{$producto->id}}">
					@foreach($compra->compras as $i => $talla)
					@if($talla->producto_id == $producto->id)
					<div class="form-group">
						@if($talla->talla == 0)
						<label>Tallas varias (set)</label>
						@else
						<label>Talla {{$talla->talla}}</label>
						@endif
						<input type="checkbox" name="talla[{{$talla->id}}]">
						<input type="number" name="defectuosos[{{$talla->id}}]" min="0" max="{{$talla->cantidad}}">
					</div>
					@endif
					@endforeach
				</div>
			</div>
			@endforeach
			<div class="form-group">
				<label for="status">Estado de la compra</label>
				<select id="status" name="status" required>
				@switch($compra->status)
				@case("China")
					<option value="China" selected>China</option>
					<option value="Miami">Miami</option>
					<option value="Tienda">En inventario</option>
				@break
				@case("Miami")
					<option value="Miami" selected>Miami</option>
					<option value="Tienda">En inventario</option>
				@break
				@case("Tienda")
					<option value="Tienda" selected>En inventario</option>
				@break
				@default
					<option value="China">China</option>
					<option value="Miami">Miami</option>
					<option value="Tienda">En inventario</option>
				@endswitch
				</select>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Guardar cambios</button>
				<a href="{{route('compras.index')}}" class="btn btn-danger">Cancelar</a>
			</div>
		</form>
	</article>
</section>
@endsection