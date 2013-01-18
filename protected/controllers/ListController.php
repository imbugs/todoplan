<?php
class ListController extends Controller
{
	public function filters() {
		return array(
            'accessControl',
        );
	}
	
	public function accessRules() {
        return array(
            array('deny',  // deny all guests
				'users'=>array('?')
			)
        );
    }
    
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
			'sort'=>array(
				'class'=>'application.controllers.task.list.SortAction',
			),
		);
	}
}