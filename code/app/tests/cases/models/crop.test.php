<?php
/* Crop Test cases generated on: 2011-05-09 21:05:59 : 1304976599*/
App::import('Model', 'Crop');

class CropTestCase extends CakeTestCase {
	var $fixtures = array('app.crop');

	function startTest() {
		$this->Crop =& ClassRegistry::init('Crop');
	}

	function endTest() {
		unset($this->Crop);
		ClassRegistry::flush();
	}

}
?>