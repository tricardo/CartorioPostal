<?php
require("includes.php");

$permissao = verifica_permissao('Franquia',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' or $controle_id_empresa!='1'){
    header('location:pagina-erro.php');
    exit;
}

$empresaDAO = new EmpresaDAO();
if($_POST){
    
    require("includes/geraexcel/excelwriter.inc.php");
    require("includes/dias_uteis.php");

    pt_register('POST','id_empresa');
    pt_register('POST','crescimento');
    
    $arquivoDiretorio = "exporta/plan-eco-fin-".(md5($controle_id_empresa.$controle_id_usuario.date('YmdHis'))).".xls";
    
    
    $emp = $empresaDAO->selectPorId($id_empresa);
    
    $excel=new ExcelWriter($arquivoDiretorio);

    if($excel==false){
        echo $excel->error;
        exit;
    }
    
    //Escreve o nome dos campos de uma tabela
    $linha_arq = utf8_decode('Relatorio de Planejamento Econômico Financeiro - Franquia ').$emp->fantasia.' - Taxa de Crescimento de '.$crescimento.'%;';
    $myArr = explode(';',$linha_arq);
    $excel->writeLine($myArr);

    $linha_arq = 'ANO I;Operacionais;';
    $myArr = explode(';',$linha_arq);
    $excel->writeLine($myArr);

    #inicio do ano I
    $linha_arq = ';1;2;3;4;5;6;7;8;9;10;11;12';
    $myArr = explode(';',$linha_arq);
    $excel->writeLine($myArr);

    $linha_arq = 'MES';

    $cont=0;
    $linha_dias_uteis	= 'DIAS UTEIS';
    $linha_despesa 	= 'DESPESAS';
    $linha_vendas 	= 'VENDAS';
    $linha_lucro	= 'LUCRO';
    $linha_operacoes 	= utf8_decode('OPERAÇÕES DO MÊS');
    $linha_pedido_medio = utf8_decode('TICKET MÉDIO');
    $linha_pedido_dia 	= utf8_decode('OPERAÇOES POR DIA');
    $linha_enviado	= 'PEDIDOS ENVIADOS PARA REDE';
    $linha_recebido	= 'PEDIDO RECEBIDOS DA REDE';
    $busca_data_i       = '';
    foreach($empresaDAO->planejamento_economico($id_empresa) AS $res){
        $cont++;
	$pedido_medio = (float)($res->valor_pedido)/(float)($res->operacoes);
	$lucro = (float)($res->valor_pedido)-(float)($res->despesa);
	$linha_arq 			.= ";".$res->mes;	
	$linha_despesa 		.= ";".$res->despesa;
	$linha_vendas 		.= ";".$res->valor_pedido;

	$linha_operacoes 	.= ";".$res->operacoes;
	$linha_lucro 		.= ";".$lucro;
	$linha_pedido_medio	.= ";".$pedido_medio;
	$linha_enviado		.= ";".$res->enviado;
	$linha_recebido		.= ";".$res->recebido;
	$dias = dias_uteis('01/'.$res->mes,'31/'.$res->mes);
	$linha_dias_uteis	.= ";".$dias;
	$pedido_dia             = $res->operacoes/$dias;
	$linha_pedido_dia	.= ";".$pedido_dia;
	if($busca_data_i=='')	$busca_data_i = $res->mes;

	$vendas_ano1 		= (float)($vendas_ano1)+(float)($res->valor_pedido);
	$ticket_ano1 		= (float)($ticket_ano1)+(float)($pedido_medio);
	$operacoes_ano1		= (float)($operacoes_ano1)+(float)($res->operacoes);
    }
    
    while($cont<12){
	$data = gmdate('m/Y',strtotime(date("d/m/Y", strtotime('01/'.$busca_data_i)) . " +".$cont." month"));
	$linha_arq .= ";".$data;
	$cont++;
    }

    $myArr = explode(';',$linha_arq);
    $excel->writeLine($myArr);

    $myArr = explode(';',$linha_dias_uteis);
    $excel->writeLine($myArr);

    $myArr = explode(';',$linha_pedido_dia);
    $excel->writeLine($myArr);

    $myArr = explode(';',$linha_despesa);
    $excel->writeLine($myArr);

    $myArr = explode(';',$linha_vendas);
    $excel->writeLine($myArr);

    $myArr = explode(';',$linha_lucro);
    $excel->writeLine($myArr);

    $myArr = explode(';',$linha_operacoes);
    $excel->writeLine($myArr);

    $myArr = explode(';',$linha_pedido_medio);
    $excel->writeLine($myArr);

    $myArr = explode(';',$linha_enviado);
    $excel->writeLine($myArr);

    $myArr = explode(';',$linha_recebido);
    $excel->writeLine($myArr);
    
    #fim do ano I
    #inicio do ano II
    $linha_arq = 'MES';
    $linha_pedido_dia2[] = utf8_decode('OPERAÇÕES POR DIA');
    $linha_dias_uteis2[] = utf8_decode('DIAS ÚTEIS');
    $linha_vendas2[] = 'VENDA';
    $linha_operacoes2[] = utf8_decode('OPERAÇÕES DO MÊS');
    $pedido_medio2[] = utf8_decode('TICKET MÉDIO');
    $calc_pedidomedio = 0;
    $por_dia          = 0;
    $vendas_ano2      = 0;
    $vendas_ano1      = 0;
    $operacoes_ano1   = 0;
    $operacoes_ano2   = 0;
    $vendas_ano1      = 0;
    $ticket_ano1      = 0;
    $ticket_ano2      = 0;
    $linha_arq_mes    = '';
    
    while($cont<24){
	$data = gmdate('m/Y',strtotime(date("d/m/Y", strtotime('01/'.$busca_data_i)) . " +".$cont." month"));
	$linha_arq .= ";".$data;	
	$pedido_medio = explode(';',$linha_pedido_medio);
	$pedido_dia = explode(';',$linha_pedido_dia);

	$cont2 = $cont-11;
        if(isset($pedido_medio[$cont2])){
            $calc_pedidomedio = (float)($pedido_medio[$cont2])+(float)($pedido_medio[$cont2])/100*$crescimento;	
        }
	$pedido_medio2[] = $calc_pedidomedio;
	
	$dias = dias_uteis('01/'.$data,'31/'.$data);
	$linha_dias_uteis2[]	= $dias;
        if(isset($pedido_dia[$cont2])){
            $por_dia = $pedido_dia[$cont2]+$pedido_dia[$cont2]/100*$crescimento;
        }
	$linha_pedido_dia2[]	= $por_dia;
	$linha_operacoes2[]	= $dias*$por_dia;
	$linha_vendas2[]	= $calc_pedidomedio*$dias*$por_dia;

	$vendas_ano2 		= (float)($vendas_ano2)+(float)($calc_pedidomedio*$dias*$por_dia);
	$ticket_ano2 		= (float)($ticket_ano2)+(float)($calc_pedidomedio);	
	$operacoes_ano2		= (float)($operacoes_ano2)+(float)($dias*$por_dia);

	$cont++;
	$linha_arq_mes .= ";".$cont;
	
    }
    
    $myArr = explode(';',';');
    $excel->writeLine($myArr);

    $myArr = explode(';','ANO II'.$linha_arq_mes);
    $excel->writeLine($myArr);

    $myArr = explode(';',$linha_arq);
    $excel->writeLine($myArr);

    $excel->writeLine($linha_dias_uteis2);

    $excel->writeLine($linha_pedido_dia2);

    $excel->writeLine($linha_vendas2);

    $excel->writeLine($linha_operacoes2);

    $excel->writeLine($pedido_medio2);


    #fim do ano II
    #statistica de 5 anos
    $ticket_ano1 = $ticket_ano1/8;
    $ticket_ano2 = $ticket_ano2/8;
    $ticket_ano3 = (float)($ticket_ano2)*(float)(1.03);
    $ticket_ano4 = (float)($ticket_ano3)*(float)(1.03);
    $ticket_ano5 = (float)($ticket_ano4)*(float)(1.03);
    $ticket5anos = utf8_decode('Ticket Médio;'.$ticket_ano1.';'.$ticket_ano2.';'.$ticket_ano3.';'.$ticket_ano4.';'.$ticket_ano5);

    $operacoes_ano1 = $operacoes_ano1/8;
    $operacoes_ano2 = $operacoes_ano2/8;
    $operacoes5anos = utf8_decode('Operações por mês;'.$operacoes_ano1.';'.$operacoes_ano2.';'.$operacoes_ano2.';'.$operacoes_ano2.';'.$operacoes_ano2);

    $mediavendas_ano1 = $vendas_ano1/8;
    $mediavendas_ano2 = $vendas_ano2/8;
    $mediavendas_ano3 = (float)($ticket_ano2)*(float)($operacoes_ano2);
    $mediavendas_ano4 = (float)($ticket_ano3)*(float)($operacoes_ano2);
    $mediavendas_ano5 = (float)($ticket_ano4)*(float)($operacoes_ano2);
    $mediavendas5anos = utf8_decode('Vendas média/mês;'.$mediavendas_ano1.';'.$mediavendas_ano2.';'.$mediavendas_ano3.';'.$mediavendas_ano4.';'.$mediavendas_ano5);

    $vendas_ano3 = (float)($mediavendas_ano3)*8;
    $vendas_ano4 = (float)($mediavendas_ano4)*8;
    $vendas_ano5 = (float)($mediavendas_ano5)*8;

    $vendas5anos = 'Vendas do Ano;'.$vendas_ano1.';'.$vendas_ano2.';'.$vendas_ano3.';'.$vendas_ano4.';'.$vendas_ano5;

    $myArr = explode(';',';');
    $excel->writeLine($myArr);

    $myArr = explode(';',utf8_decode('RECEITAS, MÉDIA DO ANO;ANO I; ANO II; ANO III; ANO IV; ANO V;'));
    $excel->writeLine($myArr);

    $myArr = explode(';',$vendas5anos);
    $excel->writeLine($myArr);

    $myArr = explode(';',$mediavendas5anos);
    $excel->writeLine($myArr);

    $myArr = explode(';',$ticket5anos);
    $excel->writeLine($myArr);

    $myArr = explode(';',$operacoes5anos);
    $excel->writeLine($myArr);
    
    header ("Content-type: octet/stream");
    header ("Content-disposition: attachment; filename=".$arquivoDiretorio.";");
    header("Content-Length: ".filesize($arquivoDiretorio));
    readfile($arquivoDiretorio);
    
} else {

    pt_register('GET','pg');
   
    $pagina = RelTipTit($pg);
    
    include('header2.php'); ?>
    <script>
        menu(3,'bt-05');
        $('#titulo').html('relatórios &rsaquo;&rsaquo; <a href="<?=$pagina['retorno']?>" id="voltar"><?=$pagina['titulo']?></a> &rsaquo;&rsaquo; Planejamento Econômico Financeiro');
        $('#sub-<?=$pagina['sub']?>').css({'font-weight':'bold'});
    </script>
    <div class="content-list-forms">
        <form method="post" target="blank">
            <dl>
                <legend>Relatório Planejamento Econômico Financeiro</legend>
                <dt>Crescimento (%):</dt>
                <dd><input type="text" id="crescimento" name="crescimento" class="numero" value=""></dd>
                <dt>Unidade:</dt>
                <dd>
                    <select name="id_empresa" id="id_empresa" class="chzn-select">
                            <?php 
                            $empresas = $empresaDAO->listarTodasFranquias();
                            $p_valor = '';
                            foreach($empresas as $emp){
                                $p_valor .= '<option value="'.$emp->id_empresa.'">'.str_ireplace('Cartório Postal - ','',  utf8_encode($emp->fantasia)).'</option>';
                            }
                            echo $p_valor; ?>
                    </select>
                </dd>
                <div class="buttons">
                    <input type="hidden" value="1" id="f" name="f">
                    <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
                    <input type="button" value="&lsaquo;&lsaquo; limpar" onclick="location.href=window.location.pathname+'?pg=<?=$pg?>'">
                    <input type="submit" value="buscar &rsaquo;&rsaquo;">
                </div>
            </dl>
        </form>
        <script>preencheCampo()</script>
    </div>
    <div class="content-list-table">
        <?php if($_POST){
            RetornaVazio();
        } else {
            RetornaVazio(2); } ?>
    </div>
    <?php include('footer.php'); 
}?>