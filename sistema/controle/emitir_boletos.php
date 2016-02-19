<? require('header.php');
require("../../includes/maladireta/class.PHPMailer.php");

$departamento_s = explode(',', $controle_id_departamento_s);
$departamento_p = explode(',', $controle_id_departamento_p);

$financeiroDAO = new FinanceiroDAO();
$empresaDAO = new EmpresaDAO();

$permissao = verifica_permissao('Financeiro', $controle_id_departamento_p, $controle_id_departamento_s);
$permissao_fin_cobranca = verifica_permissao('Financeiro Cobrança', $controle_id_departamento_p, $controle_id_departamento_s);

if (($permissao == 'FALSE' or $controle_id_empresa != 1) and ($permissao_fin_cobranca == 'FALSE' or $controle_id_empresa != 1)) {
    echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
    exit;
}
pt_register('GET', 'busca_submit');
pt_register('POST', 'submit_emite_boleto');

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

    if ($busca_ano == '') $busca_ano = date('Y');
    $buscap = new stdClass();
    $buscap->id_empresa = $busca_id_empresa;
    $buscap->ano = $busca_ano;
    $buscap->mes = $busca_mes;
    $buscap->situacao = $busca_situacao;
    $buscap->id_empresa = $busca_id_empresa;

    $cont = 0;
}


if ($busca_ano == '') $busca_ano = date('Y');
if ($busca_mes == '') $busca_mes = date('m');

?>


<div id="topo">
    <h1 class="tit"><img src="../images/tit/tit_recebimento.png" alt="Título"/>Emitir Boletos</h1>
    <a href="#" class="topo">topo</a>
    <hr class="tit"/>
</div>
<div id="meio">
    <?
    pt_register('POST', 'submit_financeiro_receber');

    if ($submit_financeiro_receber <> '') {

        $im = htmlentities($_COOKIE['fr_id_rel_royalties']);

        if (!empty($im)) {
            require('../includes/financeiro_emitir_royalties.php');
            return;
        }


        $titulo = 'Mensagem da página web';
        $msg = 'Favor selecionar uma unidade para emissão do boleto!';
        $pag = '';
        $funcJs = "openAlertBox('" . $titulo . "','" . $msg . "','" . $pag . "');";
        echo '<img src="../images/null.gif" class="nulo" onload="' . $funcJs . '" />';
    }

    pt_register('POST', 'submit_financeiro_emitir_royalties');
    if ($submit_financeiro_emitir_royalties <> '') {
        require('../includes/financeiro_emitir_royalties.php');
    }
    ?>
    <form name="buscador" action="" method="get" ENCTYPE="multipart/form-data">
        <div class="busca1">
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
            <? if ($busca_submit <> '') { ?>
                <input type="submit" name="submit_financeiro_receber" class="button_busca" value=" Emitir "
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

        if ($busca_submit <> '') {
            $buscapedido = $financeiroDAO->lista_royalties_aberto_emissao_boleto($buscap, $controle_id_empresa, $pagina);
        }
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
		</tr>';
            if ($busca_submit <> '') {
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
			</tr>';
                    }
                }
            }
            echo $p_valor;
            ?>
            <tr>
                <td colspan="9" class="barra_busca"><? $financeiroDAO->QTDPagina(); ?></td>
            </tr>
        </table>
    </form>
</div>
<?php require('footer.php'); ?>
