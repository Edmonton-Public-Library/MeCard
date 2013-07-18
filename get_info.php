<?php
//Parse the inputted number and then we can lookup the prefix in the db.

// Create connection by including a line like
// $con=mysqli_connect("hostname","user","password","db");
include '/home/its/mysql_config.php';


// Check connection
if (mysqli_connect_errno($con))  {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


$query="SELECT * FROM library l 
JOIN libraryprefixes lp ON l.record_index=lp.library_record_index
WHERE lp.userid_prefix='".substr($_POST["cardNoField"], 0, 5)."';";


$result = mysqli_query($con, $query);
if (mysqli_num_rows($result)>0) {

	while($row = mysqli_fetch_assoc($result)) {
		/* make an array of interesting variables to be JSON encoded */
		$data=array(
			"error" => false,
			"errorMsg" => "",
			"cardNumber" => $_POST['cardNoField'],
			"pin" => $_POST['pin'],
			"libraryName" => $row['library_name'],
			"libraryAddress" => $row['library_address'],
			"libraryProvince" => $row['library_province'],
			"libraryPostalCode" => $row['library_postal_code'],
			"libraryPhoneNumber" => $row['library_phone_number'],
			"libraryEmailAddress" => $row['library_email_address'],
			"libraryRecordIndex" => $row['library_record_index'],
			"randomNumber" => rand(0, 1000)
			
		);
	}
/* Perhaps I should pass a JSON structure back from here */
} else {
	$data = array("error" => true, "errorMsg" => "Unknown card number");
}

	$data=json_encode($data);
	echo $data;

?>
