<?php


$pageTitle="me card | Sign up";
include 'header.php';

if (!isset($_POST["userid"])) {
	echo('<div class="mainContent" id="mainContent" style="min-width:695px;"><a href="index.php" style="border:none;"><img id="meLogoTop" src="images/Me_Logo_Color.png"></a><h1 class="pageTitle bluebg">Error</h1><div class="subContent"><p>Please return to <a href="/">MeLibraries.ca</a>.</p></div></div>'); 
	include 'footer.php';
	exit();
}

/*
	Here we have to determine if the user is registered to any libraries and if his/her information has changed with those libraries.
*/



?>

<div class="mainContent" id="mainContent" style="min-width:695px;">

<a href="index.php" style="border:none;"><img id="meLogoTop" src="images/Me_Logo_Color.png"/></a>
<h1 class="pageTitle bluebg">Sign Up</h1>

<div class="subContent">


<?php


/* Connect to the DB and get the list of libraries that the user is not already registered to. */
include '/home/its/mysql_config.php';

// Check connection
if (mysqli_connect_errno($con))  {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

//Query for libraries this user has already joined that need to be updated

$query="SELECT * FROM membership m 
	INNER JOIN user u ON m.user_record_index=u.record_index
	INNER JOIN library l on m.library_record_index=l.record_index
	WHERE u.userid='".$_POST["userid"]."' AND user_info_hash!='".$_POST["userHash"]."'";

$result = mysqli_query($con, $query);
if (mysqli_num_rows($result)>0) {
	echo '<h2 class="blue" style="clear:both;">Update your information at these libraries:</h2>';
	echo '<table class="libTable">';
	while($row = mysqli_fetch_assoc($result)) {
	?>
	
	<tr>
	<td>
		<a href="http://<?=$row['library_url']?>/" style="border:none;"><img src="libraries/<?=$row['record_index']?>.png" style="height:120px;vertical-align:middle;" alt="<?=$row['library_name']?>" title="<?=$row['library_name']?>"></a>
	</td>
	<td><form name="form<?=$row['library_record_index']?>" id="form<?=$row['library_record_index']?>" action="join.php" method="post">
			<input type="hidden" name="jsonField" id="jsonField" value="<?=htmlspecialchars ($_POST["jsonField"])?>" />
			<input type="hidden" name="userid" id="userid" value="<?=$_POST["userid"]?>" />
			<input type="hidden" name="userHash" id="userHash" value="<?=$_POST["userHash"]?>" />
			<input type="hidden" name="firstName" id="firstName" value="<?=$_POST["firstName"]?>" />
			<input type="hidden" name="lastName" id="lastName" value="<?=$_POST["lastName"]?>" />
			<input type="hidden" name="libraryRecordIndex" id="libraryRecordIndex" value="<?=$_POST["libraryRecordIndex"]?>" />
			<input type="hidden" name="joinLibrary" id="joinLibrary" value="<?=$row['record_index']?>" />
			<h3><?=$row['library_name']?></h3>
			<a href="javascript:void(0);" class="button bluebg join" onClick="$('.loadSpinner').hide();$('#spinner<?=$row['library_record_index']?>').show();$('#form<?=$row['library_record_index']?>').submit()">Update &#9658;</a>
			<a class="terms" href="<?=$row['library_policy_url']?>">Terms & Conditions</a>
		</form>
	</td>
	</tr>	


	<?php
	}
	echo '</table><!--updatable libraries table-->';
}




//Query for libraries that we are not a member of and aren't natively from
//Later I will need to adjust this to show libraries needing an update (the hash differs from our own).
$query="SELECT * FROM library l 
JOIN libraryprefixes lp ON l.record_index=lp.library_record_index
JOIN librarycom lc ON l.record_index=lc.library_record_index
WHERE l.record_index != ".$_POST["libraryRecordIndex"]." AND l.record_index NOT IN (
SELECT m.library_record_index from user u INNER JOIN membership m ON u.record_index = m.user_record_index 
WHERE u.userid='".$_POST["userid"]."')";

$result = mysqli_query($con, $query);


if (mysqli_num_rows($result)>0) {
	echo '<h2 class="blue" style="clear:both;">Choose new libraries to join.</h2>';
	echo '<table class="libTable">';
	while($row = mysqli_fetch_assoc($result)) {
?>
		<tr>
		<td>
			<a href="http://<?=$row['library_url']?>/" style="border:none;"><img src="libraries/<?=$row['record_index']?>.png" style="height:120px;vertical-align:middle;" alt="<?=$row['library_name']?>" title="<?=$row['library_name']?>"></a>
		</td>
		<td><form name="form<?=$row['library_record_index']?>" id="form<?=$row['library_record_index']?>" action="join.php" method="post">
				<input type="hidden" name="jsonField" id="jsonField" value="<?=htmlspecialchars ($_POST["jsonField"])?>" />
				<input type="hidden" name="userid" id="userid" value="<?=$_POST["userid"]?>" />
				<input type="hidden" name="userHash" id="userHash" value="<?=$_POST["userHash"]?>" />
				<input type="hidden" name="firstName" id="firstName" value="<?=$_POST["firstName"]?>" />
				<input type="hidden" name="lastName" id="lastName" value="<?=$_POST["lastName"]?>" />
				<input type="hidden" name="libraryRecordIndex" id="libraryRecordIndex" value="<?=$_POST["libraryRecordIndex"]?>" />
				<input type="hidden" name="joinLibrary" id="joinLibrary" value="<?=$row['record_index']?>" />
				<h3><?=$row['library_name']?></h3>
				<a href="javascript:void(0);" class="button bluebg join" onClick="$('.loadSpinner').hide();$('#spinner<?=$row['library_record_index']?>').show();$('#form<?=$row['library_record_index']?>').submit();">Join &#9658;</a><img src="images/ajax-loader.gif" class="loadSpinner" id="spinner<?=$row['library_record_index']?>"/>
				<a class="terms" href="<?=$row['library_policy_url']?>">Terms & Conditions</a>
			</form>
		</td>
		</tr>
<?php		
	}
}	
	/* List the libraries from the library table, but exclude libraries that we are already registered at.*/
?>

<!--
		<tr>
		<td>
			<a href="http://epl.ca/" style="border:none;"><img src="libraries/1.png" style="height:120px;vertical-align:middle;" alt="Edmonton Public Library" title="Edmonton Public Library"></a>
		</td>
		<td>
			<h3>Edmonton Public Library</h3>
			<a href="join.php?lib=1" class="button bluebg join">Join &#9658;</a>
			<a class="terms" href="terms_epl.php">Terms & Conditions</a>
		</td>
		</tr>
-->	
	</table>

	
</div><!--subContent-->
<div id="spacer"></div>
</div><!--mainContent-->
<?php
include 'footer.php';
?>