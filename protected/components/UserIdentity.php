<?php
require_once(Yii::app()->basePath . "/controllers/ar/User.php");

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	
	/**
	 * md5 password
	 * @see CUserIdentity::authenticate()
	 */
    public function authenticate()
    {
        $record = User::model()->findByAttributes(array('username' => $this->username));
        if($record === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else if($record->password !== md5($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $this->_id = $record->id;
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode;
    }
 
    public function getId()
    {
        return $this->_id;
    }
}