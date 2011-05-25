<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppModel extends Model {
    
    var $_findMethods = array('paginatecount' => true);

    /**
     * Removes 'fields' key from count query on custom finds when it is an array,
     * as it will completely break the Model::_findCount() call
     *
     * @param string $state Either "before" or "after"
     * @param array $query
     * @param array $data
     * @return int The number of records found, or false
     * @access protected
     * @see Model::find()
     */
    function _findPaginatecount($state, $query, $results = array()) {
        if ($state == 'before' && isset($query['operation'])) {
            if (!empty($query['fields']) && is_array($query['fields'])) {
                if (!preg_match('/^count/i', $query['fields'][0])) {
                    unset($query['fields']);
                }
            }
        }
        return parent::_findCount($state, $query, $results);
    }

    /**
     * Custom Model::paginateCount() method to support custom model find pagination
     *
     * @param array $conditions
     * @param int $recursive
     * @param array $extra
     * @return array
     */
    function paginateCount($conditions = array(), $recursive = 0, $extra = array()) {
        $parameters = compact('conditions');

        if ($recursive != $this->recursive) {
            $parameters['recursive'] = $recursive;
        }

        if (isset($extra['type']) 
            && isset($this->_findMethods[$extra['type']])) {
            $extra['operation'] = 'count';
            return $this->find($extra['type'], array_merge($parameters, $extra));
        } else {
            return $this->find('count', array_merge($parameters, $extra));
        }
    }

    /* ==============================================================
     * See http://book.cakephp.org/view/1048/Callback-Methods
     * Input: 
     *      $results = array. data returned from query
     *      $primary = bool. Indicates whether model queried is same as controller
     * Returns: 
     *      $results = array. Search results
     * Description: This array places modified fields in correct space in array
     */
    function afterFind($results, $primary=false) {
        if($primary == true) {
            if(Set::check($results, '0.0')) {
                $fields = array_keys( $results[0][0] );
                foreach($results as $key=>$value) {
                    foreach( $fields as $fieldName ) {
                        $results[$key][$this->alias][$fieldName] = $value[0][$fieldName];
                    }
                    unset($results[$key][0]);
                }
            }
        }
        return $results;
    }
}
