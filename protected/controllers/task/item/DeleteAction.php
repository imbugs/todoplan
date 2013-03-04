<?php
class DeleteAction extends CAction
{
	public function run()
	{
		$sid = Yii::app()->getRequest()->getParam("id", "-1");
		$id = StringUtils::decode($sid);
		$taskItem = TaskItem::model()->findByPk($id);

		$result = new stdClass();
		$result->success = false;
		if (isset($taskItem)) {
			// delete task item
			$criteria = new CDbCriteria;
			$criteria->condition = "id='{$id}'";
			if ($taskItem->delete()) {
				$result->success = true;
			} else {
				$result->error_msg = $taskItem->error_msg;
			}
		} else {
			$result->error_msg = "can not find item by id [{$sid}]";
		}
		echo json_encode($result);
	}
}