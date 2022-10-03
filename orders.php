<?php
require_once 'php_action/db_connect.php';
require_once 'includes/header.php';
if ($_GET['o'] == 'add') {
	// add order
	echo "<div class='div-request div-hide' style='display:none;'>add</div>";
} else if ($_GET['o'] == 'manord') {
	echo "<div class='div-request div-hide' style='display:none;'>manord</div>";
} else if ($_GET['o'] == 'editOrd') {
	echo "<div class='div-request div-hide' style='display:none;'>editOrd</div>";
} // /else manage order
?>

<div class="main-panel">
	<div class="content-wrapper">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i>
							<?php if ($_GET['o'] == 'add') { ?>
								<i class="glyphicon glyphicon-plus-sign"></i> Add Order
							<?php } else if ($_GET['o'] == 'manord') { ?>
								<i class="glyphicon glyphicon-edit"></i> Manage Order
							<?php } else if ($_GET['o'] == 'editOrd') { ?>
								<i class="glyphicon glyphicon-edit"></i> Edit Order
							<?php } ?>
							<br><br><br>
						</div>
					</div> <!-- /panel-heading -->
					<div class="panel-body">

						<?php if ($_GET['o'] == 'add') {
							// add order
						?>

							<div class="success-messages"></div>
							<!--/success-messages-->

							<form class="form-horizontal" method="POST" action="php_action/createOrder.php" id="createOrderForm">

								<div class="form-group row">
									<label for="orderDate" class="col-sm-2 control-label">Order Date</label>
									<div class="col-sm-9">
										<input type="date" class="form-control" id="orderDate" name="orderDate" autocomplete="off" />
									</div>
								</div>
								<!--/form-group-->
								<div class="form-group row">
									<label for="clientName" class="col-sm-2 control-label">Client Name</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="clientName" name="clientName" placeholder="Client Name" autocomplete="off" />
									</div>
								</div>
								<!--/form-group-->
								<div class="form-group row">
									<label for="clientContact" class="col-sm-2 control-label">Client Contact</label>
									<div class="col-sm-9">
										<input type="tel" class="form-control" id="clientContact" name="clientContact" placeholder="Contact Number (e.g. 012-3456789)" autocomplete="off" pattern="[0-9]{3}-[0-9]{3}[0-9]{4}" maxlength="11" />
									</div>
								</div>
								<!--/form-group-->
								<div class="form-group row">
									<label for="clientIC" class="col-sm-2 control-label">Client IC / Passport Number</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="clientIC" name="clientIC" placeholder="Client IC" autocomplete="off" />
									</div>
								</div>
								<!--/form-group-->

								<table class="table" id="productTable">
									<thead>
										<tr>
											<th style="width:40%;">Product</th>
											<th style="width:20%;">Rate</th>
											<th style="width:10%;">Available Quantity</th>
											<th style="width:10%;">Quantity <br><small>(Enter to update amt)</small></th>
											<th style="width:20%;">Total</th>
											<th style="width:10%;"></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$arrayNumber = 0;
										for ($x = 1; $x < 2; $x++) { ?>
											<tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">
												<td style="margin-left:20px;">
													<div class="form-group">

														<select class="form-control" name="productName[]" id="productName<?php echo $x; ?>" onchange="getProductData(<?php echo $x; ?>)">
															<option value="">~~SELECT~~</option>
															<?php
															$productSql = "SELECT * FROM product WHERE active = 1 AND status = 1 AND quantity != 0";
															$productData = $connect->query($productSql);

															while ($row = $productData->fetch_array()) {
																echo "<option value='" . $row['product_id'] . "' id='changeProduct" . $row['product_id'] . "'>" . $row['product_name'] . "</option>";
															} // /while 

															?>
														</select>
													</div>
												</td>
												<td style="padding-left:20px;">
													<div class="form-group">
														<input type="text" name="rate[]" id="rate<?php echo $x; ?>" autocomplete="off" disabled="true" class="form-control" />
														<input type="hidden" name="rateValue[]" id="rateValue<?php echo $x; ?>" autocomplete="off" class="form-control" />
													</div>
												</td>
												<td style="padding-left:20px;">
													<div class="form-group">
														<p id="available_quantity<?php echo $x; ?>"></p>
													</div>
												</td>
												<td style="padding-left:20px;">
													<div class="form-group">
														<input type="number" name="quantity[]" id="quantity<?php echo $x; ?>" onkeyup="getTotal(<?php echo $x ?>)" autocomplete="off" class="form-control" min="1" />
													</div>
												</td>
												<td style="padding-left:20px;">
													<div class="form-group">
														<input type="text" name="total[]" id="total<?php echo $x; ?>" autocomplete="off" class="form-control" disabled="true" />
														<input type="hidden" name="totalValue[]" id="totalValue<?php echo $x; ?>" autocomplete="off" class="form-control" />
													</div>
												</td>
												<td>
													<div class="form-group">
														<button class="btn btn-danger removeProductRowBtn" type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i>Remove</button>
													</div>
												</td>
											</tr>
										<?php
											$arrayNumber++;
										} // /for
										?>
									</tbody>
								</table>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<label for="subTotal" class="col-sm-3 control-label">Sub Amount</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="subTotal" name="subTotal" disabled="true" />
												<input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue" />
											</div>
										</div>
									</div>
									<!--/col-md-6-->

									<div class="col-md-6">
										<div class="form-group row">
											<label for="paid" class="col-sm-3 control-label">Paid Amount</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="paid" name="paid" autocomplete="off" onkeyup="paidAmount()" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '1');"/>
											</div>
										</div>
									</div>
									<!--/col-md-6-->
								</div>
								<!--/row-->

								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<label for="totalAmount" class="col-sm-3 control-label">Total Amount</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="totalAmount" name="totalAmount" disabled="true" />
												<input type="hidden" class="form-control" id="totalAmountValue" name="totalAmountValue" />
											</div>
										</div>
									</div>
									<!--/col-md-6-->

									<div class="col-md-6">
										<div class="form-group row">
											<label for="due" class="col-sm-3 control-label">Due Amount</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="due" name="due" disabled="true" />
												<input type="hidden" class="form-control" id="dueValue" name="dueValue" />
											</div>
										</div>
									</div>
									<!--/col-md-6-->
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<label for="discount" class="col-sm-3 control-label">Discount</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="discount" name="discount" onkeyup="discountFunc()" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '1');"/>
											</div>
										</div>
									</div>
									<!--/col-md-6-->
									<div class="col-md-6">
										<div class="form-group row">
											<label for="clientContact" class="col-sm-3 control-label">Payment Type</label>
											<div class="col-sm-9">
												<select class="form-control" name="paymentType" id="paymentType">
													<option value="">~~SELECT~~</option>
													<option value="1">Cheque</option>
													<option value="2">Cash</option>
													<option value="3">Credit Card</option>
												</select>
											</div>
										</div>
									</div>
									<!--/col-md-6-->
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<label for="grandTotal" class="col-sm-3 control-label">Grand Total</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="grandTotal" name="grandTotal" disabled="true" />
												<input type="hidden" class="form-control" id="grandTotalValue" name="grandTotalValue" />
											</div>
										</div>
									</div>
									<!--/col-md-6-->
									<div class="col-md-6">
										<div class="form-group row">
											<label for="clientContact" class="col-sm-3 control-label">Payment Status</label>
											<div class="col-sm-9">
												<select class="form-control" name="paymentStatus" id="paymentStatus">
													<option value="">~~SELECT~~</option>
													<option value="1">Full Payment</option>
													<option value="2">Advance Payment</option>
													<option value="3">No Payment</option>
												</select>
											</div>
										</div>
									</div>
									<!--/col-md-6-->
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<label for="vat" class="col-sm-3 control-label gst">GST 18%</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="vat" name="gstn" readonly="true" />
												<input type="hidden" class="form-control" id="vatValue" name="vatValue" />
											</div>
										</div>
									</div>
									<!--/col-md-6-->
									<div class="col-md-6">
										<div class="form-group row">
											<label for="clientContact" class="col-sm-3 control-label">Payment Place</label>
											<div class="col-sm-9">
												<select class="form-control" name="paymentPlace" id="paymentPlace">
													<option value="">~~SELECT~~</option>
													<option value="1">Inside Valley</option>
													<option value="2">Out of Valley</option>
												</select>
											</div>
										</div>
									</div>
									<!--/col-md-6-->
								</div>

								<div class="form-group submitButtonFooter">
									<div class="col-sm-offset-2 col-sm-10">
										<button type="button" class="btn btn-success" onclick="addRow()" id="addRowBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-plus-sign"></i> Add Row </button>

										<button type="submit" id="createOrderBtn" data-loading-text="Loading..." class="btn btn-success"><i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>

										<button type="reset" class="btn btn-danger" onclick="resetOrderForm()"><i class="glyphicon glyphicon-erase"></i> Reset</button>
									</div>
								</div>
							</form>
						<?php } else if ($_GET['o'] == 'manord') {
							// manage order
						?>

							<div id="success-messages"></div>
							<div class="table-responsive">
								<table class="display expandable-table" id="manageOrderTable" style="width:100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Order Date</th>
											<th>Client</th>
											<th>Contact</th>
											<th>Encrypted Code</th>
											<th>Total Order Item</th>
											<th>Payment Status</th>
											<th>Options</th>
										</tr>
									</thead>
								</table>
							</div>
						<?php
							// /else manage order
						} else if ($_GET['o'] == 'editOrd') {
							// get order
						?>

							<div class="success-messages"></div>
							<!--/success-messages-->

							<form class="form-horizontal" method="POST" action="php_action/editOrder.php" id="editOrderForm">

								<?php $orderId = $_GET['i'];

								$sql = "SELECT orders.order_id, orders.order_date, orders.client_name, orders.client_contact, orders.client_ic, orders.sub_total, orders.vat, orders.total_amount, orders.discount, orders.grand_total, orders.paid, orders.due, orders.payment_type, orders.payment_status,orders.payment_place,orders.gstn FROM orders 	
					WHERE orders.order_id = {$orderId}";
								$result = $connect->query($sql);
								$data = $result->fetch_row();
								?>

								<div class="form-group row">
									<label for="orderDate" class="col-sm-2 control-label">Order Date</label>
									<div class="col-sm-9">
										<input type="date" class="form-control" id="orderDate" name="orderDate" autocomplete="off" value="<?php echo $data[1] ?>" />
									</div>
								</div>
								<!--/form-group-->
								<div class="form-group row">
									<label for="clientName" class="col-sm-2 control-label">Client Name</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="clientName" name="clientName" placeholder="Client Name" autocomplete="off" value="<?php echo $data[2] ?>" />
									</div>
								</div>
								<!--/form-group-->
								<div class="form-group row">
									<label for="clientContact" class="col-sm-2 control-label">Client Contact</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="clientContact" name="clientContact" placeholder="Contact Number" autocomplete="off" value="<?php echo $data[3] ?>" />
									</div>
								</div>
								<!--/form-group-->
								<div class="form-group row">
									<label for="clientIC" class="col-sm-2 control-label">Client IC / Passport Number</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="clientIC" name="clientIC" placeholder="clientIC" autocomplete="off" value="<?php echo base64_decode($data[4]) ?>"/>
									</div>
								</div>
								<!--/form-group-->
								<div class="table-responsive">
									<table class="table" id="productTable">
										<thead>
											<tr>
												<th style="width:40%;">Product</th>
												<th style="width:20%;">Rate</th>
												<th style="width:10%;">Available Quantity</th>
												<th style="width:10%;">Quantity <br><small>(Enter to update amt)</small></th>
												<th style="width:20%;">Total</th>
												<th style="width:10%;"></th>
											</tr>
										</thead>
										<tbody>

											<?php

											$orderItemSql = "SELECT order_item.order_item_id, order_item.order_id, order_item.product_id, order_item.quantity, order_item.rate, order_item.total FROM order_item WHERE order_item.order_id = {$orderId}";
											$orderItemResult = $connect->query($orderItemSql);
											// $orderItemData = $orderItemResult->fetch_all();						

											// print_r($orderItemData);
											$arrayNumber = 0;
											// for($x = 1; $x <= count($orderItemData); $x++) {
											$x = 1;
											while ($orderItemData = $orderItemResult->fetch_array()) {
												// print_r($orderItemData); 
											?>
												<tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">
													<td style="margin-left:20px;">
														<div class="form-group">

															<select class="form-control" name="productName[]" id="productName<?php echo $x; ?>" onchange="getProductData(<?php echo $x; ?>)">
																<option value="">~~SELECT~~</option>
																<?php
																$productSql = "SELECT * FROM product WHERE active = 1 AND status = 1 AND quantity != 0";
																$productData = $connect->query($productSql);

																while ($row = $productData->fetch_array()) {
																	$selected = "";
																	if ($row['product_id'] == $orderItemData['product_id']) {
																		$selected = "selected";
																	} else {
																		$selected = "";
																	}

																	echo "<option value='" . $row['product_id'] . "' id='changeProduct" . $row['product_id'] . "' " . $selected . " >" . $row['product_name'] . "</option>";
																} // /while 

																?>
															</select>
														</div>
													</td>
													<td style="padding-left:20px;">
														<div class="form-group">
															<input type="text" name="rate[]" id="rate<?php echo $x; ?>" autocomplete="off" disabled="true" class="form-control" value="<?php echo $orderItemData['rate']; ?>" />
															<input type="hidden" name="rateValue[]" id="rateValue<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php echo $orderItemData['rate']; ?>" />
														</div>
													</td>
													<td style="padding-left:20px;">
														<div class="form-group">
															<?php
															$productSql = "SELECT * FROM product WHERE active = 1 AND status = 1 AND quantity != 0";
															$productData = $connect->query($productSql);

															while ($row = $productData->fetch_array()) {
																$selected = "";
																if ($row['product_id'] == $orderItemData['product_id']) {
																	echo "<p id='available_quantity" . $row['product_id'] . "'>" . $row['quantity'] . "</p>";
																} else {
																	$selected = "";
																}

																//echo "<option value='".$row['product_id']."' id='changeProduct".$row['product_id']."' ".$selected." >".$row['product_name']."</option>";
															} // /while 

															?>

														</div>
													</td>
													<td style="padding-left:20px;">
														<div class="form-group">
															<input type="number" name="quantity[]" id="quantity<?php echo $x; ?>" onkeyup="getTotal(<?php echo $x ?>)" autocomplete="off" class="form-control" min="1" value="<?php echo $orderItemData['quantity']; ?>" />
														</div>
													</td>
													<td style="padding-left:20px;">
														<div class="form-group">
															<input type="text" name="total[]" id="total<?php echo $x; ?>" autocomplete="off" class="form-control" disabled="true" value="<?php echo $orderItemData['total']; ?>" />
															<input type="hidden" name="totalValue[]" id="totalValue<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php echo $orderItemData['total']; ?>" />
														</div>
													</td>
													<td>
														<div class="form-group">
															<button class="btn btn-danger removeProductRowBtn" type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i>Remove</button>
														</div>
													</td>
												</tr>
											<?php
												$arrayNumber++;
												$x++;
											} // /for
											?>
										</tbody>
									</table>
									<div class="col-md-12">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="subTotal" class="col-sm-3 control-label">Sub Amount</label>
													<div class="col-sm-9">
														<input type="text" class="form-control" id="subTotal" name="subTotal" disabled="true" value="<?php echo $data[5] ?>" />
														<input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue" value="<?php echo $data[5] ?>" />
													</div>
												</div>
											</div>
											<!--/col-md-6-->

											<div class="col-md-6">
												<div class="form-group row">
													<label for="paid" class="col-sm-3 control-label">Paid Amount</label>
													<div class="col-sm-9">
														<input type="text" class="form-control" id="paid" name="paid" autocomplete="off" onkeyup="paidAmount()" value="<?php echo $data[10] ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '1');"/>
													</div>
												</div>
											</div>
											<!--/col-md-6-->
										</div>
										<!--/row-->

										<div class="row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="totalAmount" class="col-sm-3 control-label">Total Amount</label>
													<div class="col-sm-9">
														<input type="text" class="form-control" id="totalAmount" name="totalAmount" disabled="true" value="<?php echo $data[7] ?>" />
														<input type="hidden" class="form-control" id="totalAmountValue" name="totalAmountValue" value="<?php echo $data[7] ?>" />
													</div>
												</div>
											</div>
											<!--/col-md-6-->

											<div class="col-md-6">
												<div class="form-group row">
													<label for="due" class="col-sm-3 control-label">Due Amount</label>
													<div class="col-sm-9">
														<input type="text" class="form-control" id="due" name="due" disabled="true" value="<?php echo $data[11] ?>"/>
														<input type="hidden" class="form-control" id="dueValue" name="dueValue" value="<?php echo $data[11] ?>" />
													</div>
												</div>
											</div>
											<!--/col-md-6-->
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="discount" class="col-sm-3 control-label">Discount</label>
													<div class="col-sm-9">
														<input type="text" class="form-control" id="discount" name="discount" onkeyup="discountFunc()" autocomplete="off" value="<?php echo $data[8] ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '1');"/>
													</div>
												</div>
											</div>
											<!--/col-md-6-->
											<div class="col-md-6">
												<div class="form-group row">
													<label for="clientContact" class="col-sm-3 control-label">Payment Type</label>
													<div class="col-sm-9">
														<select class="form-control" name="paymentType" id="paymentType">
															<option value="1" <?php if ($data[12] == 1) {
																					echo "selected";
																				} ?>>Cheque</option>
															<option value="2" <?php if ($data[12] == 2) {
																					echo "selected";
																				} ?>>Cash</option>
															<option value="3" <?php if ($data[12] == 3) {
																					echo "selected";
																				} ?>>Credit Card</option>
														</select>
													</div>
												</div>
											</div>
											<!--/col-md-6-->
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="grandTotal" class="col-sm-3 control-label">Grand Total</label>
													<div class="col-sm-9">
														<input type="text" class="form-control" id="grandTotal" name="grandTotal" disabled="true" value="<?php echo $data[9] ?>" />
														<input type="hidden" class="form-control" id="grandTotalValue" name="grandTotalValue" value="<?php echo $data[9] ?>" />
													</div>
												</div>
											</div>
											<!--/col-md-6-->
											<div class="col-md-6">
												<div class="form-group row">
													<label for="clientContact" class="col-sm-3 control-label">Payment Status</label>
													<div class="col-sm-9">
														<select class="form-control" name="paymentStatus" id="paymentStatus">
															<option value="">~~SELECT~~</option>
															<option value="1" <?php if ($data[13] == 1) {
																					echo "selected";
																				} ?>>Full Payment</option>
															<option value="2" <?php if ($data[13] == 2) {
																					echo "selected";
																				} ?>>Advance Payment</option>
															<option value="3" <?php if ($data[13] == 3) {
																					echo "selected";
																				} ?>>No Payment</option>
														</select>
													</div>
												</div>
											</div>
											<!--/col-md-6-->
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group row">
													<label for="vat" class="col-sm-3 control-label gst"><?php if ($data[14] == 2) {
																											echo "IGST 18%";
																										} else echo "GST 18%"; ?></label>
													<div class="col-sm-9">
														<input type="text" class="form-control" id="vat" name="gstn" readonly="true" value="<?php echo $data[6] ?>" />
														<input type="hidden" class="form-control" id="vatValue" name="vatValue" value="<?php echo $data[6] ?>" />
													</div>
												</div>
											</div>
											<!--/col-md-6-->
											<div class="col-md-6">
												<div class="form-group row">
													<label for="clientContact" class="col-sm-3 control-label">Payment Place</label>
													<div class="col-sm-9">
														<select class="form-control" name="paymentPlace" id="paymentPlace">
															<option value="">~~SELECT~~</option>
															<option value="1" <?php if ($data[14] == 1) {
																					echo "selected";
																				} ?>>Inside Valley</option>
															<option value="2" <?php if ($data[14] == 2) {
																					echo "selected";
																				} ?>>Out of Valley</option>
														</select>
													</div>
												</div>
											</div>
											<!--/col-md-6-->
										</div>
									</div>

									<div class="form-group editButtonFooter">
										<div class="col-sm-offset-2 col-sm-10">
											<button type="button" class="btn btn-success" onclick="addRow()" id="addRowBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-plus-sign"></i> Add Row </button>

											<input type="hidden" name="orderId" id="orderId" value="<?php echo $_GET['i']; ?>" />

											<button type="submit" id="editOrderBtn" data-loading-text="Loading..." class="btn btn-success"><i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>

										</div>
									</div>
								</div>
							</form>

						<?php
						} // /get order else  
						?>
					</div> <!-- /panel-body -->
				</div> <!-- /panel -->
				<!-- edit order -->
				<div class="modal fade" tabindex="-1" role="dialog" id="paymentOrderModal">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title"><i class="glyphicon glyphicon-edit"></i> Edit Payment</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							</div>

							<div class="modal-body form-horizontal" style="max-height:500px; overflow:auto;">

								<div class="paymentOrderMessages"></div>


								<div class="form-group row">
									<label for="due" class="col-sm-3 control-label">Due Amount</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="due" name="due" disabled="true" />
									</div>
								</div>
								<!--/form-group-->
								<div class="form-group row">
									<label for="payAmount" class="col-sm-3 control-label">Pay Amount</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="payAmount" name="payAmount" />
									</div>
								</div>
								<!--/form-group-->
								<div class="form-group row">
									<label for="clientContact" class="col-sm-3 control-label">Payment Type</label>
									<div class="col-sm-9">
										<select class="form-control" name="paymentType" id="paymentType">
											<option value="">~~SELECT~~</option>
											<option value="1">Cheque</option>
											<option value="2">Cash</option>
											<option value="3">Credit Card</option>
										</select>
									</div>
								</div>
								<!--/form-group-->
								<div class="form-group row">
									<label for="clientContact" class="col-sm-3 control-label">Payment Status</label>
									<div class="col-sm-9">
										<select class="form-control" name="paymentStatus" id="paymentStatus">
											<option value="">~~SELECT~~</option>
											<option value="1">Full Payment</option>
											<option value="2">Advance Payment</option>
											<option value="3">No Payment</option>
										</select>
									</div>
								</div>
								<!--/form-group-->

							</div>
							<!--/modal-body-->
							<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
								<button type="button" class="btn btn-primary" id="updatePaymentOrderBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save changes</button>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
				<!-- /edit order-->

				<!-- remove order -->
				<div class="modal fade" tabindex="-1" role="dialog" id="removeOrderModal">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remove Order</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							</div>
							<div class="modal-body">

								<div class="removeOrderMessages"></div>

								<p>Do you really want to remove ?</p>
							</div>
							<div class="modal-footer removeProductFooter">
								<button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
								<button type="button" class="btn btn-primary" id="removeOrderBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save changes</button>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
				<!-- /remove order-->
			</div> <!-- /col-md-12 -->
		</div> <!-- /row -->
	</div> <!-- /content-wrapper -->


	<script src="custom/js/order.js"></script>

	<?php require_once 'includes/footer.php'; ?>
