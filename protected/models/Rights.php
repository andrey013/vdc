<?php

Yii::import('application.models._base.BaseRights');

class Rights extends BaseRights
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}