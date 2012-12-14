<?php

class MailerController extends GxController {

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
		
		if(isset($_POST['Mailer'])){
			$users = User2::model()->with(array(
					'authAssignments'=>array(
						// we don't want to select posts
						'select'=>false,
						// but want to get only users with published posts
						'joinType'=>'INNER JOIN',
						'condition'=>'authAssignments.itemname=:role_id',
						'params'=>array(':role_id'=>$_POST['Mailer']['role_id'])
					),
				),
				'profile'
			)->findAll('disabled=0');
			foreach ($users as $key => $value) {
				$message = new YiiMailMessage;
				$message->setBody($_POST['Mailer']['text']);
				$message->subject = 'Новости vdv-design.ru';
				$message->addTo($value->email);
				$message->from = Yii::app()->params['adminEmail'];
				Yii::app()->mail->send($message);
			}
		}
		$this->render('list', array());
	}

}
