<?php
class FarmsController extends AppController {

	var $name = 'Farms';

	function index() {
        $url = $this->params['url'];
        $query = $this->Parser->queryString('Farm',$url);      //queryString function created to build database queries
		$this->Farm->recursive = -1; // See http://book.cakephp.org/view/1063/recursive
        if ($url['ext']=="html"){
            $farmData = $this->paginate('Farm', $query);
            $this->set('farms', $farmData);
        }
        else{   //JSON or XML
            $query = $this->Parser->queryString('Farm',$url);
            //$returndata= false;
            $farmData = $this->paginate('Farm',$query);
            $this->set('farms', $farmData);
        }

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

    /**
     * parishes
     *
     * Returns parish aggregation information
     *
     * @todo Implement pagination
     */
    function parishes($ext = null, $dis = null) {
        if ($ext == null && $dis == null) {
            $parishData = $this->Farm->find('all', array('fields' => array('Parish', 'COUNT(Parish) AS parishCount', 'SUM(PropertySize) AS totalSize'), 'group' => array('Parish')));
//            print_r($parishData);
//            var_dump($parishData);
            $this->set('parishes',$parishData);
        }
        elseif (($ext == ('extension'||'extensions')) && ($dis == null)) {     //data.org.jm/farms/extension(s) 
//                echo "Returns parishes+extension information";
            $parishData = $this->Farm->find('all', array('fields' => array( 'Farm.Parish', 'Farm.Extension', '(COUNT("Farm.Extension")) AS farmCount', 
                '(SUM(PropertySize)) AS propertySum'), 'group'=>'Extension', 'order'=>array('Parish ASC', 'Extension ASC')));
            $this->set('parishes',$parishData);   
            $this->render('extensions');     //districts.ctp not created yet
        }
        elseif (($ext == ('extension'||'extensions')) && ($dis  == ('district'||'districts'))) {     //data.org.jm/farms/extension(s)/district(s)/
            //echo "Returns parishes+extensions+districts information";
            $parishData = $this->Farm->find('all', array('fields' => array( 'Farm.Parish', 'Farm.Extension', 'Farm.District', 
                '(COUNT("Farm.District")) AS districtCount', '(SUM(PropertySize)) AS propertySum'), 'group'=>'District', 
                'order'=>array('Parish ASC', 'Extension ASC', 'District ASC')));
//            $data = $this->Parser->afterQuery($parishes);
            $this->set('parishes',$parishData);   
            $this->render('districts');     //districts.ctp not created yet
            
        }
    }
}
?>
