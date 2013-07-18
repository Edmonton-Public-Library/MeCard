<?php

$pageTitle="me card | Sign in";
include 'header.php';
?>
<div class="mainContent" id="mainContent">

<a href="index.php" style="border:none;"><img id="meLogoTop" src="images/Me_Logo_Color.png"/></a>
<h1 class="pageTitle purplebg">Welcome</h1>


<div class="subContent">

	<h2 class="purple" style="clear:both;">About you.</h2>

	<p>By using this service you agree to the following terms and conditions.</p>
	<p>In order to provide this service, the information about yourself shown below will need to be shared with other parties. --Insert Terms and conditions here--</p>

<?php #Diagnostics crap
	print_r($_POST);
?>

	
	<table class="personalInfo">
	<tr>
		<th>First name:</th>
		<td>John</td>
	</tr>
	<tr>
		<th>Last Name:</th>
		<td>Smith</td>
	</tr>
	<tr>
		<th>Address:</th>
		<td>1234 100 Street</td>
	</tr>
	<tr>
		<th>City:</th>
		<td>St. Albert</td>
	</tr>
	<tr>
		<th>Province:</th>
		<td>Alberta</td>
	</tr>
	<tr>
		<th>Phone:</th>
		<td>780-555-1234</td>
	</tr>
	<tr>
		<th>Gender:</th>
		<td>M</td>
	</tr>
	
	</table>
	
	
	<div id="verifyDiv" style="margin-top:20px;">
	<form name="verifyForm" action="">
		<input type="checkbox" name="agree" id="agree" 
		onChange="enableButton('nextButton');" /><label for="agree">I accept the terms and conditions.</label>
		<span class="deadButton" id="deadButton" style="float:right;margin-right:50px;">Next &#9658;</span>
		<a href="signup.php" class="button purplebg hidden" id="nextButton" style="float:right;padding-left:20px;padding-right:20px;margin-right:50px;">Next &#9658;</a>
	</form>
	</div>
	
	
</div><!--subContent-->
<div id="spacer"></div>
</div><!--mainContent-->
<?php
include 'footer.php';
?>