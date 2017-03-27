<?php
require_once 'MakeArrays.php';

$numarr = new MakeArrays();
$result = $numarr->getResult();

$json = json_encode($result,JSON_UNESCAPED_UNICODE);

echo $json;