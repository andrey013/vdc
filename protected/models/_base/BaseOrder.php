<?php

/**
 * This is the model base class for the table "vdc_order".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Order".
 *
 * Columns in table "vdc_order" available as properties of the model,
 * followed by relations of table "vdc_order" available as properties of the model.
 *
 * @property integer $id
 * @property string $create_date
 * @property integer $global_number
 * @property string $client_number
 * @property integer $client_id
 * @property integer $manager_id
 * @property integer $designer_id
 * @property integer $customer_id
 * @property integer $order_type_id
 * @property integer $difficulty_id
 * @property integer $priority_id
 * @property string $comment
 * @property integer $chromaticity_id
 * @property integer $density_id
 * @property integer $size_x
 * @property integer $size_y
 * @property integer $measure_unit_id
 * @property string $text
 * @property integer $designer_paid
 * @property integer $disabled
 *
 * @property Comment[] $comments
 * @property MeasureUnit $measureUnit
 * @property Client $client
 * @property User $manager
 * @property User $designer
 * @property Customer $customer
 * @property OrderType $orderType
 * @property Difficulty $difficulty
 * @property Priority $priority
 * @property Chromaticity $chromaticity
 * @property Density $density
 * @property OrderStatusHistory[] $orderStatusHistories
 * @property Payment[] $payments
 */
abstract class BaseOrder extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'vdc_order';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Order|Orders', $n);
	}

	public static function representingColumn() {
		return 'create_date';
	}

	public function rules() {
		return array(
			array('create_date, global_number, client_number, client_id, manager_id, designer_id, customer_id, order_type_id, difficulty_id, priority_id', 'required'),
			array('global_number, client_id, manager_id, designer_id, customer_id, order_type_id, difficulty_id, priority_id, chromaticity_id, density_id, size_x, size_y, measure_unit_id, designer_paid, disabled', 'numerical', 'integerOnly'=>true),
			array('client_number', 'length', 'max'=>20),
			array('comment', 'length', 'max'=>200),
			array('text', 'safe'),
			array('comment, chromaticity_id, density_id, size_x, size_y, measure_unit_id, text, designer_paid, disabled', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, create_date, global_number, client_number, client_id, manager_id, designer_id, customer_id, order_type_id, difficulty_id, priority_id, comment, chromaticity_id, density_id, size_x, size_y, measure_unit_id, text, designer_paid, disabled', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'comments' => array(self::HAS_MANY, 'Comment', 'order_id'),
			'measureUnit' => array(self::BELONGS_TO, 'MeasureUnit', 'measure_unit_id'),
			'client' => array(self::BELONGS_TO, 'Client', 'client_id'),
			'manager' => array(self::BELONGS_TO, 'User', 'manager_id'),
			'designer' => array(self::BELONGS_TO, 'User', 'designer_id'),
			'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
			'orderType' => array(self::BELONGS_TO, 'OrderType', 'order_type_id'),
			'difficulty' => array(self::BELONGS_TO, 'Difficulty', 'difficulty_id'),
			'priority' => array(self::BELONGS_TO, 'Priority', 'priority_id'),
			'chromaticity' => array(self::BELONGS_TO, 'Chromaticity', 'chromaticity_id'),
			'density' => array(self::BELONGS_TO, 'Density', 'density_id'),
			'orderStatusHistories' => array(self::HAS_MANY, 'OrderStatusHistory', 'order_id'),
			'payments' => array(self::HAS_MANY, 'Payment', 'order_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'create_date' => Yii::t('app', 'Create Date'),
			'global_number' => Yii::t('app', 'Global Number'),
			'client_number' => Yii::t('app', 'Client Number'),
			'client_id' => null,
			'manager_id' => null,
			'designer_id' => null,
			'customer_id' => null,
			'order_type_id' => null,
			'difficulty_id' => null,
			'priority_id' => null,
			'comment' => Yii::t('app', 'Comment'),
			'chromaticity_id' => null,
			'density_id' => null,
			'size_x' => Yii::t('app', 'Size X'),
			'size_y' => Yii::t('app', 'Size Y'),
			'measure_unit_id' => null,
			'text' => Yii::t('app', 'Text'),
			'designer_paid' => Yii::t('app', 'Designer Paid'),
			'disabled' => Yii::t('app', 'Disabled'),
			'comments' => null,
			'measureUnit' => null,
			'client' => null,
			'manager' => null,
			'designer' => null,
			'customer' => null,
			'orderType' => null,
			'difficulty' => null,
			'priority' => null,
			'chromaticity' => null,
			'density' => null,
			'orderStatusHistories' => null,
			'payments' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('create_date', $this->create_date, true);
		$criteria->compare('global_number', $this->global_number);
		$criteria->compare('client_number', $this->client_number, true);
		$criteria->compare('client_id', $this->client_id);
		$criteria->compare('manager_id', $this->manager_id);
		$criteria->compare('designer_id', $this->designer_id);
		$criteria->compare('customer_id', $this->customer_id);
		$criteria->compare('order_type_id', $this->order_type_id);
		$criteria->compare('difficulty_id', $this->difficulty_id);
		$criteria->compare('priority_id', $this->priority_id);
		$criteria->compare('comment', $this->comment, true);
		$criteria->compare('chromaticity_id', $this->chromaticity_id);
		$criteria->compare('density_id', $this->density_id);
		$criteria->compare('size_x', $this->size_x);
		$criteria->compare('size_y', $this->size_y);
		$criteria->compare('measure_unit_id', $this->measure_unit_id);
		$criteria->compare('text', $this->text, true);
		$criteria->compare('designer_paid', $this->designer_paid);
		$criteria->compare('disabled', $this->disabled);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}