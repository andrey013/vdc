<?php

Yii::import('application.models._base.BaseManager');

class Manager extends BaseManager
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}