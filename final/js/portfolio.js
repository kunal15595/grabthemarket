$(document).ready(function() {	
    
	$('.openport').click(function() {
		// alert("ok");
		var inc = $(this).attr('id');
		// alert(inc);
		
		var load = 'port.php?inc='+String(inc);
		// document.getElementById('portframe').load(load);
		//window.location = 'portfolio.php?inc='+inc;
		// alert(load);
		// $('#port').load(load);
		// alert("ok");
	});
});