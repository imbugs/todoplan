<?php
class TaskList extends CActiveRecord
{
	var $error_msg = null;
	var $last_sort_id = 0;
	
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
 
    public function tableName() {
        return 'task_list';
    }
    
	public function beforeSave() {
		// validate column
		$colNames = array("owner_id", "list_title");
		foreach ($colNames as $col) {
			if (empty($this->$col)) {
				$this->error_msg = "table [{$this->tableName()}], column [{$col}] can not be empty.";
				return false;
			}
		}
		return $this->checkOwner();
	}
	
	public function checkOwner() {
		$userId = Session::userId();
		if (isset($this->owner_id) && $this->owner_id === $userId) {
			return true;
		}
		$this->error_msg = "no permission to change the record.";
		return false;
	}
	
	public function beforeDelete() {
		return $this->checkOwner();
	}
	
	public function recently($limit = -1) {
		$order = 'sort_id, gmt_create ASC';
		$this->getDbCriteria()->mergeWith(array(
	        'order' => $order,
	        'limit' => $limit,
		));
		return $this;
	}
	
	
    public function lastSortId() {
		$criteria = new CDbCriteria;
		$criteria->select='MAX(sort_id) as last_sort_id';
		$criteria->condition="owner_id='{$this->owner_id}'";
		$item = self::model()->find($criteria);
		return $item->last_sort_id;
	}
	
	public function copy() {
		$colNames = array("id", "list_title", "deletable");

		$to = new stdClass();
		foreach ($colNames as $col) {
			$to->$col = $this->$col;
		}

		return $to;
	}
	
}
