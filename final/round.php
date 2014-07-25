<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>CSS3 Loading Animation Loop</title>
<link rel="stylesheet" type="text/css" href="css/round.css">
<script src="../js/jq.js" type="text/javascript"></script>
<!-- <iframe src="load.php"  style="width: 90%;height: 90%;"></iframe> -->
<script>		
$(document).ready(function() {
	$('.ball, .ball1').removeClass('stop');	    
		$('.trigger').click(function() {
				$('.ball, .ball1').toggleClass('stop');
		});
});

$(document).ready(function() {
	$('.circle, .circle1').removeClass('stop');	    
		$('.triggerFull').click(function() {
				$('.circle, .circle1').toggleClass('stop');
		});
});


</script>
</head>
<body>
<!-- LOOP LOADER -->
<div class="container">
	<div class="content">
    <div class="ball"></div>
    <div class="ball1"></div>
    </div>
</div>
<a class="trigger" href="#">Play/Stop Animation</a>

<div class="container">
	<div class="content">
    <div class="circle"></div>
    <div class="circle1"></div>
    </div>
</div>
<a class="triggerFull" href="#">Play/Stop Animation</a>


<!-- END LOOP LOADER -->
</body>
</html>
