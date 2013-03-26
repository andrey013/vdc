<?php

class DesignerController extends GxController {

public $layout='column1';


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
				'actions'=>array('list','jsonlist','changeAutoMode','jsonupdate'),
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
		$this->render('list', array('variables' => Variables::model()->find()));
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
                                'profile'=>array()
			)
		)->findAll('disabled=0');

		// create a new EditableGrid object
		$grid = new EditableGrid();

		//$grid->addColumn('id', 'ID', 'integer', NULL, false);
		$grid->addColumn('isnext', ' ', 'boolean', NULL, false);
		$grid->addColumn('lastname', 'Дизайнер', 'string', NULL, false);
		$grid->addColumn('profile.user_status_id', 'Статус', 'integer',
				$grid->fetch_pairs(UserStatus::model()->findAll(), 'id', 'name'), true);
		$grid->addColumn('jsonprojects', 'Кол-во заказов', 'string', NULL, false);//'date');
		$grid->addColumn('highpriorityjsonprojects', 'С приоритетом 1', 'string', NULL, false);
		$grid->addColumn('profile.client_id', 'Редакция', 'integer',
				$grid->fetch_pairs(Client::model()->findAll('disabled=0'), 'id', 'name'), true);

		$result = $designers;

		$this->layout=false;
		// send data to the browser
		$grid->renderJSON($result);
		Yii::app()->end();
	}

	public function actionChangeAutoMode($order_busy_designers){
		$variables = Variables::model()->find();
		$variables->order_busy_designers = $order_busy_designers;
		$variables->save();
	}

        public function actionJsonupdate() {
		$id = $_POST['id'];
		$colname = $_POST['colname'];
		$newvalue = $_POST['newvalue'];
		if($colname == 'profile.client_id'){
			$model = $this->loadModel($id, 'User2');
			$profile = $model->profile;
			$profile->client_id = $newvalue;
			$profile->save();
		}else if($colname == 'profile.user_status_id'){
			$model = $this->loadModel($id, 'User2');
			$profile = $model->profile;
			$profile->user_status_id = $newvalue;
			$profile->save();
		}
		echo('ok');
		Yii::app()->end();
	}


}
