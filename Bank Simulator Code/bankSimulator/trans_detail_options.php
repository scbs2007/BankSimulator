<?php

include("functions.php");
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Transaction Detail Options</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>

<p style="text-align:right"><a href="<?php echo $logoutAction ?>">Log out</a></p>

<h1 style="background:url(images/transaction_detail_options.png) no-repeat; text-indent:-9999px;">Transaction Details Options</h1>


<form action="process_trans_options.php" method="get" name="trans_detail_opt" id="trans_detail_opt">
<div style="border:1px solid #a23668;
background :url(images/fieldset.png) repeat-x;">
    <input name="t1" type="submit" value="View Daily Transaction" />
    <input name="t2" type="submit" value="View Teller Transaction" />
</div>
   
</form>

<?php manager_or_teller_option_link(); ?><br />
 
</body>
</html>