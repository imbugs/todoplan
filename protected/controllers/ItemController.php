<?php
require_once(Yii::app()->basePath . "/controllers/ar/TaskItem.php");

class ItemController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			'create'=>array(
				'class'=>'application.controllers.task.item.CreateAction'
			),
			'update'=>array(
				'class'=>'application.controllers.task.item.UpdateAction'
			),
			'delete'=>array(
				'class'=>'application.controllers.task.item.DeleteAction',
			),
			'get'=>array(
				'class'=>'application.controllers.task.item.GetAction',
			),
			'all'=>array(
				'class'=>'application.controllers.task.item.GetAllAction',
			),
			'done'=>array(
				'class'=>'application.controllers.task.item.DoneAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$criteria = new CDbCriteria();
		$criteria->select='id, list_id, title, starred';  // 只选择 'title' 列
		$criteria->condition='list_id=999';
		$items=TaskItem::model()->findAll($criteria);
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index', array('taskItems' => $items));
	}
}