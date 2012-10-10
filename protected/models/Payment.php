<?php

Yii::import('application.models._base.BasePayment');

class Payment extends BasePayment
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array_merge(parent::relations(), array(
			'paid' => array(self::STAT, 'PaymentHistory', 'payment_id', 'select' => 'SUM(amount)'),
			'paymentHistories' => array(self::HAS_MANY, 'PaymentHistory', 'payment_id', 'order' => 'create_date ASC'),
		));
	}

	public function getPaidhistory()
	{
		$history = $this->paymentHistories;
		$result = $this->paid;
		foreach ($history as $key => $value) {
			$result = $result.' '.$value->createdateformatted.' '.$value->amount;
		}
		return $result;
	}

	public function getPenny()
	{
		return $this->client_price - $this->designer_price ;
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