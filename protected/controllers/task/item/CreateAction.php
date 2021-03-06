<?php
class CreateAction extends CAction
{
	public function run()
	{
		$taskItem = new TaskItem();
		$taskItem->list_id = Yii::app()->getRequest()->getParam("list_id", "-1");
		$taskItem->list_id = StringUtils::decode($taskItem->list_id);
		$taskItem->title = Yii::app()->getRequest()->getParam("title", "");
		$taskItem->gmt_update = new CDbExpression('now()');
		$taskItem->gmt_create = new CDbExpression('now()');
		$taskItem->sort_id = $taskItem->lastSortId()  + 1;
		
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
