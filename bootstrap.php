<?php

Autoloader::add_core_namespace('Litmus');

Autoloader::add_classes(array(
	'Litmus\\Database_TestCase' => dirname(__FILE__).'/classes/database/testcase.php',
	'Litmus\\ArrayDataSet' => dirname(__FILE__).'/classes/arraydataset.php'
));