setStatus('current');
$(document).ready(function() {
	unblock();
	function unblock () {
		setTimeout(window.parent.$.unblockUI, 10);
	    
	}
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
	// console.log(status);
	$('.container').hide();
	// $('.circle, .circle1').removeClass('stop');	    
		$('.triggerFull').click(function() {
				
		});
	
	$('.list').click(function() {
		// alert("ok");
		block();
		$('.container').show();
		$('#container').hide();
		
		// $('.circle, .circle1').toggleClass('stop');
		$('.list').css(
		{
			"color": "#dddddd",
			// background: "linear-gradient(to right, silver, white)",
			"text-align": "center",
			width: "80%",
			"background-color": "#222222"
		}
		);
		$(this).css(
		{
		  "color": "#222222",
		  // background: "linear-gradient(to left, silver, white)",
		  "text-align": "center",
		  width: "100%",
		  "background-color": "#aaaaaa"
		  
		}
		);

		var redirect = String($( this ).attr( "name" ));
		window.location = 'current.php?inc='+redirect;
	
	});


});