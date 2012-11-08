<?php

Yii::import('application.models._base.BaseDocument');

class Document extends BaseDocument
{

	public $url;
	public $delete_url;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}