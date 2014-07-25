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
	$('.circle, .circle1').removeClass('stop');	    
		$('.triggerFull').click(function() {
				$('.circle, .circle1').toggleClass('stop');
		});
});


</script>
</head>
<body>

<div class="container">
	<div class="content">
    <div class="circle"></div>
    <div class="circle1"></div>
    </div>
</div>

<!-- END LOOP LOADER -->
</body>
</html>
