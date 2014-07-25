$('#mainframe').ready(function() {
	// setTimeout($.unblockUI, 100); 
	// alert("loaded");
	// setTimeout($.unblockUI, 500); 
});
$(document).ready(function() {
	// $.unblockUI();
	// $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
	// $('.vertical').hide();
	setTimeout(function() {
	    var add_width = 150*80/100;
		$('#left').animate({
			width: $('#left').width()*0.1
		}, 3000);
	    // $('.vertical').show();
		$('#left').animate({
			width: $('#left').width()*0.9
		}, 6000);
	}, 1000);
	
	$('.container').show();
	$('#main').hide();
	$('.circle, .circle1').removeClass('stop');
	
	$.blockUI({ 
		message: $('.container'),
		css: { 
		width: '150px',
		height: '150px',
		// border: '2px solid green',
		'margin-left': '0px auto',
		'margin-top': '0px auto',
	    border: 'none', 
	    padding: '15px', 
	    backgroundColor: 'transparent', 
	    '-webkit-border-radius': '10px', 
	    '-moz-border-radius': '10px', 
	    opacity: .5, 
	    color: '#fff' 
	} }); 
	setTimeout(function() {
		
		$('#main').show();
		$('.circle, .circle1').addClass('stop');
		$('.container').hide();
		// $('.container').css({
		// 	'width': '0px',
		// 	'height': '0px'
			
		// });
		// $('.content').css({
		// 	'width': '0px',
		// 	'height': '0px'
			
		// });$('.circle').css({
		// 	'width': '0px',
		// 	'height': '0px'
			
		// });$('.circle1').css({
		// 	'width': '0px',
		// 	'height': '0px'
			
		// });
		$('.content').hide();
		$('.circle').hide();
		$('.circle1').hide();
		
	}, 800);
	setTimeout($.unblockUI, 1400); 
	
	
	var flag = [];
	var length = 21; // user defined length

	for(var i = 1; i <= length+1; i++) {
	    flag.push(true);
	}
	// console.log(flag);

	// var incl = <?php echo $inc; ?>
	// console.log(incl);
	// $('.list').click(function() {
	// 	// alert("ok");
	// 	var num = parseInt($( this ).attr( "id" ));
	// 	if (flag[num]) {
	// 		$(this).css(
	// 		{
			 
	// 		  // background: "linear-gradient(to right, #aaaaaa, white)",
	// 		  "color": "#222222",
	// 		  width: "100%",
	// 		  "text-align": "center",
	// 		  "background-color": "#aaaaaa"
			  
	// 		}
	// 		);
	// 		flag[num]=false;
	// 	}else{
	// 		$(this).css(
	// 		{
			 
	// 		  // background: "linear-gradient(to left, #aaaaaa, white)",
	// 		  "color": "#dddddd",
	// 		  width: "80%",
	// 		  "text-align": "center",
	// 		  "background-color": "#222222"
			  
	// 		}
	// 		);
	// 		flag[num]=true;
	// 	}
		
		
	// });
	$('.vertical').click(function() {
		// alert("ok");
			// $('.container').show();
			// $('#main').hide();
			// $('.circle, .circle1').toggleClass('stop');
			$.blockUI({ 
				message: $('.container'),
				css: { 
				width: '150px',
				height: '150px',
				// border: '2px solid green',
				'margin-left': '0px auto',
				'margin-top': '0px auto',
			    border: 'none', 
			    padding: '15px', 
			    backgroundColor: 'transparent', 
			    '-webkit-border-radius': '10px', 
			    '-moz-border-radius': '10px', 
			    opacity: .5, 
			    color: '#fff' 
			} }); 
			setTimeout($.unblockUI, 500); 
			$('.vertical').css(
			{
				// background: "linear-gradient(to right, silver, white)",
				"text-align": "center",
				width: "80%",
				"background-color": "#222222"
			}
			);
			$(this).css(
			{
			 
			  // background: "linear-gradient(to left, silver, white)",
			  "text-align": "center",
			  width: "100%",
			  "background-color": "#aaaaaa"
			  
			}
			);

			var redirect = String($( this ).attr( "id" ));
			window.location = 'index.php?inc='+redirect;
		
	});
});