<?php require_once 'php_action/db_connect.php' ?>
<?php require_once 'includes/header.php'; ?>
<div class="main-panel">
	<div class="content-wrapper">
		<div class="row">
			<div class="col-md-12 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
						<div class="panel-heading">
							<div class="card-title"> <i class="glyphicon glyphicon-edit"></i>View RFID Details</div>
						</div> <!-- /panel-heading -->
						<div class="panel-body">

							<div class="remove-messages"></div>
							<div class="row">
								<div class="col-12">
									<!-- <button class="btn btn-success button1" style="float:right; background-color:#4CAF50;" data-toggle="modal" id="addUserModalBtn" data-target="#addUserModal"> <i class="glyphicon glyphicon-plus-sign"></i> Add User </button> -->
									<br><br><br>
									<div class="table-responsive">
										<table class="display expandable-table" id="viewRFIDTable" style="width:100%">
											<thead>
												<tr>
                                                    <!-- <th style="width:10%;">#</th> -->
													<th style="width:10%;">RFID Tag ID</th>
                                                    <th style="width:15%;">Timestamp</th>
													<th style="width:15%;">Encrypted Value</th>
                                                    <!-- <th style="width:15%;">Decrypted Value</th> -->
                                                    <!-- <th style="width:10%;">View Bill Details</th> -->
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
<script src="custom/js/rfid.js"></script>
<?php require_once 'includes/footer.php'; ?>