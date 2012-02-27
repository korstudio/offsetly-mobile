<?php

class FacebookStatusComment {
	
	public $id;
	public $from;
	public $message;
	public $canRemove;
	public $createdTime;
	
	public function __construct($fb_status_comment){
		$this->parseData($fb_status_comment);
	}
	
	private function parseData($cmtobj){
		
	}
	
}

?>