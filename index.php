<?php

$pageTitle="me card | Sign in";
include 'header.php';
?>

<div id="logoAndForm">
<img class="centered" id="joinMeImg" src="images/join_me.png" alt="Join me" style="margin-top:30px;width:326px;height:287px;"/>

<div class="centered" id="formDiv" style="padding:20px;">
	<form name="loginForm" id="loginForm" action="get_info.php" method="post">
	<h2 style="margin-left:20px;margin-bottom:10px;">Login</h2>
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

<div style="margin:20px auto; width:340px;text-align:center;">
<a href="Javascript:void(0);" onClick="$('#meInfo').toggle(250)">about me &#9660;</a>
<div id="meInfo" style="display:none;"><h2 style="margin-bottom:5px;">What does me do for you?</h2><p id="meInfoP">Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.</p></div>
</div>

<div id="backCurtain">
</div>


<div id="spacer"></div>
<?php
include 'footer.php';
?>