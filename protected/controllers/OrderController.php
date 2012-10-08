<?php

class OrderController extends GxController {

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
				'actions'=>array('minicreate', 'create','update','index','view','list','jsonlist','jsonupdate'),
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

	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Order'),
		));
	}

	public function actionCreate() {
		$model = new Order();
		$this->performAjaxValidation($model, 'order-form');

		if (isset($_POST['Order'])) {
			Yii::log('post is here', 'info');
			$model->setAttributes($_POST['Order']);
			Yii::log('attributes set', 'info');
			$model->setCustomerName($_POST['Order']['customername']);
			$model->setChromaticityName($_POST['Order']['chromaticityname']);
			$model->setDensityName($_POST['Order']['densityname']);
			//$model->create_date = date('Y-m-d H:i:s', $model->create_date);
			if ($model->save()) {
				$model->setOrderStatus($_POST['Order']['orderStatus']);
				$model->setPayment($_POST['Order']['clientPrice'], $_POST['Order']['designerPrice']);
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('update', 'id' => $model->id));
			}
		} else {
			$model->create_date = time(); //Yii::app()->dateFormatter->format('d.MM.yyyy H:m:s', time());
			$model->client = Client::model()->findByPk(User2::model()->findByPk(Yii::app()->user->id)->profile->client_id);
			$model->orderStatus = 'confirm';
			$model->clientPrice = '0';
			$model->designerPrice = '0';
			$variables = Variables::model()->find();
			$number = $variables->max_global_number + 1;
			$model->global_number = $number;
			$variables->max_global_number = $number;
			$variables->save();
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Order');

		$this->performAjaxValidation($model, 'order-form');

		if (isset($_POST['Order'])) {
			$model->setAttributes($_POST['Order']);
			$model->setCustomerName($_POST['Order']['customername']);
			$model->setChromaticityName($_POST['Order']['chromaticityname']);
			$model->setDensityName($_POST['Order']['densityname']);
			if ($model->save()) {
				$this->redirect(array('update', 'id' => $model->id));
			}
		}
		$model->orderStatus = $model->orderStatus->orderStatus->key;
		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Order')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Order');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Order('search');
		$model->unsetAttributes();

		if (isset($_GET['Order']))
			$model->setAttributes($_GET['Order']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionList() {
		$dataProvider = new CActiveDataProvider('Order');
		$this->render('list', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionJsonlist() {
		
		// create a new EditableGrid object
		$grid = new EditableGrid();

		//$grid->addColumn('id', 'ID', 'integer', NULL, false);
		$grid->addColumn('priority.name', '!', 'integer');
		$grid->addColumn('createdateformatted', 'Дата', 'string');//'date');
		$grid->addColumn('customer.name', 'Наименование заказчика', 'string');
		$grid->addColumn('orderType.name', 'Вид заказа', 'string');
		$grid->addColumn('comment', 'Комментарий', 'string');
		$grid->addColumn('client.name', 'Клиент', 'string');
		$grid->addColumn('designer_id', 'Дизайнер', 'integer', array('0' => '' ,'4' => 'ВикторияК.'), true);
		$grid->addColumn('orderStatus.statusformatted', 'Статус', 'string');
		$grid->addColumn('client_price', ' ', 'double(,0,comma,&nbsp;,)');
		$grid->addColumn('designer_price', 'Стоимость', 'double(,0,comma,&nbsp;,)');
		$grid->addColumn('penny', ' ', 'double(,0,comma,&nbsp;,)');
		$grid->addColumn('debt', 'Оплата', 'boolean');
		$grid->addColumn('isDesignerPaid', 'Дизайнеру', 'boolean');
		$grid->addColumn('action', ' ', 'string');

		$result = Order::model()->with('client', 'orderType', 'customer', 'priority', 'orderStatus', 'designer', 'designer.profile')->findAll();

		$this->layout=false;
		// send data to the browser
		$grid->renderJSON($result);
		Yii::app()->end();
	}
}