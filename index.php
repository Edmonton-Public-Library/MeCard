<?php

$pageTitle="me card | Sign in";
include 'header.php';
?>

<img class="centered" id="joinMeImg" src="images/join_me.png" alt="Join me" style="margin-top:30px;width:326px;height:287px;"/>

<div class="centered" id="mainbox_container" style="width:740px;margin-top:10px;">

<div class="mainbox" id="formDiv" style="padding:20px;">
	<h2 style="margin-left:20px;margin-bottom:10px;">Login</h2>
	<form name="loginForm" id="loginForm" action="get_info.php" method="post">
	<div class="formItem">
		<label class="login" for="cardNoField">Library card number</label><br />
		<input type="text" class="rounded" id="cardNoField" name="cardNoField" />
		<div id="errorCardNo" class="error">Invalid card number</div>
	</div>
	
	<div class="formItem" style="margin-bottom:37px;">
		<label class="login" for="pin">PIN</label><br />
		<input type="password" class="rounded" id="pin" name="pin"/>
	</div>	
	
	<div style="text-align:center;margin-bottom:10px;">
		<!--- I'll have to put some kind of fancy spinner and a delay here --->
		<input type="submit" class="button enter" value="Enter">
		<img src="images/ajax-loader.gif" id="loadSpinner" />
		
	</div>	
	
	</form>
	
	<!--- we submit this form with jQuery after we have the library figured out --->
	<form name="jsonForm" id="jsonForm" action="welcome.php" method="post">
		<input type="hidden" id="jsonField" name="jsonField" value="" />
	</form>
</div><!--formDiv-->

<div id="meInfo" class="mainbox" style="display:block;"><h2 style="margin-bottom:5px;text-align:center;">What does me do?</h2><p id="meInfoP">Me gives you access to all collections<sup>*</sup> and programs offered by the Metro Edmonton Federation of Libraries (Edmonton, St. Albert, Strathcona County, and Fort Saskatchewan public libraries) using a single card!</p>
<p>If you are over 18 years of age and have a card with any one of the Metro libraries, you can sign up here today to begin using that same card at any of the other member libraries.
<span class="small"><sup>*</sup>eBooks and other electronic content are not included due to licensing restrictions.</span>
</p></div>


</div><!--centered mainbox_container-->

<div id="backCurtain">
</div>


<div id="spacer"></div>
<?php
include 'footer.php';
?>