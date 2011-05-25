<?php
class Farm extends AppModel {
	var $name = 'Farm';
    var $_findMethods = array('parishAg' => true, 'extensionAg' => true, 'districtAg' => true);

    function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->_findMethods['parishAg'] = true;
        $this->_findMethods['extensionAg'] = true;
        $this->_findMethods['districtAg'] = true;
    }


    function _findParishAg($state, $query, $results = array()) {
        if ($state === 'before') {
            $query['fields'] = array( 'Parish', 'COUNT(Parish) AS parishCount', 'SUM(PropertySize) AS totalSize');
            $query['group'] = 'Parish';
            if (empty($query['order']))
                $query['order'] = array('Parish ASC');

//            $query['conditions']['approved'] = 1;
            if (!empty($query['operation'])) {
                return $this->_findPaginatecount($state, $query, $results);
            }
            return $query;
        } elseif ($state == 'after') {
            if (!empty($query['operation'])) {
                return $this->_findPaginatecount($state, $query, $results);
            }
            return $results;
        }
    }

    function _findExtensionAg($state, $query, $results = array()) {
        if ($state === 'before') {
            $query['fields'] = array( 'Farm.Parish', 'Farm.Extension', '(COUNT("Farm.Extension")) AS farmCount', '(SUM(PropertySize)) AS propertySum');
            $query['group'] = 'Extension';
            if (empty($query['order']))
                $query['order'] = array('Parish ASC', 'Extension ASC');

//            $query['conditions']['approved'] = 1;
            if (!empty($query['operation'])) {
                return $this->_findPaginatecount($state, $query, $results);
            }
            return $query;
        } elseif ($state == 'after') {
            if (!empty($query['operation'])) {
                return $this->_findPaginatecount($state, $query, $results);
            }
            return $results;
        }
    }

    function _findDistrictAg($state, $query, $results = array()) {
        if ($state === 'before') {
            $query['fields'] = array( 'Farm.Parish', 'Farm.Extension', 'Farm.District', '(COUNT("Farm.District")) AS districtCount', '(SUM(PropertySize)) AS propertySum'); 
            $query['group'] = 'District';
            if (empty($query['order']))
                $query['order'] = array('Parish ASC', 'Extension ASC', 'District ASC');

//            $query['conditions']['approved'] = 1;
            if (!empty($query['operation'])) {
                return $this->_findPaginatecount($state, $query, $results);
            }
            return $query;
        } elseif ($state == 'after') {
            if (!empty($query['operation'])) {
                return $this->_findPaginatecount($state, $query, $results);
            }
            return $results;
        }
    }

    /*}
    $_types =  array(
        'parishAg' => array(
            'fields' =>  array( 'Farm.Parish', 'Farm.Extension', '(COUNT("Farm.Extension")) AS farmCount', '(SUM(PropertySize)) AS propertySum'), 
            'group'=>'Extension', 
            'order'=>array('Parish ASC', 'Extension ASC')
        )
    );*/

}
?>
