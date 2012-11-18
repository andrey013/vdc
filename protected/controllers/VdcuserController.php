<?php

class VdcuserController extends GxController {

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
				'actions'=>array('list','jsonlist','jsonupdate','statusChange'),
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
		$model = new CreateUserForm();

		if (isset($_POST['CreateUserForm'])) {
			$model->setAttributes($_POST['CreateUserForm']);
			if ($model->validate()) {
				
				$user = new User2();
				$user->username = $_POST['CreateUserForm']['lastname'];
				$user->activkey = UserModule::encrypting(microtime().$model->password);
				$user->password = UserModule::encrypting($_POST['CreateUserForm']['password']);
				$user->create_at = 0;
				$user->email = $_POST['CreateUserForm']['email'];
				$user->status = 1;
				$user->save();
				error_log( print_r($user->getErrors(), true) );

				$profile = new Profile2();
				$profile->user_id = $user->id;
				$profile->client_id = $_POST['CreateUserForm']['client_id'];
				$profile->lastname = $user->username;
				$profile->firstname = $user->username;
				$profile->user_status_id = 1;
				$profile->save();
				error_log( print_r($profile->getErrors(), true) );

				$authAssignment = new AuthAssignment();
				$authAssignment->itemname = $_POST['CreateUserForm']['type'];
				$authAssignment->userid = $user->id;
				$authAssignment->data = 'N;';
				$authAssignment->save();
				error_log( print_r($authAssignment->getErrors(), true) );

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

		$grid->addColumn('id', 'ID', 'integer', NULL, false);
		$grid->addColumn('profile.client_id', 'Редакция', 'integer',
				$grid->fetch_pairs(Client::model()->findAll('disabled=0'), 'id', 'name'), true);
		$grid->addColumn('role_id', 'Тип пользователя', 'string',
				$grid->fetch_pairs(AuthItem::model()->findAll('description IS NOT NULL'), 'name', 'description'), true);
		$grid->addColumn('email', 'email', 'email', NULL, true);//'date');
		$grid->addColumn('emptypassword', 'Пароль', 'string', NULL, true);
		$grid->addColumn('lastname', 'Имя', 'string', NULL, true);
		$grid->addColumn('disabled', 'Удален', 'boolean', NULL, true);

		$result = User2::model()
				->with('authAssignment', 'profile')
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
		if($colname == 'profile.client_id'){
			$model = $this->loadModel($id, 'User2');
			$profile = $model->profile;
			$profile->client_id = $newvalue;
			$profile->save();
		}else if($colname == 'role_id'){
			$model = $this->loadModel($id, 'User2');
			$authAssignment = $model->authAssignment;
			$authAssignment->itemname = $newvalue;
			$authAssignment->save();
		}else if($colname == 'lastname'){
			$model = $this->loadModel($id, 'User2');
			$model->username = $newvalue;
			$model->save();
			$profile = $model->profile;
			$profile->lastname = $newvalue;
			$profile->save();
		}else if($colname == 'emptypassword'){
			$model = $this->loadModel($id, 'User2');
			$model->password = UserModule::encrypting($newvalue);
			$model->save();
		}else{
			$model = $this->loadModel($id, 'User2');
			$model->$colname=$newvalue;
			$model->save();
		}
		echo('ok');
		Yii::app()->end();
	}

	public function actionStatusChange() {
		$id = Yii::app()->user->id;
		$status = $_POST['status'];
		if($status == 'free'){
			$model = $this->loadModel($id, 'User2');
			$profile = $model->profile;
			$profile->user_status_id = 1;
			$profile->save();
		}else if($status == 'busy'){
			$model = $this->loadModel($id, 'User2');
			$profile = $model->profile;
			$profile->user_status_id = 0;
			$profile->save();
		}
		echo('ok');
		Yii::app()->end();
	}
}
