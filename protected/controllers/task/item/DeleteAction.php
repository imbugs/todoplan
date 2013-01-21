<?php
class DeleteAction extends CAction
{
	public function run()
	{
		$id = Yii::app()->getRequest()->getParam("id", "-1");
		$id = StringUtils::decode($id);
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
			$result->error_msg = "can not find item by id [{$id}]";
		}
		echo json_encode($result);
	}
}