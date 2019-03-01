<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_ConexaoMySQL = "localhost";
$database_ConexaoMySQL = "pw02projeto";
$username_ConexaoMySQL = "root";
$password_ConexaoMySQL = "";
$ConexaoMySQL = mysql_pconnect($hostname_ConexaoMySQL, $username_ConexaoMySQL, $password_ConexaoMySQL) or trigger_error(mysql_error(),E_USER_ERROR); 
?>