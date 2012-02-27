<?php
require_once('facebook.settings.php');


//$oauthURL = "https://www.facebook.com/dialog/oauth?client_id=".APP_ID."&redirect_uri=".REDIRECT_URL."&scope=".implode(",", $fb_scope);

//header("Location: {$oauthURL}");

$params = array(
  'scope' => implode(",", $fb_scope),
  'redirect_uri' => REDIRECT_URL
);

$loginURL = $facebook->getLoginUrl($params);
header("Location: {$loginURL}");

?>