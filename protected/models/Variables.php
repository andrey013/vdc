<?php

Yii::import('application.models._base.BaseVariables');

class Variables extends BaseVariables
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}