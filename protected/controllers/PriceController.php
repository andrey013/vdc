<?php

class PriceController extends GxController {

public $layout='column2';


public function filters() {
	return array(
			'accessControl', 
			);
}

public function accessRules() {
	return array(
			array('allow',
				'actions'=>array(''),
				'users'=>array('*'),
				),
			array('allow', 
				'actions'=>array('list','jsonlist'),
				'users'=>array('@'),
				),
			array('allow', 
				'actions'=>array(''),
				'users'=>array('admin'),
				),
			array('deny', 
				'users'=>array('*'),
				),
			);
}


	public function actionList() {
		$this->render('list');
	}

	public function actionJsonlist() {
		
		$designers=User2::model()->with(array(
				'authAssignments'=>array(
					// we don't want to select posts
					'select'=>false,
					// but want to get only users with published posts
					'joinType'=>'INNER JOIN',
					'condition'=>'authAssignments.itemname=\'Designer\'',
				),
			),
			'profile'
		)->findAll('disabled=0');

		// create a new EditableGrid object
		$grid = new EditableGrid();

		//$grid->addColumn('id', 'ID', 'integer', NULL, false);
		$grid->addColumn('lastname', 'Дизайнер', 'string', NULL, false);
		$grid->addColumn('profile.user_status_id', 'Статус', 'integer',
				$grid->fetch_pairs(UserStatus::model()->findAll(), 'id', 'name'), false);
		$grid->addColumn('jsonprojects', 'Кол-во заказов', 'string', NULL, false);//'date');
		$grid->addColumn('highpriorityjsonprojects', 'С приоритетом 1', 'string', NULL, false);
		

		$result = $designers;

		$this->layout=false;
		// send data to the browser
		$grid->renderJSON($result);
		Yii::app()->end();
	}
}
