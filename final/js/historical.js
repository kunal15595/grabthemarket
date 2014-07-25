setStatus('historical');
$(document).ready(function() {
	// console.log(status);
	// window.parent.$.unblockUI();
	// $.unblockUI();
	// setTimeout(window.parent.$.unblockUI, 100); 
	$('.container').hide();
	$('.list').click(function() {
		// alert("ok");
		$('.container').show();
		$('#container').hide();
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
		window.location = 'historical.php?inc='+redirect;
	
	});


});