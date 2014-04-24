<!DOCTYPE html>

<html>

<head>

<link rel="icon" type="image/png" href="/images/favicon_64x64.png" />
<!--[if IE]>
	<link rel="SHORTCUT ICON" type="image/x-icon" href="/favicon_32x32.ico" />
<![endif]-->

<link rel="stylesheet" type="text/css" href="me.css" />

<title><?=$pageTitle?></title>

<!--
SEO Stuff can go here. Meta tags, etc.
-->



<script type="text/javascript" language="Javascript" src="jquery-1.10.2.min.js"></script>

<script language="Javascript">
	
	//This function resizes an element to fit within a certain available size.
	//I can tweak it with by adjusting the availableHeight/availableWidth variables if necessary
	function autoResize(id){
		var newHeight;
		var newWidth;
		var maxHeight=326;
		var minHeight=190;
		var availableWidth;
		var sideMargin=48;
		var availableHeight=$(window).height()-600;
		if ($(window).width()<950) availableWidth=950-sideMargin-sideMargin;
		else availableWidth=$(window).width()-sideMargin-sideMargin;
		
		var aspectRatio=326/326;	
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
		if ($(window).height() > $('#mainContent').height()) $('#mainContent').height($(window).height()-20+'px');
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