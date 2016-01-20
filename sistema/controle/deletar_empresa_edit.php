<?
require('header.php');
$permissao = verifica_permissao('Franquia', $controle_id_departamento_p, $controle_id_departamento_s);
$id_departamento_p = explode(',', $controle_id_departamento_p);
if ($permissao == 'FALSE' or $controle_id_empresa != '1') {
    echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
    exit;
}
?>
<div id="topo">
    <h1 class="tit"><img src="../images/tit/tit_empresa.png" alt="Título" />Franquia</h1>
    <hr class="tit" />
</div>
<div id="meio">
    <?
    pt_register('GET', 'id');
    pt_register('POST', 'submit');
    pt_register('POST', 'submit_correios');

    $empresaDAO = new EmpresaDAO();
    $correioDAO = new CorreioDAO();

    $readonly = !(in_array('1', $id_departamento_p) || in_array('17', $id_departamento_p));

    if ($submit_correios) {//check for errors
        $error = "";
        $errors = array();
        $error = "<b>Ocorreram os seguintes erros:</b><ul>";
        pt_register('POST', 'id_fichacorreio');
        pt_register('POST', 'quantidade');

        if ($id_fichacorreio == "" || $quantidade == "") {
            if ($id_fichacorreio == "")
                $errors['id_fichacorreio'] = 1;
            if ($quantidade == "")
                $errors['quantidade'] = 1;
            $error.="<li><b>Os campos com * são obrigatórios.</b></li>";
        }

        if (count($errors) == 0) {
            $done = 1;
            $correioDAO->inserirFichaCorreio($id, $controle_id_usuario, $id_fichacorreio, $quantidade);
            $titulo = 'Mensagem da página web';
            $msg = 'Registro adicionado com sucesso!';
            $pagina = 'empresa_edit.php?id=' . $id;
            $funcJs = "openAlertBox('" . $titulo . "','" . $msg . "','" . $pagina . "');";
            echo '<img src="../images/null.gif" class="nulo" onload="' . $funcJs . '" />';
        }
        if (count($errors)) {
            echo '<div class="erro">' . $error . '</div>';
        }
    }


    if ($submit) {//check for errors
        $error = "";
        $errors = array();
        $error = "<b>Ocorreram os seguintes erros:</b><ul>";
        pt_register('POST', 'id');
        pt_register('POST', 'nome');
        pt_register('POST', 'cel');
        pt_register('POST', 'tel');
        pt_register('POST', 'email');
        pt_register('POST', 'endereco');
        pt_register('POST', 'bairro');
        pt_register('POST', 'cidade');
        pt_register('POST', 'estado');
        pt_register('POST', 'cep');
        pt_register('POST', 'cpf');
        pt_register('POST', 'rg');
        pt_register('POST', 'empresa');
        pt_register('POST', 'fantasia');
        pt_register('POST', 'tipo');
        pt_register('POST', 'complemento');
        pt_register('POST', 'numero');
        pt_register('POST', 'ramal');
        pt_register('POST', 'status');
        pt_register('POST', 'franquia');
        pt_register('POST', 'imposto');
        pt_register('POST', 'royalties');
        pt_register('POST', 'roy_min');
        pt_register('POST', 'roy_min2');
        pt_register('POST', 'sem1');
        pt_register('POST', 'sem2');
        pt_register('POST', 'sem3');
        pt_register('POST', 'inicio');
        pt_register('POST', 'adendo');
        pt_register('POST', 'adendo_data');
        pt_register('POST', 'inauguracao_data');
        pt_register('POST', 'validade_contrato');
        pt_register('POST', 'data_cof');
        pt_register('POST', 'exclusividade');
        pt_register('POST', 'notificacao');
        pt_register('POST', 'precontrato');
        pt_register('POST', 'aditivo');

        pt_register('POST', 'id_banco');
        pt_register('POST', 'agencia');
        pt_register('POST', 'conta');
        pt_register('POST', 'favorecido');

        $emp = $empresaDAO->selectPorId($id);
        $emp->fantasia = $fantasia;

        if (!$readonly) {
            $emp->imposto = $imposto;
            $emp->royalties = $royalties;
            $emp->sem1 = $sem1;
            $emp->sem2 = $sem2;
            $emp->sem3 = $sem3;
            $emp->roy_min = $roy_min;
            $emp->roy_min2 = $roy_min2;
            $emp->inicio = invert($inicio,'-','SQL');
            $emp->status = $status;
            $emp->franquia = $franquia;
        }

        $emp->nome = $nome;
        $emp->cel = $cel;
        $emp->tel = $tel;
        $emp->email = $email;
        $emp->endereco = $endereco;
        $emp->bairro = $bairro;
        $emp->cidade = $cidade;
        $emp->estado = $estado;
        $emp->cep = $cep;
        $emp->data = $data;
        $emp->cpf = $cpf;
        $emp->rg = $rg;
        $emp->empresa = $empresa;
        $emp->tipo = $tipo;
        $emp->complemento = $complemento;
        $emp->numero = $numero;
        $emp->ramal = $ramal;
        $emp->id_empresa = $id;
        $emp->adendo_data = ($adendo_data != '') ? invert($adendo_data, '-', 'SQL') : '';
        $emp->adendo = $adendo;
        $emp->inauguracao_data = ($inauguracao_data != '') ? invert($inauguracao_data, '-', 'SQL') : '';
        $emp->validade_contrato = ($validade_contrato != '') ? invert($validade_contrato, '-', 'SQL') : '';
        $emp->data_cof = ($data_cof != '') ? invert($data_cof, '-', 'SQL') : '';
        $emp->aditivo = ($aditivo != '') ? invert($aditivo, '-', 'SQL') : '';
        $emp->precontrato = ($precontrato != '') ? invert($precontrato, '-', 'SQL') : '';

        $emp->exclusividade = $exclusividade;
        $emp->notificacao = $notificacao;

        $emp->id_banco = trim($id_banco);
        $emp->agencia = trim($agencia);
        $emp->conta = trim($conta);
        $emp->favorecido = trim($favorecido);

        if ($royalties == "" || $cpf == "" || $nome == "" || $email == "" || $fantasia == "" || $empresa == "" || $tel == "" || $email == ""
                || $endereco == "" || $cidade == "" || $estado == "" || $bairro == "" || $cep == "" || ($adendo == 1 && $adendo_data == '')) {
            if ($royalties == "")
                $errors['royalties'] = 1;
            if ($cpf == "")
                $errors['cpf'] = 1;
            if ($nome == "")
                $errors['nome'] = 1;
            if ($email == "")
                $errors['email'] = 1;
            if ($empresa == "")
                $errors['empresa'] = 1;
            if ($fantasia == "")
                $errors['fantasia'] = 1;
            if ($tel == "")
                $errors['tel'] = 1;
            if ($endereco == "")
                $errors['endereco'] = 1;
            if ($bairro == "")
                $errors['bairro'] = 1;
            if ($cidade == "")
                $errors['cidade'] = 1;
            if ($estado == "")
                $errors['estado'] = 1;
            if ($cep == "")
                $errors['cep'] = 1;
            if (($adendo == 1 && $adendo_data == ''))
                $errors['adendo_data'] = 1;
            $error.="<li><b>Os campos com * são obrigatórios.</b></li>";
        }

        $valida = validaEMAIL($email);
        if ($valida == 'false') {
            $errors['email'] = 1;
            $error.="<li><b>E-mail Inválido, digite corretamente.</b></li>";
        }

        if ($status=='Ativo' and $inicio=='') {
            $errors['inicio'] = 1;
            $error.="<li><b>Preencha o campo início antes de ativar a franquia</b></li>";
        }
        
        if ($tipo == 'cpf') {
            $valida = validaCPF($cpf);
            if ($valida == 'false') {
                $errors['cpf'] = 1;
                $error.="<li><b>CPF Inválido, digite corretamente.</b></li>";
            }
        } else {
            $valida = validaCNPJ($cpf);
            if ($valida == 'false') {
                $errors['cpf'] = 1;
                $error.="<li><b>CNPJ Inválido, digite corretamente.</b></li>";
            }
        }
        if (count($errors) == 0) {
            $done = 1;
            $empresaDAO->atualizar($emp);
            //alterado 01/04/2011
            $titulo = 'Mensagem da página web';
            $msg = 'Registro atualizado com sucesso!';
            $pagina = 'empresa.php';
            $funcJs = "openAlertBox('" . $titulo . "','" . $msg . "','" . $pagina . "');";
            echo '<img src="../images/null.gif" class="nulo" onload="' . $funcJs . '" />';
        }
        if (count($errors)) {
            ?>
            <div class="erro"><?php echo $error; ?></div>
            <?
        }
    }
    if (!$submit) {
        $emp = $empresaDAO->selectPorId($id);
    }if (!$done) {
        $bancoDAO = new BancoDAO();
        $bancos = $bancoDAO->listar();
        ?>
        <div style="position: relative; width: 800px; margin: auto;" id="container-hotsite">
            <ul>
                <li><a href="#aba0" onclick="eraseCookie('aba');">Dados do franqueado</a></li>
                <li><a href="#aba1" onclick="eraseCookie('aba'); createCookie('aba','aba1','1','1'); if(document.p_correio.p_correios.value==''){ carrega_fichas_correios('<?= $id ?>'); }">Fichas dos Correios</a></li>
            </ul>
            <div id="aba0" style="position: relative; width: 800px; margin: auto">
                <form enctype="multipart/form-data" action="" name="empresa_edit" method="post">
                    <table border="0" style="text-align: left" class="tabela">
                        <tr>
                            <td colspan="4" class="tabela_tit">Dados da Franquia</td>
                        </tr>

                        <tr>
                            <td width="110">
                                <div align="right"><strong>Status:</strong></div>
                            </td>
                            <td width="243"><select name="status" class="form_estilo"
                                                    <?= ($readonly) ? 'disabled="disabled"' : ''; ?> style="width: 150px">
                                    <option value="Ativo"
                                    <? if ($emp->status == 'Ativo')
                                        echo 'selected="selected"'; ?>>Ativo</option>
                                    <option value="Inativo"
                                    <? if ($emp->status == 'Inativo')
                                        echo 'selected="selected"'; ?>>Inativo</option>
                                    <option value="Cancelado"
                                    <? if ($emp->status == 'Cancelado')
                                        echo 'selected="selected"'; ?>>Cancelado</option>
                                </select></td>
                            <td width="107">
                                <div align="right"><strong>Franquia:</strong></div>
                            </td>
                            <td width="210"><input type="radio" name="franquia"
                                <?= ($readonly) ? 'disabled="disabled"' : ''; ?>
                                <? if ($emp->franquia == 'Sim' or $emp->franquia == '')
                                    echo 'checked="checked"'; ?>
                                                   value="Sim" /> Sim <input type="radio" name="franquia" value="Não"
                                                   <?= ($readonly) ? 'disabled="disabled"' : ''; ?>
                                                   <? if ($emp->franquia == 'Não')
                                                       echo 'checked="checked"'; ?> />
                                N&atilde;o</td>
                        </tr>
                        <tr>
                            <td>
                                <div align="right"><strong>Empresa: </strong></div>
                            </td>
                            <td colspan="3"><input type="text" name="empresa"
                                                   value="<?= $emp->empresa ?>" style="width: 507px"
                                                   class="form_estilo  <?= (isset($errors['empresa'])) ? 'form_estilo_erro' : ''; ?>"><font
                                                   color="#FF0000">*</font></td>
                        </tr>
                        <tr>
                            <td>
                                <div align="right"><strong>Unidade: </strong></div>
                            </td>
                            <td colspan="3"><input type="text" name="fantasia"
                                                   value="<?= $emp->fantasia ?>" style="width: 507px"
                                                   class="form_estilo <?= (isset($errors['fantasia'])) ? 'form_estilo_erro' : ''; ?>">
                                <font color="#FF0000">*</font></td>
                        </tr>
                        <tr>
                            <td>
                                <div align="right"><strong>Nome: </strong></div>
                            </td>
                            <td colspan="3"><input type="text" name="nome"
                                                   value="<?= $emp->nome ?>" style="width: 507px"
                                                   class="form_estilo <?= (isset($errors['nome'])) ? 'form_estilo_erro' : ''; ?>" />
                                <font color="#FF0000">*</font></td>
                        </tr>
                        <tr>
                            <td>
                                <div align="right"><strong>CPF/CNPJ: </strong></div>
                            </td>
                            <td>
                                <div style="float: left"><? if ($emp->tipo == '')
                                                   $emp->tipo = 'cpf'; ?>
                                    <select name="tipo" class="form_estilo">
                                        <option value="cpf"
                                        <? if ($emp->tipo == 'cpf')
                                            echo 'selected="selected"'; ?>>CPF</option>
                                        <option value="cnpj"
                                        <? if ($emp->tipo == 'cnpj')
                                            echo 'selected="selected"'; ?>>CNPJ</option>
                                    </select></div>
                                <div id="cpf" style="float: left"><input type="text" name="cpf"
                                                                         value="<?= $emp->cpf ?>" style="width: 150px"
                                                                         onKeyUp="if(tipo.value=='cpf') masc_numeros(this,'###.###.###-##'); else masc_numeros(this,'##.###.###/####-##');"
                                                                         class="form_estilo <?= (isset($errors['cpf'])) ? 'form_estilo_erro' : ''; ?>" />
                                </div>
                                <font color="#FF0000">*</font></td>
                            <td>
                                <div align="right"><strong>RG/IE: </strong></div>
                            </td>
                            <td><input type="text" name="rg" value="<?= $emp->rg ?>"
                                       style="width: 150px" class="form_estilo" /></td>
                        </tr>
                        <tr>
                            <td>
                                <div align="right"><strong>Tel: </strong></div>
                            </td>
                            <td><input type="text" name="tel" value="<?= $emp->tel ?>"
                                       style="width: 150px" onKeyUp="masc_numeros(this,'(##) ####-####');"
                                       class="form_estilo  <?= (isset($errors['tel'])) ? 'form_estilo_erro' : ''; ?>" /><font
                                       color="#FF0000">*</font> <input type="text" name="ramal"
                                       value="<?= $emp->ramal ?>" style="width: 50px"
                                       onkeyup="masc_numeros(this,'####');" class="form_estilo" /></td>
                            <td>
                                <div align="right"><strong>Cel: </strong></div>
                            </td>
                            <td><input type="text" name="cel" value="<?= $emp->cel ?>"
                                       style="width: 150px" onKeyUp="masc_numeros(this,'(##) ####-####');"
                                       class="form_estilo" /></td>
                        </tr>
                        <tr>
                            <td>
                                <div align="right"><strong>Email: </strong></div>
                            </td>
                            <td colspan="3"><input type="text" name="email"
                                                   value="<?= $emp->email ?>" style="width: 507px"
                                                   class="form_estilo  <?= (isset($errors['email'])) ? 'form_estilo_erro' : ''; ?>" />
                                <font color="#FF0000">*</font></td>
                        </tr>

                        <tr>
                            <td colspan="4" class="tabela_tit">Endereço</td>
                        </tr>
                        <tr>
                            <td>
                                <div align="right"><strong>CEP: </strong></div>
                            </td>
                            <td colspan="3"><input type="text" name="cep" style="width: 150px"
                                                   value="<?= $emp->cep ?>"
                                                   class="form_estilo  <?= (isset($errors['cep'])) ? 'form_estilo_erro' : ''; ?>"
                                                   onKeyUp="masc_numeros(this,'#####-###');" /> <font color="#FF0000">*</font>
                                <input type="button" name="consultar2" value="Consultar"
                                       class="button_busca"
                                       onclick="carrega_endedeco(cep.value, 'empresa_edit');" /></td>
                        </tr>
                        <tr>
                            <td>
                                <div align="right"><strong>Endereço: </strong></div>
                            </td>
                            <td colspan="3">
                                <input type="text" name="endereco" value="<?= $emp->endereco ?>" style="width: 385px" class="form_estilo <?= (isset($errors['endereco'])) ? 'form_estilo_erro' : ''; ?>" />
                                <font color="#FF0000">*</font> <strong>N&deg;</strong> 
                                <input type="text" name="numero" style="width: 90px" value="<?= $emp->numero ?>" class="form_estilo" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div align="right"><strong>Complemento: </strong></div>
                            </td>
                            <td><input type="text" name="complemento" style="width: 200px"
                                       value="<?= $emp->complemento ?>" class="form_estilo" /></td>
                            <td>
                                <div align="right"><strong>Bairro:</strong></div>
                            </td>
                            <td><input type="text" name="bairro" style="width: 150px"
                                       value="<?= $emp->bairro ?>"
                                       class="form_estilo <?= (isset($errors['bairro'])) ? 'form_estilo_erro' : ''; ?>" />
                                <font color="#FF0000">*</font></td>
                        </tr>

                        <tr>
                            <td>
                                <div align="right"><strong>Cidade: </strong></div>
                            </td>
                            <td><input type="text" name="cidade" style="width: 200px"
                                       value="<?= $emp->cidade ?>"
                                       class="form_estilo <?= (isset($errors['cidade'])) ? 'form_estilo_erro' : ''; ?>" />
                                <font color="#FF0000">*</font> <input type="hidden" name="id"
                                                                      value="<?= $id ?>" /></td>
                            <td>
                                <div align="right"><strong>Estado:</strong></div>
                            </td>
                            <td><input type="text" name="estado" style="width: 150px"
                                       value="<?= $emp->estado ?>"
                                       class="form_estilo <?= (isset($errors['estado'])) ? 'form_estilo_erro' : ''; ?>"
                                       maxlength="2" /><font color="#FF0000">*</font></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="tabela_tit">Dados Bancários</td>
                        </tr>
                        <tr>
                            <td>
                                <div align="right"><strong>Banco: </strong></div>
                            </td>
                            <td colspan="3">
                                <select name="id_banco" class="form_estilo" style="width:509px">
                                    <option></option>
                                    <?php foreach ($bancos as $banco) { ?>
                                        <option value="<?= $banco->id_banco; ?>"
                                                <?= ($emp->id_banco == $banco->id_banco) ? 'selected="selected"' : '' ?>>
                                            <?= $banco->banco; ?></option>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td>
                                <div align="right"><strong>Agência:</strong></div>
                            </td>
                            <td><input type="text" name="agencia" style="width: 150px"
                                       value="<?= $emp->agencia ?>" class="form_estilo" maxlength="15" />
                            </td>
                            <td>
                                <div align="right"><strong>Conta:</strong></div>
                            </td>
                            <td><input type="text" name="conta" style="width: 150px"
                                       value="<?= $emp->conta ?>" class="form_estilo" maxlength="15" /></td>
                        </tr>
                        <tr>
                            <td>
                                <div align="right"><strong>Favorecido:</strong></div>
                            </td>
                            <td colspan="3">
                                <input type="text" name="favorecido" style="width: 507px" value="<?= $emp->favorecido ?>" class="form_estilo" maxlength="45" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="tabela_tit">Dados Operacionais</td>
                        </tr>
                        <tr>
                            <td>
                                <div align="right"><strong>Assinatura da COF:</strong></div>
                            </td>
                            <td>
                                <input type="text" name="data_cof" value="<?= ($emp->data_cof != '') ? invert($emp->data_cof, '/', 'PHP') : ''; ?>" style="width:150px" onkeyup="masc_numeros(this,'##/##/####');" class="form_estilo  <?= (isset($errors['data_cof'])) ? 'form_estilo_erro' : ''; ?>"/>
                            </td>

                            <td>
                                <div align="right"><strong><label for="adendo">Adendo HSBC: </label></strong></div>
                            </td>
                            <td>
                                <div style="width:17px; text-align:center; float:left; padding:1px;">
                                    <input type="checkbox" class="form_estilo" id="adendo" name="adendo" value="1" <?= ($emp->adendo) ? 'checked="checked"' : '' ?>/>
                                </div>
                                <input type="text" name="adendo_data" value="<?= ($emp->adendo_data != '') ? invert($emp->adendo_data, '/', 'PHP') : ''; ?>" style="width: 131px" onkeyup="masc_numeros(this,'##/##/####');"	class="form_estilo  <?= (isset($errors['adendo_data'])) ? 'form_estilo_erro' : ''; ?>" id="adendo_data"/>
                                <span id="obrig"><font color="#FF0000">*</font></span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div align="right"><strong>Início do Contrato:</strong></div>
                            </td>
                            <td>
                                <input type="text" name="inauguracao_data" value="<?= ($emp->inauguracao_data != '') ? invert($emp->inauguracao_data, '/', 'PHP') : ''; ?>" style="width:150px" onkeyup="masc_numeros(this,'##/##/####');" class="form_estilo  <?= (isset($errors['inauguracao_data'])) ? 'form_estilo_erro' : ''; ?>" id="inauguracao_data"/>
                            </td>
                            <td>
                                <div align="right"><strong>Final do Contrato:</strong></div>
                            </td>
                            <td>
                                <input type="text" name="validade_contrato" value="<?= ($emp->validade_contrato != '') ? invert($emp->validade_contrato, '/', 'PHP') : ''; ?>" style="width: 150px" onkeyup="masc_numeros(this,'##/##/####');" class="form_estilo  <?= (isset($errors['validade_contrato'])) ? 'form_estilo_erro' : ''; ?>"/>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div align="right"><strong>Pré-Contrato:</strong></div>
                            </td>
                            <td>
                                <input type="text" name="precontrato" value="<?= ($emp->precontrato != '') ? invert($emp->precontrato, '/', 'PHP') : ''; ?>" style="width:150px" onkeyup="masc_numeros(this,'##/##/####');" class="form_estilo  <?= (isset($errors['precontrato'])) ? 'form_estilo_erro' : ''; ?>" id="inauguracao_data"/>
                            </td>
                            <td>
                                <div align="right"><strong>Aditivo de Royalty:</strong></div>
                            </td>
                            <td>
                                <input type="text" name="aditivo" value="<?= ($emp->aditivo != '') ? invert($emp->aditivo, '/', 'PHP') : ''; ?>" style="width: 150px" onkeyup="masc_numeros(this,'##/##/####');" class="form_estilo  <?= (isset($errors['aditivo'])) ? 'form_estilo_erro' : ''; ?>"/>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div align="right"><strong>Exclusividade:</strong></div>
                            </td>
                            <td colspan="3">
                                <input type="text" name="exclusividade" value="<?= $emp->exclusividade; ?>" style="width: 150px" onkeyup="masc_numeros(this,'##');"	class="form_estilo  <?= (isset($errors['exclusividade'])) ? 'form_estilo_erro' : ''; ?>"/>(meses)
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div align="right"><strong>Notificação (Data,Motivo):</strong></div>
                            </td>
                            <td colspan="3">
                                <textarea name="notificacao" style="width:512px; height:100px" class="form_estilo"><?= $emp->notificacao; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="tabela_tit">Informações Complementares</td>
                        </tr>
                        <tr>
                            <td>
                                <div align="right"><strong>Liberação do Sistema:</strong></div>
                            </td>
                            <td colspan="3">
                                <input type="text" name="inicio" value="<?= ($emp->inicio != '') ? invert($emp->inicio, '/', 'PHP') : ''; ?>" style="width:150px" onkeyup="masc_numeros(this,'##/##/####');" class="form_estilo"/>
                                <strong>&nbsp;&nbsp;&nbsp;Royalties:</strong>
                                <input type="text" id="royalties" name="royalties"	value="<?= $emp->royalties ?>" style="width: 50px" onkeyup="moeda(event.keyCode,this.value,'royalties'); $('#royfixo').html(this.value); $('#royfixo2').html(this.value);" class="form_estilo <?= (isset($errors['royalties'])) ? 'form_estilo_erro' : ''; ?>" <?= ($readonly) ? 'readonly="readonly"' : ''; ?>>% 

                                <strong>Deduzir Impostos de:</strong>
                                <input type="text" name="imposto" value="<?= $emp->imposto ?>" id="imposto" style="width: 50px" onkeyup="moeda(event.keyCode,this.value,'imposto');" class="form_estilo" <?= ($readonly) ? 'readonly="readonly"' : ''; ?>>%
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div align="right"><strong>Royalties Fixo por Semestre:</strong></div>
                            </td>
                            <td colspan="3">
                                1° Sem.<input type="text" name="sem1" id="sem1" onkeyup="moeda(event.keyCode,this.value,'sem1');" value="<?= $emp->sem1 ?>" style="width:50px" class="form_estilo"/>
                                2° Sem.<input type="text" name="sem2" id="sem2" onkeyup="moeda(event.keyCode,this.value,'sem2');" value="<?= $emp->sem2 ?>" style="width:50px" class="form_estilo"/>
                                3° Sem.<input type="text" name="sem3" id="sem3" onkeyup="moeda(event.keyCode,this.value,'sem3');" value="<?= $emp->sem3 ?>" style="width:50px" class="form_estilo"/>
                                Após 3° Semestre <b><span id="royfixo"><?= $emp->royalties ?></span>%</b>
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <div align="right"><strong>Royalties Fixo:</strong></div>
                            </td>
                            <td colspan="3">
                                <input type="text" name="roy_min"  id="roy_min" onkeyup="moeda(event.keyCode,this.value,'roy_min');" value="<?= $emp->roy_min ?>" style="width:50px" class="form_estilo"/>
                                Após 4 meses
                                <input type="text" name="roy_min2"  id="roy_min2" onkeyup="moeda(event.keyCode,this.value,'roy_min2');" value="<?= $emp->roy_min2 ?>" style="width:50px" class="form_estilo"/>
                                Ou <b><span id="royfixo2"><?= $emp->royalties ?></span>%</b> (o que for maior)
                            </td>

                        </tr>
                        <tr>
                            <td colspan="4">
                                <div align="center">
                                    <? if ($controle_id_usuario == 99 or $controle_id_usuario == 877 or $controle_id_usuario == 1043 or $controle_id_usuario == 1245 or $controle_id_usuario == 1) { ?>
                                        <input type="submit" name="submit" value="Atualizar" class="button_busca" /> 
                                    <? } ?>	
                                    &nbsp; 
                                    <input type="submit" name="cancelar" value="Cancelar" onclick="document.empresa_edit.action='empresa.php'" class="button_busca" /> &nbsp; 
                                    <input type="submit" name="mensagens" value="Mensagens" onclick="document.empresa_edit.action='empresa_msg.php?id_empresa=<?php echo $emp->id_empresa ?>'" class="button_busca" />
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div id="resgata_endereco"></div>
                </form>
            </div>
            <div id="aba1" style="position: relative; width: 800px; margin: auto">
                <div id="carrega_p_correios">
                    <?
                    if ($aba == 'aba1') {
                        require('../carrega_pedido/carrega_correios.php');
                    } else {
                        echo '<form name="p_correio" id="p_correio"><input type="hidden" name="p_correios" value=""></form>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            function toggleAdendo(){
                if(($('#adendo').is(':checked'))){
                    $('#adendo_data').attr('readonly','');
                    $('#adendo_data').focus();
                    $('#obrig').show();
                }else{
                    $('#adendo_data').attr('value','');
                    $('#adendo_data').attr('readonly','readonly');
                    $('#obrig').hide();
                }
            }
            toggleAdendo();
            $('#adendo').change(function(){	toggleAdendo();});
        });
    </script>
    <?
} else {
    //alterado 01/04/2011
    $titulo = 'Mensagem da página web';
    $msg = 'reg. atualizado!';
    $pagina = '';
    $funcJs = "openAlertBox('" . $titulo . "','" . $msg . "','" . $pagina . "');";
    echo '<img src="../images/null.gif" class="nulo" onload="' . $funcJs . '" />';
}
require('footer.php');
?>