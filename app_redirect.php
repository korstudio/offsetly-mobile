<?php
require_once('services/core/facebook.settings.php');
require_once('services/core/functions.php');

if(!empty($_GET['code'])){
	/*$fb_server_code = $_GET['code'];
	$fb_oauth_req_url = str_ireplace("AUTH_CODE", $_GET['code'], $fb_oauth_req_url);
	
	$fb_token_result = file_get_contents_curl($fb_oauth_req_url);
	$fb_vars = null;
	parse_str($fb_token_result, $fb_vars);
	
	*/
	echo $facebook->getAccessToken();
}

?>