<?
require('header.php');
$departamento_s = explode(',', $controle_id_departamento_s);
$departamento_p = explode(',', $controle_id_departamento_p);

$permissao = verifica_permissao('Financeiro', $controle_id_departamento_p, $controle_id_departamento_s);
if ($permissao == 'FALSE') {
    echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
    exit;
}

$contaDAO = new ContaDAO();
$financeiroDAO = new FinanceiroDAO();
$departamentoDAO = new DepartamentoDAO();
$statusDAO = new StatusDAO();
$empresaDAO = new EmpresaDAO();

pt_register('GET', 'busca_submit');
if ($busca_submit <> '') {
    pt_register('GET', 'busca_id_status');
    pt_register('GET', 'busca_id_empresa');
    pt_register('GET', 'busca_autorizacao');
    pt_register('GET', 'busca_id_pedido');
    pt_register('GET', 'busca_ordenar');
    pt_register('GET', 'busca_id_departamento');
    pt_register('GET', 'busca_ord');
    pt_register('GET', 'busca_data_i');
    pt_register('GET', 'busca_data_f');

    $_SESSION['f_busca_id_status'] = $busca_id_status;
    $_SESSION['f_busca_id_empresa'] = $busca_id_empresa;
    $_SESSION['f_busca_autorizacao'] = $busca_autorizacao;
    $_SESSION['f_busca_ordenar'] = $busca_ordenar;
    $_SESSION['f_busca_ord'] = $busca_ord;
    $_SESSION['f_busca_id_departamento'] = $busca_id_departamento;
    $_SESSION['f_busca_data_i'] = $busca_data_i;
    $_SESSION['f_busca_data_f'] = $busca_data_f;
} else {
    $busca_id_status = $_SESSION['f_busca_id_status'];
    $busca_id_empresa = $_SESSION['f_busca_id_empresa'];
    $busca_autorizacao = $_SESSION['f_busca_autorizacao'];
    $busca_id_pedido = $_SESSION['f_busca_id_pedido'];
    $busca_ordenar = $_SESSION['f_busca_ordenar'];
    $busca_id_departamento = $_SESSION['f_busca_id_departamento'];
    $busca_data_i = $_SESSION['f_busca_data_i'];
    $busca_data_f = $_SESSION['f_busca_data_f'];
}
if ($busca_data_i <> '')
    $busca_data_i = invert($busca_data_i, '-', 'SQL'); else
    $busca_data_i = date('Y-m-d', strtotime("-1 years"));
if ($busca_data_f <> '')
    $busca_data_f = invert($busca_data_f, '-', 'SQL'); else
    $busca_data_f = date('Y-m-d');

$busca->busca_ordenar = $busca_ordenar;
$busca->busca_id_pedido = $busca_id_pedido;
$busca->busca_id_empresa = $busca_id_empresa;
$busca->busca_ord = $busca_ord;
$busca->busca_id_status = $busca_id_status;
$busca->busca_id_departamento = $busca_id_departamento;
$busca->busca_data_i = $busca_data_i;
$busca->busca_data_f = $busca_data_f;
$busca->busca_autorizacao = $busca_autorizacao;
?>
<div id="topo">
    <h1 class="tit"><img src="../images/tit/tit_recebimento.png" alt="Título" /> Recebimentos de Outras Franquias</h1>
    <a href="#" class="topo">topo</a>
    <hr class="tit" />
</div>
<div id="meio">
    <?
#devolve pedidos para a franquia
    pt_register('POST', 'submit_empresa_recusa');
    if ($submit_empresa_recusa) {//check for errors
        $errors = 0;
        $error .= "<b>Ocorreram os seguintes erros:</b>";
        $pedidoDAO = new PedidoDAO();
        $atividadeDAO = new AtividadeDAO();
        $ff_id_financeiro = explode(',', str_replace(',##', '', $_COOKIE['ff_id_pedido_item'] . '##'));
        foreach ($ff_id_financeiro as $chave => $id_financeiro) {
            $cont_seg++;

            $financeiroverificaDAO = new FinanceiroVerificaDAO();

            $ret = $financeiroverificaDAO->verificaRecusaPedido($id_financeiro, $id_pedido_item, $controle_id_empresa);

            if ($ret->id_pedido_item <> '' and $ret->id_pedido_item <> 0) {
                $id_usuario_op2 = $ret->id_usuario_op2;
                #verifica se já foi concluído
                if ($ret->operacional <> '0000-00-00') {
                    $errors = 1;
                    $error .= '<li>Esse pedido já foi executado e não pode ser devolvido.</li>';
                }

                if ($ret->id_empresa_resp == '0' or $ret->id_empresa_resp != $controle_id_empresa) {
                    $errors = 1;
                    $error .= '<li>Você não pode devolver esse pedido porque ele já é seu.</li>';
                }

                if ($errors != 1) {
                    $pedidoItem->id_atividade = 191;
                    $pedidoItem->id_status = 3;
                    $pedidoItem->id_usuario_op = $id_usuario_op2;
                    $pedidoItem->id_usuario_op2 = '';
                    $pedidoItem->id_empresa_resp = '0';
                    $pedidoItem->id_pedido_item = $ret->id_pedido_item;
                    $pedidoDAO->atualizaPedidoItemStatus($pedidoItem);
                    #$financeiroDAO->reprovaRecebimentoF($pedidoItem->id_pedido_item);
                    $atividadeDAO->inserir(191, 'Pedido devolvido para Franquia', $controle_id_usuario, $pedidoItem->id_pedido_item);
                    echo '<ul class="sucesso">[' . $ret->id_pedido . '/' . $ret->ordem . '] Pedido devolvido para a franquia</ul>';
                } else {
                    echo '<ul class="erro">[' . $ret->id_pedido . '/' . $ret->ordem . '] ' . $error . '</ul>';
                }
            }
        }
        echo "
	<script>
		eraseCookie('ff_id_pedido_item');
		eraseCookie('ff_id_pedido');
	</script>";
        unset($_COOKIE['ff_id_pedido_item']);
        unset($_COOKIE['ff_id_pedido']);
    }

#aprova valores de recebimento de outras franquias
    pt_register('POST', 'submit_financeiro_aprovar_valor');
    if ($submit_financeiro_aprovar_valor <> '') {
        $financeiroverificaDAO = new FinanceiroVerificaDAO();

        $errors = 0;
        $error = "<b>Ocorreram os seguintes erros:</b><ul>";

        $cont == 0;

        pt_register('POST', 'financeiro_descricao');
        pt_register('POST', 'financeiro_forma');
        pt_register('POST', 'financeiro_valor_ff');
        pt_register('POST', 'financeiro_data_p');
        pt_register('POST', 'financeiro_identificacao');
        pt_register('POST', 'financeiro_nossa_conta');
        pt_register('POST', 'financeiro_classificacao');

        if ($financeiro_valor_ff == "") {
            echo '<br><br><strong>O campo valor é obrigatório.</strong>';
            exit;
        }

        if ($financeiro_data_p == "") {
            echo '<br><br><strong>Preencha o campo Data de Recebimento corretamente.</strong>';
            exit;
        }

        $ff_id_pedido_item = explode(',', str_replace(',##', '', $_COOKIE['ff_id_pedido_item'] . '##'));
        $ff_id_pedido = str_replace(',##', '', $_COOKIE['ff_id_pedido'] . '##');
        $cont = 0;

        #verifica permissão
        foreach ($ff_id_pedido_item as $chave => $id_pedido_item) {
            $cont++;
            $errors = '';
            $error = '';
            $valida = valida_numero($id_pedido_item);
            if ($valida != 'TRUE') {
                echo 'Ocorreu um erro ao validar o número dos pedido(s) selecionado(s). O número de um dos pedidos não é válido';
                exit;
            }

            $id_financeiro = $id_pedido_item;

            $ret = $financeiroverificaDAO->verificaAprovaPedido($id_financeiro, $controle_id_empresa);

            $financeiro_valor = $ret->financeiro_valor;
            $valor_rec = $ret->valor_rec;
            if ($ret->id_pedido_item <> '') {
                $id_pedido_item_ant = $ret->id_pedido_item;
                $financeiro_valor = $financeiro_valor - $valor_rec;
                if ($financeiro_valor < $financeiro_valor_ff and $financeiro_valor > 0) {
                    $financeiro_valor_ff = (float) ($financeiro_valor_ff) - (float) ($financeiro_valor);
                    $financeiro_valor_f = (float) ($financeiro_valor);
                } else {
                    if ($financeiro_valor_ff > 0 and $financeiro_valor > 0) {
                        $financeiro_valor_f = $financeiro_valor_ff;
                        $financeiro_valor_ff = 0;
                    } else {
                        $financeiro_valor_f = 0;
                    }
                }

                $f->financeiro_descricao = $financeiro_descricao;
                $f->financeiro_forma = $financeiro_forma;
                $f->financeiro_classificacao = $financeiro_classificacao;
                $f->financeiro_valor_f = $financeiro_valor_f;
                $f->financeiro_identificacao = $financeiro_identificacao;
                $f->financeiro_nossa_conta = $financeiro_nossa_conta;
                $f->financeiro_data_p = invert($financeiro_data_p, '-', 'SQL');

                $done = $financeiroDAO->aprovaRecebimentoF($ret->id_pedido_item, $id_financeiro, $controle_id_usuario, $controle_id_empresa, $f, $ret, '');
                $id_financeiro_ant = $id_financeiro;

                if ($financeiro_valor_ff == 0)
                    break;
            }
        }

        if ($financeiro_valor_ff > 0 and $financeiro_valor_ff != '') {
            $f->financeiro_valor_f = $financeiro_valor_ff;
            $done = $financeiroDAO->aprovaRecebimentoF($id_pedido_item_ant, $id_financeiro_ant, $controle_id_usuario, $controle_id_empresa, '');
        }

        echo '<ul class="sucesso">Registros atualizados com sucesso!</ul>';
    }

#formulário para acusar recebimentos
    pt_register('POST', 'submit_financeiro_receber');
    if ($submit_financeiro_receber <> '') {
        $cont == 0;
        $financeiro_divisao = '';

        $ff_id_pedido_item = explode(',', str_replace(',##', '', $_COOKIE['ff_id_pedido_item'] . '##'));
        $ff_id_pedido = str_replace(',##', '', $_COOKIE['ff_id_pedido'] . '##');
        $cont = 0;

        #verifica permissão
        foreach ($ff_id_pedido_item as $chave => $id_pedido_item) {
            $cont++;
            $errors = '';
            $error = '';
            $valida = valida_numero($id_pedido_item);
            if ($valida != 'TRUE') {
                echo 'Ocorreu um erro ao validar o número dos pedido(s) selecionado(s). O número de um dos pedidos não é válido';
                exit;
            }
            $id_financeiro = $id_pedido_item;
            $financeiroverificaDAO = new FinanceiroVerificaDAO();
            $ret = $financeiroverificaDAO->verificaAprovaPedidoLista($id_financeiro, $controle_id_empresa);

            $valor_rec = $ret->valor_rec;
            $financeiro_valor = $ret->financeiro_valor;
            if ($valor_rec < $financeiro_valor)
                $financeiro_valor = (float) ($financeiro_valor) - (float) ($valor_rec); else
                $financeiro_valor = "";
            $financeiro_valor_rec = (float) ($financeiro_valor_rec) + (float) ($financeiro_valor);
            $financeiro_valor_rec = number_format($financeiro_valor_rec, 2, '.', '');
            if ($ret->id_financeiro == '') {
                echo 'Sequência inválida, entre em contato com o administrador informando o erro!';
                exit;
            }
            $financeiro_divisao++;
        }
        ?>
        <form enctype="multipart/form-data" action="" method="post" name="pedido_add">
            <table width="800" cellpadding="4" cellspacing="1" class="result_tabela">
                <tr>
                    <td colspan="4" class="tabela_tit">Recebimento</td>
                </tr>
                <tr>
                    <td width="150" valign="top">
                        <div align="right"><strong>Referente as ordens: </strong></div>
                    </td>
                    <td colspan="3"><?= $ff_id_pedido ?> <input type="hidden" name="financeiro_divisao" value="<?= $financeiro_divisao ?>"></td>
                </tr>
                <tr>
                    <td colspan="4" class="tabela_tit">Confirmar Recebimento</td>
                </tr>
                <tr>
                    <td width="150">
                        <div align="right"><strong>Conta: </strong></div>
                    </td>
                    <td width="170">
                        <select name="financeiro_nossa_conta" style="width: 150px" class="form_estilo">
                            <?
                            $p_valor = "";
                            $lista = $contaDAO->listarConta($controle_id_empresa);
                            $p_valor = '';
                            foreach ($lista as $l) {
                                $p_valor .= '<option value="' . $l->sigla . '">' . $l->sigla . '</option>';
                            }
                            echo $p_valor;
                            ?>
                        </select>
                        <font color="#FF0000">*</font>
                    </td>
                    <td width="150">
                        <div align="right"><b>Forma:</b></div>
                    </td>
                    <td>
                        <select name="financeiro_forma" style="width: 150px" class="form_estilo">
                            <?
                            $p_valor = '';
                            $var = $financeiroDAO->listarFormaPagamento();
                            foreach ($var as $s) {
                                $p_valor .= '<option value="' . $s->forma_pagamento . '" >' . $s->forma_pagamento . '</option>';
                            }
                            echo $p_valor;
                            ?>				
                        </select>
                        <font color="#FF0000">*</font> 
                        <input type="hidden" name="financeiro_classificacao" value="<?= $financeiro_classificacao ?>">
                    </td>
                </tr>
                <tr>
                    <td width="150">
                        <div align="right"><strong>Identificação: </strong></div>
                    </td>
                    <td>
                        <input type="text" class="form_estilo" name="financeiro_identificacao" style="width: 150px" />
                    </td>
                    <td>
                        <div align="right"><strong>Data de Rec.: </strong></div>
                    </td>
                    <td>
                        <input type="text" class="form_estilo" name="financeiro_data_p"	onKeyUp="masc_numeros(this,'##/##/####');" style="width: 150px" />
                        <font color="#FF0000">*</font>
                    </td>
                </tr>
                <tr>
                    <td width="150">
                        <div align="right"><strong>Descrição: </strong></div>
                    </td>
                    <td colspan="3">
                        <input type="text" class="form_estilo" name="financeiro_descricao" style="width: 490px" />
                    </td>
                </tr>
                <tr>
                    <td width="150">
                        <div align="right"><strong>Valor: </strong></div>
                    </td>
                    <td colspan="3"><input type="text" class="form_estilo"
                                           name="financeiro_valor_ff" value="<?= $financeiro_valor_rec ?>" id="financeiro_valor" onkeyup="moeda(event.keyCode,this.value,'financeiro_valor');" style="width: 150px" /><font color="#FF0000">*</font> Formato ####.##<br>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                <center>
                    <input type="submit" class="button_busca" name="submit_financeiro_aprovar_valor" value=" Aprovar " />&nbsp; 
                    <input type="submit" name="cancelar" value="Cancelar" onclick="document.pedido_add.action='financeiro_pagamento_f.php'"	class="button_busca" />
                </center>
                </td>
                </tr>
            </table>
        </form>
        <?php
        #fim da alteração de status
        exit;
    }
    ?>

    <form name="buscador" action="" method="GET" ENCTYPE="multipart/form-data">
        <div class="busca1">
            <label>Situação:</label> 
            <select name="busca_autorizacao" style="width:200px;" class="form_estilo">
                <option value="À Receber" <? if ($busca_autorizacao == '' or $busca_autorizacao == 'À Receber')
        echo 'selected="select"'; ?>>À Receber</option>
                <option value="Recebido" <? if ($busca_autorizacao == 'Recebido')
        echo 'selected="select"'; ?>>Recebido</option>
            </select> 

            <label>Recebido Entre:</label>
            <input type="text" name="busca_data_i" value="<? if ($busca_data_i <> '')
        echo invert($busca_data_i, '/', 'PHP'); ?>" style="width:90px; float:left" class="form_estilo" /> 
            <label style="width: 10px; font-weight: bold; padding-top: 5px; float: left">e</label>
            <input type="text" name="busca_data_f" value="<? if ($busca_data_f <> '')
        echo invert($busca_data_f, '/', 'PHP'); ?>" style="width:90px; float:left" class="form_estilo" /> 

            <label>Departamento:</label> 
            <select name="busca_id_departamento" style="width:200px;" class="form_estilo">
                <option value="" <? if ($busca_id_departamento == '')
                    echo ' selected="selected" '; ?>>Todos</option>
                <?
                $p_valor = '';
                $var = $departamentoDAO->listarDptoOrdem();
                foreach ($var as $s) {
                    $p_valor .= '<option value="' . $s->id_servico_departamento . '"';
                    if ($busca_id_departamento == $s->id_servico_departamento)
                        $p_valor .= ' selected="selected" ';
                    $p_valor .= ' >' . $s->departamento . '</option>';
                }
                echo $p_valor;
                ?>
            </select> 

            <label>Status:</label> 
            <select name="busca_id_status" style="width: 200px;" class="form_estilo">
                <option value="Todos">Todos (Exceto Concluído)</option>
                <?
                $p_valor = '';
                $var = $statusDAO->listarTodos();
                foreach ($var as $s) {
                    $p_valor .= '<option value="' . $s->id_status . '"';
                    if ($busca_id_status == $s->id_status)
                        $p_valor .= ' selected="selected" ';
                    $p_valor .= ' >' . $s->status . '</option>';
                }
                echo $p_valor;
                ?>
            </select>				

            <label>Unidade:</label> 
            <select name="busca_id_empresa" style="width:200px;" class="form_estilo">
                <option value="" <? if ($busca_id_empresa == '')
                    echo ' selected="selected" '; ?>>Todas</option>
<?
$p_valor = '';
$var = $empresaDAO->listarTodas();
foreach ($var as $s) {
    $p_valor .= '<option value="' . $s->id_empresa . '"';
    if ($busca_id_empresa == $s->id_empresa)
        $p_valor .= ' selected="selected" ';
    $p_valor .= ' >' . str_replace('Cartório Postal - ', '', $s->fantasia) . '</option>';
}
echo $p_valor;
?>
            </select> 

            <label>Ordenar Por:</label> 
            <select name="busca_ordenar" style="width:145px;" class="form_estilo">
                <option value="" <? if ($busca_ordenar == '')
    echo ' selected="selected" '; ?>></option>
                <option value="Ordem" <? if ($busca_ordenar == 'Ordem')
    echo ' selected="selected" '; ?>>Ordem</option>
                <option value="Documento de" <? if ($busca_ordenar == 'Documento de')
    echo ' selected="selected" '; ?>>Documento de</option>
                <option value="Data" <? if ($busca_ordenar == 'Data')
    echo ' selected="selected" '; ?>>Data</option>
                <option value="Departamento" <? if ($busca_ordenar == 'Departamento')
    echo ' selected="selected" '; ?>>Departamento</option>
                <option value="Serviço"	<? if ($busca_ordenar == 'Serviço')
    echo ' selected="selected" '; ?>>Serviço</option>
                <option value="Cidade" <? if ($busca_ordenar == 'Cidade')
    echo ' selected="selected" '; ?>>Cidade</option>
                <option value="Prazo" <? if ($busca_ordenar == 'Prazo')
    echo ' selected="selected" '; ?>>Prazo</option>
                <option value="Agenda" <? if ($busca_ordenar == 'Agenda')
    echo ' selected="selected" '; ?>>Agenda</option>
                <option value="Data Status"	<? if ($busca_ordenar == 'Data Status')
    echo ' selected="selected" '; ?>>Data Status</option>
            </select> 

            <select name="busca_ord" style="width:50px;" class="form_estilo">
                <option value="" <? if ($busca_ord == '')
            echo ' selected="selected" '; ?>>Cres</option>
                <option value="Decr" <? if ($busca_ord == 'Decr')
            echo ' selected="selected" '; ?>>Decr</option>
            </select> 

            <label>Ordem:</label> 
            <input type="text" name="busca_id_pedido" value="<?= $busca_id_pedido ?>" style="width: 90px;" class="form_estilo" /> 
            <input type="submit" name="busca_submit" class="button_busca" value=" Buscar " />
        </div>
    </form>
    <br />
    <form name="f1" action="" method="post" ENCTYPE="multipart/form-data">
        <div style="clear: both; padding: 5px">
            <input type="submit" name="submit_financeiro_receber" class="button_busca" value=" Aprovar " onclick="document.f1.target='_self'; document.f1.action=''" />&nbsp;
            <input type="submit" name="submit_exporta"	onclick="document.f1.target='_blank'; document.f1.action='gera_exporta_f_c.php'" class="button_busca" value=" Exportar " />&nbsp;
            <input type="submit" name="submit_empresa_recusa" onclick="document.f1.target='_self'; document.f1.action=''" class="button_busca" value=" Devolver " />&nbsp;
        </div>
<?php
pt_register('GET', 'pagina');
if ($pagina == '') {
    echo "
		<script>
			eraseCookie('ff_id_pedido_item');
			eraseCookie('ff_id_pedido');
		</script>";
    unset($_COOKIE['ff_id_pedido_item']);
    unset($_COOKIE['ff_id_pedido']);
}
$ff_id_pedido_item = explode(',', $_COOKIE["ff_id_pedido_item"]);

$p_valor = '';
$cont = 0;
$lista = $financeiroDAO->buscaRecebimentoF($busca, $controle_id_empresa, $pagina);
?>
        <table width="100%" cellpadding="4" cellspacing="1" class="result_tabela">
            <tr>
                <td colspan="18" class="barra_busca">
            <? $financeiroDAO->QTDPagina(); ?>
                </td>
            </tr>
            <tr>
                <td align="center" width="20" class="result_menu">
                    <input type="checkbox" name="todos"	onclick="if(this.checked==1) { selecionar_tudo_cache('ff_id_pedido'); selecionar_tudo_cache('ff_id_pedido_item'); selecionar_tudo(); } else { deselecionar_tudo_cache('ff_id_pedido'); deselecionar_tudo_cache('ff_id_pedido_item'); deselecionar_tudo(); }">
                </td>
                <td align="center" width="50" class="result_menu"><b>Ordem</b></td>
                <td align="center" width="50" class="result_menu"><b>Editar</b></td>
                <td class="result_menu"><b>Franquia</b></td>
                <td align="center" width="50" class="result_menu"><b>Custas</b></td>
                <td align="center" width="50" class="result_menu"><b>Correios</b></td>
                <td align="center" width="50" class="result_menu"><b>Honorários</b></td>
                <td align="center" width="50" class="result_menu"><b>Custo Total</b></td>
                <td align="center" width="50" class="result_menu"><b>Valor Recebido</b></td>
                <td align="center" width="80" class="result_menu"><b>Recebido em</b></td>
                <td align="center" width="80" class="result_menu"><b>Serviço</b></td>
            </tr>
            <?
            foreach ($lista as $l) {
                $cont++;
                $financeiro_valor_f = $l->financeiro_valor_f;
                $comissao = number_format((float) ($l->valor) / 100 * 14, 2, ".", ",");
                $financeiro_valor_f = number_format($financeiro_valor_f, 2, ".", ",");
                
                $financeiro_valor_f_total = (float) ($financeiro_valor_f_total) + (float) ($financeiro_valor_f);
                $financeiro_valor_total = (float) ($financeiro_valor_total) + (float) ($l->financeiro_valor);
                $financeiro_valor_stotal = (float) ($financeiro_valor_stotal) + (float) ($l->financeiro_sedex);
                $financeiro_valor_rtotal = (float) ($financeiro_valor_rtotal) + (float) ($l->financeiro_rateio);
                $financeiro_valor_vtotal = (float) ($financeiro_valor_vtotal) + (float) ($l->financeiro_custas);

                $l->financeiro_valor = number_format($l->financeiro_valor, 2, ",", "");
                $l->financeiro_sedex = number_format((float) ($l->financeiro_sedex), 2, ",", "");
                $l->financeiro_rateio = number_format((float) ($l->financeiro_rateio), 2, ",", "");
                $l->financeiro_custas = number_format((float) ($l->financeiro_custas), 2, ",", "");

                $comissao_total = (float) ($comissao_total) + (float) ($comissao);
                $financeiro_valor_f_num = $financeiro_valor_f;
                $id_re = $l->id_financeiro;

                if (in_array($id_re, $ff_id_pedido_item) == 1)
                    $item_checked = ' checked '; else
                    $item_checked = '';
                $p_valor .= '
			<tr>
			<td class="result_celula" align="center" nowrap>
			<input type="hidden" name="acao_' . $cont . '" value="' . $id_re . '"/>
			<input type="hidden" name="acao_pedido_' . $cont . '" value="' . $l->id_pedido . '/' . $l->ordem . '"/>
			<input type="checkbox" name="acao_sel_' . $cont . '" value="' . $id_re . '" onclick="if(this.checked==true) { createCookie(\'ff_id_pedido_item\',\'' . $id_re . ',\',\'1\',\'1\'); createCookie(\'ff_id_pedido\',\'#' . $l->id_pedido . '/' . $l->ordem . ',\',\'1\',\'1\'); } else {eraseCookieItem(\'ff_id_pedido_item\',\'' . $id_re . '\'); eraseCookieItem(\'ff_id_pedido\',\'#' . $l->id_pedido . '/' . $l->ordem . '\'); }" ' . $item_checked . ' />
			</td>
			<td class="result_celula" align="center"><a href="pedido_edit.php?id=' . $l->id_pedido . '&ordem=' . $l->ordem . '" target="_blank"><img src="../images/botao_editar.png" title="Editar" border="0"/></a></td>
			<td class="result_celula" align="center" nowrap>#' . $l->id_pedido . '/' . $l->ordem . '</td>
			<td class="result_celula" nowrap>' . $l->fantasia . '</td>
			<td class="result_celula" nowrap>R$ ' . $l->financeiro_custas . '</td>
			<td class="result_celula" nowrap>R$ ' . $l->financeiro_sedex . '</td>
			<td class="result_celula" nowrap>R$ ' . $l->financeiro_rateio . '</td>
			<td class="result_celula" nowrap>R$ ' . $l->financeiro_valor . '</td>
			<td class="result_celula" align="center" nowrap>R$ ' . $financeiro_valor_f . '</td>
			<td class="result_celula" nowrap>' . invert($l->financeiro_autorizacao_data, '/', 'PHP') . '</td>
			<td class="result_celula" nowrap>' . $l->servico . '</td>
			</tr>';
            }
            $financeiro_valor_f_total = 'R$ ' . number_format($financeiro_valor_f_total, 2, ".", ",");
            $financeiro_valor_total = 'R$ ' . number_format($financeiro_valor_total, 2, ".", ",");
            $financeiro_valor_stotal = 'R$ ' . number_format($financeiro_valor_stotal, 2, ".", ",");
            $financeiro_valor_vtotal = 'R$ ' . number_format($financeiro_valor_vtotal, 2, ".", ",");
            $financeiro_valor_rtotal = 'R$ ' . number_format($financeiro_valor_rtotal, 2, ".", ",");
            $comissao_total = 'R$ ' . number_format($comissao_total, 2, ".", ",");

            $p_valor .= '
		<tr>
		<td class="result_celula" align="center" nowrap></td>
		<td class="result_celula" align="center" nowrap></td>
		<td class="result_celula" align="center" nowrap></td>
		<td class="result_celula" align="right" nowrap>Total</td>
		<td class="result_celula" nowrap>' . $financeiro_valor_vtotal . '</td>
		<td class="result_celula" nowrap>' . $financeiro_valor_stotal . '</td>
		<td class="result_celula" nowrap>' . $financeiro_valor_rtotal . '</td>
		<td class="result_celula" nowrap>' . $financeiro_valor_total . '</td>
		<td class="result_celula" align="right" nowrap>' . $financeiro_valor_f_total . '</td>
		<td class="result_celula" nowrap></td>
		<td class="result_celula" nowrap></td>
		</tr>';
            echo $p_valor;
            ?>
            <tr>
                <td colspan="18" class="barra_busca">
<? $financeiroDAO->QTDPagina(); ?>
                </td>
            </tr>
        </table>
    </form>
</div>
<?php
require('footer.php');
?>