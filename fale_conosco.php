<html>
<head>
<title>Apecatu - Agência de Viagens</title>
<link rel="stylesheet" type="text/css" href="assets/css/geral.css">
</head>
<body>
<?php $paginaSelecionada = 'fale_conosco';
require("header.php");
?>
<div class="geral">
<br><br>
 <div class="titulo_paginas">
   FALE CONOSCO
</div>
  <center><img src="assets/img/barrinha.jpg" width="955" height="15"></center>
  <div class="conteudo clearfix" >
  
 <div class="coluna1">
Além das informações disponíveis em todas as páginas do site, você também poderá tirar duvidas por email ou pela central de relacionamentos:
<p>
E-mail:<br>
contato@apecatu.com.br
<p>
Endereço:<br>
Rua Itapeva, 432, Bela Vista, São Paulo - SP, Brasil
 </div>
 
 <div class="coluna2">
 <form action="" method="get">
 <table width="400" border="0">
  <tr>
    <td>Nome:</td>
    <td><input name="input" type="text" size="38"></td>
  </tr>
  <tr>
    <td>Assunto:</td>
    <td><input name="input2" type="text" size="38"></td>
  </tr>
  <tr>
    <td>E-mail:</td>
    <td><input name="input3" type="text" size="38"></td>
  </tr>
  <tr>
    <td>Telefone:</td>
    <td><input name="input4" type="text" size="38"></td>
  </tr>
  <tr>
    <td>Mensagem:</td>
    <td><textarea name="textarea" cols="40" rows="10"></textarea></td>
  </tr>
  <tr>
    <td><input name="" type="submit" value="Enviar"></td>
    <td></td>
  </tr>
</table>
 <br>
 <br>
 <br>
 <br>
 </form> 
 
 </div>
</div>
</div>

<div>
<?php $paginaSelecionada = 'pacote_turismo';
require("footer.php");
?>
</div>
</body>
</html>