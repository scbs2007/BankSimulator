<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Welcome Page</title>
<link href="myCSSfile.css" rel="stylesheet" type="text/css" />

</head>

<body>

	<?php 
	
	if(isset($_SESSION['uid']))
		 {
			echo "<h1>Welcome ".$_SESSION['uid']."</h1>";
		
			echo "<a href='Logout.php'>Log out</a>";
			
			echo "<div class='mainContainer'>";
	
			echo "<form action='process.php' method='get' name='welcomeForm' class='form' id='welcomeForm'>";
	  
	    	echo "<input type='submit' name='chUsr' value='ChangeUser' />";
			echo "<input type='submit' name='creUsr' value='CreateUser' />";
	    	echo "<input type='submit' name='delUsr' value='DeleteUser' />";
	    	echo "<input type='submit' name='viewUsr' value='ViewUser' />";
	  		echo "</form>";
	  
			echo "</div>";
		 }
		 
		 else
		 {
		 	echo "Unauthentic access!";
		 }
	?>

</body>
</html>
