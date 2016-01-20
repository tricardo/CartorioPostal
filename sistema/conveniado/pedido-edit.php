<?
header("Content-Type: text/html; charset=ISO-8859-1", true);
include_once( "../includes/verifica_logado_conveniado.inc.php" );
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

$_SESSION['pagina'] = 'editar-senha.php';
$_SESSION['form'] = '';

$sDepartamentoDAO = new ServicoDepartamentoDAO();
$pedidoDAO = new PedidoDAO();
$servicosDAO = new ServicoDAO();
$servicocampos = $servicosDAO->listaCampos($id_servico);
?>

<form onsubmit="return Pesquisa(this.id, 'carrega_pedido.php');" id="pedido_add" name="pedido_add" method="post">
    <table cellspacing="0" cellpadding="0" border="0" id="titulo">
        <tr>
            <td>Cadastrar Solicitação</td>
        </tr>
    </table>
    <table cellspacing="0" cellpadding="0" border="0" id="fldset">
        <tr>
            <td>Dados da Expedição do Documento</td>
        </tr>
    </table>
        <input type="hidden" name="dias" id="dias" value="<?= $dias ?>" />
        <input type="hidden" name="valor" value="<?= $valor ?>" id="valor" />
    <table cellspacing="0" cellpadding="0" style="border:solid 1px #999; width:744px;" id="nav">
        <tr>
            <td>
                <div align="right"><strong>Departamento: </strong></div>
            </td>
            <td colspan="3"><select name="id_servico_departamento"
                                    id="id_servico_departamento" style="width: 493px"
                                    class="form_estilo <?= ($errors['id_servico_departamento']) ? 'form_estilo_erro' : ''; ?>"
                                    onfocus="carrega_departamento(this.value);"
                                    onchange="carrega_servico(this.value,''); carrega_servico_var('','');">
                    <option value="<?= $p->id_servico_departamento ?>">
                        <?
                        #carrega departamento
                        $res_departamento = $sDepartamentoDAO->listaPorId($p->id_servico_departamento);
                        echo $res_departamento->departamento;
                        ?></option>
                </select> <font color="#FF0000">*</font></td>
        </tr>

        <tr>
            <td>
                <div align="right"><strong>Serviço: </strong></div>
            </td>
            <td colspan="3"><select name="id_servico" style="width: 493px" id="id_servico" class="form_estilo <?= ($errors['id_servico']) ? 'form_estilo_erro' : ''; ?>"
                                    onchange="carrega_servico_var(this.value,''); carrega_campo_r(this.value,'','');">
                    <option value=""></option>
                </select> <font color="#FF0000">*</font></td>
        </tr>
        <tr>
            <td>
                <div align="right"><strong>Variação: </strong></div>
            </td>
            <td colspan="3"><select name="id_servico_var" id="id_servico_var"
                                    style="width: 493px"
                                    class="form_estilo <?= ($errors['id_servico_var']) ? 'form_estilo_erro' : ''; ?>" onchange="carrega_servico_valor(this.value,'pedido_add');">
                </select> <font color="#FF0000">*</font></td>
        </tr>
    </table>
    <table cellspacing="0" cellpadding="0" border="0" id="fldset">
        <tr>
            <td>Dados do Documento</td>
        </tr>
    </table>
    <div id="carrega_campos_input">
        <table cellspacing="0" cellpadding="0" style="border:solid 1px #999; width:744px;" id="nav">
            <?
            $p_valor = "";
            foreach ($servicocampos as $servicocampo) {

                $p_valor .= '<tr>
              <td width="150"> <div align="right"><strong>' . $servicocampo->nome . ': </strong></div></td>
              <td colspan="3" width="543">';
                if ($servicocampo->campo != 'certidao_estado' and $servicocampo->campo != 'certidao_cidade') {
                    $p_valor .= '<input type="' . $servicocampo->tipo . '" name="' . $servicocampo->campo . '" value="' . ${$servicocampo->campo} . '" style="width:500px"';
                    if ($servicocampo->mascara <> '') {
                        $p_valor .= ' onKeyUp="masc_numeros(this,\'' . $servicocampo->mascara . '\');"';
                    }
                    $p_valor .= ' class="form_estilo"/>';
                } else {
                    if ($servicocampo->campo == 'certidao_estado')
                        $java_script = ' onchange="carrega_cidade2(\'\');" ';
                    else
                    if ($servicocampo->campo == 'certidao_cidade')
                        $java_script = ' onfocus="carrega_cidade2(certidao_estado.value);" id="carrega_cidade_campo" ';
                    else
                        $java_script = '';

                    $p_valor .= '<select name="' . $servicocampo->campo . '" style="width:500px" ' . $java_script . ' class="form_estilo">
								<option value="' . ${$servicocampo->campo} . '">' . ${$servicocampo->campo} . '</option>';

                    if (${$servicocampo->campo} <> '') {
                        $p_valor .= '<option value=""></option>';
                    }
                    if ($servicocampo->campo == 'certidao_estado') {
                        $servicocampo_sel = $servicosDAO->listaEstados();
                        foreach ($servicocampo_sel as $scs) {
                            $p_valor .= '<option value="' . $scs->estado . '">' . $scs->estado . '</option>';
                        }
                    } else {
                        if (${$servicocampo->campo} <> '') {
                            $servicocampo_sel = $servicosDAO->listaCidades($certidao_estado);
                            foreach ($servicocampo_sel as $scs) {
                                $p_valor .= '<option value="' . $scs->cidade . '">' . $scs->cidade . '</option>';
                            }
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
                    <div align="right"><strong>COD DO CLIENTE: </strong></div>
                </td>
                <td colspan="3" width="543"><input type="text"
                                                   name="controle_cliente" value="<?= $controle_cliente ?>"
                                                   style="width: 493px" class="form_estilo" /></td>
            </tr>
        </table>

    </div>
    <table cellspacing="0" cellpadding="0" style="margin-top:10px; width:744px;" id="nav">
        <tr>
            <td colspan="4">
                <div align="center"><input type="submit" name="submit"
                                           value="Adicionar" class="button_busca" />&nbsp; <input
                                           type="submit" name="cancelar" value="Voltar"
                                           onclick="document.pedido_add.action='pedido.php'"
                                           class="button_busca" />
                </div>
            </td>
        </tr>
    </table>
        
    <script type="text/javascript">
<? 
if ($id_cliente <> '') { ?>
                            carrega_contato('<?= $id_conveniado ?>','<?= $id_cliente ?>');
<? } ?>
                        carrega_servico('<?= $id_servico_departamento ?>','<?= $id_servico ?>');
                        carrega_servico_var('<?= $id_servico ?>','<?= $id_servico_var ?>');

    </script>
    <div id="carrega_dados"></div>
    <div id="resgata_endereco"></div>
    <div id="carrega_valor"></div>

</form>
<div id="retorno"></div>
<br><br><br><br>
<br><br><br><br>