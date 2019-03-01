<script>

	function escondeTexto(masc_texto){
		var Texto = masc_texto.id;
			if (Texto == "news"){
				document.getElementById(Texto).value = "";
				document.getElementById(Texto).className = "";
			}else {
				document.getElementById(Texto).value = "Digite aqui o seu email...";
				}
		}
	
	function mostraTexto(masc_texto){
		var Texto = masc_texto.id;
			if (Texto == "news" && document.getElementById(Texto).value == ""){
				document.getElementById(Texto).value = "Digite aqui o seu email...";
				document.getElementById(Texto).className = "style1";
			}
		}

</script>

<div class="centro">
 <div class="barra_laranja">
 
    <div class="centro2">
    
    <div class="endereco">
    <b>Endereço:</b><br />
    Rua João Augusto, 455 - São Paulo - 05654-675<br />
    Tel.: 5555-0000
    </div>
    
    <div class="social">
    <b>Siga-nos:</b><br />
       <table width="100" border="0">
         <tr>
               <td width="28"><img src="assets/img/ico_twitter.png" width="28" height="28" /></td>
               <td width="96"><img src="assets/img/ico_instagram.png" width="28" height="28" /></td>
               <td width="62"><img src="assets/img/ico_facebook.png" width="28" height="28" /></td>
         </tr>
    </table>
    </div>
    
    <div class="newsletter">
    <b>Newsletter:</b><br />
    <input class="style1" id="news" type="text" value="Digite aqui o seu email..." size="35" onClick="escondeTexto(this);" onBlur="mostraTexto(this);" />&nbsp;<input type="button" class="botao" name="enviar" value="enviar"/>
    </div>
    </div>
    </div>
    
<div class="centro3">
    
    <div class="copyright">
    © Apecatu Agência de Viagens - Todos os Direitos Reservados
    </div>
      
      <div class="desenvolvido">
    Desenvolvido por:</div>
    
      <div class="logo_html">
      <img src="assets/img/html_design.jpg" width="126" height="42" /> 
      </div>
      
  </div>
</div>

</body>
</html>