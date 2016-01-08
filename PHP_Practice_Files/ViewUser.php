<?php include("sessionHandler.php"); ?>
<?php require_once('Connections/My_PHP_App_Con.php'); ?>
<?php
mysql_select_db($database_My_PHP_App_Con, $My_PHP_App_Con);
$query_rsUsers = "SELECT UserName FROM userauthentication ORDER BY UserName ASC";
$rsUsers = mysql_query($query_rsUsers, $My_PHP_App_Con) or die(mysql_error());
$row_rsUsers = mysql_fetch_assoc($rsUsers);
$totalRows_rsUsers = mysql_num_rows($rsUsers);
?>

<html>

	<title> View Users</title>

	<link href="myCSSfile.css" rel="stylesheet" type="text/css">
<body>

	<div class="mainContainer">
		<h1>View User Page</h1>
	
		<h2>Users who registered with us</h2>
	
		<h3>User Names</h3>
		
    <?php 
		do 
		{
      		echo $row_rsUsers['UserName']."<br />"; 
      	}while ($row_rsUsers = mysql_fetch_assoc($rsUsers)); 
	 ?>
	  
	</div>
</body>

</html>

<?php
	mysql_free_result($rsUsers);
?>
