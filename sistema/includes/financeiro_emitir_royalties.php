<?
$contaDAO = new ContaDAO();
if ($controle_id_empresa == 1) {
    $financeiro_divisao = '';

    pt_register('POST', 'submit_financeiro_emitir_royalties');
    if (isset($submit_financeiro_emitir_royalties)) {
        $result = '';
        $error = array();

        pt_register('POST', 'id_conta');
        pt_register('POST', 'vencimento');

        if ($id_conta == "") {
            $errors = 1;
            $error["id_conta"] = 1;
            $result .= '<li>O campo <strong>Banco</strong> é obrigatório.</li>';
        }
        if ($vencimento == "") {
            $errors = 1;
            $error["vencimento"] = 1;
            $result .= '<li>O campo <strong>Vencimento</strong> é obrigatório.</li>';
        }

        if ($id_conta > 2) {
            pt_register('POST', 'ddlMulta');
            pt_register('POST', 'txtValorMulta');
            pt_register('POST', 'txtDataMulta');
            pt_register('POST', 'ddlJuros');
            pt_register('POST', 'txtValorJuros');
            pt_register('POST', 'ddlPgtoParcial');
            pt_register('POST', 'txtCNPJSacador');
            pt_register('POST', 'txtNomeSacador');

            if (empty($ddlMulta)) {
                $error["ddlMulta"] = 1;
                $result .= '<li>O campo <strong>Multa</strong> é obrigatório.</li>';
            }
            if ($ddlMulta == 2 && empty($txtValorMulta)) {
                $error["txtValorMulta"] = 1;
                $result .= '<li>O campo <strong>Valor Multa</strong> é obrigatório.</li>';
            }
            if (empty($txtDataMulta)) {
                $error["txtDataMulta"] = 1;
                $result .= '<li>O campo <strong>Data Multa</strong> é obrigatório.</li>';
            }
            if (empty($ddlJuros)) {
                $error["ddlJuros"] = 1;
                $result .= '<li>O campo <strong>Juros</strong> é obrigatório.</li>';
            }
            if (empty($txtValorJuros) && $ddlJuros == 2) {
                $error["txtValorJuros"] = 1;
                $result .= '<li>O campo <strong>Valor Juros</strong> é obrigatório.</li>';
            }
            if (empty($txtCNPJSacador)) {
                $error["txtCNPJSacador"] = 1;
                $result .= '<li>O campo <strong>CNPJ Sacador</strong> é obrigatório.</li>';
            }
            if (empty($txtNomeSacador)) {
                $error["txtNomeSacador"] = 1;
                $result .= '<li>O campo <strong>Nome Sacador</strong> é obrigatório.</li>';
            }
        } else {
            pt_register('POST', 'instrucao1');

            if (empty($instrucao1)) {
                $error["instrucao1"] = 1;
                $result .= '<li>O campo <strong>Instrução 1</strong> é obrigatório.</li>';
            }
        }

        if (count($error) == 0) {

            pt_register("POST", "ocorrencia");
            pt_register("POST", "aceite");
            pt_register("POST", "especie");
            pt_register("POST", "mensagem1");
            pt_register("POST", "mensagem2");
            pt_register("POST", "mensagem3");
            pt_register("POST", "vencimento");


            $im = str_replace(',', "','", str_replace(',##', "", "'" . htmlentities($_COOKIE['fr_id_rel_royalties']) . "##") . "'");
            $lista = $financeiroDAO->lista_royalties_emissao_boleto($im);
            print_r($lista);


            $cContaDAO = new ContaDAO();

            foreach ($lista as $item) {
                $cConta = new stdClass();
                $cConta->id_nota = 0;
                $cConta->id_relatorio = null;
                $cConta->id_empresa_franquia = $item->id_empresa;
                $cConta->id_fatura = 0;

                $cConta->id_conta = $item->id_conta;
                $cConta->ocorrencia = $ocorrencia;
                $cConta->tipo = 1;
                $cConta->cpf = $item->cpf;
                $cConta->sacado = $item->empresa;
                $cConta->endereco = $item->endereco;
                $cConta->bairro = $item->bairro;
                $cConta->cidade = $item->cidade;
                $cConta->estado = $item->estado;
                $cConta->cep = $item->cep;
                $cConta->vencimento = $vencimento;
                $cConta->valor = $item->valor_royalties;
                $cConta->juros_mora = null;
                $cConta->instrucao1 = null;
                $cConta->instrucao2 = null;
                $cConta->mensagem1 = $mensagem1;
                $cConta->mensagem2 = $mensagem2;
                $cConta->mensagem3 = $mensagem3;
                $cConta->emissao_papeleta = 2;
                $cConta->especie = $especie;
                $cConta->aceite = $aceite;

                echo $cContaDAO->inserirBoletoBrasil($cConta, 1, 1);
            }


            if ($id_conta == 2) {

            }


        }
    }
    ?>

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
            class="form_estilo<? if ($error['id_conta'] == 1) echo '_erro' ?>" style="width:110px" va>
        <option value="" selected></option>
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

    <label>Vencimento: </label>
    <input type="text" id="vencimento" maxlength="10" readonly name="vencimento" value="<? echo $vencimento; ?>"
           onKeyUp="masc_numeros(this,'##/##/####');"
           class="form_estilo<? if ($error['vencimento'] == 1) echo '_erro' ?> calendario"
           style="width: 90px;"/>
    <font style="float:left;color:#FF0000;">*</font>

    <label>Data Emissão: </label>
    <input type="text" id="txtDataEmissao" maxlength="10" readonly name="txtDataEmissao"
           value="<? echo date("d/m/Y"); ?>"
           onKeyUp="masc_numeros(this,'##/##/####');"
           class="form_estilo<? if ($errors['txtDataEmissao'] == 1) echo '_erro' ?>"
           style="width: 90px;"/>
    <br/>

    <div class="divBancoBrasil" style="display: <? if ($id_conta > 2) echo 'block;'; else echo 'none;'; ?>">
        <label>Multa: </label>
        <select name="ddlMulta" id="ddlMulta"
                class="form_estilo<? if ($error['ddlMulta'] == 1) echo '_erro' ?>"
                style=" width:110px; ">
            <option value=""></option>
            <option value="1">Dispensar</option>
            <option value="2">% ao mes</option>
        </select>
        <font style="float:left;color:#FF0000;">*</font>

        <div id="divValorMulta" style="display: none;">
            <label>Valor multa:</label>
            <input type="text" id="txtValorMulta" maxlength="2" name="txtValorMulta" value=""
                   class="form_estilo<? if ($error['txtValorMulta'] == 1) echo '_erro' ?>"
                   style=" width:90px; "/>
            <font style="float:left;color:#FF0000;">*</font>
        </div>
        <label>Data Multa: </label>
        <input type="text" id="txtDataMulta" maxlength="10" readonly name="txtDataMulta"
               onKeyUp="masc_numeros(this,'##/##/####');" value=""
               class="form_estilo<? if ($error['txtDataMulta'] == 1) echo '_erro' ?> calendario"
               style=" width:90px; "/>
        <font style="float:left;color:#FF0000;">*</font>
        <br/>

        <label>Juros: </label>
        <select name="ddlJuros" id="ddlJuros"
                class="form_estilo<? if ($error['ddlJuros'] == 1) echo '_erro' ?>"
                style=" width:110px; ">
            <option value=""></option>
            <option value="1">Dispensar</option>
            <option value="2">Valor fixo ao dia</option>
        </select>
        <font style="float:left;color:#FF0000;">*</font>

        <div id="divValorJuros" style="display: none;">
            <label>Valor Fixo:</label>
            <input type="text" id="txtValorJuros" maxlength="2" name="txtValorJuros" value=""
                   class="form_estilo<? if ($error['divValorJuros'] == 1) echo '_erro' ?>"
                   style=" width:90px; "/>
            <font style="float:left;color:#FF0000;">*</font>
        </div>
        <br/>

        <label>Pgto. Parcial: </label>
        <select name="ddlPgtoParcial" id="ddlPgtoParcial"
                class="form_estilo<? if ($error['ddlPgtoParcial'] == 1) echo '_erro' ?>"
                style=" width:110px; ">
            <option value=""></option>
            <option value="S">Sim</option>
            <option value="N">Não</option>
        </select>
        <font style="float:left;color:#FF0000;">*</font>

        <label>Dias protesto: </label>
        <input type="text" id="txtDiasProtesto" maxlength="2" name="txtDiasProtesto" value=""
               class="form_estilo"
               style=" width:90px; margin-right:11px;"/>
        <br/>
        <label>Campo Livre: </label>
        <input type="text" id="txtCampoLivre" maxlength="50" name="txtCampoLivre"
               onKeyUp="masc_numeros(this,'##');"
               class="form_estilo"
               style=" width:546px; "/>
        <br/>
        <label>CNPJ Sacador: </label>
        <input type="text" id="txtCNPJSacador" maxlength="18" name="txtCNPJSacador"
               onKeyUp="masc_numeros(this,'##.###.###/####-##');"
               class="form_estilo<? if ($error['txtCNPJSacador'] == 1) echo '_erro' ?>"
               style=" width:109px; "/>
        <font style="float:left;color:#FF0000;">*</font>
        <label>Nome Sacador: </label>
        <input type="text" id="txtNomeSacador" maxlength="50" name="txtNomeSacador"
               class="form_estilo<? if ($error['txtCNPJSacador'] == 1) echo '_erro' ?>"
               style=" width:309px; "/>
        <font style="float:left;color:#FF0000;">*</font>
        <br/>
    </div>
    <label>Ocorrência: </label>
    <select name="ocorrencia" id="ocorrencia" class="form_estilo_r" readonly style=" width:547px; ">
        <option value="1" selected="select">Remessa</option>
    </select>
    <br/>

    <div class="divBancoBradesco" style="display:<? if ($id_conta == 2) echo 'block;'; else echo 'none;'; ?>;">
        <label>Instrução 1: </label>
        <select name="instrucao1" id="instrucao1"
                onchange="if(instrucao1.value!=6) instrucao2.value=''; else instrucao2.value=5;"
                class="form_estilo<? if ($error['instrucao1'] == 1) echo '_erro' ?>"
                style=" width:547px; ">
            <option value=""></option>
            <option value="6"<? if ($p->instrucao1 == '6') echo 'selected="select"'; ?>>Protestar
            </option>
            <option value="8"<? if ($p->instrucao1 == '8') echo 'selected="select"'; ?>>Não cobrar juros
                de
                mora
            </option>
            <option value="9"<? if ($p->instrucao1 == '9') echo 'selected="select"'; ?>>Não receber após
                o
                vencimento
            </option>
            <option value="11"<? if ($p->instrucao1 == '11') echo 'selected="select"'; ?>>Não receber
                após o
                8º dia do vencimento
            </option>
            <option value="12"<? if ($p->instrucao1 == '12') echo 'selected="select"'; ?>>Cobrar
                encargos
                após o 5º dia do vencimento
            </option>
            <option value="13"<? if ($p->instrucao1 == '13') echo 'selected="select"'; ?>>Cobrar
                encargos
                após o 10º dia do vencimento
            </option>
            <option value="14"<? if ($p->instrucao1 == '14') echo 'selected="select"'; ?>>Cobrar
                encargos
                após o 15º dia do vencimento
            </option>
        </select>
        <font style="float:left;color:#FF0000;">*</font>
        <br/>
        <label>Instrução 2: </label>
        <input type="text" id="instrucao2" maxlength="2" name="instrucao2" value="<?= $p->instrucao2 ?>"
               onKeyUp="masc_numeros(this,'##');"
               class="form_estilo"
               style=" width:546px; "/>
        <br/>
    </div>
    <label>Mensagem 1: </label>
    <input type="text" id="mensagem1" maxlength="12" name="mensagem1" value="<?= $p->mensagem1 ?>"
           class="form_estilo"
           style=" width:546px; "/>
    <br/>

    <label>Mensagem 2: </label>
    <input type="text" id="mensagem2" maxlength="60" name="mensagem2" value="<?= $p->mensagem2 ?>"
           class="form_estilo"
           style=" width:546px; "/>
    <br/>

    <div class="divBancoBrasil" style="display: <? if ($id_conta > 2) echo 'block;'; else echo 'none;'; ?>;">
        <label>Mensagem 3: </label>
        <input type="text" id="txtMensagem3" maxlength="60" name="txtMensagem3" value=""
               class="form_estilo"
               style=" width:546px; "/>
        <br/>
    </div>
    <label for="especie">Espécie: </label>
    <select name="especie" id="especie"
            class="form_estilo<? if ($errors['especie'] == 1) echo '_erro' ?>"
            style=" width:375px; ">
        <option value="1"<? if ($p->especie == '1') echo 'selected="select"'; ?>>Duplicata</option>
        <option value="2"<? if ($p->especie == '2') echo 'selected="select"'; ?>>Nota Promissória
        </option>
        <option value="3"<? if ($p->especie == '3') echo 'selected="select"'; ?>>Nota de Seguro
        </option>
        <option value="4"<? if ($p->especie == '4') echo 'selected="select"'; ?>>Cobrança Seriada
        </option>
        <option value="5"<? if ($p->especie == '5') echo 'selected="select"'; ?>>Recibo</option>
        <option value="10"<? if ($p->especie == '10') echo 'selected="select"'; ?>>Letras de Câmbio
        </option>
        <option value="11"<? if ($p->especie == '11') echo 'selected="select"'; ?>>Nota de Débito
        </option>
        <option value="12"<? if ($p->especie == '12') echo 'selected="select"'; ?>>Duplicata de
            Serv.
        </option>
        <option value="99"<? if ($p->especie == '99') echo 'selected="select"'; ?>>Outros</option>
    </select>

    <label for="aceite">Aceite: </label>
    <select name="aceite" id="aceite"
            class="form_estilo<? if ($errors['aceite'] == 1) echo '_erro' ?>"
            style=" width:50px; ">
        <option value="A"<? if ($p->aceite == 'A') echo 'selected="select"'; ?>>A</option>
        <option value="N"<? if ($p->aceite == 'N') echo 'selected="select"'; ?>>N</option>
    </select>

    <div style="text-align:center;width:100%">
        <input type="submit" name="submit_financeiro_emitir_royalties" value="Emitir"
               class="button_busca"/>&nbsp;
        <input type="submit" onclick="document.form_auto.action='emitir_boletos.php'"
               name="submit_form2" value="Voltar" class="button_busca"/>
    </div>
    </td>
    </tr>
    </tbody>
    </table>

    </div>
    </form>

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
                    $('.divBancoBrasil').show();
                    $('.divBancoBradesco').hide();
                } else {
                    $('.divBancoBrasil').hide();
                    $('.divBancoBradesco').show();
                }
            });
        });
    </script>
    <?
    if (count($error) > 0) {
        ?>
        <br/>
        <div class="erro">
            <ul>
                <? echo $result; ?>
            </ul>
        </div>
    <?
    }
}
exit;
?>