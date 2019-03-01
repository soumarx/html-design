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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO usuario (login, senha, nome_usuario, ativo, data_cadastro) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['login'], "text"),
                       GetSQLValueString($_POST['senha'], "text"),
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['ativo'], "int"),
                       GetSQLValueString($_POST['data_cadastro'], "date"));

  mysql_select_db($database_ConexaoMySQL, $ConexaoMySQL);
  $Result1 = mysql_query($insertSQL, $ConexaoMySQL) or die(mysql_error());

  $insertGoTo = "usuario.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
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
      <li>Adicionar</li>
    </ol>
    <br>
    <p class="style1">Formulário para inclusão de um novo usuário no sistema.</p>
    <h3 class="style1">Dados do usuário</h3>
    <form class="ls-form" id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
      <table width="100%" border="0" class="ls-table">
        <tr>
          <th width="18%" align="right" scope="col"><strong>Login:</strong></th>
          <th width="82%" align="left" scope="col"><input type="text" name="login" id="login" /></th>
        </tr>
        <tr>
          <td align="right"><strong>Senha:</strong></td>
          <td align="left"><input type="password" name="senha" id="senha" /></td>
        </tr>
        <tr>
          <td align="right"><strong>Nome:</strong></td>
          <td align="left"><input type="text" name="nome" id="nome" /></td>
        </tr>
        <tr>
          <td align="right"><strong>Ativo?</strong></td>
          <td align="left"><p>
            <label>
              <input type="radio" name="ativo" value="1" id="ativo_0" />
              Sim</label>
            <br />
            <label>
              <input type="radio" name="ativo" value="0" id="ativo_1" />
              Não</label>
            <br />
          </p></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left"><input name="data_cadastro" type="hidden" id="data_cadastro" value="<?php echo date("Y-m-d H:i:s");?>" />
          <input class="ls-btn-primary" type="submit" name="button" id="button" value="Salvar dados" /></td>
        </tr>
        
      </table>
      <input type="hidden" name="MM_insert" value="form1" />
    </form>
   </div>
   <?php require('comum/sidebar.php'); ?>
</body>
</html>