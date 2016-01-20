<?
setcookie("imoveis_id_pedido_item", $_COOKIE['p_id_pedido_item']);
setcookie("imoveis_id_pedido", $_COOKIE['p_id_pedido']);

$ext = explode(',', $_COOKIE['p_id_pedido']);
$ext_num = count($ext) - 1;
?>

<form enctype="multipart/form-data" action="gera_oficio.php" method="post" name="pedido_print" target="_blank">
    <center>
        <table width="650" class="tabela">
            <tr>
                <td colspan="4" class="tabela_tit"> Ordens Selecionadas</td>
            </tr>
            <tr>
                <td colspan="4">
                    <?= str_replace(',', ' - ', $_COOKIE['p_id_pedido']); ?>
                    <br><br><b>Foram selecionados <?= $ext_num ?> pedidos.</b>				  
                </td>
            </tr>

            <tr>
                <td colspan="4" class="tabela_tit"> Selecione o Modelo da Impress&atilde;o</td>
            </tr>

            <tr>
                <td width="100"> <div align="right"><strong>Modelo: </strong></div></td>
                <td width="313" colspan="3">
                    <input type="hidden" name="id_pedido" value="<?= $id ?>" />
                    <input type="hidden" name="id_pedido_item" value="<?= $id_pedido_item ?>" />


                    <select name="tipo_impresso" style="width:470px" onchange="carrega_cartorio_texto(this.value);" class="form_estilo">
                        <option value=""></option>
                        <?
                        $impressoDAO = new ImpressoDAO();
                        $lista = $impressoDAO->buscaPorDpto('Imóveis');
                        foreach($lista as $l){
                            echo '<option value="' . $l->tipo_impresso . '">' . $l->tipo_impresso . '</option>';
                        }
                        ?>
                    </select></td></tr>
            <tr>
                <td colspan="4" class="tabela_tit"> Cart&oacute;rio</td>
            </tr>
            <tr>
                <td width="100"> <div align="right"><strong>Atribui&ccedil;&atilde;o: </strong></div></td>
                <td colspan="3">
                    <select name="cartorio_atribuicao" style="width:150px" class="form_estilo">
                        <?
                        $cartorioDAO = new CartorioDAO();
                        $lista = $cartorioDAO->listaAtribuicoes();
                        foreach($lista as $l) {
                            echo '<option value="' . $l->id_atribuicao . '" >' . $l->atribuicao . '</option>';
                        }
                        ?>	
                    </select>

                    <strong>Estado: </strong>

                    <select name="cartorio_estado" style="width:150px" class="form_estilo" onchange="carrega_cartorio_cidade(this.value,cartorio_atribuicao.value)">
                        <option value=""></option>
                        <?
                        $lista = $cartorioDAO->listaEstados();
                        foreach($lista as $l){
                            echo '<option value="' . $l->estado . '" >' . $l->estado . '</option>';
                        }
                        ?>	
                    </select>
                </td>
            </tr>
            <tr>
                <td width="100"> <div align="right"><strong>Cidade: </strong></div></td>
                <td colspan="3">
                    <select name="cartorio_cidade" id="cartorio_cidade" style="width:470px" class="form_estilo" onchange="carrega_cartorio_impressao(cartorio_estado.value,cartorio_atribuicao.value,this.value)">
                    </select>
                    <font color="#FF0000">*</font></td>
            </tr>
            <tr>
                <td width="100"> <div align="right"><strong>Cartório: </strong></div></td>
                <td colspan="3">
                    <select multiple name="cartorio[]" id="cartorio_impressao" style="width:470px; height:200px;" class="form_estilo">
                    </select><font color="#FF0000">*</font>
                </td>
            </tr>

            <tr>
                <td colspan="4" align="center">
                    <input type="submit" name="submit" value="Imprimir" class="button_busca" />&nbsp; <input type="submit" name="cancelar" value="Cancelar" onclick="document.pedido_print.target='_self'; document.pedido_print.action='pedido.php'" class="button_busca" /></td></tr>
        </table>
    </center>
</form>
</td>
</tr>
</table>  
</div>
<?
#fim da alteração de status
require('footer.php');
exit;
?>