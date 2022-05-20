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
<section class="row">
	<article class="col-md-6 text-center">
		<div><img src="<?php echo asset('imagenes/' . $producto->nombre) . '.jpg'; ?>" alt="{{$producto->nombre}}" style="width: 70%; max-height: 450px;"></div>
	</article>
	<article class="col-md-6 text-center">
		<h3>Edite la información que desee cambiar:</h3>
		<form action="{{route('inventario.update',$producto->id)}}" method="POST" enctype="multipart/form-data">
			@csrf
			@method('put')
			<div>
				<div class="form-group">
					<label for="codigo">Código</label>
					<br>
					<input type="text" id="codigo" name="codigo" placeholder="Código" value="{{$producto->codigo}}" required>
				</div>
				<div class="form-group">
					<label for="nombre">Nombre del producto</label>
					<br>
					<input type="text" id="nombre" name="nombre" placeholder="Nombre del producto" value="{{$producto->nombre}}" required>
				</div>
				<div class="form-group">
					<label for="descripcion">Descripcion</label>
					<br>
					<textarea id="descripcion" name="descripcion" placeholder="Descripcion" rows="4" required>{{$producto->descripcion}}</textarea>
				</div>
				<div class="form-group">
					<label for="precio">Precio de venta ($)</label>
					<br>
					<input type="text" id="precio" name="precio" placeholder="Precio de venta" value="{{$producto->precio}}" required>
				</div>
			</div>
			<div>
				<label for="imageselect">¿Quiere cambiar la imagen del producto?</label>
				<br>
				<select id="imageselect" name="imageselect" style="width: 100px;">
					<option value="no" selected>No</option>
					<option value="si">Sí</option>
				</select>
			</div>
				<div class="form-group" id="imageinput">
					<label for="imagen">Seleccione una imagen</label>
					<input type="file" id="imagen" name="imagen">
				</div>
			<div class="mt-5">
				<button type="submit" class="btn btn-primary mt-5">Guardar cambios</button>
				<a href="/inventario" class="btn btn-danger mt-5">Cancelar</a>
			</div>
		</form>
	</article>
</section>
@endsection