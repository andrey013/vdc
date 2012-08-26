<?php

Yii::import('application.models._base.BasePriority');

class Priority extends BasePriority
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}