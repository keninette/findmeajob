<?php

/**
 * Create array of arguments to be passed onto the pdoPrepareQuery() function
 * This array will contain associative arrays following this pattern :
 *     array(
 *          PDO_PARAM_ORDER_CODE            => ":code_param"
 *          , PDO_PARAM_ORDER_VALUE         => "param_value"
 *          , PDO_PARAM_ORDER_TYPE          => PDO::PARAM_...
 *          , PDO_PARAM_ORDER_ COLUMN_NAME  => "code_param"
 *     );
 * 
 * @param array $postFilters : content of POST data concerning filters
 * @return array : array of arguments following the pattern described
 */
function createArgsForQuery(array $postFilters) :array {
    $args = [];
    
    var_dump($postFilters);
    foreach ($postFilters as $dbColumn => $filterValue) {

        if(!empty($filterValue)) {

            // if $filterValue is an array (checkboxes & dates)
            // we need to create an entry per array line in $args
            if (is_array($filterValue) && !array_key_exists('start', $filterValue) && !array_key_exists('end', $filterValue)) {
                for ($i=0; $i<count($filterValue); $i++) {
                    $args[] = array(
                        PDO_PARAM_ORDER_CODE            => ':' .$dbColumn .$i
                        , PDO_PARAM_ORDER_VALUE         => filter_var($filterValue[$i], FILTER_VALIDATE_BOOLEAN)
                        , PDO_PARAM_ORDER_TYPE          => PDO::PARAM_BOOL
                        , PDO_PARAM_ORDER_COLUMN_NAME   => $dbColumn
                    );
                }

            } elseif (is_array($filterValue)) {
                /*if (array_key_exists('start', $filterValue)) {
                    $args[] = array(
                        PDO_PARAM_ORDER_CODE    => ':' .$dbColumn
                        , PDO_PARAM_ORDER_VALUE => filter_var($filterValue)
                        , PDO_PARAM_ORDER_TYPE  => PDO::PARAM_STR
                        , PDO_PARAM_ORDER_COLUMN_NAME   => $dbColumn 
                    );
                }
                
                if (array_key_exists('start', $filterValue)) {
                    $args[] = array(
                        PDO_PARAM_ORDER_CODE    => ':' .$dbColumn
                        , PDO_PARAM_ORDER_VALUE => filter_var($filterValue)
                        , PDO_PARAM_ORDER_TYPE  => PDO::PARAM_STR
                        , PDO_PARAM_ORDER_COLUMN_NAME   => $dbColumn 
                    );
                }*/
                
            } else {
                $args[] = array(
                    PDO_PARAM_ORDER_CODE    => ':' .$dbColumn
                    , PDO_PARAM_ORDER_VALUE => filter_var($filterValue)
                    , PDO_PARAM_ORDER_TYPE  => PDO::PARAM_STR
                    , PDO_PARAM_ORDER_COLUMN_NAME   => $dbColumn 
                );
            }
        }
    }       

    return $args;    
}