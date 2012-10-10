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
				'actions'=>array('minicreate', 'create','add','update','index','view','list','jsonlist','jsonupdate'),
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

	public function actionCreate()
	{
		$id = $_POST['id'];
		$payment = new Payment;
		$payment->order_id = $id;
		$payment->create_date = time();
		$payment->client_price = 0;
		$payment->designer_price = 0;
		$payment->debt = true;
		$payment->save();
		echo('ok');
		Yii::app()->end();
	}

	public function actionAdd()
	{
		$id = $_POST['id'];
		$value = $_POST['value'];
		$paymentHistory = new PaymentHistory;
		$paymentHistory->payment_id = $id;
		$paymentHistory->create_date = time();
		$paymentHistory->amount = $value;
		$paymentHistory->save();
		echo('ok');
		Yii::app()->end();
	}

	public function actionJsonlist() {
		$id = $_GET['id'];
		// create a new EditableGrid object
		$grid = new EditableGrid();

		//$grid->addColumn('id', 'ID', 'integer', NULL, false);
		$grid->addColumn('debt', 'Долг', 'boolean', NULL, true);
		$grid->addColumn('client_price', 'Общая стоимость, руб.', 'double(,0,comma,&nbsp;,)', NULL, true);
		$grid->addColumn('designer_price', 'Дизайнеру', 'double(,0,comma,&nbsp;,)', NULL, true);//'date');
		$grid->addColumn('penny', 'Комиссия', 'double(,0,comma,&nbsp;,)');
		$grid->addColumn('paid', 'Получено от клиента', 'double(,0,comma,&nbsp;,)');
		$grid->addColumn('paidhistory', 'Оплатить', 'string');

		$result = Payment::model()->findAll('order_id=:id', array(':id'=>$id));

		$this->layout=false;
		// send data to the browser
		$grid->renderJSON($result);
		Yii::app()->end();
	}

	public function actionJsonupdate() {
		$id = $_POST['id'];
		$colname = $_POST['colname'];
		$newvalue = $_POST['newvalue'];

		$model = $this->loadModel($id, 'Payment');
		$model->$colname=$newvalue;
		$model->save();
		echo('ok');
		Yii::app()->end();
	}
}