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

function carrega_franquias(cidade,estado){
	ajaxGet(url_site_js+"includes/carrega_franquias.php?estado="+estado+"&cidade="+cidade,document.getElementById("carrega_franquia"), true)
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

function carrega_servico_var(id_servico,id_servico_var){
	ajaxGet(url_site_js+"includes/carrega_servico_var.php?id_servico="+id_servico+"&id_servico_var="+id_servico_var,document.getElementById("id_servico_var"), true)
}

function carrega_cidade2(estado){
	ajaxGet(url_site_js+"includes/carrega_cidade.php?estado="+estado,document.getElementById("carrega_cidade_campo"), true)
}

function masc_numeros(obj,mascara){
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
	obj.value = str2
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

function fecharComunicado(id){
	document.getElementById('carrega_comunicado').style.display = 'none';
}