// JavaScript Document

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
	