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
		
	$cidFrom = 	$_GET["from_cust_id"];
	$amtFrom = 	$_GET["amount"];
	$cidTo = 	$_GET["to_cust_id"];
	
	if( $cidFrom != $cidTo )
	{
		$queryFrom = "SELECT `amount` FROM `dbbanksimulator`.`tbl_customer_details` WHERE cust_id=$cidFrom";
		$resultSetFrom = mysql_query($queryFrom);
		$nFrom = mysql_num_rows($resultSetFrom);
		
		$queryTo = "SELECT `amount` FROM `dbbanksimulator`.`tbl_customer_details` WHERE cust_id=$cidTo";
		$resultSetTo = mysql_query($queryTo);
		$nTo = mysql_num_rows($resultSetTo);

		if( ($nFrom > 0) && ($nTo > 0) )
		{
			$rowFrom = mysql_fetch_assoc($resultSetFrom);
			$oldAmtFrom = $rowFrom['amount'];
			
			$rowTo = mysql_fetch_assoc($resultSetTo);
			$oldAmtTo = $rowTo['amount'];
			
			if( $oldAmtFrom - $amtFrom >= 500 )
			{
				$query1 = "UPDATE `dbbanksimulator`.`tbl_customer_details` SET `amount` = $oldAmtFrom-$amtFrom
						WHERE `tbl_customer_details`.`cust_id` =$cidFrom";
				$resultSet1 = mysql_query($query1);
				
				$query2 = "UPDATE `dbbanksimulator`.`tbl_customer_details` SET `amount` = $oldAmtTo+$amtFrom
						WHERE `tbl_customer_details`.`cust_id` =$cidTo";
				$resultSet2 = mysql_query($query2);
			
				if( $resultSet1 && $resultSet1 )
				{
					$_SESSION['msg'] = "<h2>Transfer was made successfully.</h2>";
					
					//Updating transaction table for sender
	
					$transDate = date("Y-m-d");
					$debitOrCredit = 'D';
					$transAmt = $_GET['amount'];
					$cid = $_GET['from_cust_id'];
					$modifier = $_SESSION['userType'];
					$modifierID = $_SESSION['uid'];
					
					$query3 = "INSERT INTO `dbbanksimulator`.`tbl_transactions`(trans_date ,debit_credit ,trans_amount ,cust_id ,modifier ,modifier_id)
								VALUES ('$transDate','$debitOrCredit','$transAmt','$cid','$modifier','$modifierID')";
					$resultSet3 = mysql_query($query3);
					
					//Updating transaction table for receiver
					
					$transDate = date("Y-m-d");
					$debitOrCredit = 'C';
					$transAmt = $_GET['amount'];
					$cid = $_GET['to_cust_id'];
					$modifier = $_SESSION['userType'];
					$modifierID = $_SESSION['uid'];
					
					$query4 = "INSERT INTO `dbbanksimulator`.`tbl_transactions`(trans_date ,debit_credit ,trans_amount ,cust_id ,modifier ,modifier_id)
								VALUES ('$transDate','$debitOrCredit','$transAmt','$cid','$modifier','$modifierID')";
					$resultSet4 = mysql_query($query4);
					
					/*if( $resultSet3 && $resultSet4)
					{
						//Transaction table update successfull
						echo "<br />Transaction table update successful.";
					}
					else
					{
						//Transfaction table update failes
						echo "<br />Transaction table update failed";
					}*/
				}
				else
					$_SESSION['msg'] = "<h2>Transfer failed.</h2>";
			}
			else
			{
				$_SESSION['msg'] = "<h2>Transfer is not allowed, as the account balance will become less than 500.</h2>";
			}
		}
		else
		{
			$_SESSION['msg'] = "<h2>Either of the given customer IDs do not exit.</h2>";
		}
	}
	
	else
		$_SESSION['msg'] = "<h2>Customer IDs are same.</h2>";
	
	header("Location:transfer_amount.php");
?>