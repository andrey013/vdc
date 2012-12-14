<?php

class VdcinfoController extends GxController {

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
				'actions'=>array('update'),
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


	public function actionUpdate() {
		$model = Variables::model()->find();

		if (isset($_POST['Variables'])) {
			$model->vdc_info = $_POST['Variables']['vdc_info'];
			$model->save();
		}
		$this->render('list', array(
			'model' => $model
		));
	}

	
}
