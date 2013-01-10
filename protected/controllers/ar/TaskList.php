<?php
class TaskList extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
 
	public function recently($limit = -1)
	{
		$order = 'sort_id, gmt_create ASC';
		$this->getDbCriteria()->mergeWith(array(
	        'order' => $order,
	        'limit' => $limit,
		));
		return $this;
	}
	
    public function tableName()
    {
        return 'task_list';
    }
    
	public function copy() {
		$colNames = array("id", "list_title", "deletable");

		$to = new stdClass();
		foreach ($colNames as $col) {
			$to->$col = $this->$col;
		}

		return $to;
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
		return true;
	}
}
