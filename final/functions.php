<?php
	// include_once 'connect.php';
	
// 	if (session_status() == PHP_SESSION_NONE) {
// 	    session_start();
// 	}
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
	
	// $id = '652435218566';
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
		case 'addtocompare':
			{
				addtocompare($arg);
			}
			break;
		case 'removefromcompare':
			{
				removefromcompare($arg);
			}
			break;
		case 'isselectedtocompare':
			{
				isselectedtocompare($arg);
			}
			break;
		case 'buy':
			{
				buy($arg,$quantity);
			}
			break;
		case 'sell':
			{
				sell($arg,$quantity);
			}
			break;
		case 'pre_buy':
			{
				pre_buy($arg,$quantity);
			}
			break;
		case 'pre_sell':
			{
				pre_sell($arg,$quantity);
			}
			break;
		case 'register_user':
			{
				register_user($arg,$quantity);
			}
			break;
		case 'bonus_submit':
			{
				bonus_submit($arg);
			}
			break;
		case 'bonus_retrieve':
			{
				bonus_retrieve();
			}
			break;
		case 'bonus_evaluate':
			{
				bonus_evaluate();
			}
			break;
		case 'status_retrieve':
			{
				status_retrieve();
			}
			break;
		case 'set_status':
			{
				set_status($arg);
			}
			break;
		case 'evaluate':
			{
				evaluate();
			}
			break;
		case 'clearall':
			{
				clearall();
			}
			break;
		case 'cleargrowl':
			{
				cleargrowl();
			}
			break;
		

		default:
			
			break;
	}
	
	include_once 'config.php';
	include_once 'connect.php';
	//
	
	ob_start();
	// $id=3548357415;
	function cur_sec()
	{
		global $now, $id;
		$return = ($now - $id)/(1000*10000);
		return number_format($return, 0, '', '');;
	}
	function clearall()
	{
		global $id, $dbconn;
		$query = "DELETE FROM shares WHERE id < '".$id."' ";
		pg_query($query);
		$query = "DELETE FROM bonus WHERE id < '".$id."' ";
		pg_query($query);
		$query = "DELETE FROM status WHERE id < '".$id."' ";
		pg_query($query);
		$query = "DELETE FROM compare WHERE id < '".$id."' ";
		pg_query($query);
		echo "done";
	}
	function set_status($arg)
	{
		if (!isset($_SESSION)) {
            session_start();
        }
		$_SESSION['status'] = $arg;
	}
	function session_growl($a, $b)
	{
		?>
			<script type="text/javascript">
				sessionStorage.growlpending = "<?php echo $b;?>";
				sessionStorage.growlmessage = "<?php echo $a;?>";
			</script>
		<?php
	}
	function cleargrowl()
	{
		session_growl('', false);
	 //    if (!isset($_SESSION)) {
  //           session_start();
  //       }
		// $_SESSION['growlmessage'] = '';
		// $_SESSION['growlpending'] = false;
	}
	function growl_bonus_submit()
	{
		session_growl('Request submitted', true);
	 //    if (!isset($_SESSION)) {
  //           session_start();
  //       }
		// $_SESSION['growlmessage'] = 'Request submitted';
		// $_SESSION['growlpending'] = true;
		
	}
	function growl_buy($comp, $price, $quantity)
	{
	    $price = round( $price, 2);
		session_growl('You buyed '.$quantity.' shares of '.$comp.' @ '.$price, true);
		// if (!isset($_SESSION)) {
  //           session_start();
  //       }
		// $_SESSION['growlmessage'] = 'You buyed '.$quantity.' shares of '.$comp.' @ '.$price;
		// $_SESSION['growlpending'] = true;
		
	}

	function growl_sell($comp, $price, $quantity)
	{
	    $price = round( $price, 2);
	    session_growl('You sold '.$quantity.' shares of '.$comp.' @ '.$price, true);
	 //    if (!isset($_SESSION)) {
  //           session_start();
  //       }
		// $_SESSION['growlmessage'] = 'You sold '.$quantity.' shares of '.$comp.' @ '.$price;
		// $_SESSION['growlpending'] = true;
		
		
	}
	function growl_bonus($bonus)
	{
	    
		$bonus = round( $bonus, 2);
		session_growl('Bonus awarded !! '.'Rs. '.$bonus, true);
		// if (!isset($_SESSION)) {
  //           session_start();
  //       }
		// $_SESSION['growlmessage'] = 'Bonus awarded !! '.'Rs. '.$bonus;
		// $_SESSION['growlpending'] = true;
	}
	
	function status_retrieve()
	{
		global $id,$dbconn,$now;
		$query = "SELECT id, profit, time FROM status WHERE id='".$id."' ORDER BY time ASC ";
		$result = pg_query($query);
		$return = '';
		while ($row = pg_fetch_row($result)) {
			$return.=$row[1].',';
		}
		echo '<a id="sr">',$return,'</a>';
		?>
			<script type="text/javascript">
				console.log("return");
				sessionStorage.status_retrieve = "<?php echo $return;?>";
			</script>
		<?php

	}
	function status_update($net_profit)
	{
		global $id, $dbconn;
		$query = "INSERT INTO status (id, profit)
					VALUES ('".$id."','".$net_profit."')";
		pg_query($query);
	}
	function profit($value)
	{
		$_SESSION['net_profit']+=$value;
	}
	function set_profit($net_profit)
	{
	    global $net_credit;
		if (!isset($_SESSION)) {
            session_start();
        }
		// global $_SESSION['net_profit'];
		// echo "net_profit: ".$net_profit;
		$net_credit = '';
		$net_profit = ''.$net_profit.',';
		
		
		$_SESSION['net_profit'] = $net_profit;
		
// 		$return = '';
// 		$reality = '';
// 		$awarded = '';
// 		while ($row = pg_fetch_row($result)) {
// 			$return.=$row[2].',';
// 			$reality.=$row[3].',';
// 			$awarded.=$row[4].',';
			
// 		}
// 		echo '<a id="br">'.$return.$reality.$awarded.'</a>';
	}
	
	function manage($comp)
	{
		global $id;
		$com = pg_escape_string($comp);
		$query = "SELECT quantity, price, tag FROM shares WHERE id='".$id."' AND company='".$com."'";
		$result = pg_query($query);
		return $result;
	}
	function data()
	{
		global $id;
		$query = "SELECT company, quantity, price, tag, time FROM shares WHERE id='".$id."' ORDER BY company ASC ";
		$result = pg_query($query);
		return $result;
	}
	function bonus_retrieve()
	{
		global $id,$dbconn,$now;
		$query = "SELECT id, min, expected, reality, awarded FROM bonus WHERE id='".$id."' ORDER BY min ";
		$result = pg_query($query);
		$return = '';
		$reality = '';
		$awarded = '';
		while ($row = pg_fetch_row($result)) {
			$return.=$row[2].',';
			$reality.=$row[3].',';
			$awarded.=$row[4].',';
			
		}
		echo '<a id="br">'.$return.$reality.$awarded.'</a>';
	}
	function bonus_submit($series)
	{
		global $id,$dbconn,$now;
		$query = "DELETE FROM bonus WHERE id='".$id."'";
		pg_query($query);
		$pieces = explode(",", $series);
		for ($i=0; $i < 10; $i++) { 
			$min = ($i+1)*2;
			$query = "INSERT INTO bonus (id, min,expected, reality, evaluated, awarded)
    					VALUES ('".$id."','".$min."','{$pieces[$i]}', 0,'no',0)";
    		pg_query($query);
		}
        growl_bonus_submit();
	}
	function credit($credit)
	{
		session_start();
		$_SESSION['net_credit']+=$credit;
	}
	function past_price($comp)
	{
		global $id;
		$string = '../data/'.$comp.'.txt';
		$row = 1;
		$fd = fopen ($string, "r");
		$contents = fread ($fd,filesize ($string));
		$output = preg_split("/[\s,]+/", $contents );
		fclose ($fd);
		$return = $output[($id+rand(1, sizeof($output)))%sizeof($output)];
		// echo "contents".$contents."output".$output."return".$return;
		return $return;
		// echo($id).'\n';
		// echo($now);
		// print_r($output);
		// echo($output[4]);
		// echo length($output);
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
	function buy($comp,$num)
	{
		global $id,$dbconn,$now,$net_credit;
		
		$com = pg_escape_string($comp);
		$id = pg_escape_string($id);
		$cur_price = cur_price($comp);
		$cur_sec = number_format(cur_sec(), 0, '', '');
		// echo "comp:".$comp."num:".$num."cur_price:".$cur_price."net_credit:".$net_credit;
		if ($net_credit > $cur_price*$num) {
			// $query = "SELECT quantity FROM shares WHERE id='".$id."' AND company='".$com."'";
			// $result = pg_query($dbconn,$query);
			// $num_rows = pg_num_rows($result);
			
			$query = "INSERT INTO shares (id, company, quantity, price, tag, time)
						VALUES ('".$id."', '".$com."','".$num."','".$cur_price."','buy', '".$cur_sec."')";
			pg_query($query);
			
		}else{
			return false;
		}
		credit(0-$cur_price*$num);
		growl_buy($comp, $cur_price, $num);
		return true;

		

	}
	function sell($comp,$num)
	{
		global $id,$dbconn,$now,$net_credit;
		
		$com = pg_escape_string($comp);
		$id = pg_escape_string($id);
		$cur_price = cur_price($comp);
		$cur_sec = number_format(cur_sec(), 0, '', '');
		$query = "INSERT INTO shares (id, company, quantity, price, tag, time)
					VALUES ('".$id."', '".$com."','".$num."','".$cur_price."','sell', '".$cur_sec."')";
		if(pg_query($query)){
			credit($cur_price*$num);
			growl_sell($comp, $cur_price, $num);
			return true;
		}
		
	}
	function pre_buy($comp,$num)
	{
		global $id,$dbconn,$now,$net_credit;
		
		$com = pg_escape_string($comp);
		$id = pg_escape_string($id);
		$past_price = past_price($comp);
		$cur_sec = number_format(cur_sec(), 0, '', '');
		// echo "comp:".$comp."num:".$num."past_price:".$past_price."net_credit:".$net_credit;
		if ($net_credit > $past_price*$num) {
			// $query = "SELECT quantity FROM shares WHERE id='".$id."' AND company='".$com."'";
			// $result = pg_query($dbconn,$query);
			// $num_rows = pg_num_rows($result);
			
			$query = "INSERT INTO shares (id, company, quantity, price, tag, time)
						VALUES ('".$id."', '".$com."','".$num."','".$past_price."','buy', '".$cur_sec."')";
			pg_query($query);
			
		}else{
			return false;
		}
		credit(0-$past_price*$num);
		growl_buy($comp, $past_price, $num);
		return true;

		

	}
	function pre_sell($comp,$num)
	{
		global $id,$dbconn,$now,$net_credit;
		
		$com = pg_escape_string($comp);
		$id = pg_escape_string($id);
		$past_price = past_price($comp);
		$cur_sec = number_format(cur_sec(), 0, '', '');
		$query = "INSERT INTO shares (id, company, quantity, price, tag, time)
					VALUES ('".$id."', '".$com."','".$num."','".$past_price."','sell', '".$cur_sec."')";
		if(pg_query($query)){
			credit($past_price*$num);
			growl_sell($comp, $past_price, $num);
			return true;
		}
		
	}
	function addtocompare($comp)
	{
		global $id,$dbconn;
		$com = pg_escape_string($comp);
		$id = pg_escape_string($id);
		$query = "INSERT INTO compare (id, company) VALUES ('".$id."','".$com."')";
		pg_query($dbconn,$query);
		
	}
	function isselectedtocompare($comp)
	{
		global $id,$dbconn;
		$com = pg_escape_string($comp);
		$id = pg_escape_string($id);
		
		$query = "SELECT company FROM compare WHERE company='".$com."' AND  id='".$id."' ";
		$result = pg_query($dbconn,$query);
		$rows = pg_num_rows($result);
		if ($rows==0) {
			addtocompare($comp);
			return false;
		}else{
			removefromcompare($comp);
			return true;
		}
		
	}
	function removefromcompare($comp)
	{
		global $id,$dbconn;
		$com = pg_escape_string($comp);
		$id = pg_escape_string($id);
		$query = "DELETE FROM compare WHERE company = '".$comp."' ";
		pg_query($dbconn,$query);
		
	}
	function register_user($userid, $fullname){
	    global $id,$dbconn;
	    
	    $query = "INSERT INTO users (userid, name) VALUES ('".$userid."','".$fullname."')";
		pg_query($dbconn,$query);
	}
	function list_highscores()
	{
		global $id,$dbconn;
		
		$id = pg_escape_string($id);
		$query = "SELECT name, highscore FROM players ORDER BY highscore DESC ";
		$result = pg_query($dbconn,$query);
		
		return $result;
	}
	function set_highscore($net_profit, $net_credit)
	{
	    global $id,$dbconn;
	    
		$name = $_SESSION['name'];
		$id = pg_escape_string($id);
		$name = pg_escape_string($name);
		$score = intval($_SESSION['net_credit']) + intval($_SESSION['net_profit']) ;
		$score = pg_escape_string($score);
	    $query = "INSERT INTO players (id, name, highscore)
					VALUES ('".$id."','".$name."','".$score."')";
		$result = pg_query($dbconn,$query);
		
	}
	function init()
	{
		// $query = "CREATE TABLE compare (
		//     id        	integer CONSTRAINT firstkey PRIMARY KEY,
		//     company       varchar(40) NOT NULL
		// )";
		$query = "CREATE TABLE bonus (
		    id        	bigint NOT NULL,
		    min       integer NOT NULL
		)";
	}
	// register_user('sdf sf', 'sfgrsf');
	// addtocompare('GAG');
	//pg_query("INSERT INTO compare (id, company) VALUES ($id, 'GOOG')");
	// echo "returning";
	// echo cur_price('GOOG');
	// init();
?>
<!-- <script type="text/javascript" src="../js/jq.js"></script> -->
<!-- <script type="text/javascript" src="../js/block.js"></script> -->

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<script type="text/javascript">
	$.post( "final/functions.php", { 'action': 'register_user','arg': 'hnb', 'quantity': 'jhnv' } );
</script>
</body>
</html>