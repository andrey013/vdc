<?php

Yii::import('application.models._base.BaseOrder');

class Order extends BaseOrder
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function getCustomerName()
	{
		$customer = $this->customer;
		if(is_null($customer)){
			return '';
		}else{
			return $customer->name;
		}
	}
}