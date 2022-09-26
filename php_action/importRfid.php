<?php
require_once 'db_connect.php';

insert_new_data($connect);
update_existing_data($connect);

function encryption($text)
{
    return base64_encode($text);

    // print_r($connect);
}

function insert_new_data($connect)
{
    //check if the writing file exists
    if (file_exists(RFID_WRTIE_FILE)) {
        //YES
        // import the csv into array
        if (($open = fopen(RFID_WRTIE_FILE, "r")) !== FALSE) {
            fgetcsv($open);
            while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                $csv[] = $data;
            }

            fclose($open);
        }
        // run a loop to insert data
        foreach ($csv as $data) {
            //skip if index 0 == "time"
            //cuz this is header of the csv
            if ($data[0] == "date_time") continue;

            // print_r($data);

            //$date_time         = DateTime::createFromFormat('d/m/Y H:i:s', $data[0]);
            $date_time = $data[0];
            $rfidtag_id     = $data[1];
            $value             = $data[2];
            print_r($date_time);
            // rfidtag_id, value and date_time
            $sql = "INSERT INTO rfid (rfidtag_id, value, date_time) VALUES ('$rfidtag_id', '$value', '$date_time')";
            // print_r($sql);
            // $connect->query($sql);
            if($connect->query($sql) === TRUE) {
                $valid['success'] = true;
                $valid['messages'] = "Successfully Added";	
            } else {
                $valid['success'] = false;
                $valid['messages'] = "Error while adding the detail";
            }
        }
        $connect->close();

        echo json_encode($valid);
        // $connect->close();

        //delete file after the loop
        unlink(RFID_WRTIE_FILE);
    }
}


function update_existing_data($connect)
{
    //check if the writing file exists
    if (file_exists(RFID_UPDATE_FILE)) {
        //YES
        // import the csv and change to csv
        // import the csv into array
        if (($open = fopen(RFID_UPDATE_FILE, "r")) !== FALSE) {
            fgetcsv($open);
            while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                $csv[] = $data;
            }

            fclose($open);
        }

        // run a loop to insert data
        foreach ($csv as $data) {
            //skip if index 0 == "time"
            //cuz this is header of the csv
            if ($data[0] == "Time") continue;
            //Insert data
            // $decryptedData = decryption($data[2]);
            $date_time         = $data[0];
            $rfidtag_id        = $data[1];
            $value             = $data[2];

            $sql = "UPDATE rfid SET value='$value', date_time='$date_time' WHERE rfidtag_id = '$rfidtag_id'";

            if($connect->query($sql) === TRUE) {
                $valid['success'] = true;
                $valid['messages'] = "Successfully Updated";	
            } else {
                $valid['success'] = false;
                $valid['messages'] = "Error while updated the detail";
            }
        }
        $connect->close();

        echo json_encode($valid);


        //delete file after the loop
        unlink(RFID_UPDATE_FILE);
    }
}
