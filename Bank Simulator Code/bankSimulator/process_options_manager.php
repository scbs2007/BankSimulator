<link href="style.css" rel="stylesheet" type="text/css" />
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
<?php
	ob_start();
?>

<?php

	$cca = $_GET['create_cust_acc'];
	$wa = $_GET['withdraw_amt'];
	$at = $_GET['add_teller'];
	$ta = $_GET['transfer_amt'];
	$da = $_GET['Deposit_Amount'];
	$td = $_GET['transaction_details'];
	
		if( $cca == 'Create Customer Account' )
		{
			header('Location:create_cust_acc.php');
		}
		else if( $wa == 'Withdraw Amount' )
		{
			header('Location:withdraw_amount.php');
		}	
		else if( $at == 'Add Teller' )
		{
			header('Location:add_teller.php');
		}	
		else if( $ta == 'Transfer Amount' )
		{
			header('Location:transfer_amount.php');
		}
		else if( $da == 'Deposit Amount' )
		{
			header('Location:deposit_amount.php');
		}
		else if( $td == 'Transaction Details' )
		{
			header('Location:trans_detail_options.php');
		}	
	?>