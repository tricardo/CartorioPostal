function carrega_cidades(estado,id_cidade){
	ajaxGet("../includes/carrega_cidades.php?estado="+estado+"&id_cidade="+id_cidade,document.getElementById("carrega_cidade"), true)
}

/* fim do chat */
function enviaChat(assunto, retorno, form) {
	$.ajax({
		contentType: 'application/x-www-form-urlencoded; charset=iso-8859-1',
		type: "POST",
		url: "../safpostal/chat_ajax.php",
		dataType: "html",
		data: 'assunto='+assunto + '&retorno='+retorno + '&form='+form ,
		success: function(msg){
			$('#dados').html(msg);
		}
	});
}

        function contador() {
				contando_tempo = true;
                var saida = ((horas<10)?"0"+horas:horas) + ":" + ((minutos<10)?"0"+minutos:minutos) + ":" + ((segundos<10)?"0"+segundos:segundos) + ":" + ((milis<10)?"0"+milis:milis);
        if(milis<9){
                milis++;
        }
        else{
                milis=0;
        if(segundos < 60){
                segundos++;
        }
        else{   
                segundos = 0;
                if(minutos < 59){
                        minutos++;
                }
                else{
                        minutos = 0;
                        if(horas < 23){
                                horas++;
                        }
                        else{
                                horas = 0;
                        }
                }
        }
        }
        document.getElementById("clock1").innerHTML = saida;
        if(saida>='00:00:07:00'){
			enviaChat('','retorno','form_chat_moderador');
	} else {
		tempo = setTimeout('contador()', 100);
	}        
}


        function contador_proximo() {
				contando_tempo = true;
                var saida = ((horas<10)?"0"+horas:horas) + ":" + ((minutos<10)?"0"+minutos:minutos) + ":" + ((segundos<10)?"0"+segundos:segundos) + ":" + ((milis<10)?"0"+milis:milis);
        if(milis<9){
                milis++;
        }
        else{
                milis=0;
        if(segundos < 60){
                segundos++;
        }
        else{   
                segundos = 0;
                if(minutos < 59){
                        minutos++;
                }
                else{
                        minutos = 0;
                        if(horas < 23){
                                horas++;
                        }
                        else{
                                horas = 0;
                        }
                }
        }
        }
        document.getElementById("clock1").innerHTML = saida;
        if(saida>='00:00:07:00'){
			chat_proximo('lista_espera');
	} else {
		tempo = setTimeout('contador_proximo()', 100);
	}        
}

function Verifica(){
        if (contando_tempo){
                tempo = setTimeout('contador()', 100);
        }
}

function chat_proximo(retorno){
	ajaxGet("../safpostal/chat_proximo_ajax.php",document.getElementById(retorno), true);
}

/* fim do chat */
function forum_resposta_acao(retorno,id,acao){
	ajaxGet("../includes/carrega_forum_acao.php?id="+id+"&acao="+acao,document.getElementById(retorno), true)
}

function forum_topico_acao(retorno,id,acao){

	ajaxGet("../includes/carrega_forum_top_acao.php?id="+id+"&acao="+acao,document.getElementById(retorno), true)
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


//04/07/2011
function CarregaAba(id){
	var a;
	var p;
	for(i = 1; i <= 3; i++){
		a = 'aba' + i;
	p = 'pagina' + i;
		if(document.getElementById(p)){
			document.getElementById(p).style.display = 'none';
			document.getElementById(a).style.backgroundColor = '#CCC';
			document.getElementById(a).style.borderBottom = 'solid 1px #686868';
		}
	}
	a = 'aba' + id;
	p = 'pagina' + id;
	document.getElementById(a).style.backgroundColor = '#0071B6';
	document.getElementById(a).style.borderBottom = 'solid 1px #0071B6';
	document.getElementById(p).style.display = 'block';
}

jQuery.noConflict();
jQuery(function($){  
  $("#valor_disp").maskMoney({symbol:"R$", decimal:",", thousands:"."});
  $("#limite").maskMoney({symbol:"R$", decimal:",", thousands:"."});
  $("#honorarios").maskMoney({symbol:"R$", decimal:",", thousands:"."});
  $("#salarios").maskMoney({symbol:"R$", decimal:",", thousands:"."});
  $("#comissoes").maskMoney({symbol:"R$", decimal:",", thousands:"."});
  $("#salario_conjuge").maskMoney({symbol:"R$", decimal:",", thousands:"."});
  $("#renda_alugueis").maskMoney({symbol:"R$", decimal:",", thousands:"."});
  $("#emprestimo_financeiro").maskMoney({symbol:"R$", decimal:",", thousands:"."});
  $("#valor_veiculo").maskMoney({symbol:"R$", decimal:",", thousands:"."});
  $("#valor_venal").maskMoney({symbol:"R$", decimal:",", thousands:"."});
  $("#somatoria").maskMoney({symbol:"R$", decimal:",", thousands:"."});
  $("#valor_efetivo").maskMoney({symbol:"R$", decimal:",", thousands:"."});
  $("#valor_cof").maskMoney({symbol:"R$", decimal:",", thousands:"."});
  $("#placa_veiculo").mask("aaa - 9999"); 
  $("#cpf").mask("999.999.999-99");
  $("#conjuge_cpf").mask("999.999.999-99");
  //$("#rg").mask("99.999.999-*");
  //$("#rg").alphanumeric();
  $("#conjuge_rg").mask("99.999.999-9");
  $("#conjuge_nascimeto").mask("99/99/9999");
  $("#nascimento").mask("99/99/9999");
  $("#data_casamento").mask("99/99/9999");
  $("#conjuge_nasc").mask("99/99/9999");
  $("#conjuge_admissao").mask("99/99/9999");
  $("#tel_res").mask("(99) 9999-9999");
  $("#tel_rec").mask("(99) 9999-9999");
  $("#tel_cel").mask("(99) 9999-9999");
  $("#conjuge_telefone").mask("(99) 9999-9999");
  $("#filhos_quant").mask("99");
  $("#conjuge_tel").mask("(99) 9999-9999");
  $("#conjuge_end_cep").mask("99999-999");
  $("#cep").mask("99999-999");
  $("#anterior_cep").mask("99999-999");
  $("#conclusao").mask("99/9999");
  $("#vencimento").mask("99/9999");
  $("#telefone_banco").mask("(99) 9999-9999");
  $("#ano_veiculo").mask("9999/9999");
  $("#data_reuniao").mask("99/99/9999");
  $("#cep_i").mask("99999-999");
  $("#cep_f").mask("99999-999");
});

function CadNovInter(id){
	if(confirm('Deseja atualizar outro interessado?')){
		document.location.href = 'novos_interessados.php';
	} else {
		setTimeout("document.location.href = 'interessados_edit.php?id="+id+"'", 500);
	}
}

function VerificaStatus(id){
	//alert(id);
	document.getElementById('reuniao_agendada').style.display = 'none';
	document.getElementById('anotacao_obrigatoria').style.display = 'none';
	switch(id){
		case '5': 
		case '10': 		
		case '12': document.getElementById('reuniao_agendada').style.display = 'block'; break; 
		case '2': case '3': case '16': case '17': 
			document.getElementById('anotacao_obrigatoria').style.display = 'block';		
		break;
	}
}

function VisualizarHistorico(acao, id){
	document.getElementById('hist').innerHTML = '';
	document.getElementById('abre_historico').style.display = 'block';
	if(acao == '1'){
		document.getElementById('abre_historico').style.display = 'none';
		ajaxGet("novos_interessados_historico.php?id="+ id,document.getElementById("hist"), true)
	}
}

function listarInteressados(acao, id_status, pagina, total_registro){
	str  = 'acao='+acao;
	str += '&id_status='+pagina;
	str += '&pagina='+pagina;
	str += '&total_registro='+ total_registro;
	if(document.getElementById('usuario')){
		str += '&usuario='+document.getElementById('usuario').value;
	} else {
		str += '&usuario=0';
	}
	if(document.getElementById('estado_interesse')){
		str += '&uf='+document.getElementById('estado_interesse').value;
	}
	if(document.getElementById('cidade_interesse')){
		str += '&cidade='+document.getElementById('cidade_interesse').value; 
	}
	if(document.getElementById('id_status')){
		str += '&id_status='+document.getElementById('id_status').value;
	} else {
		str += '&id_status='+id_status;
	}
	if(document.getElementById('nome')){
		str += '&nome='+document.getElementById('nome').value;
	}
	if(document.getElementById('data1')){
		str += '&data1=' + document.getElementById('data1').value;
		str += '&data2=' + document.getElementById('data2').value;
	}
	ajaxGet("lista_combo_interessados.php?"+ str,document.getElementById("listar"), true)
}

function listarInteressados2(acao, id_status, pagina, total_registro){
	str  = 'acao='+acao;
	str += '&id_status='+pagina;
	str += '&pagina='+pagina;
	str += '&total_registro='+ total_registro;
	if(document.getElementById('usuario')){
		str += '&usuario='+document.getElementById('usuario').value;
	} else {
		str += '&usuario=0';
	}
	if(document.getElementById('estado_interesse')){
		str += '&uf='+document.getElementById('estado_interesse').value;
	}
	if(document.getElementById('cidade_interesse')){
		str += '&cidade='+document.getElementById('cidade_interesse').value; 
	}
	if(document.getElementById('id_status')){
		str += '&id_status='+document.getElementById('id_status').value;
	} else {
		str += '&id_status='+id_status;
	}
	if(document.getElementById('nome')){
		str += '&nome='+document.getElementById('nome').value;
	}
	if(document.getElementById('data1')){
		str += '&data1=' + document.getElementById('data1').value;
		str += '&data2=' + document.getElementById('data2').value;
	}
	ajaxGet("lista_combo_interessados2.php?"+ str,document.getElementById("listar"), true)
}

function InsereDirecionamento(){
	if(document.getElementById('usuario').value > 0){
		var ficha = new Array();
		k = 0;
		j = 0;
		for(i = 0; i < document.getElementsByName('id_ficha').length; i++){
			if(document.getElementsByName('id_ficha')[i].checked == true){
				ficha[k] = document.getElementsByName('id_ficha')[i].value;	
				k++;
				j = 1;
			}
		}
		if(j == 1){
			var str = 'carrega_direcionamento.php?acao=2&id_usuario='+document.getElementById('usuario').value;
			str += '&id_ficha='+ficha;
			if(document.getElementById('redirecionar')){
				str += '&redirecionar=1';
			}
			ajaxGet(str, document.getElementById("retorno"), true);
		} else {
			alert('Selecione um cliente!');	
		}
	} else {
		alert('Selecione um usuário!');	
	}
	return false;
}

function paginarInteressados(acao, pagina, uf, cidade, id_status, total_registro, nome){
	str  = 'acao='+acao;
	str += '&pagina='+pagina;
	str += '&uf='+uf;
	str += '&cidade='+cidade; 
	if(id_status.length > 0){
		str += '&id_status='+id_status;
	} else {
		str += '&id_status='+document.getElementById('usuario').value;
	}	
	str += '&total_registro='+ total_registro;
	str += '&nome='+ nome;
	ajaxGet("lista_combo_interessados.php?"+ str,document.getElementById("listar"), true)
}

function paginarInteressados2(acao, pagina, uf, cidade, id_status, total_registro, nome){
	str  = 'acao='+acao;
	str += '&pagina='+pagina;
	str += '&uf='+uf;
	str += '&cidade='+cidade; 
	str += '&id_status='+id_status;
	str += '&total_registro='+ total_registro;
	str += '&nome='+ nome;
	ajaxGet("lista_combo_interessados2.php?"+ str,document.getElementById("listar"), true)
}

function carrega_cidades_interessados(acao, uf, id){
	ajaxGet("estados_interessados.php?acao="+acao+"&uf="+ uf+'&id='+id,document.getElementById("d_cidade_interesse"), true)
}

function EsconderAbas(id){
	var aba, total;
	total = document.getElementsByName('botao').length / 3;
	for(i = 0; i < total; i++){
		aba = 'aba' + i;
		if(document.getElementById(aba)){
			document.getElementById(aba).style.display = 'none';
		}
	}
	aba = 'aba' + id;
	document.getElementById(aba).style.display = 'block';
}

function AddOutroCep(){
	stri = Array();
	strf = Array();
	stri[0] = '';
	strf[0] = '';
	if(document.getElementsByName('cep_i2[]')){
		for(i = 0; i < document.getElementsByName('cep_i2[]').length; i++){
			obi = 'cep_i'+i;
			obf = 'cep_f'+i;
			stri[i] = document.getElementById(obi).value;
			strf[i] = document.getElementById(obf).value;
		}
	}
	
	document.getElementById('outro_cep').innerHTML = '';
	total = parseInt(document.getElementById('cont_outro_cep').value) + 1;
	var str = '';
	for(i = 0; i < total; i++){
		vlri = '';
		vlrf = '';
		if(stri[i]){
			if(i < stri.length){
				vlri = stri[i];
				vlrf = strf[i];
			}
		}
		str += '<label style="width:758px;">&nbsp;'+(i+1)+' - ';
		str += '<input value="'+vlri+'" type="text" maxlength="9" class="form_estilo" ';
		str += 'onKeyPress="return digitos(event, this);" onKeyUp="Mascaras(\'CEP\',this,event);" ';
		str += 'name="cep_i2[]" id="cep_i'+i+'" style="width:70px;" /> - ';
		str += '<input value="'+vlrf+'" type="text" maxlength="9" class="form_estilo" ';
		str += 'onKeyPress="return digitos(event, this);" onKeyUp="Mascaras(\'CEP\',this,event);" ';
		str += 'name="cep_f2[]" id="cep_f'+i+'" style="width:70px; " /> ';
		str += '<a href="#outro_cep_lk" onclick="DelOutroCep('+i+');">excluir</a></label>';
	}	
	document.getElementById('outro_cep').innerHTML = str;
	document.getElementById('cont_outro_cep').value = total;
}

function DelOutroCep(id){
	stri = Array();
	strf = Array();
	str  = '';
	j    = 0;
	for(i = 0; i < document.getElementsByName('cep_i2[]').length; i++){
		if(i != id){
			obi = 'cep_i'+i;
			obf = 'cep_f'+i;
			if(document.getElementById(obi)){ stri[j] = document.getElementById(obi).value; }
			if(document.getElementById(obf)){ strf[j] = document.getElementById(obf).value; }
			j++;
		}
	}
	document.getElementById('outro_cep').innerHTML = '';
	total = parseInt(document.getElementById('cont_outro_cep').value) - 1;
	document.getElementById('cont_outro_cep').value = total;
	
	for(i = 0; i < total; i++){
		if(stri == ''){ stri = '0'; }
		str += '<label style="width:758px;">&nbsp;'+(i+1)+' - ';
		str += '<input value="'+stri+'" type="text" maxlength="9" class="form_estilo" ';
		str += 'onKeyPress="return digitos(event, this);" onKeyUp="Mascaras(\'CEP\',this,event);" ';
		str += 'name="cep_i2[]" id="cep_i'+i+'" style="width:70px;" /> - ';
		str += '<input value="'+strf+'" type="text" maxlength="9" class="form_estilo" ';
		str += 'onKeyPress="return digitos(event, this);" onKeyUp="Mascaras(\'CEP\',this,event);" ';
		str += 'name="cep_f2[]" id="cep_f'+i+'" style="width:70px;" /> ';
		str += '<a href="#outro_cep_lk" onclick="DelOutroCep('+i+');">excluir</a></label>';
	}
	document.getElementById('outro_cep').innerHTML = str;	
}

function Mascaras(tipo, campo, teclaPress) {
	if (window.event){
		var tecla = teclaPress.keyCode;
	} else {
		tecla = teclaPress.which;
	}
 
	var s = new String(campo.value);
	s = s.replace(/(\.|\(|\)|\/|\-| )+/g,'');
	tam = s.length + 1;
	
	if ( tecla != 9 && tecla != 8 ) {
		switch (tipo){
		case 'CPF' :
				if (tam > 3 && tam < 7)
						campo.value = s.substr(0,3) + '.' + s.substr(3, tam);
				if (tam >= 7 && tam < 10)
						campo.value = s.substr(0,3) + '.' + s.substr(3,3) + '.' + s.substr(6,tam-6);
				if (tam >= 10 && tam < 12)
						campo.value = s.substr(0,3) + '.' + s.substr(3,3) + '.' + s.substr(6,3) + '-' + s.substr(9,tam-9);
		break;
	
		case 'CNPJ' :
	
				if (tam > 2 && tam < 6)
						campo.value = s.substr(0,2) + '.' + s.substr(2, tam);
				if (tam >= 6 && tam < 9)
						campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,tam-5);
				if (tam >= 9 && tam < 13)
						campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,3) + '/' + s.substr(8,tam-8);
				if (tam >= 13 && tam < 15)
						campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,3) + '/' + s.substr(8,4)+ '-' + s.substr(12,tam-12);
		break;
	
		case 'TEL' :
				if (tam > 2 && tam < 4)
						campo.value = '(' + s.substr(0,2) + ') ' + s.substr(2,tam);
				if (tam >= 7 && tam < 11)
						campo.value = '(' + s.substr(0,2) + ') ' + s.substr(2,4) + '-' + s.substr(6,tam-6);
		break;
	
		case 'DATA' :
				if (tam > 2 && tam < 4)
						campo.value = s.substr(0,2) + '/' + s.substr(2, tam);
				if (tam > 4 && tam < 11)
						campo.value = s.substr(0,2) + '/' + s.substr(2,2) + '/' + s.substr(4,tam-4);
		break;
		
		case 'CEP' :
				if (tam > 5 && tam < 7)
						campo.value = s.substr(0,5) + '-' + s.substr(5, tam);
		break;
		}
	}
}

//--->Função para verificar se o valor digitado é número...<---
function digitos(event){
	if (window.event) {
		// IE
		key = event.keyCode;
	} else if ( event.which ) {
		// netscape
		key = event.which;
	}
	if ( key != 8 || key != 13 || key < 48 || key > 57 )
		return ( ( ( key > 47 ) && ( key < 58 ) ) || ( key == 8 ) || ( key == 13 ) );
	return true;
}

function Calendario(cp){
	document.getElementById('calendario').style.display = 'block';
	document.getElementById('calendario').style.left = (document.getElementById(cp).offsetLeft + 299) + 'px';
	document.getElementById('calendario').style.top = (document.getElementById(cp).offsetTop + 222) + 'px';
	ajaxGet("carrega_calendario.php?cp="+cp,document.getElementById("calendario"), true);
}

function CarregaCalendario(cp, dia, ano, mes){
	if(mes < 10){ mes = '0'+mes; }
	if(dia < 10){ dia = '0'+dia; }
	document.getElementById(cp).value = dia+'/'+mes+'/'+ano;
	document.getElementById('calendario').style.display = 'none';
}

function TrocaDataCalendario(acao, cp, vl1, vl2){
	if(acao == 1){
		ajaxGet("carrega_calendario.php?cp="+cp+'&mes='+vl1+'&ano='+vl2,document.getElementById("calendario"), true);
	} else if(acao = 2) {
		ajaxGet("carrega_calendario.php?cp="+cp+'&mes='+vl2+'&ano='+vl1,document.getElementById("calendario"), true);
	}
}

function VerData(acao, id_status, pagina, total_registro){
	data1 = document.getElementById('data1').value;
	data2 = document.getElementById('data2').value;
	if(data1 != '' && data2 != ''){
		if ( parseInt( data2.split( "/" )[2].toString() + data2.split( "/" )[1].toString() + data2.split( "/" )[0].toString() ) > parseInt( data1.split( "/" )[2].toString() + data1.split( "/" )[1].toString() + data1.split( "/" )[0].toString() ) ){
			listarInteressados(acao, id_status, pagina, total_registro);
		} else if(data1 == data2) {
			listarInteressados(acao, id_status, pagina, total_registro);
		} else {
			alert("A segunda data não pode ser menor que a primeira!");
		}	
	} else if((data1 != '' && data2 == '') || (data2 != '' && data1 == '')){
		alert("Você deve preencher as duas datas!");
	} else {
		listarInteressados(acao, id_status, pagina, total_registro);
	}
}

function Direcionamento(id){
	ajaxGet("carrega_direcionamento.php?id="+id+'&acao=1', document.getElementById("direcionamento"), true);
}

function Anexos(id, acao, id2){
	ajaxGet("carrega_anexos.php?id_ficha="+id+'&acao='+acao+'&id_anexo='+id2, document.getElementById("anexos"), true);
}

function CheckDirecionamento(id){
	if(document.getElementById(id).checked == true){
		document.getElementById(id).checked = false;
	} else {
		document.getElementById(id).checked = true;
	}
}


function EscondeAbas(id, acao){
	var tb = new Array();
	var ancora = new Array();
	tb[0] = 'DADOS DO SOLICITANTE';
	tb[1] = 'HISTÓRICO PROFISSIONAL E EMPRESARIAL';
	tb[2] = 'INFORMAÇÕES FINANCEIRAS E ADICIONAIS';
	for(i = 0; i < tb.length; i++){
		ancora[i] = 'ancor' + (i + 1);
	}
	var i = 0;
	var sn= '- ';
	
	document.getElementById('dt'+id).style.display= 'block';
	
	if(acao == 0){
		i = 1;
		sn= '+ ';
		document.getElementById('dt'+id).style.display= 'none';
	}	
	var lk = '';
	lk =  '&nbsp;'+sn+'<a href="#'+ancora[id-1]+'" ';
	lk += 'onclick="EscondeAbas('+id+','+i+');"> '+tb[id-1]+'</a>';
	
	document.getElementById('tt'+id).innerHTML = lk;
}

function EscondeAbasInterna(id, acao){
	var tb = new Array();
	var ancora = new Array();
	tb[0] = 'DADOS PESSOAIS';
	tb[1] = 'DADOS PESSOAIS DO CÔNJUGE SE HOUVER';
	tb[2] = 'ENDEREÇO ATUAL DO SOLICITANTE';
	tb[3] = 'ENDEREÇO ANTERIOR DO SOLICITANTE';
	tb[4] = 'LAZER';
	tb[5] = 'EXPERIÊNCIA COM FRANQUIAS';
	tb[6] = 'HISTÓRICO PROFISSIONAL';
	tb[7] = 'SOBRE A FRANQUIA CARTÓRIO POSTAL';
	tb[8] = 'INFORMAÇÕES FINANCEIRAS';
	tb[9] = 'REFERENCIAS BANCÁRIAS';
	tb[10] = 'DEMONSTRATIVO DE RENDIMENTO';
	tb[11] = 'BENS DE CONSUMO';
	for(i = 0; i < tb.length; i++){
		ancora[i] = 'ancor1' + (i + 1);
	}
	
	var i = 0;
	var sn= '- ';
	document.getElementById('dt2'+id).style.display= 'block';
	
	if(acao == 0){
		i = 1;
		sn= '+ ';
		document.getElementById('dt2'+id).style.display= 'none';
	}	
	var lk = '';
	lk =  '&nbsp;'+sn+'<a href="#'+ancora[id-1]+'" ';
	lk += 'onclick="EscondeAbasInterna('+id+','+i+');"> '+tb[id-1]+'</a>';
	document.getElementById('tt2'+id).innerHTML = lk;
}



















function CheckAll(bt){
	if(document.getElementById('checkbox_image').value == 0){
		document.getElementById('checkbox_buttom').src  = '../images/estrutura/botoes/check2.png';
		document.getElementById('checkbox_image').value = 1;
		acao = 1;
	} else {
		document.getElementById('checkbox_buttom').src  = '../images/estrutura/botoes/check1.png';
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