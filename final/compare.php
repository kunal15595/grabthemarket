<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Highstock Example</title>
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<link rel="stylesheet" type="text/css" href="css/round.css"/>
		<link rel="stylesheet" type="text/css" href="css/compare.css"/>
		<script type="text/javascript" src="../js/jq.js"></script>
		<?php 
			// ob_start();
			if (!isset($_SESSION)) {
			    session_start();
			}
			// $game_start = $_SESSION['game_start'];
			// $id = (float)$_SESSION['game_start'];
			$id = number_format($_SESSION['game_start'], 0, '', '');
			$set = true;
			
			// if (isset($_GET['inc']) && !empty($_GET['inc'])) {
			// 	$names = explode(" ", $_GET['inc']);
			// 	$siz = sizeof($names);   
			// 	$set = false;
			// 	$_SESSION['compare'] = $_GET['inc'];
			// }else{
			// 	$siz = 3;
			// 	$names = array('MSFT', 'AAPL', 'GOOG');
			// 	$_SESSION['compare'] ='1,5,11';
			// }
			// $session = $_SESSION['compare'];

		?>
	</head>
	<body>
		<script src="../Highstock/js/highstock.js"></script>
		<script src="../Highstock/js/modules/exporting.js"></script>
		<script type="text/javascript" src="theme/compare.js"></script>
		<div class="container">
		    <div class="content">
		    <div class="circle"></div>
		    <div class="circle1"></div>
		    </div>
		</div>
		<div id="container"></div>
		<div id="right">
		    <?php include 'list.php'; ?>
		</div>
		
		<script type="text/javascript" src="js/common.js"></script>
		<script type="text/javascript" src="js/compare.js"></script>
		<script type="text/javascript">
			
			setStatus('compare');
			
			// console.log(status);
			// var id = "<?php echo $id; ?>";
			var id = "<?php echo $_SESSION['game_start']; ?>",  siz = 0, names = [], id = "<?php echo $id; ?>";
			// console.log("id",id);
			// console.log(session);
			// var parts = session.split(',');
			// console.log(parts);
			// for (var i = 0; i < parts.length; i++) {
			// 	flag[parseInt(parts[i])] = false;
			// }
			
			// 	console.log("siz",siz);
			// 	console.log("id",id);
			// console.log("compare", sessionStorage.compare);
			var compare = JSON.parse(sessionStorage.compare);
			for (var i = 0; i < compare.length; i++) {
				if(compare[i].selected){
					siz++;
					names.push(document.getElementById(i+1).getAttribute('name'));
				}
			}
			if (parseInt(siz)<=0) {
				names = ['AC', 'DLF', 'NTPC'];
				// add(1);add(11);add(5);
			}
			// else{
			// 	names= <?php echo json_encode($names); ?>;
			// 	// console.log("2");
			// }
			// 	console.log("names",names);
			
			var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
			var seriesOptions = [], yAxisOptions = [], seriesCounter = 0, colors = Highcharts.getOptions().colors;

			$.each(names, function(i, name) {
				var elements = document.getElementsByName(name);
				var id = elements[0].getAttribute( 'id' );
				var value = elements[0].getAttribute( 'show' );
				
				add(parseInt(id));
				$.ajax({
					url: '../data/'+name+'.csv',
					success: function( data, status ) {
			            
						// console.log( status );
						
						var prices = data.split("\n"), jsonObj = [], match, date, str, amount,d = new Date(),n = d.getTime(), rows = prices.length;
						// console.log(rows);
						for (var j = rows-1; j >= 0; j--) {
							// str = data[i].Date;
							// match = str.match(/^(\d+)-(\d+)-(\d+)$/);
					    	// date = new Date(match[1], match[2] - 1, match[3]);
					    	date = n-j*1 * 24 * 60 * 60 * 1000;
					    	amount = prices[j];
					    	var results = '\n['+String(date)+','+String(amount)+']';
			                jsonObj.push(results);
						}
						// alert(jsonObj);
						jsonObj = '[\n'+String(jsonObj)+'\n]';
						// alert(jsonObj);
						// console.log('jsonObj', jsonObj);

							seriesOptions[i] = {
								name: value,
								data: eval('(' + jsonObj + ')')
							};

							seriesCounter++;
							if (seriesCounter == names.length) {
								createChart();
							}

					},
					error: function( jqXHR, status, error ) {
					// 	console.log( 'Error: ' + error );
					}
				});
			});

			// create the chart when all data is loaded
			function createChart() {

				$('#container').highcharts('StockChart', {
				    chart: {
				    	animation: Highcharts.svg
				    },

				    rangeSelector: {
				        selected: 4
				    },
				    
				    yAxis: {
				    	labels: {
				    		formatter: function() {
				    			return (this.value > 0 ? '+' : '') + this.value + '%';
				    		}
				    	},
				    	plotLines: [{
				    		value: 0,
				    		width: 2,
				    		color: 'silver'
				    	}]
				    },
				    legend: {
				        enabled: true	
				    },
		            credits: {
		                enabled: false
		            },
		            exporting: { 
		            	enabled: false 
		            },
				    plotOptions: {
				    	series: {
				    		compare: 'percent'
				    	}
				    },
				    
				    tooltip: {
				    	pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.change}%)<br/>',
				    	valueDecimals: 2
				    },
				    
				    series: seriesOptions
				});
			}

			$('.list').click(function() {
				var num = parseInt($( this ).attr( "id" ));
				var name = String($( this ).attr( "name" ));
				// console.log("clicked",num,name);
				var compare = JSON.parse(sessionStorage.compare);
				if(compare[num - 1].selected){
					compare[num - 1].selected = false;
				}else{
					compare[num - 1].selected = true;
				}
				sessionStorage.compare = JSON.stringify(compare);
				window.location = 'compare.php';
			});

		</script>
	</body>
</html>
