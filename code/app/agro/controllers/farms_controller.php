<?php
class FarmsController extends AppController {
/**
 * @todo Complete aggregate- top
 */

	var $name = 'Farms';

    /**
     *  Returns aggreagate farm data if no queries are specified
     *
     *  @todo implement top aggregation 
     */
	function index() {
        $url = $this->params['url'];
        //print_r($url);
        $aggParams = '';
        $searchType = "Farms";
        $this->Farm->recursive = -1; // See http://book.cakephp.org/view/1063/recursive

        if (count(array_keys($url))==2) { // Returns aggregrate
            $this->redirect(array('controller' => 'farms', 'action' => 'parishes'));
        }
        else { 
            $query = $this->Parser->queryString('Farm',$url);      //queryString function created to build database queries

            //debug($url);die;

            //Check for Aggregates
            //======================
            if ($this->Parser->isAgg($url)) {
                //echo "Aggregate called";
                $aggPair = $this->Parser->getAgg($url);
                $aggField = (string)$aggPair['key']."(".$aggPair['value'].")";
                //$aggField = "SUM(propertySize) AS 'sum'";
                $this->paginate = array('aggregate','fields' => $aggField, 'conditions' => $query);
                $this->set('farms', $this->paginate());
                $this->view = 'Webservice.Webservice';
            }

            if ($url['ext']=='html'){
                $this->paginate = array('fields' => $aggField, 'conditions' => $query);       // $query = conditions string e.g "column = param AND colmun2 = param2"
                $this->set('farms',$this->paginate());   
            }
            else{   //JSON or XML
                $query = $this->Parser->queryString('Farm',$url);
                $this->set('farms', $this->paginate($query));
            }
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
     * @bug Pagination for districts not returning correct page number
     */
    function parishes($ext = null, $dis = null) {
        if ($ext == null && $dis == null) {
            /*            $parishData = $this->Farm->find('all', array('fields' => array('Parish', 'COUNT(Parish) AS parishCount', 'SUM(PropertySize) AS totalSize'), 'group' => array('Parish')));*/
//            $parishData = $this->paginate('parishAg');
            $this->paginate = array('parishAg');
//            print_r($parishData);
//            var_dump($parishData);
            //$this->set('parishes',$parishData);
            $this->set('parishes',$this->paginate());
        }
        elseif (($ext == ('extension'||'extensions')) && ($dis == null)) {     //data.org.jm/farms/extension(s) 
//                echo "Returns parishes+extension information";
/*            $parishData = $this->Farm->find('all', array('fields' => array( 'Farm.Parish', 'Farm.Extension', '(COUNT("Farm.Extension")) AS farmCount', 
    '(SUM(PropertySize)) AS propertySum'), 'group'=>'Extension', 'order'=>array('Parish ASC', 'Extension ASC')));*/
            $this->paginate = array ('extensionAg', 'limit'=>50);
            $this->set('parishes',$this->paginate());   
//            $this->set('parishes',$parishData);   
            $this->render('extensions');
        }
        elseif (($ext == ('extension'||'extensions')) && ($dis  == ('district'||'districts'))) {     //data.org.jm/farms/extension(s)/district(s)/
            /*$parishData = $this->Farm->find('all', array('fields' => array( 'Farm.Parish', 'Farm.Extension', 'Farm.District', 
                '(COUNT("Farm.District")) AS districtCount', '(SUM(PropertySize)) AS propertySum'), 'group'=>'District', 
                'order'=>array('Parish ASC', 'Extension ASC', 'District ASC')));*/
//            $data = $this->Parser->afterQuery($parishes);
            $this->paginate = array ('districtAg');
            $this->set('parishes',$this->paginate());   
//            $this->set('parishes',$parishData);   
            $this->render('districts');  
            
        }
    }
}
?>
