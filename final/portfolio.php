<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<link rel="stylesheet" type="text/css" href="css/portfolio.css"/>
		<script type="text/javascript" src= "../js/jq.js"></script>
		<script type="text/javascript" src= "js/common.js"></script>
		<script type="text/javascript" src="../js/jq-ui.js"></script>
        <script src="../Highcharts/js/highcharts.js"></script>
        <script src="../Highcharts/js/modules/exporting.js"></script>
        <p style="color: orange;" id="not_open"></p>
	<?php
		if (!isset($_SESSION)) {
	       session_start();
    	}
		if (isset($_GET['inc']) && !empty($_GET['inc'])) {
			$name = $_GET['inc'];
			$file = $name.'.txt';
			$set = false;
		}
	?>

	</head>
	<body>
		<div id="wrap">
			<div id="list">
				<div id="listing" style="display: none;">
					<?php include 'list.php'; ?>
				</div>
				<table id="table"></table>
			</div>
			<div id="container"></div>
			
		</div>	
	

	<script type="text/javascript">
	var  invested, quantity, profit, company, ids = [], nums = [],
		refreshIntervalId, clicked = false;
		table = document.getElementById('table'),
		tmp = JSON.parse(sessionStorage.list),
		list = tmp.companies,
		now = right_now(),
		game = JSON.parse(sessionStorage.game),
		money = JSON.parse(sessionStorage.money),
		game_start = game.game_start,
		shares = JSON.parse(sessionStorage.shares);
		// console.log(shares);
	// console.log("list", list);
	function repeat () {
		invested = Array.apply(null, new Array(list.length)).map(Number.prototype.valueOf,0);
		quantity = Array.apply(null, new Array(list.length)).map(Number.prototype.valueOf,0);
		profit = Array.apply(null, new Array(list.length)).map(Number.prototype.valueOf,0);
		company = Array.apply(null, new Array(list.length)).map(String.prototype.valueOf,'');

		now = right_now();
		game = JSON.parse(sessionStorage.game);
		money = JSON.parse(sessionStorage.money);
		shares = JSON.parse(sessionStorage.shares);
		
		
		for (var i = 0; i < shares.length; i++) {
			company[shares[i].id] = shares[i].company;
			if (shares[i].tag == 'buy') {
				invested[shares[i].id] += shares[i].price*shares[i].quantity;
				quantity[shares[i].id] += shares[i].quantity;
				profit[shares[i].id] += (cur_price(shares[i].company) - shares[i].price)*shares[i].quantity;
				
			}else{
				invested[shares[i].id] -= shares[i].price*shares[i].quantity;
				quantity[shares[i].id] -= shares[i].quantity;
				profit[shares[i].id] -= (cur_price(shares[i].company) - shares[i].price)*shares[i].quantity;
			}
		}
	}
	repeat();
	// console.log(invested, quantity, profit, company);
	for (var i = 0; i < list.length; i++) {
		if (quantity[i]!=0) {
		 //   console.log("inserting row",'company',company[i],'cur_price',cur_price[i],'invested',invested[i]);
			var row = table.insertRow(-1);
			row.id = 'data';
			row.class = 'data';
			// increase+=Math.floor(300/num);
			// string = String(increase);
			var cell4 = row.insertCell(0);
			
			var cell3 = row.insertCell(-1);
			var cell1 = row.insertCell(-1);	
			var cell2 = row.insertCell(-1);
			cell1.style.backgroundColor="#333333";
			cell2.style.backgroundColor="#ffff66";
			cell1.style.color="#FFA500";
			cell4.style.width = "0%";
			cell3.style.width = "23%";
			cell2.style.width = "16%";
			cell1.style.width = "50%";
			cell1.style.cursor = "pointer";
			cell4.className = company[i].toString();
			cell1.setAttribute("value", i);
			
			// cell4.setAttribute("id", "openport");
			// cell1.setAttribute("class", company[i]);
			cell1.className = "expand";
			cell2.className = "contract "+i.toString();
			cell3.className = "contract pre_hide "+i.toString();
			// cell2.setAttribute("class", i);
			cell3.setAttribute("id", 'cell'+i.toString());
			cell2.setAttribute("id", 'num'+i.toString());
			
			ids.push('cell'+i.toString());
			nums.push('num'+i.toString());
			cell4.style.backgroundSize = '100%';
			// console.log(document.getElementsByName(company[i]), company[i]);
			cell1.innerHTML = document.getElementsByName(company[i])[0].getAttribute('show');
			cell2.innerHTML = quantity[i];
			var insert = 0, diff = Math.round( (cur_price(company[i]) - past_price(company[i])) *100)/100;
			if (now > game_start) {
				insert = diff.toString();
				if(diff > 0)insert = '+' + insert; 
				if(right_now() > game.game_start )insert += '('+(Math.round(diff/past_price(company[i])*100)/100).toString()+'%)';
			}
			cell3.innerHTML = insert;
			
			if (diff > 0) {
				cell3.style.backgroundColor="#00ff00";
				//cell4.style.backgroundImage = "url('../images/port.jpg')";
			}else{
				cell3.style.backgroundColor="#ff0000";
				//cell4.style.backgroundImage = "url('../images/port.jpg')";
			}
			
		}	
	}
	if (now < game_start){
		jQuery('.pre_hide').hide();
	}
	setInterval(function() {
		repeat();
		for (var i = 0; i < ids.length; i++) {
			var temp = parseInt(ids[i].substring(4));
			// console.log(cur_price(company[temp]) - past_price(company[temp]), cur_price(company[temp]) , past_price(company[temp]));
			var diff = Math.round((cur_price(company[temp]) - past_price(company[temp])) *100)/100;
			insert = diff.toString();
			if(diff > 0)insert = '+' + insert; 
			if(right_now() > game.game_start )insert += '('+(Math.round(diff/past_price(company[temp])*100)/100).toString()+'%)';
			// console.log(insert,diff,cur_price(company[temp]), past_price(company[temp]));
			document.getElementById(nums[i]).innerHTML = quantity[temp];
			document.getElementById(ids[i]).innerHTML = insert;	
			if (diff > 0) {
				document.getElementById(ids[i]).style.backgroundColor="#00ff00";
				//cell4.style.backgroundImage = "url('../images/port.jpg')";
			}else{
				document.getElementById(ids[i]).style.backgroundColor="#ff0000";
				//cell4.style.backgroundImage = "url('../images/port.jpg')";
			}
		}
	}, 5*1000);
	if(game_start > now){
		document.getElementById('not_open').innerHTML = 'Markets are yet to open ! ';
	}
	
		
		
	////////////////               chart              ///////////////////////
		jQuery('.expand').effect("highlight", {}, 3000);
		jQuery('.expand').mouseover(function() {
			if(!clicked){
				jQuery(this).css({
					'color': 'green'
				});
			}
			
		});
		jQuery('.expand').mouseout(function() {
			if(!clicked){
				jQuery(this).css({
					'color': 'orange'
				});
			}

		});
		jQuery('.expand').click(function() {
			// console.log('1');
			if(right_now() > game.game_start )clicked = true;
			jQuery('#container').empty();	
			var prices,rows,start,amount,d,n,invested;
			if(now < game.game_start)return;
			// console.log('2',now , game.game_start);
			jQuery('.expand').css({
				color: "#FFA500"
			});
			jQuery(this).css({
				// width: "100%"
				color: "#ffffff"
			});
			var num = jQuery(this).attr('value');
			// console.log(num);
			Highcharts.setOptions({
			    global: {
			        useUTC: false
			    }
			});
			var portfolio = JSON.parse(sessionStorage.portfolio);
			// console.log(portfolio);
			for (var i = 0; i < portfolio.length; i++) {
				// console.log(portfolio[i].port[num-1]);
			}
			$('#container').highcharts({
			    chart: {
			        type: 'area',
			        animation: Highcharts.svg, // don't animate in old IE
			        marginRight: 10,
			        events: {
			            load: function() {
			
			                // set up the updating of the chart each second
			                var series = this.series[0];
			                var now = right_now();
			                function repeat_port() {
			                    portfolio = JSON.parse(sessionStorage.portfolio);
			                    console.log(portfolio[portfolio.length-1].port[num-1]);
			                    var x = now, y = portfolio[portfolio.length-1].port[num-1];
			                    series.addPoint([x, y], true, false);
			                    now += 20*1000;
			            	}
			            	clearInterval(refreshIntervalId);
			                refreshIntervalId = setInterval(repeat_port, 20*1000);
			            }
			        }
			    },
			    plotOptions: {
			        series: {
			            turboThreshold: 3000,
			            marker: {
			                enabled: false
			            }
			        }
			    },
			    title: {
			        text: document.getElementsByName(company[num])[0].getAttribute('show')
			    },
			    xAxis: {
			        title: {
			            text: 'Time'
			        },
			        type: 'datetime',
			        tickPixelInterval: 150
			    },
			    yAxis: {
			        title: {
			            text: 'Net Profit'
			        },
			        plotLines: [{
			            value: 0,
			            width: 1,
			            color: '#808080'
			        }]
			    },
			    credits: {
			        enabled: false
			    },
			    exporting: { 
			        enabled: false 
			    },
			    tooltip: {
			        formatter: function() {
			                return '<b>'+ this.series.name +'</b><br/>Time : '+
			                Highcharts.dateFormat('%H:%M:%S', this.x) +'<br/>Price : '+
			                Highcharts.numberFormat(this.y, 2);
			        }
			    },
			    legend: {
			        enabled: false
			    },
			    exporting: {
			        enabled: false
			    },
			    series: [{
			        name: 'Stock price',
			        color: '#00FF00',
			        negativeColor: '#FF0000',
			        threshold: 0,
			        data: (function() {
			            // generate an array of random data
			            var data = [], time = now, i, newTime = right_now();
			            
			            // console.log("now",newTime,"start",game_start);
			            var timeDiff = Math.round((newTime - game_start/10000)/1000);
			            // console.log("diff",timeDiff);
			            for (i = 1-portfolio.length; i <= 0; i++) {
			                // console.log(prices[start]);
			                
			                data.push({
			                    x: time + i*20*1000,
			                    y: portfolio[i+portfolio.length-1].port[num-1]
			                });
			                
			            }
			            return data;
			        })()
			    }]
			});
		});



	</script>
	<script type="text/javascript" src="js/portfolio.js"></script>
		
	</body>

</html>
