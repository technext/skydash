var viewRFIDTable;

$(document).ready(function () {
	// top nav bar 
	// $('#topNavUser').addClass('active');
	// manage user data table
	viewRFIDTable = $('#viewRFIDTable').DataTable({
		'ajax': 'php_action/fetchRfid.php',
		'order': []
	});
});