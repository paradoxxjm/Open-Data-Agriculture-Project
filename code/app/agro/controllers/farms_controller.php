<?php
class FarmsController extends AppController {

	var $name = 'Farms';

	function index() {
        $url = $this->params['url'];
//        print_r($url);
        $query = $this->Parser->queryString('Farm',$url);      //queryString function created to build database queries

        if ($url['ext']=="html"){
            $farmData = $this->paginate('Farm', $query);
            $this->set('farms', $farmData);
        }
        else{   //JSON or XML
            $query = $this->Parser->queryString('Farm',$url);
            //$returndata= false;
            $farmData = $this->paginate('Farm',$query);
            $this->set('farms', $farmData);
//            $this->View = 'Webservice.Webservice';
        }

		$this->Farm->recursive = -1; // See http://book.cakephp.org/view/1063/recursive
//		$this->set('farms', $this->paginate('Farm', $query));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid farm', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('farm', $this->Farm->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Farm->create();
			if ($this->Farm->save($this->data)) {
				$this->Session->setFlash(__('The farm has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The farm could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid farm', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Farm->save($this->data)) {
				$this->Session->setFlash(__('The farm has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The farm could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Farm->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for farm', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Farm->delete($id)) {
			$this->Session->setFlash(__('Farm deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Farm was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
