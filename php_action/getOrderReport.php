<?php

require_once 'core.php';
// print_r($_POST);
if ($_POST) {
	$start_date = $_POST['startDate'];
	$end_date = $_POST['endDate'];

	$sql = "SELECT * FROM orders WHERE order_date >= '$start_date' AND order_date <= '$end_date' and order_status = 1";
	$query = $connect->query($sql);
	$totalsql = "SELECT SUM(paid) AS paid FROM orders WHERE order_date >= '$start_date' AND order_date <= '$end_date' and order_status = 1";
	$totalQuery1 = $connect->query($totalsql);
	$countTotal = $totalQuery1->num_rows;

	$totalamount = "";
	while ($totalResult = $totalQuery1->fetch_assoc()) {
		// $totalRevenue += ((int)$orderResult['paid']);
		$totalamount .= ($totalResult['paid']);
	}

	$table = '
	<table border="1" cellspacing="0" cellpadding="0" style="width:100%;">
		<tr>
			<th>Order Date</th>
			<th>Client Name</th>
			<th>Contact</th>
			<th>Grand Total</th>
		</tr>

		<tr>';
	$totalAmount = "";
	while ($result = $query->fetch_assoc()) {
		$table .=
			'<tr>
				<td><center>' . $result['order_date'] . '</center></td>
				<td><center>' . $result['client_name'] . '</center></td>
				<td><center>' . $result['client_contact'] . '</center></td>
				<td><center>' . $result['grand_total'] . '</center></td>
			</tr>';
		// $totalAmount .= $result['grand_total'];
	}
	$table .= '
		</tr>

		<tr>
			<td colspan="3"><center>Total Amount</center></td>
			<td><center>' . number_format((float)$totalamount, 2, '.', '') . '</center></td>
		</tr>
	</table>
	';

	echo $table;
}
// <td><center>'.sprintf('%.2f',$totalAmount).'</center></td>
