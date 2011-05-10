<?php
/* Prices Test cases generated on: 2011-05-09 21:05:54 : 1304976714*/
App::import('Controller', 'Prices');

class TestPricesController extends PricesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class PricesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.price');

	function startTest() {
		$this->Prices =& new TestPricesController();
		$this->Prices->constructClasses();
	}

	function endTest() {
		unset($this->Prices);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testView() {

	}

	function testAdd() {

	}

	function testEdit() {

	}

	function testDelete() {

	}

}
?>