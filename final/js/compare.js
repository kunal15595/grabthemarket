
setStatus('compare');
$(window).load(function() {
	// $('.container').hide();
});

$(document).ready(function() {
	// console.log(status);
	unblock();
	function block () {
	    window.parent.$.blockUI({ 
	        message: $('.container'),
	        css: { 
	        width: '150px',
	        height: '150px',
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
	function unblock () {
		setTimeout(window.parent.$.unblockUI, 10);
	    
	}
	$('.container').hide();
	// var id = "<?php echo $id; ?>";
	var id = '<?php echo $_SESSION["game_start"]; ?>';
// 	console.log("id",id);
	// console.log(session);
	// var parts = session.split(',');
	// console.log(parts);
	// for (var i = 0; i < parts.length; i++) {
	// 	flag[parseInt(parts[i])] = false;
	// }
	
		$('.list').click(function() {
			// alert("ok");
			block();
			// unblock();	
			
		});

});