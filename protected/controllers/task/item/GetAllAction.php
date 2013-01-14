<?php
require_once(Yii::app()->basePath . "/controllers/ar/TaskItem.php");

class GetAllAction extends CAction
{
	public function run()
	{
		$list_id = Yii::app()->getRequest()->getParam("list_id", "-1");
		$done = Yii::app()->getRequest()->getParam("done", "false");
		$criteria = new CDbCriteria();
		$criteria->select='id, list_id, title, content, starred';  // 只选择 'title' 列
		$criteria->condition="list_id='{$list_id}'";
		$criteria->addCondition("done={$done}");

		$taskItems = TaskItem::model()->recently($done)->findAll($criteria);
		$result = array();
		$idx = 0; 
		foreach ($taskItems as $taskItem) {
			$result[$idx++] = $taskItem->copy();
		}
		
		echo json_encode($result);
	}
}
