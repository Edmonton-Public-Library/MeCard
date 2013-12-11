<?php

$pageTitle="me card | Sign up";
include 'header.php';

/*
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


?>
<div class="mainContent" id="mainContent">

<a href="index.php" style="border:none;"><img id="meLogoTop" src="images/Me_Logo_Color.png"/></a>
<h1 class="pageTitle greenbg">Terms of Use</h1>

<div class="subContent">

<p>By registering for the Me card, you agree to abide by the policies of each library you register with. Information regarding the policies of each library may be found below.</p>
<ul>	
<li><a href="http://www.epl.ca/services/borrowing-guide">Edmonton Public Library</a></li>
<li><a href="http://www.sclibrary.ab.ca/aboutyourcard.htm">Strathcona County Public Library</a></li>
<li><a href="http://www.fspl.ca/my-services/library-card-and-borrowing-information">Fort Saskatchewan Public Library</a></li>
<li><a href="http://www.sapl.ca/about-us/memberships.html">St. Albert Public Library</a></li>
<li><a href="http://www.prl.ab.ca/meconditions">Parkland Regional Libraries</a></li>
</ul>

<p>Please report a lost card to your home library as soon as possible. Once you have a replacement home library card, contact the other libraries you�re registered with by phone or in person to update your account(s).</p>

<a href="http://www.melibraries.ca/">Return to MeLibraries.ca</a>	

	
</div><!--subContent-->
<div id="spacer"></div>
</div><!--mainContent-->
<?php
include 'footer.php';
?>