<?php

Yii::import('application.models._base.BasePrice');

class Price extends BasePrice
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}