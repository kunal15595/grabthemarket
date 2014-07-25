<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>CSS3 Loading Animation</title>
<link rel="stylesheet" type="text/css" href="css/progress.css">
<script src="../js/jq.js" type="text/javascript"></script>
<script>		

$(document).ready(function() {
	setTimeout(function() {
		window.location = 'start.php';
	}, 1000*10);
	$('#content').removeClass('fullwidth');	    
		
			$('#content').removeClass('fullwidth').delay(10).queue(function(next){
				$(this).addClass('fullwidth');
		        next();
		    	
		    });

		    return false;
		
});

</script>

</head>
<body>

<!-- FULL WIDTH -->
<div id="content">
<span class="expand"></span>
</div>
<a class="triggerFull" href="#">Start/Restart Animation</a>
<!-- END FULL WIDTH -->

</body>
</html>
