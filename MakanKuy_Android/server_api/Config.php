<?php
	//these are the server details
	//the username is root by default in case of xampp
	//password is nothing by default
	//and lastly we have the database named android. if your database name is different you have to change it 
	$DB_HOST = "localhost";
	$DB_USER = "root";
	$DB_PASSWORD = "";
	$DB_DATABASE = "makan";
	 
	 
	//creating a new connection object using mysqli 
	$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DATABASE);
	 
	//if there is some error connecting to the database
	//with die we will stop the further execution by displaying a message causing the error 
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	else{
		echo "Connect";
	}
?>