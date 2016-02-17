<? require('header.php'); ?>
<div id="topo"><?
    if (verifica_permissao('Franquia', $controle_id_departamento_p, $controle_id_departamento_s) == 'FALSE') {
        echo '<br><br><strong>Você não tem permissão para acessar essa página de royalties</strong>';
        exit;
    }
    pt_register('GET', 'mes');
    pt_register('GET', 'ano');
    pt_register('GET', 'id_empresa');
    pt_register('GET', 'pagina');
    if ($mes == '') $mes = date('m');
    if ($ano == '') $ano = date('Y');

    ?>
    <h1 class="tit">
        <img src="../images/tit/tit_rel.png" alt="Título"/>Relatório de Royalties
    </h1>
    <a href="#" class="topo">topo</a>
    <hr class="tit"/>
</div>
<div id="meio">
    <table border="0" height="100%" width="100%">
        <tr>
            <td valign="top">
                <form name="buscador" action="" method="get">
                    <div class="busca1">
                        <label>Mês</label>
                        <select name="mes" class="form_estilo" style="width:200px;">
                            <option value="01" <? if ($mes == '01') echo 'selected="select"'; ?>>Janeiro</option>
                            <option value="02" <? if ($mes == '02') echo 'selected="select"'; ?>>Fevereiro</option>
                            <option value="03" <? if ($mes == '03') echo 'selected="select"'; ?>>Março</option>
                            <option value="04" <? if ($mes == '04') echo 'selected="select"'; ?>>Abril</option>
                            <option value="05" <? if ($mes == '05') echo 'selected="select"'; ?>>Maio</option>
                            <option value="06" <? if ($mes == '06') echo 'selected="select"'; ?>>Junho</option>
                            <option value="07" <? if ($mes == '07') echo 'selected="select"'; ?>>Julho</option>
                            <option value="08" <? if ($mes == '08') echo 'selected="select"'; ?>>Agosto</option>
                            <option value="09" <? if ($mes == '09') echo 'selected="select"'; ?>>Setembro</option>
                            <option value="10" <? if ($mes == '10') echo 'selected="select"'; ?>>Outubro</option>
                            <option value="11" <? if ($mes == '11') echo 'selected="select"'; ?>>Novembro</option>
                            <option value="12" <? if ($mes == '12') echo 'selected="select"'; ?>>Dezembro</option>
                        </select>
                        <label>Ano</label>
                        <select name="ano" class="form_estilo" style="width: 200px;">
                            <option value="2009" <? if ($ano == '2009') echo 'selected="select"'; ?>>2009</option>
                            <option value="2010" <? if ($ano == '2010') echo 'selected="select"'; ?>>2010</option>
                            <option value="2011" <? if ($ano == '2011') echo 'selected="select"'; ?>>2011</option>
                            <option value="2012" <? if ($ano == '2012') echo 'selected="select"'; ?>>2012</option>
                            <option value="2013" <? if ($ano == '2013') echo 'selected="select"'; ?>>2013</option>
                            <option value="2014" <? if ($ano == '2014') echo 'selected="select"'; ?>>2014</option>
                            <option value="2015" <? if ($ano == '2015') echo 'selected="select"'; ?>>2015</option>
                            <option value="2016" <? if ($ano == '2016') echo 'selected="select"'; ?>>2016</option>
                        </select>
                        <? if ($controle_id_empresa == 1) { ?>
                            <label>Franquia</label>
                            <select name="id_empresa" class="form_estilo" style="width:200px;">
                                <option></option>
                                <?
                                $empresaDAO = new EmpresaDAO();
                                $empresas = $empresaDAO->listarTodas();
                                $p_valor = '';
                                foreach ($empresas as $empresa) {
                                    $p_valor .= '<option value="' . $empresa->id_empresa . '" ';
                                    if ($id_empresa == $empresa->id_empresa) $p_valor .= ' selected="select" ';
                                    $p_valor .= '>' . $empresa->fantasia . '</option>';
                                }
                                echo $p_valor;
                                ?>
                            </select> <? } ?>
                        <input type="submit" name="submit" class="button_busca" value=" Buscar "/>
                    </div>
                </form>
            </td>
        </tr>

    </table>
    <?
    #pt_register('GET','submit');

    #if($submit<>''){
    $id_empresa = ($controle_id_empresa != 1) ? $controle_id_empresa : $id_empresa;

    $relatorioDAO = new RelatorioDAO();
    $relatorios = $relatorioDAO->busca_roy($id_empresa, $mes, $ano, $pagina);
    ?>
    <br/>
    <table class="result_tabela" width="100%">
        <tbody>
        <tr>
            <td><? echo $relatorioDAO->QTDPagina(); ?></td>
        </tr>
        <tr>
            <td class="result_menu"><b>Data</b></td>
            <td class="result_menu"><b>Franquia</b></td>
            <td class="result_menu"><b>Royalties</b></td>
            <td class="result_menu"><b>FPP</b></td>
            <td align="center" width="80" class="result_menu"><b>Abrir Boleto</b></td>
        </tr>
        <?
        $p_valor = '';
        foreach ($relatorios as $i => $r) {
            $p_valor .= '<tr>
				<td class="result_celula">' . invert($r->data, '/', 'XP') . '</td>
				<td class="result_celula">' . $r->empresa . '</td>
				<td class="result_celula" align="right">R$ ' . $r->roy . '</td>
				<td class="result_celula" align="right">R$ ' . $r->fpp . '</td>';
            if ($r->id_conta_fatura <> '') {
                if ($r->valor_pago < $r->valor) {
                    $p_valor .= '
						<td align="center" class="result_celula">';

                    if ($r->id_conta == 2) {
                        $p_valor .= '<a href="../boletos/gerabradescobrad.php?id=' . $r->id_conta_fatura . '" target="_blank">';
                    } else {
                        $p_valor .= '<a href="../boletos/boleto_bb.php?id=' . $r->id_conta_fatura . '" target="_blank">';
                    }
                    $p_valor .= '<img border="0" title="Baixar" src="../images/botao_editar.png">
							</a>
						</td>
					';
                } else {
                    $p_valor .= '
						<td align="center" class="result_celula">
							PAGO
						</td>
					';
                }
            } else {
                $p_valor .= '
					<td align="center" class="result_celula">
						-
					</td>
				';
            }
        }
        echo $p_valor;
        ?>
        <tr>
            <td><? echo $relatorioDAO->QTDPagina(); ?></td>
        </tr>
        </tbody>
    </table>
    <? #} ?>
</div>
<?php
require('footer.php');
?>
