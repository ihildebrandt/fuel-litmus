<?php 

namespace Litmus;

abstract class Database_TestCase extends \PHPUnit_Extensions_Database_TestCase
{
	protected static $_connection = null;

	protected static $_module = null;

	protected static $_config = null;

	protected static $_setup = null;

	protected static function config()
	{
		if ( static::$_config === null ) {
			$class = explode('\\', get_called_class());
			$class = strtolower(array_pop($class));
			if ( \Str::starts_with($class, 'test_') ) {
				$class = \Str::sub($class, 5);
			}
			static::$_config = $class;
		}

		return static::$_config;
	}

	public function getConnection()
	{
		$connection = \Database_Connection::instance(static::$_connection)
			->connection();

		if ( ! $connection instanceof \PDO ) 
			throw new Exception("Litmus is only compatible with PDO connection types");

		$connection->exec('set foreign_key_checks=0');

		return $this->createDefaultDBConnection($connection);
	}

	public function createConfigDataSet($config, $module = null)
	{
		$file = 'litmus';
		$module and $file = $module.'::'.$file;

		\Config::load($file, true);

		return new ArrayDataSet(\Config::get($file.'.'.$config));
	}

	public function getDataSet()
	{
		$config = static::config().'.setup';
		return $this->createConfigDataSet($config, static::$_module);
	}
}