<?php 	



require_once 'core.php';

$sql = "SELECT product.product_id, product.product_name, product.brand_id,
 		product.categories_id, product.quantity, product.rate, product.active, product.status, 
 		brands.brand_name, categories.categories_name FROM product 
		INNER JOIN brands ON product.brand_id = brands.brand_id 
		INNER JOIN categories ON product.categories_id = categories.categories_id  
		WHERE product.status = 1";

$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $active = ""; 

 while($row = $result->fetch_array()) {
 	$productId = $row[0];

	//quantity
	if ($row[4] <= 10 ) {
		// product less than or equal 10 show warning
		$quantity = "<label class='badge badge-warning'>".$row[4]." Low</label>";
	} else {
		//show the quantity
		$quantity = $row[4];
	}

 	// active 
 	if($row[6] == 1) {
 		// activate member
 		$active = "<label class='badge badge-success'>Available</label>";
 	} else {
 		// deactivate member
 		$active = "<label class='badge badge-danger'>Not Available</label>";
 	} // /else

 	$button = '<!-- Single button -->
	<div class="btn-group">
	  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Action <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu">
	    <li><a type="button" data-toggle="modal" id="editProductModalBtn" data-target="#editProductModal" onclick="editProduct('.$productId.')"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
	    <li><a type="button" data-toggle="modal" data-target="#removeProductModal" id="removeProductModalBtn" onclick="removeProduct('.$productId.')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>       
	  </ul>
	</div>';

	$brand = $row[8];
	$category = $row[9];

 	$output['data'][] = array( 		
 		// product name
 		$row[1], 
 		// rate
 		'RM'.$row[5],
 		// quantity 
		// $row[4],
		$quantity, 		 	
 		// brand
 		$brand,
 		// category 		
 		$category,
 		// active
 		$active,
 		// button
 		$button 		
 		); 	
 } // /while 

}// if num_rows

$connect->close();

echo json_encode($output);