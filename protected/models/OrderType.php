<?php

Yii::import('application.models._base.BaseOrderType');

class OrderType extends BaseOrderType
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}