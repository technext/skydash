<?php require_once 'includes/header.php'; ?>

<div class="main-panel">
	<div class="content-wrapper">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Manage Categories</div>
					</div> <!-- /panel-heading -->
					<div class="panel-body">

						<div class="remove-messages"></div>
						<button class="btn btn-success button1" style="float:right; background-color:#4CAF50;" data-toggle="modal" id="addCategoriesModalBtn" data-target="#addCategoriesModal"> <i class="glyphicon glyphicon-plus-sign"></i> Add Categories </button>
						<br><br><br>
						<div class="table-responsive">
							<table class="display expandable-table" id="manageCategoriesTable" style="width:100%">
								<thead>
									<tr>
										<th>Categories Name</th>
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

	<!-- add categories -->
	<div class="modal fade" id="addCategoriesModal" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">

				<form class="form-horizontal" id="submitCategoriesForm" action="php_action/createCategories.php" method="POST">
					<div class="modal-header">
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add Categories</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">

						<div id="add-categories-messages"></div>

						<div class="form-group row">
							<label for="categoriesName" class="col-sm-3 control-label">Categories Name: </label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="categoriesName" placeholder="Categories Name" name="categoriesName" autocomplete="off">
							</div>
						</div> <!-- /form-group-->
						<div class="form-group row">
							<label for="categoriesStatus" class="col-sm-3 control-label">Status: </label>
							<div class="col-sm-9">
								<select class="form-control" id="categoriesStatus" name="categoriesStatus">
									<option value="">~~SELECT~~</option>
									<option value="1">Available</option>
									<option value="2">Not Available</option>
								</select>
							</div>
						</div> <!-- /form-group-->
					</div> <!-- /modal-body -->

					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>

						<button type="submit" class="btn btn-primary" id="createCategoriesBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
					</div> <!-- /modal-footer -->
				</form> <!-- /.form -->
			</div> <!-- /modal-content -->
		</div> <!-- /modal-dailog -->
	</div>
	<!-- /add categories -->


	<!-- edit categories brand -->
	<div class="modal fade" id="editCategoriesModal" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">

				<form class="form-horizontal" id="editCategoriesForm" action="php_action/editCategories.php" method="POST">
					<div class="modal-header">
						<h4 class="modal-title"><i class="fa fa-edit"></i> Edit Category</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">

						<div id="edit-categories-messages"></div>

						<div class="div-loading">
							<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
							<span class="sr-only">Loading...</span>
						</div>

						<div class="edit-categories-result">
							<div class="form-group row">
								<label for="editCategoriesName" class="col-sm-3 control-label">Categories Name: </label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="editCategoriesName" placeholder="Categories Name" name="editCategoriesName" autocomplete="off">
								</div>
							</div> <!-- /form-group-->
							<div class="form-group row">
								<label for="editCategoriesStatus" class="col-sm-3 control-label">Status: </label>
								<div class="col-sm-9">
									<select class="form-control" id="editCategoriesStatus" name="editCategoriesStatus">
										<option value="">~~SELECT~~</option>
										<option value="1">Available</option>
										<option value="2">Not Available</option>
									</select>
								</div>
							</div> <!-- /form-group-->
						</div>
						<!-- /edit brand result -->

					</div> <!-- /modal-body -->

					<div class="modal-footer editCategoriesFooter">
						<button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>

						<button type="submit" class="btn btn-primary" id="editCategoriesBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
					</div>
					<!-- /modal-footer -->
				</form>
				<!-- /.form -->
			</div>
			<!-- /modal-content -->
		</div>
		<!-- /modal-dailog -->
	</div>
	<!-- /categories brand -->

	<!-- categories brand -->
	<div class="modal fade" tabindex="-1" role="dialog" id="removeCategoriesModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remove Category</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<p>Do you really want to remove ?</p>
				</div>
				<div class="modal-footer removeCategoriesFooter">
					<button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
					<button type="button" class="btn btn-primary" id="removeCategoriesBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!-- /categories brand -->


	<script src="custom/js/categories.js"></script>

	<?php require_once 'includes/footer.php'; ?>