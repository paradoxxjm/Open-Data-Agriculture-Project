<?php
class CropsController extends AppController {

	var $name = 'Crops';

	function index() {
        $url = $this->params['url'];
        $aggParams = '';
        $this->Crop->recursive = -1; // See http://book.cakephp.org/view/1063/recursive

        if ( count ( array_keys($url) ) == 2) { // Returns aggregrate
            $this->paginate = array('cropAg');
            $this->set('crops', $this->paginate());
            //$this->set('crops', $cropData);
            $this->Render('aggregate');
        }
        else { // > 2 parameters implies a query request has been made
            $query = $this->Parser->queryString('Crop',$url);      //queryString function created to build database queries e.g parish=st.andrew AND extension...

            if ($url['ext']=="html"){
                $cropData = $this->paginate('Crop', $query);        
                $this->set('crops', $cropData);
            }
            else{   //JSON or XML
                $cropData = $this->paginate('Crop',$query);
                $this->set('crops', $cropData);
            }
        }
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid crop', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('crop', $this->Crop->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Crop->create();
			if ($this->Crop->save($this->data)) {
				$this->Session->setFlash(__('The crop has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The crop could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid crop', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Crop->save($this->data)) {
				$this->Session->setFlash(__('The crop has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The crop could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Crop->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for crop', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Crop->delete($id)) {
			$this->Session->setFlash(__('Crop deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Crop was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

    /**
     * parishes
     *
     * Returns parish aggregation information
     *
     * @note Created a route in the config/routes.php that forwards all requests to farms/parishes to this function
     *
     * @todo Implement pagination
     */
    function parishes($ext = null, $dis = null) {
        if ($ext == null && $dis == null) {
            $this->paginate = array('parishAg');
            $this->set('crops', $this->paginate());
            $this->render('parishes');
        }
/*        else if ($ext != null && $dis == null) {
            $this->render('extensions');
        }
        else if ($ext == null && $dis == null) {
            $this->render('districts');
        }*/
    }
}
?>
