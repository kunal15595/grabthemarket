jQuery(document).ready(function() {
    // console.log("status: ",status);
    // if (status=='start') {
    //     jQuery('#container').css({
    //         // "pointer-events": "none"
    //     });
    // }
    jQuery('#submit').hide();
    jQuery('.container').hide();
    // jQuery('.container').css({
    //     'width': '0px',
    //     'height': '0px'
        
    // });
    
    var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
    var currentIndexSelected, net_profit = '',reality = '', data = [], data2 = [], data3 = [];

    
    var sub = JSON.parse(sessionStorage.bonus_submitted);
    // console.log("bonus_submitted", sub);
    if (sub.submitted) {
        var bon = JSON.parse(sessionStorage.bonus);
        console.log("bon", bon);
        for (var i = 0; i < 10; i++) {
            data.push({x:2*(i+1), y:parseFloat(bon[i].expected)});
        }
        var count = sub.count;
        for (var i = 1; i < count+1; i++) {
            data2.push({x:2*i, y:parseFloat(bon[i-1].reality)});
            data3.push({x:2*i, y:parseFloat(bon[i-1].awarded)});    
        }
    } else{
        data = [
            {x:2*1, y:129.9}, {x:2*2, y:71.5}, {x:2*3, y:106.4},{x:2*4, y:-12.2},
            {x:2*5, y:34.0}, {x:2*6, y:-32.0}, {x:2*7, y:135.6}, {x:2*8, y:148.5},
            {x:2*9, y:216.4}, {x:2*10, y:194.1}
        ];
    }    
    
    createChart();

    function createChart () {
        var chart = new Highcharts.Chart({
            title: {
             text: status!='visit'?'Predicted Profit':'Predict your Profit'
            },
            chart: {
                renderTo: 'container',
                defaultSeriesType: 'spline',
                events: {
                    click: function (e) {
                        // find the clicked values and the series
                   
                    }
                }
            },
            xAxis: {
                title: {
                    text: 'Time of Play (min.)'
                }
            },
            yAxis: {
                title: {
                    text: 'Net Profit (Rs.)'
                }
            },
            credits: {
                enabled: false
            },
            exporting: { 
                enabled: false 
            },
            legend: {
                layout: 'vertical',
                enabled: true,
                floating: false,
                backgroundColor: '#FFFFFF',
                align: 'right',
                verticalAlign: 'top',
                y: 60,
                x: -60
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' + this.x + ': ' + Math.round(this.y*100)/100;
                }
            },
            plotOptions: {},
            series: [{
                allowPointSelect: status=='start'?false:true,
                cursor: status!='visit'?'null':'ns-resize',
                name: 'Predicted',
                point: {
                    events: {}
                },
                data: data,
                //data: [[1,29.9], [2,71.5],[3,106.4], [4,129.2], [5,144.0], [6,176.0], [7,135.6], [8,148.5], [9,216.4], [10,194.1], [11,95.6], [12,54.4]],
                draggableX: false,
                draggableY: status=='start'?false:true,

            }]
        });

        // console.log("status", status);

        if(status!='visit'){
            if (sub.submitted)anotherChart();
            jQuery('#submit').hide();
        }else{
            jQuery('#submit').show();
        }

    } 


    function anotherChart () {
        var chart = jQuery('#container').highcharts();
        console.log("data2", data2);
        if (chart.series.length == 1) {
            // chart.series[0].remove();
            chart.addSeries({
                data: data2,
                draggableX: false,
                draggableY: false,
                name: 'Reality'
            });
        }
    
        var chart = jQuery('#container').highcharts();
        if (chart.series.length == 2) {
            // chart.series[0].remove();
            chart.addSeries({
                data: data3,
                draggableX: false,
                draggableY: false,
                name: 'Awarded bonus'
            });
        }
        
    }

    function block () {
        window.parent.jQuery.blockUI({ 
            message: jQuery('.container'),
            css: { 
            width: '150px',
            height: '150px',
            // border: '2px solid green',
            'margin-left': '0px auto',
            'margin-top': '0px auto',
            border: 'none', 
            padding: '15px', 
            backgroundColor: 'transparent', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: 0.5, 
            color: '#fff' 
        } });   
    }
    jQuery('#button1').click(function () {
        //this.point[currentIndexSelected].remove();
        var chart = jQuery('#container').highcharts();
        if (chart.series.length == 1) {
            //chart.series[0].remove();
            chart.addSeries({
                data: [194.1, 95.6, 4, 434, 35, 54, 54.4, 29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 35, 4, 334, 35, 54, 3],
                draggableX: true,
                draggableY: true
            });
        }

        var series = chart.getSelectedSeries();
        jQuery('#out').html('length:' + series.length);
        // if(data.length<series[0].data.length){
        //    jQuery('#out').html('smaller');
        // }
        /* for(var i=0; i<series.data.length; i++){
             data[i] = series.data[i];   
        }*/
        //if (series.data.length) {
        // categories.splice(currentIndexSelected,1);
        data.splice(currentIndexSelected, 1);

        //var newSerie = 
        chart.series[1].setData(data);
        chart.redraw();
        //chart.xAxis[0].setCategories(categories);
        //}
    });

    // button handler
    jQuery('#button2').click(function () {
        //this.point[currentIndexSelected].remove();
        //var series = chart.series[0];
        var series = chart.getSelectedSeries();

        //categories.splice(currentIndexSelected,1);
        data.splice(currentIndexSelected, 1);

        chart.series[0].setData(data);
        chart.xAxis[0].setCategories(categories);

    });
    jQuery('#submit').click(function() {
        jQuery(this).prop('disabled', true);
        
        var bonus = [];
        console.log("data", data);
        data_string='';
        for (var i = 0; i < data.length; i++) {
            bonus.push({"min": (i+1)*2, "expected": Math.round(data[i].y*100)/100, "reality": 0, "evaluated": 'no', "awarded": 0});
            
        }
        sessionStorage.bonus = JSON.stringify(bonus);
        var bon = JSON.parse(sessionStorage.bonus_submitted);
        bon.submitted = true;
        sessionStorage.bonus_submitted = JSON.stringify(bon);

        block();
        window.parent.location = 'index.php?inc=bonus';
        
    });
});