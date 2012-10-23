<?php

Yii::import('application.models._base.BaseComment');

class Comment extends BaseComment
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	function int2vancode($i = 0) {
		$num = base_convert((int) $i, 10, 36);
		$length = strlen($num);
		return chr($length + ord('0') - 1) . $num;
	}

	function vancode2int($c = '00') {
	  	return base_convert(substr($c, 1), 36, 10);
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