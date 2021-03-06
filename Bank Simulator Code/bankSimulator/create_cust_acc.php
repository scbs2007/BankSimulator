<?php
date_default_timezone_set("Asia/Calcutta");

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

$MM_restrictGoTo = "manager_login.php";
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
<?php require_once('Connections/BankSimulatorServer.php'); ?>
<?php

if (!isset($_SESSION)) {
  session_start();
}

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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "create_cust_acc")) {
  $insertSQL = sprintf("INSERT INTO tbl_customer_details (full_name, amount) VALUES (%s, %s)",
                       GetSQLValueString($_POST['t2'], "text"),
                       GetSQLValueString($_POST['t3'], "int"));
					   

  mysql_select_db($database_BankSimulatorServer, $BankSimulatorServer);
  $Result1 = mysql_query($insertSQL, $BankSimulatorServer) or die(mysql_error());
  
  echo "<h2>Customer account has been created successfully</h2>";
  
  //Updating transaction table

	$transDate = date("Y-m-d");
	$debitOrCredit = 'C';
	$transAmt = $_POST['t3'];
	$cid =  mysql_insert_id();	//Will give the customer id generated by the customer account creation query,above
	$modifier = $_SESSION['userType'];
	$modifierID = $_SESSION['uid'];
	
	$query = "INSERT INTO `dbbanksimulator`.`tbl_transactions`(trans_date ,debit_credit ,trans_amount ,cust_id ,modifier ,modifier_id)
				VALUES ('$transDate','$debitOrCredit','$transAmt','$cid','$modifier','$modifierID')";
	$resultSet = mysql_query($query);
	
	/*if( $resultSet )
	{
		//Transaction table update successfull
		echo "Transaction table update successfull";
	}
	else
	{
		//Transfaction table update failes
		echo "Transaction table update failed";
	}*/
}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Create Customer Account</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>

<p style="text-align:right"><a href="<?php echo $logoutAction ?>">Log out</a></p>

<h1 style="background:url(images/create_customer_account.png) no-repeat; text-indent:-9999px;">Create Customer Account</h1>

<form action="<?php echo $editFormAction; ?><?php echo $editFormAction; ?>" method="POST" name="create_cust_ac" id="create_cust_ac">

<fieldset>
  
  <label for="t2"><span>Full Name</span> 
  <span id="sprytextfield3">
    <input type="text" name="t2" id="t2" />
    <span class="textfieldRequiredMsg">A value is required.</span></span></label>
  <span id="sprytextfield3"><span class="textfieldRequiredMsg">A value is required.</span></span></span>
  
  <label for="t3"><span>Starting Amount</span>
  <span id="sprytextfield2">
  <input type="text" name="t3" id="t3" />
  <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span><span class="textfieldMinValueMsg">Value should be atleast 500.</span></span></label>
  </fieldset>
  <div>
  <input type="submit" name="submit" id="submit" value="Submit" />
  <input type="reset" name="reset" id="reset" value="Reset" />
  <input type="hidden" name="MM_insert" value="create_cust_acc" /> 
  </div>
</form>
<br />
  <a href="manager_options.php">Manager's Options page </a>
<br />
  
<script type="text/javascript">
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {validateOn:["blur"], minValue:500});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur"]});
</script>
</body>
</html>