<?php 

require_once 'core.php';

if($_POST) {

	$valid['success'] = array('success' => false, 'messages' => array());

	$currentPassword = md5($_POST['password']);
	$newPassword = md5($_POST['npassword']);
	$conformPassword = md5($_POST['cpassword']);
	$userId = $_POST['user_id'];

	$sql ="SELECT * FROM users WHERE user_id = {$userId}";
	$query = $connect->query($sql);
	$result = $query->fetch_assoc();

	if($currentPassword == $result['password']) {

		if($newPassword == $conformPassword) {

			$updateSql = "UPDATE users SET password = '$newPassword' WHERE user_id = {$userId}";
			if($connect->query($updateSql) === TRUE) {
				$valid['success'] = true;
				$valid['messages'] = "Password Successfully Updated";
				// echo '<script>alert("Password Successfully Updated");window.location.href="http://localhost/Vappy/setting.php";</script>';		
			} else {
				$valid['success'] = false;
				$valid['messages'] = "Error while updating the password";
				// echo '<script>alert("Password Failed to Update");window.location.href="http://localhost/Vappy/setting.php";</script>';	
			}

		} else {
			$valid['success'] = false;
			$valid['messages'] = "New password does not match with Confirm password";
			// echo '<script>alert("New password does not match with Confirm password");window.location.href="http://localhost/Vappy/setting.php";</script>';
		}

	} else {
		$valid['success'] = false;
		$valid['messages'] = "Current password is incorrect";
		// echo '<script>alert("Current password is incorrect");window.location.href="http://localhost/Vappy/setting.php";</script>';

	}

	$connect->close();
	echo json_encode($valid);
}
?>