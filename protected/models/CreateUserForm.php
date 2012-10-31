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
			array('password', 'length', 'max'=>128, 'min' => 6,'message' => "Incorrect password (minimal length 6 symbols)."),
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