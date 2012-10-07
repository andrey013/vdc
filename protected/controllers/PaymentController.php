<?php

class PaymentController extends GxController {

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
				'actions'=>array('minicreate', 'create','update','index','view','list','jsonlist'),
				'users'=>array('@'),
				),
			array('allow', 
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
				),
			array('deny', 
				'users'=>array('*'),
				),
			);
}


	public function actionJsonlist() {
		$id = $_GET['id'];
		// create a new EditableGrid object
		$grid = new EditableGrid();

		//$grid->addColumn('id', 'ID', 'integer', NULL, false);
		$grid->addColumn('debt', 'Долг', 'boolean', NULL, true);
		$grid->addColumn('client_price', 'Общая стоимость, руб.', 'integer', NULL, true);
		$grid->addColumn('designer_price', 'Дизайнеру', 'integer', NULL, true);//'date');
		$grid->addColumn('penny', 'Комиссия', 'integer');
		$grid->addColumn('paid', 'Получено от клиента', 'integer');
		$grid->addColumn('action', ' ', 'string');

		$result = Payment::model()->findAll('order_id=:id', array(':id'=>$id));

		$this->layout=false;
		// send data to the browser
		$grid->renderJSON($result);
		Yii::app()->end();
	}
}