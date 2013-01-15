<?php
class ItemController extends Controller
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
}