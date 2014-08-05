<!DOCTYPE html>
<html>
<head>
	<?php
		include_once 'connect.php';
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$vars = json_decode(file_get_contents('php://input'));
			var_dump($vars);
		}
	?>
</head>
<body>
	<script type="text/javascript" src="../js/jq.js"></script>
	<script type="text/javascript">
		var data = {
			"compare": sessionStorage.compare,
			"bonus": sessionStorage.bonus,
			"bonus_submitted": sessionStorage.bonus_submitted,
			"game": sessionStorage.game,
			"money": sessionStorage.money,
			"growl": sessionStorage.growl,
			"stat": sessionStorage.stat,
			"timeline": sessionStorage.timeline,
			"portfolio": sessionStorage.portfolio,
			"news": sessionStorage.news,
			"broker": sessionStorage.broker,
			"active_news": sessionStorage.active_news,
			"game": sessionStorage.game,
			"shares": sessionStorage.shares,
			"list": sessionStorage.list
		};
		// console.log(data);
		$.ajax({
			type: "POST",
			url: '.',
			data: JSON.stringify(data)
		});
	</script>
</body>
</html>