@extends('layouts.app')

@section('titulo')
Ingrese la mercancía comprada
@endsection

@section('scripts')
<script type="text/javascript">
	function select(area, option) {
		let element = document.getElementById(area);
		if (option == "nuevo") {
			element.style.display = "block";
			$(element.getElementsByTagName('input')).each(function(){
				$(this).attr("required", "required");
			});
			$(element.getElementsByTagName('textarea')).each(function(){
				$(this).attr("required", "required");
			});
		}else {
			element.style.display = "none";
			$(element.getElementsByTagName('input')).each(function(){
				$(this).removeAttr("required");
			});
			$(element.getElementsByTagName('textarea')).each(function(){
				$(this).removeAttr("required", "required");
			});
		}
	}
	//Se ingresa una nueva talla al producto
	function tallas(i){
		let t_l = $("#tallas\\[" + i + "\\] .tallas").length;		//Cantidad de tallas hasta ahora
		let t_p = ($(".productos").length) - 1;	//Cantidad de productos hasta ahora
		let t_div = $("#tallas\\[" + i + "\\]"); 			//DIV que contiene las tallas
		let form_group = "</div><div class=\"form-group row\"><div class=\"col-md-4\"></div><div class=\"col-md-3\"><label for=\"";
		let labels = "</label></div><div class=\"col-md-5\"><input class=\"input-talla form-control\" type=\"text\" id=\"";
		var nueva = '<div class=\"tallas\"><div><h5 class=\"titulotalla\">Talla artículo '
			+ (t_l + 1)
			+ '</h5>' + form_group + 'talla['
			+ i + '][' + t_l
			+ ']\">Talla del producto' + labels + 'talla['
			+ i + '][' + t_l
			+ ']\" name=\"talla['
			+ i + '][' + t_l
			+ ']\" placeholder=\"Talla del producto\" required></div>' + form_group + 'cantidad['
			+ i + '][' + t_l
			+ ']\">Cantidad comprada</label></div><div class=\"col-md-5\"><input class=\"input-talla form-control\" type=\"number\" id=\"cantidad['
			+ i + '][' + t_l
			+ ']\" name=\"cantidad['
			+ i + '][' + t_l
			+ ']\" placeholder=\"Cantidad comprada\" min=\"1\" required></div>' + form_group + 'unidad['
			+ i + '][' + t_l
			+ ']\">Precio por unidad' + labels + 'unidad['
			+ i + '][' + t_l
			+ ']\" name=\"unidad['
			+ i + '][' + t_l
			+ ']\" placeholder=\"Precio por unidad\" required></div></div></div>';

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
			$("#tallas\\["+i+"\\]").next().children().eq(2).children().first().removeAttr("disabled");
		}
	}
	//Se ingresa un producto nuevo
	function productos(el){
		let t_l = $(".productos").length;		//Cantidad de tallas
		let t_div = $("#productos"); 			//DIV que contiene los productos
		let form_group = "<div class=\"form-group row\"><div class=\"col-md-3\"><label for=\"";
		var optionsprod = optionsprov = "";
		var productos = <?php echo json_encode($productos); ?>;
		var proveedores = <?php echo json_encode($proveedores); ?>;
		$(productos).each(function(){
			optionsprod += "<option value=\"" + this.id + "\">" + this.nombre + "</option>"
		});
		$(proveedores).each(function(){
			optionsprov += "<option value=\"" + this.id + "\">" + this.nombre + "</option>"
		});
		var nuevo = "<div class=\"productos card card-custom\"><div class=\"card-body\"><div class=\"text-center mb-5\"><h5 class=\"titulotalla\">Producto "
			+ (t_l + 1)
			+ "</h5></div>" + form_group + "mercancias["
			+ t_l
			+ "]\">Seleccione un producto</label></div><div class=\"col-md-9\"><select class=\"form-control\" id=\"mercancias["
			+ t_l
			+ "]\" onchange=\"select('productonuevo["
			+ t_l
			+ "]', this.value)\" name=\"mercancias["
			+ t_l
			+ "]\" required><option disabled selected value=\"\">Seleccione un producto</option>"
			+ optionsprod
			+ "<option value=\"nuevo\">Producto nuevo</option></select></div></div><div id=\"productonuevo["
			+ t_l
			+ "]\"><div><h4>Ingrese los detalles del producto nuevo</h4></div>" + form_group + "codigo["
			+ t_l
			+ "]\">Código del producto</label></div><div class=\"col-md-9\"><input class=\"form-control\" type=\"text\" id=\"codigo["
			+ t_l
			+ "]\" name=\"codigo["
			+ t_l
			+ "]\" placeholder=\"Código del producto\"></div></div>" + form_group + "nombre["
			+ t_l
			+ "]\">Nombre del producto</label></div><div class=\"col-md-9\"><input class=\"form-control\" type=\"text\" id=\"nombre["
			+ t_l
			+ "]\" name=\"nombre["
			+ t_l
			+ "]\" placeholder=\"Nombre del producto\"></div></div>" + form_group + "descripcion["
			+ t_l
			+ "]\">Descripción del producto</label></div><div class=\"col-md-9\"><textarea class=\"form-control\" name=\"descripcion["
			+ t_l
			+ "]\" id=\"descripcion["
			+ t_l
			+ "]\" placeholder=\"Descripción del producto\"></textarea></div></div><div class=\"form-group row\"><div class=\"col-md-3\"></div><div class=\"col-md-9\"><div class=\"form-group\" id=\"imageinput\"><div></div><div class=\"custom-file mt-8\"><input class=\"custom-file-input\" type=\"file\" id=\"imagen["
			+ t_l
			+ "]\" name=\"imagen[]\" accept=\"image/x-png,image/gif,image/jpeg\"><label class=\"custom-file-label\" for=\"imagen["
			+ t_l
			+ "]\">Imagen del producto</label></div></div></div></div></div>" + form_group + "proveedorselect["
			+ t_l
			+ "]\">Proveedor</label></div><div class=\"col-md-9\"><select class=\"form-control\" id=\"proveedorselect["
			+ t_l
			+ "]\" onchange=\"select('proveedornuevo["
			+ t_l
			+ "]', this.value)\" name=\"proveedorselect["
			+ t_l
			+ "]\" required><option disabled selected value=\"\">Seleccione un proveedor</option>"
			+ optionsprov								
			+ "<option value=\"nuevo\">Proveedor nuevo</option></select></div></div><div id=\"proveedornuevo["
			+ t_l
			+ "]\">" + form_group + "proveedorname["
			+ t_l
			+ "]\">Nombre del proveedor nuevo</label></div><div class=\"col-md-9\"><input class=\"form-control\" type=\"text\" id=\"proveedorname["
			+ t_l
			+ "]\" name=\"proveedor["
			+ t_l
			+ "]\" placeholder=\"Nombre del proveedor nuevo\"></div></div>" + form_group + "url["
			+ t_l
			+ "]\">Enlace a tienda del proveedor nuevo</label></div><div class=\"col-md-9\"><input class=\"form-control\" type=\"text\" name=\"url["
			+ t_l
			+ ']\" id=\"url['
			+ t_l
			+ "]\" placeholder=\"Enlace a tienda del proveedor nuevo\"></div></div></div>" + form_group + "precio[0]\">Precio de venta</label></div><div class=\"col-md-9\"><input class=\"form-control\" type=\"text\" id=\"precio\" name=\"precio["
			+ t_l
			+ "]\" placeholder=\"Precio de venta\" required></div></div><hr><div id=\"tallas["
			+ t_l
			+ "]\"><div><h4>Ingrese las tallas compradas y cantidad de cada una</h4></div><div class=\"tallas\"><div><h5 class=\"titulotalla\">Talla artículo 1</h5></div><div class=\"form-group row\"><div class=\"col-md-4\"></div><div class=\"col-md-3\"><label for=\"talla["
			+ t_l
			+ "][0]\">Talla del producto</label></div><div class=\"col-md-5\"><input class=\"input-talla form-control\" type=\"text\" id=\"talla["
			+ t_l
			+ "][0]\" name=\"talla["
			+ t_l
			+ "][0]\" placeholder=\"Talla del producto\" required></div></div><div class=\"form-group row\"><div class=\"col-md-4\"></div><div class=\"col-md-3\"><label for=\"cantidad["
			+ t_l
			+ "][0]\">Cantidad comprada</label></div><div class=\"col-md-5\"><input class=\"input-talla form-control\" type=\"number\" id=\"cantidad["
			+ t_l
			+ "][0]\" name=\"cantidad["
			+ t_l
			+ "][0]\" placeholder=\"Cantidad comprada\" min=\"1\" required></div></div><div class=\"form-group row\"><div class=\"col-md-4\"></div><div class=\"col-md-3\"><label for=\"unidad["
			+ t_l
			+ "][0]\">Precio por unidad</label></div><div class=\"col-md-5\"><input class=\"input-talla form-control\" type=\"text\" id=\"unidad["
			+ t_l
			+ "][0]\" name=\"unidad["
			+ t_l
			+ "][0]\" placeholder=\"Precio por unidad\" required></div></div></div></div><div class=\"row text-center\"><div class=\"col-md-3\"></div><div class=\"col-md-3\"><button type=\"button\" class=\"btn btn-primary newtalla\" onclick=\"tallas("
			+ t_l
			+ ")\">Agregar otra talla</button></div><div class=\"col-md-3\"><button type=\"button\" class=\"btn btn-danger\" onclick=\"borrarTalla("
			+ t_l
			+ ")\" disabled=\"disabled\">Eliminar talla</button></div><div class=\"col-md-3\"></div></div></div><hr></div>";

		t_div.append(nuevo);
		console.log(nuevo);
		$("select").select2();
		$(el).parent().next().children().eq(0).removeAttr("disabled");
	}
	//Inician las validaciones
	$(document).ready(function(){
		$("select").select2();
		$(".menu-item.menu-item-submenu").eq(2).addClass("menu-item-here");
		$(":input").change(function(e){
			$(e.target).css("background-color","");
		});
		$("#formid").on('submit', function (event) {
			var validated = true;
			var allowedExtensions = ['png', 'jpg', 'jpeg', 'gif', 'bmp'];
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
			let nums = ["precio","talla","cantidad","unidad","monto"];
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
			//Validando imágenes
			if ($("input[type=file][required]").length > 0 && validated) {
				var c_err = 0;
				$("input[type=file][required]").each(function(index,item){
					var extension = $(item).val().substr($(item).val().lastIndexOf('.') + 1).toLowerCase();
					if (allowedExtensions.indexOf(extension) === -1) {
						c_err++;
						$(item).css("background-color","lightpink");
						validated = false;
					}
					if ($(item)[0].files[0].size > 1870848) {
						validated = false;
						icon = 'error';
						title = 'Tamaño de imagen inválido';
						texto = 'Solo se admiten imágenes que pesen menos de 2MB.';
					}
				});
				if (c_err) {
					var c_prod = "";
					c_err > 1 ? c_prod = " productos nuevos" : c_prod = " producto nuevo";
					icon = 'error';
					title = 'Formato de imagen inválido en ' + c_err + c_prod;
					texto = 'Solo se admiten imágenes en png, jpg, gif y bmp.';
				}
			}
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
	<article class="alert alert-custom alert-white alert-shadow fade show" role="alert">
		<h3>Ingrese los datos de la mercancía nueva</h3>
	</article>
	<hr>
	<article id="product-form">
		<form method="POST" action="{{route('compras.store')}}" enctype="multipart/form-data" id="formid">
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
								<select class="form-control" id="mercancias[0]" onchange="select('productonuevo[0]', this.value)" name="mercancias[0]" required>
									<option disabled selected value="">Seleccione un producto</option>
									@foreach($productos as $producto)
									<option value="{{$producto->id}}">{{$producto->nombre}}</option>
									@endforeach
									<option value="nuevo">Producto nuevo</option>
								</select>
							</div>
						</div>
						<div id="productonuevo[0]">
							<div><h4>Ingrese los detalles del producto nuevo</h4></div>
							<div class="form-group row">
								<div class="col-md-3">
									<label for="codigo[0]">Código del producto</label>
								</div>
								<div class="col-md-9">
									<input class="form-control" type="text" id="codigo[0]" name="codigo[0]" placeholder="Código del producto">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-3">
									<label for="nombre[0]">Nombre del producto</label>
								</div>
								<div class="col-md-9">
									<input class="form-control" type="text" id="nombre[0]" name="nombre[0]" placeholder="Nombre del producto">
								</div>
							</div>
								<div class="form-group row">
									<div class="col-md-3">
										<label for="descripcion[0]">Descripción del producto</label>
									</div>
									<div class="col-md-9">
										<textarea class="form-control" name="descripcion[0]" id="descripcion[0]" placeholder="Descripción del producto"></textarea>
									</div>
							</div>
							<div class="form-group row">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<div class="form-group" id="imageinput">
										<div></div>
										<div class="custom-file mt-8">
											<input class="custom-file-input" type="file" id="imagen[0]" name="imagen[]" accept="image/x-png,image/gif,image/jpeg">
											<label class="custom-file-label" for="imagen[0]">Imagen del producto</label>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-3">
								<label for="proveedorselect[0]">Proveedor</label>
							</div>
							<div class="col-md-9">
								<select class="form-control" id="proveedorselect[0]" onchange="select('proveedornuevo[0]', this.value)" name="proveedorselect[0]" required>
									<option disabled selected value="">Seleccione un proveedor</option>
									@foreach($proveedores as $proveedor)
									<option value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
									@endforeach
									<option value="nuevo">Proveedor nuevo</option>
								</select>
							</div>
						</div>
						<div id="proveedornuevo[0]">
							<div class="form-group row">
								<div class="col-md-3">
									<label for="proveedorname[0]">Nombre del proveedor nuevo</label>
								</div>
								<div class="col-md-9">
									<input class="form-control" type="text" id="proveedorname[0]" name="proveedor[0]" placeholder="Nombre del proveedor nuevo">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-3">
									<label for="url[0]">Enlace a tienda del proveedor nuevo</label>
								</div>
								<div class="col-md-9">
									<input class="form-control" type="text" name="url[0]" id="url[0]" placeholder="Enlace a tienda del proveedor nuevo">
								</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-3">
								<label for="precio[0]">Precio de venta</label>
							</div>
							<div class="col-md-9">
								<input class="form-control" type="text" id="precio" name="precio[0]" placeholder="Precio de venta" required>
							</div>
						</div>
						<hr>
						<div id="tallas[0]">
							<div><h4>Ingrese las tallas compradas y cantidad de cada una</h4></div>
							<div class="tallas">
								<div><h5 class="titulotalla">Talla artículo 1</h5></div>
								<div class="form-group row">
									<div class="col-md-4"></div>
									<div class="col-md-3">
										<label for="talla[0][0]">Talla del producto</label>
									</div>
									<div class="col-md-5">
										<input class="input-talla form-control" type="text" id="talla[0][0]" name="talla[0][0]" placeholder="Talla del producto" required>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-4"></div>
									<div class="col-md-3">
										<label for="cantidad[0][0]">Cantidad comprada</label>
									</div>
									<div class="col-md-5">
										<input class="input-talla form-control" type="number" id="cantidad[0][0]" name="cantidad[0][0]" placeholder="Cantidad comprada" min="1" required>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-4"></div>
									<div class="col-md-3">
										<label for="unidad[0][0]">Precio por unidad</label>
									</div>
									<div class="col-md-5">
										<input class="input-talla form-control" type="text" id="unidad[0][0]" name="unidad[0][0]" placeholder="Precio por unidad" required>
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
					<hr>
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
				<h4>Ingrese los datos de envío y pago de mercancías</h4>
			</div>
			<div class="card card-custom">
				<div class="card-body row">
					<div class="col-md-3"></div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="casilleroselect">Casillero en Miami</label>
							<select class="form-control" id="casilleroselect" onchange="select('casilleronuevo', this.value)" name="casilleroselect" required>
								<option disabled selected value="">Seleccione un casillero</option>
								@foreach($carriers as $carrier)
								<option value="{{$carrier->id}}">{{$carrier->nombre}}: {{$carrier->casillero}}</option>
								@endforeach
								<option value="nuevo">Casillero nuevo</option>
							</select>
							<div id="casilleronuevo">
								<div class="form-group">
									<label for="carriername">Nombre de la empresa de envíos</label>
									<input class="form-control" type="text" id="carriername" name="carriername" placeholder="Nombre de la empresa de envíos">
								</div>
								<div class="form-group">
									<label for="casillero">Dirección del casillero</label>
									<input class="form-control" type="text" name="casillero" id="casillero" placeholder="Dirección del casillero">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="pago">Plataforma de pago</label>
							<select class="form-control" id="pago" name="pago" required>
								<option selected disabled value="">Seleccione un método de pago</option>
								<option value="Paypal">Paypal</option>
								<option value="Tarjeta de crédito/débito">Tarjeta de crédito/débito</option>
								<option value="Otro">Otro</option>
							</select>
						</div>
						<div class="form-group">
							<label for="monto">Monto pagado</label>
							<input class="form-control" type="text" id="monto" name="monto" placeholder="Monto pagado" required>
						</div>
						<div class="form-group">
							<label for="referencia">Referencia de pago</label>
							<input class="form-control" type="text" id="referencia" name="referencia" placeholder="Referencia de pago" required>
						</div>
						<div class="form-group">
							<label for="moneda">Moneda</label>
							<select class="form-control" id="moneda" name="moneda" required>
								<option selected disabled value="">Seleccione una moneda</option>
								<option value="Dólares">Dólares</option>
								<option value="Criptomoneda">Criptomoneda</option>
								<option value="Otro">Otro</option>
							</select>
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