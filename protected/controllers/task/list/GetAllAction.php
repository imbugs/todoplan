<?php
class GetAllAction extends CAction
{
	public function run()
	{
		$user_id = Session::userId();
		$criteria = new CDbCriteria();
		$criteria->select='id, list_title, deletable';
		$criteria->condition="owner_id='{$user_id}'";

		$listItems = TaskList::model()->recently()->findAll($criteria);
		if (count($listItems) <= 0) {
			// 创建Inbox默认项
			$taskList = new TaskList();
			$taskList->owner_id = $user_id;
			$taskList->list_title = "Inbox";
			$taskList->deletable = false;
			$taskList->gmt_update = new CDbExpression('now()');
			$taskList->gmt_create = new CDbExpression('now()');
			$taskList->sort_id = '1';
			$taskList->save();
			$listItems = TaskList::model()->recently()->findAll($criteria);
		}
		$result = array();
		$idx = 0; 
		foreach ($listItems as $listItem) {
			$result[$idx++] = $listItem->copy();
		}
		
		echo json_encode($result);
	}
}
