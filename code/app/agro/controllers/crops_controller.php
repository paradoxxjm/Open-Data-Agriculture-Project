<?php
class CropsController extends AppController {

	var $name = 'Crops';

	function index() {
        $url = $this->params['url'];

        if ( count ( array_keys($url) ) == 2) { // Returns aggregrate
            $cropData = $this->Crop->find('all', array(
                'fields' => array('CropGroup', 'CropType', 'SUM(PropertySize) AS sumProperty', 'AVG(PropertySize) AS avgProperty', 'SUM(CropArea) AS sumCrop', 'AVG(CropArea) AS avgCrop'), 
                'group' => array('CropType'), 
                'order' => array('CropGroup', 'CropType')));
            //print_r($cropData);
            $this->set('crops', $cropData);
            $this->Render('aggregate');
        }
        else { // > 2 parameters means that a query parameter
    //        print_r($url);
            $query = $this->Parser->queryString('Crop',$url);      //queryString function created to build database queries e.g parish=st.andrew AND extension...
    //        print_r($query);

            if ($url['ext']=="html"){
                $cropData = $this->paginate('Crop', $query);        
                $this->set('crops', $cropData);
            }
            else{   //JSON or XML
    //            $query = $this->Parser->queryString('Crop',$url);
                //$returndata= false;
                $cropData = $this->paginate('Crop',$query);
                $this->set('crops', $cropData);
    //            $this->View = 'Webservice.Webservice';
            }

            $this->Crop->recursive = -1; // See http://book.cakephp.org/view/1063/recursive
    //		$this->set('crops', $this->paginate('Crop', $query));
    //		$this->Crop->recursive = 0;
    //		$this->set('crops', $this->paginate());
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
            $cropData = $this->Crop->find('all', array(
                'fields' => array('Parish', 'CropGroup', 'CropType', 'SUM(PropertySize) AS sumProperty', 'AVG(PropertySize) AS avgProperty', 'SUM(CropArea) AS sumCrop', 'AVG(CropArea) AS avgCrop'), 
                'group' => array('Parish', 'CropType'), 
                'order' => array('Parish', 'CropGroup', 'CropType')));
            $this->set('crops', $cropData);
            $this->render('parishes');
        }
        else if ($ext != null && $dis == null) {
            $this->render('extensions');
        }
        else if ($ext == null && $dis == null) {
            $this->render('districts');
        }
    }
}
?>
