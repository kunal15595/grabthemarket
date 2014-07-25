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

<!-- END LOOP LOADER -->
</body>
</html>
