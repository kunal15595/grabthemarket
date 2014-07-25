
<?php


  require '../server/fb-php-sdk/facebook.php';

  // Production
  $app_id = '1392753500972228';
  $app_secret = '714602d237ea8e0947180eefaa8baf21';
  $app_namespace = 'grabthemarket';
  // $app_url = 'http://arcane-brushlands-4962.herokuapp.com';
  $app_url = 'http://apps.facebook.com/' . $app_namespace . '/';
  // $app_url = 'http://localhost/techniche/final/index.php';
    $scope = 'email,publish_actions';

    // Init the Facebook SDK
   $facebook = new Facebook(array(
     'appId'  => $app_id,
     'secret' => $app_secret,
   ));

   // Get the current user
   $user = $facebook->getUser();

   // If the user has not installed the app, redirect them to the Login Dialog

   

?>
<script src="../scripts/core.js"></script>
<script src="../scripts/game.js"></script>
<script src="../scripts/ui.js"></script>
<script type="text/javascript">
	window.location = 'bar.php';
</script>
<script type="text/javascript">
	FB.ui({ method: 'feed',
	        caption: 'I just smashed ' + 09 + ' friends! Can you beat it?',
	        picture: 'http://www.friendsmash.com/images/logo_large.jpg',
	        name: 'Checkout my Friend Smash greatness!'
	    }, fbCallback);
</script>
