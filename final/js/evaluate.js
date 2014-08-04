var net_profit, net_credit, array, now, game_start,
	money = JSON.parse(sessionStorage.money),
	stat = JSON.parse(sessionStorage.stat);

// 	console.log(net_profit);
if (stat.status == 'visit') {
	jQuery('#profit_header').hide();
	jQuery('#net_profit').hide();
	
}
jQuery('#profit_header').html('Profit');

jQuery('#credit_header').html('Credit');


jQuery(document).ready(function() {
	var count=0, tim=0, growl, growlmessage = "", growlpending = "",
		shares, timeline, current_price, money, portfolio, port,
		temp = JSON.parse(sessionStorage.list),
		list = temp.companies;

	
	function repeat () {
		
		money = JSON.parse(sessionStorage.money);
		
		
		
		// console.log(JSON.parse(sessionStorage.profit));
		net_profit = Math.round(money.profit*100)/100;
		net_credit = Math.round(money.credit*100)/100;
		// console.log(net_profit, net_credit);
		
		if(net_profit > 0){
			jQuery('#net_profit').css({
				'color': 'green'
			});
			jQuery('#net_profit').html('+'+net_profit.toString());
		}else{
			jQuery('#net_profit').css({
				'color': 'red'
			});
			jQuery('#net_profit').html(net_profit.toString());
		}
		jQuery('#net_credit').html(net_credit);
	}

	function profit_evaluate () { 
		portfolio = JSON.parse(sessionStorage.portfolio);
		shares = JSON.parse(sessionStorage.shares);
		timeline = JSON.parse(sessionStorage.timeline);
		port = Array.apply(null, new Array(list.length)).map(Number.prototype.valueOf,0);

		net_profit = 0;
		for (var i = 0; i < shares.length; i++) {
			current_price = cur_price(shares[i].company);
			if(shares[i].tag == 'buy'){
				net_profit -= shares[i].quantity*(shares[i].price - current_price);
				port[shares[i].id-1] -= shares[i].quantity*(shares[i].price - current_price);
			}else if(shares[i].tag == 'sell'){
				net_profit += shares[i].quantity*(shares[i].price - current_price);
				port[shares[i].id-1] += shares[i].quantity*(shares[i].price - current_price);
			}
		}
		if(cur_sec() > 0){
			sessionStorage.money = JSON.stringify({"credit": net_credit, "profit": net_profit});
			timeline.push({"profit": net_profit});
			portfolio.push({"port": port});
			sessionStorage.portfolio = JSON.stringify(portfolio);
			sessionStorage.timeline = JSON.stringify(timeline);
		}
	}

	function show_growl () { 
		// console.log("growl_message",growlmessage,"growl_pending",growlpending);
		growl = JSON.parse(sessionStorage.growl);
    	growlmessage = growl.message;
    	growlpending = growl.pending;
	    if((growlpending===true || growlpending=='1' || growlpending=='true') && growlmessage !==''){
            
            window.parent.jQuery.growlUI(growlmessage);
            
            var growl = ({"message": '', "pending": false});
            sessionStorage.growl  = JSON.stringify(growl);
	        
	    }
	}

	function bonus_evaluate () {
		var now = new Date().getTime(), game = JSON.parse(sessionStorage.game);
		var bonus_submit = JSON.parse(sessionStorage.bonus_submitted);
		// console.log(now - game_start, (bonus_submit.count + 1)*2*60*10000);
		if(bonus_submit.submitted){
			if (now - game.game_start > (bonus_submit.count + 1)*10*60*1000) {
				var bon = JSON.parse(sessionStorage.bonus);
				var num = bonus_submit.count;
				// console.log("num", num);
				var money = JSON.parse(sessionStorage.money);
				var profit = money.profit;
				bon[num].evaluated = 'yes';
				bon[num].reality = profit;
				var diff = bon[num].expected - profit;
				if(diff<0)diff=0-diff;
				bon[num].awarded = 1000/(2+diff);
				bonus_submit.count += 1;
				sessionStorage.bonus = JSON.stringify(bon);
				sessionStorage.bonus_submitted = JSON.stringify(bonus_submit);
				sessionStorage.growl = JSON.stringify({"pending": true, "message": 'Bonus Awarded !&nbsp;&nbsp;Rs. '+Math.round(bon[num].awarded*100)/100});
			}
		}
		
	}
	

	setTimeout(function(){
		setInterval(function(){
			show_growl();
		},3000);
		
	}, 2000);	
	
	setInterval(function(){
		bonus_evaluate();
	},4000);

	setInterval(function(){
		profit_evaluate();
	},20*1000);
	

	

});