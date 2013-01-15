<?php
Yii::import('application.controllers.task.item.AbstractUpdateAction');

class DoneAction extends AbstractUpdateAction
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
