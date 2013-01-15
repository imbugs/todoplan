<?php
Yii::import('application.controllers.task.item.AbstractUpdateAction');

class UpdateAction extends AbstractUpdateAction
{
	public function update(&$taskItem) {
		$title = Yii::app()->getRequest()->getParam("title", "");
		if (!empty($title)) {
			$taskItem->title = $title;
		}
		$content = Yii::app()->getRequest()->getParam("content", null);
		if (isset($content)) {
			$taskItem->content = $content;
		}
	}
}
