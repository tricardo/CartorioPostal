<?
setcookie("des_id_pedido_item", $_COOKIE['p_id_pedido_item']);
setcookie("des_id_pedido", $_COOKIE['p_id_pedido']);

$cont = 0;
$financeiro_divisao = "";
$pedido_valor = "";
$cont_pedidos = "";
$p_id_pedido_item = explode(',', str_replace(',##', '', $_COOKIE['p_id_pedido_item'] . '##'));
$p_id_pedido = explode(',', $_COOKIE['p_id_pedido']);
$ext_num = count($p_id_pedido) - 1;
$cont = 0;
$financeiroDAO = new FinanceiroDAO();

foreach ($p_id_pedido_item as $chave => $id_pedido_item) {
    $valida = valida_numero($id_pedido_item);
    if ($valida != 'TRUE') {
        echo 'Ocorreu um erro ao validar o número dos pedido(s) selecionado(s). O número de um dos pedidos não é válido';
        exit;
    }

    $cont_pedidos++;
    #verifica permissao
    #fim da verificacao permissao


    $pedido_valor .= '
	<tr>
            <td> <div align="right"><strong>Pedido: </strong></div></td>
            <td>
        	' . $p_id_pedido[$cont] . '
	    </td>		  
            <td> <div align="right"><strong>Custas: </strong></div></td>
            <td>
                <input type="text" class="form_estilo" name="financeiro_valor_' . $id_pedido_item . '" id="financeiro_valor_' . $id_pedido_item . '"  onkeyup="moeda(event.keyCode,this.value,\'financeiro_valor_' . $id_pedido_item . '\');"  style="width:150px" /><font color="#FF0000">*</font>
                <img src="../images/forward.png" border="0" onclick="completa_valores(\'pedido_add\',\'financeiro_valor_\',document.pedido_add.financeiro_valor_' . $id_pedido_item . '.value,document.pedido_add.cont_pedidos.value)"/>Formato ####.##
            </td>
        </tr>';
    $financeiro_divisao++;
    $cont++;
}
#alteração de status
?>
<form enctype="multipart/form-data" action="" method="post" name="pedido_add"><input type="hidden" name="financeiro_divisao"  value="<?= $financeiro_divisao ?>">
    <table width="800" cellpadding="4" cellspacing="1" class="result_tabela">
        <tr>
            <td colspan="4" class="tabela_tit">Solicitar Desembolso</td>
        </tr>
        <tr>
            <td width="150">
                <div align="right"><b>Forma:</b></div>
            </td>
            <td colspan="3">
                <select name="financeiro_forma" style="width: 150px" class="form_estilo<? if ($errors->financeiro_forma == 1)
    echo '_erro'; ?>">
                    <option value=""></option>
                    <?
                    $p_valor = "";
                    $fin = $financeiroDAO->listarForma();
                    foreach ($fin as $f) {
                        $p_valor .='<option value="' . $f->forma_2 . '" ';
                        if ($financeiro_forma == $f->forma_2)
                            $p_valor .= ' selected ';
                        $p_valor .='>' . $f->forma . '</option>';
                    }
                    echo $p_valor;
                    ?>
                </select> <font color="#FF0000">*</font></td>
        </tr>
        <tr>
            <td width="150">
                <div align="right"><strong>Classificação: </strong></div>
            </td>
            <td colspan="3">
                <select name="financeiro_classificacao" style="width: 490px" class="form_estilo">
                    <?
                    $lista = $financeiroDAO->listarClassificacao();
                    foreach($lista as $l) {
                        echo '<option value="' . $l->id_classificacao . '" >' . $l->classificacao . '</option>';
                    }
                    ?>
                </select><font color="#FF0000">*</font>
            </td>
        </tr>
        <tr>
            <td width="150">
                <div align="right"><strong>Banco: </strong></div>
            </td>
            <td colspan="3">
                <select name="financeiro_banco" style="width: 490px" class="form_estilo">
                    <option value=""></option>
                    <?
                    $bancoDAO = new BancoDAO();
                    $lista = $bancoDAO->listar();
                    foreach($lista as $l) {
                        echo '<option value="' . $l->id_banco . '" >' . $l->banco . '</option>';
                    }
                    ?>
                </select></td>
        </tr>

        <tr>
            <td width="150">
                <div align="right"><strong>Agência: </strong></div>
            </td>
            <td><input type="text" class="form_estilo" name="financeiro_agencia"
                       style="width: 150px" /></td>
            <td>
                <div align="right"><b>Conta:</b></div>
            </td>
            <td><input type="text" class="form_estilo" name="financeiro_conta"
                       style="width: 150px" /></td>
        </tr>

        <tr>
            <td width="150">
                <div align="right"><strong>Identificação: </strong></div>
            </td>
            <td><input type="text" class="form_estilo"
                       name="financeiro_identificacao" style="width: 150px" /></td>
            <td>
                <div align="right"><b>CPF/CNPJ:</b></div>
            </td>
            <td><input type="text" class="form_estilo" name="financeiro_cpf"
                       style="width: 150px" /></td>
        </tr>

        <tr>
            <td width="150">
                <div align="right"><strong>Favorecido: </strong></div>
            </td>
            <td colspan="3"><input type="text" class="form_estilo"
                                   name="financeiro_favorecido" style="width: 490px" /></td>

        </tr>

        <tr>
            <td width="150">
                <div align="right"><strong>Descrição: </strong></div>
            </td>
            <td colspan="3"><input type="text" class="form_estilo"
                                   name="financeiro_descricao" style="width: 490px" /><font
                                   color="#FF0000">*</font> <input type="hidden" name="cont_pedidos"
                                   value="<?= $cont_pedidos ?>" /></td>

        </tr>
        <?= $acao_itens ?>
        <?= $pedido_valor ?>
        <tr>
            <td></td>
            <td></td>
            <td>
                <div align="right"><strong>Honorários: </strong></div>
            </td>
            <td><input type="text" class="form_estilo" name="financeiro_rateio"
                       id="financeiro_rateio"
                       onkeyup="moeda(event.keyCode,this.value,'financeiro_rateio');"
                       style="width: 150px" /> Formato ####.##</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <div align="right"><strong>Correio: </strong></div>
            </td>
            <td><input type="text" class="form_estilo" name="financeiro_sedex"
                       id="financeiro_sedex"
                       onkeyup="moeda(event.keyCode,this.value,'financeiro_sedex');"
                       style="width: 150px" /> Formato ####.##</td>
        </tr>
        <tr>
            <td colspan="4">
        <center><input type="submit" class="button_busca"
                       name="submit_financeiro" value="Solicitar" />&nbsp; <input
                       type="submit" name="cancelar" value="Cancelar"
                       onclick="document.pedido_add.action='pedido.php'"
                       class="button_busca" /></center>

        </td>

        </tr>
    </table>
    <div id="completa_valor"></div>
</form>
</td>
</tr>
</table>
</div>
<?
require('footer.php');
exit;
?>