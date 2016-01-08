<?php
	ob_start();
?>

<html>
<body>

	<?php
		
		
		$chUsrVar = $_GET['chUsr'];
		$creUsrVar = $_GET['creUsr'];
		$delUsrVar = $_GET['delUsr'];
		$ViewUsrVar = $_GET['viewUsr'];
		
		if( $chUsrVar == 'ChangeUser' )
		{
			header('Location:ChangeUser.php');
		}
		if( $creUsrVar == 'CreateUser' )
		{
			header('Location:CreateUser.php');
		}	
		if( $delUsrVar == 'DeleteUser' )
		{
			header('Location:DeleteUser.php');
		}	
		if( $ViewUsrVar == 'ViewUser' )
		{
			header('Location:ViewUser.php');
		}	
	?>

</body>
</html>