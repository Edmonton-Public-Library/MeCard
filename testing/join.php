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
<h1 class="pageTitle greenbg">Joining &amp; Updating</h1>

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
$query="select u.record_index, m.record_index AS member_record_index, u.userid, u.home_library_record_index, m.user_record_index, m.library_record_index FROM user u
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




/* checkDuplicates function sets the right data in the customer array prior to submission to MeCard server
	-we won't necessarily know a userIdx but we will know their card number.
*/
function checkDuplicates($cardNumber, $customerHash) {
	global $customer;
	//DB Query to determine if any other hashes exist for this user
	$dupeQuery="SELECT * FROM user WHERE record_index=(SELECT DISTINCT user_record_index FROM membership
				WHERE user_info_hash ='".$customerHash."')
				AND userid != '".$cardNumber."'
				ORDER BY date_created DESC
				LIMIT 1";

	$dupeResult = mysqli_query($con, $dupeQuery);
	if (mysqli_num_rows($dupeResult)>0) {
	//Duplicate Found
		while($row = mysqli_fetch_assoc($dupeResult)) {
			$mostRecentDupeUserCard=$row['userid'];
		}
		//Now edit ISLOSTCARD and ALTERNATE_ID (scope issues here requiring global?)
		$customer['ISLOSTCARD'] = 'Y';
		$customer['ALTERNATE_ID'] = $mostRecentDupeUserCard;
	}//end duplicate found
}//end function checkDuplicates



/* Function to handle Duplicate cards after new user has been created
	-Pass the index for the new customer we just created
	-Determine the hash for this user
	-Find other accounts with this hash
	-Store the most recent card number in a variable
	-Update that into the customer's lost_card field
	-Delete old user's prior memberships
*/
function removeDuplicates($newUserIdx) {
	//Given the user idx, query for the user_info_hash
	$userQuery="SELECT user_info_hash FROM membership WHERE user_record_index ='".$newUserIdx."' LIMIT 1";
	$userResult = mysqli_query($con, $userQuery);
	if (mysqli_num_rows($userResult)>0) {
		while($row = mysqli_fetch_assoc($userResult)) {	
			$user_info_hash=$row['user_info_hash'];
		}
		
		//DB Query to determine if any other hashes exist for this user
		$dupeQuery="SELECT * FROM user WHERE record_index=(SELECT DISTINCT user_record_index FROM membership
					WHERE user_info_hash ='".$user_info_hash."' AND user_record_index !='".$newUserIdx."')
					ORDER BY date_created ASC";

		$dupeResult = mysqli_query($con, $dupeQuery);
		if (mysqli_num_rows($dupeResult)>0) {
		//Duplicates Found
			while($row = mysqli_fetch_assoc($dupeResult)) {				
				$mostRecentDupeUserIdx=$row['record_index'];
				$mostRecentDupeUserCard=$row['userid'];
				/* Here I blow away the duplicate accounts (but not the current one!) */
				$delMemberQuery="DELETE FROM membership WHERE user_record_index=$mostRecentDupeUserIdx";
				//$result=mysqli_query($con, $delMemberQuery);
				
				$delUserQuery="DELETE FROM user WHERE record_index=$mostRecentDupeUserIdx";
				//$result=mysqli_query($con, $delUserQuery);
			}
			$updateUserQuery="UPDATE user WHERE record_index=$newUserIdx SET lost_card='$mostRecentDupeUserCard'";
			$result=mysqli_query($con, $updateUserQuery);
			
		}//end: If there are duplicates
	}//end: If the user account is found
	
}//end function removeDuplicates	



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

	//Before this step, we need to see if ISLOSTCARD and ALTERNATE_ID need modification.
	//checkDuplicates will get the job done and modify data in the $customer array.
	checkDuplicates($_POST["userid"], $_POST["userHash"]);
	
	if ($hasMembership) {
		$message=array(
			"code" => "UPDATE_CUSTOMER",
			"authorityToken" => "55u1dqzu4tfSk2V4u5PW6VTMqi9bzt2d",
			"userId" => '',
			"pin" => '',
			"customer" => json_encode($customer)
			);
	
	} else {
		$message=array(
			"code" => "CREATE_CUSTOMER",
			"authorityToken" => "55u1dqzu4tfSk2V4u5PW6VTMqi9bzt2d",
			"userId" => '',
			"pin" => '',
			"customer" => json_encode($customer)
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
	if ($serverReply["code"] == "SUCCESS") {
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
			$query="UPDATE membership SET date_last_activity=NOW(), user_info_hash='".$_POST["userHash"]."' WHERE record_index='".$userInfo["member_record_index"]."'";
		}
		//Execute the insert or update query.
		$result = mysqli_query($con,$query);
		if ( false===$result ) {
			printf('<p class="error" style="display:block;">SQL error: %s</p>\n', mysqli_error($con));
		} else removeDuplicates($user_record_index); //Remove the duplicates
		
		
	} elseif ($serverReply["code"] == "PIN_CHANGE_REQUIRED") {
		
		$newPin = preg_replace("/^ ?(\d+)[\a\s:](.*)/", '<span class="pin">$1</span><span class="libMessage">$2</span>', $serverReply["responseMessage"]);
		$newNakedPin = preg_replace("/^ ?(\d+)[\a\s:](.*)/", '$1', $serverReply["responseMessage"]);
		echo '<h2 class="green" style="clear:both;">';
		if ($hasMembership) {
			echo "Thanks for the update.</h2>";
			$pinMessage =  "<span style=\"color:red;\">Note:</span> your PIN for ".$libraryComData["library_name"]." has been changed to <b>$newPin</b>";
		} else {
			echo 'Welcome to the '.$libraryComData["library_name"].'.</h2>';
			$pinMessage = '<span style=\"color:red;\">Note:</span> your PIN for this library is different.<br />';
			$pinMessage.= 'Your pin for '.$libraryComData["library_name"].' has been set to: '.$newPin;

			
			//Send an email to the customer if they have a valid email address
			if (strlen($customer["EMAIL"]) > 5) {
				require_once "Mail.php";

				$from = "Me Libaries <noreply@melibraries.ca>";
				$to = $customer["FIRSTNAME"]." ".$customer["LASTNAME"]." <".$customer["EMAIL"].">";
				$subject = 'You have joined '.$libraryComData["library_name"];
				$body = "This is a friendly notice that the you now have joined ".$libraryComData["library_name"];
				$body .= " and now have access to its collections with your home library card number!\n";
				$body .= "Visit ".$libraryComData["library_name"]." at ".$libraryComData["library_url"];

				//Add a comment about the new PIN if it has been changed
				if ($serverReply["code"] == "PIN_CHANGE_REQUIRED") {
						
					//$newPin is set above
					$body .= "\n\nNote: Your PIN for ".$libraryComData["library_name"]." is different.\nIt has been set to ".$newNakedPin.".";
				}

				$host = "mail1.epl.ca";

				$headers = array (
					'From' => $from,
					'To' => $to,
					'Subject' => $subject);
					
				$smtp = Mail::factory(
					'smtp',
					array (
						'host' => $host,
						'auth' => false)
					);

				$mail = $smtp->send($to, $headers, $body);

				if (PEAR::isError($mail)) {
				  echo("<p>" . $mail->getMessage() . "</p>");
				} else {
				  echo('<p>You have been sent an email about the following:</p>');
				}
			}//END - If email longer than 3 characters

			
			
		}//End if is a new membership

		
		//Do database inserts for when PIN Changes is required - new user
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
			$query="UPDATE membership SET date_last_activity=NOW(), user_info_hash='".$_POST["userHash"]."' WHERE record_index='".$userInfo["member_record_index"]."'";
		}
		//Execute the insert or update query.
		$result = mysqli_query($con,$query);
		if ( false===$result ) {
			printf('<p class="error" style="display:block;">SQL error: %s</p>\n', mysqli_error($con));
		} else removeDuplicates($user_record_index); //Remove the duplicates

		// I should define $error here
	
	} else {
		echo '<p class="error" style="display:block;">'.$serverReply["responseMessage"].'</p>';
		$error=true;
	}
	
	

?>



	<pre class="debug">
		<?php #Diagnostics crap 
			print_r($userInfo);
			echo "Customer:<br />";
			print_r($customer);
			
		/*
			print_r($_POST);
			echo "<br />";
			print_r($libraryComData);
			echo "<br />";
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

	
<div class="centered" style="width:90%;">	
	<?php
	if (isset($pinMessage)) {
		echo '<p style="text-align:center;">'.$pinMessage.'</p>';
	}
	?>
	<p style="margin-bottom:20px; margin-top:20px; text-align:center;">
	<?php
		if ($error != true) {
			if ($hasMembership) echo "Your record at ".$libraryComData["library_name"]." is now up to date";
			else  echo "You now have access to the ".$libraryComData["library_name"];
	?>
	.<br />Click the logo below to visit their website, or <a class="green" href="javascript:void(0);" onclick="$('#dataForm').submit()">join another library</a>.</p>
	
	<?php  } // End success message ?>
<a href="<?=$libraryComData['library_url']?>" style="border:none;width:160px;" class="centered"><img src="<?=$libraryComData["library_logo_url"]?>" class="centered" style="width:160px;vertical-align:middle;" alt="<?=$libraryComData["library_name"]?>" title="<?=$libraryComData["library_name"]?>"></a>	
</div>
<p style="text-align:center;margin-top:30px;">Note that it may take up to 5 minutes to update your account. If you are finished with this service, you can close your browser tab to end your session.</p>
</form>		
</div><!--subContent-->
<div id="spacer"></div>
</div><!--mainContent-->
<?php
include 'footer.php';
?>