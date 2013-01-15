<?php
class Config {
	public $urls;
	private static $instance;
	
	private function __construct() {
		$this->urls = array(); 
		$this->urls['loginUrl'] = "?r=site/login";
		$this->urls['indexUrl'] = "?r=site/index";
		$this->urls['homeUrl'] = "?r=site/index";
		$this->urls['logoutUrl'] = "?r=site/logout"; 
	}
	
	public static function getUrl($key) {
		$urls = self::getInstance()->urls;
		if (isset($urls[$key])) {
			return $urls[$key];
		}
		return "";
	}
	
	public static function getInstance(){ 
		if (!isset(self::$instance)) {
			self::$instance = new Config();
		}
		return self::$instance;
	}
}
