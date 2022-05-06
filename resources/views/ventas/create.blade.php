@extends('layouts.app')

@section('styles')
<style type="text/css">
	#promosection, #rastreosection, #referenciasection {
		display: none;
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
			+ '</h5></div>' + form_group + 'talla['
			+ i + '][' + t_l
			+ ']\">Talla del producto</label><select class=\"input-talla\" type=\"text\" id=\"talla['
			+ i + '][' + t_l
			+ ']\" name=\"talla['
			+ i + '][' + t_l
			+ ']\" onchange=\"ts(this)\" required><option disabled selected value=\"\">Seleccione una talla</option></select><span></span></div>' + form_group + 'cantidad['
			+ i + '][' + t_l
			+ ']\">Cantidad comprada</label><input class=\"input-talla\" type=\"number\" id=\"cantidad['
			+ i + '][' + t_l
			+ ']\" name=\"cantidad['
			+ i + '][' + t_l
			+ ']\" placeholder=\"Cantidad comprada\" min=\"1\" required></div>' + form_group + 'unidad['
			+ i + '][' + t_l
			+ ']\">';

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
			$(".newtalla").eq(i).siblings().removeAttr("disabled");
			options(document.getElementById("mercancias["+i+"]"));
		}
	}
	//Se elimina la última talla ingresada
	function borrarTalla(i){
		let t = $("#tallas\\[" + i + "\\] .tallas")
		let t_l = t.length;
		let botonEliminar = $(".newtalla").eq(i).siblings();
		if (t_l > 1) {
			t.eq(t_l-1).remove();
			t_l == 2 ? botonEliminar.attr("disabled","disabled") : botonEliminar.removeAttr("disabled");
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
		var nuevo = "<div class=\"productos\"><div><h5 class=\"titulotalla\">Producto"
			+ (t_l + 1)
			+ "</h5></div>"
			+ form_group + "mercancias["
			+ t_l
			+ "]\">Seleccione un producto</label><select id=\"mercancias["
			+ t_l
			+ "]\" name=\"mercancias["
			+ t_l
			+ "]\" onchange=\"tp(this)\" required><option disabled selected value=\"\">Seleccione un producto</option>"
			+ optionsprod
			+ "</select></div>"
			+ form_group + "precio["
			+ t_l
			+ "]\">Precio de venta</label><input type=\"text\" id=\"precio\" name=\"precio["
			+ t_l
			+ "]\" placeholder=\"Precio de venta\" required></div><hr><div id=\"tallas["
			+ t_l
			+ "]\"><div><h4>Ingrese las tallas compradas y cantidad de cada una</h4></div><div class=\"tallas\"><div><h5 class=\"titulotalla\">Talla artículo 1</h5></div>"
			+ form_group + "talla["
			+ t_l
			+ "][0]\">Talla del producto</label><select class=\"input-talla\" type=\"text\" id=\"talla["
			+ t_l
			+ "][0]\" name=\"talla["
			+ t_l
			+ "][0]\" onchange=\"ts(this)\" required><option disabled selected value=\"\">Seleccione una talla</option></select><span></span></div>"
			+ form_group + "cantidad["
			+ t_l
			+ "][0]\">Cantidad comprada</label><input class=\"input-talla\" type=\"number\" id=\"cantidad["
			+ t_l
			+ "][0]\" name=\"cantidad["
			+ t_l
			+ "][0]\" placeholder=\"Cantidad comprada\" min=\"1\" required></div></div></div><div><button type=\"button\" class=\"btn btn-primary newtalla\" onclick=\"tallas("
			+ t_l
			+ ")\">Agregar otra talla</button><button type=\"button\" class=\"btn btn-danger\" onclick=\"borrarTalla("
			+ t_l
			+ ")\" disabled=\"disabled\">Eliminar talla</button></div><hr></div>";

		t_div.append(nuevo);

		$(el).next().removeAttr("disabled");
	}
	//Se elimina el último producto ingresado
	function eliminarproducto(el){
		let p = $(".productos");
		let p_l = p.length;
		if (p_l > 1) {
			if (p_l == 2) {
				$(el).attr("disabled", "disabled");
			}
			p.eq(p_l-1).remove();
		}
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
		var id = $(el).parents(".productos").children().eq(1).children("select").val();
		var max = cantidades[id][el.value];
		$(el).next().html("Quedan " + max + " unidades");
		$(el).parent().next().children("input").val("");
		$(el).parent().next().children("input").attr('max',max);
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
@endsection

@section('content')
<section>
	<article>
		<h3>Ingrese los datos de la venta</h3>
		<h4>Ingrese la mercancía vendida</h4>
	</article>
	<hr>
	<article id="product-form">
		<form method="POST" action="{{route('ventas.store')}}" id="formid">
			@csrf
			<div id="productos">
				<div class="productos">
					<div><h5 class="titulotalla">Producto 1</h5></div>
					<div class="form-group">
						<label for="mercancias[0]">Seleccione un producto</label>
						<select id="mercancias[0]" name="mercancias[0]" onchange="tp(this)" required>
							<option disabled selected value="">Seleccione un producto</option>
							@foreach($productos as $producto)
							<option value="{{$producto->id}}">{{$producto->nombre}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="precio[0]">Precio de venta</label>
						<input type="text" id="precio" name="precio[0]" placeholder="Precio de venta" required>
					</div>
					<hr>
					<div id="tallas[0]">
						<div><h4>Ingrese las tallas compradas y cantidad de cada una</h4></div>
						<div class="tallas">
							<div><h5 class="titulotalla">Talla artículo 1</h5></div>
							<div class="form-group">
								<label for="talla[0][0]">Talla del producto</label>
								<select class="input-talla" type="text" id="talla[0][0]" name="talla[0][0]" onchange="ts(this)" required>
									<option disabled selected value="">Seleccione una talla</option>
								</select>
								<span></span>
							</div>
							<div class="form-group">
								<label for="cantidad[0][0]">Cantidad comprada</label>
								<input class="input-talla" type="number" id="cantidad[0][0]" name="cantidad[0][0]" placeholder="Cantidad comprada" min="1" required>
							</div>
						</div>
					</div>
					<div>
						<button type="button" class="btn btn-primary newtalla" onclick="tallas(0)">Agregar otra talla</button>
						<button type="button" class="btn btn-danger" onclick="borrarTalla(0)" disabled="disabled">Eliminar talla</button>
					</div>
					<hr>
				</div>
			</div>
			<div>
				<button id="nuevoproducto" type="button" class="btn btn-primary" onclick="productos(this)">Agregar otro producto</button>
				<button type="button" class="btn btn-danger" onclick="eliminarproducto(this)" disabled="disabled">Eliminar producto</button>
			</div>
			<hr>
			<!--	Acá van los formularios para el pago de la compra de mercancías		-->
			<div><h4>Ingrese los datos de envío y pago de la venta</h4></div>
			<div>
				<div class="form-group">
					<label for="ncliente">Nombre del cliente</label>
					<input type="text" id="ncliente" name="ncliente" placeholder="Nombre del cliente" required>
				</div>
				<div class="form-group">
					<label for="ccliente">Ciudad del cliente</label>
					<input type="text" id="ccliente" name="ccliente" placeholder="Ciudad del cliente" required>
				</div>
				<div class="form-group">
					<label for="tcliente">Teléfono del cliente (opcional)</label>
					<input type="text" id="tcliente" name="tcliente" placeholder="Teléfono del cliente (opcional)">
				</div>
				<div class="form-group">
					<label for="plataforma">Plataforma de contacto</label>
					<select id="plataforma" name="plataforma" required>
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
					<select id="promoselect" name="promoselect" onchange="select('promosection',this.value)" required>
						<option value="No" selected>No</option>
						<option value="Sí">Sí</option>
					</select>
				</div>
				<div class="form-group" id="promosection">
					<label for="promo">ID de promoción</label>
					<select id="promo" name="promo">
						<option disabled selected value="">Seleccione una promoción</option>
						@foreach($promos as $i => $promo)
						<option value="{{$promo->id}}">"{{$promo->nombre}}"</option>
						@endforeach
					</select>
				</div>
				@endif
				<div class="form-group">
					<label for="envioselect">Empresa de envíos</label>
					<select id="envioselect" name="envioselect" required>
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
					<select id="pago" name="pago" onchange="select('referenciasection',this.value)" required>
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
					<input type="text" id="monto" name="monto" placeholder="Monto total" required>
				</div>
				<div class="form-group" id="referenciasection">
					<label for="referencia">Referencia de pago</label>
					<input type="text" id="referencia" name="referencia" placeholder="Referencia de pago">
				</div>
				<div class="form-group">
					<label for="moneda">Moneda</label>
					<select id="moneda" name="moneda" required>
						<option selected disabled value="">Seleccione una moneda</option>
						<option value="Dólares">Dólares</option>
						<option value="Bolívares">Bolívares</option>
						<option value="Criptomoneda">Criptomoneda</option>
						<option value="Otro">Otro</option>
					</select>
				</div>
				<div class="form-group">
					<label for="status">Estado de la venta</label>
					<select id="status" name="status" onchange="select('rastreosection',this.value)" required>
						<option disabled selected value="">Seleccione un estado</option>
						<option value="Pagado">Pagado</option>
						<option value="Enviado">Enviado</option>
						<option value="Recibido">Recibido por el cliente</option>
					</select>
				</div>
				<div id="rastreosection">
					<div class="form-group">
						<label for="rastreo">Código de rastreo</label>
						<input type="text" id="rastreo" name="rastreo" placeholder="Código de rastreo">
					</div>
					<div class="form-group">
						<label for="gastoenvio">Gasto por envío bolívares</label>
						<input type="text" id="gastoenvio" name="gastoenvio" placeholder="Gasto por envío bolívares">
					</div>
				</div>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary" id="submitbtn">Guardar en inventario</button>
				<a href="{{route('inventario.index')}}" class="btn btn-danger">Cancelar</a>
			</div>
		</form>
	</article>
</section>
@endsection