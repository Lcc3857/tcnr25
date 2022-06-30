<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_tcnr25 = "localhost";
$database_tcnr25 = "tcnr025";
$username_tcnr25 = "root";
$password_tcnr25 = "12345678";
$tcnr25 = mysql_pconnect($hostname_tcnr25, $username_tcnr25, $password_tcnr25) or trigger_error(mysql_error(),E_USER_ERROR); 
?>