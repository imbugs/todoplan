<?php
require_once(Yii::app()->basePath . "/controllers/ar/TaskItem.php");

class ListController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			'create'=>array(
				'class'=>'application.controllers.task.list.CreateAction',
			),
			'update'=>array(
				'class'=>'application.controllers.task.list.UpdateAction',
			),
			'delete'=>array(
				'class'=>'application.controllers.task.list.DeleteAction',
			),
			'all'=>array(
				'class'=>'application.controllers.task.list.GetAllAction',
			),
		);
	}
	
	public function actionGet()
	{
		$id = Yii::app()->getRequest()->getParam("id", "-1");
		$criteria = new CDbCriteria();
		$criteria->select='id, list_id, title, starred';  // 只选择 'title' 列
		$criteria->condition='list_id=999';
		$items=TaskItem::model()->findAll($criteria);
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index', array('taskItems' => $items));
	}
}