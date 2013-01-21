<?php
class StringUtils {
	// length = 42;
	const SECRET_KEY = "e02e33a4d1b885b6fda8ee782ae23f6f";
	
	public static function isEmpty($value,$trim=false) {
		return $value===null || $value===array() || $value==='' || $trim && is_scalar($value) && trim($value)==='';
	}
	
	public static function getUUID() {
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
		if (empty($str)) {
			return $str;
		}
		$encrypt = trim(
			base64_encode(
				mcrypt_encrypt(
					MCRYPT_RIJNDAEL_256,
					self::SECRET_KEY, $str,
					MCRYPT_MODE_ECB,
					mcrypt_create_iv(
						mcrypt_get_iv_size(
							MCRYPT_RIJNDAEL_256,
							MCRYPT_MODE_ECB
						),
						MCRYPT_RAND
					)
				)
			)
        );
        // remove '='
        $encrypt = substr($encrypt, 0, strlen($encrypt) - 1);
		return $encrypt;
	}
	
	public static function decode($str) {
		if (empty($str)) {
			return $str;
		}
		// add '='
		$str = $str . '=';
		$decrypt = trim(
			mcrypt_decrypt(
				MCRYPT_RIJNDAEL_256,
				self::SECRET_KEY,
				base64_decode($str),
				MCRYPT_MODE_ECB,
				mcrypt_create_iv(
					mcrypt_get_iv_size(
						MCRYPT_RIJNDAEL_256,
						MCRYPT_MODE_ECB
					),
					MCRYPT_RAND
				)
			)
    	);
    	return $decrypt;
	}
	
}