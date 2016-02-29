var url_site_js = '/certidoes/';
function createCookie(name,value,days,concatena){
	if(concatena==1){
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++){
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) var conc = c.substring(nameEQ.length,c.length);
			if (!conc) conc = '';
		}
	}
	if(days){
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+conc+value+expires+"; path=/";
}

function readCookie(name){
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++){
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function eraseCookie(name){
	createCookie(name,"",-1);
}

function eraseCookieItem(name,value){
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++){
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

function carrega_cidades(estado,cidade){
	ajaxGet(url_site_js+"includes/carrega_cidades.php?estado="+estado+"&cidade="+cidade,document.getElementById("carrega_cidade"), true)
}

function carrega_bairros(estado,cidade){
	ajaxGet(url_site_js+"includes/carrega_bairros.php?estado="+estado+"&cidade="+cidade,document.getElementById("carrega_bairro"), true)
}

function carrega_franquias(cidade,estado,bairro){
	ajaxGet(url_site_js+"includes/carrega_franquias.php?estado="+estado+"&cidade="+cidade+"&bairro="+bairro,document.getElementById("carrega_franquia"), true)
}

function carrega_duvidas(busca_duvida,busca_cat,pagina){
	ajaxGet(url_site_js+"includes/carrega_duvidas.php?busca_duvida="+busca_duvida+"&busca_cat="+busca_cat+"&pagina="+pagina,document.getElementById("car_duvidas"), true);
}

function carrega_depoimento(pagina){
	ajaxGet(url_site_js+"includes/carrega_depoimento.php?pagina="+pagina,document.getElementById("car_depoimento"), true)
}

function carrega_depoimentofranquia(pagina,id_empresa){
	ajaxGet(url_site_js+"includes/carrega_depoimentofranquia.php?pagina="+pagina+"&id_empresa="+id_empresa,document.getElementById("car_depoimento"), true)
}

function carrega_imprensa(busca_imprensa,id_imprensa_cat,pagina){
	ajaxGet(url_site_js+"includes/carrega_imprensa.php?busca_imprensa="+busca_imprensa+"&id_imprensa_cat="+id_imprensa_cat+"&pagina="+pagina,document.getElementById("car_imprensa"), true)
}

function carrega_franquia(busca_franquia,pagina){
	ajaxGet(url_site_js+"includes/carrega_franquia_foto.php?busca_franquia="+busca_franquia+"&pagina="+pagina,document.getElementById("car_franquia"), true)
}

function carrega_campo(id,id_pedido_item){
	ajaxGet(url_site_js+"includes/carrega_campos.php?id="+id+"&id_pedido_item="+id_pedido_item,document.getElementById("carrega_campos_input"), true)
}
function carrega_campo_afiliado(id,id_pedido_item,largura){
	ajaxGet(url_site_js+"includes/carrega_campos.php?id="+id+"&id_pedido_item="+id_pedido_item+"&largura="+largura,document.getElementById("carrega_campos_input"), true)
}

function carrega_servico_var(id_servico,id_servico_var){
	ajaxGet(url_site_js+"includes/carrega_servico_var.php?id_servico="+id_servico+"&id_servico_var="+id_servico_var,document.getElementById("id_servico_var"), true)
}

function carrega_cidade2(estado){
	ajaxGet(url_site_js+"includes/carrega_cidade.php?estado="+estado,document.getElementById("carrega_cidade_campo"), true)
}

function novo_telefone(obj){
	obj.maxLength = 15;
	digito = /^\d$/;
	str = obj.value;
	str = replaces_all(str, '/', '');
	str = replaces_all(str, '(', '');
	str = replaces_all(str, ')', '');
	str = replaces_all(str, '-', '');
	str = replaces_all(str, ' ', '');
	str = replaces_all(str, '_', '');
	str2 = '';
	for(i = 0; i < str.length; i++){
		if(i != 2){
			str2 += digito.test(str.charAt(i)) ? str.charAt(i) : '';
		} else {
			str2 += str.charAt(i);
		}
	}
	if(str2.length > 0){
		mascara = (str.length <= 10) ? '(##) ####-####' : '(##) #####-####';
		
		str3 = '';
		for (i = 0 , j = 0; j < str2.length && i < mascara.length; i ++ ) {
			if(mascara.charAt(i) == "#"){
				str3 += str2.charAt(j)
				j++
			} else {
				str3 += mascara.charAt(i)
			}
		}
		obj.value = str3;
	}
}

function replaces_all(string, token, newtoken) {
	while (string.indexOf(token) != -1) {
 		string = string.replace(token, newtoken);
	}
	return string;
}

function masc_numeros(obj,mascara){
	if(mascara == '(##) ####-####'){
		novo_telefone(obj);
	} else {
		str = obj.value
		len = str.length
		str2 = ""
		digito = /^\d$/
		for (i = 0; i < len ; i ++ ){
			if (digito.test(str.charAt(i))) str2 += str.charAt(i)
		}
		str = str2
		len = str.length
		str2 = ""
		for(i = 0 , j = 0 ; j < len && i<mascara.length; i ++){
			if (mascara.charAt(i) == "#"){
				str2 += str.charAt(j)
				j++
			}else{
				str2 += mascara.charAt(i)
			}
		}
		obj.value = str2;
	}
}

function moeda(k,valor,id){
	var done='';
	if(k==48 || k==96 || k==9) { done=1; }
	if(k==49 || k==97) { done=1; }
	if(k==50 || k==98) { done=1; }
	if(k==51 || k==99) { done=1; }
	if(k==52 || k==100){ done=1; }
	if(k==53 && shif==false || k==101) { done=1; }
	if(k==54 || k==102) { done=1; }
	if(k==55 || k==103) { done=1; }
	if(k==56 && shif==false || k==104) { done=1; }
	if(k==57 || k==105) { done=1; }
	if(k==190 || k==194 || k==8) {done=1; }
	if(k==46 || k==13 || k==37 || k==38 || k==39 || k==40 ) {done=1; }
	if (done!=1){
		document.getElementById(id).value='';
		alert('O formato do valor deve ser ###.##');
	}
}

function EstouCiente(){
	if(document.getElementById('ciente').checked == true){
		document.getElementById('submit').style.filter = 'alpha(opacity=100)';
		document.getElementById('submit').style.opacity = '1';
		document.getElementById('submit').style.MozOpacity = '1'; 
		document.getElementById('submit').disabled = false;
	}else{
		document.getElementById('submit').style.filter = 'alpha(opacity=25)';
		document.getElementById('submit').style.opacity = '0.25';
		document.getElementById('submit').style.MozOpacity = '0.25';
		document.getElementById('submit').disabled = true;
	}
}

function abrirComunicado(pagina, w, h){
	if(document.getElementById('carrega_comunicado')){
		ajaxGet(url_site_js+"comunicados/"+pagina+'.php',document.getElementById("carrega_comunicado"), true);
	}
}

function abrirAcessor(id){
	document.getElementById('apDiv_acessor').style.display = 'block';
}

function fecharAcessor(id){
	document.getElementById('apDiv_acessor').style.display = 'none';
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
		document.getElementById(campospan).innerHTML = "Ainda não temos nada digitado..";
	}
}
 
function contarCaracteres(box,valor,campospan,campo){
	var conta = valor - box.length;
	document.getElementById(campospan).innerHTML = "Você ainda pode digitar " + conta + " caracteres";
	if(box.length >= valor){
		document.getElementById(campospan).innerHTML = "Opss.. você não pode mais digitar..";
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

function fechar_popup(id){
	document.getElementById('apDiv_popup').style.display = 'none';
}