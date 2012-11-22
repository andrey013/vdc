<?php

/**
 * This is the model base class for the table "vdc_order_status".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "OrderStatus".
 *
 * Columns in table "vdc_order_status" available as properties of the model,
 * followed by relations of table "vdc_order_status" available as properties of the model.
 *
 * @property integer $id
 * @property string $name
 * @property string $key
 * @property string $color
 * @property integer $sort_order
 *
 * @property OrderStatusHistory[] $orderStatusHistories
 */
abstract class BaseOrderStatus extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'vdc_order_status';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'OrderStatus|OrderStatuses', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name, key, sort_order', 'required'),
			array('sort_order', 'numerical', 'integerOnly'=>true),
			array('name, key, color', 'length', 'max'=>30),
			array('color', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name, key, color, sort_order', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'orderStatusHistories' => array(self::HAS_MANY, 'OrderStatusHistory', 'order_status_id'),
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
			'key' => Yii::t('app', 'Key'),
			'color' => Yii::t('app', 'Color'),
			'sort_order' => Yii::t('app', 'Sort Order'),
			'orderStatusHistories' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('key', $this->key, true);
		$criteria->compare('color', $this->color, true);
		$criteria->compare('sort_order', $this->sort_order);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}