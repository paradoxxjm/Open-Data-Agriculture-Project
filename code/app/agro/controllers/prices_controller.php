<?php
class PricesController extends AppController {

	var $name = 'Prices';

	function index() {
        $url = $this->params['url'];
//        print_r($url);
        $query = $this->Parser->queryString('Price',$url);      //queryString function created to build database queries
		$this->Price->recursive = -1; // See http://book.cakephp.org/view/1063/recursive

        if ($url['ext']=="html"){
            $priceData = $this->paginate('Price', $query);
            $this->set('prices', $priceData);
        }
        else{   //JSON or XML
            $query = $this->Parser->queryString('Price',$url);
            //$returndata= false;
            $priceData = $this->paginate('Price',$query);
            $this->set('prices', $priceData);
        }
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid price', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('price', $this->Price->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Price->create();
			if ($this->Price->save($this->data)) {
				$this->Session->setFlash(__('The price has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The price could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid price', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Price->save($this->data)) {
				$this->Session->setFlash(__('The price has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The price could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Price->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for price', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Price->delete($id)) {
			$this->Session->setFlash(__('Price deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Price was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

    function parishes() {
            $priceData = $this->Price->find('all', array('fields' => array('Parish', 'CropType', 'AVG(FreqPrice) AS avgPrice'), 'group' => array('Parish', 'CropType')));
//            print_r($priceData);
            foreach ($priceData as &$priceRecord){
                if ($priceRecord['Price']['avgPrice'] == 0) {
//                    echo "Record ".$priceRecord['Price']['Parish']." ".$priceRecord['Price']['avgPrice']."\n";
                    unset($priceRecord['Price']);
                }
            }
//            $test = $this->Price->find('all', array('fields' => array('Parish', 'CropType', 'FreqPrice'), 'conditions' => array('Price.CropType' => 'Cabbage')));
//            print_r($test);
//            print_r($priceData);
//            var_dump($parishData);
            $this->set('parishes',$priceData);
    }
}
?>
