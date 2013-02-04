<?php

class FileController extends GxController {

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
				'actions'=>array('json','addLink'),
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

	public function actionJson() {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$id = $_POST['id'];
			$stage = $_POST['stage'];
		}else{
			$id = $_GET['id'];
			$stage = $_GET['stage'];
		}

		$upload_handler = new UploadHandler(array(
				'script_url' => $this->createUrl('/file/json').'/',
           	        	'upload_dir' => dirname($_SERVER['SCRIPT_FILENAME']).'/files/'.$id.'/'.$stage.'/',
                              	'upload_url' => Yii::app()->request->baseUrl.'/files/'.$id.'/'.$stage.'/',
            	                'id' => $id,
                            	'stage' => $stage
			));
		Yii::app()->end();
	}

        public function actionAddLink() {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$id = $_POST['id'];
			$stage = $_POST['stage'];
                        $name = $_POST['name'];
			$link = $_POST['link'];
		}else{
			$id = $_GET['id'];
			$stage = $_GET['stage'];
                        $name = $_GET['name'];
			$link = $_GET['link'];
		}
                $fileName = dirname($_SERVER['SCRIPT_FILENAME']).'/files/'.$id.'/'.$stage.'/@'.$name;
                file_put_contents($fileName, $link);
		Yii::app()->end();
	}

}
