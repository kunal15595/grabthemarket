<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" type="text/css" href="css/companies.css"/>
		<script type="text/javascript" src="../js/jq.js"></script>
		<script type="text/javascript" src="../js/block.js"></script>
		<title>Companies</title>
		<?php
		// include 'functions.php';
			if (isset($_GET['tenure'])  && !empty($_GET['tenure'])) {
				$tenure = $_GET['tenure'];
			}else{
				$tenure = 'compare';
			}
			$tenure=$tenure.'.php';
		?>
	</head>
	<body >
		<div class="container">
		    <div class="content">
		    <div class="circle"></div>
		    <div class="circle1"></div>
		    </div>
		</div>
		<div id="wrap">
			<div id="tabs">
				<div class="trends" id="historical">Historical</div>
				<div class="trends" id="current">Current</div>
				<div class="trends" id="compare">Compare</div>
			</div>
	<!-- // <script type="text/javascript" src= "../js/jq.js"></script> -->
	<script type="text/javascript" src= "js/common.js"></script>
	
	<script type="text/javascript" src="js/companies.js"></script>
	<script type="text/javascript">
		var tenure = "<?php echo $tenure;?>";
		tenure = tenure.split('.');
		add_tenure(String(tenure[0]));
	</script>
			<div style="visibility:hidden;" onload="this.style.visibility = 'visible';" id="show">
				<iframe style="visibility:hidden;" onload="this.style.visibility = 'visible';" id="showframe" src="<?php echo $tenure; ?>" marginwidth="0" marginheight="0"></iframe>
			</div>
		</div>
		
	</body>

</html>
