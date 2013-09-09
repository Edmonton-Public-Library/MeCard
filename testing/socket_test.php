<html>
<body>
<?php

/* socket_send-receive sends a message to a socket by doing the following:
-accept a series of key-value pairs ($message)
-serializes them with JSON_encode
-Appends a \n to terminate the string
-performs a socket write with our message
-receives the message (socket_read) and returns it.

*/
function epl_socket_send($message){
	
}



/* PHP Socket Client */

//Set host/port & other variables
$host = "ilsdev1.epl.ca";
$host = "edpl-t.library.ualberta.ca";
$port = 2004;
//Hangup string we send when we're done
$hangup = "XX0";
//Buffer length in bytes
$bufferlen = 2048;

//JSON formatted parameters for socket with newline to terminate
$message=array(
	"code" => "GET_STATUS",
	"authorityToken" => "55u1dqzu4tfSk2V4u5PW6VTMqi9bzt2d",
	"customer" => "null"
);
$message=json_encode($message);
//Add newline so the server knows when the message is done.
$message.="\n";


// 10s Timeout 
set_time_limit(10);

// Create Socket
$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");

// Connect to the server
$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");

// Read initial server message/ack
$result = socket_read($socket, $bufferlen) or die("Could not read from server\n");
echo "<p><b>Initial message from server:</b><br />".$result."</p>";

// Write to server socket
//echo "<b>Sending Message:</b>\n<br />".$message;
//socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");

// Read server response
//$result = socket_read ($socket, $bufferlen) or die("Could not read server response\n");
//echo "<p><b>Reply From Server:</b><br />".$result."</p>";


//Testing with Card No: "21221012345678", Pin: "64058","Billy, Balzac"
$message=array(
	"code" => "CREATE_CUSTOMER",
	"authorityToken" => "55u1dqzu4tfSk2V4u5PW6VTMqi9bzt2d",
	"userId" => "",
	"pin" => "",
	"customer" => '{\"ID\":\"21221015133926\",\"PIN\":\"64058\",\"NAME\":\"Balzac, William (Dr)\",\"STREET\":\"11811 72 Ave.\",\"CITY\":\"Edmonton\",\"PROVINCE\":\"AB\",\"POSTALCODE\":\"T6G2B2\",\"GENDER\":\"X\",\"EMAIL\":\"ilsteam@epl.ca\",\"PHONE\":\"\",\"DOB\":\"X\",\"PRIVILEGE_EXPIRES\":\"20140514\",\"RESERVED\":\"OK\",\"DEFAULT\":\"X\",\"ISVALID\":\"Y\",\"ISMINAGE\":\"Y\",\"ISRECIPROCAL\":\"N\",\"ISRESIDENT\":\"Y\",\"ISGOODSTANDING\":\"Y\",\"ISLOSTCARD\":\"N\",\"FIRSTNAME\":\"William (Dr)\",\"LASTNAME\":\"Balzac\"}'
);
$message=json_encode($message);
$message.="\n";

echo "<b>Sending Message:</b>\n<br />".$message;
socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
$result = socket_read ($socket, $bufferlen) or die("Could not read server response\n");
echo "<p><b>Reply From Server:</b><br />".$result."</p>";

// Hang up socket connection
socket_write($socket, $hangup, strlen($hangup)) or die("Could not send data to server\n");

//Close the socket
socket_close($socket);





?>
</body>
</html>