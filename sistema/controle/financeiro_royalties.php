<? require('header.php');

$departamento_s = explode(',', $controle_id_departamento_s);
$departamento_p = explode(',', $controle_id_departamento_p);

$financeiroDAO = new FinanceiroDAO();
$empresaDAO = new EmpresaDAO();

$permissao = verifica_permissao('Financeiro', $controle_id_departamento_p, $controle_id_departamento_s);
if ($permissao == 'FALSE' or $controle_id_empresa != 1) {
    echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
    exit;
}
pt_register('GET', 'busca_submit');
pt_register('POST', 'submit_emite_boleto');

if (isset($submit_emite_boleto)) {

    pt_register('POST', 'id_royalties');
    pt_register('POST', 'id_empresa');
    pt_register('POST', 'id_conta');
    pt_register('POST','vencimento');


    $validacaoCLASS = new ValidacaoCLASS();
    $verifica = $validacaoCLASS->invertData($vencimento);


    $p->id_nota = null;
    $p->id_relatorio = mull;
    $p->id_empresa_franquia = $id_empresa;
    $p->id_fatura = null;
    $p->id_conta = $id_conta;
    $p->ocorrencia = 1;


    $EmpresaDao = new EmpresaDAO();
    $cEmpresa = $empresaDAO->selectPorId($id_empresa);

    $p->cpf = $cEmpresa->cpf;
    $p->sacado = $cEmpresa->empresa;
    $p->endereco = $cEmpresa->endereco;
    $p->bairro = $cEmpresa->bairro;
    $p->cidade = $cEmpresa->cidade;
    $p->estado = $cEmpresa->estado;
    $p->cep = $cEmpresa->cep;
    $p->tipo = $cEmpresa->tipo;

    $RoyaltiesDAO = new RoyaltieFixoDAO();
    $cRoyaltiesDAO = $RoyaltiesDAO->seleciona_royalties_gerados_por_id($id_royalties);


    $p->vencimento = $verifica;
    $p->valor = $cRoyaltiesDAO->valor_royalties;
    $p->juros_mora = null;
    $p->instrucao1 = null;
    $p->instrucao2 = null;
    $p->mensagem1 = null;
    $p->mensagem2 = null;
    $p->emissao_papeleta = null;
    $p->especie = null;
    $p->aceite = null;
    $id_usuario = null;



    //$contaDAO = new ContaDAO();
  //  $done = $contaDAO->inserirBoletoBrad($p,$controle_id_empresa,$controle_id_usuario);

    echo "
		<script>
			alert('CPF: ".$p->cpf."');
		</script>";
}


if ($busca_submit <> '') {
    pt_register('GET', 'busca_id_empresa');
    pt_register('GET', 'busca_ano');
    pt_register('GET', 'busca_mes');
    pt_register('GET', 'busca_situacao');
    pt_register('GET', 'busca_id_empresa');
    $_SESSION['fr_id_empresa'] = $busca_id_empresa;
    $_SESSION['fr_ano'] = $busca_ano;
    $_SESSION['fr_mes'] = $busca_mes;
    $_SESSION['fr_situacao'] = $busca_situacao;
    $_SESSION['fr_id_empresa'] = $busca_id_empresa;
} else {
    $busca_id_empresa = $_SESSION['fr_id_empresa'];
    $busca_ano = $_SESSION['fr_ano'];
    $busca_mes = $_SESSION['fr_mes'];
    $busca_situacao = $_SESSION['fr_situacao'];
    $busca_id_empresa = $_SESSION['fr_id_empresa'];
}

if ($busca_ano == '') $busca_ano = date('Y');
$buscap = new stdClass();
$buscap->id_empresa = $busca_id_empresa;
$buscap->ano = $busca_ano;
$buscap->mes = $busca_mes;
$buscap->situacao = $busca_situacao;
$buscap->id_empresa = $busca_id_empresa;
?>
    <div id="topo">
        <h1><img src="../images/tit/tit_recebimento.png" alt="Título"/>Recebimentos de Royalties e FPP</h1>
        <a href="#" class="topo">topo</a>
        <hr class="tit"/>
    </div>
    <div id="meio"><?
        pt_register('POST', 'submit_financeiro_receber');
        if ($submit_financeiro_receber <> '') {
            require('../includes/financeiro_aprovar_roy.php');
        }
        pt_register('POST', 'submit_receber_aplica');
        if ($submit_receber_aplica <> '') {
            require('../includes/financeiro_aprovar_roy_aplica.php');
        } ?>
        <form name="buscador" action="" method="get" ENCTYPE="multipart/form-data">
            <div class="busca1">
                <label>Situação:</label>
                <select name="busca_situacao" style="width: 200px; float: left" class="form_estilo">
                    <option value="" <? if ($busca_situacao == '') echo 'selected="select"'; ?>>À Receber</option>
                    <option value="1" <? if ($busca_situacao == '1') echo 'selected="select"'; ?>>Recebido</option>
                    <option value="2" <? if ($busca_situacao == '2') echo 'selected="select"'; ?>>Ambos</option>
                </select>
                <label>Franquias:</label>
                <select name="busca_id_empresa" style="width:200px" class="form_estilo">
                    <option value="" <? if ($busca_id_empresa == '') echo ' selected="selected" '; ?>>Todos</option>
                    <?
                    $p_valor = '';
                    $var = $empresaDAO->listarTodasRoy();
                    foreach ($var as $s) {
                        $p_valor .= '<option value="' . $s->id_empresa . '"';
                        if ($busca_id_empresa == $s->id_empresa) $p_valor .= ' selected="selected" ';
                        $p_valor .= ' >' . str_replace('Cartório Postal - ', '', $s->fantasia) . '</option>';
                    }
                    echo $p_valor;
                    ?>
                </select>
                <label>Mês/Ano: </label>
                <select name="busca_mes" style="width: 100px; float: left" class="form_estilo">
                    <option value=""></option>
                    <?
                    $p_valor = '';
                    $cont_mes = 1;
                    while ($cont_mes <= 12) {
                        if ($cont_mes < 10)
                            $p_valor .= '<option value="0' . $cont_mes . '" ';
                        else
                            $p_valor .= '<option value="' . $cont_mes . '" ';
                        if ($busca_mes == $cont_mes)
                            $p_valor .= 'selected="select"';
                        $p_valor .= '>' . $cont_mes . '</option>';
                        $cont_mes++;
                    }
                    echo $p_valor;
                    ?>
                </select>
                <select name="busca_ano" style="width: 100px; float: left" class="form_estilo">
                    <?
                    $p_valor = '';
                    $cont_ano = 2010;
                    while ($cont_ano <= date('Y')) {
                        $p_valor .= '<option value="' . $cont_ano . '" ';
                        if ($busca_ano == $cont_ano) $p_valor .= 'selected="select"';
                        $p_valor .= '>' . $cont_ano . '</option>';
                        $cont_ano++;
                    }
                    echo $p_valor;
                    ?>
                </select>
                <input type="submit" name="busca_submit" class="button_busca" value=" Buscar "/>
            </div>
        </form>
        <form name="f1" action="" method="post" ENCTYPE="multipart/form-data">
            <div style="postition:relative; clear: both; padding:5px 5px 5px 5px;">
                <? if ($busca_situacao == '') { ?>
                    <input type="submit" name="submit_financeiro_receber" class="button_busca" value=" Aprovar "
                           onclick="document.f1.target='_self'; document.f1.action=''"/>
                <? } ?>
            </div>
            <?php

            #recebido ou a receber
            pt_register('GET', 'pagina');
            if ($pagina == '') {
                echo "
	<script>
		eraseCookie('fr_id_rel_royalties');
	</script>
	";
                unset($_COOKIE['fr_id_rel_royalties']);
            }
            $cont = 0;
            $buscapedido = $financeiroDAO->buscaRecebimentoRoy($buscap, $controle_id_empresa, $pagina);

            echo '  <b>Valor Royalties:</b> R$ ' . str_replace('.', ',', $buscapedido[0]->valor_roy_t) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<b>Valor FPP: </b> R$ ' . str_replace('.', ',', $buscapedido[0]->valor_fpp_t) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<b>Valor Total: </b> R$ ' . str_replace('.', ',', $buscapedido[0]->valor_t) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<b>Valor Recebido:</b> R$ ' . str_replace('.', ',', $buscapedido[0]->valor_rec_t) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<b>Valor Juros: </b> R$ ' . str_replace('.', ',', $buscapedido[0]->valor_juros_roy_t) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $saldo = $buscapedido[0]->valor_t - $buscapedido[0]->valor_rec_t;
            if ($saldo > 0) echo '<b>À Receber: </b> R$ ' . str_replace('.', ',', $saldo);
            ?>
            <table width="100%" cellpadding="4" cellspacing="1" class="result_tabela">
                <tr>
                    <td colspan="23" class="barra_busca">            <? $financeiroDAO->QTDPagina(); ?>        </td>
                </tr> <?
                $p_valor = '
		<tr>
		<td align="center" width="20" class="result_menu"><input type="checkbox" name="todos" onclick="if(this.checked==1) { selecionar_tudo_cache(\'fr_id_rel_royalties\'); selecionar_tudo(); } else { deselecionar_tudo_cache(\'fr_id_rel_royalties\'); deselecionar_tudo(); }"></td>		
		<td class="result_menu"><b>Franquia</b></td>		
		<td align="center" width="130" class="result_menu"><b>Referência</b></td>		
		<td align="center" width="130" class="result_menu"><b>Royalties á Receber</b></td>		
		<td align="center" width="130" class="result_menu"><b>FPP á Receber</b></td>		
		<td align="center" width="130" class="result_menu"><b>Royalties Recebido</b></td>		
		<td align="center" width="130" class="result_menu"><b>FPP Recebido</b></td>
		<td align="center" width="130" class="result_menu"><b>Emitir Boleto</b></td>
		<td align="center" width="130" class="result_menu"><b>Editar</b></td>		
		</tr>';

                $p_ref = explode(',', $_COOKIE["fr_id_rel_royalties"]);
                foreach ($buscapedido as $p) {
                    if ($p->id_rel_royalties <> '') {
                        $cont++;
                        if (in_array($p->id_rel_royalties, $p_ref) == 1) $item_checked = ' checked '; else $item_checked = '';
                        $p_valor .= '
			<tr>				
			<td class="result_celula" align="center" nowrap>					
			<input type="hidden" name="acao_' . $cont . '" value="' . $p->id_empresa . '"/>
			<input type="hidden" name="acao_pedido_' . $cont . '" value="' . $p->id_rel_royalties . '"/>
			<input type="checkbox" name="acao_sel_' . $cont . '" value="' . $p->id_rel_royalties . '" onclick="if(this.checked==true) { createCookie(\'fr_id_rel_royalties\',\'' . $p->id_rel_royalties . ',\',\'1\',\'1\'); } else { eraseCookieItem(\'fr_id_rel_royalties\',\'' . $p->id_rel_royalties . '\'); }" ' . $item_checked . ' />
			</td>
			<td class="result_celula" align="left" nowrap>' . $p->fantasia . '</td>
			<td class="result_celula" align="center" nowrap>' . $p->ref . '</td>
			<td class="result_celula" align="right" nowrap>R$ ' . number_format($p->roy, 2, ",", "") . '</td>
			<td class="result_celula" align="right" nowrap>R$ ' . number_format($p->fpp, 2, ",", "") . '</td>
			<td class="result_celula" align="right" nowrap>R$ ' . number_format($p->roy_rec, 2, ",", "") . '</td>
			<td class="result_celula" align="right" nowrap>R$ ' . number_format($p->fpp_rec, 2, ",", "") . '</td>
			<td class="result_celula" align="center">
			    <a href="#"  onclick="carrega_banco_contas(\'' . $p->id_rel_royalties . '\',\'' . $p->id_empresa . '\'); $(\'#windowMensagem\').show();"><img src="../images/botao_editar.png" title="Editar" border="0"/></a>
			</td>
			<td class="result_celula" align="center">
				<a href="#"  onclick="carrega_royalties_r(\'' . $p->ref . '\',\'' . $p->id_empresa . '\'); $(\'#windowMensagem\').show();"><img src="../images/botao_editar.png" title="Editar" border="0"/></a>
			</td>
			</tr>';
                    }
                }
                echo $p_valor;
                ?>
                <tr>
                    <td colspan="9" class="barra_busca"><? $financeiroDAO->QTDPagina(); ?></td>
                </tr>
            </table>
        </form>
        <div id="windowMensagem">
            <div id="windowMensagemTop">
                <div id="windowMensagemTopContent">
                    <img src="../images/icon/icon_mensagem.png" style="border: 0"/> Ação
                </div>
                <img id="windowMensagemClose" src="../images/window_close.jpg"></div>
            <div id="windowMensagemBottom">
                <div id="windowMensagemBottomContent"></div>
            </div>
            <div id="windowMensagemContent">
                <div id="carrega_mensagem_input"></div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(
                function () {
                    $('#windowMensagemClose').bind(
                        'click',
                        function () {
                            $('#windowMensagem').hide();
                        }
                    );
                }
            );
        </script>
    </div>
<?php require('footer.php'); ?>