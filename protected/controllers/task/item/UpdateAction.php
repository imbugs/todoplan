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
		$list_id = Yii::app()->getRequest()->getParam("list_id", null);
		$list_id = StringUtils::decode($list_id);
		if (isset($list_id)) {
			$taskItem->list_id = $list_id;
			$taskItem->sort_id = $taskItem->lastSortId()  + 1;
		}
	}
}
