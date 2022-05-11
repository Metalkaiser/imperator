@extends('layouts.app')

@section('scripts')
<script type="text/javascript">
	function crear() {
		let form_group_label = "<div class=\"form-group\"><label for=\"";
		(async () => {
			const { value: formValues } = await Swal.fire({
				title: 'Crear una promoción',
				showCancelButton: true,
				confirmButtonText: 'Guardar',
				cancelButtonText: 'Cancelar',
				showLoaderOnConfirm: true,
				allowOutsideClick: () => !Swal.isLoading(),
				html:
				    "<div>" + form_group_label + "codigo\">Código de la promoción</label><input type=\"text\" id=\"codigo\" placeholder=\"Código de la promoción\"></div>" + form_group_label + "nombre\">Nombre de la promoción</label><input type=\"text\" id=\"nombre\" placeholder=\"Nombre de la promoción\"></div>" + form_group_label + "descripcion\">Descripción de la promoción</label><textarea id=\"descripcion\" placeholder=\"Descripción de la promoción\"></textarea></div>" + form_group_label + "inicio\">Fecha de inicio</label><input type=\"date\" id=\"inicio\" placeholder=\"Fecha de inicio\"></div>" + form_group_label + "fin\">Fecha de finalización</label><input type=\"date\" id=\"fin\" placeholder=\"Fecha de finalización\"></div></div>",
				
				preConfirm: () => {
					return {
						'codigo': $('#codigo').val(),
						'nombre': $('#nombre').val(),
						'descripcion': $('#descripcion').val(),
						'inicio': $('#inicio').val(),
						'fin': $('#fin').val()
					}
				}
			})

			if (formValues) {
				var alignmid = "</th><th class=\"align-middle\">";
				var desc = "";
				if (formValues['descripcion'] == "") {
					desc = "Sin descripción";
				}else {
					desc = formValues['descripcion'];
				}
				$.ajax({
					headers: {
						'X-CSRF-TOKEN': "{{csrf_token()}}",
					},
					url: '/promociones/crear',
					dataType : 'json',
					type : 'post',
					data : {
						'codigo': formValues['codigo'],
						'nombre': formValues['nombre'],
						'descripcion': formValues['descripcion'],
						'inicio': formValues['inicio'],
						'fin': formValues['fin']
					},
					success : function(response){
						console.log(response);
                        Swal.fire({
							icon: 'success',
							title: 'Promoción creada exitosamente',
						});
						$("#listado").append(
							"<tr><th class=\"text-center\">"
							+ response['codigo'] + alignmid + response['nombre'] + alignmid + desc + alignmid + response['inicio'] + alignmid + response['fin'] + "</th></tr>"
							);
	                   },
	                   error : function(xhr,status,error){
	                       Swal.fire({
							icon: 'warning',
							title: 'Error',
							text: "Error " + xhr.status + ": " + error,
						});
	                   },
				});
			}
		})();
	}
</script>
@endsection

@section('content')
<section>
	<article>
		<div>
			<a href="/" class="btn btn-outline-danger">Volver atrás</a>
		</div>
		<div>
			<button class="btn btn-outline-primary" type="button" onclick="crear()">+ Crear una promoción</button>
		</div>
	</article>
	@if(count($promos) == 0)
	<article>
		<h3>No hay promociones registradas en la base de datos</h3>
		<h3>Puedes crear una promoción para empezar</h3>
	</article>
	@endif
</section>
<section>
	<article>
		<table class="table table-hover table-sm">
			<thead>
				<tr>
					<th scope="col">Código de la promoción</th>
					<th scope="col">Nombre de la promoción</th>
					<th scope="col">Descripción</th>
					<th scope="col">Fecha de inicio</th>
					<th scope="col">Fecha de finalización</th>
				</tr>
			</thead>
			<tbody id="listado">
				@foreach($promos as $promo)
				<tr>
					<th class="text-center">{{$promo->codigo}}</th>
					<th class="align-middle">{{$promo->nombre}}</th>
					<th class="align-middle">
						@if($promo->descripcion == "")
						Sin descripción
						@else
						{{$promo->descripcion}}
						@endif
					</th>
					<th class="align-middle">{{$promo->inicio}}</th>
					<th class="align-middle">{{$promo->fin}}</th>
				</tr>
				@endforeach
			</tbody>
		</table>
	</article>
	<article>
		{{ $promos->links() }}
	</article>
</section>
@endsection