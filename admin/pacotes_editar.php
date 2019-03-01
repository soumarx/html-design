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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	$nomeArquivo = $row_RS_pacote['foto_destaque'];
	
	if (isset($_FILES['foto'])){
		$nomeArquivo = $_FILES['foto']['name'];
		move_uploaded_file($_FILES['foto']['tmp_name'],'../assets/uploads/' . $nomeArquivo);
	}
  $updateSQL = sprintf("UPDATE pacotes SET titulo=%s, regiao=%s, cidade_destino=%s, resumo=%s, descricao=%s, promocional=%s, valor_pacote=%s, foto_destaque=%s, ativo=%s, data_cadastro=%s WHERE id=%s",
                       GetSQLValueString($_POST['titulo'], "text"),
                       GetSQLValueString($_POST['regiao'], "text"),
                       GetSQLValueString($_POST['destino'], "text"),
                       GetSQLValueString($_POST['resumo'], "text"),
                       GetSQLValueString($_POST['descricao'], "text"),
                       GetSQLValueString($_POST['promocional'], "text"),
                       GetSQLValueString($_POST['valor_pacote'], "double"),
                       GetSQLValueString($nomeArquivo, "text"),
                       GetSQLValueString($_POST['ativo'], "text"),
                       GetSQLValueString($_POST['data_cadastro'], "date"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_ConexaoMySQL, $ConexaoMySQL);
  $Result1 = mysql_query($updateSQL, $ConexaoMySQL) or die(mysql_error());

  $updateGoTo = "pacotes.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_RS_pacote = "-1";
if (isset($_GET['id'])) {
  $colname_RS_pacote = $_GET['id'];
}
mysql_select_db($database_ConexaoMySQL, $ConexaoMySQL);
$query_RS_pacote = sprintf("SELECT * FROM pacotes WHERE id = %s", GetSQLValueString($colname_RS_pacote, "int"));
$RS_pacote = mysql_query($query_RS_pacote, $ConexaoMySQL) or die(mysql_error());
$row_RS_pacote = mysql_fetch_assoc($RS_pacote);
$totalRows_RS_pacote = mysql_num_rows($RS_pacote);
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
      <td align="left"><input name="titulo" type="text" id="titulo" value="<?php echo $row_RS_pacote['titulo']; ?>"></td>
    </tr>
    <tr>
      <th scope="row">Região</th>
      <td><input name="regiao" type="text" id="regiao" value="<?php echo $row_RS_pacote['regiao']; ?>"></td>
    </tr>
    <tr>
      <th scope="row">Destino</th>
      <td><input name="destino" type="text" id="destino" value="<?php echo $row_RS_pacote['cidade_destino']; ?>"></td>
    </tr>
    <tr>
      <th scope="row">Resumo</th>
      <td><textarea name="resumo" id="resumo" cols="45" rows="5"><?php echo $row_RS_pacote['resumo']; ?></textarea></td>
    </tr>
    <tr>
      <th scope="row">Descrição</th>
      <td><textarea name="descricao" id="descricao" cols="45" rows="5"><?php echo $row_RS_pacote['descricao']; ?></textarea></td>
    </tr>
    <tr>
      <th scope="row">Promocional</th>
      <td><p>
        <label>
          <input <?php if (!(strcmp($row_RS_pacote['promocional'],"s"))) {echo "checked=\"checked\"";} ?> type="radio" name="promocional" value="s" id="promocional_0">
          Sim</label>
        <br>
        <label>
          <input <?php if (!(strcmp($row_RS_pacote['promocional'],"n"))) {echo "checked=\"checked\"";} ?> type="radio" name="promocional" value="n" id="promocional_1">
          Não</label>
        <br>
      </p></td>
    </tr>
    <tr>
      <th scope="row">Valor do Pacote</th>
      <td><input name="valor_pacote" type="text" value="<?php echo $row_RS_pacote['valor_pacote']; ?>"></td>
    </tr>
    <tr>
      <th scope="row">Foto</th>
      <td><p>
        <input type="file" name="foto" id="foto">
      </p>
        <p>
          <input type="image" name="foto_preview" id="foto_preview" src="../assets/uploads/<?php echo $row_RS_pacote['foto_destaque']; ?>">
        </p></td>
    </tr>
    <tr>
      <th scope="row">Ativo</th>
      <td><p>
        <label>
          <input <?php if (!(strcmp($row_RS_pacote['ativo'],"s"))) {echo "checked=\"checked\"";} ?> type="radio" name="ativo" value="s" id="ativo_0">
          Sim</label>
        <br>
        <label>
          <input <?php if (!(strcmp($row_RS_pacote['ativo'],"n"))) {echo "checked=\"checked\"";} ?> type="radio" name="ativo" value="n" id="ativo_1">
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
  <input name="id" type="hidden" id="id" value="<?php echo $row_RS_pacote['id']; ?>">
  <input type="hidden" name="MM_update" value="form1">
</form>
<br>


</div>
   <?php require('comum/sidebar.php'); ?>
</body>
</html>
<?php
mysql_free_result($RS_pacote);
?>
