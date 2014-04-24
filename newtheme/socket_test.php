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


//Testing with Card No: "21221012345678", Pin: "6058","Billy, Balzac"
$message=array(
	"code" => "GET_CUSTOMER",
	"authorityToken" => "55u1dqzu4tfSk2V4u5PW6VTMqi9bzt2d",
	"userId" => "21221015133926",
	"pin" => "6058",
	"customer" => "null"
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



/* Socket Server
$host = "ilsdev1.epl.ca";
$port = 2004;
// No Timeout 
set_time_limit(0);


$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");

$result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");

// Listen to Socket
$result = socket_listen($socket, 3) or die("Could not set up socket listener\n");

// Accept incoming connection
$spawn = socket_accept($socket) or die("Could not accept incoming connection\n");

// Read message from client socket
$input = socket_read($spawn, 1024) or die("Could not read input\n");

// Reverse input. I'll want to do something more useful in practice.
$output = strrev($input) . "\n";

// Send message to client socket.
socket_write($spawn, $output, strlen ($output)) or die("Could not write output\n"); 

// Close the socket 
socket_close($spawn);
socket_close($socket);
*/




?>
</body>
</html>