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

function selecionar_tudo_cache(name){
	for (i=0;i < document.f1.elements.length;i++){
		if(document.f1.elements[i].type == "checkbox" && document.f1.elements[i].checked==0){
			if(document.f1.elements[i].value != 'on') {
				createCookie(name,document.f1.elements[i].value+',','1','1');
				createCookie('p_id_pedido','#'+document.f1.elements[i-1].value+',','1','1');	
			}	
		}	
	}		

}

function deselecionar_tudo_cache(name){
	for (i=0;i < document.f1.elements.length;i++){
		if(document.f1.elements[i].type == "checkbox" && document.f1.elements[i].checked==1){
			if(document.f1.elements[i].value != 'on') {
				eraseCookieItem(name,document.f1.elements[i].value);
				eraseCookieItem('p_id_pedido','#'+document.f1.elements[i-1].value+',');
			}	
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

function carrega_campo(id,id_pedido_item){
	ajaxGet("../includes/carrega_campos.php?id="+id+"&id_pedido_item="+id_pedido_item,document.getElementById("carrega_campos_input"), true)
}

function carrega_campo_r(id,id_pedido,ordem){
	ajaxGet("../includes/carrega_campos_copia.php?id="+id+"&id_pedido="+id_pedido+"&ordem="+ordem,document.getElementById("carrega_campos_input"), true)
}

function carrega_servico(id_departamento,id_servico){
	ajaxGet("../includes/carrega_servico.php?id_departamento="+id_departamento+"&id_servico="+id_servico,document.getElementById("id_servico"), true)
}

function carrega_servico_var(id_servico,id_servico_var){
	ajaxGet("../includes/carrega_servico_var.php?id_servico="+id_servico+"&id_servico_var="+id_servico_var,document.getElementById("id_servico_var"), true)
}

function carrega_servico_var_valor(id_servico){
	ajaxGet("../includes/carrega_servico_var_valor.php?id_servico="+id_servico,document.getElementById("id_servico_var_valor"), true)
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


document.onmouseup=new Function("isdrag=false");
//  Fim -->

