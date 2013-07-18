<html>
<head>

	<title>Ajax testing grounds</title>

</head>
</body>

<form id="loginForm" name="loginForm" method="post" action="ajax.php">
	<input type="submit" />
</form>


<div id="ajaxdiv">
Ajax stuff goes here.
</div>


<script language="Javascript">
	/* attach a submit handler to the login form */
	$(document).on('submit', '#loginForm', function(event) {
		/* stop form from submitting normally */
		event.preventDefault();
		
		/* hide our error message if it's displayed */		
		$('#errorCardNo').hide();
		
		/* Validate to ensure that the numbers are the correct length/format and that there's data here.*/
		var cardNumber = document.getElementById('cardNoField').value;
		if (cardNumber.length == 14 && !isNaN(cardNumber)) {			
			/* Show the waiting spinner
			$('#enterText').hide();
			$('#loadSpinner').show(); */

			//Post the data with Ajax and figure out what library we are coming from.		
			url = $('#loginForm').attr( 'action' ),
			formdata = $('#loginForm').serialize(),
			/* Send the data using post */
			$.post( url, formdata)
			.done(function(data) {
				$('#meInfo').show();
				$('#meInfoP').replaceWith(data);
			});
		} else $('#errorCardNo').fadeIn(500);
		//$('#loginForm').submit();
	});
</script>


</body>

</html>