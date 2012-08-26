<?php

/**
 * This is the model base class for the table "vdc_measure_unit".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "MeasureUnit".
 *
 * Columns in table "vdc_measure_unit" available as properties of the model,
 * followed by relations of table "vdc_measure_unit" available as properties of the model.
 *
 * @property integer $id
 * @property string $name
 * @property integer $sort_order
 *
 * @property Order[] $orders
 */
abstract class BaseMeasureUnit extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'vdc_measure_unit';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'MeasureUnit|MeasureUnits', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name, sort_order', 'required'),
			array('sort_order', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>30),
			array('id, name, sort_order', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'orders' => array(self::HAS_MANY, 'Order', 'measure_unit_id'),
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
			'sort_order' => Yii::t('app', 'Sort Order'),
			'orders' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('sort_order', $this->sort_order);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}