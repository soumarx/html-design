<!DOCTYPE html>
<html class="ls-theme-blue">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pacotes | Sistema Administrativo</title>
<link href="http://assets.locaweb.com.br/locastyle/3.2.2/stylesheets/locastyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php require ('comum/cabecalho.php'); ?>

<div class="ls-main ">
  <div class="container">
   	<div class="ls-box ls-lg-space ls-ico-users ls-ico-bg">
        	<h1 class="ls-title-intro ls-ico-users">Bem Vindo!</h1>
        	<p>Olá! <b><?php echo $row_RS_username['nome_usuario']; ?></b>, seja bem vindo ao sistema administrativo do site <strong>APECATU.</strong></p>    
      </div>
        
    <p>&nbsp;</p>
    <p>&nbsp;</p>
  </div>
</div>

<?php require('comum/sidebar.php'); ?>

</body>
</html>