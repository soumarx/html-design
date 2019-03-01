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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_RS_pacotes = 3;
$pageNum_RS_pacotes = 0;
if (isset($_GET['pageNum_RS_pacotes'])) {
  $pageNum_RS_pacotes = $_GET['pageNum_RS_pacotes'];
}
$startRow_RS_pacotes = $pageNum_RS_pacotes * $maxRows_RS_pacotes;

mysql_select_db($database_ConexaoMySQL, $ConexaoMySQL);
$query_RS_pacotes = "SELECT id, titulo, regiao, cidade_destino, promocional, ativo, data_cadastro FROM pacotes ORDER BY id ASC";
$query_limit_RS_pacotes = sprintf("%s LIMIT %d, %d", $query_RS_pacotes, $startRow_RS_pacotes, $maxRows_RS_pacotes);
$RS_pacotes = mysql_query($query_limit_RS_pacotes, $ConexaoMySQL) or die(mysql_error());
$row_RS_pacotes = mysql_fetch_assoc($RS_pacotes);

if (isset($_GET['totalRows_RS_pacotes'])) {
  $totalRows_RS_pacotes = $_GET['totalRows_RS_pacotes'];
} else {
  $all_RS_pacotes = mysql_query($query_RS_pacotes);
  $totalRows_RS_pacotes = mysql_num_rows($all_RS_pacotes);
}
$totalPages_RS_pacotes = ceil($totalRows_RS_pacotes/$maxRows_RS_pacotes)-1;

$queryString_RS_pacotes = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RS_pacotes") == false && 
        stristr($param, "totalRows_RS_pacotes") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RS_pacotes = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RS_pacotes = sprintf("&totalRows_RS_pacotes=%d%s", $totalRows_RS_pacotes, $queryString_RS_pacotes);
?>

<!DOCTYPE html>
<html class="ls-theme-blue">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://assets.locaweb.com.br/locastyle/3.2.2/stylesheets/locastyle.css" rel="stylesheet" type="text/css">
<title>Usuários</title>

<style type="text/css">
.sucesso {
	color: #000;
	background-color: #699;
	padding: 8px;
	border: 1px solid #CF0;
}

.style1{ margin-left:10px;}
</style>
</head>

<body>
<?php require('comum/cabecalho.php'); ?>

  <div class="ls-main">
  <ol class="ls-breadcrumb">
      <li><a href="usuario.php">Início</a></li>
      <li>Pacotes</li>
    </ol>
    <br>
<p class="style1">Lista dos Pacotes Turísticos cadastrados no Sistema</p>
<p class="style1"><a href="pacotes_adicionar.php" class="ls-btn-primary">Adicionar Pacotes</a></p>
<table class="ls-table">
  <tr>
    <th scope="col">ID</th>
    <th scope="col">Título</th>
    <th scope="col">Região</th>
    <th scope="col">Destino</th>
    <th scope="col">Promocional</th>
    <th scope="col">Ativo</th>
    <th scope="col">Data Cadastro</th>
    <th scope="col">Ações</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_RS_pacotes['id']; ?></td>
      <td><?php echo $row_RS_pacotes['titulo']; ?></td>
      <td><?php echo $row_RS_pacotes['regiao']; ?></td>
      <td><?php echo $row_RS_pacotes['cidade_destino']; ?></td>
      <td><?php echo $row_RS_pacotes['promocional']; ?></td>
      <td><?php echo $row_RS_pacotes['ativo']; ?></td>
      <td><?php echo $row_RS_pacotes['data_cadastro']; ?></td>
      <td><a class="ls-ico-pencil" href="pacotes_editar.php?id=<?php echo $row_RS_pacotes['id']; ?>">Editar</a> | <a class="ls-ico-remove" href="pacotes_excluir.php?id=<?php echo $row_RS_pacotes['id']; ?>">Apagar</a></td>
    </tr>
    <?php } while ($row_RS_pacotes = mysql_fetch_assoc($RS_pacotes)); ?>
</table>
<p align="justify">&nbsp;</p>
<table width="100px">
	<tr>
   	  <td><?php if ($pageNum_RS_pacotes > 0) { // Show if not first page ?>
   	      <a class="ls-btn-dark" href="<?php printf("%s?pageNum_RS_pacotes=%d%s", $currentPage, 0, $queryString_RS_pacotes); ?>"><<</a>
   	      <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_RS_pacotes > 0) { // Show if not first page ?>
          <a class="ls-btn-dark" href="<?php printf("%s?pageNum_RS_pacotes=%d%s", $currentPage, max(0, $pageNum_RS_pacotes - 1), $queryString_RS_pacotes); ?>"><</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_RS_pacotes < $totalPages_RS_pacotes) { // Show if not last page ?>
          <a class="ls-btn-dark" href="<?php printf("%s?pageNum_RS_pacotes=%d%s", $currentPage, min($totalPages_RS_pacotes, $pageNum_RS_pacotes + 1), $queryString_RS_pacotes); ?>">></a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_RS_pacotes < $totalPages_RS_pacotes) { // Show if not last page ?>
  <a class="ls-btn-dark" href="<?php printf("%s?pageNum_RS_pacotes=%d%s", $currentPage, $totalPages_RS_pacotes, $queryString_RS_pacotes); ?>">>></a>
  <?php } // Show if not last page ?></td>
	</tr>
</table>
<small>Mostrando de <?php echo ($startRow_RS_pacotes + 1) ?> a <?php echo min($startRow_RS_pacotes + $maxRows_RS_pacotes, $totalRows_RS_pacotes) ?> de <?php echo $totalRows_RS_pacotes ?> registros</small> </div>
  <?php require('comum/sidebar.php'); ?>
</body>
</html>
<?php
mysql_free_result($RS_pacotes);
?>
