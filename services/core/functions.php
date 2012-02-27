<?php

/**
 * Basic cURL wrapper function for PHP
 * @link http://snipplr.com/view/51161/basic-curl-wrapper-function-for-php/
 * @param string $url URL to fetch
 * @param array $curlopt Array of options for curl_setopt_array
 * @return string
 */
function file_get_contents_curl($url, $curlopt = array()){
    $ch = curl_init();
    $default_curlopt = array(
        CURLOPT_TIMEOUT => 90,
        CURLOPT_RETURNTRANSFER => 1,
        //CURLOPT_FOLLOWLOCATION => 1
    );
    $curlopt = array(CURLOPT_URL => $url) + $curlopt + $default_curlopt;
    curl_setopt_array($ch, $curlopt);
    $response = curl_exec($ch);
    if($response === false)
        trigger_error(curl_error($ch));
    curl_close($ch);
    return $response;
}

// Pass the array, followed by the column names and sort flags
// $sorted = array_orderby($data, 'volume', SORT_DESC, 'edition', SORT_ASC);
function array_orderby()
{
    $args = func_get_args();
    $data = array_shift($args);
    foreach ($args as $n => $field) {
        if (is_string($field)) {
            $tmp = array();
            foreach ($data as $key => $row)
                $tmp[$key] = $row[$field];
            $args[$n] = $tmp;
            }
    }
    $args[] = &$data;
    call_user_func_array('array_multisort', $args);
    return array_pop($args);
}

?>