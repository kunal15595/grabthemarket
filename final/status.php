<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
        <link rel="stylesheet" type="text/css" href="css/smooth.css"/>
	<?php 
        if (!isset($_SESSION)) {
            session_start();
        }
        // die("ok");
        $status = $_SESSION['status'];
        $game_start = number_format($_SESSION['game_start'], 0, '', '');
        $now = microtime(true)*1000*10000;
        if ($now < $game_start) {
            ?>
                <p style="color: orange;">Markets have not yet opened !</p>
            <?php
            die("");
        }
        $set = true;
        
    ?>
    </head>
    <body>
        <script type="text/javascript">

        </script> 
        <script type="text/javascript" src="../js/jq.js"></script>
        <script type="text/javascript" src="../js/jq-ui.js"></script>
	
        <div id="status_container" style="height: 60%;width: 95%;margin-top: 100px;"></div>
        
        <script src="../Highcharts/js/highcharts.js"></script>
        <script src="../Highcharts/js/modules/exporting.js"></script>
        <script type="text/javascript" src="js/common.js"></script>
        <script type="text/javascript" src="theme/status.js"></script>
        <script type="text/javascript" src="js/status.js"></script>

	</body>
</html>
