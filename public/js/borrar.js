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