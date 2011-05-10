<?php
/* Crops Test cases generated on: 2011-05-09 21:05:13 : 1304976673*/
App::import('Controller', 'Crops');

class TestCropsController extends CropsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class CropsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.crop');

	function startTest() {
		$this->Crops =& new TestCropsController();
		$this->Crops->constructClasses();
	}

	function endTest() {
		unset($this->Crops);
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