@extends('layouts.app')

@section('titulo')
Añadir venta
@endsection

@section('styles')
<style type="text/css">
	#promosection, #rastreosection, #referenciasection {
		display: none;
	}
	.productos {
		margin-bottom: 20px;
	}
</style>
@endsection

@section('scripts')
<script type="text/javascript">
	function select(area, option) {
		let element = document.getElementById(area);
		if (area == "promosection" && option == "Sí" || 
			area == "rastreosection" && option == "Enviado" || 
			area == "referenciasection" && option == "Paypal" || 
			area == "referenciasection" && option == "AirTM" || 
			area == "referenciasection" && option == "Pagomóvil") {
			element.style.display = "block";
			$(element.getElementsByTagName('input')).each(function(){
				$(this).attr("required", "required");
			});
			$(element.getElementsByTagName('textarea')).each(function(){
				$(this).attr("required", "required");
			});
			if (area == "promosection") {
				$(element.getElementsByTagName('select')).each(function(){
					$(this).attr("required", "required");
				});
			}
		}else {
			element.style.display = "none";
			$(element.getElementsByTagName('input')).each(function(){
				$(this).removeAttr("required");
			});
			$(element.getElementsByTagName('textarea')).each(function(){
				$(this).removeAttr("required", "required");
			});
			if (area == "promosection") {
				$(element.getElementsByTagName('select')).each(function(){
					$(this).removeAttr("required", "required");
				});
			}
		}
	}
	//Se ingresa una nueva talla al producto
	function tallas(i){
		let t_l = $("#tallas\\[" + i + "\\] .tallas").length;		//Cantidad de tallas hasta ahora
		let t_p = ($(".productos").length) - 1;	//Cantidad de productos hasta ahora
		let t_div = $("#tallas\\[" + i + "\\]"); 			//DIV que contiene las tallas
		let form_group = "<div class=\"form-group\"><label for=\"";
		let labels = "</label><input class=\"input-talla\" type=\"text\" id=\"";
		var nueva = '<div class=\"tallas\"><div><h5 class=\"titulotalla\">Talla artículo '
		+ (t_l + 1)
		+ '</h5></div><div class=\"form-group row\"><div class=\"col-md-4\"></div><div class=\"col-md-3\"><label for=\"talla['
		+ i
		+ ']['
		+ t_l
		+ ']\">Talla del producto</label></div><div class=\"col-md-5\"><select class=\"form-control input-talla\" type=\"text\" id=\"talla['
		+ i
		+ ']['
		+ t_l
		+ ']\" name=\"talla['
		+ i
		+ ']['
		+ t_l
		+ ']\" onchange=\"ts(this)\" required><option disabled selected value=\"\">Seleccione una talla</option></select><span class=\"form-text text-muted\"></span></div></div><div class=\"form-group row\"><div class=\"col-md-4\"></div><div class=\"col-md-3\"><label for=\"cantidad['
		+ i
		+ ']['
		+ t_l
		+ ']\">Cantidad comprada</label></div><div class=\"col-md-5\"><input class=\"form-control input-talla\" type=\"number\" id=\"cantidad['
		+ i
		+ ']['
		+ t_l
		+ ']\" name=\"cantidad['
		+ i
		+ ']['
		+ t_l
		+ ']\" placeholder=\"Cantidad comprada\" min=\"1\" required></div></div></div>';

		var j = 0;
		$("#tallas\\[" + i + "\\] :input").each(function(index,item){
			$(item).val() == "" ? j++ : j = j;
		});
		if (j) {
			Swal.fire({
				icon: 'warning',
				title: 'Campos sin llenar',
				text: "Llene toda la información antes de agregar una talla nueva",
			});
		}else {
			t_div.append(nueva);
			$(".newtalla").eq(i).parent().siblings().eq(1).children().eq(0).removeAttr("disabled");
			options(document.getElementById("mercancias["+i+"]"));
		}
	}
	//Se ingresa un producto nuevo
	function productos(el){
		let t_l = $(".productos").length;		//Cantidad de tallas
		let t_div = $("#productos"); 			//DIV que contiene los productos
		let form_group = "<div class=\"form-group\"><label for=\"";
		var optionsprod = optionsprov = "";
		var productos = <?php echo json_encode($productos); ?>;
		$(productos).each(function(){
			optionsprod += "<option value=\"" + this.id + "\">" + this.nombre + "</option>"
		});
		var nuevo = '<div class=\"productos card card-custom\"><div class=\"card-body\"><div class=\"text-center mb-5\"><h5 class=\"titulotalla\">Producto '
			+ (t_l + 1)
			+ '</h5></div><div class=\"form-group row\"><div class=\"col-md-3\"><label for=\"mercancias['
			+ t_l
			+ ']\">Seleccione un producto</label></div><div class=\"col-md-9\"><select class=\"form-control\" id=\"mercancias['
			+ t_l
			+ ']\" name=\"mercancias['
			+ t_l
			+ ']\" onchange=\"tp(this)\" required><option disabled selected value=\"\">Seleccione un producto</option>'
			+ optionsprod
			+ '</select></div></div><div class=\"form-group row\"><div class=\"col-md-3\"><label for=\"precio['
			+ t_l
			+ ']\">Precio de venta</label></div><div class=\"col-md-9\"><input class=\"form-control\" type=\"text\" id=\"precio\" name=\"precio['
			+ t_l
			+ ']\" placeholder=\"Precio de venta\" required><span class=\"form-text text-muted\">Precio de venta del producto en dólares</span></div></div><hr><div id=\"tallas['
			+ t_l
			+ ']\"><div class=\"text-center mb-5\"><h4>Ingrese las tallas compradas y cantidad de cada una</h4></div><div class=\"tallas\"><div><h5 class=\"titulotalla\">Talla artículo 1</h5></div><div class=\"form-group row\"><div class=\"col-md-4\"></div><div class=\"col-md-3\"><label for=\"talla['
			+ t_l
			+ '][0]\">Talla del producto</label></div><div class=\"col-md-5\"><select class=\"form-control input-talla\" type=\"text\" id=\"talla['
			+ t_l
			+ '][0]\" name=\"talla['
			+ t_l
			+ '][0]\" onchange=\"ts(this)\" required><option disabled selected value=\"\">Seleccione una talla</option></select><span class=\"form-text text-muted\"></span></div></div><div class=\"form-group row\"><div class=\"col-md-4\"></div><div class=\"col-md-3\"><label for=\"cantidad['
			+ t_l
			+ '][0]\">Cantidad comprada</label></div><div class=\"col-md-5\"><input class=\"form-control input-talla\" type=\"number\" id=\"cantidad['
			+ t_l
			+ '][0]\" name=\"cantidad['
			+ t_l
			+ '][0]\" placeholder=\"Cantidad comprada\" min=\"1\" required></div></div></div></div><div class=\"row text-center\"><div class=\"col-md-3\"></div><div class=\"col-md-3\"><button type=\"button\" class=\"btn btn-primary newtalla\" onclick=\"tallas('
			+ t_l
			+ ')\">Agregar otra talla</button></div><div class=\"col-md-3\"><button type=\"button\" class=\"btn btn-danger\" onclick=\"borrarTalla('
			+ t_l
			+ ')\" disabled=\"disabled\">Eliminar talla</button></div><div class=\"col-md-3\"></div></div></div></div>';

		t_div.append(nuevo);
		$(el).parent().siblings().children().eq(0).removeAttr("disabled");
	}
	//Crea las opciones para las tallas
	function options(el){
		var tallas = $('[id^="talla\\['+el.id.substr(11,1)+'\\]"]');
		var opciones = <?php echo json_encode($opciones); ?>;
		var options = "<option disabled selected value=''>Seleccione una talla</option>";
		$(opciones[el.value]).each(function(){
			if (this == 0) {
				options += "<option value=\"" + this + "\">Varias</option>"
			}else {
				options += "<option value=\"" + this + "\">" + this + "</option>"
			}
		});

		$(tallas).last().html(options);
		$(tallas).last().next().html("");
		$(tallas).last().parent().next().children("input").val("");
	}
	//Asigna valores a los selectores de tallas
	function tp(el){
		var indice = el.id.substr(11,1);
		var tallas = $('[id^="talla\\[' + indice + '\\]"]');
		$(tallas).each(function(){
			if (tallas.length == 1) {
				options(el);
			}else {
				borrarTalla(indice);
				tallas.length -= 1;
			}
		})
	}
	function ts(el){
		var cantidades = <?php echo json_encode($cantidades); ?>;
		var id = $(el).parents(".card-body").children().eq(1).children().eq(1).children("select").val();
		var max = cantidades[id][el.value];
		$(el).next().html("Quedan " + max + " unidades");
		$(el).parents(".form-group").next().children().eq(2).children("input").val("");
		$(el).parents(".form-group").next().children().eq(2).children("input").attr('max',max);
	}
	//Inician las validaciones
	$(document).ready(function(){
		$(":input").change(function(e){
			$(e.target).css("background-color","");
		});
		$("#formid").on('submit', function (event) {
			var validated = true;
			var mercanciaArr = mercRep = tallaRep = [];
			var tallasArr = [];
			var p_arr = [];
			var texto = title = icon = "";
			var cuentaprod = cuentatalla = exists = 0;
			var productos = <?php echo json_encode($productos); ?>;
			$(productos).each(function(pos,producto){
				p_arr.push(producto.nombre);
			});
			//Comienzan las validaciones
			//Validando los campos numéricos
			let nums = ["precio","cantidad","monto"];
			$(nums).each(function(index,item){
				var inputs = $("input[required][name^=" + item + "]");
				inputs.each(function(i,j){
					if (isNaN(($(j).val())/1)) {
						validated = false;
						icon = 'error';
						title = 'Error';
						texto = 'Ingrese los valores correctos en los campos marcados en rojo!';
						$(j).css("background-color","lightpink");
					}
				});
			});
			//Validando productos repetidos
			$("[id^='mercancias']").each(function(index,item){
				if (item.value == "nuevo") {
					var nombre = $("#nombre\\[" + index + "\\]");
					if (!(mercanciaArr.includes(nombre.val().toLowerCase()))) {
						mercanciaArr.push(nombre.val().toLowerCase());
					}else {
						mercRep[cuentaprod] = nombre.val().toLowerCase();
						cuentaprod++;
					}
					if(p_arr.includes(nombre.val().toLowerCase())) {
						exists++;
					}
				}else {
					if (!(mercanciaArr.includes($("#mercancias\\[" + index + "\\] option:selected").text().toLowerCase()))) {
						mercanciaArr.push($("#mercancias\\[" + index + "\\] option:selected").text().toLowerCase());
					}else {
						mercRep[cuentaprod] = $("#mercancias\\[" + index + "\\] option:selected").text().toLowerCase();
						cuentaprod++;
					}
				}
				//Validación de tallas
				tallasArr[index] = [];
				$("[id^='tallas']").eq(index).find("[id^='talla']").each(function(a,b){
					if (tallasArr[index].includes(b.value)) {
						validated = false;
						icon ='warning';
						title = 'Tallas duplicadas';
						texto = "Hay tallas repetidas en alguno de los productos. Verifique las tallas en el producto " + (index + 1);
					}else {
						tallasArr[index].push(b.value);
					}
				});
			});
			if (cuentaprod && validated || exists && validated) {
				validated = false;
				icon ='warning';
				title = 'Productos duplicados';
				if (exists) {
					texto =  'Está declarando un producto nuevo que en realidad ya existe. Por favor revise las opciones.'
				}else {
					texto = 'Está declarando un mismo producto más de una vez. Por favor revise la información.';
				}
			}
			//Terminan las validaciones
			//Se muestra un alerta si hay algún problema
			if (!(validated)) {
				event.preventDefault();
				Swal.fire({
					icon: icon,
					title: title,
					text: texto,
				});
			}
		});
	});
</script>
<script src="{{ asset('js/borrar.js') }}"></script>
@endsection

@section('content')
<section>
	<article class="alert alert-custom alert-white alert-shadow fade show" role="alert">
		<h3>Ingrese los datos de la venta</h3>
	</article>
	<hr>
	<article id="product-form">
		<form method="POST" action="{{route('ventas.store')}}" id="formid">
			@csrf
			<div id="productos">
				<div class="productos card card-custom">
					<div class="card-body">
						<div class="text-center mb-5">
							<h5 class="titulotalla">Producto 1</h5>
						</div>
						<div class="form-group row">
							<div class="col-md-3">
								<label for="mercancias[0]">Seleccione un producto</label>
							</div>
							<div class="col-md-9">
								<select class="form-control" id="mercancias[0]" name="mercancias[0]" onchange="tp(this)" required>
									<option disabled selected value="">Seleccione un producto</option>
									@foreach($productos as $producto)
									<option value="{{$producto->id}}">{{$producto->nombre}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-3">
								<label for="precio[0]">Precio de venta</label>
							</div>
							<div class="col-md-9">
								<input class="form-control" type="text" id="precio" name="precio[0]" placeholder="Precio de venta" required>
								<span class="form-text text-muted">Precio de venta del producto en dólares</span>
							</div>
						</div>
						<hr>
						<div id="tallas[0]">
							<div class="text-center mb-5">
								<h4>Ingrese las tallas compradas y cantidad de cada una</h4>
							</div>
							<div class="tallas">
								<div><h5 class="titulotalla">Talla artículo 1</h5></div>
								<div class="form-group row">
									<div class="col-md-4"></div>
									<div class="col-md-3">
										<label for="talla[0][0]">Talla del producto</label>
									</div>
									<div class="col-md-5">
										<select class="form-control input-talla" type="text" id="talla[0][0]" name="talla[0][0]" onchange="ts(this)" required>
											<option disabled selected value="">Seleccione una talla</option>
										</select>
										<span class="form-text text-muted"></span>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-4"></div>
									<div class="col-md-3">
										<label for="cantidad[0][0]">Cantidad comprada</label>
									</div>
									<div class="col-md-5">
										<input class="form-control input-talla" type="number" id="cantidad[0][0]" name="cantidad[0][0]" placeholder="Cantidad comprada" min="1" required>
									</div>
								</div>
							</div>
						</div>
						<div class="row text-center">
							<div class="col-md-3"></div>
							<div class="col-md-3">
								<button type="button" class="btn btn-primary newtalla" onclick="tallas(0)">Agregar otra talla</button>
							</div>
							<div class="col-md-3">
								<button type="button" class="btn btn-danger" onclick="borrarTalla(0)" disabled="disabled">Eliminar talla</button>
							</div>
							<div class="col-md-3"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="card card-custom mt-5">
				<div class="card-body row text-center">
					<div class="col-md-6">
						<button id="nuevoproducto" type="button" class="btn btn-primary" onclick="productos(this)">Agregar otro producto</button>
					</div>
					<div class="col-md-6">
						<button type="button" class="btn btn-danger" onclick="eliminarproducto(this)" disabled="disabled">Eliminar producto</button>
					</div>
				</div>
			</div>
			<hr>
			<!--	Acá van los formularios para el pago de la compra de mercancías		-->
			<div class="alert alert-custom alert-white alert-shadow fade show" role="alert">
				<h4>Ingrese los datos de envío y pago de la venta</h4>
			</div>
			<div class="card card-custom">
				<div class="card-body row">
					<div class="col-md-3"></div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="ncliente">Nombre del cliente</label>
							<input class="form-control" type="text" id="ncliente" name="ncliente" placeholder="Nombre del cliente" required>
						</div>
						<div class="form-group">
							<label for="ccliente">Ciudad del cliente</label>
							<input class="form-control" type="text" id="ccliente" name="ccliente" placeholder="Ciudad del cliente" required>
						</div>
						<div class="form-group">
							<label for="tcliente">Teléfono del cliente (opcional)</label>
							<input class="form-control" type="text" id="tcliente" name="tcliente" placeholder="Teléfono del cliente (opcional)">
						</div>
						<div class="form-group">
							<label for="plataforma">Plataforma de contacto</label>
							<select class="form-control" id="plataforma" name="plataforma" required>
								<option disabled selected value="">Seleccione una plataforma</option>
								<option value="1">Instagram</option>
								<option value="2">Mercadolibre</option>
								<option value="3">Whatsapp</option>
								<option value="4">Otro</option>
							</select>
						</div>
						@if($promos != "[]")
						<div class="form-group">
							<label for="promoselect">¿Es parte de una promoción?</label>
							<select class="form-control" id="promoselect" name="promoselect" onchange="select('promosection',this.value)" required>
								<option value="No" selected>No</option>
								<option value="Sí">Sí</option>
							</select>
						</div>
						<div class="form-group" id="promosection">
							<label for="promo">ID de promoción</label>
							<select class="form-control" id="promo" name="promo">
								<option disabled selected value="">Seleccione una promoción</option>
								@foreach($promos as $i => $promo)
								<option value="{{$promo->id}}">{{$promo->nombre}}</option>
								@endforeach
							</select>
						</div>
						@endif
						<div class="form-group">
							<label for="envioselect">Empresa de envíos</label>
							<select class="form-control" id="envioselect" name="envioselect" required>
								<option disabled selected value="">Seleccione una empresa</option>
								<option value="MRW">MRW</option>
								<option value="Zoom">Zoom</option>
								<option value="Domesa">Domesa</option>
								<option value="Entrega en persona">Entrega en persona</option>
								<option value="Otro">Otro</option>
							</select>
						</div>
						<div class="form-group">
							<label for="pago">Forma de pago</label>
							<select class="form-control" id="pago" name="pago" onchange="select('referenciasection',this.value)" required>
								<option selected disabled value="">Seleccione un método de pago</option>
								<option value="Paypal">Paypal</option>
								<option value="AirTM">AirTM</option>
								<option value="Pagomóvil">Pagomóvil</option>
								<option value="bolivares">Efectivo bolívares</option>
								<option value="dolares">Efectivo dólares</option>
								<option value="Otro">Otro</option>
							</select>
						</div>
						<div class="form-group">
							<label for="monto">Monto total</label>
							<input class="form-control" type="text" id="monto" name="monto" placeholder="Monto total" required>
						</div>
						<div class="form-group" id="referenciasection">
							<label for="referencia">Referencia de pago</label>
							<input class="form-control" type="text" id="referencia" name="referencia" placeholder="Referencia de pago">
						</div>
						<div class="form-group">
							<label for="moneda">Moneda</label>
							<select class="form-control" id="moneda" name="moneda" required>
								<option selected disabled value="">Seleccione una moneda</option>
								<option value="Dólares">Dólares</option>
								<option value="Bolívares">Bolívares</option>
								<option value="Criptomoneda">Criptomoneda</option>
								<option value="Otro">Otro</option>
							</select>
						</div>
						<div class="form-group">
							<label for="status">Estado de la venta</label>
							<select class="form-control" id="status" name="status" onchange="select('rastreosection',this.value)" required>
								<option disabled selected value="">Seleccione un estado</option>
								<option value="Pagado">Pagado</option>
								<option value="Enviado">Enviado</option>
								<option value="Recibido">Recibido por el cliente</option>
							</select>
						</div>
						<div id="rastreosection">
							<div class="form-group">
								<label for="rastreo">Código de rastreo</label>
								<input class="form-control" type="text" id="rastreo" name="rastreo" placeholder="Código de rastreo">
							</div>
							<div class="form-group">
								<label for="gastoenvio">Gasto por envío bolívares</label>
								<input class="form-control" type="text" id="gastoenvio" name="gastoenvio" placeholder="Gasto por envío bolívares">
							</div>
						</div>
					</div>
					<div class="col-md-3"></div>
				</div>
			</div>
			<div class="card card-custom mt-5">
				<div class="card-body row text-center">
					<div class="col-md-3"></div>
					<div class="col-md-3">
						<button type="submit" class="btn btn-primary" id="submitbtn">Guardar en inventario</button>
					</div>
					<div class="col-md-3">
						<a href="{{route('inventario.index')}}" class="btn btn-danger">Cancelar</a>
					</div>
					<div class="col-md-3"></div>
				</div>
			</div>
		</form>
	</article>
</section>
@endsection