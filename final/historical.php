<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<!-- <link rel="stylesheet" type="text/css" href="css/round.css"/> -->
		<script type="text/javascript" src="../js/jq.js"></script>
		<link rel="stylesheet" type="text/css" href="css/historical.css"/>
		
	<?php 
		$set = true;
		if (isset($_GET['inc']) && !empty($_GET['inc'])) {
			$name = $_GET['inc'];
		    $file = $name.'.csv';
		    $set = false;
		}else{
			$file = 'AC.csv';
			$name = 'AC';
		}
	 ?>
		
	</head>
	<body>
        <!-- 
        <div class="container">
            <div class="content">
            <div class="circle"></div>
            <div class="circle1"></div>
            </div>
        </div> -->
        <div id="container"></div>
        <div id="right">
            <?php include 'list.php'; ?>
        </div>

        <script src="../Highstock/js/highstock.js"></script>
        <script src="../Highstock/js/modules/exporting.js"></script>
        <script type="text/javascript" src="js/common.js"></script>
        <script type="text/javascript" src="js/historical.js"></script>
        <script type="text/javascript" src="theme/historical.js"></script>

        <script type="text/javascript">
            var name, id, value;
            var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
        	var set = "<?php echo $set;?>";
        	if (set) {
        		add(11);
                id = 11;
                value = 'Ambuja Cement';
                name = 'AC';
        	}else{
        		name = "<?php echo $name;?>";
        		id = document.getElementsByName(name)[0].id;
                value = document.getElementsByName(name)[0].getAttribute( 'show' );
                console.log(name, id, value);
        		add(parseInt(id));
        	}
        
        	$.ajax({
        			url: '../data/'+"<?php echo $file; ?>",
        			success: function( data, status ) {
        	            
        				// console.log( status );
        				
        				var prices = data.split("\n");
        				// console.log( prices );
        				var jsonObj = [], match, date, str, rows = data.length, amount,d = new Date(),n = d.getTime();
        				
        				for (var i = rows-1; i >= 0; i--) {
        						
        						// str = data[i].Date;
        						
        				  //   	match = str.match(/^(\d+)-(\d+)-(\d+)$/);
        				  //   	date = new Date(match[1], match[2] - 1, match[3]);
        				    	date = n-i*1 * 24 * 60 * 60 * 1000;
        				    	amount = prices[i];
        				    	var results = '\n['+String(date)+','+String(amount)+']';
        		                jsonObj.push(results);
        				}
        				// alert(jsonObj);
        				jsonObj = '[\n'+String(jsonObj)+'\n]';
        				// alert(jsonObj);
        				// console.log('jsonObj', jsonObj);
        				// Create the chart
        				$('#container').highcharts('StockChart', {
        					
        
        					rangeSelector : {
        						selected : 1
        					},
        	                credits: {
        	                    enabled: false
        	                },
        	                exporting: { 
        	                	enabled: false 
        	                },
        					title : {
        						text : 'Historical Stock Price'
        					},
        					
        					series : [{
        						name : value,
        						data : eval('(' + jsonObj + ')'),
        						tooltip: {
        							valueDecimals: 2
        						},
        						fillColor : {
        							linearGradient : {
        								x1: 0, 
        								y1: 0, 
        								x2: 0, 
        								y2: 1
        							},
        							stops : [[0, Highcharts.getOptions().colors[0]], [1, 'rgba(0,0,0,0)']]
        						}
        					}]
        				});
        
        			},
        			error: function( jqXHR, status, error ) {
        				// console.log( 'Error: ' + error );
        			}
        		});
        
        
        </script>
	</body>
</html>
