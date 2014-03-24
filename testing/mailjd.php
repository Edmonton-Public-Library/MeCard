<html>
<head>

	<title>Mail testing grounds</title>

</head>
<body>

<form id="loginForm" name="loginForm" method="post" action="ajax.php">
	<input type="submit" />
</form>


<div id="ajaxdiv">
Mail will be sent here... hrm. I guess I should make this look nice at some point.
</div>


<?php

if (strlen($customer["EMAIL"]) GT 3) {
	require_once "Mail.php";

	$from = "Me Libaries <noreply@melibraries.ca>";
	$to = $customer["FIRSTNAME"].' '.$customer["LASTNAME"].' <'$customer["EMAIL"].'>';
	$subject = echo 'You have joined '.$libraryComData["library_name"];
	$body = "This is a friendly notice that the you now have joined ".$libraryComData["library_name"];
	$body .= " and now have access to its collections with your home library card number!";

	//Add a comment about the new PIN if it has been changed
	if ($serverReply["code"] == "PIN_CHANGE_REQUIRED") {
			
		//$newPin is set above
		$body .= "\n\nNote: Your PIN for ".$libraryComData["library_name"]." is different. It has been set to ".$newPin.".";
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
	  echo("<p>Message successfully sent!</p>");
	}
}//END - If email longer than 3 characters

?>



</body>

</html>