<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="final/css/clock.css"/>
		<script type="text/javascript" src="clock/countdown.js" ></script>

		<script type="text/javascript" src="js/jq.js"></script>
		<script type="text/javascript" src="final/js/common.js"></script>
		
	</head>
<body>

	<?php 
	    if (!isset($_SESSION)) {
	        session_start();
	    }
	    $now = microtime(true)*1000;
	?>
<script>        
        sessionStorage.clear();
        console.log(new Date().getTime());
        console.log(Math.round(<?php echo $now;?>));
        
        sessionStorage.client_time_diff = JSON.stringify(new Date().getTime() - Math.round(<?php echo $now;?>));
  // This is called with the results from from FB.getLoginStatus().

  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
    // FB.init({
    //   appId      : 1392753500972228,
    //   cookie     : true,  // enable cookies to allow the server to access 
    //                       // the session
    //   xfbml      : true,  // parse social plugins on this page
    //   version    : 'v2.0', // use version 2.0
    //   oauth : true
    // });

    // Now that we've initialized the JavaScript SDK, we call 
    // FB.getLoginStatus().  This function gets the state of the
    // person visiting this page and can return one of three states to
    // the callback you provide.  They can be:
    //
    // 1. Logged into your app ('connected')
    // 2. Logged into Facebook, but not your app ('not_authorized')
    // 3. Not logged into Facebook and can't tell if they are logged into
    //    your app or not.
    //
    // These three cases are handled in the callback function.

    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1392753500972228&version=v2.0";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
		// console.log(response);
		console.log('Successful login for: ' + response.name);
		document.getElementById('status').innerHTML =
		'Thanks for registering, ' + response.name + '!';
		jQuery('.fb-login-button').hide();
		$.post( "final/functions.php", { 'arg': response.id, 'quantity': response.name } );

    });
  }
  console.log(right_now());
  var clock = new Countdown({
  	time: Math.round((1407248962942+1000*60*60*24*4 - right_now())/1000), 
  	width:500, 
  	// target		: "clock_down",
  	height:100, 
  	style: "flip",
  	rangeHi		: "day",		// The highest unit of time to display
  	rangeLo		: "second",		// The lowest unit of time to display
  });
</script>

<!--
  Below we include the Login Button social plugin. This button uses
  the JavaScript SDK to present a graphical Login button that triggers
  the FB.login() function when clicked.
-->

<!-- <fb:login-button scope="public_profile,email" onlogin="checkLoginState();"></fb:login-button> -->
<div id="clock_down"></div>

<div id="fb-root"></div>
<div id="status">
<div class="fb-login-button" data-max-rows="1" data-size="large" data-show-faces="true" data-auto-logout-link="true"></div>
</div>

</body>
</html>
