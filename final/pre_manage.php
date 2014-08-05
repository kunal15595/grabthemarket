<!DOCTYPE HTML>
<html style="background-color: #111111;">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<link rel="stylesheet" type="text/css" href="css/smooth.css"/>
        <link rel="stylesheet" type="text/css" href="css/manage.css"/>
        
		<script type="text/javascript" src="../js/jq.js"></script>
        <script type="text/javascript" src="../js/jq-ui.js"></script>
        <script type="text/javascript" src="../js/block.js"></script>
        <script type="text/javascript" src="js/common.js"></script>
		<?php
			if (!isset($_SESSION)) {
	            session_start();
	        }
			$set = true;
			$name = "";
			if (isset($_GET['inc']) && !empty($_GET['inc'])) {
				$name = $_GET['inc'];
			    $set = false;
			}
			
		?>
		<script type="text/javascript">
			var game = JSON.parse(sessionStorage.game);
			var now = right_now();
			
			
		</script>
	</head>
	<body>
        <div class="container">
		    <div class="content">
		    <div class="circle"></div>
		    <div class="circle1"></div>
		    </div>
		</div>
		<div id="wrap">
			<div id="rest">
				
					<table>
					<tr>
						<p  class="share_bar">
						  <label for="num_shares">Number of shares in portfolio:</label>
						  <input type="text" id="num_shares" readonly="readonly" style="border:0; color:orange; font-weight:bold;">
						</p>
					</tr>
					<tr>
						<p  class="share_bar">
						  <label for="current_price">Opening price of share:</label>
						  <input type="text" id="current_price" readonly="readonly" style="border:0; color:orange; font-weight:bold;">
						</p>
					</tr>
					<tr>
						<p  class="share_bar">
						  <label for="max_buy">Max. shares you can buy:</label>
						  <input type="text" id="max_buy" readonly="readonly" style="border:0; color:orange; font-weight:bold;">
						</p>
					</tr>
					
					<tr style="background-color:red;">
						<div id="buyslider"></div>
						<button id="buy" style="color: red; border-radius: 3px;">Buy</button>
					</tr>
					<tr>
						<p class="buy_bar">
						  <label for="buy_amount" id="buy_label">Number of shares to buy:</label>
						  <input type="text" id="buy_amount" readonly="readonly" style="border:0; color:#ff0000; font-weight:bold;">
						</p>
					</tr>
					<tr>
						<div id="sellslider"></div>
						<button id="sell" style="color: green; border-radius: 3px;">Sell</button>
					</tr>
					<tr>
						<p class="sell_bar">
						  <label for="sell_amount" id="sell_label">Number of shares to sell:</label>
						  <input type="text" id="sell_amount" readonly="readonly" style="border:0; color:#00ff00; font-weight:bold;">
						</p>
					</tr>
					<tr>
						<p class="broker">
						  <label for="broker_advice" id="sell_label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Broker's Advice:</label>
						  <input type="text" id="broker_advice" readonly="readonly" style="border:0; color:orange; font-weight:bold;">
						  <label for="broker_price" id="sell_label">Target:</label>
						  <input type="text" id="broker_price" readonly="readonly" style="border:0; color:orange; font-weight:bold;">
						</p>
					</tr>
				</table> 
				
				
			</div>
			<div id="right">
				<?php include 'list.php'; ?>
			</div>
			
		</div>
		<script type="text/javascript" src="js/common.js"></script>
		
		<script type="text/javascript">
			var name, id;
			var shares = JSON.parse(sessionStorage.shares);
			var stat = JSON.parse(sessionStorage.stat);
			var set = "<?php echo $set;?>", pre_status = stat.status;
			var tmp = JSON.parse(sessionStorage.list);
			var list = tmp.companies;
			var temp = Math.round(Math.random()*20);
			console.log(set);
			if (set) {
				add(temp);
				id = list[temp].id;
				name = list[temp].name;
			}else{
				name = "<?php echo $name;?>";
				id = document.getElementsByName(name)[0].id;
				add(parseInt(id));
			}
			var last_price = past_price(name),comp_shares = 0, net_credit;
			
			function repeat(){
				var money = JSON.parse(sessionStorage.money);
				net_credit = money.credit;
			}
			repeat();
			for (var i = 0; i < shares.length; i++) {
				if(shares[i].company == name){
					if (shares[i].tag == 'buy') {
						comp_shares+=shares[i].quantity;
					}else{
						comp_shares-=shares[i].quantity;
					}
				}
			}
		    jQuery.noConflict();

			
			
			if (comp_shares==0) {
				jQuery																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																												('#sell').hide();
				jQuery('#sellslider').hide();
				jQuery('#sell_amount').hide();
				jQuery('#sell_label').html('');																																																																																																									
				
			}
			if (parseInt(Math.floor(net_credit/past_price))==0) {
				jQuery('#buy').hide();
				jQuery('#buyslider').hide();
				jQuery('#buy_amount').hide();
				jQuery('#buy_label').html('');
			}

			
		
			jQuery( "#num_shares" ).val( comp_shares );
			jQuery( "#current_price" ).val( Math.round(last_price*100)/100 );
			
			jQuery( "#max_buy" ).val( parseInt(Math.floor(net_credit/last_price)) );
			jQuery( "#max_sell" ).val( parseInt(comp_shares) );
			jQuery( "#broker_price" ).val( mid_price(name) );
			jQuery( "#broker_advice" ).val( mid_price(name)>cur_price(name)?'Buy':'Sell' );
			// jQuery.noConflict();
		    jQuery(function() {
		        jQuery( "#buyslider" ).slider({
		          value:0,
		          min: 1,
		          max: parseInt(Math.floor(net_credit/last_price)),
		          step: 1,
		          slide: function( event, ui ) {
		            jQuery( "#buy_amount" ).val( ui.value );
		          }
		    });
		    jQuery( "#buy_amount" ).val( jQuery( "#buyslider" ).slider( "value" ) );
		    });
		
		    jQuery(function() {
		        jQuery( "#sellslider" ).slider({
		          value:0,
		          min: 1,
		          max: parseInt(comp_shares),
		          step: 1,
		          slide: function( event, ui ) {
		            jQuery( "#sell_amount" ).val( ui.value );
		          }
		    });
		    jQuery( "#sell_amount" ).val( jQuery( "#sellslider" ).slider( "value" ) );
		    });

	    	setInterval(function(){
	    		repeat();
	    	},1500);
		</script>
		<script type="text/javascript" src="js/manage.js"></script>
	</body>

</html>
