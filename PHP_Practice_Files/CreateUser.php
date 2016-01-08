<?php

	include("sessionHandler.php");
?>

<html>
<link href="myCSSfile.css" rel="stylesheet" type="text/css">
<body>

	<h1>Create Page</h1>
	
	<div class="mainContainer">
	
		<form action="AddingUser.php" method="get" class="form">
		  <label for="textfield">Username</label>
		  <input type="text" name="usrNameField" tabindex="10" id="usrNameField">
		  
		  <label for="Submit"></label>
		  <p>&nbsp;</p>
		  <p>
		    <label for="label">Password</label>
		    <input type="password" name="passField" tabindex="20" id="label">
		  </p>
		  
		  <p>&nbsp;</p>
		  <p>
		     <input type="submit" name="Submit" value="Submit" tabindex="30">
		    <input name="reset" type="reset" id="reset" tabindex="40" value="Reset">
		  </p>
	  </form>
	
	</div>

</body>
</html>