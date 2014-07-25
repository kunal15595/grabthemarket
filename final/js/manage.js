function cur_price (comp) {
	var ret, now = (new Date()).getTime(), game = JSON.parse(sessionStorage.game);
	if(now < game.game_start)return past_price(comp);
	jQuery.ajax({
        url: '../data/'+String(comp)+'.txt',
        async: false, 
        success: function( data, status ) {
            var prices = data.split(/\n|,|\s+/);
            // console.log(prices);
            var rows = prices.length;
            // console.log(rows);
            var game = JSON.parse(sessionStorage.game);
            var time_diff_5 = Math.round((new Date().getTime() - game.game_start)/(1000*5));
            // console.log("cur_price", prices[(time_diff + game.game_start)%(prices.length-1)]);
            ret = prices[(time_diff_5 + game.game_start)%(prices.length-1)];
            // console.log("ret", ret);
        },
        error: function( jqXHR, status, error ) {
            console.log( 'Error: ' + error );
        }
    });
    return parseFloat(ret); 
    
}

function past_price (comp) {
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
            ret = prices[(game.game_start)%(prices.length-1)];
            
        },
        error: function( jqXHR, status, error ) {
            console.log( 'Error: ' + error );
        }
    });
    return parseFloat(ret); 
}

function cur_sec () {
	var game = JSON.parse(sessionStorage.game);
	return new Date().getTime() - game.game_start;
}
	
// setStatus('manage');
jQuery(document).ready(function() {
	// console.log("statuss",pre_status);
	jQuery('.container').hide();
	function block () {
	    window.jQuery.blockUI({ 
	        message: jQuery('.container'),
	        css: { 
	        width: '150px',
	        height: '150px',
	        // border: '2px solid green',
	        'margin-left': '0px',
	        'margin-top': '0px',
	        border: 'none', 
	        padding: '15px', 
	        backgroundColor: 'transparent', 
	        '-webkit-border-radius': '10px', 
	        '-moz-border-radius': '10px', 
	        opacity: .5, 
	        color: '#fff' 
	    } });   
	}
	jQuery('.list').click(function() {
		// alert("ok");
		name = String(jQuery( this ).attr( "name" ));
		jQuery('.list').css(
		{
			"color": "#dddddd",
			// background: "linear-gradient(to right, silver, white)",
			"text-align": "center",
			width: "80%",
			"background-color": "#222222"
		}
		);
		jQuery(this).css(
		{
		  "color": "#222222",
		  // background: "linear-gradient(to left, silver, white)",
		  "text-align": "center",
		  width: "100%",
		  "background-color": "#aaaaaa"
		  
		}
		);

		var redirect = String(jQuery( this ).attr( "name" ));
		window.location = 'manage.php?inc='+redirect;
	
	});
	jQuery('#buy').click(function() {
		jQuery(this).prop('disabled', true);
		var quantity = jQuery( "#buyslider" ).slider( "value" );
		var shares = JSON.parse(sessionStorage.shares);
		var money = JSON.parse(sessionStorage.money);
		var price;
		// console.log("quantity", quantity);
		if (cur_sec() > 0) {
			price = cur_price(name);
		}else{
			price = past_price(name);
		}
		price = Math.round(price*100)/100;
		console.log(price);
		money.credit -= price*quantity;
		sessionStorage.money = JSON.stringify(money);
		shares.push({"company": name, "price": price, "quantity": quantity, "tag": 'buy', "id": document.getElementsByName(name)[0].getAttribute( 'id' )});
		sessionStorage.shares = JSON.stringify(shares);
		
		block();
		var growl = {"message": 'Buyed '+quantity+' share(s) of '+document.getElementsByName(name)[0].getAttribute( 'show' )+' @ Rs. '+price, "pending": true};
		sessionStorage.growl = JSON.stringify(growl);
		
		window.location = 'manage.php?inc='+name;
		
	});
	jQuery('#sell').click(function() {
		jQuery(this).prop('disabled', true);
		var quantity = jQuery( "#sellslider" ).slider( "value" );
		var shares = JSON.parse(sessionStorage.shares);
		var money = JSON.parse(sessionStorage.money);
		var price = cur_price(name);
		price = Math.round(price*100)/100;
		money.credit += price*quantity;
		sessionStorage.money = JSON.stringify(money);
		shares.push({"company": name, "price": price, "quantity": quantity, "tag": 'sell', "id": document.getElementsByName(name)[0].getAttribute( 'id' )});
		sessionStorage.shares = JSON.stringify(shares);
		
		block();
		var growl = {"message": 'Sold '+quantity+' share(s) of '+document.getElementsByName(name)[0].getAttribute( 'show' )+' @ Rs. '+price, "pending": true};
		sessionStorage.growl = JSON.stringify(growl);
		
		window.location = 'manage.php?inc='+name;
	});
	
});