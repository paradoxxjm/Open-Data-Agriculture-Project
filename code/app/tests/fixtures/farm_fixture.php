<?php
/* Farm Fixture generated on: 2011-05-09 21:05:17 : 1304976617 */
class FarmFixture extends CakeTestFixture {
	var $name = 'Farm';

	var $fields = array(
		'FarmerID' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'key' => 'index'),
		'Property_ID' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 7),
		'Parish' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 12),
		'Extension' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 15),
		'District' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 23),
		'Farmersize' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 9),
		'PropertySize' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '6,4'),
		'Xcoord' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '11,8'),
		'Ycoord' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '11,9'),
		'FIrstnameX' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 25),
		'LastnameX' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 21),
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'FarmerID' => array('column' => array('FarmerID', 'Property_ID', 'Parish', 'Extension', 'District', 'Farmersize', 'PropertySize', 'Xcoord', 'Ycoord', 'FIrstnameX', 'LastnameX'), 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'FarmerID' => 1,
			'Property_ID' => 1,
			'Parish' => 'Lorem ipsu',
			'Extension' => 'Lorem ipsum d',
			'District' => 'Lorem ipsum dolor sit',
			'Farmersize' => 'Lorem i',
			'PropertySize' => 1,
			'Xcoord' => 1,
			'Ycoord' => 1,
			'FIrstnameX' => 'Lorem ipsum dolor sit a',
			'LastnameX' => 'Lorem ipsum dolor s',
			'id' => 1
		),
	);
}
?>