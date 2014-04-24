<?php

$pageTitle="ME Libraries | Sign in";
include 'header.php';

if (!isset($_POST["jsonField"])) {
	echo('<div class="mainContent" id="mainContent" style="min-width:695px;"><a href="index.php" style="border:none;"><img id="meLogoTop" src="images/ME_Libraries_Logo_black.png"></a><h1 class="pageTitle">Error</h1><div class="subContent"><p>No user id specified. Please return to <a href="/">MELibraries.ca</a>.</p></div></div>'); 
	include 'footer.php';
	exit();
}




//The data passed from get_info.php
$data=json_decode($_POST["jsonField"], true);
//Customer information in a nice array
$customer=json_decode($data["customer"], true);

$customerHashData=
	//trim($customer["PIN"]) .
	trim($customer["FIRSTNAME"]) .
	trim($customer["LASTNAME"]) .
	trim($customer["DOB"]) .
	trim($customer["STREET"]) .
	trim($customer["CITY"]) .
	trim($customer["PROVINCE"]) .
	trim($customer["POSTALCODE"]) .
	trim($customer["EMAIL"]) .
	trim($customer["PHONE"]) .
	trim($customer["PRIVILEGE_EXPIRES"]);
$customerHash=md5($customerHashData);
?>

<div class="mainContent" id="mainContent">

<a href="index.php" style="border:none;" title="Return to Login"><img id="meLogoTop" src="images/ME_Libraries_Logo_black.png"/></a>
<h1 class="pageTitle">Welcome</h1>


<div class="subContent">

	<h2 class="purple" style="clear:both;">About you.</h2>

	<p>By using this service you allow the information about yourself shown below to be shared with other Me libraries.</p>

	<pre class="debug">
		<?php #Diagnostics crap
			print_r($data);
			echo "<br />";
			print_r($customer);
			print_r($customerHashData);
			echo "<br />";
			print_r($customerHash);		
		?>
	</pre>
	
	<table class="personalInfo">
	<tr>
		<th>First Name:</th>
		<td><?=$customer["FIRSTNAME"]?></td>
	</tr>
	<tr>
		<th>Last Name:</th>
		<td><?=$customer["LASTNAME"]?></td>
	</tr>	
	<tr>
		<th>Email Address:</th>
		<td><?=$customer["EMAIL"]?></td>
	</tr>	
	<tr>
		<th>Street Address:</th>
		<td><?=$customer["STREET"]?></td>
	</tr>
	<tr>
		<th>City:</th>
		<td><?=$customer["CITY"]?></td>
	</tr>
	<tr>
		<th>Province:</th>
		<td><?=$customer["PROVINCE"]?></td>
	</tr>
	<tr>
		<th>Postal Code:</th>
		<td><?=$customer["POSTALCODE"]?></td>
	</tr>	
	<tr>
		<th>Phone:</th>
		<td><?=$customer["PHONE"]?></td>
	</tr>
	<tr>
		<th>Sex:</th>
		<td><?=$customer["SEX"]?></td>
	</tr>
	<tr>
		<th>Date of Birth:</th>
		<td><?=$customer["DOB"]?></td>
	</tr>	
	<tr>
		<th>Membership Expires:</th>
		<td><?=$customer["PRIVILEGE_EXPIRES"]?></td>
	</tr>	
	
	
	</table>
	
	
	<div id="verifyDiv" style="margin-top:20px;margin-bottom:10px;">
	<form name="verifyForm" id="verifyForm" action="signup.php" method="post">
		<!--- Hidden Form elements contain useful user metadata, library info, etc. --->
		<input type="hidden" name="jsonField" id="jsonField" value="<?=htmlspecialchars ($_POST["jsonField"])?>" />
		<input type="hidden" name="userid" id="userid" value="<?=$customer["ID"]?>" />
		<input type="hidden" name="userHash" id="userHash" value="<?=$customerHash?>" />
		<input type="hidden" name="firstName" id="firstName" value="<?=$customer["FIRSTNAME"]?>" />
		<input type="hidden" name="lastName" id="lastName" value="<?=$customer["LASTNAME"]?>" />
		<input type="hidden" name="libraryRecordIndex" id="libraryRecordIndex" value="<?=$data["libraryRecordIndex"]?>" />
		<label for="agree">I allow this information to be shared with other Me libraries. <input type="checkbox" name="agree" id="agree" onChange="enableButton('nextButton');" /></label>

		<span class="deadButton" id="deadButton" style="margin-left:50px;margin-right:50px;">Next&nbsp;&#9658;</span>
		
		<!--- Clicking this button submits all the known data--->
		<a href="javascript:void(0);" class="button hidden" id="nextButton" style="padding-left:20px;padding-right:20px;margin-left:50px;margin-right:50px;" onClick="$('#verifyForm').submit()">Next &#9658;</a>
		

	</form>
	</div>
	<div style="clear:both;"></div>
	
</div><!--subContent-->
<div id="spacer"></div>
</div><!--mainContent-->
<?php
include 'footer.php';
?>