<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if ($_POST) {
	$edituserName = $_POST['edituserName'];
	$editPassword 		= md5($_POST['editPassword']);
	$editEmail = $_POST['editEmail'];
	$userid 		= $_POST['userid'];


	$sql = "UPDATE users SET username = '$edituserName', password = '$editPassword', email = '$editEmail' WHERE user_id = $userid ";

	if ($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = "User Successfully Updated";
		// echo '<script>alert("Successfully Update");window.location.href="http://localhost/Vappy/user.php";</script>';	

	} else {
		$valid['success'] = false;
		$valid['messages'] = "Error while updating user info";
		// echo '<script>alert("Error while updating user info ");window.location.href="http://localhost/Vappy/user.php";</script>';	

	}
} // /$_POST

$connect->close();

echo json_encode($valid);
