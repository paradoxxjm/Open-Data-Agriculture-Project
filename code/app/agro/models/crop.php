<?php
class Crop extends AppModel {
	var $name = 'Crop';
	var $displayField = 'id';

    function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->_findMethods['cropAg'] = true;
        $this->_findMethods['parishAg'] = true;
    }

    function _findCropAg($state, $query, $results = array()) {
        if ($state == 'before') {
            $query['fields'] = array( 'CropGroup', 'CropType', 'SUM(PropertySize) AS sumProperty', 'AVG(PropertySize) AS avgProperty', 'SUM(CropArea) AS sumCrop', 'AVG(CropArea) AS avgCrop');
            $query['group'] = array('CropType');
            if (empty($query['order']))
                $query['order'] = array('CropGroup ASC', 'CropType ASC');

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

    function _findParishAg($state, $query, $results = array()) {
        if ($state == 'before') {
            $query['fields'] = array( 'Parish', 'CropGroup', 'CropType', 'SUM(PropertySize) AS sumProperty', 'AVG(PropertySize) AS avgProperty', 'SUM(CropArea) AS sumCrop', 'AVG(CropArea) AS avgCrop');
            $query['group'] = array('Parish', 'CropType');
            if (empty($query['order']))
                $query['order'] = array('Parish ASC', 'CropGroup ASC', 'CropType ASC');

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
}
?>
