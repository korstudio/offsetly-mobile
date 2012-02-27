<?php
require_once('facebook.settings.php');

/**
Fields
id
	The user's Facebook ID. No `access_token` required. `string`.
name
	The user's full name. No `access_token` required. `string`.
first_name
	The user's first name. No `access_token` required. `string`.
middle_name
	The user's middle name. No `access_token` required. `string`.
last_name
	The user's last name. No `access_token` required. `string`.
gender
	The user's gender: `female` or `male`. No `access_token` required. `string`.
locale
	The user's locale. No `access_token` required. `string` containing the ISO Language Code and ISO Country Code.
languages
	The user's languages. `user_likes`. `array` of objects containing language `id` and `name`.
link
	The URL of the profile for the user on Facebook. No `access_token` required. `string` containing a valid URL.
username
	The user's Facebook username. No `access_token` required. `string`.
third_party_id
	An anonymous, but unique identifier for the user; only returned if specifically requested via the `fields` URL parameter. Requires `access_token`. `string`.
installed
	Specifies whether the user has installed the application associated with the app access token that is used to make the request; only returned if specifically requested via the `fields` URL parameter. Requires app `access_token`. `object` containing `type` (this is always "user"), `id` (the ID of the user), and optional `installed` field (always `true` if returned); The `installed` field is only returned if the user has installed the application, otherwise it is not part of the returned object.
timezone
	The user's timezone offset from UTC. Available only for the current user. `number`.
updated_time
	The last time the user's profile was updated; changes to the `languages`, `link`, `timezone`, `verified`, `interested_in`, `favorite_athletes`, `favorite_teams`, and `video_upload_limits` are not not reflected in this value. Requires `access_token`. `string` containing an ISO-8601 datetime.
verified
	The user's account verification status, either `true` or `false` (see below). Requires `access_token`. `boolean`.
bio
	The user's biography. `user_about_me` or `friends_about_me`. `string`.
birthday
	The user's birthday. `user_birthday` or `friends_birthday`. Date `string` in `MM/DD/YYYY` format.
education
	A list of the user's education history. `user_education_history` or `friends_education_history`. `array` of objects containing `year` and `type` fields, and `school` object (`name`, `id`, `type`, and optional `year`, `degree`, `concentration` array, `classes` array, and `with` array ).
email
	The proxied or contact email address granted by the user. `email`. `string` containing a valid RFC822 email address.
hometown
	The user's hometown. `user_hometown` or `friends_hometown`. object containing `name` and `id`.
interested_in
	The genders the user is interested in. `user_relationship_details` or `friends_relationship_details`. `array` containing strings.
location
	The user's current city. `user_location` or `friends_location`. object containing `name` and `id`.
political
	The user's political view. `user_religion_politics` or `friends_religion_politics`. `string`.
favorite_athletes
	The user's favorite athletes; this field is deprecated and will be removed in the near future. `user_likes` or `friends_likes` . `array` of objects containing `id` and `name` fields.
favorite_teams
	The user's favorite teams; this field is deprecated and will be removed in the near future. `user_likes` or `friends_likes`. `array` of objects containing `id` and `name` fields.
quotes
	The user's favorite quotes. `user_about_me` or `friends_about_me`. `string`.
relationship_status
	The user's relationship status: `Single`, `In a relationship`, `Engaged`, `Married`, `It's complicated`, `In an open relationship`, `Widowed`, `Separated`, `Divorced`, `In a civil union`, `In a domestic partnership`. `user_relationships` or `friends_relationships`. `string`.
religion
	The user's religion. `user_religion_politics` or `friends_religion_politics` . `string`.
significant_other
	The user's significant other. `user_relationships` or `friends_relationships`. object containing `name` and `id`.
video_upload_limits
	The size of the video file and the length of the video that a user can upload; only returned if specifically requested via the `fields` URL parameter. Requires `access_token`. object containing `length` and `size` of video.
website
	The URL of the user's personal website. `user_website` or `friends_website` . `string` containing a valid URL.
work
	A list of the user's work history. `user_work_history` or `friends_work_history`. `array` of objects containing `employer`, `location`, `position`, `start_date` and `end_date` fields.
 *
 *
 */

class FacebookUser {
	
	private $me;
	private $fb;
	
	public $id;
	public $name;
	public $first_name;
	public $middle_name;
	public $last_name;
	public $gender;
	public $locale;
	public $languages;
	public $link;
	public $username;
	public $third_party_id;
	public $installed;
	public $timezone;
	public $updated_time;
	public $verified;
	public $bio;
	public $birthday;
	public $education;
	public $email;
	public $hometown;
	public $interested_in;
	public $location;
	public $political;
	public $quotes;
	public $relationship_status;
	public $religion;
	public $significant_other;
	public $video_upload_limits;
	public $website;
	public $work;
	
	public $statuses;
	public $groups;
	public $likes;
	
	public function __construct($fb){
		$this->fb = $fb;
		$this->me = $this->fb->api("/me");
		$this->parseData();
	}
	
	private function parseData(){
		foreach($this->me as $prop=>$val){
			$this->{$prop} = $val;
		}
		
		$statuses = $this->fb->api("/me/statuses");
		$groups = $this->fb->api("/me/groups");
		$likes = $this->fb->api("/me/likes");
		
		/**
		 * Parse Facebook likes
		 */
		foreach ($likes['data'] as $index => $like) {
			$this->likes[$index] = new FacebookLike($this->fb, $like['id']);
		}
		
		$this->statuses = $statuses['data'];
		$this->groups = $groups['data'];
		//$this->likes = $likes['data'];
	}
	
	/**
	 * @param mixed index
	 * @return FacebookLike
	 */
	public function getLikeAt($index){
		return $this->likes[$index];
	}
}

?>