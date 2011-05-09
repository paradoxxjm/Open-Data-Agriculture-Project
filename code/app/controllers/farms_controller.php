<?php
    /**
     * 
     */
    class FarmsController extends AppController {
        var $helpers = array ('Html', 'Form');
        var $components = array('RequestHandler', 'Webservice.Webservice');     //Components to manage exportation to xml & json
        var $name = 'Farms';
        
        /*This variable is used to manage the amount and ordering of data that is passed 
            to view (See http://book.cakephp.org/view/1231/Pagination for details  */
        var $paginate = array(
            'limit' => 25,
            'order' => array(
                'Farm.FarmerID' => 'asc'
                )
        );

        function index() {
            $data = $this->paginate('Farm');
            $this->set('farms', $data);
            }

        function view($id = null)
        {
            $this->Farm->id = $id;
            $this->View = 'Webservice.Webservice';
            $this->set('farms', $this->Farm->read());
            
            //Parsing out particular URL parameters
            $this->set('format', 'xml');
            $this->set('url', $this->params['url']);
            $this->set('fullurl', $this->params['pass']);
        }

        function add()
        {
            if (!empty($this->data)) {
                if ($this->Farm->save($this->data)) {
                    $this->Session->setFlash('Your post has been saved.');
                    $this->redirect(array('action' => 'index'));
                }
            }
        }

        function edit($id=null)
        {
            $this->Farm->id = $id;
            if ($this->Farm->save($this->data)) {
                $message = 'Saved';
            } else {
                $message = 'Error';
            }
            $this->set(compact("message"));
        }

        function delete($id=null)
        {
            if($this->Farm->delete($id)) {
                $message = 'Deleted';
            } else {
                $message = 'Error';
            }
            $this->set(compact("message"));
        }
            
        }
    
?>
