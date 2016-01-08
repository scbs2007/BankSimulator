<?php require_once('Connections/BankSimulatorServer.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "manager_options.php";
  $MM_redirectLoginFailed = "manager_login.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_BankSimulatorServer, $BankSimulatorServer);
  
  $LoginRS__query=sprintf("SELECT username, password FROM tbl_manager_details WHERE username=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $BankSimulatorServer) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;
	
	//Hand written
	$query=sprintf("SELECT man_id,username, password FROM tbl_manager_details WHERE username=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
    $MyLoginRS = mysql_query($query, $BankSimulatorServer) or die(mysql_error());
	$row = mysql_fetch_assoc($MyLoginRS);
    echo $_SESSION['uid'] = $row['man_id'];	
	$_SESSION['userType'] = 'M';        

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
	  echo "<br /><h2>Incorrect Username/Password</h2>";
    //header("Location: ". $MM_redirectLoginFailed );
	
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Manager Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>


<h1 style="background:url(images/manager_login.png) no-repeat; text-indent:-9999px;"> Manager Login </h1>

<form action="<?php echo $loginFormAction; ?>" method="POST" name="login" id="login">

<fieldset>
      
      <label for="username"><span> Username </span>
      <span id="sprytextfield1">
      <input type="text" name="username" id="username" />
      <span class="textfieldRequiredMsg"> A value is required. </span></span> </label>
      
      <label for="password"><span> Password </span>
      <span id="sprypassword1">
      <input type="password" name="password" id="password" />
      <span class="passwordRequiredMsg"> A value is required. </span></span></label>
      </fieldset>
      <div>
      <input type="submit" name="login" id="login" value="Login" />
      <input type="reset" name="reset" id="reset" value="Reset" />
      </div>

</form>

<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1", {validateOn:["blur"]});
</script>
<br />
<a href="index.php">Back</a>
</body>
</html>