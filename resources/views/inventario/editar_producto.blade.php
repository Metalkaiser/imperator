@extends('layouts.app')

@section('titulo')
Editando: {{$producto->nombre}}
@endsection

@section('styles')
<style type="text/css">
	#imageinput {
		display: none;
	}
</style>
@endsection

@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$("#imageselect").change(function(){
			if ($(this).val() == "si") {
				$("#imageinput").show();
				$("#imageinput :input").attr('required','required');
			}else {
				$("#imageinput").hide();
				$("#imageinput :input").removeAttr('required');
			}
		});
	});

</script>
@endsection

@section('content')
<section class="row ">
	<article class="col-md-6 text-center" style="position: relative;">
		<div style="margin: 0; position: absolute; top: 50%; transform: translateY(-50%);">
			<img src="<?php echo asset('imagenes/' . $producto->nombre) . '.jpg'; ?>" alt="{{$producto->nombre}}" style="width: 80%;">
		</div>
	</article>
	<article class="col-md-6 text-center card card-custom">
		<div class="card-header">
			<h3 class="card-title">Edite la información que desee cambiar:</h3>
		</div>
		<form action="{{route('inventario.update',$producto->id)}}" method="POST" enctype="multipart/form-data" class="card-body">
			@csrf
			@method('put')
			<div>
				<div class="form-group">
					<label for="codigo">Código</label>
					<br>
					<input class="form-control" type="text" id="codigo" name="codigo" placeholder="Código" value="{{$producto->codigo}}" required>
				</div>
				<div class="form-group">
					<label for="nombre">Nombre del producto</label>
					<br>
					<input class="form-control" type="text" id="nombre" name="nombre" placeholder="Nombre del producto" value="{{$producto->nombre}}" required>
				</div>
				<div class="form-group">
					<label for="descripcion">Descripcion</label>
					<br>
					<textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripcion" rows="4" required>{{$producto->descripcion}}</textarea>
				</div>
				<div class="form-group">
					<label for="precio">Precio de venta ($)</label>
					<br>
					<input class="form-control" type="text" id="precio" name="precio" placeholder="Precio de venta" value="{{$producto->precio}}" required>
				</div>
			</div>
			<div>
				<label for="imageselect">¿Quiere cambiar la imagen del producto?</label>
				<br>
				<select class="form-control" id="imageselect" name="imageselect">
					<option value="no" selected>No</option>
					<option value="si">Sí</option>
				</select>
			</div>
				<div class="form-group" id="imageinput">
					<div></div>
					<div class="custom-file mt-8">
						<input class="custom-file-input" type="file" id="imagen" name="imagen">
						<label class="custom-file-label" for="imagen">Seleccione una imagen</label>
					</div>
				</div>
			<div class="mt-5">
				<button type="submit" class="btn btn-primary mt-5">Guardar cambios</button>
				<a href="{{ url()->previous() }}" class="btn btn-danger mt-5">Cancelar</a>
			</div>
		</form>
	</article>
</section>
@endsection