<?php

class PriorityController extends GxController {

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
		$model = new Priority();

		if (isset($_POST['Priority'])) {
			$model->setAttributes($_POST['Priority']);
			if ($model->save()) {
				$this->redirect(array('list'));
			}
		}
		$this->render('list', array(
			'model' => $model
		));
	}

	public function actionJsonlist() {
		
		// create a new EditableGrid object
		$grid = new EditableGrid();

		//$grid->addColumn('id', 'ID', 'integer', NULL, false);
		$grid->addColumn('name', 'Название', 'string', NULL, true);
		$grid->addColumn('code', 'Шифр', 'string', NULL, true);
		$grid->addColumn('sort_order', 'Порядок сортировки', 'штеупук', NULL, true);
		$grid->addColumn('disabled', 'Удален', 'boolean', NULL, true);

		$result = Priority::model()
				->findAll('disabled=0');

		$this->layout=false;
		// send data to the browser
		$grid->renderJSON($result);
		Yii::app()->end();
	}

	public function actionJsonupdate() {
		$id = $_POST['id'];
		$colname = $_POST['colname'];
		$newvalue = $_POST['newvalue'];
		
		$model = $this->loadModel($id, 'Priority');
		$model->$colname=$newvalue;
		$model->save();
		
		echo('ok');
		Yii::app()->end();
	}
}
