<?php

class CommentController extends GxController {

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
		$parent_id = $_POST['parent_id'];
		$text = $_POST['text'];

		$comment = new Comment;
		$comment->text = $text;
		$comment->parent_id = $parent_id;

		if($parent_id==''){
			$maxThreadArray = Yii::app()->db->createCommand()
			    ->select('MAX(thread) t')
			    ->from('vdc_comment c')
			    ->where('order_id=:id', array(':id'=>$id))
			    ->queryRow();
			//print_r($maxThreadArray);
			$maxThread = $maxThreadArray['t'];
			$maxThread = rtrim($maxThread, '/');
	        $parts = explode('.', $maxThread);
	        $firstsegment = $parts[0];
	        $comment->thread = Comment::int2vancode(Comment::vancode2int($firstsegment) + 1);
		}else{
	        $parent = $this->loadModel($parent_id, 'Comment');
	        $parent->thread = (string) rtrim((string) $parent->thread, '/');
			$maxThreadArray = Yii::app()->db->createCommand()
			    ->select('MAX(thread) t')
			    ->from('vdc_comment c')
			    ->where('thread LIKE :thread AND order_id = :id', array(':thread' => $parent->thread.'.%', ':id'=>$id))
			    ->queryRow();
			//print_r($maxThreadArray);
			$maxThread = $maxThreadArray['t'];
	        if ($maxThread=='') {
	            $comment->thread = $parent->thread . '.' . Comment::int2vancode(0);
	        }else{
		        $maxThread = rtrim($maxThread, '/');
		        $parts = explode('.', $maxThread);
		        $parent_depth = count(explode('.', $parent->thread));
		        $last = $parts[$parent_depth];
		        $comment->thread = $parent->thread . '.' . Comment::int2vancode(Comment::vancode2int($last) + 1);
	      	}
	  	}
		$comment->user_id = Yii::app()->user->id;
		$comment->order_id = $id;
		$comment->create_date = time();
		$comment->save();
		//print_r($comment->getErrors());
		echo('ok');
		//Yii::app()->end();
	}

	public function actionJsonlist() {
		$id = $_GET['id'];
		// create a new EditableGrid object
		$grid = new EditableGrid();

		//$grid->addColumn('id', 'ID', 'integer', NULL, false);
		$grid->addColumn('comment', ' ', 'html', NULL, false);

		$criteria=new CDbCriteria();
		$criteria->order = 'thread asc';
		$criteria->condition = 'order_id=:id';
		$criteria->params=array(':id'=>$id);
		$result = Comment::model()->findAll($criteria);

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