<?
if ($controle_id_usuario == "") {
    header("Content-Type: text/html; charset=ISO-8859-1", true);
    require( "../includes/verifica_logado_ajax.inc.php");
    require( "../includes/funcoes.php" );
    require( "../includes/global.inc.php" );
    pt_register('GET', 'id_pedido');
    pt_register('GET', 'ordem');
    $pedidoDAO = new PedidoDAO();
    $servicosDAO = new ServicoDAO();
    $servicocampos = $servicosDAO->listaCampos($p->id_servico);
    #seleciona dados do pedido
    foreach ($servicocampos as $servicocampo) {
        $p_campos.= ','.$servicocampo->campo;
    }
    $p = $pedidoDAO->selectPedidoEditPorIdNovo($id_pedido, $ordem, $controle_id_empresa,$p_campos);    
    $id_pedido_item = $p->id_pedido_item;
    if ($id_pedido_item == '') {
        echo 'Você não tem permissão de alterar esse pedido';
        exit;
    }
    $departamento_s = explode(',', $controle_id_departamento_s);
    $departamento_p = explode(',', $controle_id_departamento_p);
}
$mensagemDAO = new MensagemDAO();
$servicovars = $servicosDAO->listaVariacao($p->id_servico);
if (in_array('2', $departamento_s) == 1 or in_array('1', $departamento_s) == 1 or in_array('9', $departamento_p) == 1 or (in_array('6', $departamento_p) == 1 and ($p->id_status == '1' or $p->id_status == '2' or $p->id_status == '3' or $p->id_status == '12'))) {
    $permissao_alterar = 'class="form_estilo"';
} else {
    $permissao_alterar = 'class="form_estilo_r" readonly="readonly"';
}
?>
<form action="#aba0" method="post" name="pedido_add"
      enctype="multipart/form-data">
    <table width="800" class="tabela">
        <tr>
            <td colspan="4" class="tabela_tit">
                Serviços
                <span class="formInfo"><a href="../help/pedido_edit_1.php?width=500" class="jTip" id="help_serv" name="Ajuda - Dados do Serviço:">?</a></span>
            </td>
        </tr>
        <tr>
            <td width="150">
                <div align="right"><strong>Dias: </strong></div>
            </td>
            <td colspan="3">
                <div style="float: left;">
                    <input type="text" name="dias" style="width: 80px" value="<?= $p->dias ?>" class="form_estilo" onKeyUp="masc_numeros(this,'###');" /> 
                    <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valor:</strong>
                    <input type="hidden" name="id_servico" value="<?= $p->id_servico ?>" />
                    <input type="hidden" name="old_valor" value="<?= $p->valor ?>" />
                    <input type="hidden" name="id_fatura" value="<?= $p->id_fatura ?>" />
                    <input type="text" name="valor" style="width: 100px" value="<?= $p->valor ?>" id="valor" <?= ($p->id_fatura != "") ? 'readonly="readonly"' : '' ?> onkeyup="moeda(event.keyCode,this.value,'valor');"
                           <?= $permissao_alterar ?> /> Formato ####.## &nbsp;&nbsp;&nbsp;
                </div>
                <div style="width: 150px; float: left" class="form_estilo">
                    <input type="checkbox" <? if ($p->urgente == 'on')
                               echo 'checked="checked"'; ?> name="urgente" /> 
                    <strong>Urgente</strong>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="tabela_tit">Dados da Expedição do Documento</td>
        </tr>
        <tr>
            <td width="150">
                <div align="right"><strong>Departamento: </strong></div>
            </td>
            <td colspan="3">
                <input type="text" name="departamento" readonly="readonly" value="<?= $p->departamento ?>" style="width: 500px" class="form_estilo_r" />
            </td>
        </tr>
        <tr>
            <td>
                <div align="right"><strong>Serviço: </strong></div>
            </td>
            <td colspan="3">
                <input type="text" name="servico" readonly="readonly"  value="<?= $p->servico ?>" style="width: 500px" class="form_estilo_r" />
            </td>
        </tr>
        <tr>
            <td>
                <div align="right"><strong>Variação: </strong></div>
            </td>
            <td colspan="3">
                <? if (in_array(6, $departamento_s) == 1) { ?> 
                    <select name="id_servico_var" style="width: 500px" class="form_estilo">
                        <?
                        $p_valor = '<option value="' . $p->id_servico_var . '">' . $p->variacao . '</option>';
                        foreach ($servicovars as $servicovar) {
                            $p_valor .= '<option value="' . $servicovar->id_servico_var . '">' . $servicovar->variacao . '</option>';
                        }
                        echo $p_valor;
                        ?>
                    </select> 
                <? } else { ?>
                    <input type="text" name="servico_var" readonly="readonly" value="<?= $p->variacao ?>" style="width: 500px" class="form_estilo_r" /> 
                    <input type="hidden" name="id_servico_var" value="<?= $p->id_servico_var ?>" /> <? } ?> <font color="#FF0000">*</font>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="tabela_tit">Dados do Documento</td>
        </tr>
        <?
        $p_valor = "";
        foreach ($servicocampos as $servicocampo) {

            $p_valor .= '<tr>
              <td width="150"> 
                <div align="right"><strong>' . $servicocampo->nome . ': </strong></div>
              </td>
              <td colspan="3" width="543">';
            if ($servicocampo->campo != 'certidao_estado' and $servicocampo->campo != 'certidao_cidade') {
                $p_valor .= '<input type="' . $servicocampo->tipo . '" name="' . $servicocampo->campo . '" value="' . $p->{$servicocampo->campo} . '" style="width:500px"';
                if ($servicocampo->mascara <> '') {
                    $p_valor .= ' onKeyUp="masc_numeros(this,\'' . $servicocampo->mascara . '\');"';
                }
                $p_valor .= ' class="form_estilo'.(($errors2[$servicocampo->campo])?' form_estilo_erro':'').'"/>';
            } else {
                if ($servicocampo->campo == 'certidao_estado')
                    $java_script = ' onchange="carrega_cidade2(this.value);" ';
                else
                if ($servicocampo->campo == 'certidao_cidade')
                    $java_script = ' onfocus="carrega_cidade3(certidao_estado.value,this.value);" id="carrega_cidade_campo" ';
                else
                    $java_script = '';

                $p_valor .= '<select name="' . $servicocampo->campo . '" style="width:500px" ' . $java_script . ' class="form_estilo'.(($errors2[$servicocampo->campo])?' form_estilo_erro':'').'">
                    <option value="' . $p->{$servicocampo->campo} . '">' . $p->{$servicocampo->campo} . '</option>';

                if ($p->{$servicocampo->campo} <> '') {
                    $p_valor .= '<option value=""></option>';
                }
                if ($servicocampo->campo == 'certidao_estado') {
                    $servicocampo_sel = $servicosDAO->listaEstados();
                    foreach ($servicocampo_sel as $scs) {
                        $p_valor .= '<option value="' . $scs->estado . '">' . $scs->estado . '</option>';
                    }
                }
                $p_valor .= '</select>';
            }
            $p_valor .= ($servicocampo->obrigatorio) ? '<font color="#F00">*</font>' : '';
            $p_valor .= ' </td>
            </tr>';
            $cont++;
        }
        echo $p_valor;
        ?>
        <tr>
            <td width="150">
                <div align="right"><strong>CONTROLE DO CLIENTE: </strong></div>
            </td>
            <td colspan="3">
                <input type="text" name="controle_cliente" value="<?= $p->controle_cliente ?>" style="width: 500px" class="form_estilo" />
            </td>
        </tr>
        <tr>
            <td colspan="4" class="tabela_tit">Dados do Operacional</td>
        </tr>
        <tr>
            <td width="150" valign="top">
                <div align="right"><strong>Custas do Serviço: </strong></div>
            </td>
            <td colspan="3" align="left">
                <input type="text" name="custas" value="<?= $p->custas ?>" style="width: 500px" maxlength="100" class="form_estilo" />
            </td>
        </tr>
        <tr>
            <td width="150" valign="top">
                <div align="right"><strong>Resultado: </strong></div>
            </td>
            <td colspan="3" align="left">
                <input type="text" name="certidao_resultado" value="<?= $p->certidao_resultado ?>" style="width: 396px" maxlength="100" class="form_estilo" />
                <?php
                if ($p->id_servico_departamento == 7) {
                    echo '<input type="button" name="submit_imoveis_busca" value="Busca Imóveis" class="button_busca"
        		onclick="eraseCookie(\'p_id_pedido\');
                        eraseCookie(\'imoveis_d_id_pedido_item\');
                        eraseCookie(\'p_id_pedido_item\');
                        createCookie(\'p_id_pedido_item\',\'' . $p->id_pedido_item . ',\',\'1\',\'1\');
                        createCookie(\'p_id_pedido\',\'#' . $p->id_pedido . '/' . $p->ordem . ',\',\'1\',\'1\');
                        document.f1.submit();
                        "/>';
                } elseif ($p->id_servico_departamento == 8) {
                    echo '<input type="button" name="submit_protesto_busca" value="Busca Detran" class="button_busca"
                        onclick="eraseCookie(\'p_id_pedido\');
                        eraseCookie(\'imoveis_d_id_pedido_item\');
                        eraseCookie(\'p_id_pedido_item\');
                        createCookie(\'p_id_pedido_item\',\'' . $p->id_pedido_item . ',\',\'1\',\'1\');
                        createCookie(\'p_id_pedido\',\'#' . $p->id_pedido . '/' . $p->ordem . ',\',\'1\',\'1\');
                        document.f2.submit();
                        "/>';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td width="150" valign="top">
                <div align="right"><strong>Motivo de Atraso: </strong></div>
            </td>
            <td colspan="3" align="left">
                <input type="text" name="motivo_atraso" value="<?= $p->motivo_atraso ?>" style="width: 500px" maxlength="255" class="form_estilo" />
            </td>
        </tr>
        <tr>
            <td colspan="4" class="tabela_tit">Observações</td>
        </tr>
        <tr>
            <td width="150" valign="top">
                <div align="right"><strong>Obs: </strong></div>
            </td>
            <td colspan="3" align="left">
                <textarea name="obs" class="form_estilo" style="width: 500px; height: 100px"><?= $p->obs; ?></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <div align="center">
                    <input type="hidden" name="ocor" value="<?= $p->ocor ?>" /> 
                    <input type="hidden" name="regi" value="<?= $p->regi ?>" /> 
                    <input type="submit" name="submit_servico" value="Atualizar" class="button_busca" />
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="tabela_tit">Mensagens da Solicitação</td>
        </tr>
        <tr>
            <td colspan="4">
                <?
                $p_valor = '
                    <div class="form_estilo_r" style="width:150px; font-weight:bold; float:left">Data</div>
                    <div class="form_estilo_r" style="width:280px; font-weight:bold; float:left">De</div>
                    <div class="form_estilo_r" style="width:280px; font-weight:bold; float:left">Para</div>';

                $mensagem = $mensagemDAO->listaMensagemPedido($id_pedido_item);
                foreach ($mensagem as $m) {
                    if ($m->situacao != 'Sim')
                        $situacao = 'form_estilo_nlido';
                    else
                        $situacao = 'form_estilo_lido';
                    $p_valor .= '
                        <div class="' . $situacao . '" style="width:150px; font-weight:bold; float:left">' . invert($m->data, '/', 'PHP') . ' ' . substr($m->data, 11, 8) . '</div>
                        <div class="' . $situacao . '" style="width:280px; font-weight:bold; float:left">' . $m->de . '</div>
                        <div class="' . $situacao . '" style="width:280px; font-weight:bold; float:left">' . $m->para . '</div>
                        <input type="button" name="Ler_' . $m->id_mensagem . '" value="Ler" onclick="carrega_mensagem(\'' . $m->id_mensagem . '\'); $(\'#windowMensagem\').show();" class="button_busca" style="width:35px; float:left;" >';
                }
                echo $p_valor;
                ?>
            </td>
        </tr>
    </table>
</form>
<form name="f1" action="pedido.php" method="post" ENCTYPE="multipart/form-data">
    <input type="hidden" name="submit_imoveis_busca" value="Busca Imóveis"/>
</form>
<form name="f2" action="pedido.php" method="post" ENCTYPE="multipart/form-data">
    <input type="hidden" name="submit_processos" value="Busca Detran"/>
</form>