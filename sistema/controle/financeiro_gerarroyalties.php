<? require('header.php');

$departamento_s = explode(',', $controle_id_departamento_s);
$departamento_p = explode(',', $controle_id_departamento_p);
$cRoyaltieFixoDAO = new RoyaltieFixoDAO();
$empresaDAO = new EmpresaDAO();
$permissao = verifica_permissao('Financeiro', $controle_id_departamento_p, $controle_id_departamento_s);
$permissao_fin_cobranca = verifica_permissao('Financeiro Cobrança', $controle_id_departamento_p, $controle_id_departamento_s);

if (($permissao == 'FALSE' or $controle_id_empresa != 1) and ($permissao_fin_cobranca == 'FALSE' or $controle_id_empresa != 1)) {
    echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
    exit;
}



pt_register('POST', 'gerar_submit');
pt_register("POST", 'gerar_submit_todos');

if (isset($gerar_submit)) {
    pt_register('POST', 'acao_sel');
    pt_register('POST', 'busca_mes');
    pt_register('POST', 'busca_ano');


    $dtmData = "$busca_ano-$busca_mes-01";

    if (date("yy-mm", strtotime($dtmData)) > date("yy-mm")) {
        $titulo = 'Mensagem da página web';
        $msg = 'O mês informado não pode ser superior que a data de hoje!';

        $pag = '';
        $funcJs = "openAlertBox('" . $titulo . "','" . $msg . "','" . $pag . "');";
        echo '<img src="../images/null.gif" class="nulo" onload="' . $funcJs . '" />';

    } else {

        if (count($acao_sel) <= 0) {
            $titulo = 'Mensagem da página web';
            $msg = 'Favor selecionar uma unidade!';
            $pag = '';
            $funcJs = "openAlertBox('" . $titulo . "','" . $msg . "','" . $pag . "');";
            echo '<img src="../images/null.gif" class="nulo" onload="' . $funcJs . '" />';

        } else {

            foreach ($acao_sel as $item) {
                $roy = $cRoyaltieFixoDAO->royalties_gerados_por_mes($busca_mes, $busca_ano, $item);
                if ($roy->qnt == 0) {
                    $royal = $cRoyaltieFixoDAO->lista_royalties_fixo($item);
                    $cRoyaltieFixoDAO->gerar_royalties_franquia($item, "$busca_ano-$busca_mes-01", $royal->valor);

                    $titulo = 'Mensagem da página web';
                    $msg = 'Royalties gerados com sucesso!';
                    $pag = 'financeiro_gerarroyalties.php';
                    $funcJs = "openAlertBox('" . $titulo . "','" . $msg . "','" . $pag . "');";
                    echo '<img src="../images/null.gif" class="nulo" onload="' . $funcJs . '" />';
                } else {
                    $titulo = 'Mensagem da página web';
                    $msg = 'Está unidade já foi gerada na data informada!';
                    $pag = 'financeiro_gerarroyalties.php';
                    $funcJs = "openAlertBox('" . $titulo . "','" . $msg . "','" . $pag . "');";
                    echo '<img src="../images/null.gif" class="nulo" onload="' . $funcJs . '" />';
                }
            }
        }
    }
}

if (isset($gerar_submit_todos)) {
    pt_register('POST', 'busca_mes');
    pt_register('POST', 'busca_ano');

    $dtmData = "$busca_ano-$busca_mes-01";

    if (date("yy-mm", strtotime($dtmData)) > date("yy-mm")) {
        $titulo = 'Mensagem da página web';
        $msg = 'O mês informado não pode ser superior que a data de hoje!';

        $pag = '';
        $funcJs = "openAlertBox('" . $titulo . "','" . $msg . "','" . $pag . "');";
        echo '<img src="../images/null.gif" class="nulo" onload="' . $funcJs . '" />';

    } else {

        $resultado = $cRoyaltieFixoDAO->listar_franquia_royalties_todos();

        foreach ($resultado as $item) {
            $roy = $cRoyaltieFixoDAO->royalties_gerados_por_mes($busca_mes, $busca_ano, $item->id_empresa);
            if ($roy->qnt == 0  ) {
                $royal = $cRoyaltieFixoDAO->lista_royalties_fixo($item->id_empresa);
                $cRoyaltieFixoDAO->gerar_royalties_franquia($item->id_empresa, "$busca_ano-$busca_mes-01", $royal->valor);

                $titulo = 'Mensagem da página web';
                $msg = 'Royalties gerados com sucesso!';
                $pag = 'financeiro_gerarroyalties.php';
                $funcJs = "openAlertBox('" . $titulo . "','" . $msg . "','" . $pag . "');";
                echo '<img src="../images/null.gif" class="nulo" onload="' . $funcJs . '" />';
            } else {
                $titulo = 'Mensagem da página web';
                $msg = 'Está unidade já foi gerada na data informada!';
                $pag = 'financeiro_gerarroyalties.php';
                $funcJs = "openAlertBox('" . $titulo . "','" . $msg . "','" . $pag . "');";
                echo '<img src="../images/null.gif" class="nulo" onload="' . $funcJs . '" />';
            }
        }
    }
}

if ($busca_ano == '') $busca_ano = date('Y');
if ($busca_mes == '') $busca_mes = date('m');

?>
    <div id="topo">
        <h1><img src="../images/tit/tit_recebimento.png" alt="Título"/>Gerar Royalties</h1>
        <a href="#" class="topo">topo</a>
        <hr class="tit"/>
    </div>
    <div id="meio">
        <form name="f1" action="" method="post" ENCTYPE="multipart/form-data">
            <div class="busca1">
                <label>Mês/Ano: </label>
                <select name="busca_mes" style="width: 100px; float: left" class="form_estilo
	<?= (isset($errors['mes'])) ? 'form_estilo_erro' : ''; ?>>
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
                <!--<input type="submit" name="gerar_submit_todos" id="gerar_submit_todos" class="button_busca"
                       value=" Gerar todos"/>-->
                <input type="submit" name="gerar_submit" class="button_busca" value=" Gerar "/>
            </div>

            <div style="postition:relative; clear: both; padding:5px 5px 5px 5px;">

            </div>
            <?php

            #recebido ou a receber
            pt_register('GET', 'pagina');
            if ($pagina == '') {
                echo "
	<script>
		eraseCookie('fr_id_royaltie_fixo_franquiado');
	</script>
	";
                unset($_COOKIE['fr_id_royaltie_fixo_franquiado']);
            }
            $cont = 0;
            $row = $cRoyaltieFixoDAO->listar_franquia_royalties($pagina);
            ?>
            <table width="100%" cellpadding="4" cellspacing="1" class="result_tabela">
                <tr>
                    <td colspan="23" class="barra_busca">            <? $cRoyaltieFixoDAO->QTDPagina(); ?>        </td>
                </tr> <?
                $p_valor = '
		<tr>
		<td align="center" width="20" class="result_menu"><input type="checkbox" name="todos" onclick="if(this.checked==1) { selecionar_tudo_cache(\'fr_id_royaltie_fixo_franquiado\'); selecionar_tudo(); } else { deselecionar_tudo_cache(\'fr_id_royaltie_fixo_franquiado\'); deselecionar_tudo(); }"></td>
		<td class="result_menu"><b>Unidade</b></td>
		<td align="center" width="130" class="result_menu"><b>Status</b></td>
		<td align="center" width="130" class="result_menu"><b>Royalties</b></td>
		</tr>';
                $p_ref = explode(',', $_COOKIE["fr_id_royaltie_fixo_franquiado"]);
                foreach ($row as $p) {
                    $cont++;
                    $p_valor .= '
			<tr>
			<td class="result_celula" align="center" nowrap>
			<input type="hidden" name="acao_' . $cont . '" value="' . $p->id_empresa . '"/>
			<input type="checkbox" name="acao_sel[]" value="' . $p->id_empresa . '" onclick="if(this.checked==true) { createCookie(\'fr_id_royaltie_fixo_franquiado\',\'' . $p->id_royaltie_fixo_franquiado . ',\',\'1\',\'1\'); } else { eraseCookieItem(\'fr_id_royaltie_fixo_franquiado\',\'' . $p->id_royaltie_fixo_franquiado . '\'); }" />
			</td>
			<td class="result_celula" align="left" nowrap>' . $p->fantasia . '</td>
			<td class="result_celula" align="center" nowrap>' . $p->status . '</td>
			<td class="result_celula" align="right" nowrap>R$ ' . number_format($p->valor, 2, ",", "") . '</td>
			</tr>';
                }
                echo $p_valor;
                ?>
                <tr>
                    <td colspan="8" class="barra_busca"><? $cRoyaltieFixoDAO->QTDPagina(); ?></td>
                </tr>
            </table>
        </form>
    </div>
    <script type="text/javascript">
        $("#gerar_submit_todos").click(function () {
            var resultado = confirm("Deseja realmente gerar todos os royalties?");

            if(resultado) return true;
            return false;
        });
    </script>
<?php require('footer.php'); ?>