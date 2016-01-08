<?php

	function manager_or_teller_option_link()
	{
		if( $_SESSION['userType'] == 'M' )
			echo "<br /><br /><a href='manager_options.php'>Manager's Options page</a>";
		else
			echo "<br /><br /><a href='teller_options.php'>Teller's Options page</a>";
	}

?>