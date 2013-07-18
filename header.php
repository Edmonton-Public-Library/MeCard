<!DOCTYPE html>

<html>

<head>

<!--- make a favicon --->

<title><?=$pageTitle?></title>

<!--
SEO Stuff can go here. Meta tags, etc.
-->

<style type="text/css">
	* {
		-moz-box-sizing: border-box;
		-webkit-box-sizing: border-box;
		box-sizing: border-box;
	}

	body {
		background-image:url('images/backgroundCovers.jpg');
	}

	
	@font-face {
		font-family: 'Asap';
		src: url('fonts/Asap-Regular.otf');
	}
	

	a {
		color:white;
		font-family:Asap, Arial, Helvetica, sans-serif;
		text-decoration:none;
	}
	
	a:hover {
		text-decoration:underline;
	}
	
	p {
		margin-top:5px;
		margin-bottom:5px;
		font-family:Asap, Arial, Helvetica, sans serif;
	}
	.centered {
		display:block;
		margin:0 auto;
	}

	.hidden {
		display:none;
	}
	
	#spacer {
		height:75px;
	}
	
	#formDiv {
		background-image:url('images/alpha-70.png');
		-webkit-border-radius: 20px;
		-moz-border-radius: 20px;
		border-radius: 20px;
		width:340px;
		margin-top:30px;
		position:relative;
	}

	h2 {
		font-family:Asap, Arial, Helvetica, sans-serif;
		font-size:32px;
		color:#009775;
		font-weight:normal;
		margin-top:0px;
	}
	
	label {
		font-family:Asap, Arial, Helvetica, sans-serif;
	}
	
	.login {
		font-size:18px;
	}
	
	.error {
		font-size:16px;
		font-family: Asap, Arial, Helvetica, sans-serif;
		color:red;
		text-align:left;
		display:none;
	}
	
	
	.formItem {
		margin:0 auto;
		margin-bottom:12px;
		width:262px;
	}
	
	input.rounded {
		background-color:rgba(255, 255, 255, 0.8);
		border: 1px solid #DDD;
		padding:5px;
		-webkit-border-radius: 10px;
		-moz-border-radius: 10px;
		border-radius: 10px;
		-webkit-box-shadow: 
		  inset 0 0 8px  rgba(0,0,0,0.2),
				0 0 16px rgba(0,0,0,0.2); 
		-moz-box-shadow: 
		  inset 0 0 8px  rgba(0,0,0,0.2),
				0 0 16px rgba(0,0,0,0.2); 
		box-shadow: 
		  inset 0 0 8px  rgba(0,0,0,0.2),
				0 0 16px rgba(0,0,0,0.2);

		font-size:16px;
		
		width:250px;
	}
	
	.button {
		-webkit-box-shadow: 0px 0px 13px rgba(20, 20, 20, 0.5);
		-moz-box-shadow:    0px 0px 13px rgba(20, 20, 20, 0.5);
		box-shadow:         0px 0px 13px rgba(20, 20, 20, 0.5);
		text-align:center;
		-webkit-border-radius: 10px;
		-moz-border-radius: 10px;
		border-radius: 10px;
		background-color:#009775;
		font-family:Asap, Arial, Helvetica, sans-serif;
		font-size:18px;		
		padding:6px 80px;
		color:#DDD;
		text-decoration:none;
		border-color:#00B189;
		
	}
	
	
	.button:hover {
		color:white;
		text-decoration:none;
		-webkit-box-shadow: 0px 0px 13px rgba(0, 0, 0, 0.6);
		-moz-box-shadow:    0px 0px 13px rgba(0, 0, 0, 0.6);
		box-shadow:         0px 0px 13px rgba(0, 0, 0, 0.6);		
	}

	.enter {
		padding:5px 0px;
		width:150px;
		display:block;
		margin:0 auto;
	}
	
	.deadButton {
		text-align:center;
		-webkit-border-radius: 10px;
		-moz-border-radius: 10px;
		border-radius: 10px;
		background-color:#C4C4C4 ;
		font-family:Asap, Arial, Helvetica, sans-serif;
		font-size:18px;		
		padding:6px 20px;
		color:#E4E4E4;
		text-decoration:none;
		
	}	
	

	.footer {
		position:fixed;
		bottom:0;
		left:0;
		right:0;
		background-color:black;
		color:#CCC;
	}

	
	.footerText {
		float:left;
		font-size:14px;
		margin-top:30px;
		margin-left:40px;
		font-family:Asap, Arial, Helvetica, sans-serif;
	}
	
	.footerText a {
		color:#FFF;
		text-decoration:none;
	}
	
	.footerText a:hover {
		color:#FFF;
		text-decoration:underline;
	}
	
	#meInfo {
		background-image:url('images/alpha-70.png');
		-webkit-border-radius: 20px;
		-moz-border-radius: 20px;
		border-radius: 20px;
		width:340px;
		padding:20px;
	}
	
	.mainContent {
		position:relative;
		background-color:white;
		margin-left:8%;
		margin-right:8%;
		height:100%;
	}
	
	.subContent {
		margin:25px 20px 10px 40px;
	}
	.pageTitle {
		position:absolute;
		right:21px;
		left:202px;
		top:21px;
		color:white;
		font-family:Asap, Arial, Helvetica, sans-serif;
		font-size:46px;
		background-color:black;
		font-weight:normal;
		float:right;
		padding:20px;
		margin:0 0 0 0px;
		-webkit-border-radius: 8px;
		-moz-border-radius: 8px;
		border-radius: 8px;	

	}

	.purple {
		color:#AE2573;	
	}	
	.purplebg {
		background-color:#AE2573;	
	}

	.blue {
		color:#0033A0;	
	}	
	.bluebg {
		background-color:#0033A0;	
	}	
	
	.green {
		color:#009775;
	}
	.greenbg {
		background-color:#009775;
	}
	
	#meLogoTop {
		width:160px;
		height:93px;
		margin-left:21px;
		margin-top:21px;
		border:none;
	}
	
	
	.personalInfo {
		color:#AE2573;
		margin-top:20px;
		font-family:Asap, Arial, Helvetica, sans-serif;
	}
	
	.personalInfo th {
		color:black;
		text-align:left;
		padding-right:10px;
	}
	
	.libCaption {
		font-family:Asap, Arial, Helvetica, sans-serif;
		text-align:center;
	}
	
	.libTable td {
		padding-bottom:25px;
		padding-right:25px;
	}
	
	a.terms {
		color:#0033A0;
		margin:0 auto;
		text-align:left;
		margin-top:20px;
		display:block;
	}
	
	a.join {
		padding-left:20px;
		padding-right:20px;
	}

	a.update {
		padding-left:20px;
		padding-right:20px;
		margin:0 10px 0 10px;
	}

	#backCurtain {
		position:fixed;
		top:0;
		bottom:0;
		left:0;
		right:0;
		background-image:url('images/alpha-black-30.png');
		display:none;
	}
	
	#loadSpinner {
		width:126px;
		height:22px;
		display:none;
		vertical-align:middle;
	}
	
	#enterText {
		display:block;
		padding:1px;
	}
</style>



<script type="text/javascript" language="Javascript" src="jquery-1.9.1.min.js"></script>

<script language="Javascript">
	
	//This function resizes an element to fit within a certain available size.
	//I can tweak it with by adjusting the availableHeight/availableWidth variables if necessary
	function autoResize(id){
		var newHeight;
		var newWidth;
		var maxHeight=287;
		var minHeight=190;
		var availableWidth;
		var sideMargin=48;
		var availableHeight=$(window).height()-600;
		if ($(window).width()<950) availableWidth=950-sideMargin-sideMargin;
		else availableWidth=$(window).width()-sideMargin-sideMargin;
		
		var aspectRatio=326/287;	
		if(document.getElementById){

			if (availableHeight<(availableWidth/aspectRatio)) {
				newHeight=availableHeight;
				newWidth=availableHeight*aspectRatio;
			} else {
				newHeight=availableWidth/aspectRatio;
				newWidth=newHeight*aspectRatio;
			}

		}
		if (newHeight < minHeight) {
			document.getElementById(id).style.height= minHeight+"px";
			document.getElementById(id).style.width= minHeight*aspectRatio+"px";
		} else if (newHeight < maxHeight) {
			document.getElementById(id).style.height= newHeight+"px";
			document.getElementById(id).style.width= newWidth+"px";
		}
	}		

	
	$(document).ready(function(){
		if ($('#joinMeImg').length) autoResize('joinMeImg');
		if ($(window).height() > $('#mainContent').height()) $('#mainContent').height($(window).height()-20+'px');
	});
	
	$(window).resize(function () {
		if ($('#joinMeImg').length) autoResize('joinMeImg');
		//if ($(window).height() < $('#mainContent').height()) $('#mainContent').height($(window).height()-20+'px');
	});



	function enableButton(id) {
		if (document.getElementById('agree').checked==true) {
			document.getElementById('deadButton').style.display='none';
			document.getElementById(id).style.display='inline';
		} else {
			document.getElementById('deadButton').style.display='inline';
			document.getElementById(id).style.display='none';
		}
	}


	
	
	function showSpinner() {
		$('#enterText').hide();
		$('#loadSpinner').show();
		//$('#backCurtain').show();	
		$(this).parent().submit('get_info.php');
	}
	
	
</script>

</head>

<body>