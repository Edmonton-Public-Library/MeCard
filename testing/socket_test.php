<html>
<body>
<?php

/* PHP Socket Client */


/* Another example of a socket reading function */
function socket_read_normal($socket, $end=array("\r", "\n")){
    if(is_array($end)){
        foreach($end as $k=>$v){
            $end[$k]=$v{0};
        }
        $string='';
        while(TRUE){
            $char=socket_read($socket,1);
            $string.=$char;
            foreach($end as $k=>$v){
                if($char==$v){
                    return $string;
                }
            }
        }
    }else{
        $endr=str_split($end);
        $try=count($endr);
        $string='';
        while(TRUE){
            $ver=0;
            foreach($endr as $k=>$v){
                $char=socket_read($socket,1);
                $string.=$char;
                if($char==$v){
                    $ver++;
                }else{
                    break;
                }
                if($ver==$try){
                    return $string;
                }
            }
        }
    }
}


//Set host/port #
$host = "ilsdev1.epl.ca";
$port = 2004;




//JSON formatted parameters for socket.
$message = '["QA0", "55u1dqzu4tfSk2V4u5PW6VTMqi9bzt2d"]';

echo "<p>Sending the following message to <b>$host</b> on port <b>$port</b>:\n<br />";
echo $message."\n</p>";

// No Timeout 
set_time_limit(0);

// Create Socket
$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");

// Connect to the server
$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");

// Read initial server message/ack
//$result = socket_read_normal($socket) or die("Could not read from server\n");
//echo "<p><b>Initial message from server:</b><br />".$result."</p>";

// Write to server socket
socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");

// Read server response
$result = socket_read ($socket, 1024) or die("Could not read server response\n");
echo "<p><b>Reply From Server:</b><br />".$result."</p>";

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