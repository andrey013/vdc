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
				'actions'=>array('json'),
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

		header('Pragma: no-cache');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Content-Disposition: inline; filename="files.json"');
		header('X-Content-Type-Options: nosniff');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
		header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

		switch ($_SERVER['REQUEST_METHOD']) {
		    case 'OPTIONS':
		        break;
		    case 'HEAD':
		    case 'GET':
		        $upload_handler->get();
		        break;
		    case 'POST':
		        if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
		            $upload_handler->delete();
		        } else {
		            $upload_handler->post();
		        }
		        break;
		    case 'DELETE':
		        $upload_handler->delete();
		        break;
		    default:
		        header('HTTP/1.1 405 Method Not Allowed');
		}
		Yii::app()->end();
	}

}