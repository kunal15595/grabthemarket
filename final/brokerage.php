<!DOCTYPE html>
<html>
	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<link rel="stylesheet" type="text/css" href="css/brokerage.css"/>
		<script type="text/javascript" src= "../js/jq.js"></script>
		<script type="text/javascript" src= "js/common.js"></script>
		<script type="text/javascript" src="../js/jq-ui.js"></script>
	</head>
	<body>
		<div id="broke"></div>
		<div id="tab">
            <table id="table">
                <tr id="names">
                    <td class="character blank"></td>
                    
                </tr>
                <tr id="cost">
                    <td class="character">Sign Up Cost</td>
                </tr>
                <tr id="volume">
                    <td class="character">Brokerage Cost</td>
                </tr>
                <tr id="cat">
                    <td class="character">Reputation</td>
                </tr>
                <tr id="signup">
                    <td class="character blank"></td>
                </tr>
            </table>
        </div>

        <script type="text/javascript">
        var broker = JSON.parse(sessionStorage.broker);
        var broker_temp_names = [],
            broker_temp_cost = [],
            broker_temp_volume = [],
            broker_temp_repute = [],
            
            broker_temp_cat = [];
        
        jQuery('.list').click(function() {
        	jQuery('.list').css({
        		color: 'orange'
        	});
        	jQuery(this).css({
        		color: 'white'
        	});
        });

        var names = document.getElementById('names');
        var cost = document.getElementById('cost');
        var volume = document.getElementById('volume');
        var cat = document.getElementById('cat');
        var signup = document.getElementById('signup');
        
        for (var i = 0; i < 3; i++) {
            var name_cell = names.insertCell(-1);
            name_cell.innerHTML = broker.names[i].toString();
            broker_temp_names.push(broker.names[i].toString());

            var cost_cell = cost.insertCell(-1);
            cost_cell.innerHTML = broker.repute[i]*(1000-100*(i+1)).toString();
            broker_temp_cost.push(broker.repute[i]*(1000-100*(i+1)).toString());

            var volume_cell = volume.insertCell(-1);
            volume_cell.innerHTML = 'Rs.'+broker.repute[i].toString();
            broker_temp_volume.push(broker.repute[i].toString());

            var cat_cell = cat.insertCell(-1);
            cat_cell.innerHTML = broker.types[i].toString();   
            broker_temp_cat.push(broker.types[i].toString());

            broker_temp_repute = broker.repute[i];

            var signup_cell = signup.insertCell(-1);
            var bt = document.createElement('button');
            bt.innerHTML = 'Sign Up';
            bt.className = "break "+i.toString();
            var button = signup_cell.appendChild(bt);
            // signup_cell.innerHTML = broker.types[i].toString();            
        }

        jQuery('.break').click(function() {
            jQuery('.break').prop('disabled', true);
            broker.opted = 'true';
            var num = parseInt(jQuery(this).attr("class").split(" ")[1]);
            // console.log(num);
            broker.cat = broker_temp_cat[num];
            broker.name = broker_temp_names[num];
            broker.volume = broker_temp_volume[num];
            broker.id = broker_temp_repute[num];
            sessionStorage.broker = JSON.stringify(broker);
            window.parent.location = 'index.php';
        });
        </script>
	</body>
</html>