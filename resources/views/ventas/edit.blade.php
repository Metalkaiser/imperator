@extends('layouts.app')

@section('scripts')
<script type="text/javascript">
	function envioselect(el){
		if(el.value == "Entrega en persona" || el.value == "Otro") {
			$("#envioselect").hide();
		}else {
			$("#envioselect").show();
		}
	}
</script>
@endsection

@section('content')
<section>
	<article>
		<div>
			<a href="/ventas" class="btn btn-outline-danger">Volver atrás</a>
		</div>
	</article>
</section>
<section>
	<article>
		<h4>Editando venta del cliente: {{$venta->nombre_cliente}}</h4>
	</article>
	<article>
		<table class="table table-hover table-sm">
			<thead>
				<tr>
					<th>Ciudad del cliente</th>
					<th>Plataforma de contacto</th>
					<th>Forma de pago</th>
					<th>Estado actual de la venta</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>{{$venta->ciudad_cliente}}</td>
					<td>{{$venta->plataformas->nombre}}</td>
					<td>{{$venta->pagos->plat_pago}}</td>
					<td>{{$venta->status}}</td>
				</tr>
			</tbody>
		</table>
	</article>
	<article>
		<form method="POST" action="{{route('ventas.update',$venta->id)}}">
			@csrf
			@method('put')
			<div class="form-group">
				<label for="empresa">Empresa de envíos</label>
				<select id="empresa" name="empresa" required onchange="envioselect(this);">
				@switch($venta->envios->empresa)
					@case("MRW")
					<option value="MRW" selected>MRW</option>
					<option value="Zoom">Zoom</option>
					<option value="Domesa">Domesa</option>
					<option value="Entrega en persona">Entrega en persona</option>
					<option value="Otro">Otro</option>
					@break
					@case("Zoom")
					<option value="MRW">MRW</option>
					<option value="Zoom" selected>Zoom</option>
					<option value="Domesa">Domesa</option>
					<option value="Entrega en persona">Entrega en persona</option>
					<option value="Otro">Otro</option>
					@break
					@case("Domesa")
					<option value="MRW">MRW</option>
					<option value="Zoom">Zoom</option>
					<option value="Domesa" selected>Domesa</option>
					<option value="Entrega en persona">Entrega en persona</option>
					<option value="Otro">Otro</option>
					@break
					@case("Entrega en persona")
					<option value="MRW">MRW</option>
					<option value="Zoom">Zoom</option>
					<option value="Domesa">Domesa</option>
					<option value="Entrega en persona" selected>Entrega en persona</option>
					<option value="Otro">Otro</option>
					@break
					@case("Otro")
					<option value="MRW">MRW</option>
					<option value="Zoom">Zoom</option>
					<option value="Domesa">Domesa</option>
					<option value="Entrega en persona">Entrega en persona</option>
					<option value="Otro" selected>Otro</option>
					@break
				@endswitch
				</select>
			</div>
			@if($venta->envios->empresa == "Entrega en persona" || $venta->envios->empresa == "Otro")
			<div id="envioselect" style="display: none;">
			@else
			<div id="envioselect">
			@endif
				<div class="form-group">
					<label for="rastreo">Código de rastreo</label>
					<input type="text" name="rastreo" id="rastreo" value="{{$venta->envios->rastreo}}">
					</div>
				<div class="form-group">
					<label for="precio">Precio de envío</label>
					<input type="text" name="precio" id="precio" value="{{$venta->envios->precio}}">
				</div>
			</div>
			<div class="form-group">
				<label for="status">Estado de la venta</label>
				<select id="status" name="status" required>
					<?php
						switch ($venta->status) {
							case 'Pagado':
								echo "<option value=\"Pagado\" selected>Pagado</option>";
								echo "<option value=\"Enviado\">Enviado</option>";
								echo "<option value=\"Recibido\">Recibido por el cliente</option>";
								break;
							case 'Enviado':
								echo "<option value=\"Enviado\" selected>Enviado</option>";
								echo "<option value=\"Recibido\">Recibido por el cliente</option>";
								break;
							case 'Recibido':
								echo "<option value=\"Recibido\" selected>Recibido por el cliente</option>";
								break;
							default:
								echo "<option disabled selected value=\"\">Seleccione un estado</option>";
								echo "<option value=\"Pagado\">Pagado</option>";
								echo "<option value=\"Enviado\">Enviado</option>";
								echo "<option value=\"Recibido\">Recibido por el cliente</option>";
								break;
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Guardar cambios</button>
				<a href="{{route('ventas.index')}}" class="btn btn-danger">Cancelar</a>
			</div>
		</form>
	</article>
</section>
@endsection