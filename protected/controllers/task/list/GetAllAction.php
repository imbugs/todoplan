<?php
require_once(Yii::app()->basePath . "/controllers/ar/TaskList.php");

class GetAllAction extends CAction
{
	public function run()
	{
		$user_id = "1";
		$criteria = new CDbCriteria();
		$criteria->select='id, list_title, deletable';
		$criteria->condition="owner_id='{$user_id}'";

		$listItems = TaskList::model()->recently()->findAll($criteria);
		$result = array();
		$idx = 0; 
		foreach ($listItems as $listItem) {
			$result[$idx++] = $listItem->copy();
		}
		
		echo json_encode($result);
	}
}
