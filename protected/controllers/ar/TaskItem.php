<?php
/**
 * 任务 
 * @author tinghe
 */
class TaskItem extends CActiveRecord
{
	var $error_msg = null;
	var $last_sort_id = 0;
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'task_item';
	}

	public function beforeSave() {
		// validate column
		$colNames = array("list_id", "title");
		foreach ($colNames as $col) {
			if (empty($this->$col)) {
				$this->error_msg = "table [{$this->tableName()}], column [{$col}] can not be empty.";
				return false;
			}
		}
		// check owner
		return $this->checkOwner();
	}

	public function checkOwner() {
		if (isset($this->list_id)) {
			$taskList = TaskList::model()->findByPk($this->list_id);
			if (isset($taskList)) {
				$userId = Session::userId();
				if (isset($taskList->owner_id) && $taskList->owner_id === $userId) {
					return true;
				} else {
					$this->error_msg = "no permission to change the record..";
				}
			} else {
				$this->error_msg = "can not find [{$this->tableName()}] by id [{$this->list_id}].";
			}
		}
		return false;
	}
	
	public function beforeDelete() {
		return $this->checkOwner();
	}
	
	public function recently($done = "false", $limit = -1) {
		$order = 'sort_id, gmt_create ASC';
		if ($done == "true") {
			$order = 'sort_id, gmt_done ASC';
		}
		$this->getDbCriteria()->mergeWith(array(
	        'order' => $order,
	        'limit' => $limit,
		));
		return $this;
	}

	public function lastSortId() {
		$criteria = new CDbCriteria;
		$criteria->select='MAX(sort_id) as last_sort_id';
		$criteria->condition="list_id='{$this->list_id}' and done='{$this->done}'";
		$item = self::model()->find($criteria);
		return $item->last_sort_id;
	}

	public function copy($encode = true) {
		$colNames = array("id", "list_id", "title", "content", "starred", "done");
			
		$to = new stdClass();
		foreach ($colNames as $col) {
			$to->$col = $this->$col;
		}
		if ($encode) {
			$to->id = StringUtils::encode($to->id);
			$to->list_id = StringUtils::encode($to->list_id);
		}
		return $to;
	}
}
