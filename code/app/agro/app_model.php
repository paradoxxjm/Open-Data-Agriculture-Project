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
