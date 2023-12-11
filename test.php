<?php

require_once 'DataAccess.php';

    $da = new DataAccess();

try {
    $arrData=$da->getData('select * from Management;');
var_dump($arrData);
} catch (Exception $e) {
}

