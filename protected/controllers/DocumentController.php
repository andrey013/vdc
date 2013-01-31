<?php

class DocumentController extends GxController {

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
				'actions'=>array('json', 'list', 'jsonlist', 'jsonupdate'),
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

	public function actionList() {
		$this->render('list');
	}

	public function actionJson() {

		$upload_handler = new UploadHandler(array(
				'script_url' => $this->createUrl('/document/json').'/',
           		'upload_dir' => dirname($_SERVER['SCRIPT_FILENAME']).'/files/documents/',
            	'upload_url' => Yii::app()->request->baseUrl.'/files/documents/',
            	'id' => 't',
            	'stage' => 't'
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


	public function actionJsonlist() {

		$upload_handler = new UploadHandler(array(
				'script_url' => $this->createUrl('/document/json').'/',
           		'upload_dir' => dirname($_SERVER['SCRIPT_FILENAME']).'/files/documents/',
            	'upload_url' => Yii::app()->request->baseUrl.'/files/documents/',
            	'id' => 't',
            	'stage' => 't'
			), false);
		// create a new EditableGrid object
		$grid = new EditableGrid();

		//$grid->addColumn('id', 'ID', 'integer', NULL, false);
		$grid->addColumn('filename', 'Имя файла', 'string', NULL, false);
		$grid->addColumn('name', 'Отображаемое имя', 'string', NULL, true);
		$grid->addColumn('designer', 'Дизайнеру', 'boolean', NULL, true);//'date');
		$grid->addColumn('manager', 'Менеджеру', 'boolean', NULL, true);//'date');
		$grid->addColumn('admin', 'Администратору', 'boolean', NULL, true);//'date');
		$grid->addColumn('delete_url', ' ', 'html', NULL, false);//'date');

		$res = $upload_handler->get_file_objects();

		$result = array();
		foreach ($res as $key => $value) {
			$upload_handler->set_file_delete_properties($value);
			$ts = Document::model()->findAll('filename = :filename', array(':filename' => $value->name));
			
			if(!isset($ts[0])){
				$t = new Document;
				$t->name = ' ';
				$t->filename = $value->name;
				$t->delete_url = $value->delete_url;
				$t->admin = 0;
				$t->designer = 0;
				$t->manager = 0;
				$t->disabled = 0;
				$t->save();
				$result[] = $t;
			}else{
				$ts[0]->delete_url = $value->delete_url;
				$result[] = $ts[0];
			}
			
		}

		$this->layout=false;
		// send data to the browser
		$grid->renderJSON($result);
		Yii::app()->end();
	}

	public function actionJsonupdate() {
		$id = $_POST['id'];
		$colname = $_POST['colname'];
		$newvalue = $_POST['newvalue'];

		$model = $this->loadModel($id, 'Document');
		$model->$colname=$newvalue;
		$model->save();
		echo('ok');
		Yii::app()->end();
	}
}
