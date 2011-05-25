<?php
/**
 * The parse component includes the functions utilized in the the API to parse HTTP requests and any data required from the DB
 */
class ParserComponent extends Object {
    /*
     * Description: Takes the table and the HTTP URL posted and returns the 
     * parameters in an array
     */
    function queryString($table, $urlParams, &$aggQuery=null) {
        //print_r($urlParams);
        //$query = "";
        $query = array();
        $arrCount = 2;
        if (count($urlParams) > 2) {
            foreach ( $urlParams as $column=>$param) { 
                if ($column != 'ext' && $column != 'url') {
                    $arrCount++;
                    if ( $column == "startdate" ) {     // date format = yyyy-mm-dd
                        if ( $table == 'Crop') {
                            $query .= (($arrCount < count($urlParams) ? ("$table.CropDate>'$param' AND ") :  ("$table.CropDate>'$param'") ));
                        }
                        else if ($table == 'Price') {
                            $query .= (($arrCount < count($urlParams) ? ("$table.PriceMonth>'$param' AND ") :  ("$table.PriceMonth>'$param'") ));
                        }
                    }
                    else if ( $column == "enddate" ) { 
                        if ( $table == 'Crop') {
                            $query .= (($arrCount < count($urlParams) ? ("$table.CropDate<'$param' AND ") :  ("$table.CropDate<'$param'") ));
                        }
                        else if ($table == 'Price') {
                            $query .= (($arrCount < count($urlParams) ? ("$table.PriceMonth<'$param' AND ") :  ("$table.PriceMonth<'$param'") ));
                        }
                    } 
                    else if ( $column == "count" ) {
                        echo "count";
                    }
                    else if ( $column == "sum" ) {
                        echo "sum";
                        $query .= (($arrCount < count($urlParams) ? ("SUM($table.$param) AS sum$param, ") :  ("SUM($table.$param) AS sum$param") ));
                        //echo "$query";
                    }
                    else if ( $column == "max" ) {
                        echo "max";
                        $query .= (($arrCount < count($urlParams) ? ("MAX($table.$param) AS max$param, ") :  ("MAX($table.$param) AS max$param") ));
                    }
                    else if ( $column == "top" ) {
                        echo "";
                    }
                    else {
//                        $query .= (($arrCount < count($urlParams) ? ("$table.$column='$param' AND ") :  ("$table.$column='$param'") ));
                        $query[] = array($column => $param);
                    }
                }
            }
        }
        return $query;
    }
}

?>
