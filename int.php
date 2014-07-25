
<?php

  require 'server/fb-php-sdk/facebook.php';

  // Production
  $app_id = '1392753500972228';
  $app_secret = '714602d237ea8e0947180eefaa8baf21';
  $app_namespace = 'grabthemarket';
//   $app_url = 'http://grabthemarket.herokuapp.com';
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

   if (!$user) {
     $loginUrl = $facebook->getLoginUrl(array(
       'scope' => $scope,
       'redirect_uri' => $app_url,
     ));

     print('<script> top.location.href=\'' . $loginUrl . '\'</script>');
   }
   if($user) {

         // We have a user ID, so probably a logged in user.
         // If not, we'll get an exception, which we handle below.
         try {

           $user_profile = $facebook->api('/me','GET');
        //   echo "Name: " . $user_profile['name'];
           if (!isset($_SESSION)) {
                session_start();
            }
           $_SESSION['name'] = $user_profile['name'];

         } catch(FacebookApiException $e) {
           // If the user is logged out, you can have a 
           // user ID even though the access token is invalid.
           // In this case, we'll get an exception, so we'll
           // just ask the user to login again here.
           $loginUrl = $facebook->getLoginUrl(array(
              'scope' => $scope,
              'redirect_uri' => $app_url,
            ));

            print('<script> top.location.href=\'' . $loginUrl . '\'</script>');
          
           error_log($e->getType());
           error_log($e->getMessage());
         }   
       } else {

         // No user, print a link for the user to login
         $login_url = $facebook->getLoginUrl();
         echo 'Please <a href="' . $login_url . '">login.</a>';

       }

    
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Grab the Market!</title>

      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
      <meta name="apple-mobile-web-app-capable" content="yes" />
      <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
      
      <link href="scripts/style.css" rel="stylesheet" type="text/css">

      <script src="scripts/jquery-1.8.3.js"></script>
      <script src="scripts/jquery.jCounter-0.1.4.js"></script>

  </head>

  <body>
      <div id="fb-root"></div>
      <script src="//connect.facebook.net/en_US/all.js"></script>

      <script>
          var appId = '<?php echo $facebook->getAppID() ?>';

          // Initialize the JS SDK
          FB.init({
            appId: appId,
            frictionlessRequests: true,
            cookie: true,
          });

          FB.getLoginStatus(function(response) {
            uid = response.authResponse.userID ? response.authResponse.userID : null;
          });
      </script>
      <?php
        // header("Location: final/start.php");
      ?>
      <script type="text/javascript">
    //   	window.location = 'final/start.php';
      </script>
  </body>
</html>
