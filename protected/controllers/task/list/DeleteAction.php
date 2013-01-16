<?php
class DeleteAction extends CAction
{
	public function run()
	{
		$id = Yii::app()->getRequest()->getParam("id", "-1");
		$taskList = TaskList::model()->findByPk($id);

		$result = new stdClass();
		$result->success = false;
		if (isset($taskList)) {
			$userId = Session::userId();
			if($taskList->deletable) {
				// delete task item
				$criteria = new CDbCriteria;
				$criteria->condition = "list_id='{$id}'";
				$result->item_count = TaskItem::model()->deleteAll($criteria);
				if ($result->item_count >= 0) {
					if ($taskList->delete()) {
						$result->success = true;
					} else {
						$result->error_msg = $taskList->error_msg;
					}
				} else {
					$result->error_msg = "delete task_item error list_id [{$id}]";
				}
			} else {
				$result->error_msg = "can not delete item id [{$id}]";
			}
		} else {
			$result->error_msg = "can not find item by id [{$id}]";
		}
		echo json_encode($result);
	}
}
