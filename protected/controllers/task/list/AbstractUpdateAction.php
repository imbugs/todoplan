<?php
abstract class AbstractUpdateAction extends CAction
{
	public function run()
	{
		$sid = Yii::app()->getRequest()->getParam("id", "-1");
		$id = StringUtils::decode($sid);
		$taskList = TaskList::model()->findByPk($id);
		$result = new stdClass();
		$result->success = false;

		if (isset($taskList)) {
			$userId = Session::userId();
			if($taskList->deletable) {
				$this->update($taskList);
				$taskList->gmt_update = new CDbExpression('now()');
				
				if ($taskList->save()) {
					$result->success = true;
					$result->item = $taskList->copy();
				} else {
					$result->error_msg = $taskList->error_msg;
				}
			} else {
				$result->error_msg = "can not modify item id [{$sid}]";
			}
		} else {
			$result->error_msg = "can not find item by id [{$sid}]";
		}
		echo json_encode($result);
	}
	
	/**
	 * update columns
	 * @param class $taskList
	 */
	abstract public function update(&$taskList);
}
