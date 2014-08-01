<?php
	if (!isset($_SESSION)) {
        session_start();
    }
	$game_start = $_SESSION['game_start'];
	$game_visit = $_SESSION['game_visit'];
	$game_stop = $_SESSION['game_stop'];
    $now = microtime(true)*1000*10000;
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script type="text/javascript" src="countdown.js" ></script>
</head>
<body>
	<div id="status_info"></div>
	<script type="text/javascript" src="../js/jq.js"></script>
	<script type="application/javascript">
		var game = JSON.parse(sessionStorage.game),
			tim = 5*60,
			game_start = game.game_start, 
			game_visit = game.game_visit, 
			game_stop = game.game_stop, 
			now = (new Date()).getTime();
		
		if (now < game_start) {
			tim = (15*60*1000 - (now-game_visit))/1000;
		}else{
			tim = (2.5*60*60*1000 - (now-game_start))/1000;
		}

		
		var check = setInterval(function(){
			now += 4000;
			// console.log( "its",now,"now");
			if (now > game_stop) {
				// console.log("Shifting", now, game_start,game_stop);
	 			// window.parent.location = '../final/bonus.php';
			}else if(now >= game_start-2.5*1000 && now <= game_start+1.6*1000){
			// console.log("between");
				
				var stat = JSON.parse(sessionStorage.stat);
				stat.status = 'start';
				sessionStorage.stat = JSON.stringify(stat);

				window.parent.location = '../final/index.php?inc=companies';

			}else if(now >= game_stop-8*1000 && now <= game_stop){
			// console.log("between");
				
				var stat = JSON.parse(sessionStorage.stat);
				stat.status = 'stop';
				sessionStorage.stat = JSON.stringify(stat);

				window.parent.location = '../final/index.php?inc=bonus';

			}
		},4000);

	    // console.log("starting clock");
	    var low = "minute";
	    var high = "hour";
	    
	    if(tim < 30*60){
	    	low = "second";
	    	high = "minute";
	    }
		var clock = new Countdown({
			time: Math.round(tim), 
			width:120, 
			height:60, 
			rangeHi		: high,		// The highest unit of time to display
			rangeLo		: low,		// The lowest unit of time to display
		});

	// console.log("started clock");
	</script>
</body>
</html>