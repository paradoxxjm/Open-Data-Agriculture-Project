<?php
    /**
     * 
     */
     class PricesController extends AppController {
        var $helpers = array ('Html', 'Form');
        var $components = array('RequestHandler', 'Webservice.Webservice');     //Components to manage exportation to xml & json
        var $name = 'Prices';
        
        /*This variable is used to manage the amount and ordering of data that is passed 
            to view (See http://book.cakephp.org/view/1231/Pagination for details  */
        var $paginate = array(
            'limit' => 25,
            'order' => array(
                'Price.CropType' => 'ASC'
                )
        );

        function index() {
            /*Function: queryString
             *Input: Array of URL posted parameters
             *Output: SQL query string
             *=====================================
            */    
            function queryString($urlParams) {
//                print_r($urlParams);
                //echo count($urlParams);
                $query = "";
                $arrCount = 2;
                if (count($urlParams) > 2) {
                    foreach ( $urlParams as $column=>$param) { 
                        if ($column != 'ext' && $column != 'url') {
                            $arrCount++;
                            $query .= (($arrCount < count($urlParams) ? ("Price.$column='$param' AND ") :  ("Price.$column='$param'") ));
                        }
                    }
                }
                return $query;
            }
            ///////////////////////////////////////////////////////

            $url = $this->params['url'];
//           print_r($url);
            $query = queryString($url);
            $price = $this->paginate('Price', $query);
            
            $this->set('prices', $price);
            $this->View = 'Webservice.Webservice';
            
            }
    }
?>
