@extends('layouts.app')

@section('titulo')
Base de datos
@endsection

@section('scripts')
<script type="text/javascript">
	function respaldar(){
		$.ajax({
			url: '/respaldar',
			type : 'get',
			data : {
				'accion': 'respaldar',
			},
			success : function(response){
				if (response == "Ocurrió un error") {
					Swal.fire({
						icon: 'warning',
						title: response,
					});
				}else {
					Swal.fire({
						icon: 'success',
						title: 'Archivo creado y descargado existosamente!',
					});
				}
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
</script>
@endsection

@section('content')
<section class="card card-custom">
	<article class="card-header">
		<h3 class="card-title">
			Respaldo de la base de datos
		</h3>
	</article>
	<article class="card-body">
		<div class="text-center">
			<p>Puede descargar una copia de la base de datos en un archivo .sql</p>
			<p>El archivo se descargará con el nombre:</p>
			<p><strong>backup-año-mes-día_hora:minutos:segundos.sql</strong></p>
			<p>en la carpeta donde su navegador guarda sus descargas.</p>
		</div>
		<div class="mt-8 text-center">
			<p>Haga click en el botón de abajo para iniciar la descarga (aprox. 50KB)</p>
			<a class="btn btn-outline-info" href="/respaldar">Guardar respaldo</a>
		</div>
	</article>
</section>
@endsection