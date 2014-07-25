<?php
    session_start();
    
    $app_id = '1392753500972228';
    $app_secret = '714602d237ea8e0947180eefaa8baf21';
    $app_namespace = 'grabthemarket';
    $app_url = 'http://apps.facebook.com/' . $app_namespace . '/';
    $scope = 'email,publish_actions';
    
    require_once( 'Facebook/FacebookSession.php' );
    require_once( 'Facebook/FacebookRedirectLoginHelper.php' );
    require_once( 'Facebook/FacebookRequest.php' );
    require_once( 'Facebook/FacebookResponse.php' );
    require_once( 'Facebook/FacebookSDKException.php' );
    require_once( 'Facebook/FacebookRequestException.php' );
    require_once( 'Facebook/FacebookAuthorizationException.php' );
    require_once( 'Facebook/GraphObject.php' );
     
    use Facebook\FacebookSession;
    use Facebook\FacebookRedirectLoginHelper;
    use Facebook\FacebookRequest;
    use Facebook\FacebookResponse;
    use Facebook\FacebookSDKException;
    use Facebook\FacebookRequestException;
    use Facebook\FacebookAuthorizationException;
    use Facebook\GraphObject;
     
    // init app with app id (APPID) and secret (SECRET)
    FacebookSession::setDefaultApplication($app_id,$app_secret);
     
    // login helper with redirect_uri
    $helper = new FacebookRedirectLoginHelper( $app_url );
     
    try {
      $session = $helper->getSessionFromRedirect();
    } catch( FacebookRequestException $ex ) {
      // When Facebook returns an error
    } catch( Exception $ex ) {
      // When validation fails or other local issues
    }
     
    // see if we have a session
    if ( isset( $session ) ) {
      // graph api request for user data
      $request = new FacebookRequest( $session, 'GET', '/me' );
      $response = $request->execute();
      // get response
      $graphObject = $response->getGraphObject();
       
      // print data
      echo  print_r( $graphObject, 1 );
    } else {
      // show login url
      echo '<a href="' . $helper->getLoginUrl() . '">Login</a>';
    }
?>
<script type="text/javascript">
   	window.location = 'final/start.php';
</script>