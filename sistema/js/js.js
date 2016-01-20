function iframeAutoHeight(quem){
    if(navigator.appName.indexOf("Internet Explorer")>-1){
        var func_temp = function(){
            var val_temp = quem.contentWindow.document.body.scrollHeight + 15
            quem.style.height = val_temp + "px";
        }
        setTimeout(function() { func_temp() },100);
    }else{
        var val = quem.contentWindow.document.body.parentNode.offsetHeight + 15
        quem.style.height= val + "px";
    }    
}

function selecionar_campos(onde){
	if(onde=='direcionamento'){
		document.buscador.busca_e_inicio.checked='1';
		document.buscador.busca_e_prazo.checked='1';
		document.buscador.busca_e_data_atividade.checked='1';
		document.buscador.busca_e_servico.checked='1';
		document.buscador.busca_e_cidade.checked='1';
		document.buscador.busca_e_estado.checked='1';
		document.buscador.busca_e_status.checked='1';
		document.buscador.busca_e_atividade.checked='1';
		document.buscador.busca_e_responsavel.checked='1';
		document.buscador.busca_e_atendimento.checked='1';
		document.buscador.busca_e_devedor.checked='1';
	}
	if(onde=='pedidos'){
		document.buscador.busca_e_inicio.checked='1';
		document.buscador.busca_e_prazo.checked='1';
		document.buscador.busca_e_conclu.checked='1';
		document.buscador.busca_e_servico.checked='1';
		document.buscador.busca_e_cidade.checked='1';
		document.buscador.busca_e_estado.checked='1';
		document.buscador.busca_e_status.checked='1';
		document.buscador.busca_e_atividade.checked='1';
		document.buscador.busca_e_responsavel.checked='1';
		document.buscador.busca_e_atendimento.checked='1';
		document.buscador.busca_e_devedor.checked='1';
		document.buscador.busca_e_agenda.checked='1';
		document.buscador.busca_e_data_atividade.checked='1';
		document.buscador.busca_e_valor.checked='1';
		document.buscador.busca_e_departamento.checked='1';
	}
}

function deselecionar_campos(onde){
	if(onde=='direcionamento'){
		document.buscador.busca_e_inicio.checked='';
		document.buscador.busca_e_prazo.checked='';
		document.buscador.busca_e_data_atividade.checked='';
		document.buscador.busca_e_servico.checked='';
		document.buscador.busca_e_cidade.checked='';
		document.buscador.busca_e_estado.checked='';
		document.buscador.busca_e_status.checked='';
		document.buscador.busca_e_atividade.checked='';
		document.buscador.busca_e_responsavel.checked='';
		document.buscador.busca_e_atendimento.checked='';
		document.buscador.busca_e_devedor.checked='';
	}	
	
	if(onde=='pedidos'){
		document.buscador.busca_e_inicio.checked='';
		document.buscador.busca_e_prazo.checked='';
		document.buscador.busca_e_conclu.checked='';
		document.buscador.busca_e_servico.checked='';
		document.buscador.busca_e_cidade.checked='';
		document.buscador.busca_e_estado.checked='';
		document.buscador.busca_e_status.checked='';
		document.buscador.busca_e_atividade.checked='';
		document.buscador.busca_e_responsavel.checked='';
		document.buscador.busca_e_atendimento.checked='';
		document.buscador.busca_e_devedor.checked='';
		document.buscador.busca_e_agenda.checked='';
		document.buscador.busca_e_data_atividade.checked='';
		document.buscador.busca_e_valor.checked='';
		document.buscador.busca_e_departamento.checked='';
		
	}
}

function selecionar_tudo(){
	for (i=0;i < document.f1.elements.length;i++)
		if(document.f1.elements[i].type == "checkbox")
			document.f1.elements[i].checked=1;
}

function selecionar_tudo_cache(nome){
	for (i=0;i < document.f1.elements.length;i++){
		if(document.f1.elements[i].type == "checkbox" && document.f1.elements[i].checked==0){
			if(document.f1.elements[i].value != 'on') {
				createCookie(nome,document.f1.elements[i].value+',','1','1');
				createCookie('p_id_pedido','#'+document.f1.elements[i-1].value+',','1','1');
			}	
		}	
	}
}

function selecionar_tudo_des(nome){
	for (i=0;i < document.f1.elements.length;i++){
		if(document.f1.elements[i].type == "checkbox" && document.f1.elements[i].checked==0){
			createCookie(nome,document.f1.elements[i].value+',','1','1');
			createCookie('p_id_pedido','#'+document.f1.elements[i-1].value+',','1','1');
			createCookie('des_id_fin',document.f1.elements[i-2].value+',','1','1');
		}	
	}
}

function deselecionar_tudo_cache(name){
	for (i=0;i < document.f1.elements.length;i++){
		if(document.f1.elements[i].type == "checkbox" && document.f1.elements[i].checked==1){
			if(document.f1.elements[i].value != 'on') {
				eraseCookieItem(name,document.f1.elements[i].value);
				eraseCookieItem('p_id_pedido','#'+document.f1.elements[i-1].value);
			}
		}
	}	
}

function deselecionar_tudo_des(nome){
	for (i=0;i < document.f1.elements.length;i++){
		if(document.f1.elements[i].type == "checkbox" && document.f1.elements[i].checked==1){
				eraseCookieItem(nome,document.f1.elements[i].value);
				eraseCookieItem('p_id_pedido','#'+document.f1.elements[i-1].value);
				eraseCookieItem('des_id_fin',document.f1.elements[i-2].value);
		}	
	}		
}

function deselecionar_tudo(){
	for (i=0;i < document.f1.elements.length;i++)
		if(document.f1.elements[i].type == "checkbox")
			document.f1.elements[i].checked=0;
}

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
		while (conc.indexOf(' '+value+',') != -1) {
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

function remessa_registra(nome,cpf,cidade,estado,id_arquivo_item){
	ajaxGet("../includes/carrega_remessa_c.php?nome="+nome+"&cpf="+cpf+"&cidade="+cidade+"&estado="+estado+"&id_arquivo_item="+id_arquivo_item,document.getElementById("result_"+id_arquivo_item), true)
}

function carrega_royalties_r(ref,id_empresa){
	ajaxGet("../carrega_combo/carrega_royalties_r.php?ref="+ref+"&id_empresa="+id_empresa,document.getElementById("carrega_mensagem_input"), true)
}

function carrega_fornecedor_contas(id){
	ajaxGet("../carrega_combo/carrega_forn_conta.php?id="+id,document.getElementById("carrega_forn"), true)
}

function excluir_contaapagar(id_pagamento){
	ajaxGet("../carrega_combo/excluir_contaapagar.php?id_pagamento="+id_pagamento,document.getElementById("exc_"+id_pagamento), true)
}

function calcula_retem(valor,id_regime){
	ajaxGet("../carrega_combo/carrega_retem.php?valor="+valor+"&id_regime="+id_regime,document.getElementById("carrega_retem"), true)
}

function carrega_fichas_correios(id_empresa){
	ajaxGet("../carrega_combo/carrega_correios.php?id_empresa="+id_empresa,document.getElementById("carrega_p_correios"), true)
}

function carrega_cartorio_edit(id_pedido_item){
	ajaxGet("../carrega_pedido/p_cartorio.php?id_pedido_item="+id_pedido_item,document.getElementById("carrega_cartorio_edit"), true)
}

function carrega_p_financeiro_edit(id_pedido_item){
	ajaxGet("../carrega_pedido/p_financeiro.php?id_pedido_item="+id_pedido_item,document.getElementById("carrega_p_financeiro_edit"), true)
}

function carrega_anexo_edit(id_pedido_item){
	ajaxGet("../carrega_pedido/p_anexo.php?id_pedido_item="+id_pedido_item,document.getElementById("carrega_anexo_edit"), true)
}

function carrega_mensagem_edit(id_pedido_item){
	ajaxGet("../carrega_pedido/p_mensagem.php?id_pedido_item="+id_pedido_item,document.getElementById("carrega_mensagem_edit"), true)
}

function carrega_atividade(id_pedido_item){
	ajaxGet("../carrega_pedido/p_atividade.php?id_pedido_item="+id_pedido_item,document.getElementById("carrega_ativ"), true)
}

function carrega_atividade_log(id_pedido_item){
	ajaxGet("../carrega_pedido/p_atividade_log.php?id_pedido_item="+id_pedido_item,document.getElementById("carrega_log_ativ"), true)
}

function carrega_solicitante(id_pedido,ordem){
	ajaxGet("../carrega_pedido/p_solicitante.php?id_pedido="+id_pedido+"&ordem="+ordem,document.getElementById("carrega_solic"), true)
}

function carrega_solicitante_edit(id_pedido,ordem){
	ajaxGet("../carrega_pedido/p_solicitante_edit.php?id_pedido="+id_pedido+"&ordem="+ordem,document.getElementById("carrega_solic"), true)
}

function carrega_servico_edit(id_pedido,ordem){
	ajaxGet("../carrega_pedido/p_servico_edit.php?id_pedido="+id_pedido+"&ordem="+ordem,document.getElementById("carrega_pedido_add"), true)
}

function carrega_cliente_conv(id_cliente){
	ajaxGet("../carrega_combo/carrega_cliente.php?id_cliente="+id_cliente,document.getElementById("id_cliente"), true)
}

function carrega_departamento(id_servico_departamento){
	ajaxGet("../carrega_combo/carrega_departamento.php?id_servico_departamento="+id_servico_departamento,document.getElementById("id_servico_departamento"), true)
}

function servico_grava(valor,dias,id_servico_var){
	ajaxGet("../includes/carrega_valor_grava.php?valor="+valor+"&dias="+dias+"&id_servico_var="+id_servico_var,document.getElementById("result_grava"), true)
}

function carrega_servico_valor(id_servico_var,form){
	ajaxGet("../includes/carrega_servico_valor.php?id_servico_var="+id_servico_var+"&form="+form,document.getElementById("carrega_valor"), true)
}

function carrega_imoveis_busca(id_impresso){
	ajaxGet("../includes/carrega_imoveis_busca.php?id_impresso="+id_impresso,document.getElementById("carrega_imoveis_busca"), true)
}

function carrega_financeiro_edit(id_pedido_item,id_financeiro){
	ajaxGet("../includes/carrega_financeiro_edit.php?id_pedido_item="+id_pedido_item+"&id_financeiro="+id_financeiro,document.getElementById("carrega_mensagem_input"), true)
}

function carrega_financeiro_edit_r(id_pedido_item,id_financeiro){
	ajaxGet("../includes/carrega_financeiro_edit_r.php?id_pedido_item="+id_pedido_item+"&id_financeiro="+id_financeiro,document.getElementById("carrega_mensagem_input"), true)
}

function carrega_financeiro_edit_d(id_pedido_item,id_financeiro){
	ajaxGet("../includes/carrega_financeiro_edit_d.php?id_pedido_item="+id_pedido_item+"&id_financeiro="+id_financeiro,document.getElementById("carrega_mensagem_input"), true)
}

function carrega_financeiro_edit_des(id_pedido_item){
	ajaxGet("../includes/carrega_financeiro_edit_des.php?id_pedido_item="+id_pedido_item,document.getElementById("carrega_mensagem_input"), true)
}

function carrega_mensagem_chat(){
	ajaxGet("../includes/carrega_mensagem_chat.php",document.getElementById("mensagem"), true)
}

function carrega_cartorio(id_cartorio){
	ajaxGet("../includes/carrega_cartorio.php?id_cartorio="+id_cartorio,document.getElementById("carrega_mensagem_input"), true)
}


function carrega_pedido_cartorio(id_pedido_cartorio){
	ajaxGet("../includes/carrega_pedido_cartorio.php?id_pedido_cartorio="+id_pedido_cartorio,document.getElementById("carrega_mensagem_input"), true)
}


function carrega_comissionado(comissionado){
	ajaxGet("../includes/carrega_comissionado.php?comissionado="+comissionado,document.getElementById("comissionado"), true)
}

function carrega_pontodevenda(id_ponto){
	ajaxGet("../includes/carrega_pontodevenda.php?id_ponto="+id_ponto,document.getElementById("id_ponto"), true)
}

function carrega_finaliza_chat(){
	ajaxGet("../includes/carrega_finaliza_chat.php",document.getElementById("finaliza_chat"), true)
}

function carrega_pedido_status(id_pedido_status){
	ajaxGet("../includes/carrega_pedido_status.php?id_pedido_status="+ id_pedido_status,document.getElementById("carrega_mensagem_input"), true)
}

function carrega_mensagem(id_mensagem){
	ajaxGet("../includes/carrega_mensagem.php?id_mensagem="+ id_mensagem,document.getElementById("carrega_mensagem_input"), true)
}

function carrega_pedido_txt(id_pedido){
	ajaxGet("../includes/carrega_pedido_txt.php?id_pedido="+ id_pedido,document.getElementById("carrega_mensagem_input"), true)
}

function carrega_envia_mensagem_chat(mensagem_box){
	ajaxGet("../includes/carrega_envia_mensagem_chat.php?mensagem_box="+mensagem_box,document.getElementById("envia_mensagem"), true);

}

function carrega_contato(id_conveniado,id_cliente){
	ajaxGet("../includes/carrega_contato.php?id_conveniado="+id_conveniado+"&id_cliente="+id_cliente,document.getElementById("id_conveniado_input"), true)
}

function carrega_cartorio_texto(tipo_impresso){
	ajaxGet("../includes/carrega_cartorio_texto.php?tipo_impresso="+tipo_impresso,document.getElementById("carrega_texto"), true)
}

function carrega_cartorio_cidade(cartorio_estado,cartorio_atribuicao){
	ajaxGet("../includes/carrega_cartorio_cidade.php?cartorio_estado="+cartorio_estado+"&cartorio_atribuicao="+cartorio_atribuicao,document.getElementById("cartorio_cidade"), true)
}

function carrega_cartorio_cartorio(cartorio_estado,cartorio_atribuicao,cartorio_cidade){
	ajaxGet("../includes/carrega_cartorio_cartorio.php?cartorio_estado="+cartorio_estado+"&cartorio_atribuicao="+cartorio_atribuicao+"&cartorio_cidade="+cartorio_cidade,document.getElementById("cartorio_cartorio"), true)
}

function carrega_cartorio_impressao(cartorio_estado,cartorio_atribuicao,cartorio_cidade){
	ajaxGet("../includes/carrega_cartorio_impressao.php?cartorio_estado="+cartorio_estado+"&cartorio_atribuicao="+cartorio_atribuicao+"&cartorio_cidade="+cartorio_cidade,document.getElementById("cartorio_impressao"), true)
}

function carrega_cliente(form,cpf){
	ajaxGet("../includes/carrega_cliente.php?cpf="+ cpf+"&form="+form,document.getElementById("carrega_dados"), true)
}

function carrega_sacado(form,cpf){
	ajaxGet("../includes/carrega_sacado.php?cpf="+ cpf+"&form="+form,document.getElementById("carrega_dados"), true)
}

function carrega_campo_velho(id,id_pedido_item){
	ajaxGet("../includes/carrega_campos.php?id="+id+"&id_pedido_item="+id_pedido_item,document.getElementById("carrega_campos_input"), true)
}

function carrega_campo_r(id,id_pedido,ordem){
	ajaxGet("../includes/carrega_campos.php?id="+id+"&id_pedido="+id_pedido+"&ordem="+ordem,document.getElementById("carrega_campos_input"), true)
}

function carrega_servico(id_departamento,id_servico){
	ajaxGet("../carrega_combo/carrega_servico.php?id_departamento="+id_departamento+"&id_servico="+id_servico,document.getElementById("id_servico"), true)
}

function carrega_servico_var(id_servico,id_servico_var){
	ajaxGet("../carrega_combo/carrega_servico_var.php?id_servico="+id_servico+"&id_servico_var="+id_servico_var,document.getElementById("id_servico_var"), true)
}

function carrega_servico_var_valor(id_servico){
	ajaxGet("../includes/carrega_servico_var_valor.php?id_servico="+id_servico,document.getElementById("id_servico_var_valor"), true)
}

//function teste
function carrega_servico_var_valor2(id_servico){
	ajaxGet("../includes/carrega_servico_var_valor2.php?id_servico="+id_servico,document.getElementById("id_servico_var_valor"), true)
}


function carrega_cliente_id(id,id_cliente,form){
	ajaxGet("../includes/carrega_cliente_id.php?id="+id+"&id_cliente="+id_cliente+"&form="+form,document.getElementById("carrega_dados"), true)
}

function carrega_estados(estado){
	ajaxGet("../includes/carrega_estados.php?estado="+ estado,document.getElementById("carrega_estado"), true)
}

function carrega_cidades(estado,id_cidade){
	ajaxGet("../includes/carrega_cidades.php?estado="+ estado+"&id_cidade="+id_cidade,document.getElementById("carrega_cidade"), true)
}

function carrega_cidade2(estado){
	ajaxGet("../carrega_combo/carrega_cidade.php?estado="+ estado,document.getElementById("carrega_cidade_campo"), true)
}

function carrega_cidade3(estado,cidade){
	ajaxGet("../carrega_combo/carrega_cidade.php?estado="+ estado+"&cidade="+cidade,document.getElementById("carrega_cidade_campo"), true)
}

function carrega_cpf(tipo,cpf){
	ajaxGet("../includes/cpf_cnpj.php?tipo="+ tipo+"&cpf="+cpf,document.getElementById("cpf"), true)
}

function completa_valores(form,campo,valor,qtdd){
	ajaxGet("../includes/carrega_valores.php?campo="+campo+"&form="+form+"&valor="+valor+"&qtdd="+qtdd,document.getElementById("completa_valor"), true)
}

function carrega_endedeco(cep, form){
	ajaxGet("../includes/carrega_endereco.php?cep="+cep+"&form="+form,document.getElementById("resgata_endereco"), true)
}

function carrega_endedeco2(cep, form){
	ajaxGet("../includes/carrega_endereco2.php?cep="+cep+"&form="+form,document.getElementById("resgata_endereco"), true)
}


function carrega_clientesemespera(){
	ajaxGet("../includes/carrega_clientesemespera.php",document.getElementById("clientesemespera"), true)
}

function faturar_mesmoendereco(travar){
	
	document.pedido_add.endereco_f.disabled=travar; 
	document.pedido_add.cep_f.disabled=travar; 
	document.pedido_add.numero_f.disabled=travar; 
	document.pedido_add.complemento_f.disabled=travar; 
	document.pedido_add.bairro_f.disabled=travar; 
	document.pedido_add.cidade_f.disabled=travar; 
	document.pedido_add.estado_f.disabled=travar;
	if(travar){
		document.pedido_add.endereco_f.value=document.pedido_add.endereco.value; 
		document.pedido_add.cep_f.value=document.pedido_add.cep.value; 
		document.pedido_add.numero_f.value=document.pedido_add.numero.value; 
		document.pedido_add.complemento_f.value=document.pedido_add.complemento.value; 
		document.pedido_add.bairro_f.value=document.pedido_add.bairro.value; 
		document.pedido_add.cidade_f.value=document.pedido_add.cidade.value; 
		document.pedido_add.estado_f.value=document.pedido_add.estado.value;
	}else{
		document.pedido_add.endereco_f.value=''; 
		document.pedido_add.cep_f.value=''; 
		document.pedido_add.numero_f.value=''; 
		document.pedido_add.complemento_f.value=''; 
		document.pedido_add.bairro_f.value=''; 
		document.pedido_add.cidade_f.value=''; 
		document.pedido_add.estado_f.value='';
	}
}

function faturar_mesmoendereco_edit(travar){
	document.p_solicitante.endereco_f.disabled=travar; 
	document.p_solicitante.cep_f.disabled=travar; 
	document.p_solicitante.numero_f.disabled=travar; 
	document.p_solicitante.complemento_f.disabled=travar; 
	document.p_solicitante.bairro_f.disabled=travar; 
	document.p_solicitante.cidade_f.disabled=travar; 
	document.p_solicitante.estado_f.disabled=travar;
	if(travar){
		document.p_solicitante.endereco_f.value=document.p_solicitante.endereco.value; 
		document.p_solicitante.cep_f.value=document.p_solicitante.cep.value; 
		document.p_solicitante.numero_f.value=document.p_solicitante.numero.value; 
		document.p_solicitante.complemento_f.value=document.p_solicitante.complemento.value; 
		document.p_solicitante.bairro_f.value=document.p_solicitante.bairro.value; 
		document.p_solicitante.cidade_f.value=document.p_solicitante.cidade.value; 
		document.p_solicitante.estado_f.value=document.p_solicitante.estado.value;
	}else{
		document.p_solicitante.endereco_f.value=''; 
		document.p_solicitante.cep_f.value=''; 
		document.p_solicitante.numero_f.value=''; 
		document.p_solicitante.complemento_f.value=''; 
		document.p_solicitante.bairro_f.value=''; 
		document.p_solicitante.cidade_f.value=''; 
		document.p_solicitante.estado_f.value='';
	}
}
function confirmDelete() {
	return confirm("Tem certeza que deseja deletar esse registro?");   
} 	

function masc_numeros(obj,mascara) {
		str   = obj.value
		len   = str.length
		str2  = ""
		digito = /^\d$/
		for (i = 0; i < len ; i ++ ) {
			if (digito.test(str.charAt(i))) str2 += str.charAt(i)

		}

		str   = str2

		len   = str.length

		str2  = ""

		for (i = 0 , j = 0 ; j < len && i<mascara.length; i ++ ) {

			if (mascara.charAt(i) == "#") {

				str2 += str.charAt(j)

				j++

			} else {

				str2 += mascara.charAt(i)

			}

		}

		obj.value = str2

}


function moeda(k,valor,id) {
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
       alert('O formato do valor deve ser ###.##'+k);
   }
}


function camada( sId, visivel ) { //função que esconde/mostra a camada
	var sDiv = document.getElementById( sId );
	if( visivel == "true" ) {
		sDiv.style.display = "block";
	} else {
		sDiv.style.display = "none";
	}
}

/* drag da calculadora */

<!-- This script and many more are available free online at -->
<!-- Created by: elouai.com -->
<!-- Início

var ie=document.all;
var nn6=document.getElementById&&!document.all;
var isdrag=false;
var x,y;
var dobj;

function movemouse(e)
{
  if (isdrag)
  {
    dobj.style.left = nn6 ? tx + e.clientX - x : tx + event.clientX - x;
    dobj.style.top  = nn6 ? ty + e.clientY - y : ty + event.clientY - y;
    return false;
  }
}

function selectmouse(e)
{
  var fobj       = nn6 ? e.target : event.srcElement;
  var topelement = nn6 ? "HTML" : "BODY";
  while (fobj.tagName != topelement && fobj.className != "dragme")
  {
    fobj = nn6 ? fobj.parentNode : fobj.parentElement;
  }

  if (fobj.className=="dragme")
  {
    isdrag = true;
    dobj = fobj;
    tx = parseInt(dobj.style.left+0);
    ty = parseInt(dobj.style.top+0);
    x = nn6 ? e.clientX : event.clientX;
    y = nn6 ? e.clientY : event.clientY;
    document.onmousemove=movemouse;
    return false;
  }

}

function copia_permissao(addPerm,dep){
	if(addPerm){
		document.getElementById('pertence_'+dep).checked=true;
	}
}

function buscaData(inp){
	if(inp.value!=''){
		$.get("conta_dias_uteis.php",{ dias: inp.value },
			function(data_posdias){
				$('#data_posdias').attr('value',data_posdias);
			}
		);
	}else{
		$('#data_posdias').attr('value','');
	}
}

document.onmouseup=new Function("isdrag=false");


function openConfirmBox(titulo, perg, resp1, resp2){
	jConfirm(perg, titulo, function(valor) {
		var resp = resp1;
		if(valor == false){
			resp = resp2;
		}
		location.href = resp;
	});
}

function openAlertBox(titulo, msg, pagina){
	jAlert(msg, titulo);
	if(pagina.length > 0){
		setTimeout("document.location.href='"+ pagina +"'",2000);
	}
}

//RAFAEL 23/05/2011
function busca_endereco(tipo){
	cep    = document.getElementById('busca_cep').value;
	erro = 0;
	
	if(cep.length == 0){
		erro = 1;
		mensagem = "Preencha o campo 'Busca CEP', para fazer a busca!";
		cp = 'busca_cep';
	}

	if(cep.length > 0 && cep.length < 9){
		erro = 1;
		mensagem = 'Para fazer a busca você deve digitar uma faixa de CEP válida!';
		cp = 'busca_cep';
	}
	
	if(erro == 0){
		pesquisa = 'cep='+cep;
		ajaxGet('../includes/busca_endereco.php?'+pesquisa, document.getElementById("resulta_pesquisa_busca_endereco"), true);
	} else {
		alert(mensagem);
		document.getElemenById(cp).focus();
	}
}

function CarregaEndereco(endereco, bairro, cep, cidade, estado, idfranquia, franquia){
	document.getElementById('endereco').value = endereco;
	document.getElementById('bairro').value = bairro;
	document.getElementById('cep').value = cep;
	document.getElementById('cidade').value = cidade;
	document.getElementById('estado').value = estado;
	document.getElementById('id_franquia').value = idfranquia;
	document.getElementById('franquia').value = franquia;
	document.getElementById('resulta_pesquisa_busca_endereco').innerHTML = '';
}

function CarregaAnexo(id){
	if(document.getElementById('certidao_resultado')){
		//document.getElementById('certidao_resultado').style.display = 'none';
		document.getElementById('certidao_resultado').disabled = true;
		switch(id){
			case 'Certidão': document.getElementById('certidao_resultado').disabled = false; break;
		}
	}
}

//Alterado 30/06/2011
jQuery.noConflict();
jQuery(function($){  
	$("#data_ultimo_contato").mask("99/99/9999");
	$("#data_aniversario").mask("99/99/9999");
        $("#data_contrato_i").mask("99/99/9999");
        $("#data_contrato_f").mask("99/99/9999");
});

function CarregaBalancoFinanceiro(id){
	ajaxGet('../includes/balanco_comercial.php?id='+id, document.getElementById("balanco_financeiro"), true);
}
//  Fim -->

//Alterado 24/11/2011
function MultiTafCidades(valor, div, pagina){
	url = pagina + '&valor=' + valor;
	ajaxGet('../includes/' + url, document.getElementById(div), true);
}

function MultiploSelect(acao, cp1, cp2, d1, d2){
	var j = 0; k = 0; cont1 = 0; cont2 = 0;
	var s1 		 = document.getElementById(cp1);
	var s2 		 = document.getElementById(cp2); s3 = '';
	var r1 		 = new Array();
	var r2 		 = new Array();
	var obj      = new Array(d1, d2);
	var dt       = new Array(r1, r2);
	var list     = new Array(cp1, cp2);
	var contador = new Array(cont1, cont2);

	if(acao == 1){ 
		if(s2.options.length > 0){
			for(i = 0; i < s2.options.length; i++){
				r2[j] = new Array();
				r2[j][1] = s2[i].value;
				r2[j][0] = s2[i].text;
				j++;
			}
		}		
		for(i = 0; i < s1.options.length; i++){
			if(s1[i].selected == true){
				r2[j] = new Array();
				r2[j][1] = s1[i].value;
				r2[j][0] = s1[i].text;
				j++;
			} else {
				r1[k] = new Array();
				r1[k][1] = s1[i].value;
				r1[k][0] = s1[i].text;
				k++;
			}
		}
	} else {
		if(s1.options.length > 0){
			for(i = 0; i < s1.options.length; i++){
				r1[j] = new Array();
				r1[j][1] = s1[i].value;
				r1[j][0] = s1[i].text;
				j++;
			}
		}
		for(i = 0; i < s2.options.length; i++){
			if(s2[i].selected == true){
				r1[j] = new Array();
				r1[j][1] = s2[i].value;
				r1[j][0] = s2[i].text;
				j++;
			} else {
				r2[k] = new Array();
				r2[k][1] = s2[i].value;
				r2[k][0] = s2[i].text;
				k++;
			}
		}
	}
	r1.sort();
	r2.sort();
	for(j = 0; j < obj.length; j++){
		document.getElementById(obj[j]).innerHTML = '';
		html = '<select multiple id="'+list[j]+'" name="'+list[j]+'[]" class="form_estilo" style="width:220px; height:100px;">\n';
		for(i = 0; i < dt[j].length; i++){
			html += '<option value="'+dt[j][i][1]+'">'+dt[j][i][0]+'</option>\n';
			contador[j]++;
		}
		html += '</select>';
		document.getElementById(obj[j]).innerHTML = html;
	}
	document.getElementById('deletar').disabled = (contador[1] > 0) ? false : true; 
	document.getElementById('incluir').disabled = (contador[0] > 0) ? false : true; 
}

function RegiaoInteresse(){
	var s = document.getElementById('regiao_interesse2');
	if(s.options.length > 0){
		id = new Array();
		for(i = 0; i < s.options.length; i++){ id[i] = s[i].value; }
		document.getElementById('regiao_interesse').value = id;
	}
}

function CarregarMascarasInteresse(){
	jQuery.noConflict();
	jQuery(function($){  
		$("#cep").mask("99999-999");
		$("#orgao_exp").mask("aaa/aa");
		$("#cpf").mask("999.999.999-99");
		$("#tel_res").mask("(99) 9999-9999");
		$("#tel_cel").mask("(99) 9999-9999");
		$("#tel_rec").mask("(99) 9999-9999");
		$("#tel_com").mask("(99) 9999-9999");
		$("#data_nasc").mask("99/99/9999");
		$("#contato_tel1").mask("(99) 9999-9999");
		$("#contato_tel2").mask("(99) 9999-9999");
		$("#fone1").mask("(99) 9999-9999");
		$("#fone2").mask("(99) 9999-9999");
		$("#nome_tel1").mask("(99) 9999-9999");
		$("#nome_tel2").mask("(99) 9999-9999");
		$("#investimento").maskMoney({symbol:"R$",decimal:",",thousands:"."});
	});
}

function VisualizarHistorico(acao, id){
	document.getElementById('hist').innerHTML = '';
	document.getElementById('abre_historico').style.display = 'block';
	if(acao == '1'){
		document.getElementById('abre_historico').style.display = 'none';
		ajaxGet("../expansao/fichas-editar-div-historico.php?id="+ id,document.getElementById("hist"), true)
	}
}

function SomaForm(cp){
	var v1 = document.getElementById('v1'+cp);
	var v2 = document.getElementById('v2'+cp);
	var v3 = document.getElementById('v3'+cp);

	vl1 = parseInt(v1.value.replace(".",""));
	vl2 = parseInt(v2.value.replace("_",""));

	var total = (String)(vl1 + vl2);
	
	if(total == 'NaN'){ total = '0'; }
	var id_ficha = '';
	for(i = 0; i < (6 - total.length); i++){
		id_ficha += '0';
	}
	id_ficha += total;
	ficha = id_ficha.substr(0,3) + '.' + id_ficha.substr(-3,3);

	v3.value = ficha;
}

function MaskFormControle(cp){
	/*jQuery.noConflict();
	jQuery(function($){  
		$("#"+cp).mask("999");
	});
	*/
	return document.getElemenById(cp).value.replace(/\D/g,"");
}

function ControleForm(acao, id){
	url = 'controle-formularios.php?id='+id+'&acao='+acao;
	if(acao == 2) {
		v1 = new Array(); v2 = new Array(); v4 = new Array();
		for(i = 0; i < document.getElementsByName('v2[]').length; i++){
			 v1[i] = document.getElementById('v1' + (i + 1)).value;
			 v2[i] = document.getElementById('v2' + (i + 1)).value;
			 v4[i] = document.getElementById('v4' + (i + 1)).value;
		}
		url += '&v1='+v1;
		url += '&v2='+v2;
		url += '&v4='+v4;
	}
	ajaxGet('../includes/' + url, document.getElementById('retorno'), true);
}

function VerificaStatus(id){
	//alert(id);
	document.getElementById('reuniao_agendada').style.display = 'none';
	document.getElementById('anotacao_obrigatoria').style.display = 'none';
	switch(id){
		case '5': 
		case '10': 		
		case '12': case '19': document.getElementById('reuniao_agendada').style.display = 'block'; break; 
		case '2': case '3': case '16': case '17': 
			document.getElementById('anotacao_obrigatoria').style.display = 'block';		
		break;
	}
}

function excluir_duplicidades(){
	dups = '';
	for(i = 0; i < document.getElementsByName('dups').length; i++){
		if(document.getElementsByName('dups')[i].checked == true){
			dups += document.getElementsByName('dups')[i].value + ';';
		}
	}
	if(dups.length == 0){
		alert('Selecione um campo para continuar!');
	} else {
		var msg = confirm("Deseja realmente excluir estes itens selecionados?",'Sim','Não');
		if(msg == true){
			document.getElementById('duplicidades').value = dups;
			document.getElementById('form1').submit();
		}
	}
}

function ativar_implantacao(id){
	ajaxGet("../implantacao/ativar_implantacao.php?id_ficha="+ id,document.getElementById("retorno"), true);
}

function enviar_form(){
	location.href = 'franquias-novas.php?busca='+document.getElementById('busca').value;
}

function carregar_implantacao(id_implantacao,id_empresa){
	ajaxGet("../implantacao/implantacao.php?id_implantacao="+ id_implantacao+"&id_empresa="+id_empresa,document.getElementById("retorno"), true);
}

function alterar_implantacao(id_implantacao){
	url = '../implantacao/implantacao.php?acao_implementacao=1';
	url += '&id_implantacao='+id_implantacao;
	for(i = 0; i < document.getElementById('form1').elements.length; i++){
		tipo = document.getElementById('form1').elements[i].type;
		nome = document.getElementById('form1').elements[i].name;
		if(tipo != 'button'){
			if(tipo == 'checkbox'){
				valor = 0;
				if(document.getElementById('form1').elements[i].checked == true){ valor = 1; }
				url += '&' + nome + '=' + valor;
			} else {
				url += '&' + nome + '=' + replaceAll(document.getElementById('form1').elements[i].value, "'", "´");
			}
		}
	}
	ajaxGet(url, document.getElementById("retorno"), true);
}

function replaceAll(string, token, newtoken) {
	while (string.indexOf(token) != -1) {
 		string = string.replace(token, newtoken);
	}
	return string;
}

function implantacao_email(acao, em, us){
	url = '../implantacao/email.php?acao='+acao+'&emp='+em;
	url += '&usr='+us;
	ajaxGet(url, document.getElementById("retorno"), true);
}

function faixa_cep(acao, num){
	cp = new Array('cep_i','cep_f','apelido','cidade','estado',
		'loja','latitude','longitude','cdt','distancia','id_franquia_regiao');
	tipo = new Array(1,1,1,1,1,0,0,0,0,0,0,0);
	valor= new Array('','','','',0,0,'','','','',0);
	for(i = 0; i < cp.length; i++){
		b1 = document.getElementById(cp[i]);
		b2 = cp[i] + '' + num;
		b2 = document.getElementById(b2);
		if(acao == 1){
			b1 = (tipo[i] == 1) ? b1.value = b2.innerHTML : b1.value = b2.value;
		} else {
			b1.value = valor[i];
		}
	}
	enviar = document.getElementById('btn');
	enviar = (acao == 1) ? enviar.value = 'Editar' : enviar.value = 'Incluir';
}

function franquia_master(id){
	document.getElementById('lb_id_recursivo').style.display = 'none';
	document.getElementById('id_recursivo').style.display = 'none';
	document.getElementById('br_id_recursivo').style.display = 'none';
	if(id > 1){
		document.getElementById('lb_id_recursivo').style.display = 'block';
		document.getElementById('id_recursivo').style.display = 'block';
		document.getElementById('br_id_recursivo').style.display = 'block';
	} 
}

function f_cpmail(){
	if(document.getElementById('sigla').value.length > 0 &&
		document.getElementById('sigla').value != 'sigla do e-mail'){
		document.getElementById('email').value = 'diretoria.' + document.getElementById('sigla').value + '@cartoriopostal.com.br';
	} else {
		document.getElementById('email').value = '';
	}
}

function franquia_editar(tipo, empresa){
	url = '../implantacao/implantacao.php?id_empresa='+empresa;
	if(tipo == 2){
		url += '&id_implantacao=12';
	} else if(tipo == 3){
		url += '&id_implantacao=1';
	}
	for(i = 0; i < document.getElementById('form1').elements.length; i++){
		tipo = document.getElementById('form1').elements[i].type;
		nome = document.getElementById('form1').elements[i].name;
		if(tipo == 'checkbox'){
			valor = 0;
			if(document.getElementById('form1').elements[i].checked == true){ 
				valor = replaceAll(document.getElementById('form1').elements[i].value, '&', '**amp**'); 
			}
			url += '&' + nome + '=' + valor;
		} else {
			valor = replaceAll(document.getElementById('form1').elements[i].value, "&", "**amp**")
			valor = replaceAll(valor, "'", "´");
			valor = replaceAll(valor, "\n", "<br />");
			valor = replaceAll(valor, '%', 'por100tagem');
			url += '&' + nome + '=' + valor;
		}
	} //alert(url);
	ajaxGet(url, document.getElementById("retorno"), true);
}

function CheckAll(bt){
	if(document.getElementById('checkbox_image').value == 0){
		document.getElementById('checkbox_buttom').src  = '../images/botoes/check2.png';
		document.getElementById('checkbox_image').value = 1;
		acao = 1;
	} else {
		document.getElementById('checkbox_buttom').src  = '../images/botoes/check1.png';
		document.getElementById('checkbox_image').value = 0;
		acao = 0;
	}
	for(i = 0; i < document.getElementsByName(bt).length; i++){
		if(acao == 0){
			document.getElementsByName(bt)[i].checked = true;
		} else {
			document.getElementsByName(bt)[i].checked = false;
		}
	}
}

function ficha_form_edita(num){
	for(i = 0; i <= 4; i++){
		document.getElementById('cad'+i).style.display = 'none';
	}
	document.getElementById('cad'+num).style.display = 'block';
}

function submit_expansao_edit(valor){
	document.getElementById('acao_btn').value = valor;
	document.getElementById('form1').submit();
}