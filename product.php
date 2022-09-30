<?php require_once 'php_action/db_connect.php' ?>
<?php require_once 'includes/header.php'; ?>

<!-- <style>
	ul li {
		margin-left: 15px;
	}

	ul li:first-child {
		margin-left: 15px;
	}
</style> -->
<div class="main-panel">
	<div class="content-wrapper">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Manage Product</div>
					</div> <!-- /panel-heading -->
					<div class="panel-body">

						<div class="remove-messages"></div>
						<button class="btn btn-success button1" style="float:right;" data-toggle="modal" id="addProductModalBtn" data-target="#addProductModal"> <i class="glyphicon glyphicon-plus-sign"></i> Add Product </button>
						<br><br><br>
						<div class="table-responsive">
							<table class="display expandable-table" id="manageProductTable" style="width:100%">
								<thead>
									<tr>
										<!-- <th style="width:10%;">Photo</th> -->
										<th>Product Name</th>
										<th>Rate</th>
										<th>Quantity</th>
										<th>Brand</th>
										<th>Category</th>
										<th>Status</th>
										<th style="width:15%;">Options</th>
									</tr>
								</thead>
							</table>
							<!-- /table -->
						</div> <!-- /table-responsive -->
					</div> <!-- /panel-body -->
				</div> <!-- /panel -->
			</div> <!-- /col-md-12 -->
		</div> <!-- /row -->
	</div> <!-- /content-wrapper -->

	<!-- add product -->
	<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">

				<form class="form-horizontal" id="submitProductForm" action="php_action/createProduct.php" method="POST" enctype="multipart/form-data">
					<div class="modal-header">
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add Product</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>

					<div class="modal-body" style="max-height:450px; overflow:auto;">

						<div id="add-product-messages"></div>

						<div class="form-group row">
							<label for="productName" class="col-sm-3 control-label">Product Name: </label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="productName" placeholder="Product Name" name="productName" autocomplete="off">
							</div>
						</div> <!-- /form-group-->

						<div class="form-group row">
							<label for="quantity" class="col-sm-3 control-label">Quantity: </label>
							<div class="col-sm-9">
								<input type="number" class="form-control" id="quantity" placeholder="Quantity" name="quantity" autocomplete="off" min="0">
							</div>
						</div> <!-- /form-group-->

						<div class="form-group row">
							<label for="rate" class="col-sm-3 control-label">Rate: </label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="rate" placeholder="Rate" name="rate" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '1');">
							</div>
						</div> <!-- /form-group-->

						<div class="form-group row">
							<label for="brandName" class="col-sm-3 control-label">Brand Name: </label>
							<div class="col-sm-9">
								<select class="form-control" id="brandName" name="brandName">
									<option value="">~~SELECT~~</option>
									<?php
									$sql = "SELECT brand_id, brand_name, brand_active, brand_status FROM brands WHERE brand_status = 1 AND brand_active = 1";
									$result = $connect->query($sql);

									while ($row = $result->fetch_array()) {
										echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
									} // while

									?>
								</select>
							</div>
						</div> <!-- /form-group-->

						<div class="form-group row">
							<label for="categoryName" class="col-sm-3 control-label">Category Name: </label>
							<div class="col-sm-9">
								<select type="text" class="form-control" id="categoryName" placeholder="Product Name" name="categoryName">
									<option value="">~~SELECT~~</option>
									<?php
									$sql = "SELECT categories_id, categories_name, categories_active, categories_status FROM categories WHERE categories_status = 1 AND categories_active = 1";
									$result = $connect->query($sql);

									while ($row = $result->fetch_array()) {
										echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
									} // while

									?>
								</select>
							</div>
						</div> <!-- /form-group-->

						<div class="form-group row">
							<label for="productStatus" class="col-sm-3 control-label">Status: </label>
							<div class="col-sm-9">
								<select class="form-control" id="productStatus" name="productStatus">
									<option value="">~~SELECT~~</option>
									<option value="1">Available</option>
									<option value="2">Not Available</option>
								</select>
							</div>
						</div> <!-- /form-group-->
					</div> <!-- /modal-body -->

					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>

						<button type="submit" class="btn btn-primary" id="createProductBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
					</div> <!-- /modal-footer -->
				</form> <!-- /.form -->
			</div> <!-- /modal-content -->
		</div> <!-- /modal-dailog -->
	</div>
	<!-- /add categories -->


	<!-- edit categories brand -->
	<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<h4 class="modal-title"><i class="fa fa-edit"></i> Edit Product</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body" style="max-height:450px; overflow:auto;">

					<div class="div-loading">
						<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
						<span class="sr-only">Loading...</span>
					</div>

					<!-- <div class="div-result"> -->

						<form class="form-horizontal" id="editProductForm" action="php_action/editProduct.php" method="POST">

							<div id="edit-product-messages"></div>

							<div class="form-group row">
								<label for="editProductName" class="col-sm-3 control-label">Product Name: </label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="editProductName" placeholder="Product Name" name="editProductName" autocomplete="off">
								</div>
							</div> <!-- /form-group-->

							<div class="form-group row">
								<label for="editQuantity" class="col-sm-3 control-label">Quantity: </label>
								<div class="col-sm-9">
									<input type="number" class="form-control" id="editQuantity" placeholder="Quantity" name="editQuantity" autocomplete="off" min="0">
								</div>
							</div> <!-- /form-group-->

							<div class="form-group row">
								<label for="editRate" class="col-sm-3 control-label">Rate: </label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="editRate" placeholder="Rate" name="editRate" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '1');">
								</div>
							</div> <!-- /form-group-->

							<div class="form-group row">
								<label for="editBrandName" class="col-sm-3 control-label">Brand Name: </label>
								<div class="col-sm-9">
									<select class="form-control" id="editBrandName" name="editBrandName">
										<option value="">~~SELECT~~</option>
										<?php
										$sql = "SELECT brand_id, brand_name, brand_active, brand_status FROM brands WHERE brand_status = 1 AND brand_active = 1";
										$result = $connect->query($sql);

										while ($row = $result->fetch_array()) {
											echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
										} // while

										?>
									</select>
								</div>
							</div> <!-- /form-group-->

							<div class="form-group row">
								<label for="editCategoryName" class="col-sm-3 control-label">Category Name: </label>
								<div class="col-sm-9">
									<select type="text" class="form-control" id="editCategoryName" name="editCategoryName">
										<option value="">~~SELECT~~</option>
										<?php
										$sql = "SELECT categories_id, categories_name, categories_active, categories_status FROM categories WHERE categories_status = 1 AND categories_active = 1";
										$result = $connect->query($sql);

										while ($row = $result->fetch_array()) {
											echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
										} // while

										?>
									</select>
								</div>
							</div> <!-- /form-group-->

							<div class="form-group row">
								<label for="editProductStatus" class="col-sm-3 control-label">Status: </label>
								<div class="col-sm-9">
									<select class="form-control" id="editProductStatus" name="editProductStatus">
										<option value="">~~SELECT~~</option>
										<option value="1">Available</option>
										<option value="2">Not Available</option>
									</select>
								</div>
							</div> <!-- /form-group-->

							<div class="modal-footer editProductFooter">
								<button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>

								<button type="submit" class="btn btn-success" id="editProductBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
							</div> <!-- /modal-footer -->
						</form> <!-- /.form -->
						<!-- </div> -->
						<!-- /product info -->
						<!-- </div> -->

					<!-- </div> -->

				</div> <!-- /modal-body -->


			</div>
			<!-- /modal-content -->
		</div>
		<!-- /modal-dailog -->
	</div>
	<!-- /categories brand -->

	<!-- categories brand -->
	<div class="modal fade" tabindex="-1" role="dialog" id="removeProductModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remove Product</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">

					<div class="removeProductMessages"></div>

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


	<script src="custom/js/product.js"></script>

	<?php require_once 'includes/footer.php'; ?>
