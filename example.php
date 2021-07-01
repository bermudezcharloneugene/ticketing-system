<?php

require_once "./autoload.php";
use app\utils\Query2;

$db = new Query2;
$query = "SELECT * FROM SAMPLE WHERE SAMPLE_ID = :sample_id";
var_dump($db->extractData($query,[
    ':sample_id' => 1
]));
