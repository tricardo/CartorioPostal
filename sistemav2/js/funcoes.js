$(document).ready(function() {   
    aplicarClass();    
});

function aplicarClass(){
    
    $('.cpf').attr('onkeyup','onkeyfield(this.id,1)');
    $('.fone').attr('onkeyup','onkeyfield(this.id,2)'); 
    if($('.cep').attr('onkeyup')){
        attribs = $('.cep').attr('onkeyup');
        $('.cep').removeAttr('onkeyup');
        $('.cep').attr('onkeyup',attribs+';'+'onkeyfield(this.id,3)'); 
    } else {
        $('.cep').attr('onkeyup','onkeyfield(this.id,3)'); 
    }
    $('.data').attr('onkeyup','onkeyfield(this.id,4)'); 
    if($('.numero').attr('onkeyup')){
        attribs = $('.numero').attr('onkeyup');
        $('.numero').removeAttr('onkeyup');
        $('.numero').attr('onkeyup','onkeyfield(this.id,5);'+attribs); 
    } else {
        $('.numero').attr('onkeyup','onkeyfield(this.id,5)'); 
    }    
    $('.hora').attr('onkeyup','onkeyfield(this.id,7);');
    $('.ordem').attr('onkeyup','onkeyfield(this.id,8)');
    $('.money').maskMoney({
        allowZero:false,
        allowNegative:true,
        decimal:".", 
        thousands:""
    });
    $('.money').attr('maxlength',10);
    $('.email').css('text-transform','lowercase');
    if($('.cp').length > 0){
        EmailCartorio(0,'')
    }

    if($('.chzn-select').length > 0){
        $(".chzn-select").chosen({no_results_text: "Não foi encontrado"});
    }

    if($('.check1').length > 0 || $('.check2').length > 0){
        MarcaOnClickCheck();
    }

}

Shadowbox.init({
    language: 'pt',
    continuous: true,
    counterType: "skip",
    gallery: "mustang",
    handleOversize: "drag",
    player: ['img', 'html', 'swf']
});


function MarcaOnClickCheck(){
    cont = 0;
    for(i = 1; i <= 10; i++){ if($('.check'+i).length > 0){ cont++; } }
    for(i = 1; i <= cont; i++){
        if($('.check'+i).length > 0){
            for(j = 0; j < $('.check'+i).length; j++){
                uid  = $('.check'+i).eq(j).attr('id');
                if(cont == 1){
                    $('.check'+i).parent().parent().eq(j).css({'cursor':'context-menu'});
                    if($('#NoStatusCheck').length == 0){
                        $('.check'+i).parent().parent().eq(j).attr('onclick',"StatusCheck('"+uid+"')");
                    }
                } else if(cont > 1){
                    $('.check'+i).parent().eq(j).css({'cursor':'context-menu'});
                    if($('#NoStatusCheck').length == 0){
                        $('.check'+i).parent().eq(j).attr('onclick',"StatusCheck('"+uid+"')");
                    }
                }  
            }
        }
    }
}

function StatusCheck(id){
    if($('#'+id).attr('checked')){
        $('#'+id).removeAttr('checked');
    } else {
        $('#'+id).attr('checked',true);
        $('#'+id).prop("checked",true);
    }
}

function EmailCartorio(acao, id){
    switch(acao){
        case 1:
            valor = $('#'+id).val().replace('@cartoriopostal.com.br','');
            valor += (valor.length > 0) ? '@cartoriopostal.com.br' : '';
            $('#'+id).val(valor);
            break;
        default:
            for(i = 0; i < $('.cp').length; i++){
                $('.cp').eq(i).attr('onkeyup', 'EmailCartorio(1,this.id)');
            }
    }
}


function onkeyfield(bt, sel){
    acao = '';
    max  = 0;
    switch(sel){
        case 1:
            acao = 'cnpj'; 
            max = 17; 
            break;            
        case 2:
            acao = 'telefone'; 
            max = 15;
            break;            
        case 3:
            acao = 'cep'; 
            max = 9; 
            break;
        case 4:
            acao = 'data';
            max = 10;
            break;
        case 5:
            acao = 'numero';
            valor = $('#'+bt).val().replace(/[^0-9]+/g, '');
            $('#'+bt).val(valor);
            if(!$('#'+bt).attr('maxlength')){
                $('#'+bt).attr('maxlength',6);
            }
            break;
        case 6:
            $('#'+bt).attr('maxlength',13);
            $('#'+bt).maskMoney({showSymbol:true, decimal:".", thousands:""});
            break;
        case 7:
            acao = 'hora'; 
            max = 5; 
            break;
        case 8:
            acao = 'ordem';
            max  = 8;
            break;
    }
    
    switch(acao){
            case 'cnpj': case 'cep': case 'telefone': case 'data': 
            case 'hora': case 'ordem':
                bt = '#'+bt;
                $(bt).maxLength = max;
                digito = /^\d$/;
                str = $(bt).val();                                
                str = limpar(str, '/', '');
                str = limpar(str, '|', '');
                str = limpar(str, '(', '');
                str = limpar(str, ')', '');
                str = limpar(str, '-', '');
                str = limpar(str, ' ', '');
                str = limpar(str, '_', '');
                str = limpar(str, '.', '');
                str2 = '';
                for(i = 0; i <= str.length; i++){
                    str2 += digito.test(str.charAt(i)) ? str.charAt(i) : '';
                }
                if(str2.length >= 0){
                    m    = '';
                    str3 = '';
                    switch(acao){
                        case 'cnpj':
                            m = (str.length <= 11) ? '###.###.###-##' : '##.###.###/####-##';
                            break;
                        case 'telefone':
                            m = (str.length <= 10) ? '(##) ####-####' : '(##) #####-####';
                            break;
                        case 'cep':
                            m = '#####-###';
                            break;
                        case 'data':
                            m = '##/##/####';
                            break;
                        case 'hora':
                            m = '##:##';
                            break;
                        case 'ordem':
                            m = '######/#';
                            break;
                    }
                    for (i = 0 , j = 0; j < str2.length && i < m.length; i ++ ) {
                        if(m.charAt(i) == "#"){
                            str3 += str2.charAt(j)
                            j++
                        } else {
                            str3 += m.charAt(i)
                        }
                    }
                    $(bt).val(str3);
                }
                break;
        }
}

function limpar(str, token, newtoken) {
    while (str.indexOf(token) != -1) {
        str = str.replace(token, newtoken);
    }
    return str;
}

function SendAjax(pagina, dados, div){
    $.ajax({
        type: "post",
        url: pagina,
        data: dados,
        cache: false,
        success: function(resposta){
            $(div).html(resposta);
        },
        error: function(erro){
            $(div).html(erro);
        }
    });
}

function menu(acao, id){
    bt = '#bt-0';
    switch(acao){
        case 1:
        case 2:    
            for(i = 1; i <= 8; i++){
                m = bt +''+i;
                if($(m)){
                    if(!$(m).attr('class') || $(m).attr('class') != 'active'){
                        $(m).removeAttr('class');
                        if(('#' + id) == m && acao == 1){
                            $(m).addClass('view');
                        }
                    }
                }
            }
            break;
            
        case 3:
            $('.items').hide();
            for(i = 1; i <= 8; i++){
                m = bt +''+i;
                if($(m)){ $(m).removeAttr('class'); }
            }
            $('#' + id).addClass('active');
            if($('#sub-' + id)){ $('#sub-' + id).show(); }
            break;
    }
}

function SelectResizeReq(){   
    if($('.content-forms form .chzn-select').length > 0){
        for(i = 0; i < $('.content-forms form .chzn-select').length; i++){
            if($('#'+$('.content-forms form .chzn-select').eq(i).attr('id')).attr('class').indexOf('line1') == -1){
                ChzSelects($('.content-forms form .chzn-select').eq(i).attr('id')+'_chosen',0);
            } else {
                ChzSelects($('.content-forms form .chzn-select').eq(i).attr('id')+'_chosen',1);
            }
        }
    }
}

function ChzSelects(id, acao){  
    if($('#'+id).length == 0){
        setTimeout("ChzSelects('"+id+"',"+acao+");", 100);
    } else {
        switch(acao){
            case 1:
                if($('#'+(id.replace('_chosen',''))).attr('class').indexOf('required') == -1){
                    $('#'+id).css({'width':'580px'});
                    $('#'+id+' a.chosen-single').css({'width':'542px'});
                    $('#'+id+' div.chosen-drop').css({'width':'558px'});
                } else {
                    $('#'+id).css({'border-left':'solid 4px #CC0000','-webkit-border-radius':'5px','-moz-border-radius':'5px','border-radius':'5px'});
                    $('#'+id).css({'width':'580px'});
                    $('#'+id+' a.chosen-single').css({'width':'538px'});
                    $('#'+id+' div.chosen-drop').css({'width':'555px'});                   
                }
                break;
                
            default:
                if($('#'+(id.replace('_chosen',''))).attr('class').indexOf('required') != -1){
                    $('#'+id).css({'border-left':'solid 4px #CC0000','-webkit-border-radius':'5px','-moz-border-radius':'5px','border-radius':'5px'});
                } else {
                    $('#'+id).css({'width':'170px'});
                    $('#'+id+' a.chosen-single').css({'width':'173px'});
                    $('#'+id+' div.chosen-drop').css({'width':'189px'}); 
                }
        }            
    }
}

function preencheCampo(){
    cont = 0;
    for(i = 0; i < $('form').length; i++){
        $.each($('form')[i].elements, function(index, elemento){
            nc = 0;
            nc = ($('#'+elemento.id).attr('type') == 'checkbox') ? nc + 1 : nc;
            cont = cont + nc;

            if(nc == 0){
                valor = ($('dt').eq(index-cont).length > 0) ? $('dt').eq(index-cont).html() : '';
                //alert(valor.length);
                if(valor.length){
                    if($('#'+elemento.id).attr('required')){
                        $('#'+elemento.id).attr('autofocus',true);
                        if($('#'+elemento.id).attr('class')){
                            $('#'+elemento.id).attr('class',$('#'+elemento.id).attr('class')+' required');
                        } else {
                            $('#'+elemento.id).attr('class','required');
                        }
                        if($('#'+elemento.id).attr('placeholder')){
                            //$('dt').eq(index-cont).html(elemento.placeholder+' <span style="color:#CC0000; font-size: 16px;">*</span>:');
                            $('#'+elemento.id).attr('title',elemento.placeholder);
                            $('#'+elemento.id).attr('alt',elemento.placeholder);
                            //$('dt').eq(index).attr('title',elemento.placeholder);
                            //$('dt').eq(index).attr('alt',elemento.placeholder);
                        } else {
                            if($('dt').eq(index-cont).html().length == 0){
                                //$('dt').eq(index-cont).html('&nbsp;');
                            }
                        }
                    } else {
                        if($('#'+elemento.id).attr('placeholder')){
                            //$('dt').eq(index-cont).html(elemento.placeholder+':');
                            $('#'+elemento.id).attr('title',elemento.placeholder);
                            $('#'+elemento.id).attr('alt',elemento.placeholder);
                            //$('dt').eq(index-cont).attr('alt',elemento.placeholder);
                            //$('dt').eq(index-cont).attr('title',elemento.placeholder);
                        } else {
                            if($('#'+elemento.id).length > 0){
                                if(document.getElementById(elemento.id).tagName == 'SELECT'){
                                    $('#'+elemento.id).attr('title',$('#' + elemento.id + ' option:eq(0)').text());
                                    $('#'+elemento.id).attr('alt',$('#' + elemento.id + ' option:eq(0)').text());
                                } else {
                                    if($('dt').eq(index-cont).html().length == 0){
                                        //$('dt').eq(index-cont).html('&nbsp;');
                                    }
                                }
                            }
                        }
                    }
                }
            }
        });
    }
    SelectResizeReq();
}

function BoxMsg(enviado, erros, campos, mensagem){
    $('.msgbox').hide();
    if(enviado == 1){        
        if(erros > 0){
            campos    = campos.split(';');
            mensagem  = mensagem.split(';');
            texto     = '<ul><li><strong>ocorreram os seguintes erros:</strong></li>';
            for(i = 0; i < campos.length; i++){
                if($('#'+campos[i]).length > 0){
                    texto += '<li>&bull; '+mensagem[i]+'</li>';

                    posicao = $('#'+campos[i]).offset();
                    $('<div>')
                        .attr('id','dv_'+campos[i]).attr('name','dv_'+campos[i]).attr('class','msgbox-error')
                        .css({'top':(posicao.top+38),'left':(posicao.left+30)})
                        .html(($('#'+campos[i]).attr('placeholder')) ? '<img src="images/back-alert.png">'+$('#'+campos[i]).attr('placeholder')+'<br><span>'+mensagem[i] +'</span>' : '<img src="images/back-alert.png">'+mensagem[i])
                        .appendTo('body');
                    setTimeout("$('.msgbox-error').hide();", 10000);
                    $('#'+campos[i]).attr('onkeyup', "$('#dv_"+campos[i]+"').hide()");
                }
            }
            texto    += '</ul>'; 
            $('.msgbox .text').html(texto);
            $('.msgbox').show();
            setTimeout("$('.msgbox').hide();", 5000);
        }  else if(erros == 0){
            $('.msgbox .text').html('<h3>'+mensagem+'</h3>');
            $('.msgbox').show();
            setTimeout("$('.msgbox').hide();", 5000);
        }
    }
}

function Validar(acao){
    $('.msgbox-error').hide();
}

function PaginacaoWidth(){
    $('.paginacao').css({'width':$('table').width() - 23});
    $('.adicionar').css({'width':$('table').width() - 23});
}

function opcoesForm(valor){
    $('form').hide();
    $('form').eq(valor-1).show();
}

function CheckAll(bt){
    if($('.'+bt).attr('disabled')){
        if($('.'+bt).attr('disabled').length == 0){
            if($('#'+bt).val() == 1){
                $('#'+bt).val(0);
                $('.'+bt).prop("checked",true);
            } else {
                $('#'+bt).val(1);
                $('.'+bt).prop("checked",false);
            }
        }
    } else {
        if($('#'+bt).val() == 1){
            $('#'+bt).val(0);
            $('.'+bt).prop("checked",true);
        } else {
            $('#'+bt).val(1);
            $('.'+bt).prop("checked",false);
        }
    }
}

function AddButtonPageEdit(){
    if($('.content-forms').length > 0){
        if($('.content-forms .opcoes').length > 0){
            if($('.content-forms .adicionar').length > 0){
                $('.content-forms .adicionar').attr('style','margin-top:32px');
            }
        }
    }
    tableFormResize();
}

function tableFormResize(){
    for(i = 0; i < $('.box .table1').length;i++){
        h = $('.box .table1').eq(i).css('height');
        h = h.replace('px','');
        if(h < 200){
            $('.box .table1').eq(i).css({'width':'740px'});
        }
    }
}

function BuscaCep(obj, acao, compl){
    switch(acao){
        case 1:      
            if($('#'+obj).val().length == 9){
                if($('#dv_message_alert'+compl).length){
                    $('#dv_message_alert'+compl).html('<img src="images/back-alert.png"><span>Por Favor, Aguarde enquanto Localizo o CEP informado.</span>');
                    $('#dv_message_alert'+compl).show();
                } else {
                    posicao = $('#'+obj).offset();
                    $('<div>')
                        .attr('id','dv_message_alert'+compl).attr('name','dv_message_alert'+compl)
                        .attr('class','msgbox-alert')
                        .css({'top':(posicao.top+38),'left':(posicao.left+30)})
                        .html('<img src="images/back-alert.png"><span>Por Favor, Aguarde enquanto Localizo o CEP informado.</span>')
                        .appendTo('body');
                }
                setTimeout("$('#dv_message_alert"+compl+"').hide();", 5000);
            } else {
                if($('#dv_message_alert'+compl)){
                   $('#dv_message_alert'+compl).hide();
                }
            }
            dados = 'cep='+$('#'+obj).val()+'&complemento='+compl+'&obj='+obj;
            SendAjax('consulta-cep.php', dados, '.ajax');
            break;
    }    
}

function carregar_cartorio_cidade(atribuicao, estado, cidade, cid_valor){
    if(estado != ''){  
        dados = 'estado='+estado+'&cidade='+cidade;
        dados+= $('#'+atribuicao).length > 0 ? '&atribuicao='+$('#'+atribuicao).val() : '';
        if($('#'+cid_valor).length > 0 && $('#'+cid_valor).val().length > 0){        
            dados += '&cid_valor='+$('#'+cid_valor).val();
            $('#'+cid_valor).remove();
        } else {
            if($('#'+ cidade +' option:selected')){
                dados+= ($('#'+ cidade +' option:selected').val().length > 0) ? '&cid_valor='+$('#'+ cidade +' option:selected').val() : '&cid_valor=';
            }
        }
        $('option',  $('#'+cidade)).remove().removeAttr();
        SendAjax('consulta-cartorio-cidade.php', dados, '#'+cidade);
    }
}

function CkechSession(tipo, obj, sessao){
    switch(tipo){
        case 3:
            dados = 'sessao=zera_sessao&acao=0';
            SendAjax('includes/criar-sessao.php', dados, '.ajax');
            break;
        
        
        case 1:
            //$('.ajax').show();
            dados = 'acao='+$("input[id='"+obj+"']:checked").length;
            dados+= '&id='+$("#"+obj).val();
            dados+= '&sessao='+sessao;
            dados+= '&js=uniq';
            SendAjax('includes/criar-sessao.php', dados, '.ajax');
            break;
            
        case 2:
            for(i = 0; i < $(obj).length; i++){
                ob = $(obj).eq(i);
                dados = 'acao='+$("input[id='"+ob.attr('id')+"']:checked").length;
                dados+= '&id='+ob.val();
                dados+= '&sessao='+sessao;
                dados+= '&js=multi';
                SendAjax('includes/criar-sessao.php', dados, '.ajax');
            }
            break;
    }
    
    
}

function carrega_calendario(mes,ano){
    $('#calendario_evento').html('');
    SendAjax('expansao-agenda-calendario.php', 'mes='+mes+'&ano='+ano, '#calendario');
}

function carrega_evento(data){
    $('#calendario_evento').html('');
    SendAjax('expansao-agenda-evento.php', 'data='+data, '#calendario_evento');
}


function VerificaStatus(valor){
    a = 0;
    switch(valor){
        case '2': case '3': case '16': case '17': 
            a = 1; break;
        case '5': case '10': case '12': case '19': 
            a = 2; break;
    }
    
    switch(a){
        case 1:
            $('#h_obs').html('Observações <span>*</span>:');
            $('#h_reuniao').html('Data da Reunião:');
            $('#observacao_expansao').attr('required','required');
            $('#observacao_expansao').attr('class','required');
            $('#data_reuniao').removeAttr('class');
            $('#data_reuniao').removeAttr('required');
            $('#data_reuniao').removeAttr('onkeyup');
            break;
            
        case 2:
            $('#h_obs').html('Observações:');
            $('#h_reuniao').html('Data da Reunião <span>*</span>:');
            $('#observacao_expansao').removeAttr('class');
            $('#observacao_expansao').removeAttr('required');
            $('#data_reuniao').attr('required','required');
            $('#data_reuniao').attr('class','required data');
            $('#data_reuniao').attr('onkeyup','onkeyfield(this.id,4)');
            break;

        default:
            $('#h_obs').html('Observações:');
            $('#h_reuniao').html('Data da Reunião:');
            $('#observacao_expansao').removeAttr('class');
            $('#observacao_expansao').removeAttr('required');
            $('#data_reuniao').removeAttr('class');
            $('#data_reuniao').removeAttr('required');
            $('#data_reuniao').removeAttr('onkeyup');
    }
}

function DesembolsoPedido(financeiro,item,pedido, servico, acao){
    $('#dv_desembolso_pedido').remove();
    $('<div>').attr('id','dv_desembolso_pedido')
             .attr('name','dv_desembolso_pedido')
             .attr('class','show-box')
             .attr('style','width:100%;height:'+window.innerHeight)
             .appendTo('body');
    $('#dv_desembolso_pedido').html('<div id="dv_desembolso_pedido_box" class="show-box-div"></div>');
    
                
    data = 'pedido='+pedido;
    data+= '&servico='+servico;
    data+= '&financeiro='+financeiro;
    data+= '&item='+item;
    data+= (acao == 1 ) ? '&acao=view' : '&acao=form';
    SendAjax('desembolso-ajax.php', 'data='+data, '#dv_desembolso_pedido_box');
}

function DesembolsoConferido(){
   if($('#financeiro_troco').val()==''){ 
       $('#financeiro_troco').val(0);
   }
   if($('#financeiro_desembolsado').val()==''){
       $('#financeiro_desembolsado').val(0);
   }
   if($('#financeiro_valor').val()>0){ 
        valor = parseFloat($('#financeiro_desembolsado').val());
        valor = valor - parseFloat($('#financeiro_troco').val());
        valor = valor - parseFloat($('#financeiro_rateio').val());
        valor = valor - parseFloat($('#financeiro_sedex').val());
        valor = parseFloat(valor).toFixed(2);
        $('#financeiro_valor').val(valor);
    } else { 
        valor = parseFloat($('#financeiro_desembolsado').val());
        valor = valor - parseFloat($('#financeiro_troco').val());
        valor = valor - parseFloat($('#financeiro_sedex').val());
        valor = parseFloat(valor).toFixed(2);
        $('#financeiro_rateio').val(valor);
    }
}

function AcaoDesembolso(acao, f){
    $('#acao_desembolso').val(acao);
    if($('#NoStatusCheck').length > 0){
        $('#'+f).submit();
    }
}

function ShowBox(msg){   
    $('.msgbox').remove();
    texto = '<div class="panel"><a href="#" onclick="$(\'.msgbox\').hide()">fechar X</a></div>'
    texto += '<div class="text">'+msg+'</div>';
    texto += '<script>setTimeout("$(\'.msgbox\').hide();", 10000);</script>';
    
    $('<div>').attr('class','msgbox')
             .appendTo('body');
    $('.msgbox').html(texto);
}

function DesembolsoConfirm(g,acao){
    switch(acao){   
        case 'efetuado':
            if(g == 1){
                $('.ajax').html();
                SendAjax('includes/criar-sessao.php', 'listar_sessao=1&sessao=desembolso', '.ajax');
            }
            if($('#show_box_ret_msg').val()){
                if($('#show_box_ret_msg').val() == '0'){
                    ShowBox('Erro!<br><br>Você deve selecionar pelo menos um Pedido para a atividade Efetuado!\n');
                } else {
                    pedido = new Array();
                    arr = $('#show_box_ret_msg').val().split(',');
                    for(i = 0; i < arr.length; i++){
                        item = arr[i].split(';');
                        pedido[i] = '#'+item[2]+'/'+item[3];
                    }
                    pedido = pedido.join(', ');
                    if(confirm('Você tem certeza que deseja efetuar o depósito para as ordens abaixo?\n'+pedido)){
                        AcaoDesembolso(acao,'form1');
                    } else {
                        return false;
                    }
                }
            } else {
                setTimeout("DesembolsoConfirm(0,'efetuado');", 1);
            }
            break;
            
        case 'alterar_conta':
            if(g == 1){
                $('.ajax').html();
                SendAjax('includes/criar-sessao.php', 'listar_sessao=1&sessao=desembolso', '.ajax');
            }
            if($('#show_box_ret_msg').val()){
                if($('#show_box_ret_msg').val() == '0'){
                    ShowBox('Erro!<br><br>Você deve selecionar pelo menos um Pedido para Alterar a Conta!');
                } else {
                    $('#dv_desembolso_pedido').remove();
                    $('<div>').attr('id','dv_desembolso_pedido')
                             .attr('name','dv_desembolso_pedido')
                             .attr('class','show-box')
                             .attr('style','width:100%;height:'+window.innerHeight)
                             .appendTo('body');
                    $('#dv_desembolso_pedido').html('<div id="dv_desembolso_pedido_box" class="show-box-div"></div>');
                    SendAjax('desembolso-ajax.php', 'acao=conta', '#dv_desembolso_pedido_box');
                }
            } else {
                setTimeout("DesembolsoConfirm(0,'alterar_conta');", 1);
            }            
            break;
            
        case 'arquivo':
            $('#form1').attr('target','_blank').attr('action','desembolso-listar-arquivo.php'); 
            $('#form1').submit();
            $('#form1').removeAttr('target');
            $('#form1').removeAttr('action');
            break;
    }
    
}

function RecNovoBoleto(id){
    $('#dv_desembolso_pedido').remove();
    $('<div>').attr('id','dv_rec_pedido')
             .attr('name','dv_rec_pedido')
             .attr('class','show-box')
             .attr('style','width:100%;height:'+window.innerHeight)
             .appendTo('body');
    $('#dv_rec_pedido').html('<div id="dv_rec_pedido_box" class="show-box-div"></div>');
    SendAjax('recebimentos-de-pedidos-ajax.php', 'acao=boleto&id='+id, '#dv_rec_pedido_box');
}

function RecPedidoConfirm(g,acao){
    switch(acao){            
        case 'status':
            if($('#show_box_ret_msg').val()){
                if($('#show_box_ret_msg').val() == '0'){
                    ShowBox('Erro!<br><br>Você deve selecionar pelo menos um Pedido para Alterar o Status!');
                } else {
                    $('#dv_desembolso_pedido').remove();
                    $('<div>').attr('id','dv_rec_pedido')
                             .attr('name','dv_rec_pedido')
                             .attr('class','show-box')
                             .attr('style','width:100%;height:'+window.innerHeight)
                             .appendTo('body');
                    $('#dv_rec_pedido').html('<div id="dv_rec_pedido_box" class="show-box-div"></div>');
                    SendAjax('recebimentos-de-pedidos-ajax.php', 'acao=status', '#dv_rec_pedido_box');
                }
            } else {
                setTimeout("RecPedidoConfirm(0,'status');", 1);
            } 
            break;
        
        case 'aprovar':
            alert('Esta ação ainda não esta pronta!');
            break;
            
        case 'reprovar':
            alert('Esta ação ainda não esta pronta!');
            break;
            
        case 'faturar':
            if(g == 1){
                $('.ajax').html();
                SendAjax('includes/criar-sessao.php', 'listar_sessao=1&sessao=rec_pedido', '.ajax');
            }
            if($('#show_box_ret_msg').val()){
                if($('#show_box_ret_msg').val() == '0'){
                    ShowBox('Erro!<br><br>Você deve selecionar pelo menos um Pedido para Faturar!');
                } else {
                    $('#dv_desembolso_pedido').remove();
                    $('<div>').attr('id','dv_rec_pedido')
                             .attr('name','dv_rec_pedido')
                             .attr('class','show-box')
                             .attr('style','width:100%;height:'+window.innerHeight)
                             .appendTo('body');
                    $('#dv_rec_pedido').html('<div id="dv_rec_pedido_box" class="show-box-div"></div>');
                    SendAjax('recebimentos-de-pedidos-ajax.php', 'acao=faturar', '#dv_rec_pedido_box');
                }
            } else {
                setTimeout("RecPedidoConfirm(0,'faturar');", 1);
            } 
            break;
        
        
        case 'arquivo_todos':
            $('#form1').attr('target','_blank').attr('action','recebimentos-de-pedidos-arquivo-todos.php'); 
            $('#form1').submit();
            $('#form1').removeAttr('target');
            $('#form1').removeAttr('action');
            break;
            
        case 'arquivo':
            if(g == 1){
                $('.ajax').html();
                SendAjax('includes/criar-sessao.php', 'listar_sessao=1&sessao=rec_pedido', '.ajax');
            }
            if($('#show_box_ret_msg').val()){
                if($('#show_box_ret_msg').val() == '0'){
                    ShowBox('Erro!<br><br>Você deve selecionar pelo menos um Pedido para Exportar!');
                } else {
                    $('#form1').attr('target','_blank').attr('action','recebimentos-de-pedidos-arquivo.php'); 
                    $('#form1').submit();
                    $('#form1').removeAttr('target');
                    $('#form1').removeAttr('action');
                }
            } else {
                setTimeout("RecPedidoConfirm(0,'arquivo');", 1);
            }  
            break;
    }
}

function CarregaServico(id_depto, id_serv){
    SendAjax('servicos-listar-carrega-servico.php', 'id_depto='+id_depto+'&id_serv='+id_serv, '#ajax_busca_id_servico');
}

function ServicoEdit(id_serv){
    data = 'valor='+$('#valor'+id_serv).val();
    data += '&dias='+$('#dias'+id_serv).val();
    data += '&id_serv='+id_serv;
    SendAjax('servicos-editar.php', data, '.ajax');
}


function LocationTargetAcao(a, f, p, o){
    $(o).val(a);
    $('#'+f).removeAttr('action');
    $('#'+f).attr('action',p);
    $('#'+f).attr('target','_blank');
    $('#'+f).submit();
        
    $('#'+f).removeAttr('action');
    $('#'+f).removeAttr('target');
    if($('#NoStatusCheck').length > 0){
        $('#'+f).attr('action',$('#NoStatusCheck').val());
    }
    
}

function DirecionamentoConfirm(g,acao){
    switch(acao){   
        case 'colaborador': case 'colaborador_site':
        case 'unidade': case 'unidade_site':
            if(g == 1){
                $('.ajax').html();
                s = 'direcionamento_site';
                if(acao == 'unidade' || acao == 'colaborador'){
                    s = 'direcionamento';
                }
                SendAjax('includes/criar-sessao.php', 'listar_sessao=1&sessao='+s, '.ajax');
            }
            if($('#show_box_ret_msg').val()){
                if($('#show_box_ret_msg').val() == '0'){
                    texto = (acao == 'unidade') ? 'uma Unidade' : 'um Colaborador';
                    ShowBox('Erro!<br><br>Você deve selecionar pelo menos um Pedido para Direcionar para '+texto);
                } else {
                    if(acao == 'unidade' || acao == 'colaborador'){
                        campo  = (acao == 'unidade') ? '#id_empresa_resp' : '#id_usuario';
                        texto = (acao == 'unidade') ? 'uma Unidade' : 'um Colaborador';
                    } else {
                        campo  = (acao == 'unidade_site') ? '#id_usuario_franquia' : '#id_usuario';
                        texto = (acao == 'unidade_site') ? 'uma Unidade' : 'um Colaborador';
                    }
                    if($(campo).val() == '' || $(campo).val() == 0){
                        ShowBox('Erro!<br><br>Você deve selecionar '+texto+' para Direcionar!');
                    } else {
                        $('#acao_direcionamento').val(acao);
                        if($('#NoStatusCheck').length > 0){
                            $('#form1').submit();
                        }
                    }
                }
            } else {
                setTimeout("DirecionamentoConfirm(0,'"+acao+"');", 1);
            }
            break;
            
        case 'alterar_status':
            if(g == 1){
                $('.ajax').html();
                SendAjax('includes/criar-sessao.php', 'listar_sessao=1&sessao=direcionamento', '.ajax');
            }
            if($('#show_box_ret_msg').val()){
                if($('#show_box_ret_msg').val() == '0'){
                    ShowBox('Erro!<br><br>Você deve selecionar pelo menos um Pedido para Alterar o Status!');
                } else {
                    $('#dv_direcionamento_pedido').remove();
                    $('<div>').attr('id','dv_direcionamento_pedido')
                             .attr('name','dv_direcionamento_pedido')
                             .attr('class','show-box')
                             .attr('style','width:100%;height:'+window.innerHeight)
                             .appendTo('body');
                    $('#dv_direcionamento_pedido').html('<div id="dv_direcionamento_pedido_box" class="show-box-div"></div>');
                    SendAjax('direcionamento-listar-ajax.php', 'acao=status', '#dv_direcionamento_pedido_box');
                }
            } else {
                setTimeout("DirecionamentoConfirm(0,'alterar_status');", 1);
            }            
            break;
            
        case 'duplicidade':
            if(g == 1){
                $('.ajax').html();
                SendAjax('includes/criar-sessao.php', 'listar_sessao=1&sessao=direcionamento_site', '.ajax');
            }
            if($('#show_box_ret_msg').val()){
                if($('#show_box_ret_msg').val() == '0'){
                    ShowBox('Erro!<br><br>Você deve selecionar pelo menos um Pedido para Aplicar a Duplicidade!');
                } else {
                   $('#acao_direcionamento').val(acao);
                    if($('#NoStatusCheck').length > 0){
                        $('#form1').submit();
                    }
                }
            } else {
                setTimeout("DirecionamentoConfirm(0,'duplicidade');", 1);
            }  
            break;
    }
    
}

function RetData(cp,acao){
    switch(cp){
        case 'status_dias':
            $('#status_dias').attr('maxlength',3);
            if($('#status_dias').val().length > 0){
                valor = $('#status_dias').val() > 180 ? 180 : $('#status_dias').val();
                if($('#status_dias').val() > 180){
                    $('#status_dias').val(180);
                    ShowBox('Erro!<br><br>Você deve preencher um valor de 1 a 180 no campo Dias!');
                }
                SendAjax('conta-dias-uteis.php', 'dias='+valor, '.ajax');
            } else {
                $('#data_posdias').val('');
            }
            break;
    }
}

function CobrancaConfirm(g,acao){
    switch(acao){   
        case 'colaborador': 
            if(g == 1){
                $('.ajax').html();
                SendAjax('includes/criar-sessao.php', 'listar_sessao=1&sessao=cobranca', '.ajax');
            }
            if($('#show_box_ret_msg').val()){
                if($('#show_box_ret_msg').val() == '0'){
                    ShowBox('Erro!<br><br>Você deve selecionar pelo menos um Pedido para Direcionar para um Colaborador!');
                } else {
                    if($('#id_usuario').val() == '' || $('#id_usuario').val() == 0){
                        ShowBox('Erro!<br><br>Você deve selecionar um Colaborador para Direcionar!');
                    } else {
                        $('#acao_direcionamento').val(acao);
                        if($('#NoStatusCheck').length > 0){
                            $('#form1').submit();
                        }
                    }
                }
            } else {
                setTimeout("CobrancaConfirm(0,'"+acao+"');", 1);
            }
            break;
            
        case 'acompanhar': case 'notificar': case 'notificado': case 'apoio_juridico': case 'efetuado':
            switch(acao){ 
                case 'acompanhar': texto = 'Acompanhar!'; break;
                case 'notificar': texto = 'Notificar!'; break;
                case 'notificado': texto = 'Notificado!'; break;
                case 'apoio_juridico': texto = 'Apoio Jurídico'; break;
                case 'efetuado': texto = 'Efetuado'; break;
            }
            
            
            if(g == 1){
                $('.ajax').html();
                SendAjax('includes/criar-sessao.php', 'listar_sessao=1&sessao=cobranca', '.ajax');
            }
            if($('#show_box_ret_msg').val()){
                if($('#show_box_ret_msg').val() == '0'){
                    ShowBox('Erro!<br><br>Você deve selecionar pelo menos um Pedido para '+texto);
                } else {
                    $('#dv_direcionamento_pedido').remove();
                    $('<div>').attr('id','dv_direcionamento_pedido')
                             .attr('name','dv_direcionamento_pedido')
                             .attr('class','show-box')
                             .attr('style','width:100%;height:'+window.innerHeight)
                             .appendTo('body');
                    $('#dv_direcionamento_pedido').html('<div id="dv_direcionamento_pedido_box" class="show-box-div"></div>');
                    SendAjax('cobranca-listar-ajax.php', 'acao='+acao, '#dv_direcionamento_pedido_box');
                }
            } else {
                setTimeout("CobrancaConfirm(0,'"+acao+"');", 1);
            } 
            break;
    }
}

function carrega_fornecedor_contas(id){
    SendAjax('contas-a-pagar-ajax.php', 'acao=1&id='+id, '.ajax');
}

function marca_classificacao(id){
    if($('#'+id).val().length > 0){
        $('#id_planoconta option[value *= ' + $('#'+id).val() + ']:first').attr('selected', true);
    }
}

function ExportarContasPagar(){
    $('#form1').attr('target','_blank').attr('action','contas-a-pagar-listar-arquivo.php'); 
    $('#form1').submit();
    $('#form1').removeAttr('target');
    $('#form1').removeAttr('action');
}

function SendExpBoleto(acao, pagina){
    if(acao == 1){
        $('#form1').attr('target','_blank').attr('action',pagina); 
    } else {
        $('#form1').attr('action',pagina); 
    }
    $('#form1').submit();
    $('#form1').removeAttr('target');
    $('#form1').removeAttr('action');
}

function RecOutrasFranqConfirm(g,acao){
    switch(acao){ 
        case 'devolver':
            if(g == 1){
                $('.ajax').html();
                SendAjax('includes/criar-sessao.php', 'listar_sessao=1&sessao=fi_franquia', '.ajax');
            }
            if($('#show_box_ret_msg').val()){
                if($('#show_box_ret_msg').val() == '0'){
                    ShowBox('Erro!<br><br>Você deve selecionar pelo menos um Pedido para Devolver!');
                } else {
                    $('#acao_direcionamento').val(acao);
                    if($('#NoStatusCheck').length > 0){
                        $('#form1').submit();
                    }                   
                }
            } else {
                setTimeout("RecOutrasFranqConfirm(0,'"+acao+"');", 1);
            }
            break;
            
            
        case 'aprovar':
            if(g == 1){
                $('.ajax').html();
                SendAjax('includes/criar-sessao.php', 'listar_sessao=1&sessao=fi_franquia', '.ajax');
            }
            if($('#show_box_ret_msg').val()){
                if($('#show_box_ret_msg').val() == '0'){
                    ShowBox('Erro!<br><br>Você deve selecionar pelo menos um Pedido para Aprovar!');
                } else {
                    $('#dv_recoutras').remove();
                    $('<div>').attr('id','dv_recoutras')
                             .attr('name','dv_recoutras')
                             .attr('class','show-box')
                             .attr('style','width:100%;height:'+window.innerHeight)
                             .appendTo('body');
                    $('#dv_recoutras').html('<div id="dv_recoutras_box" class="show-box-div"></div>');
                    SendAjax('recebimentos-de-franquias-listar-ajax.php', 'acao='+acao, '#dv_recoutras_box');
                }
            } else {
                setTimeout("RecOutrasFranqConfirm(0,'"+acao+"');", 1);
            } 
            break;
            
        case 'arquivo':
            $('#form1').attr('target','_blank').attr('action','recebimentos-de-franquias-listar-arquivo.php'); 
            $('#form1').submit();
            $('#form1').removeAttr('target');
            $('#form1').removeAttr('action');
            break;
    }

}

function RoyaltiesConfirm(g,acao,obj){
    switch(acao){   
        
        case 'erro':
            ShowBox('Erro!<br><br>Você não tem permissão para acessar essa página!');
            break;
            
        case 'aprovar':
            
            if(g == 1){
                $('.ajax').html();
                SendAjax('includes/criar-sessao.php', 'listar_sessao=1&sessao=royalties', '.ajax');
            }
            if($('#show_box_ret_msg').val()){
                if($('#show_box_ret_msg').val() == '0'){
                    ShowBox('Erro!<br><br>Você deve selecionar pelo menos uma Cobrança para Aprovar!');
                } else {
                    $('#dv_royalties').remove();
                    $('<div>').attr('id','dv_royalties')
                             .attr('name','dv_royalties')
                             .attr('class','show-box')
                             .attr('style','width:100%;height:'+window.innerHeight)
                             .appendTo('body');
                    $('#dv_royalties').html('<div id="dv_royalties_box" class="show-box-div"></div>');
                    SendAjax('royalties-listar-ajax.php', 'acao='+acao, '#dv_royalties_box');
                }
            } else {
                setTimeout("RoyaltiesConfirm(0,'"+acao+"',0);", 1);
            } 
            break;
            
        case 'listar':
            $('#dv_royalties').remove();
            $('<div>').attr('id','dv_royalties')
                     .attr('name','dv_royalties')
                     .attr('class','show-box')
                     .attr('style','width:100%;height:'+window.innerHeight)
                     .appendTo('body');
            $('#dv_royalties').html('<div id="dv_royalties_box" class="show-box-div"></div>');
            data = 'acao='+acao+'&bt_ref='+$('#bt_ref'+obj).val();
            data+= '&bt_emp='+$('#bt_emp'+obj).val();
            SendAjax('royalties-listar-ajax.php', data, '#dv_royalties_box');
            break;
    }
}

function ocorrencia_brad(ocor){
    $('#div_vencimento').hide();
    $('#div_outros_dados').hide();
    $('#form1').show();
    switch(ocor){
        case '6':
            $('#form1').hide();
            $('#div_vencimento').show();
            break;
            
        case '31':
            $('#div_outros_dados').show();
            $('#form1').hide();
            break;
    }
}

function SendBoleto(acao,f){
    $('.acao_boleto').val(acao);
    $('#'+f).attr('action','boletos-editar.php'+$('#'+f).attr('action'));
    $('#'+f).submit();
}


function DivAddRegistro(nav){
    if(nav.length == 0){
        if($('.opcoes').length == 0){
            if($('.content-list-table').length == 0){
                $('.adicionar').attr('style','margin-top:150px');
            }
        }
    }
}