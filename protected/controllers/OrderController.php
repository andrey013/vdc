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

		if (isset($_POST['Order'])&&isset($_POST['Order']['clientPrice'])) {
			Yii::log('post is here', 'info');
			$model->setAttributes($_POST['Order']);
			Yii::log('attributes set', 'info');
			$model->setCustomerName($_POST['Order']['customername']);
			$model->setChromaticityName($_POST['Order']['chromaticityname']);
			$model->setDensityName($_POST['Order']['densityname']);
			$model->orderStatusHist = $_POST['Order']['orderStatusHist'];
			$model->clientPrice = $_POST['Order']['clientPrice'];
			$model->designerPrice = $_POST['Order']['designerPrice'];
			//$model->create_date = date('Y-m-d H:i:s', $model->create_date);
			if ($model->save()) {
				$model->setOrderStatus($_POST['Order']['orderStatusHist']);
				$model->setPayment($_POST['Order']['clientPrice'], $_POST['Order']['designerPrice']);
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('update', 'id' => $model->id));
			}
		} else {
			if (isset($_POST['Order'])) {
				$model->setAttributes($_POST['Order']);
				$model->setCustomerName($_POST['Order']['customername']);
				$model->setChromaticityName($_POST['Order']['chromaticityname']);
				$model->setDensityName($_POST['Order']['densityname']);
				$model->orderStatusHist = $_POST['Order']['orderStatusHist'];
			} else {
				$model->orderStatusHist = 'work';
			}
			$model->create_date = time(); //Yii::app()->dateFormatter->format('d.MM.yyyy H:m:s', time());
			$model->client = Client::model()->findByPk(User2::model()->findByPk(Yii::app()->user->id)->profile->client_id);
			$model->client_id = $model->client->id;
			$model->clientPrice = '0';
			$model->designerPrice = '0';
			$model->difficulty = Difficulty::model()->findByPk('2');
			$model->difficulty_id = $model->difficulty->id;
			$model->priority = Priority::model()->findByPk('2');
			$model->priority_id = $model->priority->id;
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
				if($_POST['Order']['orderStatusHist'] != $model->orderStatusHist->orderStatus->key)
					$model->setOrderStatus($_POST['Order']['orderStatusHist']);
				$this->redirect(array('list'));
			}
		}
		$model->orderStatusHist = $model->orderStatusHist->orderStatus->key;
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

		$user = User2::model()->with('profile')->findByPk(Yii::app()->user->id);

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

		$criteria1=new CDbCriteria();
		$criteria2=new CDbCriteria();
		//echo $user->role_id;
		if($user->role_id=='Admin'){
			//$grid->addColumn('id', 'ID', 'integer', NULL, false);
			$grid->addColumn('priority.name', '!', 'integer');
			$grid->addColumn('createdateformatted', 'Дата', 'string');//'date');
			$grid->addColumn('customer.name', 'Заказчик', 'string');
			$grid->addColumn('orderType.name', 'Вид', 'string');
			$grid->addColumn('comment', 'Комментарий', 'string');
			$grid->addColumn('client.name', 'Клиент', 'string');
			$grid->addColumn('designer_id', 'Дизайнер', 'integer',
				$grid->fetch_pairs($designers, 'id', 'profile.lastname'), true);
			$grid->addColumn('orderStatusHist.statusformatted', 'Статус', 'string');
			$grid->addColumn('client_price', 'Стоимость', 'double(,0,comma,&nbsp;,)');
			$grid->addColumn('designer_price', ' ', 'double(,0,comma,&nbsp;,)');
			$grid->addColumn('penny', ' ', 'double(,0,comma,&nbsp;,)');
			$grid->addColumn('paid', 'О', 'boolean', null, true);
			$grid->addColumn('designer_paid', 'Д', 'boolean', null, true);
			$grid->addColumn('orderStatusHist.key', ' ', 'string');

			$criteria1->order = 'DATE(t.create_date) DESC, priority.sort_order, orderStatus.sort_order';
			$criteria1->condition = 'orderStatusHist.order_status_id!=\'8\'';

			$criteria2->order = 'DATE(t.create_date) DESC, priority.sort_order, orderStatus.sort_order';
			$criteria2->condition = 'orderStatusHist.order_status_id=\'8\'';
		}else if($user->role_id=='Manager'){
			$grid->addColumn('priority.name', '!', 'integer');
			$grid->addColumn('createdateformatted', 'Дата', 'string');//'date');
			$grid->addColumn('customer.name', 'Заказчик', 'string');
			$grid->addColumn('orderType.name', 'Вид', 'string');
			$grid->addColumn('comment', 'Комментарий', 'string');
			$grid->addColumn('client.name', 'Клиент', 'string');
			$grid->addColumn('designer_id', 'Дизайнер', 'integer',
				$grid->fetch_pairs($designers, 'id', 'profile.lastname'), false);
			$grid->addColumn('orderStatusHist.statusformatted', 'Статус', 'string');
			$grid->addColumn('client_price', 'Стоимость', 'double(,0,comma,&nbsp;,)');
			$grid->addColumn('orderStatusHist.key', ' ', 'string');

			
			$criteria1->order = 'DATE(t.create_date) DESC, priority.sort_order, orderStatus.sort_order';
			$criteria1->condition = 'orderStatusHist.order_status_id!=\'8\' and t.client_id=:client_id';
			$criteria1->params=array(':client_id'=>$user->profile->client_id);

			$criteria2->order = 'DATE(t.create_date) DESC, priority.sort_order, orderStatus.sort_order';
			$criteria2->condition = 'orderStatusHist.order_status_id=\'8\' and t.client_id=:client_id';
			$criteria2->params=array(':client_id'=>$user->profile->client_id);
	
		}else if($user->role_id=='Designer'){
			$grid->addColumn('priority.name', '!', 'integer');
			$grid->addColumn('createdateformatted', 'Дата', 'string');//'date');
			$grid->addColumn('customer.name', 'Заказчик', 'string');
			$grid->addColumn('orderType.name', 'Вид', 'string');
			$grid->addColumn('comment', 'Комментарий', 'string');
			$grid->addColumn('client.name', 'Клиент', 'string');
			$grid->addColumn('designer_id', 'Дизайнер', 'integer',
				$grid->fetch_pairs($designers, 'id', 'profile.lastname'), false);
			$grid->addColumn('orderStatusHist.statusformatted', 'Статус', 'string');
			$grid->addColumn('designer_price', 'Стоимость', 'double(,0,comma,&nbsp;,)');
			$grid->addColumn('orderStatusHist.key', ' ', 'string');

			
			$criteria1->order = 'DATE(t.create_date) DESC, priority.sort_order, orderStatus.sort_order';
			$criteria1->condition = 'orderStatusHist.order_status_id!=\'8\' and t.designer_id=:designer_id';
			$criteria1->params=array(':designer_id'=>$user->id);

			$criteria2->order = 'DATE(t.create_date) DESC, priority.sort_order, orderStatus.sort_order';
			$criteria2->condition = 'orderStatusHist.order_status_id=\'8\' and t.designer_id=:designer_id';
			$criteria2->params=array(':designer_id'=>$user->id);
	
		}

		$result = array_merge(
				  Order::model()
				->with('orderStatusHist', 'orderStatusHist.orderStatus', 'client', 'orderType', 'customer', 'priority', 'designer', 'designer.profile', 'payments')
				->findAll($criteria1)
				, Order::model()
				->with('orderStatusHist', 'orderStatusHist.orderStatus', 'client', 'orderType', 'customer', 'priority', 'designer', 'designer.profile', 'payments')
				->findAll($criteria2)
				);
		$this->layout=false;
		// send data to the browser
		$grid->renderJSON($result);
		Yii::app()->end();
	}

	public function actionJsonupdate() {
		$id = $_POST['id'];
		$colname = $_POST['colname'];
		$newvalue = $_POST['newvalue'];
		if($colname == 'paid' && $newvalue == 1){
			$model = $this->loadModel($id, 'Order');
			$rows = $model->payments;
			foreach ($rows as $row) {
                                if($row->debt == 1){
				        $paymentHistory = new PaymentHistory;
				        $paymentHistory->payment_id = $row->id;
				        $paymentHistory->create_date = time();
				        $paymentHistory->amount = $row->client_price - $row->paid;
				        $paymentHistory->save();
				        $row->debt = 0;
				        if($row->save()){
					        echo "ok";
				        }else{
					        echo print_r($row->getErrors());
				        }
                                }
			}
		}else{
			$model = $this->loadModel($id, 'Order');
			$model->$colname=$newvalue;
			$model->save();
		}
		echo('ok');
		Yii::app()->end();
	}
}
