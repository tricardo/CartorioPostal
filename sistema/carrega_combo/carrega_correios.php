<?
if ($controle_id_usuario == "") {
    header("Content-Type: text/html; charset=ISO-8859-1", true);
    require( "../includes/funcoes.php" );
    require( "../includes/verifica_logado_controle.inc.php");
    require( "../includes/global.inc.php" );

    $departamento_s = explode(',', $controle_id_departamento_s);
    $departamento_p = explode(',', $controle_id_departamento_p);
    $correioDAO = new CorreioDAO();
}
pt_register('GET', 'id_empresa');
$permissao = verifica_permissao('Franquia', $controle_id_departamento_p, $controle_id_departamento_s);
$id_departamento_p = explode(',', $controle_id_departamento_p);
if ($permissao == 'FALSE' or $controle_id_empresa != '1') {
    echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
    exit;
}
?>
<form action="#aba6" method="post" name="p_financeiro" id="p_financeiro" enctype="multipart/form-data">
    <input type="hidden" name="p_correios" value="1">
    <table width="800" class="tabela">
        <tr>
            <td colspan="4" class="tabela_tit">Fichas dos Correios</td>
        </tr>
        <tr>
            <td width="150">
                <div align="right"><b>Tipo de Ficha:</b></div>
            </td>
            <td width="180">
                <select name="id_fichacorreio" style="width: 150px" class="form_estilo<? if ($errors->id_fichacorreio == 1)
    echo '_erro'; ?>">
                    <option value=""></option>
                    <?
                    $p_valor = "";
                    $lista = $correioDAO->listarTipoFicha();
                    foreach ($lista as $l) {
                        $p_valor .='<option value="' . $l->id_fichacorreio . '" ';
                        if ($id_fichacorreio == $l->id_fichacorreio) $p_valor .= ' selected ';
                        $p_valor .= '>' . $l->fichacorreio . '</option>';
                    }
                    echo $p_valor;
                    ?>
                </select> <font color="#FF0000">*</font>
            </td>
            <td width="100"><div align="right"><strong>Quantidade: </strong></div></td>
            <td>
                <input type="text" class="form_estilo<? if ($errors->quantidade == 1) echo '_erro'; ?>" name="quantidade" value="<?= $quantidade ?>" onkeyup="mascara(this.value,'#####');" style="width: 150px" />
                <font color="#FF0000">*</font>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <center>
                    <input type="submit" class="button_busca" name="submit_correios" value="Cadastrar" />&nbsp; 
                    <input type="submit" name="cancelar" value="Cancelar" class="button_busca" />
                </center>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="tabela_tit">Histórico de Fichas</td>
        </tr>
        <tr>
            <td colspan="4">
                <?
                $p_valor = '
                    <div class="form_estilo_r" style="width:85px; float:left; clear:left; font-weight:bold">Data</div>
                    <div class="form_estilo_r" style="width:85px; float:left; font-weight:bold">Tipo de Ficha</div>
                    <div class="form_estilo_r" style="width:75px; float:left; font-weight:bold">Quantidade</div>';
                $lista = $correioDAO->listarFicha($id_empresa);
                foreach ($lista as $l) {
                    $p_valor .= '
                        <div class="form_estilo_r" style="width:85px; float:left; clear:left">' . invert($l->data, '/', 'PHP') . '</div>
                        <div class="form_estilo_r" style="width:85px; float:left;">' . $l->fichacorreio . '</div>
                        <div class="form_estilo_r" style="width:75px; float:left">' . $l->quantidade . '</div>';
                }
                echo $p_valor;
                ?>
            </td>
        </tr>
    </table>
</form>