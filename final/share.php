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
			"game": sessionStorage.game,
			"money": sessionStorage.money,
			"portfolio": sessionStorage.portfolio
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