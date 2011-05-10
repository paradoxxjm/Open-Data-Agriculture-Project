<?php
/* Farm Test cases generated on: 2011-05-09 21:05:18 : 1304976618*/
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