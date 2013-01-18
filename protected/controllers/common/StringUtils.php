<?php
class StringUtils {
	public static function isEmpty($value,$trim=false) {
		return $value===null || $value===array() || $value==='' || $trim && is_scalar($value) && trim($value)==='';
	}
	
	public static function getUUID () {
		$uuid = uniqid(true);
		$time = time();
		$sha1 = sha1($time);
		return $uuid . $sha1;
	}
	
	/** 
	 * method masks the username of an email address 
	 * 
	 * @param string $email the email address to mask 
	 * @param string $mask_char the character to use to mask with 
	 * @param int $percent the percent of the username to mask 
	 */ 
	public static function maskEmail( $email, $mask_char, $percent=50 ) { 
	        list( $user, $domain ) = preg_split("/@/", $email ); 
	        $len = strlen( $user ); 
	        $mask_count = ceil( $len * $percent /100 ); 
	        $offset = ceil( ( $len - $mask_count ) / 2 ); 
	        $masked = substr( $user, 0, $offset ) 
	                .str_repeat( $mask_char, $mask_count ) 
	                .substr( $user, $mask_count+$offset ); 
	        return( $masked.'@'.$domain ); 
	}
	
	public static function encode($str) {
		return $str;
	}
	
	public static function decode($str) {
		return $str;
	}
}