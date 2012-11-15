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

	/**
	* Возвращает следующего дизайнера (автоматический выбор)
	*/
	public static function getNext()
	{
		$designers=User2::model()->with(array(
				'authAssignments'=>array(
					// we don't want to select posts
					'select'=>false,
					// but want to get only users with published posts
					'joinType'=>'INNER JOIN',
					'condition'=>'authAssignments.itemname=\'Designer\'',
				),
			),
			'profile'
		)->findAll(array('order'=>'username', 'condition'=>'disabled=0'));
		$variables = Variables::model()->find();
		$prev_designer_id = $variables->prev_designer_id;
		$found = false;
		foreach ($designers as $key => $value) {
			if($found && $value->profile->user_status_id==1) {
				return $value;
			}
			if($value->id == $prev_designer_id) {
				$found = true;
			}
		}
		foreach ($designers as $key => $value) {
			if($value->profile->user_status_id==1) {
				return $value;
			}
		}
		return null;
	}

	public function getIsnext()
	{
		$next = $this->next;
		if(!is_null($next) && $this->id == $next->id) return true;
		return false;
	}

	public function getJsonprojects()
	{
		$criteria1=new CDbCriteria();
		$criteria1->order = 'DATE(t.create_date) DESC, priority.sort_order, orderStatus.sort_order';
		$criteria1->condition = 'orderStatusHist.order_status_id!=\'8\' and designer_id=:id and t.disabled=0';
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
		$criteria1->condition = 'orderStatusHist.order_status_id!=\'8\' and designer_id=:id and priority.code=1 and t.disabled=0';
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