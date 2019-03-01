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

mysql_select_db($database_ConexaoMySQL, $ConexaoMySQL);
$query_RS_newsletter = "SELECT * FROM newsletter ORDER BY nome ASC";
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
.style2{
	border:1px solid #999;
	background-color:#eaeaea;	
}

.titulo {
	color: #00F;
}
</style>
</head>

<body>
<h1 class="titulo">Newsletter</h1>
<p>Lista de registro de newsletter cadastradas no sistema:</p>
<p><a href="news_adicionar.php">Adicionar newsletter</a></p>
<table width="100%" border="0">
  <tr class="style1">
    <th scope="col" class="style1">ID</th>
    <th scope="col" class="style1">Nome</th>
    <th scope="col" class="style1">Email</th>
    <th scope="col" class="style1">Ações</th>
  </tr>
  <?php do { ?>
    <tr>
      <td class="style2" align="center"><?php echo $row_RS_newsletter['id']; ?></td>
      <td class="style2" align="center"><?php echo $row_RS_newsletter['nome']; ?></td>
      <td class="style2" align="center"><?php echo $row_RS_newsletter['email']; ?></td>
      <td align="center" class="style2"><a href="news_editar.php?id=<?php echo $row_RS_newsletter['id']; ?>">Editar</a> | <a href="news_excluir.php?id=<?php echo $row_RS_newsletter['id']; ?>">Excluir</a></td>
    </tr>
    <?php } while ($row_RS_newsletter = mysql_fetch_assoc($RS_newsletter)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($RS_newsletter);
?>
