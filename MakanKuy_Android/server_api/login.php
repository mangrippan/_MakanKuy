<?php
$connect=mysql_connect('localhost', 'root', '');
mysql_select_db('makan', $connect);

if (isset($_POST['id_konsumen']) && isset($_POST['password'])) {
 
 
 $id_konsumen = $_POST['id_konsumen'];
 $password = $_POST['password'];
 
 $sql = mysql_query("SELECT * FROM konsumen where id_konsumen = '$id_konsumen' and password = '$password' ");
 //$query = mysql_query($sql,$conn);
 
 $user = mysql_fetch_array($sql);
 
     if(mysql_num_rows($user)>0){
        $response["error"] = FALSE;
        $response["user"]["id_konsumen"] = $user["id_konsumen"];
        $response["user"]["password"] = $user["password"];
        //echo json_encode($response);
        echo "Username or Password Please Try Again";
     }
     
     else{
        $response["error"] = TRUE;
        echo "Invalid Username or Password Please Try Again";
     }
 
 }else{
 echo "Check Again";
 }

?>