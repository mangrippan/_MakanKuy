<?php


include_once('/Authentication.php');
use user\Authentication;

$auth = new Authentication();
$auth->prepare($_POST);
$userStatus = $auth->isUserExisted();


if ($userStatus==false) {
    $auth->insertNewUserIntoDB();

} else {
    
    $json['success'] = 0;
    $json['message'] = 'User exist';

    echo json_encode($json);
}