<?php
/**
 * 校验邮件
 * @author tinghe
 */
class VerifyMail extends CActiveRecord
{
	var $error_msg = null;
	
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
 
    public function tableName() {
        return 'verify_mail';
    }
    
    /**
     * 删除早于maxVerifyTime的数据，在校验数据之前调用 
     */
    public static function deleteExpired() {
    	$maxVerifyTime = Config::getInstance()->maxVerifyTime;
    	$criteria = new CDbCriteria;
		$criteria->condition = "gmt_update < date_add(now(), interval -{$maxVerifyTime} second)";
		$count = VerifyMail::model()->deleteAll($criteria);
		return $count;
    }
    
    /**
     * 创建新的VerifyMail记录，如果已经存在数据，则进行更新动作
     * @param mix $user
     * @param string $type, UserConstant::VERIFY_VALID | UserConstant::VERIFY_RESET
     */
    public static function newRecord($user, $type) {
		$record = VerifyMail::model()->findAllByAttributes(array("username"=> $user->username, "type"=> $type));
		if (isset($record) && count($record) > 0) {
			$record = array_shift($record);
			// update
			$record->code = StringUtils::getUUID();
			$record->gmt_update = new CDbExpression('now()');
		} else {
			// insert
			$record = new VerifyMail;
			$record->type = $type;
			$record->username = $user->username;
			$record->email = $user->email;
			$record->code = StringUtils::getUUID();
			$record->gmt_update = new CDbExpression('now()');
			$record->gmt_create = new CDbExpression('now()');
		}
    	
		if ($record->save()) {
			return $record;
		} else {
			return null;
		}
    }
}
