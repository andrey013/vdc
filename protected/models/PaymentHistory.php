<?php

Yii::import('application.models._base.BasePaymentHistory');

class PaymentHistory extends BasePaymentHistory
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}