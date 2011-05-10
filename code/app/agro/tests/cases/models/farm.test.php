<?php
/* Farm Test cases generated on: 2011-05-09 19:05:41 : 1304982461*/
App::import('Model', 'Farm');

class FarmTestCase extends CakeTestCase {
	var $fixtures = array('app.farm');

	function startTest() {
		$this->Farm =& ClassRegistry::init('Farm');
	}

	function endTest() {
		unset($this->Farm);
		ClassRegistry::flush();
	}

}
?>