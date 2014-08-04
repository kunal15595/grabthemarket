<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Highcharts Example</title>
        
        
	<?php 
        if (!isset($_SESSION)) {
            session_start();
        }
        // die("ok");
        $game_start = number_format($_SESSION['game_start'], 0, '', '');
        $now = microtime(true)*1000*10000;
        if ($now < $game_start) {
           ?>
                <p style="color: orange;">Markets have not yet opened</p>
            <?php
            die("");
        }
        $set = true;
        if (isset($_GET['inc']) && !empty($_GET['inc'])) {
            $name = $_GET['inc'];
            $file = $name.'.txt';
            $set = false;
        }
    ?>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
        <link rel="stylesheet" type="text/css" href="css/smooth.css"/>
        <link rel="stylesheet" type="text/css" href="css/round.css"/>
        <link rel="stylesheet" type="text/css" href="css/current.css"/>
        <script type="text/javascript" src="../js/jq.js"></script>
        <script type="text/javascript" src="../js/jq-ui.js"></script>
	</head>
	<body>
        <script src="../Highcharts/js/highcharts.js"></script>
        <script src="../Highcharts/js/modules/exporting.js"></script>
        <script type="text/javascript" src="js/common.js"></script>
        <script type="text/javascript" src="js/current.js"></script>

        <div class="container">
            <div class="content">
            <div class="circle"></div>
            <div class="circle1"></div>
            </div>
        </div>
        <!-- <a class="triggerFull" href="#">Play/Stop Animation</a>
         -->
        <div id="container"></div>
        <div id="right">
            <?php include 'list.php'; ?>
        </div>
        <script type="text/javascript" src="theme/current.js"></script>
        <script type="text/javascript">
            var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
            var game = JSON.parse(sessionStorage.game);
            var set = "<?php echo $set;?>";
            var game_start = game.game_start;
            var list = JSON.parse(sessionStorage.list).companies;
            // console.log("game_start",game_start);
            var now = (new Date()).getTime();
            var temp = Math.round(Math.random()*20);
            if (set) {
                add(temp);
            }else{
                var id = document.getElementsByName("<?php echo $name;?>")[0].id;
                add(parseInt(id));
            }
   
            $(document).ready(function() {
                var prices, rows, amount, d = new Date(), n = d.getTime(), start = game_start;
                // console.log('start', start);   
                Highcharts.setOptions({
                    global: {
                        useUTC: false
                    }
                });
                
                jQuery.ajax({
                        url: '../data/'+list[temp].name+'.txt',
                        success: function( data, status ) {
                            prices = data.split(/\n+|\s+/);
                            // console.log("prices", prices);
                            rows = prices.length;
                            // console.log("rows", rows);
                            // start = n%rows;
                            createChart();
                        }
                });

                function createChart(){
                    
                    $('#container').highcharts({
                        chart: {
                            type: 'spline',
                            animation: Highcharts.svg, // don't animate in old IE
                            marginRight: 40,
                            events: {
                                load: function() {
                    
                                    // set up the updating of the chart each second
                                    var series = this.series[0];
                                    setInterval(function() {
                                        start%=(rows-1);
                                        var x = (new Date()).getTime(), // current time
                                            y = Math.round(prices[start]*100)/100
                                            // y = Math.random()
                                        series.addPoint([x, y], true, false);
                                        start++;
                                        
                                        
                                    }, 20*1000);
                                }
                            }
                        },

                        rangeSelector: {
                            selected: 4
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
                            text: 'Live data'
                        },
                        xAxis: {
                            type: 'datetime',
                            tickPixelInterval: 150,
                            title: {
                                text: 'Time'
                            }
                        },
                        yAxis: {
                            title: {
                                text: 'Value'
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
                                // console.log(Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x), Highcharts.numberFormat(this.y, 2));
                                    return '<b>'+ this.series.name +'</b><br/>'+
                                    Highcharts.dateFormat('%l:%M:%S',this.x) +'<br/>'+
                                    Highcharts.numberFormat(this.y, 2);
                            }
                        },
                        legend: {
                            enabled: false

                        },
                        
                        series: [{
                            name: 'Stock price',
                            // color: '#FF0000',
                            // negativeColor: '#0088FF',
                            // threshold: 38.35,
                            data: (function() {
                                // generate an array of random data
                                var data = [], time = (new Date()).getTime(), i;
                                // console.log(start,prices);
                                // console.log("now",now,"start",game_start);
                                timeDiff = Math.round((new Date().getTime() - game.game_start)/(1000*20));
                                // console.log(timeDiff);
                                // console.log("diff",timeDiff);
                                for (i = -timeDiff ; i <= 0; i++) {
                                    // console.log(prices[start]);
                                    start%=(rows-1);
                                    data.push({
                                        x: time + i*20*1000,
                                        y: Math.round(prices[start]*100)/100
                                        // y: Math.random()
                                    });
                                    start++;
                                    
                                }
                                return data;
                            })()
                        }]
                    });
                }

            });
                
        </script>
	</body>
</html>
