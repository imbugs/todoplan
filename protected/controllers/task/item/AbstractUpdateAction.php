<?php
abstract class AbstractUpdateAction extends CAction
{
	public function run()
	{
		$sid = Yii::app()->getRequest()->getParam("id", "-1");
		$id = StringUtils::decode($sid);
		
		$taskItem = TaskItem::model()->findByPk($id);
		$result = new stdClass();
		$result->success = false;

		if (isset($taskItem)) {
			$this->update($taskItem);
			$taskItem->gmt_update = new CDbExpression('now()');
			
			if ($taskItem->save()) {
				$result->success = true;
				$result->item = $taskItem->copy();
			} else {
				$result->error_msg = $taskItem->error_msg;
			}
		} else {
			$result->error_msg = "can not find item by id [{$sid}]";
		}
		echo json_encode($result);
	}
	
	/**
	 * update columns
	 * @param class $taskItem
	 */
	abstract public function update(&$taskItem);
}
