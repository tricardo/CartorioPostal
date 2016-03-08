function createCookie(name,value,days,concatena) {
	if(concatena==1){
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) var conc = c.substring(nameEQ.length,c.length);
			if (!conc) conc = '';
		}
	}
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+conc+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function eraseCookie(name) {
	createCookie(name,"",-1);
}

function eraseCookieItem(name,value) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) var conc = ' '+c.substring(nameEQ.length,c.length);
		if (!conc) conc = '';
	}
	if(conc){
		conc = conc.replace(/,/gi,", ");
		while (conc.indexOf(' '+value+',') != -1){
			conc = conc.replace(' '+value+',', '');
		}
		conc = conc.replace(/ /gi, "");
	}
	var date = new Date();
	var days = 1;
	date.setTime(date.getTime()+(days*24*60*60*1000));
	var expires = "; expires="+date.toGMTString();
	document.cookie = name+"="+conc+expires+"; path=/";
}

function masc_numeros(obj,mascara){
		str = obj.value
		len = str.length
		str2  = ""
		digito = /^\d$/
		for (i = 0; i < len ; i ++ ){
			if (digito.test(str.charAt(i))) str2 += str.charAt(i)
		}
		str = str2
		len = str.length
		str2 = ""
		for (i = 0 , j = 0 ; j < len && i<mascara.length; i ++ ){
			if (mascara.charAt(i) == "#"){
				str2 += str.charAt(j)
				j++
			}else{
				str2 += mascara.charAt(i)
			}
		}
		obj.value = str2
}

function abrir_pagina(pagina){
	ajaxGet(pagina, document.getElementById("pagina_conteudo"), true);
}

function mostrarResultado(box,num_max,campospan){
	var contagem_carac = box.length;
	if (contagem_carac != 0){
		document.getElementById(campospan).innerHTML = contagem_carac + " caracteres digitados";
		if (contagem_carac == 1){
			document.getElementById(campospan).innerHTML = contagem_carac + " caracter digitado";
		}
		if (contagem_carac >= num_max){
			document.getElementById(campospan).innerHTML = "Limite de caracteres excedido!";
		}
	}else{
		document.getElementById(campospan).innerHTML = "Ainda n�o temos nada digitado..";
	}
}
 
function contarCaracteres(box,valor,campospan,campo){
	var conta = valor - box.length;
	document.getElementById(campospan).innerHTML = "Voc� ainda pode digitar " + conta + " caracteres";
	if(box.length >= valor){
		document.getElementById(campospan).innerHTML = "Opss.. voc� n�o pode mais digitar..";
		document.getElementById(campo).value = document.getElementById(campo).value.substr(0,valor);
	}
}

function checkall(acao){
	if(acao==1){
		document.getElementById('chk1').style.display='none';
		document.getElementById('chk0').style.display='block';
		document.getElementById('chk0').checked = true;
		document.getElementById('chk1').checked = false;
		ck = true;
	}else{
		document.getElementById('chk1').style.display='block';
		document.getElementById('chk0').style.display='none';
		document.getElementById('chk1').checked = false;
		document.getElementById('chk0').checked = false;
		ck = false;
	}
	for(i = 0; i < document.getElementById('totalcheck').value; i++){
		c = 'checklister' + i;
		document.getElementById(c).checked = ck;
	}
}

function VerificaCheckSel(){
	ids = '';
	for(i = 0; i < document.getElementsByName('checklister').length; i++){
		if(document.getElementsByName('checklister')[i].checked == true){
			ids += document.getElementsByName('checklister')[i].value + ', ';
		}
	}
	document.getElementById('id_anunc').value = ids;
}

function Hours_Start(){
	Hora = new Date;
	calculoTempo = contagemTempo(Hora.getHours()) + ":" + contagemTempo(Hora.getMinutes()) + ":" + contagemTempo(Hora.getSeconds());
	document.getElementById("relogio").innerHTML = calculoTempo;
	setTimeout("Hours_Start()",1000);
}

function contagemTempo(Value){
	return (Value > 9) ? "" + Value : "0" + Value;
}