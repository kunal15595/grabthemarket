<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="css/bonus.css">
        <link rel="stylesheet" type="text/css" href="css/round.css"/>
        <script type="text/javascript" src="../js/jq.js"></script>
        <script type="text/javascript" src="../js/block.js"></script>
	</head>
	
	<body>	
		<script type="text/javascript">
			var stat = JSON.parse(sessionStorage.stat);
			var status = stat.status;
			console.log("status", status);
			if (status=='stop') {
				setTimeout(function() {
                    window.location = 'share.php';
                }, 1000*10);
			}
		</script>
		<script type="text/javascript" src="../Highcharts/js/highcharts.js"></script>
		<script type="text/javascript" src="../Highcharts/js/modules/exporting.js"></script>
		<script src="js/draggable-points.js"></script>
		<div id="container" style="height: 400px"></div>
		<div class="container">
		    <div class="content">
		    <div class="circle"></div>
		    <div class="circle1"></div>
		    </div>
		</div>
		<div id="out"></div>
		<button id="submit" value="Submit">Submit</button>
		<script type="text/javascript" src="theme/bonus.js"></script>		 
		<script type="text/javascript" src="js/bonus.js"></script>
	</body>
</html>
