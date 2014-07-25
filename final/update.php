
<?php
	
	if (!isset($_SESSION)) {
        session_start();
    }
    if(isset($_SESSION['net_credit']))
    {
    	$net_credit = $_SESSION['net_credit'];
    }
    if(isset($_SESSION['net_profit']))
    {
    	$net_profit = $_SESSION['net_profit'];
    }
    if(isset($_SESSION['bonus_count']))
    {
    	$bonus_count = $_SESSION['bonus_count'];
    }
	if(isset($_SESSION['game_start'])){
	    $id = number_format($_SESSION['game_start'], 0, '', '');
	}
	$now = number_format(microtime(true)*1000*10000, 0, '', '');
	
	if (isset($_POST['action']) && !empty($_POST['action']) ) {
		$action = trim($_POST['action']);
		if (isset($_POST['arg']) && !empty($_POST['arg'])) {
			$arg = trim($_POST['arg']);
		}
		if (isset($_POST['quantity']) && !empty($_POST['quantity'])) {
			$quantity = trim($_POST['quantity']);
		}
	}else{
		$action = '';
		$arg = '';
	}

	switch ($action) {
		
		case 'bonus_evaluate': bonus_evaluate();
			break;
		
		case 'evaluate': evaluate();
			break;
		
		default:
			break;
	}
	
	include_once 'config.php';
	include_once 'connect.php';
	//
	
	ob_start();

	function cur_sec()
	{
		global $now, $id;
		$return = ($now - $id)/(1000*10000);
		return number_format($return, 0, '', '');
	}

	function profit($value)
	{
		$_SESSION['net_profit']+=$value;
	}

	function credit($credit)
	{
		$_SESSION['net_credit']+=$credit;
	}

	function bonus_evaluate()
	{
		global $id,$dbconn,$now,$net_profit,$bonus_count;
		if (($now-$id)/(2*60*1000*10000) < $bonus_count+1) {
			return;
		}else{
			$time = ($bonus_count+1)*2;
			$_SESSION['bonus_count']+=1;
			
			// $profit = 0;
			// $diff = 99999999999999;
			// $time = intval($time);
			// $query = "SELECT id, min, expected, evaluated FROM bonus WHERE id='".$id."' AND min='".$time."' AND evaluated='no' ";
			// $result = pg_query($query);
			// while ($row = pg_fetch_row($result)) {
			// 	$diff = $row[2]-$net_profit;
			// 	if ($diff<0) {
			// 		$diff = 0 - $diff;
			// 	}
				
			// }
			// $profit = (50*$net_profit)/(50+$diff);
			// profit($profit);
			// credit($profit);
			// $query = "UPDATE bonus SET evaluated = 'yes', awarded = '".$profit."', reality = '".$net_profit."' WHERE id='".$id."' AND min='".$time."' AND evaluated='no' ";
			// pg_query($query);
			// echo '<a id="be">',$profit,'</a>';
			?>
				<script type="text/javascript">
					var diff = JSON.parse(sessionStorage.bonus);
					var num = parseInt("<?php echo $bonus_count;?>");
					var profit = JSON.parse(sessionStorage.profit);
					diff[num].evaluated = 'yes';
					diff[num].reality = profit;
					diff[num].awarded = (50*profit)/(50+(diff[num].expected - profit));
					sessionStorage.bonus = JSON.stringify(diff);

					sessionStorage.growl = JSON.stringify({"pending": true, "message": });
				</script>
			<?php
		}
	}

	function evaluate()
	{
		global $id, $dbconn, $net_credit;
		$net_profit = 0;
		if (!isset($_SESSION)) {
            session_start();
        }
		$query = "SELECT quantity, price, tag, company FROM shares WHERE id='".$id."' ";
		$result = pg_query($query);
		while ($row = pg_fetch_row($result)) {
			$cur_price = cur_price($row[3]);
			if ($row[2]=='buy') {
					$net_profit-=$row[0]*($row[1]-$cur_price);
				} elseif ($row[2]=='sell') {
					$net_profit+=$row[0]*($row[1]-$cur_price);
				}
		}
		
		if(cur_sec() > 0){
		    status_update($net_profit);
		    $_SESSION['net_profit'] = $net_profit;
		}
		?>
			<script type="text/javascript">
				sessionStorage.credit = JSON.stringify({"credit": "<?php echo $net_credit;?>"});
				sessionStorage.profit = JSON.stringify({"profit": "<?php echo $net_profit;?>"});
				console.log("credit", JSON.parse(sessionStorage.credit));
			</script>
			
		<?php
		return $net_profit;
	}

	function status_update($net_profit)
	{
		global $id, $dbconn;
		$query = "INSERT INTO status (id, profit)
					VALUES ('".$id."','".$net_profit."')";
		pg_query($query);
	}

	function cur_price($comp)
	{
		global $id,$dbconn;
		$now = number_format(microtime(true)*1000*10000, 0, '', '');
		$insert = number_format($id/10000, 0, '', '');
		$string = '../data/'.$comp.'.txt';
		$row = 1;
		$fd = fopen ($string, "r");
		$contents = fread ($fd,filesize ($string));
		$output = preg_split("/[\s,]+/", $contents );
		fclose ($fd);
		$time_diff = ($now-$id)/(1000*10000);
		$time_diff = number_format($time_diff, 0, '', '');
		// if($time_diff<0){$time_diff = 0-$time_diff;}
		$return = $output[($time_diff+$insert)%(sizeof($output)-1)];
		// echo "contents".$contents."output".$output."return".$return;
		return $return;
		// echo($id).'\n';
		// echo($now);
		// print_r($output);
		// echo($output[4]);
		// echo length($output);
	}
?>