<?php

Yii::import('application.models._base.BaseOrderType');

class OrderType extends BaseOrderType
{
	public $price = array();
	public $purpose;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function getPrice()
	{
		return $price;
	}
}