<?php require('header.php');

$permissao = verifica_permissao('Financeiro', $controle_id_departamento_p, $controle_id_departamento_s);
if ($permissao == 'FALSE') {
    echo '<br><br><strong>Voc� n�o tem permiss�o para acessar essa p�gina</strong>';
    exit;
}

#caso o link venha diretamente da tela financeiro_pagamento.php
pt_register('GET', 'id_fatura');

$p->id_fatura = $id_fatura;
$p->tipo = '1';
$p->ocorrencia = '1';
$p->emissao_papeleta = '2';
$p->especie = '12';
$p->aceite = 'N';

pt_register('POST', 'submit_form');
$validacaoCLASS = new ValidacaoCLASS();
$contaDAO = new ContaDAO();

if ($submit_form) {
    $result = '';
    $errors = array();
    $cont = 0;

    pt_register('POST', 'id_nota');
    pt_register('POST', 'id_fatura');
    pt_register('POST', 'tipo');
    pt_register('POST', 'cpf');
    pt_register('POST', 'sacado');
    pt_register('POST', 'id_conta');
    pt_register('POST', 'endereco');
    pt_register('POST', 'bairro');
    pt_register('POST', 'cidade');
    pt_register('POST', 'estado');
    pt_register('POST', 'cep');
    pt_register('POST', 'vencimento');
    pt_register('POST', 'valor');
    pt_register('POST', 'ocorrencia');
    pt_register('POST', 'mensagem1');
    pt_register('POST', 'mensagem2');
    pt_register('POST', 'emissao_papeleta');
    pt_register('POST', 'especie');
    pt_register('POST', 'aceite');

    if(empty($id_conta)){
        $errors['id_conta'] = 1;
        $result .= "<li>O campo <strong>Banco</strong> � obrigat�rio.</li>";
    }

    if (empty($tipo)) {
        $errors['tipo'] = 1;
        $result .= "<li>O campo <strong>Tipo</strong> � obrigat�rio.</li>";
    }

    if (empty($cpf)) {
        $errors["cpf"] = 1;
        $result .= "<li>O campo <strong>CPF/CNPJ</strong> � obrigat�rio.</li>";
    }

    if (empty($sacado)) {
        $errors['sacado'] = 1;
        $result .= "<li>O campo <strong>Sacado</strong> � obrigat�rio.</li>";
    }

    if (empty($endereco)) {
        $errors['endereco'] = 1;
        $result .= "<li>O campo <strong>Endere�o</strong> � obrigat�rio.</li>";
    }

    if (empty($bairro)) {
        $errors['bairro'] = 1;
        $result .= "<li>O campo <strong>Bairro</strong> � obrigat�rio.</li>";
    }

    if (empty($cidade)) {
        $errors['cidade'] = 1;
        $result .= "<li>O campo <strong>Cidade</strong> � obrigat�rio.</li>";
    }

    if (empty($cep)) {
        $errors['cep'] = 1;
        $result .= "<li>O campo <strong>CEP</strong> � obrigat�rio.</li>";
    }

    if (empty($vencimento)) {
        $errors['vencimento'] = 1;
        $result .= "<li>O campo <strong>Vencimento</strong> � obrigat�rio.</li>";
    }

    if (empty($valor)) {
        $errors['valor'] = 1;
        $result .= "<li>O campo <strong>Valor</strong> � obrigat�rio.</li>";
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
        pt_register("POST", "txtMensagem3");


        if (empty($ddlMulta)) {
            $errors['ddlMulta'] = 1;
            $result .= "<li>O campo <strong>Multa</strong> � obrigat�rio.</li>";
        }

        if (empty($txtValorMulta) && $$ddlMulta > 1) {
            $errors['txtValorMulta'] = 1;
            $result .= "<li>O campo <strong>Valor multa</strong> � obrigat�rio.</li>";
        }

        if (empty($txtDataMulta)) {
            $errors['txtDataMulta'] = 1;
            $result .= "<li>O campo <strong>Data multa</strong> � obrigat�rio.</li>";
        } else {
            $verifica = $validacaoCLASS->invertData($txtDataMulta);

            if ($verifica == false) {
                $errors['txtDataMulta'] = 1;
                $result .= '<li>O campo <strong>Data multa</strong> � inv�lido.</li>';
            } else {
                $txtDataMulta = $verifica;
            }
        }

        if (empty($ddlJuros)) {
            $errors['ddlJuros'] = 1;
            $result .= "<li>O campo <strong>Juros</strong> � obrigat�rio.</li>";
        }

        if (empty($txtValorJuros) && $ddlJuros > 1) {
            $errors['txtValorJuros'] = 1;
            $result .= "<li>O campo <strong>Valor Juros</strong> � obrigat�rio.</li>";
        }

        if (empty($ddlPgtoParcial)) {
            $errors['ddlPgtoParcial'] = 1;
            $result .= "<li>O campo <strong>Pgto Parcial</strong> � obrigat�rio.</li>";
        }

        if (empty($txtDiasProtesto)) {
            $errors['txtDiasProtesto'] = 1;
            $result .= "<li>O campo <strong>Dias Protesto</strong> � obrigat�rio.</li>";
        }

        if (empty($txtNumeroBeneficiario)) {
            $errors['txtNumeroBeneficiario'] = 1;
            $result .= "<li>O campo <strong>N� Benefici�rio</strong> � obrigat�rio.</li>";
        }

        if (empty($txtCNPJSacador)) {
            $errors['txtCNPJSacador'] = 1;
            $result .= "<li>O campo <strong>CNPJ Sacador</strong> � obrigat�rio.</li>";
        }

        if (empty($txtNomeSacador)) {
            $errors['txtNomeSacador'] = 1;
            $result .= "<li>O campo <strong>Nome Sacador</strong> � obrigat�rio.</li>";
        }

    } else {
        pt_register("POST", "juros_mora");
        pt_register('POST', 'instrucao1');
        pt_register('POST', 'instrucao2');

        if (empty($juros_mora)) {
            $errors['juros_mora'] = 1;
            $result .= "<li>O campo <strong>Mora di�ria</strong> � obrigat�rio.</li>";
        }

        if ($instrucao1 == 6 and $instrucao2 < 5) {
            $errors['instrucao2'] = 1;
            $error .= '<li>O campo instru��o 2 n�o pode ser menor que 5</li>';
        }
    }

    if (empty($ocorrencia)) {
        $errors['ocorrencia'] = 1;
        $result .= "<li>O campo <strong>Ocorr�ncia</strong> � obrigat�rio.</li>";
    }

    if (empty($emissao_papeleta)) {
        $errors['emissao_papeleta'] = 1;
        $result .= "<li>O campo <strong>Papeleta</strong> � obrigat�rio.</li>";
    }

    if (empty($especie)) {
        $errors['especie'] = 1;
        $result .= "<li>O campo <strong>Esp�cie</strong> � obrigat�rio.</li>";
    }

    if (empty($aceite)) {
        $errors['aceite'] = 1;
        $result .= "<li>O campo <strong>Aceite</strong> � obrigat�rio.</li>";
    }

    if (invert($vencimento, '-', 'SQL') < date('Y-m-d')) {
        $errors['vencimento'] = 1;
        $result .= '<li>A data de <strong>Vencimento</strong> n�o pode ser inferior ao dia de hoje.</li>';
    }

    $verifica = $validacaoCLASS->invertData($vencimento);
    if ($verifica == false) {
        $errors['vencimento'] = 1;
        $result .= '<li>O campo <strong>Vencimento</strong> � inv�lido.</li>';
    } else {
        $vencimento = $verifica;
    }

    if ($id_fatura <> '') {
        $verifica_fatura = $contaDAO->verificaFatura($controle_id_empresa, $id_fatura);
        if ($verifica_fatura == 0 or $verifica_fatura == '') {
            $errors['id_fatura'] = 1;
            $result .= '<li>N�mero de Fatura inv�lido</li>';
        }
    }

    if (count($errors) == 0) {
        $p->tipo = $tipo;
        $p->cpf = $cpf;
        $p->id_nota = $id_nota;
        $p->id_fatura = $id_fatura;
        $p->id_conta = $id_conta;
        $p->separador = $separador;
        $p->sacado = $sacado;
        $p->endereco = $endereco;
        $p->bairro = $bairro;
        $p->cidade = $cidade;
        $p->estado = $estado;
        $p->cep = $cep;
        $p->vencimento = $vencimento;
        $p->valor = $valor;
        $p->ocorrencia = $ocorrencia;
        $p->mensagem1 = $mensagem1;
        $p->mensagem2 = $mensagem2;
        $p->emissao_papeleta = $emissao_papeleta;
        $p->especie = $especie;
        $p->aceite = $aceite;

        switch ($id_conta) {
            case 2:
                $p->juros_mora = $juros_mora;
                $p->instrucao1 = $instrucao1;
                $p->instrucao2 = $instrucao2;
                $retorno = $contaDAO->inserirBoletoBrad($p, $controle_id_empresa, $controle_id_usuario);
                break;
            default:
                $p->instrucao1 = 0;
                $p->instrucao2 = 0;
                $p->tipo_multa = $ddlMulta;
                $p->valor_multa = ($ddlMulta == 1) ? null : $txtValorMulta;
                $p->data_multa = $txtDataMulta;
                $p->tipo_juros = $ddlJuros;
                $p->juros_mora = ($ddlJuros == 1) ? 0 : $txtValorJuros;
                $p->dias_protesto = date('Y-m-d', strtotime("+$txtDiasProtesto days", strtotime($vencimento)));
                $p->pgto_parcial = ($ddlPgtoParcial == 'S') ? true : false;
                $p->campo_livre = $txtCampoLivre;
                $p->cpnj_sacador = $txtCNPJSacador;
                $p->nome_sacador = strtoupper($txtNomeSacador);
                $p->mensagem3 = strtoupper($txtMensagem3);
                $p->txtNumeroBeneficiario = strtoupper($txtNumeroBeneficiario . substr(str_replace(" ", "", $item->cidade), 0, 5));
                $retorno = $contaDAO->inserirBoletoBrasil($p, $controle_id_empresa, $controle_id_usuario);
                break;
        }

        if ($retorno > 0) {
            $titulo = 'Mensagem da p�gina web';
            $msg = 'Boleto emitido com sucesso!';
            $pag = 'financeiro_boleto.php';
            $funcJs = "openAlertBox('" . $titulo . "','" . $msg . "','" . $pag . "');";
            echo '<img src="../images/null.gif" class="nulo" onload="' . $funcJs . '" />';
        }else{
            $titulo = 'Mensagem da p�gina web';
            $msg = 'Erro na emiss�o do boleto!';
            $pag = '';
            $funcJs = "openAlertBox('" . $titulo . "','" . $msg . "','" . $pag . "');";
            echo '<img src="../images/null.gif" class="nulo" onload="' . $funcJs . '" />';
        }
    }
}
if ($p->vencimento <> '')
    $p->vencimento = invert($p->vencimento, '/', 'PHP');
?>
    <div id="topo">
        <h1 class="tit"><img src="../images/tit/tit_recebimento.png" alt="T�tulo"/>Adicionar Boleto</h1>
        <a href="#" class="topo">topo</a>
        <hr class="tit"/>
    </div>
    <div id="meio">
    <form method="POST" action="" name="form_auto" id="form_auto" enctype="multipart/form-data">
    <div id="retorno" style="position:relative;width:690px;margin:auto;border:solid 1px #0D357D;padding:1px">
    <table style="width:690px;border:0" class="tabela">
    <tbody>
    <tr>
        <td class="tabela_tit">Dados do Boleto</td>
    </tr>
    <tr>
    <td id="td_implantacao">
    <label>Banco: </label>
    <select name="id_conta" id="id_conta"
            class="form_estilo<? if ($errors['id_conta'] == 1) echo '_erro' ?>"
            style=" width:110px; ">
        <option value="" selected>
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
    <input type="text" id="id_fatura" maxlength="10" name="id_fatura"
           value="<?= $p->id_fatura ?>"
           onKeyUp="masc_numeros(this,'##########');"
           class="form_estilo<? if ($errors['id_fatura'] == 1) echo '_erro' ?>"
           style=" width:100px; "/>

    <label for="nota">Nota: </label>
    <input type="text" id="id_nota" maxlength="10" name="id_nota"
           value="<?= $p->id_nota ?>" onKeyUp="masc_numeros(this,'##########');"
           class="form_estilo<? if ($errors['id_nota'] == 1) echo '_erro' ?>"
           style=" width:95px; "/>
    <br/>

    <label for="tipo">Tipo: </label>
    <select name="tipo" id="tipo"
            class="form_estilo<? if ($errors['tipo'] == 1) echo '_erro' ?>"
            style=" width:110px; ">
        <option value=""></option>
        <option value="1"<? if ($p->tipo == '1') echo 'selected="select"'; ?>>
            CPF
        </option>
        <option value="2"<? if ($p->tipo == '2') echo 'selected="select"'; ?>>
            CNPJ
        </option>
        <option value="98"<? if ($p->tipo == '98') echo 'selected="select"'; ?>>
            N�o
            Tem
        </option>
        <option value="99"<? if ($p->tipo == '99') echo 'selected="select"'; ?>>
            Outros
        </option>
    </select>
    <font style="float:left;color:#FF0000;">*</font>

    <label for="cpf">CPF/CNPJ: </label>
    <input type="text" id="cpf" maxlength="20" name="cpf" value="<?= $p->cpf ?>"
           onKeyUp="if(tipo.value=='1') masc_numeros(this,'###.###.###-##'); else if(tipo.value=='2') masc_numeros(this,'##.###.###/####-##'); else masc_numeros(this,'##############');"
           class="form_estilo<? if ($errors['cpf'] == 1) echo '_erro' ?>"
           style=" width:140px; "/>

    <input type="button" id="consultar" name="consultar" value="Consultar"
           onclick="carrega_sacado('form_auto',cpf.value);" class="button_busca"
           style="float:left" style=" width:120px; "/>
    <font style="float:left;color:#FF0000;">*</font>
    <br/>

    <label for="sacado">Sacado: </label>
    <input type="text" id="sacado" maxlength="40" name="sacado"
           value="<?= $p->sacado ?>"
           class="form_estilo<? if ($errors['sacado'] == 1) echo '_erro' ?>"
           style=" width:555px; "/>
    <font style="float:left;color:#FF0000;">*</font>
    <br/>

    <label for="endereco">Endere�o: </label>
    <input type="text" id="endereco" maxlength="40" name="endereco"
           value="<?= $p->endereco ?>"
           class="form_estilo<? if ($errors['endereco'] == 1) echo '_erro' ?>"
           style=" width:555px; "/>
    <font style="float:left;color:#FF0000;">*</font>
    <br/>

    <label for="endereco">Bairro: </label>
    <input type="text" id="bairro" maxlength="70" name="bairro"
           value="<?= $p->bairro ?>"
           class="form_estilo<? if ($errors['bairro'] == 1) echo '_erro' ?>"
           style=" width:109px; "/>
    <font style="float:left;color:#FF0000;">*</font>

    <label for="endereco">Cidade: </label>
    <input type="text" id="cidade" maxlength="70" name="cidade"
           value="<?= $p->cidade ?>"
           class="form_estilo<? if ($errors['cidade'] == 1) echo '_erro' ?>"
           style=" width:142px; "/>
    <font style="float:left;color:#FF0000;">*</font>

    <label for="endereco">Estado: </label>
    <input type="text" id="estado" maxlength="2" name="estado"
           value="<?= $p->estado ?>"
           class="form_estilo<? if ($errors['estado'] == 1) echo '_erro' ?>"
           style=" width:48px;"/>
    <br/>

    <label for="cep">CEP: </label>
    <input type="text" id="cep" maxlength="9" name="cep" value="<?= $p->cep ?>"
           onKeyUp="masc_numeros(this,'#####-###');"
           class="form_estilo<? if ($errors['cep'] == 1) echo '_erro' ?>"
           style=" width:109px; "/>
    <font style="float:left;color:#FF0000;">*</font>
    <label for="vencimento">Vencimento: </label>
    <input type="text" id="vencimento" maxlength="10" name="vencimento"
           value="<?= $p->vencimento ?>"
           onKeyUp="masc_numeros(this,'##/##/####');"
           class="form_estilo<? if ($errors['vencimento'] == 1) echo '_erro' ?> calendario"
           style=" width:100px; "/>
    <font style="float:left;color:#FF0000;">*</font>

    <label for="valor">Valor: </label>
    <input type="text" id="valor" maxlength="10" name="valor"
           value="<?= $p->valor ?>"
           onkeyup="moeda(event.keyCode,this.value,'valor');"
           class="form_estilo<? if ($errors['valor'] == 1) echo '_erro' ?>"
           style=" width:90px; "/>
    <font style="float:left;color:#FF0000;">*</font>
    <br/>

    <div class="divBancoBradesco"
         style="display:<? if ($id_conta == 2) echo 'block;'; else echo 'none;'; ?>;">
        <label for="juros_mora">Mora di�ria: </label>
        <input type="text" id="juros_mora" maxlength="10" name="juros_mora"
               value="<?= $p->juros_mora ?>"
               onkeyup="moeda(event.keyCode,this.value,'valor');"
               class="form_estilo<? if ($errors['juros_mora'] == 1) echo '_erro' ?>"
               style=" width:109px; "/>
        <font style="float:left;color:#FF0000;">*</font>
        <br/>
    </div>
    <div class="divBancoBrasil"
         style="display: <? if ($id_conta > 2) echo 'block;'; else echo 'none;'; ?>">
        <label>Multa: </label>
        <select name="ddlMulta" id="ddlMulta"
                class="form_estilo<? if ($errors['ddlMulta'] == 1) echo '_erro' ?>"
                style=" width:110px; ">
            <option value=""></option>
            <option value="1">Dispensar</option>
            <option value="2">% ao mes</option>
        </select>
        <font style="float:left;color:#FF0000;">*</font>

        <div id="divValorMulta" style="display: none;">
            <label>Valor multa:</label>
            <input type="text" id="txtValorMulta" maxlength="5" name="txtValorMulta"
                   value=""
                   onkeyup="moeda(event.keyCode,this.value,'valor');"
                   class="form_estilo<? if ($errors['txtValorMulta'] == 1) echo '_erro' ?>"
                   style=" width:100px; "/>
            <font style="float:left;color:#FF0000;">*</font>
        </div>
        <br/>

        <label>Data Multa: </label>
        <input type="text" id="txtDataMulta" maxlength="10" readonly name="txtDataMulta"
               onKeyUp="masc_numeros(this,'##/##/####');" value=""
               class="form_estilo<? if ($errors['txtDataMulta'] == 1) echo '_erro' ?> calendario"
               style=" width:109px; "/>
        <font style="float:left;color:#FF0000;">*</font>

        <label>Juros: </label>
        <select name="ddlJuros" id="ddlJuros"
                class="form_estilo<? if ($errors['ddlJuros'] == 1) echo '_erro' ?>"
                style=" width:101px; ">
            <option value=""></option>
            <option value="1">Dispensar</option>
            <option value="2">Valor fixo ao dia</option>
        </select>
        <font style="float:left;color:#FF0000;">*</font>

        <div id="divValorJuros" style="display: none;">
            <label>Valor Fixo:</label>
            <input type="text" id="txtValorJuros" maxlength="5" name="txtValorJuros" value=""
                   onkeyup="moeda(event.keyCode,this.value,'valor');"
                   class="form_estilo<? if ($errors['txtValorJuros'] == 1) echo '_erro' ?>"
                   style=" width:90px; "/>
            <font style="float:left;color:#FF0000;">*</font>
        </div>
        <br/>

        <label>Pgto. Parcial:</label>
        <select name="ddlPgtoParcial" id="ddlPgtoParcial"
                class="form_estilo<? if ($errors['ddlPgtoParcial'] == 1) echo '_erro' ?>"
                style=" width:110px; ">
            <option value=""></option>
            <option value="S">Sim</option>
            <option value="N">N�o</option>
        </select>
        <font style="float:left;color:#FF0000;">*</font>

        <label>Dias protesto: </label>
        <input type="text" id="txtDiasProtesto" maxlength="2" name="txtDiasProtesto" value=""
               onKeyUp="masc_numeros(this,'##');"
               class="form_estilo<? if ($errors['txtDiasProtesto'] == 1) echo '_erro' ?>"
               style=" width:100px;"/>
        <font style="color:#FF0000;float:left;">*</font>

        <label>N� Benefici�rio: </label>
        <input type="text" id="txtNumeroBeneficiario" maxlength="3" name="txtNumeroBeneficiario"
               value=""
               class="form_estilo<? if ($errors['txtNumeroBeneficiario'] == 1) echo '_erro' ?>"
               style=" width:89px; text-transform: uppercase;"/>
        <font style="color:#FF0000;">*</font>
        <br/>

        <label>Campo Livre: </label>
        <input type="text" id="txtCampoLivre" maxlength="60" name="txtCampoLivre"
               class="form_estilo"
               style=" width:554px; "/>
        <br/>
        <label>CNPJ Sacador: </label>
        <input type="text" id="txtCNPJSacador" maxlength="18" name="txtCNPJSacador"
               onKeyUp="masc_numeros(this,'##.###.###/####-##');"
               class="form_estilo<? if ($errors['txtCNPJSacador'] == 1) echo '_erro' ?>"
               style=" width:109px;"/>
        <font style="float:left;color:#FF0000;">*</font>
        <label>Nome Sacador: </label>
        <input type="text" id="" maxlength="50" name="txtNomeSacador"
               class="form_estilo<? if ($errors['txtCNPJSacador'] == 1) echo '_erro' ?>"
               style=" width:317px; text-transform: uppercase;"/>
        <font style="float:left;color:#FF0000;">*</font>
        <br/>
    </div>

    <label for="ocorrencia">Ocorr�ncia: </label>
    <select name="ocorrencia" id="ocorrencia" class="form_estilo_r" readonly
            style=" width:555px; ">
        <option value="1" selected="select">Remessa</option>
    </select>
    <br/>

    <div class="divBancoBradesco"
         style="display:<? if ($id_conta == 2) echo 'block;'; else echo 'none;'; ?>;">
        <label for="instrucao1">Instru��o 1: </label>
        <select name="instrucao1" id="instrucao1"
                onchange="if(instrucao1.value!=6) instrucao2.value=''; else instrucao2.value=5;"
                class="form_estilo<? if ($errors['instrucao1'] == 1) echo '_erro' ?>"
                style=" width:555px; ">
            <option value=""></option>
            <option
                value="6"<? if ($p->instrucao1 == '6') echo 'selected="select"'; ?>>
                Protestar
            </option>
            <option
                value="8"<? if ($p->instrucao1 == '8') echo 'selected="select"'; ?>>
                N�o
                cobrar juros de mora
            </option>
            <option
                value="9"<? if ($p->instrucao1 == '9') echo 'selected="select"'; ?>>
                N�o
                receber ap�s o vencimento
            </option>
            <option
                value="11"<? if ($p->instrucao1 == '11') echo 'selected="select"'; ?>>
                N�o receber ap�s o 8� dia do vencimento
            </option>
            <option
                value="12"<? if ($p->instrucao1 == '12') echo 'selected="select"'; ?>>
                Cobrar encargos ap�s o 5� dia do vencimento
            </option>
            <option
                value="13"<? if ($p->instrucao1 == '13') echo 'selected="select"'; ?>>
                Cobrar encargos ap�s o 10� dia do vencimento
            </option>
            <option
                value="14"<? if ($p->instrucao1 == '14') echo 'selected="select"'; ?>>
                Cobrar encargos ap�s o 15� dia do vencimento
            </option>
        </select>
        <br/>

        <label for="instrucao2">Instru��o 2: </label>
        <input type="text" id="instrucao2" maxlength="2" name="instrucao2"
               value="<?= $p->instrucao2 ?>" onKeyUp="masc_numeros(this,'##');"
               class="form_estilo<? if ($errors['instrucao2'] == 1) echo '_erro' ?>"
               style=" width:554px; "/>
        <br/>
    </div>
    <label for="mensagem1">Mensagem 1: </label>
    <input type="text" id="mensagem1" maxlength="12" name="mensagem1"
           value="<?= $p->mensagem1 ?>"
           class="form_estilo<? if ($errors['mensagem1'] == 1) echo '_erro' ?>"
           style=" width:554px; "/>
    <br/>

    <label for="mensagem2">Mensagem 2: </label>
    <input type="text" id="mensagem2" maxlength="60" name="mensagem2"
           value="<?= $p->mensagem2 ?>"
           class="form_estilo<? if ($errors['mensagem2'] == 1) echo '_erro' ?>"
           style=" width:554px; "/>
    <br/>

    <div class="divBancoBrasil"
         style="display: <? if ($id_conta > 2) echo 'block;'; else echo 'none;'; ?>;">
        <label>Mensagem 3: </label>
        <input type="text" id="txtMensagem3" maxlength="60" name="txtMensagem3" value=""
               class="form_estilo"
               style=" width:554px; text-transform: uppercase"/>
        <br/>
    </div>

    <label for="emissao_papeleta">Emitir Papeleta: </label>
    <select name="emissao_papeleta" id="emissao_papeleta"
            class="form_estilo<? if ($errors['emissao_papeleta'] == 1) echo '_erro' ?>"
            style=" width:110px; ">
        <option
            value="1"<? if ($p->emissao_papeleta == '1') echo 'selected="select"'; ?>>
            Pelo Banco
        </option>
        <option
            value="2"<? if ($p->emissao_papeleta == '2') echo 'selected="select"'; ?>>
            Pela Empresa
        </option>
    </select>
    <font style="float:left;color:#FF0000;">*</font>

    <label for="especie">Esp�cie: </label>
    <select name="especie" id="especie"
            class="form_estilo<? if ($errors['especie'] == 1) echo '_erro' ?>"
            style=" width:144px; ">
        <option
            value="1"<? if ($p->especie == '1') echo 'selected="select"'; ?>>
            Duplicata
        </option>
        <option
            value="2"<? if ($p->especie == '2') echo 'selected="select"'; ?>>
            Nota
            Promiss�ria
        </option>
        <option
            value="3"<? if ($p->especie == '3') echo 'selected="select"'; ?>>
            Nota de
            Seguro
        </option>
        <option
            value="4"<? if ($p->especie == '4') echo 'selected="select"'; ?>>
            Cobran�a Seriada
        </option>
        <option
            value="5"<? if ($p->especie == '5') echo 'selected="select"'; ?>>
            Recibo
        </option>
        <option
            value="10"<? if ($p->especie == '10') echo 'selected="select"'; ?>>
            Letras de C�mbio
        </option>
        <option
            value="11"<? if ($p->especie == '11') echo 'selected="select"'; ?>>
            Nota
            de D�bito
        </option>
        <option
            value="12"<? if ($p->especie == '12') echo 'selected="select"'; ?>>
            Duplicata de Serv.
        </option>
        <option
            value="99"<? if ($p->especie == '99') echo 'selected="select"'; ?>>
            Outros
        </option>
    </select>
    <font style="float:left;color:#FF0000;">*</font>

    <label for="aceite">Aceite: </label>
    <select name="aceite" id="aceite"
            class="form_estilo<? if ($errors['aceite'] == 1) echo '_erro' ?>"
            style=" width:47px; ">
        <option value="A"<? if ($p->aceite == 'A') echo 'selected="select"'; ?>>
            A
        </option>
        <option value="N"<? if ($p->aceite == 'N') echo 'selected="select"'; ?>>
            N
        </option>
    </select>
    <font style="float:left;color:#FF0000;">*</font>

    <div style="text-align:center;width:100%">
        <input type="submit" name="submit_form" value="Cadastrar"
               class="button_busca"/>&nbsp;
        <input type="submit"
               onclick="document.form_auto.action='financeiro_boleto.php'"
               name="submit_form2" value="Voltar" class="button_busca"/>
    </div>
    <br/>

    <div style="text-align:center;width:100%" id="carrega_dados">

    </div>
    </td>
    </tr>
    </tbody>
    </table>
    </div>
    </form>
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

    <link href="../css/jquery-ui.css" rel="stylesheet">
    <script src="../js/jquery-1.11.4/jquery.js"></script>
    <script src="../js/jquery-1.11.4/jquery-ui.js"></script>
    <script src="../js/jquery-1.11.4/datepicker-pt-BR.js"></script>
    <script>
        $(function () {
            $(".calendario").datepicker({
                    dateFormat: "dd/mm/yy"
                },
                $.datepicker.regional['pt-BR']);
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
    </script>
<?php require('footer.php'); ?>