<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
        <link rel="stylesheet" type="text/css" href="css/smooth.css"/>
        <link rel="stylesheet" type="text/css" href="css/portfolio.css"/>
        <link rel="stylesheet" type="text/css" href="css/port.css"/>
        
		<script type="text/javascript" src="../js/jq.js"></script>
        <script type="text/javascript" src="../js/jq-ui.js"></script>
        <script src="../Highcharts/js/highcharts.js"></script>
        <script src="../Highcharts/js/modules/exporting.js"></script>
	
	</head>
	<body>


<script type="text/javascript" src="theme/port.js"></script>
<script type="text/javascript">

var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
var set = "<?php echo $set;?>";
var cur_price = "<?php echo $cur_price;?>";

var game_start = "<?php echo $game_start;?>";
// console.log("game_start",game_start);

var quantity = <?php echo json_encode($quantity);?>;
var tag = <?php echo json_encode($tag);?>;
var time = <?php echo json_encode($time);?>;
var price = <?php echo json_encode($price);?>;

var now_string = <?php echo json_encode($now); ?>;
var now = Number(now_string);

// console.log("quan",quantity,'tag',tag,'time',time,'price',price);

$(function () {
    
    $(document).ready(function() {
        var prices,rows,start,start_quantity,pass_time,amount,d,n,invested;
        invested = 0;
        for (var i = time.length - 1; i >= 0; i--) {
            
                if (tag[i]=='buy') {
                    invested+=quantity[i]*price[i];
                }else {
                    invested-=quantity[i]*price[i];
                }
        }
        // console.log(invested);
        function time_quantity (start_time) {
            var ret = 0;
            for (var i = time.length - 1; i >= 0; i--) {
                if(time[i] < start_time){
                    if (tag[i]=='buy') {
                        ret+=parseInt(quantity[i]);
                    }else{
                        ret-=parseInt(quantity[i]);
                    }
                }
            }
            // console.log("ret",ret);
            return ret;
        }

        
        pass_time = 0;
        start_quantity = Math.round(game_start/10000);
        start = Math.round(game_start/10000);
        Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });
        
        $.ajax({
                url: '../data/'+"<?php echo $file; ?>",
                success: function( data, status ) {
                
                    // console.log( status );
                    
                    prices = data.split(/\n|\s+/);
                    // console.log(prices);
                    rows = prices.length;
                    // console.log(rows);
                    // var amount,d,n;
                    n = (new Date()).getTime();
                    n = "<?php echo $game_start;?>";
                    start = n%rows;
                    createChart();
                    
                },
                error: function( jqXHR, status, error ) {
                    // console.log( 'Error: ' + error );
                }
                
        });
            
        
        
        
        function createChart(){
            var chart;

            $('#container').highcharts({
                chart: {
                    type: 'area',
                    animation: Highcharts.svg, // don't animate in old IE
                    marginRight: 10,
                    events: {
                        load: function() {
            
                            // set up the updating of the chart each second
                            var series = this.series[0];
                            setInterval(function() {
                                console.log("price",prices[start],"quantity",time_quantity(pass_time),"invested",invested)
                                var x = now, // current time
                                    y = time_quantity(pass_time)==0?0:Math.round(((prices[start])*time_quantity(pass_time)-invested)*100)/100
                                    // y = Math.random()
                                series.addPoint([x, y], true, false);
                                start++;
                                pass_time++;
                                start%=rows;
                                now += 20*1000*10000;
                            }, 20*1000);
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
                    text: "<?php echo $name; ?>"
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
                            return '<b>'+ this.series.name +'</b><br/>'+
                            Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) +'<br/>'+
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
                        var data = [], time = now, i, newTime = (new Date()).getTime();
                        
                        // console.log("now",newTime,"start",game_start);
                        var timeDiff = Math.round((newTime - game_start/10000)/(20*1000));
                        // console.log("diff",timeDiff);
                        for (i = -timeDiff ; i <= 0; i++) {
                            // console.log(prices[start]);
                            pass_time++;
                            start%=rows;
                            data.push({
                                x: time + i * 20*1000*10000,
                                y: time_quantity(pass_time)===0?0:Math.round(((prices[start])*time_quantity(pass_time)-invested)*100)/100
                            });
                            start++;
                            
                        }
                        return data;
                    })()
                }]
            });
        }

    });
    
});
        </script>
	</body>
</html>
