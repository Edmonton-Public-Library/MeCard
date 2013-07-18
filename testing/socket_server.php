<html>
<body>
<?php

/* Socket Server */
$host = "localhost";
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





?>
</body>
</html>