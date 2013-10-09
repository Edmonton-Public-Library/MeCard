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
<h1 class="pageTitle greenbg">Terms of Use &amp; Privacy Policy</h1>

<div class="subContent">
<h2>Terms of Use</h2>

<p>By registering for the Me card, you agree to abide by the policies of each library you register with. Information regarding the policies of each library may be found below.</p>
<ul>	
<li><a href="http://www.epl.ca/services/borrowing-guide">Edmonton Public Library</a></li>
<li><a href="http://www.sclibrary.ab.ca/meconditions.htm">Strathcona County Library &amp; Fort Saskatchewan Public Library</a></li>
<li><a href="http://www.sapl.ca/about-us/memberships.html">St. Albert Public Library</a></li>
</ul>
<p>Please report a lost card to your home library as soon as possible. Once you have a replacement home library card, contact the other libraries you’re registered with by phone or in person to update your account(s).</p>

<h2>Privacy Policy</h2>

<p>The information you submit to the Metro libraries is collected under the authority of Section 33(c) of the Freedom of Information and Protection of Privacy Act (Alberta). It will not be used for any other purpose. Each Metro library collects customer information under the authority of the Alberta Libraries Act and the Freedom of Information and Protection of Privacy Act.</p>


<a href="http://www.melibraries.ca/" style="display:block;margin-top:20px;">Return to MeLibraries.ca</a>	

	
</div><!--subContent-->
<div id="spacer"></div>
</div><!--mainContent-->
<?php
include 'footer.php';
?>