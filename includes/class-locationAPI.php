<?php

class LocationAPI {
	// url to dribble api
	var $apiUrl = 'http://dce42bbb.ngrok.io/api/getBusinessLocation/';
	
	// dribble username or user id
	var $business_id;
	
	public function __construct($business_id)
	{
		$this->business_id = $business_id;
	}
	
	public function getBusiness()
	{
		$business_id = $this->business_id;
		
		$json = wp_remote_post($this->apiUrl . $business_id);
		
		$array = json_decode($json['body']);
		
       $business = $array;
        
       // print_r($array);
		
		return $business;
	}
}