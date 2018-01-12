<?php 
 
 require_once 'Config.php';
 
 $response = array();
 
 if(isset($_GET['apicall'])){
 
 switch($_GET['apicall']){
 
 case 'register':
 if(isTheseParametersAvailable(array('id_konsumen','email','nama','password','no_telp'))){
 $email = $_POST['email'];
 $nama = $_POST['nama']; 
 $id_konsumen = $_POST['id_konsumen']; 
 $password = md5($_POST['password']);
 $no_telp = $_POST['no_telp']; 
 
 $stmt = $conn->prepare("SELECT id FROM konsumen WHERE id_konsumen = ? OR email = ?");
 $stmt->bind_param("ss", $email, $id_konsumen);
 $stmt->execute();
 $stmt->store_result();
 
 if($stmt->num_rows > 0){
 $response['error'] = true;
 $response['message'] = 'User already registered';
 $stmt->close();
 }else{
 $stmt = $conn->prepare("INSERT INTO konsumen (id_konsumen, email, nama, password, no_telp) VALUES (?, ?, ?, ?,?)");
 $stmt->bind_param("sssss", $email, $nama, $username, $password, $no_telp);
 
 if($stmt->execute()){
 $stmt = $conn->prepare("SELECT id_konsumen, email, nama, username, password, no_telp FROM konsumen WHERE id_konsumen = ?"); 
 $stmt->bind_param("s",$username);
 $stmt->execute();
 $stmt->bind_result($id_konsumen, $email, $nama, $username, $password, $no_telp);
 $stmt->fetch();
 
 $user = array(
 'id_konsumen'=>$id_konsumen,
 'email'=>$email,
 'nama'=>$nama,
 'password'=>$password,
 'no_telp'=>$no_telp
 );
 
 $stmt->close();
 
 $response['error'] = false; 
 $response['message'] = 'User registered successfully'; 
 $response['user'] = $user; 
 }
 }
 
 }else{
 $response['error'] = true; 
 $response['message'] = 'required parameters are not available'; 
 }
 
 break; 
 
 case 'login':
 
 if(isTheseParametersAvailable(array('id_konsumen', 'password'))){
 
 $id_konsumen = $_POST['id_konsumen'];
 $password = md5($_POST['password']); 
 
 $stmt = $conn->prepare("SELECT id_konsumen, email, nama, password, no_telp FROM konsumen WHERE id_konsumen = ? AND password = ?");
 $stmt->bind_param("ss",$id_konsumen, $password);
 
 $stmt->execute();
 
 $stmt->store_result();
 
 if($stmt->num_rows > 0){
 
 $stmt->bind_result($id_konsumen, $email, $nama, $no_telp);
 $stmt->fetch();
 
 $user = array(
 'id_konsumen'=>$id_konsumen,
 'email'=>$email,
 'nama'=>$nama,
 'no_telp'=>$no_telp
 );
 
 $response['error'] = false; 
 $response['message'] = 'Login successfull'; 
 $response['user'] = $user; 
 }else{
 $response['error'] = false; 
 $response['message'] = 'Invalid username or password';
 }
 }
 break; 
 
 default: 
 $response['error'] = true; 
 $response['message'] = 'Invalid Operation Called';
 }
 
 }else{
 $response['error'] = true; 
 $response['message'] = 'Invalid API Call';
 }
 
 echo json_encode($response);
 
 function isTheseParametersAvailable($params){
 
 foreach($params as $param){
 if(!isset($_POST[$param])){
 return false; 
 }
 }
 return true; 
 }