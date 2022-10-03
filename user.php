<?php require_once 'php_action/db_connect.php' ?>
<?php require_once 'includes/header.php'; ?>

<div class="main-panel">
	<div class="content-wrapper">
		<div class="row">
			<div class="col-md-12 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
						<div class="panel-heading">
							<div class="card-title"> <i class="glyphicon glyphicon-edit"></i>Manage User</div>
						</div> <!-- /panel-heading -->
						<div class="panel-body">

							<div class="remove-messages"></div>
							<div class="row">
								<div class="col-12">
									<button class="btn btn-success button1" style="float:right; background-color:#4CAF50;" data-toggle="modal" id="addUserModalBtn" data-target="#addUserModal"> <i class="glyphicon glyphicon-plus-sign"></i> Add User </button>
									<br><br><br>
									<div class="table-responsive">
										<table class="display expandable-table" id="manageUserTable" style="width:100%">
											<thead>
												<tr>
													<th style="width:10%;">Username</th>
													<th style="width:10%;">Email</th>
													<th style="width:15%;">Options</th>
												</tr>
											</thead>
										</table><!-- /table -->
									</div> <!-- /table-responsive -->
								</div> <!-- /col-12 -->
							</div> <!-- /row -->
						</div> <!-- /panel-body -->
					</div> <!-- /card-body -->
				</div> <!-- /card -->
			</div> <!-- /col-md-12 -->
		</div> <!-- /row -->
	</div><!-- /content-wrapper -->

	<!-- add user -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

    	<form class="form-horizontal" id="submitUserForm" action="php_action/createUser.php" method="POST" enctype="multipart/form-data">
	      <div class="modal-header">
		  <h4 class="modal-title"><i class="fa fa-plus"></i> Add User</h4>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	      </div>

	      <div class="modal-body" style="max-height:450px; overflow:auto;">

	      	<div id="add-user-messages"></div>
	        <div class="form-group row">
	        	<label for="userName" class="col-sm-3 control-label">Username: </label>
	        	
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="userName" placeholder="Username" name="userName" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->	    

	        <div class="form-group row">
	        	<label for="upassword" class="col-sm-3 control-label">Password: </label>
	        	
				    <div class="col-sm-9">
				      <input type="password" class="form-control" id="upassword" placeholder="Password" name="upassword" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->	        	 

	        <div class="form-group row">
	        	<label for="uemail" class="col-sm-3 control-label">Email: </label>
	        	
				    <div class="col-sm-9">
				      <input type="email" class="form-control" id="uemail" placeholder="Email" name="uemail" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->	 
	        	         	        
	      </div> <!-- /modal-body -->
	      
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
	        
	        <button type="submit" class="btn btn-primary" id="createUserBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
	      </div> <!-- /modal-footer -->	      
     	</form> <!-- /.form -->	     
    </div> <!-- /modal-content -->    
  </div> <!-- /modal-dailog -->
</div> 
<!-- /add categories -->

	<!-- edit categories brand -->
	<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><i class="fa fa-edit"></i> Edit User</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body" style="max-height:450px; overflow:auto;">

					<div class="div-loading">
						<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
						<span class="sr-only">Loading...</span>
					</div>

					<!-- user image -->
					<div role="tabpanel" class="tab-pane active" id="userInfo">
						<form class="form-horizontal" id="editUserForm" action="php_action/editUser.php" method="POST">
							<!-- <br /> -->

							<div id="edit-user-messages"></div>

							<div class="form-group row">
								<label for="edituserName" class="col-sm-3 control-label">Username: </label>

								<div class="col-sm-9">
									<input type="text" class="form-control" id="edituserName" placeholder="Username" name="edituserName" autocomplete="off">
								</div>
							</div> <!-- /form-group-->

							<div class="form-group row">
								<label for="editPassword" class="col-sm-3 control-label">Password: </label>

								<div class="col-sm-9">
									<input type="password" class="form-control" id="editPassword" placeholder="Password" name="editPassword" autocomplete="off">
								</div>
							</div> <!-- /form-group-->

							<div class="form-group row">
								<label for="editEmail" class="col-sm-3 control-label">Email: </label>

								<div class="col-sm-9">
									<input type="email" class="form-control" id="editEmail" placeholder="Email" name="editEmail" autocomplete="off">
								</div>
							</div> <!-- /form-group-->


							<div class="modal-footer editUserFooter">
								<button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>

								<button type="submit" class="btn btn-success" id="editProductBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
							</div> <!-- /modal-footer -->
						</form> <!-- /.form -->
					</div>
					<!-- /user info -->

				</div> <!-- /modal-body -->


			</div>
			<!-- /modal-content -->
		</div>
		<!-- /modal-dailog -->
	</div>
	<!-- /categories brand -->

	<!-- categories brand -->
	<div class="modal fade" tabindex="-1" role="dialog" id="removeUserModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remove User</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">

					<div class="removeUserMessages"></div>

					<p>Do you really want to remove ?</p>
				</div>
				<div class="modal-footer removeProductFooter">
					<button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
					<button type="button" class="btn btn-primary" id="removeProductBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!-- /categories brand -->

	<script src="custom/js/user.js"></script>
	<?php require_once 'includes/footer.php'; ?>