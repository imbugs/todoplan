<?php
require_once(Yii::app()->basePath . "/controllers/ar/TaskItem.php");

class CreateAction extends CAction
{
	public function run()
	{
		$taskItem = new TaskItem();
		$taskItem->list_id = Yii::app()->getRequest()->getParam("list_id", "-1");
		$taskItem->title = Yii::app()->getRequest()->getParam("title", "");
		$taskItem->gmt_update = new CDbExpression('now()');
		$taskItem->gmt_create = new CDbExpression('now()');
		
		$result = new stdClass();
		$result->success = false;
		
		if ($taskItem->save()) {
			$result->success = true;
			$result->item = $taskItem->copy();
		} else {
			$result->error_msg = $taskItem->error_msg;
		}
		
		echo json_encode($result);
	}
}
