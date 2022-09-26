<?php require_once 'includes/header.php'; ?>

<div class="main-panel">
	<div class="content-wrapper">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Manage Brand</div>
					</div> <!-- /panel-heading -->
					<div class="panel-body">

						<div class="remove-messages"></div>

						<button class="btn btn-success button1" style="float:right; background-color:#4CAF50;" data-toggle="modal" data-target="#addBrandModel"> <i class="glyphicon glyphicon-plus-sign"></i> Add Brand </button>
						<br><br><br>
						<div class="table-responsive">
							<table class="display expandable-table" id="manageBrandTable" style="width:100%">
								<thead>
									<tr>
										<th>Brand Name</th>
										<th>Status</th>
										<th style="width:15%;">Options</th>
									</tr>
								</thead>
							</table><!-- /table -->
						</div> <!-- /table-responsive -->
					</div> <!-- /panel-body -->
				</div> <!-- /panel -->
			</div> <!-- /col-md-12 -->
		</div> <!-- /row -->
	</div> <!-- /content-wrapper -->


	<div class="modal fade" id="addBrandModel" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">

				<form class="form-horizontal" id="submitBrandForm" action="php_action/createBrand.php" method="POST">
					<div class="modal-header">
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add Brand</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">

						<div id="add-brand-messages"></div>

						<div class="form-group row">
							<label for="brandName" class="col-sm-3 control-label">Brand Name: </label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="brandName" placeholder="Brand Name" name="brandName" autocomplete="off">
							</div>
						</div> <!-- /form-group-->
						<div class="form-group row">
							<label for="brandStatus" class="col-sm-3 control-label">Status: </label>
							<div class="col-sm-9">
								<select class="form-control" id="brandStatus" name="brandStatus">
									<option value="">~~SELECT~~</option>
									<option value="1">Available</option>
									<option value="2">Not Available</option>
								</select>
							</div>
						</div> <!-- /form-group-->

					</div> <!-- /modal-body -->

					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

						<button type="submit" class="btn btn-success" id="createBrandBtn" data-loading-text="Loading..." autocomplete="off">Save Changes</button>
					</div>
					<!-- /modal-footer -->
				</form>
				<!-- /.form -->
			</div>
			<!-- /modal-content -->
		</div>
		<!-- /modal-dailog -->
	</div>
	<!-- / add modal -->

	<!-- edit brand -->
	<div class="modal fade" id="editBrandModel" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">

				<form class="form-horizontal" id="editBrandForm" action="php_action/editBrand.php" method="POST">
					<div class="modal-header">
						<h4 class="modal-title"><i class="fa fa-edit"></i> Edit Brand</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">

						<div id="edit-brand-messages"></div>

						<div class="div-loading">
							<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
							<span class="sr-only">Loading...</span>
						</div>

						<div class="edit-brand-result">
							<div class="form-group row">
								<label for="editBrandName" class="col-sm-3 control-label">Brand Name: </label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="editBrandName" placeholder="Brand Name" name="editBrandName" autocomplete="off">
								</div>
							</div> <!-- /form-group-->
							<div class="form-group row">
								<label for="editBrandStatus" class="col-sm-3 control-label">Status: </label>
								<div class="col-sm-9">
									<select class="form-control" id="editBrandStatus" name="editBrandStatus">
										<option value="">~~SELECT~~</option>
										<option value="1">Available</option>
										<option value="2">Not Available</option>
									</select>
								</div>
							</div> <!-- /form-group-->
						</div>
						<!-- /edit brand result -->

					</div> <!-- /modal-body -->

					<div class="modal-footer editBrandFooter">
						<button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>

						<button type="submit" class="btn btn-success" id="editBrandBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
					</div>
					<!-- /modal-footer -->
				</form>
				<!-- /.form -->
			</div>
			<!-- /modal-content -->
		</div>
		<!-- /modal-dailog -->
	</div>
	<!-- / add modal -->
	<!-- /edit brand -->

	<!-- remove brand -->
	<div class="modal fade" tabindex="-1" role="dialog" id="removeMemberModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remove Brand</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<p>Do you really want to remove ?</p>
				</div>
				<div class="modal-footer removeBrandFooter">
					<button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
					<button type="button" class="btn btn-primary" id="removeBrandBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!-- /remove brand -->

	<script src="custom/js/brand.js"></script>
	<?php require_once 'includes/footer.php'; ?>