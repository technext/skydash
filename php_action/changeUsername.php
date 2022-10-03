<?php 

require_once 'core.php';

if($_POST) {

	$valid['success'] = array('success' => false, 'messages' => array());

	$username = $_POST['username'];
	// $email = $_POST['email'];
	$userId = $_POST['user_id'];

	$sql = "UPDATE users SET username = '$username' WHERE user_id = {$userId}";
	if($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = "Username Successfully Update";	
		// echo '<script>alert("Successfully Update");window.location.href="http://localhost/Vappy/setting.php";</script>';
	} else {
		$valid['success'] = false;
		$valid['messages'] = "Error while updating user details";
		// echo '<script>alert("Error while updating Username");window.location.href="http://localhost/Vappy/setting.php";</script>';
	}

	$connect->close();

	echo json_encode($valid);
}
?>