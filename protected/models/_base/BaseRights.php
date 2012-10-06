<?php

/**
 * This is the model base class for the table "vdc_Rights".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Rights".
 *
 * Columns in table "vdc_Rights" available as properties of the model,
 * followed by relations of table "vdc_Rights" available as properties of the model.
 *
 * @property string $itemname
 * @property integer $type
 * @property integer $weight
 *
 * @property AuthItem $itemname0
 */
abstract class BaseRights extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'vdc_Rights';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Rights|Rights', $n);
	}

	public static function representingColumn() {
		return 'itemname';
	}

	public function rules() {
		return array(
			array('itemname, type, weight', 'required'),
			array('type, weight', 'numerical', 'integerOnly'=>true),
			array('itemname', 'length', 'max'=>64),
			array('itemname, type, weight', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'itemname0' => array(self::BELONGS_TO, 'AuthItem', 'itemname'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'itemname' => null,
			'type' => Yii::t('app', 'Type'),
			'weight' => Yii::t('app', 'Weight'),
			'itemname0' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('itemname', $this->itemname);
		$criteria->compare('type', $this->type);
		$criteria->compare('weight', $this->weight);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}