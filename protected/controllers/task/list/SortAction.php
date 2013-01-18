<?php
class SortAction extends CAction
{
	public function run()
	{
		$order = Yii::app()->getRequest()->getParam("order", array());
		if (count($order) > 0) {
			foreach ($order as $index=> $id) {
				if (isset($id) && isset($index)) {
					$sortId = $index + 1;
					TaskList::model()->updateByPk($id, array('sort_id' => $sortId, 'gmt_update' => new CDbExpression('now()')));
				}
			}
		}
		$result = new stdClass();
		$result->success = true;
		echo json_encode($result);
	}
}