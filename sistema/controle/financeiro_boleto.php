<?
require('header.php');

$permissao = verifica_permissao('Financeiro', $controle_id_departamento_p, $controle_id_departamento_s);
$contaDAO = new ContaDAO();
$empresaDAO = new EmpresaDAO();

if ($permissao == 'FALSE') {
    echo '<br><br><strong>Você não tem permissao para acessar essa página</strong>';
    exit;
}
pt_register('GET', 'submit');
if ($submit <> '') {
    pt_register('GET', 'busca_id_fatura');
    pt_register('GET', 'busca_id_conta_fatura');
    pt_register('GET', 'busca_id_empresa');
    pt_register('GET', 'busca_id_ocorrencia');
    pt_register('GET', 'busca');
    pt_register('GET', 'busca_vencimento_i');
    pt_register('GET', 'busca_vencimento_f');
    $_SESSION['fb_id_ocorrencia'] = $busca_id_ocorrencia;
    $_SESSION['fb_busca_vencimento_i'] = $busca_vencimento_i;
    $_SESSION['fb_busca_vencimento_f'] = $busca_vencimento_f;
} else {
    $busca_id_ocorrencia = $_SESSION['fb_busca_id_ocorrencia'];
    $busca_vencimento_i = $_SESSION['fb_busca_vencimento_i'];
    $busca_vencimento_f = $_SESSION['fb_busca_vencimento_f'];
}

if ($busca_vencimento_i <> '')
    $busca_vencimento_ib = invert($busca_vencimento_i, '-', 'SQL');
else
    $busca_vencimento_ib = '';

if ($busca_vencimento_f <> '')
    $busca_vencimento_fb = invert($busca_vencimento_f, '-', 'SQL');
else
    $busca_vencimento_fb = '';

$b = new stdClass();
$b->busca = $busca;
$b->busca_id_empresa = $busca_id_empresa;
$b->busca_id_fatura = $busca_id_fatura;
$b->busca_id_ocorrencia = $busca_id_ocorrencia;
$b->busca_vencimento_i = $busca_vencimento_ib;
$b->busca_vencimento_f = $busca_vencimento_fb;
$b->busca_id_conta_fatura = $busca_id_conta_fatura;
$b->busca = $busca;
?>
<div id="topo">
    <h1>
        <img src="../images/tit/tit_recebimento.png" alt="TÍtulo"/>
        Contas à Receber &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="financeiro_boleto_remessa.php">Arquivos de Remessa</a>
    </h1>
    <a href="#" class="topo">topo</a>
    <hr class="tit"/>
</div>
<div id="meio">
    <form name="f1" action="" method="GET" ENCTYPE="multipart/form-data">
        <div class="busca1">
            <label>Buscar:</label>
            <input type="text" class="form_estilo" name="busca" value="<?= $busca ?>" style="width:200px"/>
            <label>Fatura:</label>
            <input type="text" class="form_estilo" name="busca_id_fatura" value="<?= $busca_id_fatura ?>"
                   style="width:200px"/>
            <label>ID:</label>
            <input type="text" class="form_estilo" name="busca_id_conta_fatura" value="<?= $busca_id_conta_fatura ?>"
                   style="width:200px"/>
            <label>Venc. Entre: </label>
            <input type="text" name="busca_vencimento_i" value="<?= $busca_vencimento_i ?>"
                   style="width: 95px; float: left" class="form_estilo"/>
            <strong style="width: 10px; font-weight: bold; padding-top: 5px; float: left">e</strong>
            <input type="text" name="busca_vencimento_f" value="<?= $busca_vencimento_f ?>"
                   style="width: 90px; float: left" class="form_estilo"/>

            <label>Situação: </label>
            <select name="busca_id_ocorrencia" style="width: 200px;" class="form_estilo">
                <option value="" <? if ($busca_id_ocorrencia == '')
                    echo ' selected="selected" '; ?>>Todos
                </option>
                <option value="1" <? if ($busca_id_ocorrencia == '1')
                    echo ' selected="selected" '; ?>>Pago
                </option>
                <option value="2" <? if ($busca_id_ocorrencia == '2')
                    echo ' selected="selected" '; ?>>Em Aberto
                </option>
                <option value="3" <? if ($busca_id_ocorrencia == '3')
                    echo ' selected="selected" '; ?>>Titulos com Erro
                </option>
                <option value="4" <? if ($busca_id_ocorrencia == '4')
                    echo ' selected="selected" '; ?>>Títulos Baixados
                </option>
            </select>
            <? if ($controle_id_empresa == 1) { ?>
                <label>Tipo de Busca: </label>
                <select name="busca_id_empresa" style="width:200px" class="form_estilo">
                    <option value="" <? if ($busca_id_empresa == '')
                        echo ' selected="selected" '; ?>>Todos
                    </option>
                    <option value="P" <? if ($busca_id_empresa == 'P')
                        echo ' selected="selected" '; ?>>Somente Pedidos
                    </option>
                    <option value="_" <? if ($busca_id_empresa == '_')
                        echo ' selected="selected" '; ?>>Somente Royalties
                    </option>
                    <?
                    $p_valor = '';
                    #$var = $empresaDAO->listarTodasN($controle_id_empresa);
                    $var = $empresaDAO->listarTodasFranquias();
                    foreach ($var as $s) {
                        $p_valor .= '<option value="' . $s->id_empresa . '"';
                        if ($busca_id_empresa == $s->id_empresa)
                            $p_valor .= ' selected="selected" ';
                        $p_valor .= ' >' . str_replace('Cartório Postal - ', '', $s->fantasia) . '</option>';
                    }
                    echo $p_valor;
                    ?>
                </select>
            <? } ?>
            <input type="submit" onclick="document.f1.target='_self'; document.f1.action=''" name="submit"
                   class="button_busca" value=" Buscar "/>
            <input type="submit" name="submit_exporta"
                   onclick="document.f1.target='_blank'; document.f1.action='gera_exporta_btto.php'"
                   class="button_busca" value=" Exportar Todos "/>
        </div>
    </form>
    <br/>

    <div style="clear: both"><br/>
        <a href="financeiro_boleto_add.php"><h3><img src="../images/botao_add.png" border="0"/> Adicionar novo registro
            </h3><br></a>
    </div>
    <?php
    $b->busca = $busca;
    pt_register('GET', 'pagina');
    $lista = $contaDAO->listaBoletos($b, $controle_id_empresa, $pagina);
    $p_valor = "";
    echo '<b>Valor Total: </b> R$ ' . $lista[0]->valor_t . ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<b>Valor Recebido:</b> R$ ' . $lista[0]->valor_rec_t;
    ?>
    <table width="100%" cellpadding="4" cellspacing="1" class="result_tabela">
        <tr>
            <td colspan="9" class="barra_busca">
                <?php $contaDAO->QTDPagina(); ?>
            </td>
        </tr>
        <tr>
            <td align="center" width="40" class="result_menu"><b>Editar</b></td>
            <td class="result_menu" width="40"><b>ID</b></td>
            <td class="result_menu" width="40"><b>Fatura</b></td>
            <td class="result_menu"><b>Sacado</b></td>
            <td class="result_menu" width="40"><b>Vencimento</b></td>
            <td class="result_menu" width="70" align="right"><b>Valor</b></td>
            <td class="result_menu" width="70" align="right"><b>Valor Rec.</b></td>
            <td class="result_menu" width="90"><b>Status</b></td>
        </tr>
        <?
        $p_valor = '';
        if ($lista[0]->id_conta_fatura <> '') {
            foreach ($lista as $p) {
                if ($p->status == 0)
                    $status = 'Não Registrado'; else
                    $status = 'Registrado';
                if ($p->fantasia <> '')
                    $fantasia = '(' . $p->fantasia . ') '; else
                    $fantasia = '';
                $p_valor .= '<tr>
                        <td class="result_celula" align="center"><a href="financeiro_boleto_edit.php?id=' . $p->id_conta_fatura . '"><img src="../images/botao_editar.png" title="Editar" border="0"/></a></td>								
                        <td class="result_celula">' . $p->id_conta_fatura . '</td>								
                        <td class="result_celula">' . $p->id_fatura . '</td>								
                        <td class="result_celula">' . $fantasia . $p->sacado . '</td>								
                        <td class="result_celula">' . invert($p->vencimento, '/', 'PHP') . '</td>								
                        <td class="result_celula ' . $classe . '" align="right">R$ ' . $p->valor . '</td>								
                        <td class="result_celula ' . $classe . '" align="right">R$ ' . $p->valor_pago . '</td>';
                if ($p->id_conta == 2) {
                    $p_valor .= '<td class="result_celula ' . $classe . '" align="right"><a href="../boletos/gerabradescobrad.php?id=' . $p->id_conta_fatura . '" target="blank">' . $status . '</td>';
                } else {
                    $p_valor .= '<td class="result_celula ' . $classe . '" align="right"><a href="../boletos/boleto_bb.php?id=' . $p->id_conta_fatura . '" target="blank">' . $status . '</td>';
                }
                $p_valor .= '</tr>';
            }
        }
        echo $p_valor;
        ?>
        <tr>
            <td colspan="9" class="barra_busca">
                <?php $contaDAO->QTDPagina(); ?>
            </td>
        </tr>
    </table>
</div>
<?php require('footer.php'); ?>
