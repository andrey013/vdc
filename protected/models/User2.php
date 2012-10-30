<?php

Yii::import('application.models._base.BaseUser');

class User2 extends BaseUser
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return parent::relations() + array(
			'authAssignment' => array(self::HAS_ONE, 'AuthAssignment', 'userid')

		);
	}

	public function getRole()
	{
		return $this->authAssignment->itemname0->description;
	}

	public function getLastname()
	{
		return $this->profile->lastname;
	}
}