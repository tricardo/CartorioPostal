<?
setcookie("2via_id_pedido_item", $_COOKIE['p_id_pedido_item']);
setcookie("2via_id_pedido", $_COOKIE['p_id_pedido']);

$p_id_pedido_item = explode(',', str_replace(',##', '', $_COOKIE['p_id_pedido_item'] . '##'));
$ext_num = count($p_id_pedido_item);

#verifica permissão
$cc = '';
foreach ($p_id_pedido_item as $chave => $id_pedido_item) {
    $valida = valida_numero($id_pedido_item);
    if ($valida != 'TRUE') {
        echo 'Ocorreu um erro ao validar o número dos pedido(s) selecionado(s). O número de um dos pedidos não é válido';
        exit;
    }

    if ($cc >= 1) {
        $busca_cartorios_itens .= " or pc.id_pedido_item='" . $id_pedido_item . "' ";
        $cc++;
    } else {
        $busca_cartorios_itens .= " and (pc.id_pedido_item='" . $id_pedido_item . "' ";
        $cc++;
    }
    $cont++;
}
$busca_cartorios_itens .= ')';
?>

<form enctype="multipart/form-data" action="gera_2via.php" method="post" name="pedido_print" target="_blank">
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
                <td width="100"> <div align="right"><strong>Forma de Pagamento: </strong></div></td>
                <td width="313" colspan="3">
                    <input type="hidden" name="id_pedido" value="<?= $id ?>" />
                    <input type="hidden" name="id_pedido_item" value="<?= $id_pedido_item ?>" />

                    <input type="text" name="valor1" style="width:470px" class="form_estilo">



                </td></tr>

            <tr>
                <td width="100"> <div align="right"><strong>Valor: </strong></div></td>
                <td width="313" colspan="3">

                    <input type="text" name="valor2" style="width:470px" class="form_estilo">



                </td></tr>
            <tr>
                <td width="100"> <div align="right"><strong>Prazo: </strong></div></td>
                <td width="313" colspan="3">

                    <input type="text" name="valor3" style="width:470px" class="form_estilo">



                </td></tr>

            <tr>
                <td width="100"> <div align="right"><strong>Cartório: </strong></div></td>
                <td width="313" colspan="3">
                    <select name="id_cartorio" class="form_estilo">
                        <?
                        $cartorioDAO = new CartorioDAO();
                        $lista = $cartorioDAO->selectCartorio2Via($busca_cartorios_itens);
                        foreach($lista as $l){
                            echo '<option value="' . $l->cartorio_cartorio . '">' . $l->nome . '</option>';
                        }
                        ?>
                    </select>
                </td>
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
</div>
<?
#fim da alteração de status
require('footer.php');
exit;
?>