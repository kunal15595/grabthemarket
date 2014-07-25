<!DOCTYPE HTML>
<html style="background-image: url(../images/pattern_40.gif);">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" type="text/css" href="css/portfolio.css"/>
	
	<?php
		session_start();
		// die("ok");
		$game_start = number_format($_SESSION['game_start'], 0, '', '');
		$now = microtime(true)*1000*10000;
		if ($now < $game_start) {
		    // die("Market has not yet opened");
		}
		include_once 'functions.php';
		$data = data();
		if (isset($_GET['inc']) && !empty($_GET['inc'])) {
		    $name = $_GET['inc'];
		    $file = $name.'.txt';
		    $set = false;
		}else{
		    // die();
		    $name = '';
		}
		$inc = 'port.php?inc='.$name;
	?>

	</head>
	<body>
		<div id="wrap">
			<div id="list">
				<div id="listing">
					<?php include 'listing.php'; ?>
				
				</div>
				
				<table id="table">

				</table>
			</div>
			
	<script type="text/javascript" src= "../js/jq.js"></script>
	<!-- // <script type="text/javascript" src= "js/common.js"></script> -->
	
	
			
		
<?php
	$list = array('AAPL' => 1,'APF' => 2,'APOL' => 3,'F' => 4,'GOOG' => 5,'HDB' => 6,'HMC' => 7,'IBN' => 8,'INFY' => 9,'JBLU' => 10,'MSFT' => 11,'NOK' => 12,'NSANY' => 13,'ORCL' => 14,'SI' => 15,'SYMC' => 16,'TM' => 17,'TTM' => 18,'VOD' => 19,'WIT' => 20,'YHOO' => 21);
	//company, quantity, price, tag, time
	$company= array('','','','','','','','','','','','','','','','','','','','','','');
	$quantity= array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
	$invested= array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
	$price= array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
	$cur_price= array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
	
	$tag= array('','','','','','','','','','','','','','','','','','','','','','');
	while ($row = pg_fetch_row($data)) {
		$key = $list[$row[0]];
		$company[$key] = $row[0];
		if ($row[3]=='buy') {
			$quantity[$key] += $row[1];
			$invested[$key] += $row[1]*$row[2];
			
		}else{
			$quantity[$key] -= $row[1];
			$invested[$key] -= $row[1]*$row[2];
		}
		$cur_price[$key] = cur_price($row[0]);
	}
	// echo $invested;
?>
	<script type="text/javascript">
		var now = "<?php echo $now;?>";
		var game_start = "<?php echo $game_start;?>";
		
		var invested = <?php echo json_encode($invested);?>;
		var quantity = <?php echo json_encode($quantity);?>;
		var company = <?php echo json_encode($company);?>;
		var cur_price = <?php echo json_encode($cur_price);?>;
		
		var table = document.getElementById("table");
// 		table.id = 'transpose';
		var num = company.length;
		var script = '', string;
		// var increase = 10;
		for (var i = 1;i < num; i++) {
			if (company[i]!=='') {
			 //   console.log("inserting row",'company',company[i],'cur_price',cur_price[i],'invested',invested[i]);
				var row = table.insertRow(0);
				row.id = 'data';
				row.class = 'data';
				// increase+=Math.floor(300/num);
				// string = String(increase);
				var cell1 = row.insertCell(0);
				cell1.id = 'cell1';
				cell1.style.backgroundColor="#66ffff";
				var cell2 = row.insertCell(1);
				cell2.style.backgroundColor="#ffff66";
				var cell3 = row.insertCell(2);
				var cell4 = row.insertCell(3);
				cell4.style.height = "0px";
				cell4.style.width = "0px";
				cell4.setAttribute("id", company[i]);
				cell4.setAttribute("class", "openport");
				cell4.id = company[i];
				cell4.class = 'openport';

				cell4.style.backgroundSize = '100%';
				cell1.innerHTML = document.getElementsByName(company[i])[0].getAttribute( 'show' );
				cell2.innerHTML = quantity[i];
				var insert;
				if (now > game_start) {
					insert = Math.round((cur_price[i]*quantity[i] - invested[i])*100)/100;
				}else{
					insert = 0;
				}
				cell3.innerHTML = insert;
				if (insert > 0) {
					cell3.style.backgroundColor="#00ff00";
					//cell4.style.backgroundImage = "url('../images/port.jpg')";
				}else{
					cell3.style.backgroundColor="#ff0000";
					//cell4.style.backgroundImage = "url('../images/port.jpg')";
				}
				
			}
		}	
		var row = table.insertRow(0);
		row.id = 'heading';
		row.class = 'heading';
		
		var cell1 = row.insertCell(0);
		cell1.style.backgroundColor="#009999";
		var cell2 = row.insertCell(1);
		cell2.style.backgroundColor="#999900";
		var cell3 = row.insertCell(2);
		cell3.style.backgroundColor="#aaaaaa";
		
		cell1.innerHTML = 'Company';
		cell2.innerHTML = 'Shares';
		cell3.innerHTML = 'Profit';
// 		console.log(invested,quantity,company);
		
	</script>
	<script type="text/javascript" src="js/portfolio.js"></script>
	       
		</div>
	</body>

</html>
