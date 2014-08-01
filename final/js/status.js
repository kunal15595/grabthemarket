
var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
var status_retrieve = '', data, net_profit, tim = 0, count = 0, prices,rows,start,amount,d,n, timeline, money;
var set = "<?php echo $set;?>";
var game_start = "<?php echo $game_start;?>";
// console.log("game_start",game_start);

var now_string = "<?php echo json_encode($now); ?>";
var now = Number(now_string);

$(document).ready(function() {
    start = Math.round(game_start/10000);
                    
    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });
    
    
    function repeat () {
        timeline = JSON.parse(sessionStorage.timeline);
        money = JSON.parse(sessionStorage.money);
        net_profit = money.profit;
    }
    repeat();
    $('#status_container').highcharts({
        chart: {
            type: 'area',
            animation: Highcharts.svg, // don't animate in old IE
            marginRight: 10,
            events: {
                load: function() {
    
                    // set up the updating of the chart each second
                    var series = this.series[0];
                    setInterval(function() {
                    	
                        var x = (new Date()).getTime(), y = Math.round(net_profit*100)/100;
                            // y = Math.random()
                        series.addPoint([x, y], true, false);
                        repeat();
                        
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
            text: 'Profit Timeline'
        },
        xAxis: {
            type: 'datetime',
            tickPixelInterval: 150
        },
        yAxis: {
            title: {
                text: 'Value (Rs.)'
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
                    Highcharts.dateFormat('%l:%M:%S', this.x) +'<br/>Profit : '+
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
            name: 'Net Profit',
            color: '#00FF00',
            negativeColor: '#FF0000',
            threshold: 0,
            data: (function() {
                // generate an array of random data
                var data = [], time = (new Date()).getTime(), i;
            // console.log(start,prices);
                // newTime = (new Date()).getTime();
                
                // console.log("now",newTime,"start",game_start);
                // timeDiff = Math.round(((newTime - game_start/10000)/10000)/5);
                timeDiff = timeline.length;
                // console.log("status_retrieve", status_retrieve);
                // console.log("timeline",timeline);
                for (i = 2-timeDiff; i <= 0; i++) {
                    // console.log(prices[start]);
                    // start%=rows;
                    // console.log(time + i * 1000,":",Math.round(parseFloat(status_retrieve[i-2+timeDiff])*100)/100);
                    data.push({
                        x: time + i*20*1000,
                        y: Math.round(parseFloat(timeline[i-2+timeDiff].profit)*100)/100
                        // y: Math.random()
                    });
                    // start++;
                    
                }
                return data;
            })()
        }]
    });
    
});
