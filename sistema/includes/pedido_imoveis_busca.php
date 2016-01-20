<?
setcookie("imoveis_d_id_pedido_item", $_COOKIE['p_id_pedido_item']);
setcookie("imoveis_d_id_pedido", $_COOKIE['p_id_pedido']);

$ext = explode(',', $_COOKIE['p_id_pedido']);
$ext_num = count($ext) - 1;
?>

<form enctype="multipart/form-data" action="gera_imoveis_busca.php" method="post" name="pedido_print" target="_blank">
    <center>
        <table width="650" class="tabela">
            <tr>
                <td colspan="4" class="tabela_tit">Ordens Selecionadas</td>
            </tr>
            <tr>
                <td colspan="4"><?= str_replace(',', ' - ', $_COOKIE['p_id_pedido']); ?>
                    <br>
                    <br>
                    <b>Foram selecionados <?= $ext_num ?> pedidos.</b>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="tabela_tit">Selecione o Modelo de Protocolo</td>
            </tr>

            <tr>
                <td width="100">
                    <div align="right"><strong>Modelo: </strong></div>
                </td>
                <td width="313" colspan="3">
                    <select name="id_impresso" style="width: 470px" class="form_estilo" onchange="carrega_imoveis_busca(this.value)">
                        <?
                        $impressoDAO = new ImpressoDAO();
                        $lista = $impressoDAO->buscaPorDpto('Imóveis Pe');
                        foreach ($lista as $l) {
                            echo '<option value="' . $l->id_impresso . '">' . $l->tipo_impresso . '</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td width="100">
                    <div align="right"><strong>Obs: </strong></div>	
                </td>
                <td width="313" colspan="3">
                    <input type="text" name="obs" style="width: 470px" class="form_estilo"/>
                </td>
            </tr>
        </table>
        <div id="carrega_imoveis_busca"></div>
        <table width="650" class="tabela">
            <tr>
                <td width="100">
                    <div align="right"></div>
                </td>
                <td width="313" colspan="3"><input type="radio" name="anexar" value=""
                                                   checked="checked"> <strong>Apenas gerar o arquivo para download</strong>
                    <input type="radio" name="anexar" value="on"> <strong>Gerar arquivo e
                        anexar</strong></td>
            </tr>
            <tr>
                <td colspan="4" align="center">
                    <input type="submit" name="submit" value="Imprimir" class="button_busca" />&nbsp; 
                    <input type="submit" name="cancelar" value="Cancelar" onclick="document.pedido_print.target='_self'; document.pedido_print.action='pedido.php'" class="button_busca" />
                </td>
            </tr>
        </table>
    </center>
</form>
</td>
</tr>
</table>
<script>
    carrega_imoveis_busca("33");
</script>
</div>
<?
#fim da alteração de status
require('footer.php');
exit;
?>