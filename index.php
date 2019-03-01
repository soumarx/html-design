<?php require_once('Connections/ConexaoMySQL.php'); ?>
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

$maxRows_RS_pacotes = 4;
$pageNum_RS_pacotes = 0;
if (isset($_GET['pageNum_RS_pacotes'])) {
  $pageNum_RS_pacotes = $_GET['pageNum_RS_pacotes'];
}
$startRow_RS_pacotes = $pageNum_RS_pacotes * $maxRows_RS_pacotes;

mysql_select_db($database_ConexaoMySQL, $ConexaoMySQL);
$query_RS_pacotes = "SELECT id, titulo, regiao, cidade_destino, resumo, promocional, foto_destaque FROM pacotes WHERE ativo = 's' ORDER BY RAND() ";
$query_limit_RS_pacotes = sprintf("%s LIMIT %d, %d", $query_RS_pacotes, $startRow_RS_pacotes, $maxRows_RS_pacotes);
$RS_pacotes = mysql_query($query_limit_RS_pacotes, $ConexaoMySQL) or die(mysql_error());
$row_RS_pacotes = mysql_fetch_assoc($RS_pacotes);

if (isset($_GET['totalRows_RS_pacotes'])) {
  $totalRows_RS_pacotes = $_GET['totalRows_RS_pacotes'];
} else {
  $all_RS_pacotes = mysql_query($query_RS_pacotes);
  $totalRows_RS_pacotes = mysql_num_rows($all_RS_pacotes);
}
$totalPages_RS_pacotes = ceil($totalRows_RS_pacotes/$maxRows_RS_pacotes)-1;$maxRows_RS_pacotes = 4;
$pageNum_RS_pacotes = 0;
if (isset($_GET['pageNum_RS_pacotes'])) {
  $pageNum_RS_pacotes = $_GET['pageNum_RS_pacotes'];
}
$startRow_RS_pacotes = $pageNum_RS_pacotes * $maxRows_RS_pacotes;

mysql_select_db($database_ConexaoMySQL, $ConexaoMySQL);
$query_RS_pacotes = "SELECT id, titulo, regiao, cidade_destino, resumo, valor_pacote, foto_destaque FROM pacotes WHERE ativo = 's' ORDER BY RAND() ";
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
?>
<html>
<head>
<title>Apecatu - Agência de Viagens</title>
<link rel="stylesheet" type="text/css" href="assets/css/geral.css">
<link rel="stylesheet" href="assets/css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="assets/css/default.css" type="text/css" media="screen" />
<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.nivo.slider.js"></script>
</head>
<body>
<?php $paginaSelecionada = 'home';
require("header.php");
?>
  
  
  
  <div class="conteudo">
    <div class="banner_home">
      <div class="slider-wrapper theme-default">
          <div id="slider" class="nivoSlider theme-default">
              <img src="assets/img/banner_home.jpg" data-transition="slideInLeft" alt=""/>
              <img src="assets/img/banner_home_2.jpg" data-transition="slideInLeft" alt=""/>
              <img src="assets/img/banner_home_3.jpg" alt="" data-transition="slideInLeft"/>
          </div>
      </div>
    </div>
	<script type="text/javascript">
	  $(window).load(function() {
	  $('#slider').nivoSlider();
	  });
   	</script>
    <img src="assets/img/img_borda_banner.png" width="100%">
    <div class="container">
    	<h2 class="titulo_home">Pacotes Promocionais</h2>
        <hr>
        <?php do { ?>
        <div class="box_home">
            <img src="assets/uploads/<?php echo $row_RS_pacotes['foto_destaque']; ?>">
            <h4 class="titulo_pacote">
            <?php echo $row_RS_pacotes['titulo']; ?>
            <p class="texto_box">
              a partir de:<br>
              <font class="valor_box">10 X <font color="#f48735;"><?php echo number_format($row_RS_pacotes['valor_pacote'], 2, ',','.'); ?></font></font><br>
              <?php echo $row_RS_pacotes['resumo']; ?></p>
            <div align="center"><a href="pacote.php?id=<?php echo $row_RS_pacotes['id']; ?>"><img class="opacidade" src="assets/img/bt_ver_pacotes.png"></a></div>
         </div>
          <?php } while ($row_RS_pacotes = mysql_fetch_assoc($RS_pacotes)); ?>
    </div>
    <div class="conteudo_video">
    	<div class="container">
        <div class="texto_video">
        <p>Viagem por todo o Brasil</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sollicitudin elit tortor, molestie mattis lacus venenatis at. Duis enim lorem, dapibus id eros nec, fringilla dictum turpis. Etiam posuere quam non mauris luctus, eu gravida libero finibus. Proin ut dignissim elit, at rutrum nulla. Sed id sem non risus fringilla convallis. Quisque congue risus eu nisi volutpat pulvinar. Curabitur scelerisque posuere turpis, ut ullamcorper nulla scelerisque eu. Praesent gravida purus at vehicula tempor.</p>
        </div>
        <div class="img_video"> <iframe src="//player.vimeo.com/video/52742614" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> </div>
        </div>
    </div>
    <br>  
  </div>
  
  

<?php $paginaSelecionada = 'pacote_turismo';
require("footer.php");
?>

</body>
</html>
<?php
mysql_free_result($RS_pacotes);
?>
