<?php

class PriceController extends GxController {

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
		$this->render('list');
	}

	public function actionJsonlist() {
		
		$order_types = OrderType::model()->findAll('disabled=0');

		$difficulties = Difficulty::model()->findAll('disabled=0');

		// create a new EditableGrid object
		$grid = new EditableGrid();

		//$grid->addColumn('id', 'ID', 'integer', NULL, false);
		$grid->addColumn('name', 'Вид заказа', 'html', NULL, false);
		//$grid->addColumn('purpose', ' ', 'html', NULL, false);
		//$grid->addColumn('d', 'Сложность', 'html', NULL, false);
		foreach ($difficulties as $key => $value) {
			$grid->addColumn('@price|'.$value->id, $value->name, 'double(,0,comma,&nbsp;,)', NULL, true);
		}

		//$result = $order_types;
		$result = array();
		foreach ($order_types as $value) {
			$res = new OrderType();
			$res->id = $value->id.'|'.'0';
			$res->name = $value->name;
			$res->purpose = 'клиенту';
			
			foreach ($difficulties as $diff) {
				$price = Price::model()->findAll('order_type_id=:otid and difficulty_id=:did',
					array(':otid'=>$value->id, ':did'=>$diff->id));
				if(isset($price[0])){
					$res->price[$diff->id] = $price[0]->client_price;
				}else{
					$res->price[$diff->id] = 0;
				}
			}
			//error_log(print_r($res->price, true));
			$result[] = $res;

			$res = new OrderType();
			$res->id = $value->id.'|'.'1';
			//$res->name = $value->name;
			$res->purpose = 'дизайнеру';
			foreach ($difficulties as $diff) {
				$price = Price::model()->findAll('order_type_id=:otid and difficulty_id=:did',
					array(':otid'=>$value->id, ':did'=>$diff->id));
				if(isset($price[0])){
					$res->price[$diff->id] = $price[0]->designer_price;
				}else{
					$res->price[$diff->id] = 0;
				}
			}
			$result[] = $res;
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
		$difficulty_id = explode('|', substr($colname, 1, 10))[1];
		$order_type_id = explode('|', $id)[0];
		$is_designer_price = explode('|', $id)[1];
		if($is_designer_price=='1'){
			$price = Price::model()->findAll('order_type_id=:otid and difficulty_id=:did',
				array(':otid'=>$order_type_id, ':did'=>$difficulty_id));
			if(isset($price[0])){
				$price[0]->designer_price = $newvalue;
				$price[0]->save();
			}else{
				$newPrice = new Price;
				$newPrice->order_type_id = $order_type_id;
				$newPrice->difficulty_id = $difficulty_id;
				$newPrice->designer_price = $newvalue;
				$newPrice->client_price = 0;
				$newPrice->save();
			}
		}else{
			$price = Price::model()->findAll('order_type_id=:otid and difficulty_id=:did',
				array(':otid'=>$order_type_id, ':did'=>$difficulty_id));
			if(isset($price[0])){
				$price[0]->client_price = $newvalue;
				$price[0]->save();
			}else{
				$newPrice = new Price;
				$newPrice->order_type_id = $order_type_id;
				$newPrice->difficulty_id = $difficulty_id;
				$newPrice->designer_price = 0;
				$newPrice->client_price = $newvalue;
				$newPrice->save();
			}
		}
		echo('ok');
		Yii::app()->end();
	}
}
