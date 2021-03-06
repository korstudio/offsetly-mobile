<?php
require_once('services/core/facebook.settings.php');


$fbUser = new FacebookUser($facebook);

function getLatestStatus(){
	global $facebook, $me;
	//$statuses = $facebook->api("/me/statuses");
	//print_r($statuses);
	return $me->statuses[0]['message'];
}

function getUserGroups(){
	global $facebook, $me;
	//$groups = $facebook->api("/me/groups");
	$groups = $me->groups;
	$str_list_title = '<p><a href="URL">TITLE</a></p>';
	$str_list_content = '<dd>USER</dd>';
	$str_list = "";
	for($i = 0; $i < /*count($groups)*/3; $i++){
		$str_temp = str_replace("TITLE", $groups[$i]['name'], $str_list_title);
		$str_temp = str_replace("URL", "#", $str_temp);
		$str_list .= $str_temp;
		
		$groupMembers = $facebook->api("/{$groups[$i]['id']}/members");
		$groupMembers = $groupMembers['data'];
		$str_list .= '<div class="well row"><div class="span12">';
		foreach($groupMembers as $index=>$member){
			if($member['administrator']){
				$str_list .= '<div class="list_container">';
				$str_list .= '<img src="https://graph.facebook.com/'.$member['id'].'/picture" alt="" width="50" height="50">';
				$str_list .= '<span class="label label-info">ADMIN</span>';
				$str_list .= '<h5>'.$member['name'].'</h5>';
				$str_list .= '<div style="clear:both"></div>';
				$str_list .= '</div>';
				$groupMembers[$index] = NULL;
			}
		}
		$groupMembers = array_orderby($groupMembers, 'name', SORT_ASC, SORT_STRING, 'id', SORT_ASC);
		$MAX_DISPLAY = 6;
		$currentCount = 0;
		foreach($groupMembers as $member){
			if(++$currentCount > $MAX_DISPLAY) break;
			if($member != NULL){
				$str_list .= '<div class="list_container">';
				$str_list .= '<img src="https://graph.facebook.com/'.$member['id'].'/picture" alt="" width="50" height="50">';
				if($member['administrator']) $str_list .= '<span class="label label-info">ADMIN</span>';
				$str_list .= '<h5>'.$member['name'].'</h5>';
				$str_list .= '<div style="clear:both"></div>';
				$str_list .= '</div>';
			}else{
				--$currentCount;
			}
			
		}
		$str_list .= '</div></div>';
		
		/*$str_temp = str_replace("CONTENT", $groups[$i]['name'], $str_list_content);
		$str_temp = str_replace("USER", "#", $str_temp);
		$str_list .= $str_temp;*/
	}
	return $str_list;
}

function getUserLikes(){
	global $facebook, $me;
	
	$likes = $me->likes;
	$str_list_title = '<p><a href="URL">TITLE</a></p>';
	$str_list = '<div class="well row"><div class="span12">';
	for($i = 0; $i < count($likes); $i++){
		$likeItem = $likes[$i];
		$likeName = $likeItem->name;
		$likeId = $likeItem->id;
		$likeCat = $likeItems->category;
		$str_temp = str_replace(array("TITLE", "URL"), array($likeName, $likeItem->link), $str_list_title);
		
		$str_list .= '<div class="list_container">';
		$str_list .= '<img src="https://graph.facebook.com/'.$likeId.'/picture" alt="" width="50" height="50">';
		$str_list .= $str_temp;
		$str_list .= '<div style="clear:both"></div>';
		$str_list .= '</div>';
		
	}
	$str_list .= '</div></div>';
	return $str_list;
}


?>


<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrap-tooltip.js"></script>
<script type="text/javascript" src="js/bootstrap-popover.js"></script>
<script type="text/javascript">
	$(document).ready(function(e) {
		$("#show_token_btn").popover({
			placement: 'bottom',
			trigger: 'manual'
		}).click(function(e){
			e.preventDefault();
			$(this).popover('toggle');
		});
	});
</script>
<style>
.thumbnail {
	width: 200px;
	height: 50px;
}
.span12 {
	-webkit-column-count: 3;
}
.span12 .list_container{
	height: 50px;
	margin: 5px 0;
}
.span12 .list_container > *{
	float: left;
}
h5 {
	
}
</style>
</head>

<body>

<div class="container">
	<header>
    	<h1>Front-end Test</h1>
    </header>
	
    <?php if($fb_user): ?>
    
    <section id="fbuser">
        <div class="page-header">
        	<h2>Welcome, <?=$me->name?></h2>
            <a class="btn" id="show_token_btn" data-content="<?=$facebook->getAccessToken()?>" data-original-title="Access Token">Get Access Token</a>
        </div>
        <p class="lead">Latest on Facebook</p>
        <blockquote>
        	<p><?=getLatestStatus(); ?></p>
            <small><?=$me->name?></small>
        </blockquote>
	</section>
    <section id="fbgroups">
        <p class="lead">Groups</p>
        <div id="grouplist">
          <?=getUserGroups(); ?>
        </div>
	</section>
    <section id="fblikes">
        <p class="lead">Likes</p>
        <ul class="nav nav-tabs nav-stacked">
          <?=getUserLikes(); ?>
        </ul>
	</section>
    
    <?php else: ?>
    
    <section id="fblogin">
        <div class="page-header"><h2>Log in</h2></div>
        <p class="lead"><a href="services/endpoint/login.php" class="btn btn-primary btn-large">Log in with Facebook</a></p>
	</section>
    
    <?php endif ?>
</div>

</body>
</html>
