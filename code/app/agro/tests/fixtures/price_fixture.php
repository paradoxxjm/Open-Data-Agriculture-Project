<?php
/* Price Fixture generated on: 2011-05-09 19:05:54 : 1304982534 */
class PriceFixture extends CakeTestFixture {
	var $name = 'Price';

	var $fields = array(
		'Parish' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 12),
		'CropType' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 21),
		'LowerPrice' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '5,2'),
		'UpperPrice' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '5,2'),
		'FreqPrice' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '5,2'),
		'SupplyStatus' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 8),
		'Quality' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 7),
		'Price_Month' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'Xcoord' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '11,8'),
		'Ycoord' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '11,9'),
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'Parish' => 'Lorem ipsu',
			'CropType' => 'Lorem ipsum dolor s',
			'LowerPrice' => 1,
			'UpperPrice' => 1,
			'FreqPrice' => 1,
			'SupplyStatus' => 'Lorem ',
			'Quality' => 'Lorem',
			'Price_Month' => '2011-05-09',
			'Xcoord' => 1,
			'Ycoord' => 1,
			'id' => 1
		),
	);
}
?>