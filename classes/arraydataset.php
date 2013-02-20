<?php

namespace Litmus;

class ArrayDataSet extends \PHPUnit_Extensions_Database_DataSet_AbstractDataSet
{
	protected $tables = array();

	public function __construct(array $data = null)
	{
		$data or $data = array();
		
		foreach ($data as $table_name => $rows) 
		{
			$cols = array();
			isset($rows[0]) and $cols = array_keys($rows[0]);

			$meta = new \PHPUnit_Extensions_Database_DataSet_DefaultTableMetaData($table_name, $cols);
			$table = new \PHPUnit_Extensions_Database_DataSet_DefaultTable($meta);

			foreach ($rows as $row)
			{
				$table->addRow($row);
			}

			$this->tables[$table_name] = $table;
		}
	}

	protected function createIterator($reverse = false)
	{
		return new \PHPUnit_Extensions_Database_DataSet_DefaultTableIterator($this->tables, $reverse);
	}

	public function getTable($table)
	{
		if (!isset($this->tables[$table]))
			throw new \InvalidArgumentException("$table is not a table in the current database");

		return $this->tables[$table];
	}
}