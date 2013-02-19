<?php

Autoloader::add_classes(array(
	'Litmus\\Database_TestCase' => dirname(__FILE__).'/classes/database/testcase.php',
	'Litmus\\Database_Connection' => dirname(__FILE__).'/classes/database/connection.php',
	'Litmus\\ArrayDataSet' => dirname(__FILE__).'/classes/arraydataset.php'
));