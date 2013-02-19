<?php 

namespace Litmus;

abstract class Database_TestCase extends \PHPUnit_Extensions_Database_TestCase
{
	protected static $_connection = null;

	protected static $_module = null;

	protected static $_setup = null;

	protected static function config($set)
	{
		$class = explode('\\', get_called_class());
		$class = strtolower(array_pop($class));
		if ( \Str::starts_with($class, 'test_') ) {
			$class = \Str::sub($class, 5);
		}

		return $class.'.'.$set;
	}

	public function getConnection()
	{
		return new Database_Connection(\Database_Connection::instance(static::$_connection));
	}

	public function connection()
	{
		return $this->getConnection();
	}

	public function create_config_dataset($config, $module = null)
	{
		$file = 'litmus';

		$config = static::config($config);
		$module or $module = static::$_module;
		$module and $file = $module.'::'.$file;

		\Config::load($file, true);

		return new ArrayDataSet(\Config::get($file.'.'.$config));
	}

	public function getDataSet()
	{
		return $this->create_config_dataset('setup', static::$_module);
	}
}