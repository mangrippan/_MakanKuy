<?php

include_once('/Authentication.php');
use user\Authentication;

$auth = new Authentication();
$auth->prepare($_GET);
$auth->profilReq();



