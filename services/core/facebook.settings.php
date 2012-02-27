<?php
require_once('facebook/facebook.php');
require_once('FacebookUser.php');

define('APP_ID', '302999799754348');
define('APP_SECRET', '51cb8dbdbd562a29e3dcf04f49c3804a');
//define('REDIRECT_URL', 'http://lab.clicknect.net/offsetly-mobile/app_redirect.php');
define('REDIRECT_URL', 'http://lab.clicknect.net/offsetly-mobile/index.php');

$fb_oauth_req_url = 'https://graph.facebook.com/oauth/access_token?client_id='.APP_ID.'&redirect_uri='.REDIRECT_URL.'&client_secret='.APP_SECRET.'&code=AUTH_CODE';

$fb_scope = array();
$fb_scope[] = 'user_activities';
$fb_scope[] = 'user_groups';
$fb_scope[] = 'user_interests';
$fb_scope[] = 'user_likes';
$fb_scope[] = 'user_status';
$fb_scope[] = 'read_friendlists';
$fb_scope[] = 'read_stream';
$fb_scope[] = 'email';

$facebook = new Facebook(array(
	'appId' => APP_ID,
	'secret' => APP_SECRET
));

$fb_user = $facebook->getUser();

if($fb_user){
	try {
    // Proceed knowing you have a logged in user who's authenticated.
    $fb_user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    $fb_user = NULL;
  }
}

if($fb_user){
	$facebook->getAccessToken();
	$fb_user_profile = $facebook->api("/me");
	$me = new FacebookUser($facebook);
}

?>