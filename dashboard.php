<?php require_once 'includes/header.php'; ?>

<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
$date = date('d.M.Y');
$time = date('h:i a');
$day = date('D');

$user_id = $_SESSION['userId'];
$sqluser = "SELECT * FROM users WHERE user_id = {$user_id}";
$queryuser = $connect->query($sqluser);
$result = $queryuser->fetch_assoc();

$sql = "SELECT * FROM product WHERE status = 1";
$query = $connect->query($sql);
$countProduct = $query->num_rows;

$orderSql = "SELECT * FROM orders WHERE order_status = 1";
$orderQuery = $connect->query($orderSql);
$countOrder = $orderQuery->num_rows;

$GrandTotal = "SELECT SUM(paid) AS paid FROM orders WHERE order_status = 1";
$grandQuery1 = $connect->query($GrandTotal);
$countGrandTotal = $grandQuery1->num_rows;

$totalRevenue = "";
while ($grandResult = $grandQuery1->fetch_assoc()) {
	// $totalRevenue += ((int)$orderResult['paid']);
	$totalRevenue .= ($grandResult['paid']);
}

$lowStockSql = "SELECT * FROM product WHERE quantity <= 10 AND status = 1";
$lowStockQuery = $connect->query($lowStockSql);
$countLowStock = $lowStockQuery->num_rows;

$userwisesql = "SELECT users.username , SUM(orders.grand_total) as totalorder FROM orders INNER JOIN users ON orders.user_id = users.user_id WHERE orders.order_status = 1 GROUP BY orders.user_id";
$userwiseQuery = $connect->query($userwisesql);
$userwieseOrder = $userwiseQuery->num_rows;

$connect->close();

?>

<div class="main-panel">
	<div class="content-wrapper">
		<div class="row">
			<div class="col-md-12 grid-margin">
				<div class="row">
					<div class="col-12 col-xl-8 mb-4 mb-xl-0">
						<h3 class="font-weight-bold">Welcome <?php echo $result['username']; ?></h3>
						<h6 class="font-weight-normal mb-0">All systems are running smoothly!</h6>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 grid-margin stretch-card">
				<div class="card tale-bg">
					<div class="card-people mt-auto">
						<img src="images/dashboard/people.svg" alt="people">
						<div class="weather-info">
							<div class="d-flex">
								<div>
									<h2 class="mb-0 font-weight-normal"><?php echo $day; ?></h2>
								</div>
								<div class="ml-2">
									<h4 class="location font-weight-normal"><?php echo $date; ?></h4>
									<h6 class="font-weight-normal"><?php echo $time; ?></h6>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 grid-margin transparent">
				<div class="row">
					<?php if (isset($_SESSION['userId']) && $_SESSION['userId'] == 1) { ?>
						<div class="col-md-6 mb-4 stretch-card transparent">
							<div class="card card-tale">
								<div class="card-body" href="product.php">
									<p class="mb-4">Total Product</p>
									<p class="fs-30 mb-2"><?php echo $countProduct; ?></p>
									<a href="product.php" style="color:black;">View Product Details</a>
								</div>
							</div>
						</div>
						<div class="col-md-6 mb-4 stretch-card transparent">
							<div class="card card-dark-blue">
								<div class="card-body">
									<p class="mb-4">Low Stock</p>
									<p class="fs-30 mb-2"><?php echo $countLowStock; ?></p>
									<a href="product.php" style="color:black;">View Product Details</a>
								</div>
							</div>
						</div>
				</div>

				<div class="row">
					<div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
						<div class="card card-light-blue">
							<div class="card-body">
								<p class="mb-4">Total Order</p>
								<p class="fs-30 mb-2"><?php echo $countOrder; ?></p>
								<a href="orders.php?o=manord" style="color:black;">View Total Order</a>
							</div>
						</div>
					</div>
				<?php } ?>
				<div class="col-md-6 stretch-card transparent">
					<div class="card card-light-danger">
						<div class="card-body">
							<p class="mb-4">Total Revenue</p>
							<p class="fs-30 mb-2"><?php if ($totalRevenue) {
														echo 'RM' . number_format((float)$totalRevenue, 2, '.', ''); // preview in two decimals place
														// echo 'FK';
													} else {
														echo 'RM0';
													} ?></p>
							<!-- <p>0.22% (30 days)</p> -->
						</div>
					</div>
				</div>
				</div>

			</div>
		</div>
		<?php if (isset($_SESSION['userId']) && $_SESSION['userId'] == 1) { ?>
			<div class="row">
				<div class="col-md-12 grid-margin stretch-card">
					<div class="card">
						<div class="card-body">
							<p class="card-title">User Wise Order</p>
							<div class="row">
								<div class="col-12">
									<div class="table-responsive">
										<table id="example" class="display expandable-table" style="width:100%">
											<thead>
												<tr>
													<th>User Name</th>
													<th>Orders (RM)</th>
												</tr>
											</thead>
											<tbody>
												<?php while ($orderResult = $userwiseQuery->fetch_assoc()) { ?>
													<tr>
														<td><?php echo $orderResult['username'] ?></td>
														<td><?php echo number_format((float)$orderResult['totalorder'], 2, '.', ''); ?></td>

													</tr>

												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>


				</div>
			</div>
		<?php  } ?>
	</div>
	<?php require_once 'includes/footer.php'; ?>
