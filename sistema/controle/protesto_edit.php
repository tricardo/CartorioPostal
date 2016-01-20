<?
require('header.php');
$permissao = verifica_permissao('Protesto', $controle_id_departamento_p, $controle_id_departamento_s);
if ($permissao == 'FALSE') {
    echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
    exit;
}
?>
<div id="topo">
    <h1 class="tit"><img src="../images/tit/tit_protesto.png" alt="Título" />Protesto</h1>
    <hr class="tit" />
</div>
<div id="meio">
    <?
    pt_register('POST', 'submit');
    $protestoDAO = new ProtestoDAO();
    if ($submit) {//check for errors
        $errors = 0;
        $error = "<b>Ocorreram os seguintes erros:</b><ul>";
        pt_register('POST', 'id');
        pt_register('POST', 'portador_nome');
        pt_register('POST', 'ibge_cidade');
        pt_register('POST', 'portador');
        pt_register('POST', 'data_movimento');
        pt_register('POST', 'cedente_agencia');
        pt_register('POST', 'cedente_nome');
        pt_register('POST', 'sacado_documento');
        pt_register('POST', 'sacado_nome');
        pt_register('POST', 'sacado_cep');
        pt_register('POST', 'sacado_endereco');
        pt_register('POST', 'sacado_cidade');
        pt_register('POST', 'sacado_estado');
        pt_register('POST', 'nosso_numero');
        pt_register('POST', 'tipo_moeda');
        pt_register('POST', 'agencia_centralizadora');

        $p = new stdClass();
        $p->id_protesto = $id;
        $p->portador_nome = $portador_nome;
        $p->ibge_cidade = $ibge_cidade;
        $p->portador = $portador;
        $p->data_movimento = invert($data_movimento, '-', 'SQL');
        $p->cedente_agencia = $cedente_agencia;
        $p->cedente_nome = $cedente_nome;
        $p->sacado_documento = $sacado_documento;
        $p->sacado_nome = $sacado_nome;
        $p->sacado_cep = $sacado_cep;
        $p->sacado_endereco = $sacado_endereco;
        $p->sacado_cidade = $sacado_cidade;
        $p->sacado_estado = $sacado_estado;
        $p->nosso_numero = $nosso_numero;
        $p->tipo_moeda = $tipo_moeda;
        $p->agencia_centralizadora = $agencia_centralizadora;

        if ($portador == "" or $portador_nome == "" or $data_movimento == "" or $cedente_agencia == "" or $cedente_nome == "" or $sacado_documento == "" or $sacado_nome == "" or $sacado_cep == "" or $sacado_endereco == "" or $sacado_estado == "" or $sacado_cidade == "" or $nosso_numero == "" or $tipo_moeda == "" or $agencia_centralizadora == "") {
            $errors = 1;
            $error.="<li><b>Todos os campos são obrigatórios.</b></li>";
        } elseif ($errors != 1) {
            $protestoDAO->atualizar($p, $controle_id_empresa);
            $done = 1;
        }
        if ($errors) {
            ?>
            <div class="erro"><?php echo $error; ?></div>
            <?php
        }
        if ($done) {
            //alterado 01/04/2011
            $titulo = 'Editar Protesto';
            $perg = 'Novo registro adicionado com sucesso!\nAdicionar devedores?';
            $resp1 = 'protesto_rem_add.php?id=' . $id;
            $resp2 = 'protesto.php';
            $funcJs = "openConfirmBox('" . $titulo . "','" . $perg . "','" . $resp1 . "','" . $resp2 . "');";
            echo '<img src="../images/null.gif" class="nulo" onload="' . $funcJs . '" />';
        }
    }
    if (!$done && !$submit) {
        $id = $_GET["id"];
        $p = $protestoDAO->buscaPorId($id, $controle_id_empresa);
    }
    ?>

    <table width="100%" border="0" cellpadding="10" cellspacing="0">
        <tr>
            <td valign="top" align="center">

                <blockquote>
                    <form enctype="multipart/form-data" action="" name="protesto_edit"
                          method="post">
                        <table width="650" class="tabela">
                            <tr>
                                <td colspan="4" class="tabela_tit">Dados do Portador</td>
                            </tr>
                            <tr>
                                <td width="100">
                                    <div align="right"><strong>Portador: </strong></div>
                                </td>
                                <td width="243"><input type="text" name="portador"
                                                       value="<?= $p->portador ?>" onKeyUp="masc_numeros(this,'###');"
                                                       style="width: 200px" class="form_estilo" /><input type="hidden"
                                                       name="id" value="<?= $p->id_protesto ?>" /></td>
                                <td width="70">
                                    <div align="right"><strong>Movimento: </strong></div>
                                </td>
                                <td width="219"><input type="text" name="data_movimento"
                                                       value="<?= invert($p->data_movimento, '/', 'PHP'); ?>"
                                                       onKeyUp="masc_numeros(this,'##/##/####');" style="width: 150px"
                                                       class="form_estilo" /></td>
                            </tr>

                            <tr>
                                <td>
                                    <div align="right"><strong>Nome: </strong></div>
                                </td>
                                <td colspan="3"><input type="text" name="portador_nome"
                                                       value="<?= $p->portador_nome ?>" maxlength="40"
                                                       style="width: 470px" class="form_estilo"></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="tabela_tit">Cedente</td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="right"><strong>Agência: </strong></div>
                                </td>
                                <td colspan="3"><input type="text" name="cedente_agencia"
                                                       value="<?= $p->cedente_agencia ?>" maxlength="15"
                                                       style="width: 200px" class="form_estilo" />
                                    <div align="right"></div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div align="right"><strong>Nome: </strong></div>
                                </td>
                                <td colspan="3"><input type="text" name="cedente_nome"
                                                       value="<?= $p->cedente_nome ?>" maxlength="45" style="width: 470px"
                                                       class="form_estilo"></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="tabela_tit">Sacado / Credor</td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="right"><strong>Documento:</strong></div>
                                </td>
                                <td colspan="3"><input type="text" name="sacado_documento"
                                                       value="<?= $p->sacado_documento ?>" maxlength="14"
                                                       style="width: 200px" class="form_estilo" /></td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="right"><strong>Nome: </strong></div>
                                </td>
                                <td colspan="3"><input type="text" name="sacado_nome"
                                                       value="<?= $p->sacado_nome ?>" maxlength="45" style="width: 470px"
                                                       class="form_estilo" /></td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="right"><strong>Cep: </strong></div>
                                </td>
                                <td colspan="3"><input type="text" name="sacado_cep"
                                                       value="<?= $p->sacado_cep ?>"
                                                       onKeyUp="masc_numeros(this,'#####-###');" style="width: 200px"
                                                       class="form_estilo" /></td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="right"><strong>Endereço: </strong></div>
                                </td>
                                <td colspan="3"><input type="text" name="sacado_endereco"
                                                       value="<?= $p->sacado_endereco ?>" maxlength="45"
                                                       style="width: 470px" class="form_estilo"></td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="right"><strong>Cidade: </strong></div>
                                </td>
                                <td><input type="text" name="sacado_cidade" style="width: 200px"
                                           value="<?= $p->sacado_cidade ?>" maxlength="20" class="form_estilo" /></td>
                                <td>
                                    <div align="right"><strong>Estado:</strong></div>
                                </td>
                                <td><input type="text" name="sacado_estado" style="width: 150px"
                                           value="<?= $p->sacado_estado ?>" maxlength="2" class="form_estilo" /></td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="right"><strong>Nosso Número: </strong></div>
                                </td>
                                <td><input type="text" name="nosso_numero"
                                           value="<?= $p->nosso_numero ?>" maxlength="15" style="width: 200px"
                                           class="form_estilo" /> 
                                <td>    
                                    <strong>Tipo Moeda:</strong> 
                                </td>
                                <td>    
                                    <input type="text" name="tipo_moeda" style="width: 95px" onKeyUp="masc_numeros(this,'###');" value="<?= $p->tipo_moeda ?>" class="form_estilo" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="right"><strong>Ag. Central.: </strong></div>
                                </td>
                                <td>
                                    <input type="text" name="agencia_centralizadora" style="width: 200px" value="<?= $p->agencia_centralizadora ?>" maxlength="6" class="form_estilo" />
                                </td>
                                <td>
                                    <div align="right"><strong>Cód. IBGE:</strong></div>
                                </td>
                                <td>
                                    <input type="text" name="ibge_cidade" style="width: 150px" value="<?= $p->ibge_cidade ?>" maxlength="7" class="form_estilo" />
                                </td>
                            </tr>

                            <tr>
                                <td colspan="4">
                                    <div align="center"><input type="submit" name="submit"
                                                               value="Atualizar" class="button_busca" />&nbsp; <input
                                                               type="submit" name="cancelar" value="Cancelar"
                                                               onclick="document.protesto_edit.action='protesto.php'"
                                                               class="button_busca" /></div>
                                </td>
                            </tr>
                        </table>
                        <div id="resgata_endereco"></div>
                    </form>
                </blockquote>
            </td>
        </tr>
    </table>
</div>
<?php
require('footer.php');
?>
