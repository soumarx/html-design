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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE newsletter SET nome=%s, email=%s WHERE id=%s",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_ConexaoMySQL, $ConexaoMySQL);
  $Result1 = mysql_query($updateSQL, $ConexaoMySQL) or die(mysql_error());

  $updateGoTo = "newsletter.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_RS_newsletter = "-1";
if (isset($_GET['id'])) {
  $colname_RS_newsletter = $_GET['id'];
}
mysql_select_db($database_ConexaoMySQL, $ConexaoMySQL);
$query_RS_newsletter = sprintf("SELECT * FROM newsletter WHERE id = %s", GetSQLValueString($colname_RS_newsletter, "int"));
$RS_newsletter = mysql_query($query_RS_newsletter, $ConexaoMySQL) or die(mysql_error());
$row_RS_newsletter = mysql_fetch_assoc($RS_newsletter);
$totalRows_RS_newsletter = mysql_num_rows($RS_newsletter);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sem título</title>
<style type="text/css">

.style1 {
	background-color:#666666;
	color:#FFFFFF;
}

.titulo {
	color: #00F;
}
.sub_titulo {
	color: #036;
}
.style2 a{
	color:#FF0000;
	text-decoration:none;
}

</style>
</head>

<body>
<h1 class="titulo">Newsletter - Edição</h1>
<p>Formulário para edição de um registro da tabela de Newsletter:</p>
<h3 class="sub_titulo">Dados da Newsletter</h3>
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  <table border="0">
    <tr>
      <th scope="row" class="style1" width="100px">Nome</th>
      <td><input name="nome" type="text" id="nome" value="<?php echo $row_RS_newsletter['nome']; ?>" /></td>
    </tr>
    <tr>
      <th scope="row" class="style1">Email</th>
      <td><input name="email" type="text" id="email" value="<?php echo $row_RS_newsletter['email']; ?>" /></td>
    </tr>
    <tr>
      <th align="right" scope="row">&nbsp;</th>
      <td><input type="submit" name="button" id="button" value="Enviar" />
      <input name="id" type="hidden" id="id" value="<?php echo $row_RS_newsletter['id']; ?>" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
<p class="style2"><small><a href="newsletter.php"><< Voltar</a></small></p>
</body>
</html>
<?php
mysql_free_result($RS_newsletter);
?>
