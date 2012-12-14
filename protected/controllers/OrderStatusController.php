<?php

class OrderStatusController extends GxController {

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
				'actions'=>array('list','jsonlist','jsonupdate'),
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
		
		// create a new EditableGrid object
		$grid = new EditableGrid();

		//$grid->addColumn('id', 'ID', 'integer', NULL, false);
		$grid->addColumn('key', 'Ключ', 'string', NULL, false);
		$grid->addColumn('name', 'Название', 'string', NULL, true);
		$grid->addColumn('sort_order', 'Порядок сортировки', 'integer', NULL, true);

		$result = OrderStatus::model()
				->findAll();

		$this->layout=false;
		// send data to the browser
		$grid->renderJSON($result);
		Yii::app()->end();
	}

	public function actionJsonupdate() {
		$id = $_POST['id'];
		$colname = $_POST['colname'];
		$newvalue = $_POST['newvalue'];
		
		$model = $this->loadModel($id, 'OrderStatus');
		$model->$colname=$newvalue;
		$model->save();
		
		echo('ok');
		Yii::app()->end();
	}
}
