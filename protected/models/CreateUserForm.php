<?php
/**
 * 
 */
class CreateUserForm extends CFormModel {
	public $type;
	public $email;
	public $password;
	public $lastname;
	public $client_id;
	
	public function rules() {
		return array(
			array('password, lastname, email, type, client_id', 'required'),
			array('password', 'length', 'max'=>128, 'min' => 3, 'message' => "Минимальная длина пароля - 3 символа."),
			array('lastname', 'length', 'max'=>128, 'min' => 3, 'message' => "Минимальная длина имени - 3 символа."),
			array('email', 'email'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
		);
	}
	
	
}