<?php
//Parse the inputted number and then we can lookup the prefix in the db.

// Create connection by including a line like
// $con=mysqli_connect("hostname","user","password","db");
include '/home/its/mysql_config.php';

// Check connection
if (mysqli_connect_errno($con))  {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


if (strlen($_POST['cardNoField']) == 13) $numDigits=3;
else $numDigits=5;

$_POST['cardNoField'] = trim($_POST['cardNoField']);

$query="SELECT * FROM library l 
JOIN libraryprefixes lp ON l.record_index=lp.library_record_index
JOIN librarycom lc ON l.record_index=lc.library_record_index
WHERE lp.userid_prefix='".substr($_POST["cardNoField"], 0, $numDigits)."';";


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
			"libraryServerUrl" => $row['library_server_url'],
			"libraryServerPort" => $row['library_server_port'],
		);
	}
	
	/*	I can do the socket connection here and if it's all good, return the appropriate data. */
	/* PHP Socket Client */

	
	//Token/API Key
	$authorityToken="55u1dqzu4tfSk2V4u5PW6VTMqi9bzt2d";
	
	//In production, this should come from the librarycom table (in the $data array).
	$host = $data["libraryServerUrl"];
	$port = $data["libraryServerPort"];
	//Hangup string we send when we're done
	$hangup = "XX0";
	//Buffer length in bytes
	$bufferlen = 2048;

	//JSON formatted parameters for socket with newline to terminate
	$message=array(
		"code" => "GET_STATUS",
		"authorityToken" => $authorityToken,
		"customer" => "null"
	);
	/* If GET_STATUS is not okay, do error handling */
	$message=json_encode($message);
	//Add newline so the server knows when the message is done.
	$message.="\n";

	// 10s Timeout 
	set_time_limit(10);

	// Create Socket
	$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");

	// Connect to the server
	if ($result = socket_connect($socket, $host, $port) == false) {
		$data["error"]=true;
		$data["errorMsg"]="Can't connect to server $host";
		$data=json_encode($data);
		die ($data);
	};

	// Read initial server message/ack
	if ($result = socket_read($socket, $bufferlen) == false) {
		$data["error"]=true;
		$data["errorMsg"]="Can't read from server $host";
		$data=json_encode($data);
		die ($data);
	};
	//echo "<p><b>Initial message from server:</b><br />".$result."</p>";

	//Testing with Card No: "21221012345678", Pin: "64058","Billy, Balzac"
	$message=array(
		"code" => "GET_CUSTOMER",
		"authorityToken" => $authorityToken,
		"userId" => $port = $data["cardNumber"],
		"pin" => $data["pin"],
		"customer" => "null"
	);
	$message=json_encode($message);
	$message.="\n";

	//echo "<b>Sending Message:</b>\n<br />".$message;
	$result = (socket_write($socket, $message, strlen($message)));
	if ($result == false) {
		$data["error"]=true;
		$data["errorMsg"]="Could not send data to server $host";
		$data=json_encode($data);		
		die($data);
	}
	
	$result = socket_read ($socket, $bufferlen);
	if ($result == false) {
		$data["error"]=true;
		$data["errorMsg"]="Could not read server response";
		$data=json_encode($data);
		die($data);
	}
	//echo "<p><b>Reply From Server:</b><br />".$result."</p>";

	// Hang up socket connection
	socket_write($socket, $hangup, strlen($hangup)) or die("Could not send data to server\n");

	//Close the socket
	socket_close($socket);



	/* Do error handling here: no connection, invalid credentials, etc
	OK, SUCCESS, FAIL, ERROR, UNKNOWN, BUSY, UNAVAILABLE */

		/* Merge new JSON to the data I already have so I still have the library info. */
		$resultArr=json_decode($result, true);
		//echo $result;
		$data = array_merge_recursive($data, $resultArr);

		switch ($data["code"]) {
			case "FAIL";
			case "ERROR";
			case "UNKNOWN";
			case "UNAVAILABLE";
			case "UNAUTHORIZED";
				$data["error"]=true;
				$data["errorMsg"]=$data["responseMessage"];
				break;
		}
		
		$dataJSON=json_encode($data);
		echo $dataJSON;
	
	
/* If we can't match the card number to a library, return an error to that effect. */
} else {
	$data = array("error" => true, "errorMsg" => "Unknown card number");
	$dataJSON=json_encode($data);
	echo $dataJSON;
}

?>
