<?php
/* Crop Fixture generated on: 2011-05-09 21:05:52 : 1304976592 */
class CropFixture extends CakeTestFixture {
	var $name = 'Crop';

	var $fields = array(
		'Parish' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 9, 'key' => 'index'),
		'Extension' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 15),
		'District' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 21),
		'Group' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 1),
		'CropGroup' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 14),
		'CropType' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 21),
		'Property_ID' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 7),
		'FarmerID' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'PropertySize' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '6,2'),
		'CropArea' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '6,2'),
		'CropCount' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 5),
		'Crop_Date' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 8),
		'Farmsize' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 9),
		'FarmerAge' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 11),
		'Xcoord' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '11,8'),
		'Ycoord' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '11,9'),
		'firstnameX' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 25),
		'lastnameX' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 19),
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'Parish' => array('column' => array('Parish', 'Extension', 'District', 'Group', 'CropGroup', 'CropType', 'Property_ID', 'FarmerID', 'PropertySize', 'CropArea', 'CropCount', 'Crop_Date', 'Farmsize', 'FarmerAge', 'Xcoord', 'Ycoord'), 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'Parish' => 'Lorem i',
			'Extension' => 'Lorem ipsum d',
			'District' => 'Lorem ipsum dolor s',
			'Group' => 1,
			'CropGroup' => 'Lorem ipsum ',
			'CropType' => 'Lorem ipsum dolor s',
			'Property_ID' => 1,
			'FarmerID' => 1,
			'PropertySize' => 1,
			'CropArea' => 1,
			'CropCount' => 'Lor',
			'Crop_Date' => 'Lorem ',
			'Farmsize' => 'Lorem i',
			'FarmerAge' => 'Lorem ips',
			'Xcoord' => 1,
			'Ycoord' => 1,
			'firstnameX' => 'Lorem ipsum dolor sit a',
			'lastnameX' => 'Lorem ipsum dolor',
			'id' => 1
		),
	);
}
?>