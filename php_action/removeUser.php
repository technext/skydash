<?php 	

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$userid = $_POST['userid'];

if($userid) { 

 $sql = "DELETE FROM users  WHERE user_id = {$userid}";

 if($connect->query($sql) === TRUE) {
 	$valid['success'] = true;
	$valid['messages'] = "User Successfully Removed";		
	// echo '<script>alert("Successfully Removed");window.location.href="http://localhost/Vappy/user.php";</script>';	
 } else {
 	$valid['success'] = false;
 	$valid['messages'] = "Error while remove the user";
	// echo '<script>alert("Error while remove the user");window.location.href="http://localhost/Vappy/user.php";</script>';	

 }
 
 $connect->close();

 echo json_encode($valid);
 
} // /if $_POST