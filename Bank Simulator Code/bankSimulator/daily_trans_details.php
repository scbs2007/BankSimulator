<?php require_once('Connections/BankSimulatorServer.php'); 
	include("functions.php");
?>
<?php
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
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php

if (!isset($_SESSION)) 
  		session_start();
		
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

mysql_select_db($database_BankSimulatorServer, $BankSimulatorServer);
$query_rsDailyTransDetails = "SELECT * FROM tbl_transactions ORDER BY trans_id ASC";
$rsDailyTransDetails = mysql_query($query_rsDailyTransDetails, $BankSimulatorServer) or die(mysql_error());
$row_rsDailyTransDetails = mysql_fetch_assoc($rsDailyTransDetails);
$totalRows_rsDailyTransDetails = mysql_num_rows($rsDailyTransDetails);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Daily Transaction Details</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>

<p style="text-align:right"><a href="<?php echo $logoutAction ?>">Log out</a></p>

<h1 style="background:url(images/daily_transaction_details.png) no-repeat; text-indent:-9999px;">Daily Transaction Details</h1>
<div  style="border:1px solid #a23668;
background :url(images/fieldset.png) repeat-x;" align="center">
<table border="0">
  <tr>
    <th>Transaction ID</th>
    <th>Transaction Date</th>
    <th>Debit/Credit</th>
    <th>Transaction Amount</th>
    <th>Customer ID</th>
    <th>Modifier</th>
    <th>Modifier ID</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsDailyTransDetails['trans_id']; ?></td>
      <td><?php echo $row_rsDailyTransDetails['trans_date']; ?></td>
      <td><?php echo $row_rsDailyTransDetails['debit_credit']; ?></td>
      <td><?php echo $row_rsDailyTransDetails['trans_amount']; ?></td>
      <td><?php echo $row_rsDailyTransDetails['cust_id']; ?></td>
      <td><?php echo $row_rsDailyTransDetails['modifier']; ?></td>
      <td><?php echo $row_rsDailyTransDetails['modifier_id']; ?></td>
    </tr>
    <?php } while ($row_rsDailyTransDetails = mysql_fetch_assoc($rsDailyTransDetails)); ?>
</table>
</div>
<?php

	manager_or_teller_option_link();
		
	mysql_free_result($rsDailyTransDetails);
?><br />

</body>
</html>
