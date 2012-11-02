<?php

class DesignerController extends GxController {

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
		$this->render('list'));
	}

	public function actionJsonlist() {
		
		// create a new EditableGrid object
		$grid = new EditableGrid();

		//$grid->addColumn('id', 'ID', 'integer', NULL, false);
		$grid->addColumn('lastname', 'Дизайнер', 'string', NULL, true);
		$grid->addColumn('profile.user_status_id', 'Редакция', 'integer',
				EditableGrid::fetch_pairs(Client::model()->findAll(), 'id', 'name'), true);
		$grid->addColumn('role_id', 'Тип пользователя', 'string',
				EditableGrid::fetch_pairs(AuthItem::model()->findAll('description IS NOT NULL'), 'name', 'description'), true);
		$grid->addColumn('email', 'email', 'email', NULL, true);//'date');
		$grid->addColumn('emptypassword', 'Пароль', 'string', NULL, true);
		
		$grid->addColumn('disabled', 'Удален', 'boolean', NULL, true);

		$result = User2::model()
				->with('authAssignment', 'profile')
				->findAll();

		$this->layout=false;
		// send data to the browser
		$grid->renderJSON($result);
		Yii::app()->end();
	}
}
