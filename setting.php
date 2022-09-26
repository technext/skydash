<?php require_once 'includes/header.php'; ?>

<?php 
$user_id = $_SESSION['userId'];
$sql = "SELECT * FROM users WHERE user_id = {$user_id}";
$query = $connect->query($sql);
$result = $query->fetch_assoc();

$connect->close();
?>
<div class="main-panel">
	<div class="content-wrapper">
	<div class="change-Username-Messages"></div>
		<div class="row">
		
			<div class="col-md-12 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Change User Details</h4>
						<p class="card-description">
							Change your user details here.
						</p>
						<form class="forms-sample" action="php_action/changeUsername.php" method="post" class="form-horizontal" id="changeUsernameForm">
						<div class="changeUsenrameMessages"></div>
							<div class="form-group row">
								<label for="username" class="col-sm-3 col-form-label">Username</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $result['username']; ?>">
								</div>
							</div>
							<!-- <div class="form-group row">
								<label for="username" class="col-sm-3 col-form-label">Email</label>
								<div class="col-sm-9">
									<input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $result['email']; ?>">
								</div>
							</div> -->
							<input type="hidden" name="user_id" id="user_id" value="<?php echo $result['user_id'] ?>" /> 
							<button type="submit" class="btn btn-primary mr-2" style="float:right; background-color:#4CAF50;" data-loading-text="Loading..." id="changeUsernameBtn">Update Username</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Change Password</h4>
						<p class="card-description">
							Change your password here.
						</p>
						<form class="forms-sample" action="php_action/changePassword.php" method="post" id="changePasswordForm">
						<div class="changePasswordMessages"></div>
							<div class="form-group row">
								<label for="password" class="col-sm-3 col-form-label">Current Password</label>
								<div class="col-sm-9">
									<input type="password" class="form-control" id="password" name="password" placeholder="Current Password">
								</div>
							</div>
							<div class="form-group row">
								<label for="npassword" class="col-sm-3 col-form-label">New Password</label>
								<div class="col-sm-9">
									<input type="password" class="form-control" id="npassword" name="npassword" placeholder="New Password">
								</div>
							</div>
							<div class="form-group row">
								<label for="cpassword" class="col-sm-3 col-form-label">Confirm Password</label>
								<div class="col-sm-9">
									<input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password">
								</div>
							</div>
							<input type="hidden" name="user_id" id="user_id" value="<?php echo $result['user_id'] ?>" /> 
							<button type="submit" class="btn btn-primary mr-2" style="float:right;">Update Password</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="custom/js/setting.js"></script>
	<?php require_once 'includes/footer.php'; ?>