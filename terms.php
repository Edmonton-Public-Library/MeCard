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
<h1 class="pageTitle greenbg">Terms of Service</h1>

<div class="subContent">

<p>By registering for Me services, you agree to abide by the policies of each library you register with. Information regarding the policies of each library may be found below.</p>
<ul>	
<li><a href="http://www.epl.ca/services/borrowing-guide">Edmonton Public Library</a></li>
<li><a href="http://www.sclibrary.ab.ca/aboutyourcard.htm">Strathcona County Public Library</a></li>
<li><a href="http://www.fspl.ca/my-services/library-card-and-borrowing-information">Fort Saskatchewan Public Library</a></li>
<li><a href="http://www.sapl.ca/about-us/memberships.html">St. Albert Public Library</a></li>
</ul>

<p>If you lose your home library card, you will need to update any other Me libraries that you registered with via the Me Libraries website, or by phone or in person.</p>

<a href="http://www.melibraries.ca/">Return to MeLibraries.ca</a>	

	
</div><!--subContent-->
<div id="spacer"></div>
</div><!--mainContent-->
<?php
include 'footer.php';
?>