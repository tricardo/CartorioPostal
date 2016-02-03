<?php require('header.php');

$permissao = verifica_permissao('Financeiro', $controle_id_departamento_p, $controle_id_departamento_s);
if ($permissao == 'FALSE') {
    echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
    exit;
}
$submit = 'inserir';

pt_register('POST', 'ocorrencia');
pt_register('POST', 'submit_form');
pt_register('POST', 'submit_deleta');
pt_register('GET', 'id');

$validacaoCLASS = new ValidacaoCLASS();
$contaDAO = new ContaDAO();

$p = $contaDAO->listaBoletoBrad($id, $controle_id_empresa);

$id_conta = $p->id_conta;
if ($p->id_conta_fatura == '') {
    echo 'Boleto não encontrado.<br><br>';
    exit;
}

#altera??o de vencimento
if ($submit_form <> '' and $ocorrencia == 6 and $p->status == 1) {
    $errors = array();
    $error = '<div class="erro"><b>Ocorreram os seguintes erros:</b><br>';
    $cont = 0;

    pt_register('POST', 'vencimento');
    pt_register('POST', 'ocorrencia');
    if ($vencimento == "" or $ocorrencia == "") {
        if ($vencimento == "") $errors['vencimento'] = 1;
        if ($ocorrencia == "") $errors['ocorrencia'] = 1;
        $error .= '- Os Campos com * são obrigatórios;<br>';
    }

    $verifica = $validacaoCLASS->invertData($vencimento);
    if ($verifica == false) {
        $errors['vencimento'] = 1;
        $error .= '- Vencimento inválido;<br>';
    } else {
        $vencimento = $verifica;
    }

    $p->vencimento = $vencimento;
    $p->ocorrencia = $ocorrencia;
    if (COUNT($errors) == 0) {
        $done = $contaDAO->inserirBoletoBradOco6($p, $id, $controle_id_empresa, $controle_id_usuario);
        //alterado 01/04/2011
        $titulo = 'Mensagem da p?gina web';
        $msg = 'Boleto alterado com sucesso!';
        $pagina = 'financeiro_boleto_edit.php?id=' . $id;
        $funcJs = "openAlertBox('" . $titulo . "','" . $msg . "','" . $pagina . "');";
        echo '<img src="../images/null.gif" class="nulo" onload="' . $funcJs . '" />';
        exit;
    }

    if ($errors) {
        echo $error . "</div>";
    }
}

#outras ocorrencias
if ($submit_form <> '' and ($ocorrencia == 100 or $ocorrencia == 101) and $ocorrencia <> '' and $p->status == 1) {
    $done = $contaDAO->inserirBoletoBradOco100($ocorrencia, $id, $controle_id_empresa, $controle_id_usuario);
    //alterado 01/04/2011
    $titulo = 'Mensagem da página web';
    $msg = 'Boleto alterado com sucesso!';
    $pagina = 'financeiro_boleto_edit.php?id=' . $id;
    $funcJs = "openAlertBox('" . $titulo . "','" . $msg . "','" . $pagina . "');";
    echo '<img src="../images/null.gif" class="nulo" onload="' . $funcJs . '" />';
    exit;

}

#outras ocorrencias
if ($submit_form <> '' and $ocorrencia != 6 and $ocorrencia != 1 and $ocorrencia != 31 and $ocorrencia != 100 and $ocorrencia != 101 and $ocorrencia <> '' and $p->status == 1) {

    $done = $contaDAO->inserirBoletoBradOco($ocorrencia, $id, $controle_id_empresa, $controle_id_usuario);
    //alterado 01/04/2011
    $titulo = 'Mensagem da página web';
    $msg = 'Boleto alterado com sucesso!';
    $pagina = 'financeiro_boleto_edit.php?id=' . $id;
    $funcJs = "openAlertBox('" . $titulo . "','" . $msg . "','" . $pagina . "');";
    echo '<img src="../images/null.gif" class="nulo" onload="' . $funcJs . '" />';
    exit;

}

#altera??o do boleto depois do registro
if ($submit_form <> '' and $ocorrencia == 31 and $p->status == 1) {
    $errors = array();
    $error = '<div class="erro"><b>Ocorreram os seguintes erros:</b><br>';
    $cont = 0;

    pt_register('POST', 'ocorrencia');
    pt_register('POST', 'tipo');
    pt_register('POST', 'cpf');
    pt_register('POST', 'sacado');
    pt_register('POST', 'endereco');
    pt_register('POST', 'bairro');
    pt_register('POST', 'cidade');
    pt_register('POST', 'estado');
    pt_register('POST', 'cep');
    pt_register('POST', 'valor');
    pt_register('POST', 'juros_mora');
    pt_register('POST', 'instrucao1');
    pt_register('POST', 'instrucao2');
    pt_register('POST', 'mensagem1');
    pt_register('POST', 'mensagem2');
    if ($tipo == "" or $cpf == "" or $sacado == "" or $endereco == "" or $cep == "" or $valor == "") {
        if ($tipo == "") $errors['tipo'] = 1;
        if ($cpf == "") $errors['cpf'] = 1;
        if ($sacado == "") $errors['sacado'] = 1;
        if ($endereco == "") $errors['endereco'] = 1;
        if ($cep == "") $errors['cep'] = 1;
        if ($valor == "") $errors['valor'] = 1;
        $error .= '- Os Campos com * são obrigatórios;<br>';
    }

    if ($instrucao1 == 6 and $instrucao2 < 5) {
        $errors['instrucao2'] = 1;
        $error .= '- O campo instrução 2 não pode ser menor que 5;<br>';
    }

    $p->ocorrencia = $ocorrencia;
    $p->tipo = $tipo;
    $p->cpf = $cpf;
    $p->sacado = $sacado;
    $p->endereco = $endereco;
    $p->bairro = $bairro;
    $p->cidade = $cidade;
    $p->estado = $estado;
    $p->cep = $cep;
    $p->valor = $valor;
    $p->juros_mora = $juros_mora;
    $p->instrucao1 = $instrucao1;
    $p->instrucao2 = $instrucao2;
    $p->mensagem1 = $mensagem1;
    $p->mensagem2 = $mensagem2;
    if (COUNT($errors) == 0) {
        $done = $contaDAO->inserirBoletoBradOco31($p, $id, $controle_id_empresa, $controle_id_usuario);
        //alterado 01/04/2011
        $titulo = 'Mensagem da página web';
        $msg = 'Boleto alterado com sucesso!';
        $pagina = 'financeiro_boleto_edit.php?id=' . $id;
        $funcJs = "openAlertBox('" . $titulo . "','" . $msg . "','" . $pagina . "');";
        echo '<img src="../images/null.gif" class="nulo" onload="' . $funcJs . '" />';
        exit;
    }

    if ($errors) {
        echo $error . "</div>";
    }
}


#altera??o do boleto antes de registrar
if ($submit_form <> '' and $p->status == 0) {

    $result = '';
    $errors = array();
    //$error = '<div class="erro"><b>Ocorreram os seguintes erros:</b><br>';
    $cont = 0;

    pt_register('POST', 'id_conta');
    pt_register('POST', 'tipo');
    pt_register('POST', 'id_nota');
    pt_register('POST', 'cpf');
    pt_register('POST', 'sacado');
    pt_register('POST', 'endereco');
    pt_register('POST', 'bairro');
    pt_register('POST', 'cidade');
    pt_register('POST', 'estado');
    pt_register('POST', 'cep');
    pt_register('POST', 'vencimento');
    pt_register('POST', 'valor');
    pt_register('POST', 'mensagem1');
    pt_register('POST', 'mensagem2');
    pt_register('POST', 'emissao_papeleta');
    pt_register('POST', 'especie');
    pt_register('POST', 'aceite');


    if (empty($id_conta)) {
        $errors["id_conta"] = 1;
        $result .= "<li>O campo <strong>Banco</strong> é obrigatório</li>";
    }

    if (empty($tipo)) {
        $errors['tipo'] = 1;
        $result .= "<li>O campo <strong>Tipo</strong> é obrigatório.</li>";
    }

    if (empty($cpf)) {
        $errors["cpf"] = 1;
        $result .= "<li>O campo <strong>CPF/CNPJ</strong> é obrigatório.</li>";
    }

    if (empty($sacado)) {
        $errors['sacado'] = 1;
        $result .= "<li>O campo <strong>Sacado</strong> é obrigatório.</li>";
    }

    if (empty($endereco)) {
        $errors['endereco'] = 1;
        $result .= "<li>O campo <strong>Endereço</strong> é obrigatório.</li>";
    }

    if (empty($bairro)) {
        $errors['bairro'] = 1;
        $result .= "<li>O campo <strong>Bairro</strong> é obrigatório.</li>";
    }

    if (empty($cidade)) {
        $errors['cidade'] = 1;
        $result .= "<li>O campo <strong>Cidade</strong> é obrigatório.</li>";
    }

    if (empty($cep)) {
        $errors['cep'] = 1;
        $result .= "<li>O campo <strong>CEP</strong> é obrigatório.</li>";
    }

    if (empty($vencimento)) {
        $errors['vencimento'] = 1;
        $result .= "<li>O campo <strong>Vencimento</strong> é obrigatório.</li>";
    }

    if (empty($valor)) {
        $errors['valor'] = 1;
        $result .= "<li>O campo <strong>Valor</strong> é obrigatório.</li>";
    }

    if (empty($emissao_papeleta)) {
        $errors['emissao_papeleta'] = 1;
        $result .= "<li>O campo <strong>Papeleta</strong> é obrigatório.</li>";
    }

    if (empty($especie)) {
        $errors['especie'] = 1;
        $result .= "<li>O campo <strong>Espécie</strong> é obrigatório.</li>";
    }

    if (empty($aceite)) {
        $errors['aceite'] = 1;
        $result .= "<li>O campo <strong>Aceite</strong> é obrigatório.</li>";
    }

    if (invert($vencimento, '-', 'SQL') < date('Y-m-d')) {
        $errors['vencimento'] = 1;
        $result .= '<li>A data de <strong>Vencimento</strong> não pode ser inferior ao dia de hoje.</li>';
    }

    $verifica = $validacaoCLASS->invertData($vencimento);
    if ($verifica == false) {
        $errors['vencimento'] = 1;
        $result .= '<li>O campo <strong>Vencimento</strong> é inválido.</li>';
    } else {
        $vencimento = $verifica;
    }

    if ($id_conta > 2) {
        pt_register("POST", "ddlMulta");
        pt_register("POST", "txtValorMulta");
        pt_register("POST", "txtDataMulta");
        pt_register("POST", "ddlJuros");
        pt_register("POST", "txtValorJuros");
        pt_register("POST", "ddlPgtoParcial");
        pt_register("POST", "txtDiasProtesto");
        pt_register("POST", "txtNumeroBeneficiario");
        pt_register("POST", "txtCampoLivre");
        pt_register("POST", "txtCNPJSacador");
        pt_register("POST", "txtNomeSacador");
        pt_register("POST", "mensagem3");

        if (empty($ddlMulta)) {
            $errors['ddlMulta'] = 1;
            $result .= "<li>O campo <strong>Multa</strong> é obrigatório.</li>";
        }

        if (empty($txtValorMulta) && $$ddlMulta > 1) {
            $errors['txtValorMulta'] = 1;
            $result .= "<li>O campo <strong>Valor multa</strong> é obrigatório.</li>";
        }

        if (empty($txtDataMulta)) {
            $errors['txtDataMulta'] = 1;
            $result .= "<li>O campo <strong>Data multa</strong> é obrigatório.</li>";
        } else {
            $verifica = $validacaoCLASS->invertData($txtDataMulta);

            if ($verifica == false) {
                $errors['txtDataMulta'] = 1;
                $result .= '<li>O campo <strong>Data multa</strong> é inválido.</li>';
            } else {
                $txtDataMulta = $verifica;
            }
        }

        if (empty($ddlJuros)) {
            $errors['ddlJuros'] = 1;
            $result .= "<li>O campo <strong>Juros</strong> é obrigatório.</li>";
        }

        if (empty($txtValorJuros) && $ddlJuros > 1) {
            $errors['txtValorJuros'] = 1;
            $result .= "<li>O campo <strong>Valor Juros</strong> é obrigatório.</li>";
        }

        if (empty($ddlPgtoParcial)) {
            $errors['ddlPgtoParcial'] = 1;
            $result .= "<li>O campo <strong>Pgto Parcial</strong> é obrigatório.</li>";
        }

        if (empty($txtDiasProtesto)) {
            $errors['txtDiasProtesto'] = 1;
            $result .= "<li>O campo <strong>Dias Protesto</strong> é obrigatório.</li>";
        }

        if (empty($txtNumeroBeneficiario)) {
            $errors['txtNumeroBeneficiario'] = 1;
            $result .= "<li>O campo <strong>N° Beneficiário</strong> é obrigatório.</li>";
        }

        if (empty($txtCNPJSacador)) {
            $errors['txtCNPJSacador'] = 1;
            $result .= "<li>O campo <strong>CNPJ Sacador</strong> é obrigatório.</li>";
        }

        if (empty($txtNomeSacador)) {
            $errors['txtNomeSacador'] = 1;
            $result .= "<li>O campo <strong>Nome Sacador</strong> é obrigatório.</li>";
        }

    } else {
        pt_register("POST", "juros_mora");
        pt_register('POST', 'instrucao1');
        pt_register('POST', 'instrucao2');

        if (empty($juros_mora)) {
            $errors['juros_mora'] = 1;
            $result .= "<li>O campo <strong>Mora diária</strong> é obrigatório.</li>";
        }

        if ($instrucao1 == 6 and $instrucao2 < 5) {
            $errors['instrucao2'] = 1;
            $error .= 'O campo instrução 2 não pode ser menor que 5<br>';
        }
    }

    if (count($errors) == 0) {
        $p->id_nota = $id_nota;
        $p->tipo = $tipo;
        $p->cpf = $cpf;
        $p->sacado = $sacado;
        $p->endereco = $endereco;
        $p->bairro = $bairro;
        $p->cidade = $cidade;
        $p->estado = $estado;
        $p->cep = $cep;
        $p->vencimento = $vencimento;
        $p->valor = $valor;
        $p->mensagem1 = $mensagem1;
        $p->mensagem2 = $mensagem2;
        $p->emissao_papeleta = $emissao_papeleta;
        $p->especie = $especie;
        $p->aceite = $aceite;
        $p->id_conta = $id_conta;

        switch ($id_conta) {
            case 2:
                $p->juros_mora = $juros_mora;
                $p->instrucao1 = $instrucao1;
                $p->instrucao2 = $instrucao2;

                $retorno = $contaDAO->atualizaBoletoBrad($p, $id, $controle_id_empresa);
                break;
            default:
                $p->instrucao1 = 0;
                $p->instrucao2 = 0;
                $p->tipo_multa = $ddlMulta;
                $p->valor_multa = ($ddlMulta == 1) ? null : $txtValorMulta;
                $p->data_multa = $txtDataMulta;
                $p->tipo_juros = $ddlJuros;
                $p->juros_mora = ($ddlJuros == 1) ? 0 : $txtValorJuros;
                $p->dias_protesto = $txtDiasProtesto;
                $p->pgto_parcial = ($ddlPgtoParcial == 'S') ? true : false;
                $p->campo_livre = $txtCampoLivre;
                $p->cpnj_sacador = $txtCNPJSacador;
                $p->nome_sacador = strtoupper($txtNomeSacador);
                $p->mensagem3 = strtoupper($mensagem3);
                $p->txtNumeroBeneficiario = strtoupper($txtNumeroBeneficiario . substr(str_replace(" ", "", $item->cidade), 0, 5));
                $retorno = $contaDAO->atualizaBoletoBrasil($p, $id, $controle_id_empresa);
                break;
        }

        $titulo = 'Mensagem da página web';
        $msg = 'Boleto alterado com sucesso!';
        $pag = 'financeiro_boleto.php';
        $funcJs = "openAlertBox('" . $titulo . "','" . $msg . "','" . $pag . "');";
        echo '<img src="../images/null.gif" class="nulo" onload="' . $funcJs . '" />';
    }
    $p->vencimento = date('d/m/Y', strtotime($p->vencimento));
}


#exclus?o do boleto antes de registrar
if ($submit_deleta <> '' and $p->status == 0) {
    $errors = array();
    $error = '<div class="erro"><b>Ocorreram os seguintes erros:</b><br>';
    $cont = 0;

    if (COUNT($errors) == 0) {
        $done = $contaDAO->deletaBoletoBrad($id, $controle_id_empresa);
        //alterado 01/04/2011
        $titulo = 'Mensagem da página web';
        $msg = 'Boleto deletado com sucesso!';
        $pagina = 'financeiro_boleto.php';
        $funcJs = "openAlertBox('" . $titulo . "','" . $msg . "','" . $pagina . "');";
        echo '<img src="../images/null.gif" class="nulo" onload="' . $funcJs . '" />';
        exit;
    }

    if ($errors) {
        echo $error . "</div>";
    }
}

?>
    <div id="topo">
        <h1 class="tit"><img src="../images/tit/tit_recebimento.png" alt="Título"/>Alterar Boleto</h1>
        <a href="#" class="topo">topo</a>
        <hr class="tit"/>
    </div>
<div id="meio">
<div id="retorno" style="position:relative;width:690px;margin:auto;border:solid 1px #0D357D;padding:1px">

<table style="width:690px;border:0" class="tabela">
<tbody>
<tr>

    <td class="tabela_tit">Dados do Boleto <? if ($p->carga == 'M') echo "- Manualmente"; ?></td>

</tr>
<tr>
<form method="POST" action="" name="form_auto" enctype="multipart/form-data"
      onsubmit="if(submit_deleta_.value==1) return confirmDelete();">
<td id="td_implantacao">

<label>Banco: </label>
<select name="id_conta" id="id_conta" disabled
        class="form_estilo<? if ($errors['id_conta'] == 1) echo '_erro' ?>"
        style=" width:110px; ">
    <?
    $lista = $contaDAO->listarContaBoleto($controle_id_empresa);
    $p_valor = '';
    foreach ($lista as $l) {
        $p_valor .= '<option value="' . $l->id_conta . '"';
        if ($l->id_conta == $id_conta) $p_valor .= 'selected="select"';
        $p_valor .= '>' . $l->sigla . '</option>';
    }
    echo $p_valor;
    ?>
</select>
<font style="float:left;color:#FF0000;">*</font>
<label>Fatura: </label>
<input type="text" id="id_fatura" maxlength="10" readonly name="id_fatura"
       value="<?= $p->id_fatura ?>"
       onKeyUp="masc_numeros(this,'##########');" class="form_estilo_r" style=" width:100px; "/>

<label for="valor">Valor Rec.: </label>
<input type="text" id="valor_pago" name="valor_pago" value="<?= $p->valor_pago ?>" class="form_estilo_r"
       readonly style=" width:90px; "/>
<br/>
<label for="tipo">Tipo: </label>
<select name="tipo" id="tipo" class="form_estilo<? if ($errors['tipo'] == 1) echo '_erro' ?>"
        style=" width:110px; ">
    <option value="1" <? if ($p->tipo == '1') echo 'selected'; ?>>CPF</option>
    <option value="2" <? if ($p->tipo == '2') echo 'selected'; ?>>CNPJ</option>
    <option value="98" <? if ($p->tipo == '98') echo 'selected'; ?>>Não Tem</option>
    <option value="99" <? if ($p->tipo == '99') echo 'selected'; ?>>Outros</option>
</select>
<font style="float:left;color:#FF0000;">*</font>
<label for="cpf">CPF/CNPJ: </label>
<input type="text" id="cpf" maxlength="20" name="cpf" value="<?= $p->cpf ?>"
       onKeyUp="if(tipo.value=='1') masc_numeros(this,'###.###.###-##'); else if(tipo.value=='2') masc_numeros(this,'##.###.###/####-##'); else masc_numeros(this,'##############');"
       class="form_estilo<? if ($errors['cpf'] == 1) echo '_erro' ?>" style=" width:100px; "/>
<label for="nota">Nota: </label>
<input type="text" id="id_nota" maxlength="10" name="id_nota" value="<?= $p->id_nota ?>"
       onKeyUp="masc_numeros(this,'##########');"
       class="form_estilo<? if ($errors['id_nota'] == 1) echo '_erro' ?>" style=" width:90px; "/>
<br/>

<label for="sacado">Sacado: </label>
<input type="text" id="sacado" maxlength="40" name="sacado" value="<?= $p->sacado ?>"
       class="form_estilo<? if ($errors['sacado'] == 1) echo '_erro' ?>" style=" width:550px; "/>
<font style="float:left;color:#FF0000;">*</font>
<br/>

<label for="endereco">Endereço: </label>
<input type="text" id="endereco" maxlength="40" name="endereco" value="<?= $p->endereco ?>"
       class="form_estilo<? if ($errors['endereco'] == 1) echo '_erro' ?>" style=" width:550px; "/>
<font style="float:left;color:#FF0000;">*</font>
<br/>

<label for="endereco">Bairro: </label>
<input type="text" id="bairro" maxlength="70" name="bairro" value="<?= $p->bairro ?>"
       class="form_estilo<? if ($errors['bairro'] == 1) echo '_erro' ?>" style=" width:110px; margin-right:11px;"/>

<label for="endereco">Cidade: </label>
<input type="text" id="cidade" maxlength="70" name="cidade" value="<?= $p->cidade ?>"
       class="form_estilo<? if ($errors['cidade'] == 1) echo '_erro' ?>" style=" width:150px; "/>
<label for="endereco">Estado: </label>
<input type="text" id="estado" maxlength="2" name="estado" value="<?= $p->estado ?>"
       class="form_estilo<? if ($errors['estado'] == 1) echo '_erro' ?>" style=" width:39px;"/>
<br/>

<label for="cep">CEP: </label>
<input type="text" id="cep" maxlength="9" name="cep" value="<?= $p->cep ?>"
       onKeyUp="masc_numeros(this,'#####-###');"
       class="form_estilo<? if ($errors['cep'] == 1) echo '_erro' ?>" style=" width:110px; "/>
<font style="float:left;color:#FF0000;">*</font>

<label for="vencimento">Vencimento: </label>
<input type="text" id="vencimento" maxlength="10" name="vencimento" value="<?= $p->vencimento ?>"
       onKeyUp="masc_numeros(this,'##/##/####');"
       class="form_estilo<? if ($errors['vencimento'] == 1) echo '_erro' ?>" style=" width:100px; "/>
<font style="float:left;color:#FF0000;">*</font>
<label for="valor">Valor: </label>
<input type="text" id="valor" maxlength="10" name="valor" value="<?= $p->valor ?>"
       onkeyup="moeda(event.keyCode,this.value,'valor');"
       class="form_estilo<? if ($errors['valor'] == 1) echo '_erro' ?>" style=" width:84px; "/>
<font style="float:left;color:#FF0000;">*</font>
<br/>

<div class="divBancoBradesco"
     style="display:<? if ($id_conta == 2) echo 'block;'; else echo 'none;'; ?>;">
    <label for="juros_mora">Mora diária: </label>
    <input type="text" id="juros_mora" maxlength="10" name="juros_mora" value="<?= $p->juros_mora ?>"
           onkeyup="moeda(event.keyCode,this.value,'valor');"
           class="form_estilo<? if ($errors['juros_mora'] == 1) echo '_erro' ?>" style=" width:110px; "/>
    <br/>
</div>
<div class="divBancoBrasil"
     style="display: <? if ($id_conta > 2) echo 'block;'; else echo 'none;'; ?>">
    <label>Multa: </label>
    <select name="ddlMulta" id="ddlMulta"
            class="form_estilo<? if ($errors['ddlMulta'] == 1) echo '_erro' ?>"
            style=" width:111px; ">
        <option value=""></option>
        <option value="1" <? if ($p->tipo_multa == '1') echo 'selected'; ?>>Dispensar</option>
        <option value="2" <? if ($p->tipo_multa == '2') echo 'selected'; ?>>% ao mes</option>
    </select>
    <font style="float:left;color:#FF0000;">*</font>

    <div id="divValorMulta" style="display: <? if ($p->tipo_multa == '2') echo 'block'; else echo 'none'; ?> ;">
        <label>Valor multa:</label>
        <input type="text" id="txtValorMulta" maxlength="5" name="txtValorMulta"
               value="<?= $p->valor_multa ?>"
               onkeyup="moeda(event.keyCode,this.value,'valor');"
               class="form_estilo<? if ($errors['txtValorMulta'] == 1) echo '_erro' ?>"
               style=" width:100px; "/>
        <font style="float:left;color:#FF0000;">*</font>
    </div>
    <label>Data Multa: </label>
    <input type="text" id="txtDataMulta" maxlength="10" name="txtDataMulta"
           onKeyUp="masc_numeros(this,'##/##/####');" value="<?= date("d/m/Y", strtotime($p->data_multa)) ?>"
           class="form_estilo<? if ($errors['txtDataMulta'] == 1) echo '_erro' ?> calendario"
           style=" width:85px; "/>
    <font style="float:left;color:#FF0000;">*</font>
    <br/>
    <label>Juros: </label>
    <select name="ddlJuros" id="ddlJuros"
            class="form_estilo<? if ($errors['ddlJuros'] == 1) echo '_erro' ?>"
            style=" width:111px; ">
        <option value=""></option>
        <option value="1" <? if ($p->tipo_juros == '1') echo 'selected'; ?>>Dispensar</option>
        <option value="2" <? if ($p->tipo_juros == '2') echo 'selected'; ?>>Valor fixo ao dia</option>
    </select>
    <font style="float:left;color:#FF0000;">*</font>

    <div id="divValorJuros" style="display: <? if ($p->tipo_juros == '2') echo 'block'; else echo 'none'; ?>;">
        <label>Valor Fixo:</label>
        <input type="text" id="txtValorJuros" maxlength="5" name="txtValorJuros" value="<?= $p->juros_mora ?>"
               onkeyup="moeda(event.keyCode,this.value,'valor');"
               class="form_estilo<? if ($errors['txtValorJuros'] == 1) echo '_erro' ?>"
               style=" width:100px; "/>
        <font style="float:left;color:#FF0000;">*</font>
    </div>
    <br/>

    <label>Pgto. Parcial:</label>
    <select name="ddlPgtoParcial" id="ddlPgtoParcial"
            class="form_estilo<? if ($errors['ddlPgtoParcial'] == 1) echo '_erro' ?>"
            style=" width:111px; ">
        <option value=""></option>
        <option value="S" <? if ($p->pgto_parcial == '1') echo 'selected'; ?>>Sim</option>
        <option value="N" <? if ($p->pgto_parcial == '0') echo 'selected'; ?>>Não</option>
    </select>

    <font style="float:left;color:#FF0000;">*</font>
    <label>Dias protesto: </label>
    <input type="text" id="txtDiasProtesto" maxlength="2" name="txtDiasProtesto" value="<?= $p->dias_protesto ?>"
           onKeyUp="masc_numeros(this,'##');"
           class="form_estilo<? if ($errors['txtDiasProtesto'] == 1) echo '_erro' ?>"
           style=" width:100px;"/>
    <font style="color:#FF0000;float:left;">*</font>
    <label>N° Beneficiário: </label>
    <input type="text" id="txtNumeroBeneficiario" maxlength="3" name="txtNumeroBeneficiario"
           value="<?= $p->numero_beneficiario ?>" readonly
           class="form_estilo_r<? if ($errors['txtNumeroBeneficiario'] == 1) echo '_erro' ?>"
           style=" width:85px; text-transform: uppercase;"/>
    <font style="color:#FF0000;">*</font>
    <br/>

    <label>Campo Livre: </label>
    <input type="text" id="txtCampoLivre" maxlength="60" name="txtCampoLivre"
           class="form_estilo" value="<?= $p->campo_livre ?>"
           style=" width:550px; "/>
    <br/>

    <label>CNPJ Sacador: </label>
    <input type="text" id="txtCNPJSacador" maxlength="18" name="txtCNPJSacador"
           onKeyUp="masc_numeros(this,'##.###.###/####-##');" value="<?= $p->cpnj_sacador ?>"
           class="form_estilo<? if ($errors['txtCNPJSacador'] == 1) echo '_erro' ?>"
           style=" width:109px;"/>
    <font style="float:left;color:#FF0000;">*</font>
    <label>Nome Sacador: </label>
    <input type="text" id="txtNomeSacador" maxlength="50" name="txtNomeSacador" value="<?= $p->nome_sacador ?>"
           class="form_estilo<? if ($errors['txtCNPJSacador'] == 1) echo '_erro' ?>"
           style=" width:314px; text-transform: uppercase;"/>
    <font style="float:left;color:#FF0000;">*</font>
    <br/>
</div>
<label for="ocorrencia">Ocorrência: </label>
<select name="ocorrencia" id="ocorrencia"
        class="form_estilo<? if ($errors['ocorrencia'] == 1) echo '_erro' ?>" style=" width:552px; ">
    <option value="1" <? if ($p->ocorrencia == '1') echo 'selected="select"'; ?>>Remessa</option>
</select>
<font style="float:left;color:#FF0000;">*</font>
<br/>

<div class="divBancoBradesco"
     style="display:<? if ($id_conta == 2) echo 'block;'; else echo 'none;'; ?>;">
    <label for="instrucao1">Instrução 1: </label>
    <select name="instrucao1" id="instrucao1"
            class="form_estilo<? if ($errors['instrucao1'] == 1) echo '_erro' ?>" style=" width:552px; ">
        <option value=""></option>
        <option value="6" <? if ($p->instrucao1 == '6') echo 'selected="select"'; ?>>Protestar</option>
        <option value="8" <? if ($p->instrucao1 == '8') echo 'selected="select"'; ?>>Não cobrar juros de
            mora
        </option>
        <option value="9" <? if ($p->instrucao1 == '9') echo 'selected="select"'; ?>>Não receber após o
            vencimento
        </option>
        <option value="11" <? if ($p->instrucao1 == '11') echo 'selected="select"'; ?>>Não receber após o 8°
            dia do vencimento
        </option>
        <option value="12" <? if ($p->instrucao1 == '12') echo 'selected="select"'; ?>>Cobrar encargos após
            o 5° dia do vencimento
        </option>
        <option value="13" <? if ($p->instrucao1 == '13') echo 'selected="select"'; ?>>Cobrar encargos após
            o 10° dia do vencimento
        </option>
        <option value="14" <? if ($p->instrucao1 == '14') echo 'selected="select"'; ?>>Cobrar encargos após
            o 15° dia do vencimento
        </option>
    </select>
    <br/>

    <label for="instrucao2">Instrução 2: </label>
    <input type="text" id="instrucao2" maxlength="2" name="instrucao2" value="<?= $p->instrucao2 ?>"
           onKeyUp="masc_numeros(this,'##');"
           class="form_estilo<? if ($errors['instrucao2'] == 1) echo '_erro' ?>" style=" width:552px; "/>
    <br/>
</div>
<label for="mensagem1">Mensagem 1: </label>
<input type="text" id="mensagem1" maxlength="12" name="mensagem1" value="<?= $p->mensagem1 ?>"
       class="form_estilo<? if ($errors['mensagem1'] == 1) echo '_erro' ?>" style=" width:552px; "/>
<br/>

<label for="mensagem2">Mensagem 2: </label>
<input type="text" id="mensagem2" maxlength="60" name="mensagem2" value="<?= $p->mensagem2 ?>"
       class="form_estilo<? if ($errors['mensagem2'] == 1) echo '_erro' ?>" style=" width:552px; "/>
<br/>

<div class="divBancoBrasil"
     style="display: <? if ($id_conta > 2) echo 'block;'; else echo 'none;'; ?>;">
    <label for="mensagem2">Mensagem 3: </label>
    <input type="text" id="mensagem3" maxlength="60" name="mensagem3" value="<?= $p->mensagem3 ?>"
           class="form_estilo<? if ($errors['mensagem3'] == 1) echo '_erro' ?>" style=" width:552px; "/>
    <br/>
</div>
<label for="emissao_papeleta">Emitir Papeleta: </label>
<select name="emissao_papeleta" id="emissao_papeleta"
        class="form_estilo<? if ($errors['emissao_papeleta'] == 1) echo '_erro' ?>"
        style=" width:110px; ">
    <option value="1" <? if ($p->emissao_papeleta == '1') echo 'selected="select"'; ?>>Pelo Banco
    </option>
    <option value="2" <? if ($p->emissao_papeleta == '2') echo 'selected="select"'; ?>>Pela Empresa
    </option>
</select>
<font style="float:left;color:#FF0000;">*</font>

<label for="especie">Espécie: </label>
<select name="especie" id="especie" class="form_estilo<? if ($errors['especie'] == 1) echo '_erro' ?>"
        style=" width:139px; ">
    <option value="1" <? if ($p->especie == '1') echo 'selected="select"'; ?>>Duplicata</option>
    <option value="2" <? if ($p->especie == '2') echo 'selected="select"'; ?>>Nota Promissória</option>
    <option value="3" <? if ($p->especie == '3') echo 'selected="select"'; ?>>Nota de Seguro</option>
    <option value="4" <? if ($p->especie == '4') echo 'selected="select"'; ?>>Cobrança Seriada</option>
    <option value="5" <? if ($p->especie == '5') echo 'selected="select"'; ?>>Recibo</option>
    <option value="10" <? if ($p->especie == '10') echo 'selected="select"'; ?>>Letras de Câmbio
    </option>
    <option value="11" <? if ($p->especie == '11') echo 'selected="select"'; ?>>Nota de Débito</option>
    <option value="12" <? if ($p->especie == '12') echo 'selected="select"'; ?>>Duplicata de Serv.
    </option>
    <option value="99" <? if ($p->especie == '99') echo 'selected="select"'; ?>>Outros</option>
</select>
<font style="float:left;color:#FF0000;">*</font>
<label for="aceite">Aceite: </label>
<select name="aceite" id="aceite" class="form_estilo<? if ($errors['aceite'] == 1) echo '_erro' ?>"
        style=" width:50px; ">
    <option value="A" <? if ($p->aceite == 'A') echo 'selected="select"'; ?>>A</option>
    <option value="N" <? if ($p->aceite == 'N') echo 'selected="select"'; ?>>N</option>
</select>
<font style="float:left;color:#FF0000;">*</font>

<div style="text-align:center;width:100%">
    <? if ($p->status == 0) { ?>
        <input type="submit" name="submit_form" value="Atualizar" class="button_busca"/>&nbsp;
        <input type="submit" name="submit_deleta" onclick="submit_deleta_.value='1'" value="Excluir"
               class="button_busca"/>&nbsp;
        <input type="hidden" name="submit_deleta_" value=""/>
    <? } ?>
    <input type="submit" onclick="document.form_auto.action='financeiro_boleto.php'" name="submit_form2"
           value="Voltar" class="button_busca"/>
</div>
<br/>
</td>
</form>
</tr>
<? if ($p->status == 1 and $p->id_ocorrencia != 6 and $p->id_ocorrencia != 15 and $p->id_ocorrencia != 16 and $p->id_ocorrencia != 17 and $p->id_ocorrencia != 100 and $p->id_ocorrencia != 101) { ?>
    <tr>
        <td class="tabela_tit">Nova Ocorrência</td>
    </tr>
    <tr>
        <form method="POST" action="" class="form_auto" name="form_auto2" enctype="multipart/form-data">
            <td id="td_implantacao">
                <label for="ocorrencia">Ocorrência: </label>
                <select name="ocorrencia" id="ocorrencia"
                        class="form_estilo<? if ($errors['ocorrencia'] == 1) echo '_erro' ?>" style=" width:338px;"
                        onchange="ocorrencia_brad(this.value);">
                    <option value=""></option>
                    <? if ($p->id_ocorrencia == 9 or $p->id_ocorrencia == 10) { ?>
                        <option value="100" <? if ($p->ocorrencia == '100') echo 'selected="select"'; ?>>Valor
                            Recebido
                        </option>
                        <option value="101" <? if ($p->ocorrencia == '101') echo 'selected="select"'; ?>>Valor não
                            Recebido
                        </option>
                    <? } else { ?>
                        <option value="2" <? if ($p->ocorrencia == '2') echo 'selected="select"'; ?>>Pedido de baixa
                        </option>
                        <option value="6" <? if ($p->ocorrencia == '6') echo 'selected="select"'; ?>>Alteração de
                            vencimento
                        </option>
                        <option value="9" <? if ($p->ocorrencia == '9') echo 'selected="select"'; ?>>Pedido de
                            protesto
                        </option>
                        <option value="18" <? if ($p->ocorrencia == '18') echo 'selected="select"'; ?>>Sustar
                            protesto e
                            baixar Título
                        </option>
                        <option value="19" <? if ($p->ocorrencia == '19') echo 'selected="select"'; ?>>Sustar
                            protesto e
                            manter em carteira
                        </option>
                        <option value="31" <? if ($p->ocorrencia == '31') echo 'selected="select"'; ?>>Alteração de
                            outros dados
                        </option>
                    <? } ?>
                </select>
                <font style="float:left;color:#FF0000;">*</font>
                <br/>

                <div id="div_outros_dados" style="visibility:hidden; height:0px; overflow:hidden; clear:both">
                    <label for="tipo">Tipo: </label>
                    <select name="tipo" id="tipo" class="form_estilo<? if ($errors['tipo'] == 1) echo '_erro' ?>"
                            style=" width:110px; ">
                        <option value="1" <? if ($p->tipo == '1') echo 'selected="select"'; ?>>CPF</option>
                        <option value="2" <? if ($p->tipo == '2') echo 'selected="select"'; ?>>CNPJ</option>
                        <option value="98" <? if ($p->tipo == '98') echo 'selected="select"'; ?>>N?o Tem</option>
                        <option value="99" <? if ($p->tipo == '99') echo 'selected="select"'; ?>>Outros</option>
                    </select>
                    <font style="float:left;color:#FF0000;">*</font>

                    <label for="cpf">CPF/CNPJ: </label>
                    <input type="text" id="cpf" maxlength="20" name="cpf" value="<?= $p->cpf ?>"
                           onKeyUp="if(tipo.value=='1') masc_numeros(this,'###.###.###-##'); else if(tipo.value=='2') masc_numeros(this,'##.###.###/####-##'); else masc_numeros(this,'##############');"
                           class="form_estilo<? if ($errors['cpf'] == 1) echo '_erro' ?>" style=" width:140px; "/>

                    <font style="float:left;color:#FF0000;">*</font>
                    <input type="button" id="consultar" name="consultar" value="Consultar"
                           onclick="carrega_sacado('form_auto',cpf.value);" class="button_busca" style="float:left"
                           style=" width:120px; "/>
                    <br/>

                    <label for="sacado">Sacado: </label>
                    <input type="text" id="sacado" maxlength="40" name="sacado" value="<?= $p->sacado ?>"
                           class="form_estilo<? if ($errors['sacado'] == 1) echo '_erro' ?>"
                           style=" width:550px; "/>
                    <font style="float:left;color:#FF0000;">*</font>
                    <br/>

                    <label for="endereco">Endereço: </label>
                    <input type="text" id="endereco" maxlength="40" name="endereco" value="<?= $p->endereco ?>"
                           class="form_estilo<? if ($errors['endereco'] == 1) echo '_erro' ?>"
                           style=" width:550px; "/>
                    <font style="float:left;color:#FF0000;">*</font>
                    <br/>

                    <label for="endereco">Bairro: </label>
                    <input type="text" id="bairro" maxlength="70" name="bairro" value="<?= $p->bairro ?>"
                           class="form_estilo<? if ($errors['bairro'] == 1) echo '_erro' ?>"
                           style=" width:110px; margin-right:11px;"/>


                    <label for="endereco">Cidade: </label>
                    <input type="text" id="cidade" maxlength="70" name="cidade" value="<?= $p->cidade ?>"
                           class="form_estilo<? if ($errors['cidade'] == 1) echo '_erro' ?>"
                           style=" width:149px; "/>

                    <div class="asterisco"></div>

                    <label for="endereco">Estado: </label>
                    <input type="text" id="estado" maxlength="2" name="estado" value="<?= $p->estado ?>"
                           class="form_estilo<? if ($errors['estado'] == 1) echo '_erro' ?>" style=" width:40px;"/>
                    <br/>
                    <label for="cep">CEP: </label>
                    <input type="text" id="cep" maxlength="9" name="cep" value="<?= $p->cep ?>"
                           onKeyUp="masc_numeros(this,'#####-###');"
                           class="form_estilo<? if ($errors['cep'] == 1) echo '_erro' ?>" style=" width:110px; "/>

                    <font style="float:left;color:#FF0000;">*</font>

                    <label for="valor">Valor: </label>
                    <input type="text" id="valor" maxlength="10" name="valor" value="<?= $p->valor ?>"
                           onkeyup="moeda(event.keyCode,this.value,'valor');"
                           class="form_estilo<? if ($errors['valor'] == 1) echo '_erro' ?>" style=" width:120px; "/>

                    <font style="float:left;color:#FF0000;">*</font>

                    <label for="juros_mora">Mora diária: </label>
                    <input type="text" id="juros_mora" maxlength="10" name="juros_mora"
                           value="<?= $p->juros_mora ?>"
                           onkeyup="moeda(event.keyCode,this.value,'valor');"
                           class="form_estilo<? if ($errors['juros_mora'] == 1) echo '_erro' ?>"
                           style=" width:64px; "/>

                    <br/>
                    <label for="instrucao1">Instrução 1: </label>
                    <select name="instrucao1" id="instrucao1"
                            class="form_estilo<? if ($errors['instrucao1'] == 1) echo '_erro' ?>"
                            style=" width:550px; ">
                        <option value=""></option>
                        <option value="6" <? if ($p->instrucao1 == '6') echo 'selected="select"'; ?>>Protestar
                        </option>
                        <option value="8" <? if ($p->instrucao1 == '8') echo 'selected="select"'; ?>>N?o cobrar
                            juros de
                            mora
                        </option>
                        <option value="9" <? if ($p->instrucao1 == '9') echo 'selected="select"'; ?>>N?o receber
                            ap?s o
                            vencimento
                        </option>
                        <option value="11" <? if ($p->instrucao1 == '11') echo 'selected="select"'; ?>>N?o receber
                            ap?s
                            o 8? dia do vencimento
                        </option>
                        <option value="12" <? if ($p->instrucao1 == '12') echo 'selected="select"'; ?>>Cobrar
                            encargos
                            ap?s o 5? dia do vencimento
                        </option>
                        <option value="13" <? if ($p->instrucao1 == '13') echo 'selected="select"'; ?>>Cobrar
                            encargos
                            ap?s o 10? dia do vencimento
                        </option>
                        <option value="14" <? if ($p->instrucao1 == '14') echo 'selected="select"'; ?>>Cobrar
                            encargos
                            ap?s o 15? dia do vencimento
                        </option>
                    </select>
                    <br/>
                    <label for="instrucao2">Instrução 2: </label>
                    <input type="text" id="instrucao2" maxlength="2" name="instrucao2" value="<?= $p->instrucao2 ?>"
                           onKeyUp="masc_numeros(this,'##');"
                           class="form_estilo<? if ($errors['instrucao2'] == 1) echo '_erro' ?>"
                           style=" width:550px; "/>

                    <br/>

                    <label for="mensagem1">Mensagem 1: </label>
                    <input type="text" id="mensagem1" maxlength="12" name="mensagem1" value="<?= $p->mensagem1 ?>"
                           class="form_estilo<? if ($errors['mensagem1'] == 1) echo '_erro' ?>"
                           style=" width:550px; "/>

                    <br/>

                    <label for="mensagem2">Mensagem 2: </label>
                    <input type="text" id="mensagem2" maxlength="60" name="mensagem2" value="<?= $p->mensagem2 ?>"
                           class="form_estilo<? if ($errors['mensagem2'] == 1) echo '_erro' ?>"
                           style=" width:550px; "/>
                    <br/>
                </div>
                <div id="div_vencimento" style="visibility:hidden; height:0px; overflow:hidden; clear:both;">
                    <label for="vencimento">Vencimento: </label>
                    <input type="text" id="vencimento" maxlength="10" name="vencimento"
                           value="<?= $p->vencimento ?>"
                           onKeyUp="masc_numeros(this,'##/##/####');"
                           class="form_estilo<? if ($errors['vencimento'] == 1) echo '_erro' ?>"
                           style=" width:110px; "/>

                    <div class="asterisco">*</div>
                    <div style=" width:400px;  height:27px;  float:left;"></div>
                    <br/>
                </div>

                <div style="text-align:center;width:100%">
                    <input type="submit" name="submit_form" value="Adicionar" class="button_busca"/>&nbsp;
                    <input type="submit" onclick="document.form_auto2.action='financeiro_boleto.php'"
                           name="submit_form2" value="Voltar" class="button_busca"/>
                </div>
                <br/>
            </td>
        </form>
    </tr>
<?
}
if ($p->status != 0) {
    ?>
    <tr>
        <td class="tabela_tit">Histórico de Ocorrências Internas</td>
    </tr>
    <tr>
        <td id="td_implantacao">
            <table width="100%">
                <tr>
                    <td>
                        <?
                        $lista = $contaDAO->listaBoletoBradOco($id, $controle_id_empresa);

                        foreach ($lista as $l) {
                            if ($l->status == 0) $status = 'Não Registrado'; else $status = 'Registrado';

                            echo "<b>$l->data_oco</b> $status - $l->conta_oco<br>";
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="tabela_tit">Histórico de Ocorrências Bradesco</td>
    </tr>
    <tr>
        <td id="td_implantacao">
            <table width="100%">
                <tr>
                    <td>Data Ocorrência</td>
                    <td>Ocorrência</td>
                    <td>Despesas</td>
                    <td>Outras</td>
                    <td>Juros</td>
                    <td>IOF</td>
                    <td>Mora</td>
                    <td>Protesto</td>
                    <td colspan="5">Ocor1</td>
                </tr>
                <?
                $lista = $contaDAO->listaBoletoBradOcoRet($id, $controle_id_empresa);
                foreach ($lista as $l) {
                    ?>
                    <tr>
                        <td><?= $l->data_oco ?></td>
                        <td><?= $l->conta_oco ?></td>
                        <td>R$ <?= $l->despesa_cobranca ?></td>
                        <td>R$ <?= $l->outras_despesas ?></td>
                        <td>R$ <?= $l->juros_atraso ?></td>
                        <td>R$ <?= $l->iof ?></td>
                        <td>R$ <?= $l->juros_mora ?></td>
                        <td><?= $l->motivo_protesto ?></td>
                        <td><?= $l->motivo_ocorrencia1 ?></td>
                        <td><?= $l->motivo_ocorrencia2 ?></td>
                        <td><?= $l->motivo_ocorrencia3 ?></td>
                        <td><?= $l->motivo_ocorrencia4 ?></td>
                        <td><?= $l->motivo_ocorrencia5 ?></td>
                    </tr>
                <?
                }
                ?>
            </table>
        </td>
    </tr>
<?
}
?>
</tbody>
</table>
</div>
<?
if (count($errors) > 0) {
    ?>
    <br/>
    <div class="erro">
        <b>Ocorreram os seguintes erros:</b>
        <ul>
            <? echo $result; ?>
        </ul>
    </div>
<?
}
?>
<script type="text/javascript">
    $(function () {
        $("#ddlMulta").change(function () {
            if ($(this).val() != 2) {
                $("#txtValorMulta").val("");
                $('#divValorMulta').hide();
            } else {
                $('#divValorMulta').show();
            }
        });
        $("#ddlJuros").change(function () {
            if ($(this).val() != 2) {
                $("#txtValorJuros").val("");
                $('#divValorJuros').hide();
            } else {
                $('#divValorJuros').show();
            }
        });
        $("#id_conta").change(function () {
            if ($(this).val() != 2 && $(this).val() != "") {
                $("#mensagem1").attr("maxlength", 60);
                $('.divBancoBrasil').show();
                $('.divBancoBradesco').hide();
            } else {
                $('.divBancoBrasil').hide();
                $("#mensagem1").attr("maxlength", 12);
                $('.divBancoBradesco').show();
            }
            $("#mensagem1").val("");
        });
    });

    function ocorrencia_brad(ocor) {
        document.getElementById('div_vencimento').style.visibility = 'visible';
        document.getElementById('div_vencimento').style.height = '0px';
        document.getElementById('div_outros_dados').style.visibility = 'visible';
        document.getElementById('div_outros_dados').style.height = '0px';
        if (ocor == 6) {
            document.getElementById('div_vencimento').style.visibility = 'visible';
            document.getElementById('div_vencimento').style.height = 'auto';
        } else {
            if (ocor == 31) {
                document.getElementById('div_outros_dados').style.visibility = 'visible';
                document.getElementById('div_outros_dados').style.height = 'auto';
            }
        }
    }

</script>
<?php require('footer.php'); ?>