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
				'actions'=>array('index','view','list','jsonlist'),
				'users'=>array('*'),
				),
			array('allow', 
				'actions'=>array('minicreate', 'create','update'),
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
			//$model->create_date = date('Y-m-d H:i:s', $model->create_date);
			if ($model->save()) {
				$model->setOrderStatus($_POST['Order']['orderStatus']);
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->id));
			}
		} else {
			$model->create_date = time(); //Yii::app()->dateFormatter->format('d.MM.yyyy H:m:s', time());
			$model->client = Client::model()->findByPk(User2::model()->findByPk(Yii::app()->user->id)->profile->client_id);
			$model->orderStatus = 'confirm';
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

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

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
		$grid->addColumn('designer_id', 'Дизайнер', 'integer', NULL, true);
		$grid->addColumn('orderStatus.statusformatted', 'Статус', 'string');
		$grid->addColumn('cost1', ' ', 'integer');
		$grid->addColumn('cost2', 'Стоимость', 'integer');
		$grid->addColumn('cost3', ' ', 'integer');
		$grid->addColumn('debt', 'Оплата', 'boolean');
		$grid->addColumn('isDesignerPaid', 'Дизайнеру', 'boolean');

		$result = Order::model()->with('client', 'orderType', 'customer', 'priority', 'orderStatus')->findAll();

		$this->layout=false;
		// send data to the browser
		$grid->renderJSON($result);
		Yii::app()->end();
	}
}