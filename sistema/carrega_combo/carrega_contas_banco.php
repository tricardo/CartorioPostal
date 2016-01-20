<?
/**
 * Created by PhpStorm.
 * User: Thauan
 * Date: 15/01/2016
 * Time: 08:23
 */

require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

pt_register('GET','id_empresa');
pt_register('GET','id_royalties');

$contaDAO = new ContaDAO();

?>

<form action="" method="post" name="p_financeiro" id="p_financeiro" enctype="multipart/form-data">
    <table width="300" class="tabela">
        <tr>
            <td colspan="2" class="tabela_tit">Emissão de Boleto</td>
        </tr>
        <tr>
            <td>
                <div align="right"><b>Banco:</b></div>
            </td>
            <td>
                <select name="id_conta" id="id_conta"  class="form_estilo<? if($errors['id_conta']==1) echo '_erro' ?>" style=" width:150px; ">
                    <option value="">Selecione</option>
                    <?
                    $lista = $contaDAO->listarContaBoleto($controle_id_empresa);
                    $p_valor = '';
                    foreach($lista as $l){
                        $p_valor .= '<option value="'.$l->id_conta.'"';
                        if($l->id_conta==$id_conta) $p_valor .= 'selected="select"';
                        $p_valor .= '>'.$l->sigla.'</option>';
                    }
                    echo $p_valor;
                    ?>
                </select>
                <font color="#FF0000">*</font>
            </td>
        </tr>
        <tr>
            <td>
                <div align="right"><b>Vencimento:</b></div>
            </td>
            <td>
                <input type="text" id="vencimento" maxlength="10" name="vencimento" value=""  onKeyUp="masc_numeros(this,'##/##/####');" class="form_estilo" style=" width:110px; " />
                <font color="#FF0000">*</font>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <center>
                    <input type="submit" class="button_busca" name="submit_emite_boleto" value="Emitir"/>&nbsp;
                    <input type="submit" name="cancelar" value="Cancelar" class="button_busca"/>
                </center>
            </td>
        </tr>
    </table>
    <input  type="hidden" name="id_royalties" value="<? echo $id_royalties; ?>" />
    <input  type="hidden" name="id_empresa" value="<? echo $id_empresa; ?>" />
</form>
