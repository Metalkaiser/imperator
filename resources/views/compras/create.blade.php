@extends('layouts.app')

@section('scripts')
<script type="text/javascript">
	function select(area, option) {
		let element = document.getElementById(area);
		if (option == "nuevo") {
			element.style.display = "block";
		}else {
			element.style.display = "none";
		}
	}

	function tallas(i){
		let d = document;
		let t_l = d.getElementsByClassName("tallas").length;		//Cantidad de tallas hasta ahora
		let t_p = (d.getElementsByClassName("productos").length) - 1;	//Cantidad de productos hasta ahora
		let t_div = d.getElementById("tallas"); 			//DIV que contiene las tallas
		var nueva = '<div class=\"tallas\"><div><h5 class=\"titulotalla\">Talla artículo '
		+ (t_l + 1)
		+ '</h5></div><div class=\"form-group\"><label for=\"talla['
		+ t_p + '][' + t_l
		+ ']\">Talla del producto</label><input class=\"input-talla\" type=\"text\" id=\"talla['
		+ t_p + '][' + t_l
		+ ']\" name=\"talla['
		+ t_p + '][' + t_l
		+ ']\" placeholder=\"Talla del producto\"></div><div class=\"form-group\"><label for=\"cantidad['
		+ t_p + '][' + t_l
		+ ']\">Cantidad comprada</label><input class=\"input-talla\" type=\"number\" id=\"cantidad['
		+ t_p + '][' + t_l
		+ ']\" name=\"cantidad['
		+ t_p + '][' + t_l
		+ ']\" placeholder=\"Cantidad comprada\"></div><div class=\"form-group\"><label for=\"unidad['
		+ t_p + '][' + t_l
		+ ']\">Precio por unidad</label><input class=\"input-talla\" type=\"text\" id=\"unidad['
		+ t_p + '][' + t_l
		+ ']\" name=\"unidad['
		+ t_p + '][' + t_l
		+ ']\" placeholder=\"Precio por unidad\"></div></div>';

		t_div.innerHTML += nueva;

	}


	function botontallas(el){
		let divtallas = el.parentNode.parentNode.parentNode;
		let inputs_tallas = document.getElementsByClassName("input-talla");
		var vacio = 0;
		Object.keys(inputs_tallas).forEach(key => inputs_tallas[key].value == "" ? vacio++ : null);
		if (vacio == 0) {
			divtallas.nextElementSibling.firstElementChild.disabled = false;
		}else {
			divtallas.nextElementSibling.firstElementChild.disabled = true;
		}
	}


	function productos(i){
		let d = document;
		let t_l = d.getElementsByClassName("productos").length;		//Cantidad de tallas
		let t_div = d.getElementById("productos"); 			//DIV que contiene los productos
		console.log("Producto agregado");
	}
</script>
@endsection

@section('styles')
<style type="text/css">
	[id^="productonuevo"] {
		display: none;
	}
	[id^="proveedornuevo"] {
		display: none;
	}
	#casilleronuevo {
		display: none;
	}
</style>
@endsection

@section('content')
<section>
	<article>
		<h3>Ingrese los datos de la mercancía nueva</h3>
	</article>
	<hr>
	<article id="product-form">
		<form method="POST" action="{{route('compras.store')}}">
			@csrf
			<div id="productos">
				<div><h4>Ingrese la mercancía comprada</h4></div>
				<div class="productos">
					<div class="form-group">
						<label for="mercancias[0]">Seleccione un producto</label>
						<select id="mercancias[0]" onchange="select('productonuevo[0]', this.value)" name="mercancias[0]">
							<option disabled selected>Seleccione un producto</option>
							@foreach($productos as $producto)
							<option value="{{$producto->id}}">{{$producto->nombre}}</option>
							@endforeach
							<option value="nuevo">Producto nuevo</option>
						</select>
					</div>
					<div id="productonuevo[0]">
						<div><h4>Ingrese los detalles del producto nuevo</h4></div>
						<div class="form-group">
							<label for="codigo[0]">Código del producto</label>
							<input type="text" id="codigo[0]" name="codigo[0]" placeholder="Código del producto">
						</div>
						<div class="form-group">
							<label for="nombre[0]">Nombre del producto</label>
							<input type="text" id="nombre[0]" name="nombre[0]" placeholder="Nombre del producto">
						</div>
						<div class="form-group">
							<label for="descripcion[0]">Descripción del producto</label>
							<textarea name="descripcion[0]" id="descripcion[0]" placeholder="Descripción del producto"></textarea>
						</div>
						<div class="form-group">
							<label for="imagen[0]">Imagen del producto</label>
							<input type="file" id="imagen[0]" name="imagen[0]">
						</div>
					</div>
					<div class="form-group">
						<label for="proveedorselect[0]">Proveedor</label>
						<select id="proveedorselect[0]" onchange="select('proveedornuevo[0]', this.value)" name="proveedorselect[0]">
							<option disabled selected>Seleccione un proveedor</option>
							@foreach($proveedores as $proveedor)
							<option value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
							@endforeach
							<option value="nuevo">Proveedor nuevo</option>
						</select>
						<div id="proveedornuevo[0]">
							<div class="form-group">
								<label for="proveedorname[0]">Nombre del proveedor nuevo</label>
								<input type="text" id="proveedorname[0]" name="proveedor[0]" placeholder="Nombre del proveedor nuevo">
							</div>
							<div class="form-group">
								<label for="url[0]">Enlace a tienda del proveedor nuevo</label>
								<input type="text" name="url[0]" id="url[0]" placeholder="Enlace a tienda del proveedor nuevo">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="precio">Precio de venta</label>
						<input type="text" id="precio" name="precio" placeholder="Precio de venta">
					</div>
					<hr>
					<div id="tallas">
						<div><h4>Ingrese las tallas compradas y cantidad de cada una</h4></div>
						<div class="tallas">
							<div><h5 class="titulotalla">Talla artículo 1</h5></div>
							<div class="form-group">
								<label for="talla[0][0]">Talla del producto</label>
								<input onchange="botontallas(this)" class="input-talla" type="text" id="talla[0][0]" name="talla[0][0]" placeholder="Talla del producto">
							</div>
							<div class="form-group">
								<label for="cantidad[0][0]">Cantidad comprada</label>
								<input onchange="botontallas(this)" class="input-talla" type="number" id="cantidad[0][0]" name="cantidad[0][0]" placeholder="Cantidad comprada">
							</div>
							<div class="form-group">
								<label for="unidad[0][0]">Precio por unidad</label>
								<input onchange="botontallas(this)" class="input-talla" type="text" id="unidad[0][0]" name="unidad[0][0]" placeholder="Precio por unidad">
							</div>
						</div>
					</div>
					<div>
						<button type="button" class="btn btn-primary newtalla" onclick="tallas(0)" disabled>Agregar otra talla</button>
					</div>
					<hr>
				</div>
				<div>
					<button id="nuevoproducto" type="button" class="btn btn-primary" onclick="productos(0)" disabled>Agregar otro producto</button>
				</div>
			</div>
			<hr>
			<!--	Acá van los formularios para el pago de la compra de mercancías		-->
			<div><h4>Ingrese los datos de envío y pago de mercancías</h4></div>
			<div>
				<div class="form-group">
					<label for="casilleroselect">Casillero en Miami</label>
					<select id="casilleroselect" onchange="select('casilleronuevo', this.value)" name="casilleroselect">
						<option disabled selected>Seleccione un casillero</option>
						@foreach($carriers as $carrier)
						<option value="{{$carrier->id}}">{{$carrier->nombre}}: {{$carrier->casillero}}</option>
						@endforeach
						<option value="nuevo">Casillero nuevo</option>
					</select>
					<div id="casilleronuevo">
						<div class="form-group">
							<label for="carriername">Nombre de la empresa de envíos</label>
							<input type="text" id="carriername" name="carriername" placeholder="Nombre de la empresa de envíos">
						</div>
						<div class="form-group">
							<label for="casillero">Dirección del casillero</label>
							<input type="text" name="casillero" id="casillero" placeholder="Dirección del casillero">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="pago">Plataforma de pago</label>
					<select id="pago" name="pago">
						<option selected disabled>Seleccione un método de pago</option>
						<option value="Paypal">Paypal</option>
						<option value="Tarjeta de crédito/débito">Tarjeta de crédito/débito</option>
						<option value="Otro">Otro</option>
					</select>
				</div>
				<div class="form-group">
					<label for="monto">Monto pagado</label>
					<input type="text" id="monto" name="monto" placeholder="Monto pagado">
				</div>
				<div class="form-group">
					<label for="precio">Referencia de pago</label>
					<input type="text" id="referencia" name="referencia" placeholder="Referencia de pago">
				</div>
				<div class="form-group">
					<label for="moneda">Moneda</label>
					<select id="moneda" name="moneda">
						<option selected disabled>Seleccione una moneda</option>
						<option value="Dólares">Dólares</option>
						<option value="Criptomoneda">Criptomoneda</option>
						<option value="Otro">Otro</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Guardar en inventario</button>
				<a href="{{route('inventario.index')}}" class="btn btn-danger">Cancelar</a>
			</div>
		</form>
	</article>
</section>
@endsection