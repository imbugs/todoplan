<?php
require_once(Yii::app()->basePath . "/controllers/ar/TaskList.php");

class CreateAction extends CAction
{
	public function run()
	{
		$taskList = new TaskList();
		$taskList->owner_id = "1";
		$taskList->list_title = Yii::app()->getRequest()->getParam("list_title", "");
		$taskList->gmt_update = new CDbExpression('now()');
		$taskList->gmt_create = new CDbExpression('now()');
		$taskList->sort_id = $taskList->lastSortId()  + 1;

		$result = new stdClass();
		$result->success = false;
		if ($taskList->save()) {
			$result->success = true;
			$result->item = $taskList->copy();
		} else {
			$result->error_msg = $taskList->error_msg;
		}
		
		echo json_encode($result);
	}
}
