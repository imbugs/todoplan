<?php
class User extends CActiveRecord
{
	var $error_msg = null;
	
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
 
    public function tableName()
    {
        return 'user';
    }
    
	public function beforeSave() {
		// validate column
		$colNames = array("username", "password", "email");
		foreach ($colNames as $col) {
			if (empty($this->$col)) {
				$this->error_msg = "table [{$this->tableName()}], column [{$col}] can not be empty.";
				return false;
			}
		}
		return true;
	}
}
