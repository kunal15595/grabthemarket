 var status, flag = [], length = 21; 

jQuery(document).ready(function(){
	

	for(var i = 1; i <= length; i++) {
	    flag.push(true);
	}

	jQuery('.list').click(function() {

		var num = parseInt(jQuery( this ).attr( "id" ));
		// console.log(status,status);
		if (status=='current') {
			clearall();
			jQuery(this).css({
				// background: "linear-gradient(to right, #aaaaaa, white)",
				"color": "#222222",
				width: "100%",
				"text-align": "center",
				"background-color": "#aaaaaa"
			});
			flag[num]=false;
		}
	});
	jQuery('.trends').click(function() {
		// alert("yahoo");
	});
});

	function setStatus(input) {
		status = input;
	// 	console.log(status);
	}
	function getStatus () {
		return status;
	}
	function get (num) {
		return flag[num];
	}
	function set (num,bol) {
		flag[num]=bol;
	}
	function add_page (argument) {
		var id= '#'+String(argument);
		jQuery(id).css({
			// "color": "black",
			width: "100%",
			// "text-align": "center",
			// "background-color": "#00EE00"
		});
	}
	function add_tenure (argument) {
		var id= '#'+String(argument);
		jQuery(id).css({
			"color": "#cccc99",
			// "border": "1px solid white",
			// "opacity": "0.5",
			// "background": "inherit"
			// height: "80%",
			// "text-align": "center",
			"background-color": "#666633"
		});
	}
	function add (num) {
		var x='#'+String(num);
		jQuery(x).css({
		  // background: "linear-gradient(to right, #aaaaaa, white)",
		  // "color": "#222222",
		  width: "100%",
		  "font-weight": "bold",
		  height: "20px",
		  // "text-align": "center",
		  "background-color": "#000000"
		});
		flag[num]=false;
	}
	function remove (num) {
		var x='#'+String(num);
		jQuery(x).css(
		{
			// "color": "#dddddd",
			width: "80%",
			// "text-align": "center",
			"background-color": "#333333"
		});
		flag[num]=true;
	}

	function clearall () {
		jQuery('.list').css(
		{
			"color": "#dddddd",
			"width": "80%",
			"text-align": "center",
			"background-color": "#222222"
		});
		for(var i = 1; i <= 21; i++) {
		    flag[i]=true;
		}

	}

	function cur_price (comp) {

		var ret, now = right_now(), game = JSON.parse(sessionStorage.game);
		if(now < game.game_start)return past_price(comp);
		var temp = JSON.parse(sessionStorage.list);
		var list = temp.companies;
		for (var i = 0; i < list.length; i++) {
			if(list[i].name == comp.toString())return list[i].span_price[Math.round((now - game.game_start)/(1000*20))];
		}
		jQuery.ajax({
            url: '../data/'+String(comp)+'.txt',
            async: false, 
            success: function( data, status ) {
                var prices = data.split(/\n|,|\s+/);
                // console.log(prices);
                var rows = prices.length;
                // console.log(rows);
                var game = JSON.parse(sessionStorage.game);
                var time_diff_5 = Math.round((right_now() - game.game_start)/(1000*20));
                // console.log("cur_price", prices[(time_diff + game.game_start)%(prices.length-1)]);
                ret = prices[(time_diff_5 + game.game_start)%(prices.length-1)];
                // console.log("ret", ret);
            },
            error: function( jqXHR, status, error ) {
                console.log( 'Error: ' + error );
            }
        });

        return Math.round(parseFloat(ret)*100)/100; 
        
	}

	function mid_price (comp) {
		var ret, now = right_now(), game = JSON.parse(sessionStorage.game), broker = JSON.parse(sessionStorage.broker);
		if(now < game.game_start)now = game.game_start;
		jQuery.ajax({
            url: '../data/'+String(comp)+'.txt',
            async: false, 
            success: function( data, status ) {
                var prices = data.split(/\n|,|\s+/);
                // console.log(prices);
                var rows = prices.length;
                // console.log(rows);
                var game = JSON.parse(sessionStorage.game);
                var time_diff_5 = Math.round((game.game_stop - now)/(1000*20*2));
                // console.log("cur_price", prices[(time_diff + game.game_start)%(prices.length-1)]);
                ret = prices[(time_diff_5 + game.game_start)%(prices.length-1)];
                // console.log("ret", ret);
            },
            error: function( jqXHR, status, error ) {
                console.log( 'Error: ' + error );
            }
        });
        var broker = JSON.parse(sessionStorage.broker);
		var delta = parseInt(broker.tag);

        ret*= 1+(5-delta)/100-2*(5-delta)*broker.random/100;
        // console.log(ret, delta, broker);
        return Math.round(parseFloat(ret)*100)/100; 
        
	}
	
	function past_price (comp) {

		if (sessionStorage.getItem('list')){
			var temp = JSON.parse(sessionStorage.list);
			var list = temp.companies;
			for (var i = 0; i < list.length; i++) {
				if(list[i].name == comp.toString())return list[i].starting_price;
			}
		}
		var ret, prices,now = right_now();
		var game = JSON.parse(sessionStorage.game);
		jQuery.ajax({
            url: '../data/'+String(comp)+'.txt',
            async: false, 
            success: function( data, status ) {
                prices = data.split(/\n|,|\s+/);
                // console.log(prices);
                var rows = prices.length;
                // console.log(rows);
                
                ret = prices[(game.game_start)%(prices.length-1)];
                
            },
            error: function( jqXHR, status, error ) {
                console.log( 'Error: ' + error );
            }
        });
        
		if(now < game.game_start)return prices;
        else return Math.round(parseFloat(ret)*100)/100; 
	}

	function end_price (comp) {
		var ret;
		jQuery.ajax({
            url: '../data/'+String(comp)+'.txt',
            async: false, 
            success: function( data, status ) {
                var prices = data.split(/\n|,|\s+/);
                // console.log(prices);
                var rows = prices.length;
                // console.log(rows);
                var game = JSON.parse(sessionStorage.game);
                ret = prices[(game.game_stop)%(prices.length-1)];
                
            },
            error: function( jqXHR, status, error ) {
                console.log( 'Error: ' + error );
            }
        });
        
        return Math.round(parseFloat(ret)*100)/100; 
	}

	function cur_sec () {
		var game = JSON.parse(sessionStorage.game);
		return right_now() - game.game_start;
	}
	
	function block (mess) {
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

    function right_now () {
    	var ret = (new Date()).getTime() - JSON.parse(sessionStorage.client_time_diff);
    	return ret;
    }

    function date_now () {
    	var ret = new Date(right_now());
    	return ret.getDate();
    }