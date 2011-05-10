<?php
/* Farms Test cases generated on: 2011-05-09 19:05:50 : 1304982590*/
App::import('Controller', 'Farms');

class TestFarmsController extends FarmsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class FarmsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.farm');

	function startTest() {
		$this->Farms =& new TestFarmsController();
		$this->Farms->constructClasses();
	}

	function endTest() {
		unset($this->Farms);
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