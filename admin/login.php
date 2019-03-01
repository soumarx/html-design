<?php require_once('../Connections/ConexaoMySQL.php'); ?>
<?php
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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['usuario'])) {
  $loginUsername=$_POST['usuario'];
  $password=$_POST['senha'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "index.php";
  $MM_redirectLoginFailed = "erro.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_ConexaoMySQL, $ConexaoMySQL);
  
  $LoginRS__query=sprintf("SELECT login, senha FROM usuario WHERE login=%s AND senha=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $ConexaoMySQL) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html>
<html class="ls-theme-blue">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema Administrativo</title>
<link href="http://assets.locaweb.com.br/locastyle/3.2.2/stylesheets/locastyle.css" rel="stylesheet" type="text/css">
</head>
<style>
body { margin:0 auto;}
</style>

<body>
<div align="center" style="vertical-align:middle; margin-top:30px;">
<img src="_imagens/img_logo.png" width="185" height="250" align="middle" style="margin-bottom: 15px;">
<form name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
  <table width="300" align="center" style="border: 1px solid #ccc;" height="150">
    <tr>
      <th width="72" align="right" scope="row">Usuário:</th>
      <td width="212" align="center"><input type="text" name="usuario" id="usuario"></td>
    </tr>
    <tr>
      <th align="right" scope="row">Senha:</th>
      <td align="center"><input type="password" name="senha" id="senha"></td>
    </tr>
    <tr>
      <th align="right" scope="row">&nbsp;</th>
      <td align="center"><input class="ls-btn-primary" type="submit" name="button" id="button" value="Enviar"></td>
    </tr>
  </table>
</form>
</div>
<p>&nbsp;</p>
</body>
</html>
