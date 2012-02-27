<?php
require_once('facebook.settings.php');

class FacebookLike {
	
	public $fb;
	public $id;
	public $link;
	public $name;
	public $picture;
	public $likes;
	public $app_id;
	public $category;
	public $is_published;
	public $description;
	public $about;
	public $can_post;
	public $talking_about_count;
	public $type;
	
	protected $rawdata;
	
	/**
	 * @param Facebook $fb Facebook instance
	 * @param mixed $id Like page ID
	 */
	public function __constructor($fb, $id){
		$this->fb = $fb;
		$this->id = $id;
		$this->rawdata = $this->fb->api("/{$id}");
		$this->parseData();
	}
	
	private function parseData(){
		foreach ($this->rawdata as $prop => $value) {
			$this->{$prop} = $value;
		}
	}
}


?>