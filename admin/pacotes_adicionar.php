<?php require_once('../Connections/ConexaoMySQL.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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
	$nomeArquivo = $_FILES['foto']['name'];
	move_uploaded_file($_FILES['foto']['tmp_name'], '../assets/uploads/' . $nomeArquivo);	
	
  $insertSQL = sprintf("INSERT INTO pacotes (titulo, regiao, cidade_destino, resumo, descricao, promocional, foto_destaque, ativo, data_cadastro) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['titulo'], "text"),
                       GetSQLValueString($_POST['regiao'], "text"),
                       GetSQLValueString($_POST['destino'], "text"),
                       GetSQLValueString($_POST['resumo'], "text"),
                       GetSQLValueString($_POST['descricao'], "text"),
                       GetSQLValueString($_POST['promocional'], "text"),
                       GetSQLValueString($nomeArquivo, "text"),
                       GetSQLValueString($_POST['ativo'], "text"),
                       GetSQLValueString($_POST['data_cadastro'], "date"));

  mysql_select_db($database_ConexaoMySQL, $ConexaoMySQL);
  $Result1 = mysql_query($insertSQL, $ConexaoMySQL) or die(mysql_error());

  $insertGoTo = "pacotes.php";
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
<li><a href="pacotes.php">Pacotes</a></li>
<li>Adicionar</li>
</ol>
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">
  <table class="ls-table">
    <tr>
      <th scope="row" width="15%">Título</th>
      <td align="left"><input type="text" name="titulo" id="titulo"></td>
    </tr>
    <tr>
      <th scope="row">Região</th>
      <td><input type="text" name="regiao" id="regiao"></td>
    </tr>
    <tr>
      <th scope="row">Destino</th>
      <td><input type="text" name="destino" id="destino"></td>
    </tr>
    <tr>
      <th scope="row">Resumo</th>
      <td><textarea name="resumo" id="resumo" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <th scope="row">Descrição</th>
      <td><textarea name="descricao" id="descricao" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <th scope="row">Promocional</th>
      <td><p>
        <label>
          <input type="radio" name="promocional" value="s" id="promocional_0">
          Sim</label>
        <br>
        <label>
          <input type="radio" name="promocional" value="n" id="promocional_1">
          Não</label>
        <br>
      </p></td>
    </tr>
    <tr>
      <th scope="row">Valor do Pacote</th>
      <td><input id="valor_pacote" name="valor_pacote" type="text"></td>
    </tr>
    <tr>
      <th scope="row">Foto</th>
      <td><input type="file" name="foto" id="foto"></td>
    </tr>
    <tr>
      <th scope="row">Ativo</th>
      <td><p>
        <label>
          <input type="radio" name="ativo" value="s" id="ativo_0">
          Sim</label>
        <br>
        <label>
          <input type="radio" name="ativo" value="n" id="ativo_1">
          Não</label>
        <br>
      </p></td>
    </tr>
    <tr>
      <th scope="row"></th>
      <td><input name="button" type="submit" value="Enviar" class="ls-btn-primary"></td>
    </tr>
  </table>
  <input name="data_cadastro" type="hidden" value="<?php echo date("Y-m-d H:i:s");?>">
  <input type="hidden" name="MM_insert" value="form1">
</form>
<br>


</div>
   <?php require('comum/sidebar.php'); ?>
</body>
</html>