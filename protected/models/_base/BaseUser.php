<?php

/**
 * This is the model base class for the table "vdc_user".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "User".
 *
 * Columns in table "vdc_user" available as properties of the model,
 * followed by relations of table "vdc_user" available as properties of the model.
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $activkey
 * @property string $create_at
 * @property string $lastvisit_at
 * @property integer $superuser
 * @property integer $status
 *
 * @property AuthAssignment[] $authAssignments
 * @property Order[] $orders
 * @property Order[] $orders1
 * @property Profile $profile
 */
abstract class BaseUser extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'vdc_user';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'User|Users', $n);
	}

	public static function representingColumn() {
		return 'username';
	}

	public function rules() {
		return array(
			array('username, password, email, create_at', 'required'),
			array('superuser, status', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>20),
			array('password, email, activkey', 'length', 'max'=>128),
			array('lastvisit_at', 'safe'),
			array('activkey, lastvisit_at, superuser, status', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, username, password, email, activkey, create_at, lastvisit_at, superuser, status', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'authAssignments' => array(self::HAS_MANY, 'AuthAssignment', 'userid'),
			'orders' => array(self::HAS_MANY, 'Order', 'manager_id'),
			'orders1' => array(self::HAS_MANY, 'Order', 'designer_id'),
			'profile' => array(self::HAS_ONE, 'Profile', 'user_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'username' => Yii::t('app', 'Username'),
			'password' => Yii::t('app', 'Password'),
			'email' => Yii::t('app', 'Email'),
			'activkey' => Yii::t('app', 'Activkey'),
			'create_at' => Yii::t('app', 'Create At'),
			'lastvisit_at' => Yii::t('app', 'Lastvisit At'),
			'superuser' => Yii::t('app', 'Superuser'),
			'status' => Yii::t('app', 'Status'),
			'authAssignments' => null,
			'orders' => null,
			'orders1' => null,
			'profile' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('username', $this->username, true);
		$criteria->compare('password', $this->password, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('activkey', $this->activkey, true);
		$criteria->compare('create_at', $this->create_at, true);
		$criteria->compare('lastvisit_at', $this->lastvisit_at, true);
		$criteria->compare('superuser', $this->superuser);
		$criteria->compare('status', $this->status);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}