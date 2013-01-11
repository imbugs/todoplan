<?php
require_once(Yii::app()->basePath . "/controllers/ar/TaskItem.php");

abstract class AbstractUpdateAction extends CAction
{
	public function run()
	{
		$id = Yii::app()->getRequest()->getParam("id", "-1");
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
			$result->error_msg = "can not find item by id [{$id}]";
		}
		echo json_encode($result);
	}
	
	/**
	 * update columns
	 * @param class $taskItem
	 */
	abstract public function update(&$taskItem);
}
