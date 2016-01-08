<link href="style.css" rel="stylesheet" type="text/css" />
<?php

date_default_timezone_set("Asia/Calcutta");

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
<?php ob_start(); ?>	
<?php require_once('Connections/BankSimulatorServer.php'); ?>

<?php

	if (!isset($_SESSION)) 
  		session_start();

	$cid = 	$_GET["cust_id"];
	$amt = 	$_GET["amount"];
	
	$query1 = "SELECT `amount` FROM `dbbanksimulator`.`tbl_customer_details` WHERE cust_id=$cid";
	$resultSet1 = mysql_query($query1);
	$n1 = mysql_num_rows($resultSet1);
	
	if( $n1 > 0 )
	{
		$row = mysql_fetch_assoc($resultSet1);
		$oldAmt = $row['amount'];
		
		if( $oldAmt - $amt >= 500 )
		{
			$query2 = "UPDATE `dbbanksimulator`.`tbl_customer_details` SET `amount` = $oldAmt-$amt
					WHERE `tbl_customer_details`.`cust_id` =$cid";
			$resultSet2 = mysql_query($query2);
		
		
			if( $resultSet2 )
			{
				$_SESSION['msg'] = "<h2>Withdrawal successful.</h2>";
				
				//Updating transaction table

				$transDate = date("Y-m-d");
				$debitOrCredit = 'D';
				$transAmt = $_GET['amount'];
				$cid = $_GET['cust_id'];
				$modifier = $_SESSION['userType'];
				$modifierID = $_SESSION['uid'];
				
				$query = "INSERT INTO `dbbanksimulator`.`tbl_transactions`(trans_date ,debit_credit ,trans_amount ,cust_id ,modifier ,modifier_id)
							VALUES ('$transDate','$debitOrCredit','$transAmt','$cid','$modifier','$modifierID')";
				$resultSet = mysql_query($query);
				
				/*if( $resultSet )
				{
					//Transaction table update successful
					echo "<br />Transaction table update successful";
				}
				else
				{
					//Transfaction table update failes
					echo "<br />Transaction table update failed";
				}*/
			}
			else
				$_SESSION['msg'] = "<h2>Withdraw failed.</h2>";
		}
		else
		{
			$_SESSION['msg'] = "<h2>Withdrawal is not allowed, as the account balance will become less than 500.</h2>";
		}
	}
	else
	{
		$_SESSION['msg'] = "<h2>Given Customer ID does not exist.</h2>";
	}
	
	header("Location:withdraw_amount.php");
?>