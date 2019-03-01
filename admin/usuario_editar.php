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
  $updateSQL = sprintf("UPDATE usuario SET login=%s, senha=%s, nome_usuario=%s, ativo=%s WHERE id_usuario=%s",
                       GetSQLValueString($_POST['login'], "text"),
                       GetSQLValueString($_POST['senha'], "text"),
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['ativo'], "int"),
                       GetSQLValueString($_POST['id_usuario'], "int"));

  mysql_select_db($database_ConexaoMySQL, $ConexaoMySQL);
  $Result1 = mysql_query($updateSQL, $ConexaoMySQL) or die(mysql_error());

  $updateGoTo = "usuario.php?status=1";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_RS_editar = "-1";
if (isset($_GET['id_usuario'])) {
  $colname_RS_editar = $_GET['id_usuario'];
}
mysql_select_db($database_ConexaoMySQL, $ConexaoMySQL);
$query_RS_editar = sprintf("SELECT id_usuario, login, senha, nome_usuario, ativo FROM usuario WHERE id_usuario = %s", GetSQLValueString($colname_RS_editar, "int"));
$RS_editar = mysql_query($query_RS_editar, $ConexaoMySQL) or die(mysql_error());
$row_RS_editar = mysql_fetch_assoc($RS_editar);
$totalRows_RS_editar = mysql_num_rows($RS_editar);
?>
<!DOCTYPE html>
<html class="ls-theme-blue">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://assets.locaweb.com.br/locastyle/3.2.2/stylesheets/locastyle.css" rel="stylesheet" type="text/css">
<title>Usuários</title>

<style type="text/css">
.style1{ margin-left:10px;}
</style>

</head>

<body>

<?php require('comum/cabecalho.php'); ?>

  <div class="ls-main">
  	<ol class="ls-breadcrumb">
      <li><a href="usuario.php">Início</a></li>
      <li>Editar</li>
    </ol>
    <br>
    <p class="style1">Formulário para edição de dados de um usuário do sistema.</p>
    <h3 class="style1">Dados do usuário</h3>
      <form action="<?php echo $editFormAction; ?>" id="form1" class="ls-form" name="form1" method="POST">
        <table width="100%" border="0" class="ls-table">
          <tr>
            <th width="18%" align="right" scope="col"><strong>Login:</strong></th>
            <th width="82%" align="left" scope="col"><input name="login" type="text" id="login" value="<?php echo $row_RS_editar['login']; ?>" /></th>
          </tr>
          <tr>
            <td align="right"><strong>Senha:</strong></td>
            <td align="left"><input name="senha" type="password" id="senha" value="<?php echo $row_RS_editar['senha']; ?>" /></td>
          </tr>
          <tr>
            <td align="right"><strong>Nome:</strong></td>
            <td align="left"><input name="nome" type="text" id="nome" value="<?php echo $row_RS_editar['nome_usuario']; ?>" /></td>
          </tr>
          <tr>
            <td align="right"><strong>Ativo?</strong></td>
            <td align="left"><p>
              <label>
                <input <?php if (!(strcmp($row_RS_editar['ativo'],"1"))) {echo "checked=\"checked\"";} ?> type="radio" name="ativo" value="1" id="ativo_0" />
                Sim</label>
              <br />
              <label>
                <input <?php if (!(strcmp($row_RS_editar['ativo'],"0"))) {echo "checked=\"checked\"";} ?> type="radio" name="ativo" value="0" id="ativo_1" />
                Não</label>
              <br />
            </p></td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td align="left"><input name="id_usuario" type="hidden" id="id_usuario" value="<?php echo $row_RS_editar['id_usuario']; ?>" />        <input type="submit" name="button" class="ls-btn-primary" id="button" value="Salvar dados" /></td>
          </tr>
          
        </table>
        <input type="hidden" name="MM_update" value="form1" />
      </form>
	</div>
   <?php require('comum/sidebar.php'); ?>
</body>
</html>
<?php
mysql_free_result($RS_editar);
?>
