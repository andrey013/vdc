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
				'actions'=>array('minicreate', 'create','update','index','view','list','print','jsonlist','jsonprint','jsonupdate'),
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

		if (isset($_POST['Order'])&&isset($_POST['Order']['clientPrice'])&&$_POST['Order']['clientPrice']!='') {
			Yii::log('post is here', 'info');
			$model->setAttributes($_POST['Order']);
			Yii::log('attributes set', 'info');
			$model->setCustomerName($_POST['Order']['customername']);
			$model->setChromaticityName($_POST['Order']['chromaticityname']);
			$model->setDensityName($_POST['Order']['densityname']);
			$model->orderStatusHist = $_POST['Order']['orderStatusHist'];
			$model->clientPrice = $_POST['Order']['clientPrice'];
			$model->designerPrice = $_POST['Order']['designerPrice'];
			$next = User2::getNext();
			if($model->designer_id==''){
				if(!is_null($next)){
					$model->designer_id = $next->id;
				}
			}
            $model->id = $_POST['Order']['global_number'];
			//$model->create_date = date('Y-m-d H:i:s', $model->create_date);
			if ($model->save()) {
				$model->setOrderStatus($_POST['Order']['orderStatusHist']);
				$model->setPayment($_POST['Order']['clientPrice'], $_POST['Order']['designerPrice']);

				if(isset($model->designer_id)&&!is_null($next)){
					if($model->designer_id==$next->id){
						$variables = Variables::model()->find();
						$variables->prev_designer_id = $model->designer_id;
						$variables->save();

						//$profile = User2::model()->with('profile')->findByPk($model->designer_id)->profile;
						//$profile->user_status_id = 0;
						//$profile->save();
					}
				}

				$model->refresh();
				$users = array();/*User2::model()->with(array(
						'authAssignments'=>array(
							// we don't want to select posts
							'select'=>false,
							// but want to get only users with published posts
							'joinType'=>'INNER JOIN',
							'condition'=>'authAssignments.itemname=:role_id',
							'params'=>array(':role_id'=>'Admin')
						),
					),
					'profile'
				)->findAll('disabled=0');*/
				$users[] = $model->designer;
				//$users[] = $model->manager;
				foreach ($users as $key => $value) {
					if(is_null($value)) continue;
					$message = new YiiMailMessage;
					$message->setBody('Уважаемый дизайнер '.$value->username
						.', вам поступил в разработку новый заказ: '
						.$model->customername.' '
						.$model->client_number.' '
						.' '.$model->orderType->name);
					$message->subject = 'Новый заказ';
					$message->addTo($value->email);
					$message->from = Yii::app()->params['adminEmail'];
					Yii::app()->mail->send($message);
				}

				if (Yii::app()->getRequest()->getIsAjaxRequest()){
					Yii::app()->end();
				} else {
					if(isset($_POST['action'])&&$_POST['action']=='files'){
						$this->redirect(array('update', 'id' => $model->id, '#' => 'tofiles'));
					} else {
						$this->redirect(array('list'));
					}
				}
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
			$user = User2::model()->findByPk(Yii::app()->user->id);
			$model->client = Client::model()->findByPk($user->profile->client_id);
			$model->client_id = $model->client->id;
			if($user->role_id == 'Manager'){
				$model->manager = $user;
				$model->manager_id = $user->id;
			}
			$model->clientPrice = '0';
			$model->designerPrice = '0';
			$model->difficulty = Difficulty::model()->findByPk('2');
			$model->difficulty_id = $model->difficulty->id;
			$model->priority = Priority::model()->findByPk('2');
			$model->priority_id = $model->priority->id;
			$variables = Variables::model()->find();
			$number = $variables->max_global_number + 1;
			$model->global_number = $number;
            $model->id = $number;
			$variables->max_global_number = $number;
			$variables->save();
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Order');

		$this->performAjaxValidation($model, 'order-form');
		$user = User2::model()->with('profile')->findByPk(Yii::app()->user->id);
		$user_id = $user->id;
		if($user->role_id=='Designer'&&($user_id!=$model->designer_id||$model->disabled==1))
			throw new CHttpException(401, 'У вас недостаточно прав для просмотра этой информации');
		if (isset($_POST['Order'])) {
                        $olddesigner = $model->designer;
			$model->setAttributes($_POST['Order']);
			$model->setCustomerName($_POST['Order']['customername']);
			$model->setChromaticityName($_POST['Order']['chromaticityname']);
			$model->setDensityName($_POST['Order']['densityname']);
                        
			if ($model->save()) {
                                $payments = $model->payments;
                                if(count($payments)==1){
                                        //Yii::log($_POST['Order']['clientPrice'] . ' - ' . $_POST['Order']['designerPrice'], 'info');
                                        $payments[0]->client_price = $_POST['Order']['clientPrice'];
                                        $payments[0]->designer_price = $_POST['Order']['designerPrice'];
                                        $payments[0]->save();
                                }
				if($_POST['Order']['orderStatusHist'] != $model->orderStatusHist->orderStatus->key){
					$model->setOrderStatus($_POST['Order']['orderStatusHist']);
					$model->refresh();

					$users = array();/*User2::model()->with(array(
							'authAssignments'=>array(
								// we don't want to select posts
								'select'=>false,
								// but want to get only users with published posts
								'joinType'=>'INNER JOIN',
								'condition'=>'authAssignments.itemname=:role_id',
								'params'=>array(':role_id'=>'Admin')
							),
						),
						'profile'
					)->findAll('disabled=0');*/
					
					if($user_id!=$model->designer_id) $users[] = $model->designer;
					if($user_id!=$model->manager_id) $users[] = $model->manager;
					foreach ($users as $key => $value) {
						if(is_null($value)) continue;
						$message = new YiiMailMessage;
						$message->setBody('Уважаемый пользователь ВДЦ '.$value->username
							.' заказ '
							.$model->customername.' '
							.$model->client_number.' '
							.' '.$model->orderType->name
							.' сменил свой статус - "'.$model->orderStatusHist->orderStatus->name.'"');
						$message->subject = 'Смена статуса';
						$message->addTo($value->email);
						$message->from = Yii::app()->params['adminEmail'];
						Yii::app()->mail->send($message);
					}
				}
                                $model->refresh();
                                if((is_null($olddesigner)?-1:$olddesigner->id) != (is_null($model->designer)?-1:$model->designer->id)){
				        
                                        $this->designerChange($model, $olddesigner, $model->designer);
                                }
				$this->redirect(array('list'));
			}
		}
		$model->orderStatusHist = $model->orderStatusHist->orderStatus->key;
		$model->clientPrice = $model->client_price;
		$model->designerPrice = $model->designer_price;
		$model->debtPrice = $model->debt;
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

	public function actionPrint() {
		$this->layout='login';
		$dataProvider = new CActiveDataProvider('Order');
		$this->render('print', array(
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

		$start = '2000-01-01';
		$end   = '2099-01-01';
		if (isset($_GET['start'])) {
			$start = date('Y-m-d H:i:s', CDateTimeParser::parse(
									$_GET['start'], 
									'dd.MM.yyyy'
								));
		}
		if (isset($_GET['end'])) {
			$end = date('Y-m-d H:i:s', strtotime("+1 day", CDateTimeParser::parse(
									$_GET['end'], 
									'dd.MM.yyyy'
								)));
		}

		$criteria1=new CDbCriteria();
		$criteria2=new CDbCriteria();
		//echo $user->role_id;

		$order = 'DATE(t.create_date) DESC, priority.sort_order, orderStatus.sort_order, global_number DESC';

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
                        $grid->addColumn('debt', 'Долг', 'double(,0,comma,&nbsp;,)');
			$grid->addColumn('paid', 'О', 'boolean', null, true);
			$grid->addColumn('designer_paid', 'Д', 'boolean', null, true);
			$grid->addColumn('disabled', 'X', 'boolean', null, true);
			$grid->addColumn('filter', ' ', 'string');

			$criteria1->order = $order;
			$criteria1->condition = 'orderStatusHist.order_status_id!=\'8\' and t.create_date between :start and :end and t.disabled=0';
			$criteria1->params=array(':start'=>$start, ':end'=>$end);

			$criteria2->order = $order;
			$criteria2->condition = 'orderStatusHist.order_status_id=\'8\' and t.create_date between :start and :end and t.disabled=0';
			$criteria2->params=array(':start'=>$start, ':end'=>$end);
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
			$grid->addColumn('filter', ' ', 'string');

			
			$criteria1->order = $order;
			$criteria1->condition = 'orderStatusHist.order_status_id!=\'8\' and t.client_id=:client_id and t.create_date between :start and :end and t.disabled=0';
			$criteria1->params=array(':client_id'=>$user->profile->client_id, ':start'=>$start, ':end'=>$end);

			$criteria2->order = $order;
			$criteria2->condition = 'orderStatusHist.order_status_id=\'8\' and t.client_id=:client_id and t.create_date between :start and :end and t.disabled=0';
			$criteria2->params=array(':client_id'=>$user->profile->client_id, ':start'=>$start, ':end'=>$end);
	
		}else if($user->role_id=='Designer'){
			$grid->addColumn('priority.name', '!', 'integer');
			$grid->addColumn('createdateformatted', 'Дата', 'string');//'date');
			$grid->addColumn('customer.name', 'Заказчик', 'string');
			$grid->addColumn('orderType.name', 'Вид', 'string');
			$grid->addColumn('comment', 'Комментарий', 'string');
			$grid->addColumn('client.name', 'Клиент', 'string');
			$grid->addColumn('orderStatusHist.statusformatted', 'Статус', 'string');
			$grid->addColumn('designer_price', 'Стоимость', 'double(,0,comma,&nbsp;,)');
			$grid->addColumn('filter', ' ', 'string');

			
			$criteria1->order = $order;
			$criteria1->condition = 'orderStatusHist.order_status_id!=\'8\' and t.designer_id=:designer_id and t.create_date between :start and :end and t.disabled=0';
			$criteria1->params=array(':designer_id'=>$user->id, ':start'=>$start, ':end'=>$end);

			$criteria2->order = $order;
			$criteria2->condition = 'orderStatusHist.order_status_id=\'8\' and t.designer_id=:designer_id and t.create_date between :start and :end and t.disabled=0';
			$criteria2->params=array(':designer_id'=>$user->id, ':start'=>$start, ':end'=>$end);
	
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

	public function actionJsonprint() {
		
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

		$managers=User2::model()->with(array(
				'authAssignments'=>array(
					// we don't want to select posts
					'select'=>false,
					// but want to get only users with published posts
					'joinType'=>'INNER JOIN',
					'condition'=>'authAssignments.itemname=\'Manager\'',
				),
			),
			'profile'
		)->findAll('disabled=0');

		$start = '2000-01-01';
		$end   = '2099-01-01';
		if (isset($_GET['start'])) {
			$start = date('Y-m-d H:i:s', CDateTimeParser::parse(
									$_GET['start'], 
									'dd.MM.yyyy'
								));
		}
		if (isset($_GET['end'])) {
			$end = date('Y-m-d H:i:s', strtotime("+1 day", CDateTimeParser::parse(
									$_GET['end'], 
									'dd.MM.yyyy'
								)));
		}

		$criteria1=new CDbCriteria();
		$criteria2=new CDbCriteria();
		//echo $user->role_id;

		$order = 'DATE(t.create_date) DESC, priority.sort_order, orderStatus.sort_order, global_number DESC';

		if($user->role_id=='Admin'){
			//$grid->addColumn('id', 'ID', 'integer', NULL, false);
			$grid->addColumn('priority.name', '!', 'integer');
			$grid->addColumn('createdateformatted', 'Дата', 'string');//'date');
			$grid->addColumn('client.name', 'Клиент', 'string');
			$grid->addColumn('global_number', '№ заказа', 'string');
			$grid->addColumn('client_number', '№ заказа у заказчика', 'string');
			$grid->addColumn('manager_id', 'Менеджер', 'integer',
				$grid->fetch_pairs($managers, 'id', 'profile.lastname'), false);
			$grid->addColumn('orderType.name', 'Вид заказа', 'string');
			$grid->addColumn('customer.name', 'Заказчик', 'string');
			
			$grid->addColumn('designer_id', 'Дизайнер', 'integer',
				$grid->fetch_pairs($designers, 'id', 'profile.lastname'), false);
			$grid->addColumn('orderStatusHist.statusformatted', 'Статус', 'string');
			$grid->addColumn('client_price', 'Стоимость', 'double(,0,comma,&nbsp;,)');
			$grid->addColumn('designer_price', ' ', 'double(,0,comma,&nbsp;,)');
			$grid->addColumn('penny', ' ', 'double(,0,comma,&nbsp;,)');
			$grid->addColumn('dateformatted', 'Дата платежа', 'string');
			$grid->addColumn('pay', 'Платеж', 'double(,0,comma,&nbsp;,)');
			$grid->addColumn('debtPrice', 'Долг', 'double(,0,comma,&nbsp;,)');
			$grid->addColumn('filter', ' ', 'string');
			
			$criteria1->order = $order;
			$criteria1->condition = 'orderStatusHist.order_status_id!=\'8\' and t.create_date between :start and :end and t.disabled=0';
			$criteria1->params=array(':start'=>$start, ':end'=>$end);

			$criteria2->order = $order;
			$criteria2->condition = 'orderStatusHist.order_status_id=\'8\' and t.create_date between :start and :end and t.disabled=0';
			$criteria2->params=array(':start'=>$start, ':end'=>$end);
		}else if($user->role_id=='Manager'){
			$grid->addColumn('priority.name', '!', 'integer');
			$grid->addColumn('createdateformatted', 'Дата', 'string');//'date');
			$grid->addColumn('client.name', 'Клиент', 'string');
			$grid->addColumn('global_number', '№ заказа', 'string');
			$grid->addColumn('client_number', '№ заказа у заказчика', 'string');
			$grid->addColumn('orderType.name', 'Вид заказа', 'string');
			$grid->addColumn('customer.name', 'Заказчик', 'string');
			$grid->addColumn('designer_id', 'Дизайнер', 'integer',
				$grid->fetch_pairs($designers, 'id', 'profile.lastname'), false);
			$grid->addColumn('orderStatusHist.statusformatted', 'Статус', 'string');
			$grid->addColumn('client_price', 'Стоимость', 'double(,0,comma,&nbsp;,)');
			$grid->addColumn('debt', 'Долг', 'double(,0,comma,&nbsp;,)');
			$grid->addColumn('filter', ' ', 'string');

			
			$criteria1->order = $order;
			$criteria1->condition = 'orderStatusHist.order_status_id!=\'8\' and t.client_id=:client_id and t.create_date between :start and :end and t.disabled=0';
			$criteria1->params=array(':client_id'=>$user->profile->client_id, ':start'=>$start, ':end'=>$end);

			$criteria2->order = $order;
			$criteria2->condition = 'orderStatusHist.order_status_id=\'8\' and t.client_id=:client_id and t.create_date between :start and :end and t.disabled=0';
			$criteria2->params=array(':client_id'=>$user->profile->client_id, ':start'=>$start, ':end'=>$end);
	
		}else if($user->role_id=='Designer'){
			$grid->addColumn('priority.name', '!', 'integer');
			$grid->addColumn('createdateformatted', 'Дата', 'string');//'date');
			$grid->addColumn('client.name', 'Клиент', 'string');
			$grid->addColumn('global_number', '№ заказа', 'string');
			$grid->addColumn('client_number', '№ заказа у заказчика', 'string');
			$grid->addColumn('manager_id', 'Менеджер', 'integer',
				$grid->fetch_pairs($managers, 'id', 'profile.lastname'), false);
			$grid->addColumn('orderType.name', 'Вид заказа', 'string');
			$grid->addColumn('customer.name', 'Заказчик', 'string');
			$grid->addColumn('orderStatusHist.statusformatted', 'Статус', 'string');
			$grid->addColumn('designer_price', 'Стоимость', 'double(,0,comma,&nbsp;,)');
			$grid->addColumn('filter', ' ', 'string');

			
			$criteria1->order = $order;
			$criteria1->condition = 'orderStatusHist.order_status_id!=\'8\' and t.designer_id=:designer_id and t.create_date between :start and :end and t.disabled=0';
			$criteria1->params=array(':designer_id'=>$user->id, ':start'=>$start, ':end'=>$end);

			$criteria2->order = $order;
			$criteria2->condition = 'orderStatusHist.order_status_id=\'8\' and t.designer_id=:designer_id and t.create_date between :start and :end and t.disabled=0';
			$criteria2->params=array(':designer_id'=>$user->id, ':start'=>$start, ':end'=>$end);
	
		}

		$result = array_merge(
				  Order::model()
				->with('orderStatusHist', 'orderStatusHist.orderStatus', 'client', 'orderType', 'customer', 'priority', 'designer', 'designer.profile', 'payments')
				->findAll($criteria1)
				, Order::model()
				->with('orderStatusHist', 'orderStatusHist.orderStatus', 'client', 'orderType', 'customer', 'priority', 'designer', 'designer.profile', 'payments')
				->findAll($criteria2)
				);
                if ($user->role_id=='Admin'){
                        $finalResult = array();
                        foreach ($result as $row) {
                                $row->debtPrice=$row->client_price;
                                $row->pay = 0;
                                $payment = Payment::model()->findAll("order_id=:order_id", array(':order_id'=>$row->id));
                                if(count($payment)==1){
                                        $payments = PaymentHistory::model()->findAll("payment_id=:payment_id", array(':payment_id'=>$payment[0]->id));
                                        if(count($payments)>0){
                                                foreach ($payments as $pay) {
                                                        $row->pay = $pay->amount;
                                                        $row->dateformatted = Yii::app()->dateFormatter->format('d.MM.yyyy', $pay->create_date);
                                                        $row->debtPrice=$row->debtPrice-$row->pay;
                                                        $finalResult[] = clone $row;
                                                        $row->client_price = 0;
                                                        $row->designer_price = 0;
                                                        $row->penny = 0;
                                                }
                                                
                                        } else {
                                                $finalResult[] = $row;
                                        }
                                } else {
                                        $finalResult[] = $row;
                                }
                        }
                        $result = $finalResult;
                }
		$this->layout=false;
		// send data to the browser
		$grid->renderJSON($result);
		Yii::app()->end();
	}

	public function actionJsonupdate() {
		$ids = array();
		if (isset($_POST['id'])) {
			$ids[] = $_POST['id'];
		} else if(isset($_POST['ids'])){
			$ids = $_POST['ids'];
		}
		$colname = $_POST['colname'];
		$newvalue = $_POST['newvalue'];
		foreach ($ids as $id) {
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
					        
				        }else{
					        echo print_r($row->getErrors());
				        }
	                }
				}
			}else if($colname == 'designer_id'){
				$model = $this->loadModel($id, 'Order');
				$olddesigner = $model->designer;
				$model->$colname=$newvalue;

				$model->save();

				$model->refresh();
                                $this->designerChange($model, $olddesigner, $model->designer);
			}else{
				$model = $this->loadModel($id, 'Order');
				$model->$colname=$newvalue;
				$model->save();
			}
		}
		echo('ok');
		Yii::app()->end();
	}

        public function designerChange($model, $old, $new) {
                //новому
		$users = array($new);
		foreach ($users as $key => $value) {
			if(is_null($value)) continue;
			$message = new YiiMailMessage;
			$message->setBody('Уважаемый дизайнер '.$value->username
				.', вам поступил в разработку новый заказ: '
				.$model->customername.' '
				.$model->client_number.' '
				.' '.$model->orderType->name);
			$message->subject = 'Новый заказ';
			$message->addTo($value->email);
			$message->from = Yii::app()->params['adminEmail'];
			Yii::app()->mail->send($message);
		}
		//старому
		$users = array($old);
		foreach ($users as $key => $value) {
			if(is_null($value)) continue;
			$message = new YiiMailMessage;
			$message->setBody('Внимание! Заказ '
				.$model->customername.' '
				.$model->client_number.' '
				.' '.$model->orderType->name
				.' передан другому дизайнеру');
			$message->subject = 'Заказ передан другому дизайнеру';
			$message->addTo($value->email);
			$message->from = Yii::app()->params['adminEmail'];
			Yii::app()->mail->send($message);
		}
        }

}
