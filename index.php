<?php
require_once('MyDateTime.php');

try {

    $dateTime = new MyDateTime('01/03/2010 23:00', '+', 4000);
    echo $dateTime::parserDate();
} catch (Exception $e) {
    var_dump($e->getMessage());
}