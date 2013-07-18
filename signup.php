<?php

$pageTitle="me card | Sign up";
include 'header.php';
?>
<div class="mainContent" id="mainContent" style="min-width:695px;">

<a href="index.php" style="border:none;"><img id="meLogoTop" src="images/Me_Logo_Color.png"/></a>
<h1 class="pageTitle bluebg">Sign Up</h1>

<div class="subContent">

	<h2 class="blue" style="clear:both;">Choose libraries.</h2>
	<table class="libTable">
	<tr>
	<td style="width:250px;">
		<a href="http://www.epl.ca/" style="border:none;"><img src="images/epl_logo.png" style="width:209px;vertical-align:middle;" alt="Edmonton Public Library" title="Edmonton Public Library"></a>
	</td>
	<td>
		<a href="join_epl.php" class="button bluebg join">Join &#9658;</a>
		<a class="terms" href="terms_epl.php">Terms & Conditions</a>
	</td>
	</tr>

	<tr>
	<td style="width:250px;">
		<a href="http://www.fspl.ca/" style="border:none;"><img src="images/FSPL-logo-dkblue.png" style="width:112px;vertical-align:middle;" alt="Fort Saskatchewan Public Library" title="Fort Saskatchewan Public Library"></a>
	</td>
	<td>
		<a href="signup.php" class="button bluebg join">Join &#9658;</a>
		<a class="terms" href="#">Terms & Conditions</a>
	</td>
	</tr>

	<tr>
	<td style="width:250px;">
		<a href="http://www.sapl.ca/" style="border:none;"><img src="images/SAPL_logo_wordmark_square.png" style="width:111px;vertical-align:middle;" alt="St. Albert Public Library" title="St. Albert Public Library"></a>
	</td>
	<td>
		<a href="signup.php" class="button bluebg join">Join &#9658;</a>
		<a class="terms" href="#">Terms & Conditions</a>
	</td>
	</tr>

	<tr>
	<td style="width:250px;">
		<a href="http://www.sclibrary.ab.ca/" style="border:none;"><img src="images/SCL_Logo.png" style="width:111px;vertical-align:middle;" alt="Strathcona County Library" title="Strathcona County Library"></a>
	</td>
	<td>
		<a href="signup.php" class="button bluebg join" id="nextButton" >Join &#9658;</a>
		<a class="terms" href="#">Terms & Conditions</a>
	</td>
	</tr>
	
	</table>

	
</div><!--subContent-->
<div id="spacer"></div>
</div><!--mainContent-->
<?php
include 'footer.php';
?>