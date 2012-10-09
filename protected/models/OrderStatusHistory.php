<?php

Yii::import('application.models._base.BaseOrderStatusHistory');

class OrderStatusHistory extends BaseOrderStatusHistory
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function getStatusFormatted()
	{
		return $this->orderStatus->name.' '.Yii::app()->dateFormatter->format('d.MM.yyyy', $this->change_date);
	}

	public function getKey()
	{
		return $this->orderStatus->key;
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