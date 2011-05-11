<?php
/**
 * The parse component includes the functions utilized in the the API to parse HTTP requests and any data required from the DB
 */
class ParseComponent extends Object {
    /*
     * Description: Takes the table and the HTTP URL posted and returns the 
     * parameters in an array
     */
    function queryString($table, $urlParams)
    {
        $query = "";
        $arrCount = 2;
        if (count($urlParams) > 2) {
            foreach ( $urlParams as $column=>$param) { 
                if ($column != 'ext' && $column != 'url') {
                    $arrCount++;
                    $query .= (($arrCount < count($urlParams) ? ("Crop.$column='$param' AND ") :  ("Crop.$column='$param'") ));
                }
            }
        }
        return $query;
    }
}

?>
