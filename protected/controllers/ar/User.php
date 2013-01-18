<?php
/**
 * 用户
 * @author tinghe
 */
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
		return $this->checkOwner();
	}
	
	public function checkOwner() {
		if ($this->getIsNewRecord()) {
			// insert, no owner
			return true;
		}
		$userId = Session::userId();
		if (isset($this->id) && $this->id === $userId) {
			return true;
		}
		$this->error_msg = "no permission to change the record.";
		return false;
	}
	
	public function beforeDelete() {
		return $this->checkOwner();
	}
	
	public function copy() {
		$colNames = array("username", "status", "password", "email");
			
		$to = new stdClass();
		foreach ($colNames as $col) {
			$to->$col = $this->$col;
		}
			
		return $to;
	}
	
	// 删除早于maxVerifyTime且没有验证的用户
	public static function deleteUnverify() {
		$maxVerifyTime = Config::getInstance()->maxVerifyTime;
		$unverify = UserConstant::STATUS_TOVALID;
		$criteria = new CDbCriteria;
		$criteria->condition = "gmt_update < date_add(now(), interval -{$maxVerifyTime} second) and status = '{$unverify}'";
		$count = User::model()->deleteAll($criteria);
		return $count;
	}
}
