<!--- This pushes the page down so the footer doesn't overlap anything if you need to scroll to the bottom of content --->
<div class="footer">
<div class="footerText">Copyright 2013 | <a href="#">Terms</a> | <a href="#">Privacy Policy</a> | <a href="#">Help</a></div>
<img src="images/me_white.png" alt="join me . show me . free me" style="width:100px;margin:16px 40px 16px 0px;float:right;" />
</div>
</div><!--logoAndForm-->


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

			//Let's post the data with Ajax and figure out what library we are coming from.		
			url = $('#loginForm').attr( 'action' ),
			formdata = $('#loginForm').serialize(),
			/* Send the data using post */
			$.post( url, formdata)
			.done(function(data) {
				/* Detect error condition. */
				dataObj = JSON.parse(data);
				
				if (dataObj.error) {
					$('#errorCardNo').show();
					$('#errorCardNo').empty();
					$('#errorCardNo').append(dataObj.errorMsg);				
				
				} else {
					/* Production version will submit data to a new page - the one that shows the customer their info */
					//Insert our JSON into the jsonField
					$('#jsonField').val(data)
					$('#jsonForm').submit();
					
					/*$('#meInfo').show();
					$('#meInfoP').empty();
					$('#meInfoP').append(dataObj.libraryName);*/
				}
			});
		} else $('#errorCardNo').fadeIn(500);
		//$('#loginForm').submit();
	});
</script>


</body>

</html>