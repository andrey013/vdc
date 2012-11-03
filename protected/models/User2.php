<?php

Yii::import('application.models._base.BaseUser');

class User2 extends BaseUser
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return parent::relations() + array(
			'authAssignment' => array(self::HAS_ONE, 'AuthAssignment', 'userid'),
		);
	}

	public function getJsonprojects()
	{
		$criteria1=new CDbCriteria();
		$criteria1->order = 'DATE(t.create_date) DESC, priority.sort_order, orderStatus.sort_order';
		$criteria1->condition = 'orderStatusHist.order_status_id!=\'8\' and designer_id=:id';
		$criteria1->params=array(':id'=>$this->id);
		$res = Order::model()
				->with('orderStatusHist', 'orderStatusHist.orderStatus', 'client', 'orderType', 'customer', 'priority', 'designer', 'designer.profile', 'payments')
				->findAll($criteria1);
		$result = array();
		foreach ($res as $key => $value) {
			$result[] = array(
				'customerName' => $value->customerName,
				'order_type' => $value->orderType->name,
				'priority' => $value->priority->name,
				'status' => $value->orderStatusHist->orderStatus->key,
				);
		}
		return json_encode($result);
	}

	public function getHighpriorityjsonprojects()
	{
		$criteria1=new CDbCriteria();
		$criteria1->order = 'DATE(t.create_date) DESC, priority.sort_order, orderStatus.sort_order';
		$criteria1->condition = 'orderStatusHist.order_status_id!=\'8\' and designer_id=:id and priority.code=1';
		$criteria1->params=array(':id'=>$this->id);
		$res = Order::model()
				->with('orderStatusHist', 'orderStatusHist.orderStatus', 'client', 'orderType', 'customer', 'priority', 'designer', 'designer.profile', 'payments')
				->findAll($criteria1);
		$result = array();
		foreach ($res as $key => $value) {
			$result[] = array(
				'customerName' => $value->customerName,
				'order_type' => $value->orderType->name,
				'priority' => $value->priority->name,
				'status' => $value->orderStatusHist->orderStatus->key,
				);
		}
		return json_encode($result);
	}

	public function getEmptypassword()
	{
		return '';
	}

	public function getRole()
	{
		return $this->authAssignment->itemname0->description;
	}

	public function getRole_id()
	{
		return $this->authAssignment->itemname;
	}

	public function getLastname()
	{
		return $this->profile->lastname;
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