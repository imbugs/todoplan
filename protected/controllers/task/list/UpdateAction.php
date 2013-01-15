<?php
Yii::import('application.controllers.task.list.AbstractUpdateAction');

class UpdateAction extends AbstractUpdateAction
{
	public function update(&$taskList) {
		$list_title = Yii::app()->getRequest()->getParam("list_title", "false");
		$taskList->list_title = $list_title;
	}
}
