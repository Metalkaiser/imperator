@extends('layouts.app')

@section('titulo')
Promociones
@endsection

@section('styles')
<style type="text/css">
	.swal-height {
		height: 80vh;
		width: 90%;
	}
	#swal2-html-container {
		max-height: 90%;
	}
</style>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/pages/crud/ktdatatable/base/html-table.js') }}"></script>
<script type="text/javascript">
	function crear() {
		let form_group_label = "<div class=\"form-group\"><label for=\"";
		(async () => {
			const { value: formValues } = await Swal.fire({
				title: 'Crear una promoción',
				customClass: 'swal-height',
				showCancelButton: true,
				confirmButtonText: 'Guardar',
				cancelButtonText: 'Cancelar',
				showLoaderOnConfirm: true,
				allowOutsideClick: () => !Swal.isLoading(),
				html:
				    "<div>" + form_group_label + "codigo\">Código de la promoción</label><br><input type=\"text\" id=\"codigo\" placeholder=\"Código de la promoción\"></div>" + form_group_label + "nombre\">Nombre de la promoción</label><br><input type=\"text\" id=\"nombre\" placeholder=\"Nombre de la promoción\"></div>" + form_group_label + "descripcion\">Descripción de la promoción</label><br><textarea id=\"descripcion\" placeholder=\"Descripción de la promoción\"></textarea></div>" + form_group_label + "inicio\">Fecha de inicio</label><br><input type=\"date\" id=\"inicio\" placeholder=\"Fecha de inicio\"></div>" + form_group_label + "fin\">Fecha de finalización</label><br><input type=\"date\" id=\"fin\" placeholder=\"Fecha de finalización\"></div></div>",
				
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
	$(document).ready(function(){
		$(".menu-item.menu-item-submenu").eq(1).addClass("menu-item-here");
	});
</script>
@endsection

@section('content')
<section>
	<div class="alert alert-custom alert-white alert-shadow gutter-b" role="alert">
		<div class="alert-text">
			<p>
				A continuación, una lista de las promociones y concursos que se han hecho hasta hoy.
			</p>
			<p>Puede crear una nueva promoción o concurso con el botón de abajo:</p>

			<button class="btn btn-outline-primary" type="button" onclick="crear()">+ Crear una promoción</button>
		</div>
	</div>
	<article>
		<div>
			
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
	<div class="card card-custom">
		<div class="card-header flex-wrap border-0 pt-6 pb-0">
			<div class="card-title">
				<h3 class="card-label"></h3>
			</div>
			<div class="card-toolbar">
				<!--div class="dropdown dropdown-inline mr-2">
					<button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="svg-icon svg-icon-md">
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<rect x="0" y="0" width="24" height="24"/>
									<path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3"/>
									<path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000"/>
								</g>
							</svg>
						</span>
						Export
					</button>
					<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
						<ul class="navi flex-column navi-hover py-2">
							<li class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2">
						        Elige una opción:
						    </li>
							<li class="navi-item">
								<a href="#" class="navi-link">
									<span class="navi-icon"><i class="la la-file-excel-o"></i></span>
									<span class="navi-text">Excel</span>
								</a>
							</li>
							<li class="navi-item">
								<a href="#" class="navi-link">
									<span class="navi-icon"><i class="la la-file-pdf-o"></i></span>
									<span class="navi-text">PDF</span>
								</a>
							</li>
						</ul>
					</div>
				</div-->
			</div>
		</div>
		<div class="card-body">
			<!--div class="mb-7">
				<div class="row align-items-center">
					<div class="col-lg-9 col-xl-8">
						<div class="row align-items-center">
							<div class="col-md-4 my-2 my-md-0">
								<div class="input-icon">
									<input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query" />
									<span>
										<i class="flaticon2-search-1 text-muted"></i>
									</span>
								</div>
							</div>
							<div class="col-md-4 my-2 my-md-0">
								<div class="d-flex align-items-center">
									<label class="mr-3 mb-0 d-none d-md-block">Status:</label>
									<select class="form-control" id="kt_datatable_search_status">
										<option value="">All</option>
										<option value="1">Pending</option>
										<option value="2">Delivered</option>
										<option value="3">Canceled</option>
										<option value="4">Success</option>
										<option value="5">Info</option>
										<option value="6">Danger</option>
									</select>
								</div>
							</div>
							<div class="col-md-4 my-2 my-md-0">
								<div class="d-flex align-items-center">
									<label class="mr-3 mb-0 d-none d-md-block">Type:</label>
									<select class="form-control" id="kt_datatable_search_type">
										<option value="">All</option>
										<option value="1">Online</option>
										<option value="2">Retail</option>
										<option value="3">Direct</option>
									</select>
								</div>
							</div>
			            </div>
					</div>
					<div class="col-lg-3 col-xl-4 mt-5 mt-lg-0">
						<a href="#" class="btn btn-light-primary px-6 font-weight-bold">
							Search
						</a>
					</div>
				</div>
			</div-->
			<table class="table table-hover table-responsive-md">
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
		</div>
	</div>
	<article>
	</article>
	<article>
		{{ $promos->links() }}
	</article>
</section>
@endsection