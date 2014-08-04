<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/load.css">
	<script src="../js/jq.js" type="text/javascript"></script>
	<script>		

	$(document).ready(function() {
		$('#content').removeClass('fullwidth');	    
		$('#startgame').click(function(e) {
	        e.preventDefault();
			$('#content').removeClass('fullwidth').delay(10).queue(function(next){
				$(this).addClass('fullwidth');
		        next();
		    });
		    setTimeout(function() {
		    window.location = 'start.php';  
		    }, 1000*10);
		    
		    return false;
		});
	});

	</script>

</head>
<body>
    <h1>Grab the market !</h1>
	<a class="triggerFull" id="instructions" href="instructions.php">Instructions</a>
	<a class="triggerFull" id="highscores" href="highscores.php">Highscores</a>
	<a class="triggerFull" id="startgame" href="#">Start Game</a>
	<div id="content">
	<span class="expand"></span>
	</div>
	<!-- END FULL WIDTH -->

</body>
</html>
