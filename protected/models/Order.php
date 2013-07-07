<?php

Yii::import('application.models._base.BaseOrder');

class Order extends BaseOrder
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public $clientPrice;
	public $designerPrice;
	public $debtPrice;

        public $pay;
        public $dateformatted;

	public function relations() {
		return parent::relations() + array(
			//'maxDate' => array(self::HAS_ONE, 'OrderStatusHistory', 'order_id', 'select'=>'MAX(vdc_order_status_history.change_date) as maxDate'),
			'orderStatusHist' => array(self::HAS_ONE, 'OrderStatusHistory', 'order_id',
				'condition'=>'orderStatusHist.change_date in (select MAX(change_date) from vdc_order_status_history group by order_id)'),
			'client_price' => array(self::STAT, 'Payment', 'order_id', 'select' => 'SUM(client_price)'),
			'designer_price' => array(self::STAT, 'Payment', 'order_id', 'select' => 'SUM(designer_price)'),
			'penny' => array(self::STAT, 'Payment', 'order_id', 'select' => 'SUM(client_price) - SUM(designer_price)'),

		);
	}

	public function getPaid()
	{
		$rows = $this->payments;
		foreach ($rows as $row) {
			if($row->debt == 1) return 0;
		}
		return 1;//print_r($this->getRelated("payments"));
	}

	public function getPaidSum()
	{
		$rows = $this->payments;
		$sum = 0;
		foreach ($rows as $row) {
			if($row->debt == 1) $sum += $row->paid;
		}
		return $sum;//print_r($this->getRelated("payments"));
	}

	public function getDebt()
	{
		if($this->paid==1) return 0;
		return $this->client_price - $this->paidSum;
	}

	public function setPaid($name)
	{
		
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
                $cache=Yii::app()->cache;
		$orderStatus = OrderStatus::model()->find('`key`=:key', array(':key'=>$key));
		if(!is_null($orderStatus)){
			$orderStatusHistory = new OrderStatusHistory();
			$orderStatusHistory->order_id = $this->id;
			$orderStatusHistory->change_date = time();
			$orderStatusHistory->order_status_id = $orderStatus->id;
			$orderStatusHistory->save();
                        $cache->delete('orderStatus'.$this->id);
                        $orderStatusHistory->getRelated('orderStatus');
                        $cache['orderStatus'.$this->id]=$orderStatusHistory;
		}
	}

        public function getOrderStatus()
	{
                $cache=Yii::app()->cache;
                $orderStatus=$cache['orderStatus'.$this->id];
                if($orderStatus===false){
                        $orderStatus = $this->orderStatusHist;
                        $orderStatus->getRelated('orderStatus');
                        $cache['orderStatus'.$this->id]=$orderStatus;
                }
                return $orderStatus;
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
		return Yii::app()->dateFormatter->format('d.MM.yyyy HH:mm:ss', $this->create_date);
	}

	public function getFilter(){
		$result = new stdClass();
		$result->order_type = $this->order_type_id;
		$result->manager = $this->manager_id;
		$result->designer = $this->designer_id;
		$result->order_status = $this->orderStatus->orderStatus->key;
		$result->client = $this->client_id;
		$result->pay_type = $this->pay_type;
		$result->client_paid = $this->client_paid;
		$result->designer_paid = $this->designer_paid;
		$result->changed = count($this->payments)<=1?0:1;
		$result->filter = ''.$this->customer->name.' '
							.$this->orderType->name.' '
							.$this->comment.' '
							.$this->client->name.' '
							.$this->manager->username.' ';
		return json_encode($result);
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

public static function mergesort(&$array, $cmp_function = 'strcmp') {
    // Arrays of size < 2 require no action.
    if (count($array) < 2) return $array;
    // Split the array in half
    $halfway = count($array) / 2;
    $array1 = array_slice($array, 0, $halfway);
    $array2 = array_slice($array, $halfway);
    // Recurse to sort the two halves
    Order::mergesort($array1, $cmp_function);
    Order::mergesort($array2, $cmp_function);
    // If all of $array1 is <= all of $array2, just append them.
    if (call_user_func($cmp_function, end($array1), $array2[0]) < 1) {
        $array = array_merge($array1, $array2);
        return $array;
    }
    // Merge the two sorted arrays into a single sorted array
    $array = array();
    $ptr1 = $ptr2 = 0;
    while ($ptr1 < count($array1) && $ptr2 < count($array2)) {
        if (call_user_func($cmp_function, $array1[$ptr1], $array2[$ptr2]) < 1) {
            $array[] = $array1[$ptr1++];
        }
        else {
            $array[] = $array2[$ptr2++];
        }
    }
    // Merge the remainder
    while ($ptr1 < count($array1)) $array[] = $array1[$ptr1++];
    while ($ptr2 < count($array2)) $array[] = $array2[$ptr2++];
    return $array;
}

public static function cmp($a, $b)
{

    //$order = 'create_date, priority.sort_order DESC, orderStatus.sort_order DESC, global_number';

    $ad = $a->orderStatus->order_status_id;
    $bd = $b->orderStatus->order_status_id;
    if (($ad == 8 && $bd == 8) || ($ad != 8 && $bd != 8)){
        // floor to the midnight
        $ad = $a->create_date - ($a->create_date % 86400);
        $bd = $b->create_date - ($b->create_date % 86400);
        if ($ad == $bd ) {
            if ($a->priority->sort_order == $b->priority->sort_order){
                if ($a->orderStatus->orderStatus->sort_order == $b->orderStatus->orderStatus->sort_order){
                    if ($a->global_number == $b->global_number){
                        return 0;
                    } else {
                        return ($a->global_number > $b->global_number) ? -1 : 1;
                    }
                } else {
                    return ($a->orderStatus->orderStatus->sort_order < $b->orderStatus->orderStatus->sort_order) ? -1 : 1;
                }
            } else {
                return ($a->priority->sort_order < $b->priority->sort_order) ? -1 : 1;
            }
        } else {
            return ($ad > $bd) ? -1 : 1;
        }
    } else {
        return ($bd == 8) ? -1 : 1;
    }
}


}
