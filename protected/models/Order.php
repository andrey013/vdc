<?php

Yii::import('application.models._base.BaseOrder');

class Order extends BaseOrder
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
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

	public function getDensityName()
	{
		$density = $this->density;
		if(is_null($density)){
			return '';
		}else{
			return $density->name;
		}
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