<?php

Yii::import('application.models._base.BaseOrderStatusHistory');

class OrderStatusHistory extends BaseOrderStatusHistory
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}