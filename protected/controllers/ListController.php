<?php
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
}