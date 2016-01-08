<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Index</title>
<link href="myCSSfile.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div class="mainContainer">
<form action="Login.php" method="get" name="form1" class="form" id="form1">

  <label for="usernameField">Username</label>
  <input name="t1" type="text" />
  
  <label for="passwordField"><br /><br />Password</label>
  
  <input name="t2" type="password" id="t2" />
  <br /> <br />
  
  <input type="submit" name="Submit" value="Submit"  />
  
  <input name="Reset" type="reset" id="Reset"  value="Reset" />
  
  <br /><br />
  
  <?php
  	echo $_REQUEST['a'];
  ?>
  
</form>
</div>
</body>
</html>