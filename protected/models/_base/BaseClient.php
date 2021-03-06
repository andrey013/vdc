<?php

/**
 * This is the model base class for the table "vdc_client".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Client".
 *
 * Columns in table "vdc_client" available as properties of the model,
 * followed by relations of table "vdc_client" available as properties of the model.
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $disabled
 *
 * @property Order[] $orders
 * @property Profile[] $profiles
 */
abstract class BaseClient extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'vdc_client';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Client|Clients', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name, code', 'required'),
			array('disabled', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('code', 'length', 'max'=>30),
			array('disabled', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name, code, disabled', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'orders' => array(self::HAS_MANY, 'Order', 'client_id'),
			'profiles' => array(self::HAS_MANY, 'Profile', 'client_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'name' => Yii::t('app', 'Name'),
			'code' => Yii::t('app', 'Code'),
			'disabled' => Yii::t('app', 'Disabled'),
			'orders' => null,
			'profiles' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('code', $this->code, true);
		$criteria->compare('disabled', $this->disabled);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}