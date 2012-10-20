<?php

Yii::import('application.models._base.BaseOrder');

class Order extends BaseOrder
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public $clientPrice;
	public $designerPrice;

	public function relations() {
		return parent::relations() + array(
			'maxDate' => array(self::HAS_ONE, 'OrderStatusHistory', 'order_id', 'select'=>'MAX(vdc_order_status_history.change_date) as maxDate'),
			'orderStatus' => array(self::HAS_ONE, 'OrderStatusHistory', 'order_id'),
				//'condition'=>'orderStatus.change_date = maxDate'),
			'client_price' => array(self::STAT, 'Payment', 'order_id', 'select' => 'SUM(client_price)'),
			'designer_price' => array(self::STAT, 'Payment', 'order_id', 'select' => 'SUM(designer_price)'),
			'penny' => array(self::STAT, 'Payment', 'order_id', 'select' => 'SUM(client_price) - SUM(designer_price)'),

		);
	}

	public function setPayment($client, $designer)
	{
		$payment = new Payment;
		$payment->order_id = $this->id;
		$payment->create_date = time();
		$payment->client_price = $client;
		$payment->designer_price = $designer;
		$payment->debt = true;
		$payment->save();
	}

	public function setOrderStatus($key)
	{
		$orderStatus = OrderStatus::model()->find('`key`=:key', array(':key'=>$key));
		if(!is_null($orderStatus)){
			$orderStatusHistory = new OrderStatusHistory();
			$orderStatusHistory->order_id = $this->id;
			$orderStatusHistory->change_date = time();
			$orderStatusHistory->order_status_id = $orderStatus->id;
			$orderStatusHistory->save();
		}
	}

	public function getCustomerName()
	{
		$customer = $this->customer;
		if(is_null($customer)){
			return '';
		}else{
			return $customer->name;
		}
	}

	public function setCustomerName($name)
	{
		Yii::log('setCustomerName', 'info');
		$customer = Customer::model()->find('name=:name', array(':name'=>$name));
		if(is_null($customer)){
			Yii::log('create CustomerName', 'info');
			$customer = new Customer();
			$customer->name = $name;
			$customer->save();
		}
		$this->customer = $customer;
		$this->customer_id = $customer->id;
	}

	public function getChromaticityName()
	{
		$chromaticity = $this->chromaticity;
		if(is_null($chromaticity)){
			return '';
		}else{
			return $chromaticity->name;
		}
	}

	public function setChromaticityName($name)
	{
		$chromaticity = Chromaticity::model()->find('name=:name', array(':name'=>$name));
		if(is_null($chromaticity)){
			$chromaticity = new Chromaticity();
			$chromaticity->name = $name;
			$chromaticity->save();
		}
		$this->chromaticity = $chromaticity;
		$this->chromaticity_id = $chromaticity->id;
	}

	public function getDensityName()
	{
		$density = $this->density;
		if(is_null($density)){
			return '';
		}else{
			return $density->name;
		}
	}

	public function setDensityName($name)
	{
		$density = Density::model()->find('name=:name', array(':name'=>$name));
		if(is_null($density)){
			$density = new Density();
			$density->name = $name;
			$density->save();
		}
		$this->density = $density;
		$this->density_id = $density->id;
	}

	public function getCreateDateFormatted()
	{
		return Yii::app()->dateFormatter->format('d.MM.yyyy', $this->create_date);
	}

	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			foreach($this->metadata->tableSchema->columns as $columnName => $column)
			{
				if ($column->dbType == 'date' || $column->dbType == 'datetime')
				{
					$this->$columnName = date('Y-m-d H:i:s', $this->$columnName);
				}
			}
			return true;
		}
		else
			return false;
	}

	protected function afterFind()
	{
		foreach($this->metadata->tableSchema->columns as $columnName => $column)
		{           
			if (!strlen($this->$columnName)) continue;
	
			if ($column->dbType == 'date' || $column->dbType == 'datetime')
			{
				$this->$columnName = CDateTimeParser::parse(
							$this->$columnName, 
							'yyyy-MM-dd hh:mm:ss'
						);
			}
		}
		return true;
	}
}