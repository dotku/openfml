<?php 

function fnmili_json_decode($requestURL, $data) {
    if ($data) {
        $requestURL = $requestURL . '?' . http_build_query($data);
    }
    return json_decode(file_get_contents($requestURL), true);
}