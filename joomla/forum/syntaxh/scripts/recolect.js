// Creado por: Walfre Manolo López Prado
//eliminacion de molestos <br> en codigos de Syntax
//www.umgx.info
function trans(texto, id){
	var text = texto.split('<br />');
	var bol = false;
	if(text.length==1 || text.length==0){
		var opcion1="";
//			4012083195
	}
	else{
		var	opcion1 = "highlight: [";
		
		for(i = 2; i<=text.length; i=i+2){
			opcion1 = opcion1 + i;
			if(i+1 == text.length || i==text.length){
				opcion1= opcion1 +"]";
			}
			else{
				opcion1= opcion1 +", ";
			}
		}
	}
	
	document.writeln('<pre class="brush: '+ id +'; '+ opcion1 +'">'); 
	
	for(i = 0; i<text.length; i++){
		bol=true;
		var codigo = text[i];

		var codigoter = "";
		for (j=0; j<codigo.length; j++){
			caracter = codigo.charAt(j);
			
			if(caracter =="<"){
				caracter = "&lt;";
			}
			if(caracter==">"){
				caracter = "&gt;";
			}
			codigoter = codigoter + caracter;
			
		}
		document.writeln(codigoter + ' ');
	}
	if(bol ==false){
		document.writeln(text);
	}
	document.writeln('</pre>'); 
}
function loader(){
	document.writeln('<script type="text/javascript" src="syntaxh/scripts/shBrushJScript.js"></script>');
	document.writeln('<script type="text/javascript" src="syntaxh/scripts/shBrushAppleScript.js"></script>');
	document.writeln('<script type="text/javascript" src="syntaxh/scripts/shBrushAS3.js"></script>');
	document.writeln('<script type="text/javascript" src="syntaxh/scripts/shBrushBash.js"></script>');
	document.writeln('<script type="text/javascript" src="syntaxh/scripts/shBrushColdFusion.js"></script>');
	document.writeln('<script type="text/javascript" src="syntaxh/scripts/shBrushCpp.js"></script>');
	document.writeln('<script type="text/javascript" src="syntaxh/scripts/shBrushCSharp.js"></script>');
	document.writeln('<script type="text/javascript" src="syntaxh/scripts/shBrushCss.js"></script>');
	document.writeln('<script type="text/javascript" src="syntaxh/scripts/shBrushDelphi.js"></script>');
	document.writeln('<script type="text/javascript" src="syntaxh/scripts/shBrushDiff.js"></script>');
	document.writeln('<script type="text/javascript" src="syntaxh/scripts/shBrushErlang.js"></script>');
	document.writeln('<script type="text/javascript" src="syntaxh/scripts/shBrushGroovy.js"></script>');
	document.writeln('<script type="text/javascript" src="syntaxh/scripts/shBrushJava.js"></script>');
	document.writeln('<script type="text/javascript" src="syntaxh/scripts/shBrushJavaFX.js"></script>');
	document.writeln('<script type="text/javascript" src="syntaxh/scripts/shBrushPerl.js"></script>');
	document.writeln('<script type="text/javascript" src="syntaxh/scripts/shBrushPhp.js"></script>');
	document.writeln('<script type="text/javascript" src="syntaxh/scripts/shBrushPlain.js"></script>');
	document.writeln('<script type="text/javascript" src="syntaxh/scripts/shBrushPowerShell.js"></script>');
	document.writeln('<script type="text/javascript" src="syntaxh/scripts/shBrushPython.js"></script>');
	document.writeln('<script type="text/javascript" src="syntaxh/scripts/shBrushRuby.js"></script>');
	document.writeln('<script type="text/javascript" src="syntaxh/scripts/shBrushSass.js"></script>');
	document.writeln('<script type="text/javascript" src="syntaxh/scripts/shBrushScala.js"></script>');
	document.writeln('<script type="text/javascript" src="syntaxh/scripts/shBrushSql.js"></script>');
	document.writeln('<script type="text/javascript" src="syntaxh/scripts/shBrushVb.js"></script>');
	document.writeln('<script type="text/javascript" src="syntaxh/scripts/shBrushXml.js"></script>');
}