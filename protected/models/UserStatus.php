<?php

Yii::import('application.models._base.BaseUserStatus');

class UserStatus extends BaseUserStatus
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}