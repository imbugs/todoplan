<?php
class GetAction extends CAction
{
	public function run()
	{
		$id = Yii::app()->getRequest()->getParam("id", "-1");
		$taskItem = TaskItem::model()->findByPk($id);
		
		$result = new stdClass();
		if (isset($taskItem)) {
			$result = $taskItem->copy();
		}
		echo json_encode($result);
	}
}
