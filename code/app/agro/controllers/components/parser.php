<?php
/**
 * The parse component includes the functions utilized in the the API to parse HTTP requests and any data required from the DB
 */
class ParserComponent extends Object {

    function isAgg($url) {
        $aggregates = array('sum','max','min','top','count');
        foreach ($aggregates as $agg) {
            if (array_key_exists("$agg",$url))
                return true;
        }
        return false;
    }

    function getAgg($url) {
        $aggregates = array('sum','max','min','top','count');
        foreach ($aggregates as $agg) {
            if (array_key_exists("$agg",$url)) {
                $aggPair = array("key" => $agg);
                $aggPair["value"] = $url["$agg"];
                return $aggPair;
            }
        }
        return null;
    }

    /*
     * Description: Takes the table and the HTTP URL posted and returns the 
     * parameters in an array
     */
    function queryString($table, $urlParams) {
        //print_r($urlParams);
        //$query = "";
        $query = array();
        $aggregates = array('sum','max','min','top','count');
        $arrCount = 2;

        if (count($urlParams) > 2) {
            foreach ( $urlParams as $column=>$param) { 
                if ($column != 'ext' && $column != 'url') {
                    $arrCount++;
                    if ( $column == "startdate" ) {     // date format = yyyy-mm-dd
                        if ( $table == 'Crop') {
                            //$query .= (($arrCount < count($urlParams) ? ("$table.CropDate>'$param' AND ") :  ("$table.CropDate>'$param'") ));
                            $query[] = array("CropDate >" => $param);
                        }
                        else if ($table == 'Price') {
                            $query[] = array("PriceMonth >" => $param);
                            //$query .= (($arrCount < count($urlParams) ? ("$table.PriceMonth>'$param' AND ") :  ("$table.PriceMonth>'$param'") ));
                        }
                    }
                    else if ( $column == "enddate" ) { 
                        if ( $table == 'Crop') {
//                            $query .= (($arrCount < count($urlParams) ? ("$table.CropDate<'$param' AND ") :  ("$table.CropDate<'$param'") ));
                            $query[] = array("CropDate <" => $param);
                        }
                        else if ($table == 'Price') {
                            $query[] = array("PriceMonth >" => $param);
                            //$query .= (($arrCount < count($urlParams) ? ("$table.PriceMonth<'$param' AND ") :  ("$table.PriceMonth<'$param'") ));
                        }
                    } 
                    else if (in_array($column,$aggregates))
                        continue;
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
