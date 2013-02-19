<?php

namespace Litmus;

class Database_Connection extends \PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection
{
	protected $_connection;

	public function __construct(\Fuel\Core\Database_Connection $connection)
	{
		$this->_connection = $connection;

		$pdo = $connection->connection();
		if ( ! $pdo instanceof \PDO ) 
			throw new Exception("Litmus is only compatible with PDO connection types");

		$pdo->exec('set foreign_key_checks=0');
		parent::__construct($pdo);
	}

	public function create_query_table($table, $select_query)
	{
		if ( $select_query instanceof \Fuel\Core\Database_Query_Builder_Select )
		{
			$select_query = $select_query->compile($this->_connection);
		}
		return $this->createQueryTable($table, $select_query);
	}

	public function create_query_dataset()
	{
		$dataset = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this);
		foreach (func_get_args() as $args) {
			if ( $args[1] instanceof \Fuel\Core\Database_Query_Builder_Select )
			{
				$args[1] = $args[1]->compile($this->_connection);
			}

			$dataset->addTable($args[0], $args[1]);
		}
		return $dataset;
	}
}