<?
require('header.php');

$permissao = verifica_permissao('Empresa', $controle_id_departamento_p, $controle_id_departamento_s);
if ($controle_id_empresa != 1) {
    echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
    exit;
}
?>

<div id="topo">
    <h1 class="tit"><img src="../images/tit/tit_conta.png" alt="Título" />Agências dos Correios</h1>
    <hr class="tit" />
</div>
<div id="meio"><?
$correioDAO = new CorreioDAO();
$empresaDAO = new EmpresaDAO();
$lista = $empresaDAO->listarTodasFranquias();
pt_register('GET', 'id');
$con = $correioDAO->selectPorId($id,$controle_id_empresa);


pt_register('POST', 'submit');
if ($submit and $controle_id_empresa==1) {//check for errors
    $errors = array();
    $done = false;
    $error = "<b>Ocorreram os seguintes erros:</b><ul>";
    pt_register('POST', 'id_empresa');
    pt_register('POST', 'nome');
    pt_register('POST', 'agencia');
    pt_register('POST', 'status');
    pt_register('POST', 'data_cartaz');
    pt_register('POST', 'endereco');
    pt_register('POST', 'bairro');
    pt_register('POST', 'cidade');
    pt_register('POST', 'estado');
    pt_register('POST', 'cep');
    pt_register('POST', 'tel');
    pt_register('POST', 'fax');
    
    $con = new stdClass();
    $con->id_empresa = trim($id_empresa);
    $con->nome = trim($nome);
    $con->agencia = trim($agencia);
    $con->status = trim($status);
    $con->data_cartaz = invert(trim($data_cartaz), '-', 'SQL');
    $con->endereco = trim($endereco);
    $con->bairro = trim($bairro);
    $con->cidade = trim($cidade);
    $con->estado = trim($estado);
    $con->cep = trim($cep);
    $con->tel = trim($tel);
    $con->fax = trim($fax);

    if ($con->id_empresa == '' || $con->nome == '' || $con->status == '') {
        $error.="<li><b>Os campos com * são obrigatórios.</b></li>";
        if ($con->id_empresa == '')
            $errors['id_empresa'] = 1;
        if ($con->nome == '')
            $errors['nome'] = 1;
        if ($con->status == '')
            $errors['status'] = 1;
    }


    if (count($errors) == 0) {
        $correioDAO->atualizar($con,$id);
        $done = 1;
    } else {
        ?>
            <div class="erro"><?= $error; ?></div>
            <?
        }
        if ($done) {
            //alterado 01/04/2011
			
            $funcJs = "openAlertBox('Mensagem da página web','Registro atualizado com sucesso!','');";
            echo '<img src="../images/null.gif" class="nulo" onload="' . $funcJs . '" />';
        }
    }
	?>
		
        <table width="100%" border="0" cellpadding="10" cellspacing="0">
            <tr>
                <td valign="top" align="center">
                    <form enctype="multipart/form-data" action="" method="post" name="correio_add">
                        <table width="650" class="tabela">
                            <tr>
                                <td colspan="4" class="tabela_tit">Dados da Agência</td>
                            </tr>
                            <tr>
                                <td width="100">
                                    <div align="right"><strong>Status:</strong></div>
                                </td>
                                <td width="180">
                                    <select name="status" class="form_estilo" style="width: 150px">
                                        <option value="1" <? if ($con->status == '1')
                                                echo 'selected="selected"'; ?>>Ativo</option>
                                        <option value="2" <? if ($con->status == '2')
                                                echo 'selected="selected"'; ?>>Cancelado</option>
                                    </select>
                                </td>
                                <td>
                                    <div align="right"><strong>Franquia:</strong></div>
                                </td>
                                <td>
                                    <select name="id_empresa" class="form_estilo <?= (isset($errors['id_empresa'])) ? 'form_estilo_erro' : ''; ?>" style="width:200px">
                                        <option></option>
                                        <?php foreach ($lista as $l) { ?>
                                            <option value="<?= $l->id_empresa; ?>"<?= ($con->id_empresa == $l->id_empresa) ? 'selected="selected"' : '' ?>><?= $l->fantasia; ?></option>
                                        <?php } ?>
                                    </select> <font color="#FF0000">*</font>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="right"><strong>Nome: </strong></div>
                                </td>
                                <td colspan="3">
                                    <input type="text" name="nome" value="<?= $con->nome ?>" style="width: 460px" class="form_estilo <?= (isset($errors['nome'])) ? 'form_estilo_erro' : ''; ?>">
                                    <font color="#FF0000">*</font>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="right"><strong>Data do Cartaz:</strong></div>
                                </td>
                                <td colspan="3">
                                    <input type="text" name="data_cartaz" onKeyUp="masc_numeros(this,'##/##/####');" value="<?= invert($con->data_cartaz,'/','PHP') ?>" style="width: 150px" class="form_estilo" />
                                    (Opcional)
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="right"><strong>Endereço:</strong></div>
                                </td>
                                <td colspan="3">
                                    <input type="text" name="endereco" value="<?= $con->endereco ?>" style="width: 460px" class="form_estilo" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="right"><strong>Bairro:</strong></div>
                                </td>
                                <td>
                                    <input type="text" name="bairro" value="<?= $con->bairro ?>" style="width: 150px" class="form_estilo" />
                                </td>
                                <td>
                                    <div align="right"><strong>Cidade: </strong></div>
                                </td>
                                <td>
                                    <input type="text" name="cidade" value="<?= $con->cidade ?>" style="width: 200px" class="form_estilo">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="right"><strong>Estado:</strong></div>
                                </td>
                                <td>
                                    <input type="text" name="estado" value="<?= $con->estado ?>" style="width: 150px" class="form_estilo" />
                                </td>
                                <td>
                                    <div align="right"><strong>CEP: </strong></div>
                                </td>
                                <td>
                                    <input type="text" name="cep" value="<?= $con->cep ?>" onKeyUp="masc_numeros(this,'#####-###');" style="width: 200px" class="form_estilo">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="right"><strong>Telefone:</strong></div>
                                </td>
                                <td>
                                    <input type="text" name="tel" value="<?= $con->tel ?>" onKeyUp="masc_numeros(this,'## ####-####');" style="width: 150px" class="form_estilo" />
                                </td>
                                <td>
                                    <div align="right"><strong>Fax: </strong></div>
                                </td>
                                <td>
                                    <input type="text" name="fax" value="<?= $con->fax ?>" onKeyUp="masc_numeros(this,'## ####-####');" style="width: 200px" class="form_estilo">
                                </td>
                            </tr>

                            <tr>
                                <td colspan="4">
                                    <div align="center">
                                        <input type="submit" name="submit" value="Atualizar" class="button_busca" />&nbsp; 
                                        <input type="submit" name="cancelar" value="Cancelar" onclick="document.correio_add.action='correios.php'" class="button_busca" />
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </form>
                </td>
            </tr>
        </table>
    </div>
    <?php

require('footer.php');
?>