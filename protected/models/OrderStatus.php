<?php

Yii::import('application.models._base.BaseOrderStatus');

class OrderStatus extends BaseOrderStatus
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}