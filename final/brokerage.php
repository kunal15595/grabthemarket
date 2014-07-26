<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<link rel="stylesheet" type="text/css" href="css/brokerage.css"/>
		<script type="text/javascript" src= "../js/jq.js"></script>
		<script type="text/javascript" src= "js/common.js"></script>
		<script type="text/javascript" src="../js/jq-ui.js"></script>
	</head>
	<body>
		<div id="broke"></div>
		<div id="right">
            <?php include 'list.php'; ?>
        </div>
        <script type="text/javascript">
        var broker = JSON.parse(sessionStorage.broker);
        
        jQuery('.list').click(function() {
        	jQuery('.list').css({
        		color: 'orange'
        	});
        	jQuery(this).css({
        		color: 'white'
        	});
        });
        </script>
	</body>
</html>