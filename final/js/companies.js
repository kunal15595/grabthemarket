setStatus('companies');
$(document).ready(function() {
	block();
	unblock();
	// setTimeout($.unblockUI, 5000); 
	// $.blockUI({ 
	// 	message: $('.container'),
	// 	css: { 
	// 	width: '150px',
	// 	height: '150px',
	// 	// border: '2px solid green',
	// 	'margin-left': '0px auto',
	// 	'margin-top': '0px auto',
	//     border: 'none', 
	//     padding: '15px', 
	//     backgroundColor: 'inherit', 
	//     '-webkit-border-radius': '10px', 
	//     '-moz-border-radius': '10px', 
	//     opacity: .5, 
	//     color: '#fff' 
	// } }); 
	// setTimeout($.unblockUI, 100); 
	function unblock () {
		setTimeout($.unblockUI, 500); 
	}
	function block () {
	    $.blockUI({ 
	        message: '',
	        css: { 
	        width: '0px',
	        height: '0px',
	        // border: '2px solid green',
	        'margin-left': '0px',
	        'margin-top': '0px',
	        border: 'none', 
	        padding: '15px', 
	        backgroundColor: 'inherit', 
	        '-webkit-border-radius': '10px', 
	        '-moz-border-radius': '10px', 
	        opacity: .5, 
	        color: '#fff' 
	    } });   
	}
	// alert("comp");
	// console.log(status);
	$('.container').hide();

	$('.trends').click(function() {
		// alert("ok");
		// console.log("efsd",	status);
		$.blockUI({ 
			        message: '',
			        css: { 
			        width: '0px',
			        height: '0px',
			        // border: '2px solid green',
			        'margin-left': '0px',
			        'margin-top': '0px',
			        border: 'none', 
			        padding: '15px', 
			        backgroundColor: 'inherit', 
			        '-webkit-border-radius': '10px', 
			        '-moz-border-radius': '10px', 
			        opacity: .5, 
			        color: '#fff' 
			    } });  
		var redirect = $(this).attr('id');
		status = redirect;
		
		// console.log(status);
		// var incljs = 'js/'+String(redirect)+'.js';
		setTimeout(function() {
			window.location = 'companies.php?tenure='+String(redirect);
		}, 400);
		
		// $('#show').load(String(redirect));

	});
	$('.list').click(function() {
// 		alert("listed");
	});
	
});