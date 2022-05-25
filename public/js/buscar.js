function buscar() {
	var input, filter, table, tr, trs, td, i, txtValue;
	var count = 0;
	input = document.getElementById("buscainput");
	filter = input.value.toUpperCase();
	table = document.getElementById("buscatable");
	trs = table.getElementsByTagName("tr");

	for (i = 1; i < trs.length; i++) {
	tr = $(trs).eq(i).children();

	    for (var j = 0; j < (tr.length - 1); j++) {
		    txtValue = $(tr).eq(j).text();
		    if (txtValue.toUpperCase().indexOf(filter) > -1) {
		    	//tr[i].style.display = "";
		    	count++;
		    } else {
		    	//tr[i].style.display = "none";
		    }
	    }
	    if (count) {
	    	$(trs).eq(i).show();
	    } else {
	    	$(trs).eq(i).hide();
	    }
	    count = 0;
	}
}