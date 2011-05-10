<?php
/* Price Test cases generated on: 2011-05-09 21:05:38 : 1304976638*/
App::import('Model', 'Price');

class PriceTestCase extends CakeTestCase {
	var $fixtures = array('app.price');

	function startTest() {
		$this->Price =& ClassRegistry::init('Price');
	}

	function endTest() {
		unset($this->Price);
		ClassRegistry::flush();
	}

}
?>