<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_BankSimulatorServer = "localhost";
$database_BankSimulatorServer = "dbbanksimulator";
$username_BankSimulatorServer = "root";
$password_BankSimulatorServer = "";
$BankSimulatorServer = mysql_pconnect($hostname_BankSimulatorServer, $username_BankSimulatorServer, $password_BankSimulatorServer) or trigger_error(mysql_error(),E_USER_ERROR); 
?>