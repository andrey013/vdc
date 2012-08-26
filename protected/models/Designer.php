<?php

Yii::import('application.models._base.BaseDesigner');

class Designer extends BaseDesigner
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}