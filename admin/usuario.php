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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_RS_usuario = 3;
$pageNum_RS_usuario = 0;
if (isset($_GET['pageNum_RS_usuario'])) {
  $pageNum_RS_usuario = $_GET['pageNum_RS_usuario'];
}
$startRow_RS_usuario = $pageNum_RS_usuario * $maxRows_RS_usuario;

mysql_select_db($database_ConexaoMySQL, $ConexaoMySQL);
$query_RS_usuario = "SELECT id_usuario, login, nome_usuario, ativo, data_ultimo_login, data_cadastro FROM usuario ORDER BY id_usuario ASC";
$query_limit_RS_usuario = sprintf("%s LIMIT %d, %d", $query_RS_usuario, $startRow_RS_usuario, $maxRows_RS_usuario);
$RS_usuario = mysql_query($query_limit_RS_usuario, $ConexaoMySQL) or die(mysql_error());
$row_RS_usuario = mysql_fetch_assoc($RS_usuario);

if (isset($_GET['totalRows_RS_usuario'])) {
  $totalRows_RS_usuario = $_GET['totalRows_RS_usuario'];
} else {
  $all_RS_usuario = mysql_query($query_RS_usuario);
  $totalRows_RS_usuario = mysql_num_rows($all_RS_usuario);
}
$totalPages_RS_usuario = ceil($totalRows_RS_usuario/$maxRows_RS_usuario)-1;

$queryString_RS_usuario = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RS_usuario") == false && 
        stristr($param, "totalRows_RS_usuario") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RS_usuario = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RS_usuario = sprintf("&totalRows_RS_usuario=%d%s", $totalRows_RS_usuario, $queryString_RS_usuario);
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
      <li>Início</li>
    </ol>
    <br>
  <p class="style1">Lista dos usuários do sistema.</p>
  <?php if(isset($_GET['status']) && $_GET['status'] == 1){ ?>
  <div class="sucesso">Registro salvo com sucesso!</div>
  <?php } ?>
  
    <p>&nbsp;</p>
    <p class="style1"><a href="usuario_adicionar.php" class="ls-btn-primary ls-ico-user-add">Adicionar Usuário</a></p>
      <table  class="ls-table">
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Login</th>
          <th scope="col">Nome</th>
          <th scope="col">Ativo?</th>
          <th scope="col">Data Criação</th>
          <th scope="col">Último Acesso</th>
          <th scope="col">Ações</th>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_RS_usuario['id_usuario']; ?></td>
            <td><?php echo $row_RS_usuario['login']; ?></td>
            <td><?php echo $row_RS_usuario['nome_usuario']; ?></td>
            <td><?php if ($row_RS_usuario['ativo'] == '1') echo "Sim"; 
              else echo "Não"; ?></td>
            <td><?php echo $row_RS_usuario['data_ultimo_login']; ?></td>
            <td><?php echo $row_RS_usuario['data_cadastro']; ?></td>
            <td><a class="ls-ico-pencil" href="usuario_editar.php?id_usuario=<?php echo $row_RS_usuario['id_usuario']; ?>">Editar</a> | <a class="ls-ico-remove" href="usuario_excluir.php?id_usuario=<?php echo $row_RS_usuario['id_usuario']; ?>">Apagar</a></td>
          </tr>
          <?php } while ($row_RS_usuario = mysql_fetch_assoc($RS_usuario)); ?>
      </table>
      <p>&nbsp;</p>
    <table width="100px">
	<tr>
   	  <td><?php if ($pageNum_RS_usuario > 0) { // Show if not first page ?>
   	      <a class="ls-btn-dark" href="<?php printf("%s?pageNum_RS_usuario=%d%s", $currentPage, 0, $queryString_RS_usuario); ?>"><<</a>
   	      <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_RS_usuario > 0) { // Show if not first page ?>
          <a class="ls-btn-dark" href="<?php printf("%s?pageNum_RS_usuario=%d%s", $currentPage, max(0, $pageNum_RS_usuario - 1), $queryString_RS_usuario); ?>"><</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_RS_usuario < $totalPages_RS_usuario) { // Show if not last page ?>
          <a class="ls-btn-dark" href="<?php printf("%s?pageNum_RS_usuario=%d%s", $currentPage, min($totalPages_RS_usuario, $pageNum_RS_usuario + 1), $queryString_RS_usuario); ?>">></a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_RS_usuario < $totalPages_RS_usuario) { // Show if not last page ?>
          <a class="ls-btn-dark" href="<?php printf("%s?pageNum_RS_usuario=%d%s", $currentPage, $totalPages_RS_usuario, $queryString_RS_usuario); ?>">>></a>
          <?php } // Show if not last page ?></td>
	</tr>
</table>
<small>Mostrando de <?php echo ($startRow_RS_usuario + 1) ?> a <?php echo min($startRow_RS_usuario + $maxRows_RS_usuario, $totalRows_RS_usuario) ?> de <?php echo $totalRows_RS_usuario ?> registros</small>
  </div>

  <?php require('comum/sidebar.php'); ?>

</body>
</html>
<?php
mysql_free_result($RS_usuario);
?>
