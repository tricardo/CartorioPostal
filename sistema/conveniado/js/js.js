function MudaCorBotao(acao, cp){
	if(acao == 1)
		document.getElementById(cp).style.backgroundColor='#F0F0F0';
	else
		document.getElementById(cp).style.backgroundColor='#FFF';
}

function CarregaPagina(pagina){
	document.getElementById('navegacao').style.height = 'auto';
	document.getElementById('navegacao').style.width = 'auto';
	document.getElementById('calendario').style.display = 'none';
	if(document.getElementById('box_news')){ document.getElementById('box_news').style.display = 'none'; }
	if(document.getElementById('busca')){ 
		document.getElementById('busca').value = 0; 
		HabilitaCampo('busca', 0);
	}
	ajaxGet(pagina, document.getElementById("navegacao"), true);
}

function Calendario(cp){
	document.getElementById('calendario').style.display = 'block';
	//document.getElementById('calendario').style.left = (document.getElementById(cp).offsetLeft - 73) + 'px';
	//document.getElementById('calendario').style.top = (document.getElementById(cp).offsetTop + 204) + 'px';
	ajaxGet("includes/carrega_calendario.php?cp="+cp,document.getElementById("calendario"), true);
}

function CarregaCalendario(cp, dia, ano, mes){
	if(mes < 10){ mes = '0'+mes; }
	if(dia < 10){ dia = '0'+dia; }
	document.getElementById(cp).value = dia+'/'+mes+'/'+ano;
	document.getElementById('calendario').style.display = 'none';
}

function TrocaDataCalendario(acao, cp, vl1, vl2){
	if(acao == 1){
		ajaxGet("includes/carrega_calendario.php?cp="+cp+'&mes='+vl1+'&ano='+vl2,document.getElementById("calendario"), true);
	} else if(acao = 2) {
		ajaxGet("includes/carrega_calendario.php?cp="+cp+'&mes='+vl2+'&ano='+vl1,document.getElementById("calendario"), true);
	}
}

function Pesquisa(f, p){
	/* if(document.getElementById('calendario')){ document.getElementById('calendario').style.display = 'none'; } */
	/* if(document.getElementById('box_news')){ document.getElementById('box_news').style.display = 'none'; } */
	str = 'form='+f;

	for(i = 0; i < document.getElementById(f).elements.length; i++){
		if(document.getElementById(f).elements[i].id){
			document.getElementById(document.getElementById(f).elements[i].id).disabled = true;		
			document.getElementById(document.getElementById(f).elements[i].id).style.filter = 'alpha(opacity=25)';
			document.getElementById(document.getElementById(f).elements[i].id).style.opacity = '0.25';
			document.getElementById(document.getElementById(f).elements[i].id).style.MozOpacity = '0.25';  
			str += '&' + document.getElementById(f).elements[i].id + '=' + document.getElementById(document.getElementById(f).elements[i].id).value;
		}
	}
	/*
	if(document.getElementsByName('idata')){
		for(i = 0; i < document.getElementsByName('idata').length; i++){
			document.getElementById(document.getElementsByName('idata')[i].id).style.display = 'none';
		}
	} */
	document.getElementById("retorno").style.display = 'block';
	ajaxGet(p+"?"+str, document.getElementById("retorno"), true);
	return false;
}

function RetornaErro(f, erro, mostra){
	if(document.getElementById(f)){
		for(i = 0; i < document.getElementById(f).elements.length; i++){
			if(document.getElementById(f).elements[i].id){
				document.getElementById(document.getElementById(f).elements[i].id).disabled = false;		
				document.getElementById(document.getElementById(f).elements[i].id).style.filter = 'alpha(opacity=100)';
				document.getElementById(document.getElementById(f).elements[i].id).style.opacity = '1';
				document.getElementById(document.getElementById(f).elements[i].id).style.MozOpacity = '1';  
			}
		}
		if(document.getElementsByName('idata')){
			for(i = 0; i < document.getElementsByName('idata').length; i++){
				document.getElementById(document.getElementsByName('idata')[i].id).style.display = 'block';
			}
		}
		if(document.getElementById('box_news') && mostra == 1){ 
			document.getElementById('box_news').style.display = 'block'; 
			document.getElementById('erro').innerHTML = erro;
		}
	}
	return false;
}

function HabilitaCampo(id, cp){
	var padrao = '';
	switch(id){
		case '0':
			padrao =  '<input type="text" onclick="alert(\'Defina um tipo busca!\'); ';
			padrao += 'document.getElementById(\'busca\').focus();" onchange="alert(\'Defina um tipo busca!\'); ';
			padrao += 'document.getElementById(\'busca\').focus();" id="buscador" name="buscador" class="form_estilo" ';
			padrao += 'style="width:210px;" readonly="readonly" />';
		break;
		case '1':
		case '2':
		case '3':
		case '4':
			/*padrao =  '<input type="text" id="cpf" name="cpf" class="form_estilo" ';
			padrao += 'style="width:210px;" maxlength="14" />';	
			cpo = 'cpf';
		break;
		case '4':
			padrao =  '<input type="text" id="cnpj" name="cnpj" class="form_estilo" ';
			padrao += 'style="width:210px;" maxlength="18" />';	
			cpo = 'cnpj';
		break;
		case '2':*/
			padrao =  '<input type="text" id="cnpj" name="cnpj" class="form_estilo" ';
			padrao += 'style="width:210px;" maxlength="18" />';	
			cpo = 'cnpj';
		break;
		default:
			padrao =  '<input type="text" id="outros" name="outros" class="form_estilo" ';
			padrao += 'style="width:210px;" maxlength="50" />';	
			cpo = 'outros';
	}
	document.getElementById('cp').innerHTML = padrao;
	if(document.getElementById(cpo)){
		document.getElementById(cpo).focus();	
	}
}

function CarregaMascara(tipo, cp){
	switch(tipo){
		case 1: tipo = "999.999.999-99"; break;
		case 2: tipo = "99.999.999/9999-99"; break
	}
	jQuery($(cp).mask(tipo));	
}

function AjaxPaginacao(nome_pagina, num_pagina, f){
	ajaxGet(nome_pagina+"?pagina="+num_pagina+'&form='+f+'&p=1', document.getElementById("retorno"), true);
}

function LimparForm(){
	document.getElementById('retorno').innerHTML='';
	HabilitaCampo(0,'');
	ajaxGet("carrega_session.php", document.getElementById("retorno"), true);
}

function carrega_departamento(id_servico_departamento){
	ajaxGet("../carrega_combo/carrega_departamento.php?id_servico_departamento="+id_servico_departamento,document.getElementById("id_servico_departamento"), true)
}

function carrega_servico(id_departamento,id_servico){
	ajaxGet("../carrega_combo/carrega_servico.php?id_departamento="+id_departamento+"&id_servico="+id_servico,document.getElementById("id_servico"), true)
}

function carrega_servico_var(id_servico,id_servico_var){
	ajaxGet("../carrega_combo/carrega_servico_var.php?id_servico="+id_servico+"&id_servico_var="+id_servico_var,document.getElementById("id_servico_var"), true)
}

function carrega_servico_valor(id_servico_var,form){
	ajaxGet("../includes/carrega_servico_valor.php?id_servico_var="+id_servico_var+"&form="+form,document.getElementById("carrega_valor"), true)
}
