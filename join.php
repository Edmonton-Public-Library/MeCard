<?php

$pageTitle="me card | Join";
include 'header.php';

/*
	1. Check if user is already a member of this library.
	2. If he is a member, set a variable that will change my request to Update
	3. If the create/update was succesfull (ok response), insert/update the database hash
	On this page we will insert the member into the user table if they haven't been added yet.
	After this, we will insert the membership for the library that they have just joined into the membership table
	
	There will be a component here that requires talking to the server to do.
	Send request to create/update user, 
	$message=array(
		"code" => "CREATE_CUSTOMER",
		"authorityToken" => $authorityToken,
		"customer" => "null"
	);	
*/


//The data passed from the submitting page
$submitData=json_decode($_POST["jsonField"], true);
//Customer information in a nice array
$customer=json_decode($submitData["customer"], true);


if (!isset($_POST["jsonField"])) {
	echo('<div class="mainContent" id="mainContent" style="min-width:695px;"><a href="index.php" style="border:none;"><img id="meLogoTop" src="images/Me_Logo_Color.png"></a><h1 class="pageTitle bluebg">Error</h1><div class="subContent"><p>Please return to <a href="/">MeLibraries.ca</a>.</p></div></div>'); 
	include 'footer.php';
	exit();
}


?>

<div class="mainContent" id="mainContent">

<a href="index.php" style="border:none;"><img id="meLogoTop" src="images/Me_Logo_Color.png"/></a>
<h1 class="pageTitle greenbg">Thanks For Joining</h1>

<div class="subContent">



<?php



/* Connect to the DB and get the list of libraries that the user is not already registered to
or where the hash is different (for updating) */
include '/home/its/mysql_config.php';

// Check connection
if (mysqli_connect_errno($con))  {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


$query="select * from librarycom  lc
JOIN library l ON l.record_index=lc.library_record_index
where lc.library_record_index='".$_POST["joinLibrary"]."'";
//I will also need to filter out other libraries that the user has already joined

if ($result=mysqli_query($con, $query)) {
	$libraryComData = mysqli_fetch_assoc($result);

} else echo "<h2>No communication info for library<h2>";


//Check to see if the user is already a member here. If so, we do an update.
$query="select u.record_index, u.userid, u.home_library_record_index, m.user_record_index, m.library_record_index FROM user u
	INNER JOIN membership m
	ON u.record_index = m.user_record_index
	WHERE u.userid='".$_POST["userid"]."' AND m.library_record_index=".$_POST["joinLibrary"];


$userExists=false;
$hasMembership=false;
	
$result=mysqli_query($con, $query);
if ($result->num_rows > 0) {
		$userInfo = mysqli_fetch_assoc($result);
		$hasMembership=true;
		$userExists=true;
} else {
	//Now check that the user exists at all
	$query="select * from user WHERE userid='".$_POST["userid"]."'";
	$result=mysqli_query($con, $query);
	if ($result->num_rows > 0) {
		$userInfo = mysqli_fetch_assoc($result);
		$userExists=true;
	} 	
}


	

/* Do Socket connection and add user to foreign library 	*/
	//Token/API Key
	$authorityToken="55u1dqzu4tfSk2V4u5PW6VTMqi9bzt2d";
	$host = $libraryComData["library_server_url"];
	$port = $libraryComData["library_server_port"];

	
	
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
	// If GET_STATUS is not okay, do error handling
	$message=json_encode($message);
	//Add newline so the server knows when the message is done.
	$message.="\n";

	// 10s Timeout 
	set_time_limit(10);

	// Create Socket
	$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");

	// Connect to the server
	if ($result = socket_connect($socket, $host, $port) == false) {
		$error=true;
		$errorMsg="Can't connect to server $host on port $port";
		echo('<div class="mainContent" id="mainContent" style="min-width:695px;"><a href="index.php" style="border:none;"><img id="meLogoTop" src="images/Me_Logo_Color.png"></a><h1 class="pageTitle bluebg">Error</h1><div class="subContent"><p class="error" style="display:inline;">'.$errorMsg.'</p><p>Please return to <a href="/">MeLibraries.ca</a>.</p></div></div>'); 
		include 'footer.php';
		exit();
	}


	// Read initial server message/ack
	if ($result = socket_read($socket, $bufferlen) == false) {
		$data["error"]=true;
		$data["errorMsg"]="Can't read from server $host";
		$data=json_encode($data);
		die ($data);
	};

	//Testing with Card No: "21221012345678", Pin: "64058","Billy, Balzac"
	
	if ($hasMembership) {
		$message=array(
			"code" => "UPDATE_CUSTOMER",
			"authorityToken" => "55u1dqzu4tfSk2V4u5PW6VTMqi9bzt2d",
			"userId" => '',
			"pin" => '',
			"customer" => $submitData["customer"]
			);
	
	} else {
		$message=array(
			"code" => "CREATE_CUSTOMER",
			"authorityToken" => "55u1dqzu4tfSk2V4u5PW6VTMqi9bzt2d",
			"userId" => '',
			"pin" => '',
			"customer" => $submitData["customer"]
			);
	}
	$message=json_encode($message);
	$message.="\n";

	//echo "<b>Sending Message:</b>\n<br />".$message;
	$result = (socket_write($socket, $message, strlen($message)));
	if ($result == false) {
		$error=true;
		$errorMsg="Could not send data to server $host";
		echo('<div class="mainContent" id="mainContent" style="min-width:695px;"><a href="index.php" style="border:none;"><img id="meLogoTop" src="images/Me_Logo_Color.png"></a><h1 class="pageTitle bluebg">Error</h1><div class="subContent"><p class="error" style="display:inline;">'.$errorMsg.'</p><p>Please return to <a href="/">MeLibraries.ca</a>.</p></div></div>'); 
		include 'footer.php';
		exit();
	}
	
	$serverReply = socket_read ($socket, $bufferlen);
	if ($serverReply == false) {
		$data["error"]=true;
		$data["errorMsg"]="Could not read server response";
		$data=json_encode($data);
		die($data);
	}
	echo '<p class="debug"><b>Reply From Server:</b><br />'.$serverReply.'</p>';
	$serverReply=json_decode($serverReply, true);
	
	// Hang up socket connection
	socket_write($socket, $hangup, strlen($hangup)) or die("Could not send data to server\n");

	//Close the socket
	socket_close($socket);


	
	//If the server replied that it was successful, we can do our database fun stuff.
	if ($serverReply["code"] == "OK") {
		echo '<h2 class="green" style="clear:both;">';
		if ($hasMembership) echo "Thanks for the update";
		else echo 'Welcome to the '.$libraryComData["library_name"];
		echo '.</h2>';
		
		//Insert the new user if he doesn't exist yet
		if ($userExists == false) {
			$query="INSERT INTO user (userid, home_library_record_index, date_last_activity, date_created)
			VALUES('".$_POST["userid"]."','".$_POST["libraryRecordIndex"]."', NOW(), NOW())";
			$result = mysqli_query($con,$query);
			if ( false===$result ) {
				printf('<p class="SQL error" style="display:block;">error: %s</p>\n', mysqli_error($con));
			}

			$user_record_index=mysqli_insert_id($con);
		} else {
			$user_record_index=$userInfo["record_index"];
		}
		
		if ($hasMembership == false) {
			$query="INSERT INTO membership (user_record_index, library_record_index, date_last_activity, user_info_hash)
			VALUES('".$user_record_index."','".$_POST["joinLibrary"]."', NOW(), '".$_POST["userHash"]."')";
		}
		else {
			//else we update an existing record
			$query="UPDATE membership SET date_last_activity=NOW(), user_info_hash='".$_POST["userHash"]."'";
		}
		//Execute the insert or update query.
		$result = mysqli_query($con,$query);
		if ( false===$result ) {
			printf('<p class="error" style="display:block;">SQL error: %s</p>\n', mysqli_error($con));
		}

		
	} else {
		echo '<p class="error" style="display:block;">'.$serverReply["responseMessage"].'</p>';
		$error=true;
	}
	
	

?>



	<pre class="debug">
		<?php /* #Diagnostics crap 
			print_r($_POST);
			echo "<br />";
			print_r($libraryComData);
			echo "<br />";
			echo "Customer:<br />";
			print_r($customer);
			echo "serverReply:<br />";
			print_r($serverReply);
		*/?>
	</pre>		

	
<form name="dataForm" id="dataForm" action="signup.php" method="post">
			<input type="hidden" name="jsonField" id="jsonField" value="<?=htmlspecialchars ($_POST["jsonField"])?>" />
			<input type="hidden" name="userid" id="userid" value="<?=$_POST["userid"]?>" />
			<input type="hidden" name="userHash" id="userHash" value="<?=$_POST["userHash"]?>" />
			<input type="hidden" name="firstName" id="firstName" value="<?=$_POST["firstName"]?>" />
			<input type="hidden" name="lastName" id="lastName" value="<?=$_POST["lastName"]?>" />
			<input type="hidden" name="libraryRecordIndex" id="libraryRecordIndex" value="<?=$_POST["libraryRecordIndex"]?>" />

	
<div class="centered" style="width:600px;">	
	<p style="margin-bottom:20px; text-align:center;">
	<?php
		if ($hasMembership and $error != true) echo "Your record at ".$libraryComData["library_name"]."is now up to date";
		else if ($error != true) {echo "You now have access to the ".$libraryComData["library_name"];
	?>
	.<br />Click the logo below to visit their website, or <a class="green" href="javascript:void(0);" onclick="$('#dataForm').submit()">join another library</a>.</p>
	<?php } // End success message ?>
<a href="<?=$libraryComData['library_url']?>" style="border:none;"><img src="<?=$libraryComData["library_logo_url"]?>" class="centered" style="width:160px;vertical-align:middle;" alt="Edmonton Public Library" title="Edmonton Public Library"></a>	
</div>
</form>		
</div><!--subContent-->
<div id="spacer"></div>
</div><!--mainContent-->
<?php
include 'footer.php';
?>