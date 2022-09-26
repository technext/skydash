<?php

require_once 'core.php';

$sql = "SELECT * FROM rfid";

$result = $connect->query($sql);

$output = array('data' => array());
if ($result->num_rows > 0) {

    while ($row = $result->fetch_array()) {
        // $id = $row[0];
        // active 
        $rfidtag = $row[1];

        $value = $row[2];
        
        //$decrypt = base64_decode($value);

        $datetime = $row[3];

        // $button = '<!-- Single button -->
        // <div class="btn-group">
        // <button type="button" class="btn btn-info btn-rounded btn-fw">View</button>
        // </div>';



        $output['data'][] = array(
            // id
            // $id,
            //rfid tag value
            $rfidtag,
            //datetime
            $datetime,
            // encrypted value
            $value,
            // decrypted value
            //$decrypt
            //button
            // $button
        );
    } // /while 

} // if num_rows

$connect->close();

echo json_encode($output);
