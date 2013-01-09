<?php
require_once(Yii::app()->basePath . "/controllers/ar/TaskItem.php");
require_once(Yii::app()->basePath . "/controllers/task/item/UpdateAction.php");

class DoneAction extends UpdateAction
{
	public function update(&$taskItem) {
		$undo = Yii::app()->getRequest()->getParam("undo", "false");
		if ($undo == "true") {
			$taskItem->done = 0;
		} else if ($undo == "false") {
			$taskItem->done = 1;
		}
		$taskItem->sort_id = $taskItem->lastSortId()  + 1;
		$taskItem->gmt_done = new CDbExpression('now()');
	}
}
