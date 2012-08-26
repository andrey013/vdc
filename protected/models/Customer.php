<?php

Yii::import('application.models._base.BaseCustomer');

class Customer extends BaseCustomer
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}