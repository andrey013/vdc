<?php

/**
 * This is the model base class for the table "vdc_profile".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Profile".
 *
 * Columns in table "vdc_profile" available as properties of the model,
 * followed by relations of table "vdc_profile" available as properties of the model.
 *
 * @property integer $user_id
 * @property string $lastname
 * @property string $firstname
 * @property integer $client_id
 * @property integer $user_status_id
 *
 * @property User $user
 * @property Client $client
 * @property UserStatus $userStatus
 */
abstract class BaseProfile extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'vdc_profile';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Profile|Profiles', $n);
	}

	public static function representingColumn() {
		return 'lastname';
	}

	public function rules() {
		return array(
			array('client_id, user_status_id', 'numerical', 'integerOnly'=>true),
			array('lastname, firstname', 'length', 'max'=>50),
			array('lastname, firstname, client_id, user_status_id', 'default', 'setOnEmpty' => true, 'value' => null),
			array('user_id, lastname, firstname, client_id, user_status_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'user' => array(self::BELONGS_TO, 'User2', 'user_id'),
			'client' => array(self::BELONGS_TO, 'Client', 'client_id'),
			'userStatus' => array(self::BELONGS_TO, 'UserStatus', 'user_status_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'user_id' => null,
			'lastname' => Yii::t('app', 'Lastname'),
			'firstname' => Yii::t('app', 'Firstname'),
			'client_id' => null,
			'user_status_id' => null,
			'user' => null,
			'client' => null,
			'userStatus' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('lastname', $this->lastname, true);
		$criteria->compare('firstname', $this->firstname, true);
		$criteria->compare('client_id', $this->client_id);
		$criteria->compare('user_status_id', $this->user_status_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}