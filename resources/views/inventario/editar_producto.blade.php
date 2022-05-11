@extends('layouts.app')

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
<section>
	<article>
		<h1>Editando {{$producto->nombre}}</h1>
		<div><img src="<?php echo asset('imagenes/' . $producto->nombre) . '.jpg'; ?>" alt="{{$producto->nombre}}" style="width: 400px;"></div>
	</article>
	<article>
		<h3>Edite la información que desee cambiar:</h3>
	</article>
</section>
<section>
	<article>
		<form action="{{route('inventario.update',$producto->id)}}" method="POST" enctype="multipart/form-data">
			@csrf
			@method('put')
			<div class="form-group">
				<label for="codigo">Código</label>
				<input type="text" id="codigo" name="codigo" placeholder="Código" value="{{$producto->codigo}}" required>
			</div>
			<div class="form-group">
				<label for="nombre">Nombre del producto</label>
				<input type="text" id="nombre" name="nombre" placeholder="Nombre del producto" value="{{$producto->nombre}}" required>
			</div>
			<div class="form-group">
				<label for="descripcion">Descripcion</label>
				<textarea id="descripcion" name="descripcion" placeholder="Descripcion" required>{{$producto->descripcion}}</textarea>
			</div>
			<div class="form-group">
				<label for="precio">Precio de venta ($)</label>
				<input type="text" id="precio" name="precio" placeholder="Precio de venta" value="{{$producto->precio}}" required>
			</div>
			<div>
				<label for="imageselect">¿Quiere cambiar la imagen del producto?</label>
				<select id="imageselect" name="imageselect">
					<option value="no" selected>No</option>
					<option value="si">Sí</option>
				</select>
			</div>
				<div class="form-group" id="imageinput">
					<label for="imagen">Seleccione una imagen</label>
					<input type="file" id="imagen" name="imagen">
				</div>
			<div>
				<button type="submit" class="btn btn-primary">Guardar cambios</button>
				<a href="/inventario" class="btn btn-danger">Cancelar</a>
			</div>
		</form>
	</article>
</section>
@endsection