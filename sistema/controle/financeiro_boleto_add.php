<?php require('header.php'); ?>
    <div id="topo">
        <?php
        #caso o link venha diretamente da tela financeiro_pagamento.php
        pt_register('GET', 'id_fatura');

        $permissao = verifica_permissao('Financeiro', $controle_id_departamento_p, $controle_id_departamento_s);
        if ($permissao == 'FALSE') {
            echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
            exit;
        }
        $submit = 'inserir';
        ?>
        <h1 class="tit"><img src="../images/tit/tit_recebimento.png" alt="Título"/>Adicionar Boleto</h1>
        <a href="#" class="topo">topo</a>
        <hr class="tit"/>
    </div>
    <div id="meio">
        <table width="100%" border="0" cellpadding="10" cellspacing="0">
            <tr>
                <td valign="top" align="center">
                    <?
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
                        $errors = array();
                        $error = '<div class="erro"><b>Ocorreram os seguintes erros:</b><br>';
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
                        pt_register('POST', 'juros_mora');
                        pt_register('POST', 'ocorrencia');
                        pt_register('POST', 'instrucao1');
                        pt_register('POST', 'instrucao2');
                        pt_register('POST', 'mensagem1');
                        pt_register('POST', 'mensagem2');
                        pt_register('POST', 'emissao_papeleta');
                        pt_register('POST', 'especie');
                        pt_register('POST', 'aceite');
                        if ($tipo == "" or $cpf == "" or $sacado == "" or $endereco == "" or $cep == "" or $vencimento == "" or $valor == "" or $ocorrencia == "" or $emissao_papeleta == "" or $especie == "" or $aceite == "") {

                            if ($tipo == "") $errors['tipo'] = 1;
                            if ($cpf == "") $errors['cpf'] = 1;
                            if ($sacado == "") $errors['sacado'] = 1;
                            if ($endereco == "") $errors['endereco'] = 1;
                            if ($cep == "") $errors['cep'] = 1;
                            if ($vencimento == "") $errors['vencimento'] = 1;
                            if ($valor == "") $errors['valor'] = 1;
                            if ($ocorrencia == "") $errors['ocorrencia'] = 1;
                            if ($emissao_papeleta == "") $errors['emissao_papeleta'] = 1;
                            if ($especie == "") $errors['especie'] = 1;
                            if ($aceite == "") $errors['aceite'] = 1;
                            $error .= '- Os Campos com * são obrigatórios;<br>';
                        }

                        if ($instrucao1 == 6 and $instrucao2 < 5) {
                            $errors['instrucao2'] = 1;
                            $error .= '- O campo instrução 2 não pode ser menor que 5;<br>';
                        }

                        if (invert($vencimento, '-', 'SQL') < date('Y-m-d')) {
                            $errors['vencimento'] = 1;
                            $error .= '- A data de vencimento não pode ser inferior ao dia de hoje<br>';
                        }

                        $verifica = $validacaoCLASS->invertData($vencimento);
                        if ($verifica == false) {
                            $errors['vencimento'] = 1;
                            $error .= '- Vencimento inválido;<br>';
                        } else {
                            $vencimento = $verifica;
                        }

                        if ($id_fatura <> '') {
                            $verifica_fatura = $contaDAO->verificaFatura($controle_id_empresa, $id_fatura);
                            if ($verifica_fatura == 0 or $verifica_fatura == '') {
                                $errors['id_fatura'] = 1;
                                $error .= '- Número de Fatura inválido;<br>';
                            }
                        }

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
                        $p->juros_mora = $juros_mora;
                        $p->ocorrencia = $ocorrencia;
                        $p->instrucao1 = $instrucao1;
                        $p->instrucao2 = $instrucao2;
                        $p->mensagem1 = $mensagem1;
                        $p->mensagem2 = $mensagem2;
                        $p->emissao_papeleta = $emissao_papeleta;
                        $p->especie = $especie;
                        $p->aceite = $aceite;

                        if (COUNT($errors) == 0) {
                            $done = $contaDAO->inserirBoletoBrad($p, $controle_id_empresa, $controle_id_usuario);
                            echo "
		<script>
			alert('Boleto cadastrado com sucesso!');
			window.location='financeiro_boleto.php';
		</script>";
                        }

                        if ($errors) {
                            echo $error . "</div>";
                        }
                    }
                    if ($p->vencimento <> '')
                        $p->vencimento = invert($p->vencimento, '/', 'PHP');
                    ?>
                    <table width="670" class="tabela">
                        <tr>
                            <td class="tabela_tit">Dados do Boleto</td>
                        </tr>
                        <tr>
                            <td>
                                <form method="POST" action="" class="form_auto" name="form_auto" id="form_auto"
                                      enctype="multipart/form-data">

                                    <label for="id_conta">Banco: </label>
                                    <select name="id_conta" id="id_conta"
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

                                    <div class="asterisco">*</div>

                                    <label for="fatura">Fatura: </label>
                                    <input type="text" id="id_fatura" maxlength="10" name="id_fatura"
                                           value="<?= $p->id_fatura ?>" onKeyUp="masc_numeros(this,'##########');"
                                           class="form_estilo<? if ($errors['id_fatura'] == 1) echo '_erro' ?>"
                                           style=" width:140px; "/>

                                    <label for="nota">Nota: </label>
                                    <input type="text" id="id_nota" maxlength="10" name="id_nota"
                                           value="<?= $p->id_nota ?>" onKeyUp="masc_numeros(this,'##########');"
                                           class="form_estilo<? if ($errors['id_nota'] == 1) echo '_erro' ?>"
                                           style=" width:100px; "/>

                                    <label for="tipo">Tipo: </label>
                                    <select name="tipo" id="tipo"
                                            class="form_estilo<? if ($errors['tipo'] == 1) echo '_erro' ?>"
                                            style=" width:110px; ">
                                        <option value=""></option>
                                        <option value="1"<? if ($p->tipo == '1') echo 'selected="select"'; ?>>CPF
                                        </option>
                                        <option value="2"<? if ($p->tipo == '2') echo 'selected="select"'; ?>>CNPJ
                                        </option>
                                        <option value="98"<? if ($p->tipo == '98') echo 'selected="select"'; ?>>Não
                                            Tem
                                        </option>
                                        <option value="99"<? if ($p->tipo == '99') echo 'selected="select"'; ?>>Outros
                                        </option>
                                    </select>

                                    <div class="asterisco">*</div>

                                    <label for="cpf">CPF/CNPJ: </label>
                                    <input type="text" id="cpf" maxlength="20" name="cpf" value="<?= $p->cpf ?>"
                                           onKeyUp="if(tipo.value=='1') masc_numeros(this,'###.###.###-##'); else if(tipo.value=='2') masc_numeros(this,'##.###.###/####-##'); else masc_numeros(this,'##############');"
                                           class="form_estilo<? if ($errors['cpf'] == 1) echo '_erro' ?>"
                                           style=" width:140px; "/>

                                    <div class="asterisco">*</div>
                                    <input type="button" id="consultar" name="consultar" value="Consultar"
                                           onclick="carrega_sacado('form_auto',cpf.value);" class="button_busca"
                                           style="float:left" style=" width:120px; "/>

                                    <div class="asterisco">&nbsp;</div>
                                    <div style=" width:40px;  height:27px;  float:left;"></div>

                                    <label for="sacado">Sacado: </label>
                                    <input type="text" id="sacado" maxlength="40" name="sacado"
                                           value="<?= $p->sacado ?>"
                                           class="form_estilo<? if ($errors['sacado'] == 1) echo '_erro' ?>"
                                           style=" width:550px; "/>

                                    <div class="asterisco">*</div>

                                    <label for="endereco">Endereço: </label>
                                    <input type="text" id="endereco" maxlength="40" name="endereco"
                                           value="<?= $p->endereco ?>"
                                           class="form_estilo<? if ($errors['endereco'] == 1) echo '_erro' ?>"
                                           style=" width:550px; "/>

                                    <div class="asterisco">*</div>

                                    <label for="endereco">Bairro: </label>
                                    <input type="text" id="bairro" maxlength="70" name="bairro"
                                           value="<?= $p->bairro ?>"
                                           class="form_estilo<? if ($errors['bairro'] == 1) echo '_erro' ?>"
                                           style=" width:150px; "/>

                                    <div class="asterisco"></div>

                                    <label for="endereco">Cidade: </label>
                                    <input type="text" id="cidade" maxlength="70" name="cidade"
                                           value="<?= $p->cidade ?>"
                                           class="form_estilo<? if ($errors['cidade'] == 1) echo '_erro' ?>"
                                           style=" width:150px; "/>

                                    <div class="asterisco"></div>

                                    <label for="endereco">Estado: </label>
                                    <input type="text" id="estado" maxlength="2" name="estado" value="<?= $p->estado ?>"
                                           class="form_estilo<? if ($errors['estado'] == 1) echo '_erro' ?>"
                                           style=" width:40px;"/>

                                    <label for="cep">CEP: </label>
                                    <input type="text" id="cep" maxlength="9" name="cep" value="<?= $p->cep ?>"
                                           onKeyUp="masc_numeros(this,'#####-###');"
                                           class="form_estilo<? if ($errors['cep'] == 1) echo '_erro' ?>"
                                           style=" width:110px; "/>

                                    <div class="asterisco">*</div>

                                    <label for="vencimento">Vencimento: </label>
                                    <input type="text" id="vencimento" maxlength="10" name="vencimento"
                                           value="<?= $p->vencimento ?>" onKeyUp="masc_numeros(this,'##/##/####');"
                                           class="form_estilo<? if ($errors['vencimento'] == 1) echo '_erro' ?>"
                                           style=" width:110px; "/>

                                    <div class="asterisco">*</div>

                                    <label for="valor">Valor: </label>

                                    <input type="text" id="valor" maxlength="10" name="valor" value="<?= $p->valor ?>"
                                           onkeyup="moeda(event.keyCode,this.value,'valor');"
                                           class="form_estilo<? if ($errors['valor'] == 1) echo '_erro' ?>"
                                           style=" width:120px; "/>

                                    <div class="asterisco">*</div>

                                    <label for="juros_mora">Mora diária: </label>
                                    <input type="text" id="juros_mora" maxlength="10" name="juros_mora"
                                           value="<?= $p->juros_mora ?>"
                                           onkeyup="moeda(event.keyCode,this.value,'valor');"
                                           class="form_estilo<? if ($errors['juros_mora'] == 1) echo '_erro' ?>"
                                           style=" width:110px; "/>

                                    <div class="asterisco">&nbsp;</div>

                                    <label for="ocorrencia">Ocorrência: </label>
                                    <select name="ocorrencia" id="ocorrencia" class="form_estilo_r" readonly
                                            style=" width:338px; ">
                                        <option value="1" selected="select">Remessa</option>

                                    </select>

                                    <div class="asterisco">*</div>

                                    <label for="instrucao1">Instrução 1: </label>
                                    <select name="instrucao1" id="instrucao1"
                                            onchange="if(instrucao1.value!=6) instrucao2.value=''; else instrucao2.value=5;"
                                            class="form_estilo<? if ($errors['instrucao1'] == 1) echo '_erro' ?>"
                                            style=" width:552px; ">
                                        <option value=""></option>
                                        <option value="6"<? if ($p->instrucao1 == '6') echo 'selected="select"'; ?>>
                                            Protestar
                                        </option>
                                        <option value="8"<? if ($p->instrucao1 == '8') echo 'selected="select"'; ?>>Não
                                            cobrar juros de mora
                                        </option>
                                        <option value="9"<? if ($p->instrucao1 == '9') echo 'selected="select"'; ?>>Não
                                            receber após o vencimento
                                        </option>
                                        <option value="11"<? if ($p->instrucao1 == '11') echo 'selected="select"'; ?>>
                                            Não receber após o 8º dia do vencimento
                                        </option>
                                        <option value="12"<? if ($p->instrucao1 == '12') echo 'selected="select"'; ?>>
                                            Cobrar encargos após o 5º dia do vencimento
                                        </option>
                                        <option value="13"<? if ($p->instrucao1 == '13') echo 'selected="select"'; ?>>
                                            Cobrar encargos após o 10º dia do vencimento
                                        </option>
                                        <option value="14"<? if ($p->instrucao1 == '14') echo 'selected="select"'; ?>>
                                            Cobrar encargos após o 15º dia do vencimento
                                        </option>
                                    </select>

                                    <div class="asterisco">&nbsp;</div>


                                    <label for="instrucao2">Instrução 2: </label>

                                    <input type="text" id="instrucao2" maxlength="2" name="instrucao2"
                                           value="<?= $p->instrucao2 ?>" onKeyUp="masc_numeros(this,'##');"
                                           class="form_estilo<? if ($errors['instrucao2'] == 1) echo '_erro' ?>"
                                           style=" width:110px; "/>

                                    <div class="asterisco">&nbsp;</div>

                                    <label for="mensagem1">Mensagem 1: </label>
                                    <input type="text" id="mensagem1" maxlength="12" name="mensagem1"
                                           value="<?= $p->mensagem1 ?>"
                                           class="form_estilo<? if ($errors['mensagem1'] == 1) echo '_erro' ?>"
                                           style=" width:334px; "/>

                                    <div class="asterisco">&nbsp;</div>

                                    <label for="mensagem2">Mensagem 2: </label>
                                    <input type="text" id="mensagem2" maxlength="60" name="mensagem2"
                                           value="<?= $p->mensagem2 ?>"
                                           class="form_estilo<? if ($errors['mensagem2'] == 1) echo '_erro' ?>"
                                           style=" width:550px; "/>

                                    <div class="asterisco">&nbsp;</div>

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

                                    <div class="asterisco">*</div>

                                    <label for="especie">Espécie: </label>
                                    <select name="especie" id="especie"
                                            class="form_estilo<? if ($errors['especie'] == 1) echo '_erro' ?>"
                                            style=" width:187px; ">
                                        <option value="1"<? if ($p->especie == '1') echo 'selected="select"'; ?>>
                                            Duplicata
                                        </option>
                                        <option value="2"<? if ($p->especie == '2') echo 'selected="select"'; ?>>Nota
                                            Promissória
                                        </option>
                                        <option value="3"<? if ($p->especie == '3') echo 'selected="select"'; ?>>Nota de
                                            Seguro
                                        </option>
                                        <option value="4"<? if ($p->especie == '4') echo 'selected="select"'; ?>>
                                            Cobrança Seriada
                                        </option>
                                        <option value="5"<? if ($p->especie == '5') echo 'selected="select"'; ?>>
                                            Recibo
                                        </option>
                                        <option value="10"<? if ($p->especie == '10') echo 'selected="select"'; ?>>
                                            Letras de Câmbio
                                        </option>
                                        <option value="11"<? if ($p->especie == '11') echo 'selected="select"'; ?>>Nota
                                            de Débito
                                        </option>
                                        <option value="12"<? if ($p->especie == '12') echo 'selected="select"'; ?>>
                                            Duplicata de Serv.
                                        </option>
                                        <option value="99"<? if ($p->especie == '99') echo 'selected="select"'; ?>>
                                            Outros
                                        </option>
                                    </select>

                                    <div class="asterisco">*</div>

                                    <label for="aceite">Aceite: </label>
                                    <select name="aceite" id="aceite"
                                            class="form_estilo<? if ($errors['aceite'] == 1) echo '_erro' ?>"
                                            style=" width:50px; ">
                                        <option value="A"<? if ($p->aceite == 'A') echo 'selected="select"'; ?>>A
                                        </option>
                                        <option value="N"<? if ($p->aceite == 'N') echo 'selected="select"'; ?>>N
                                        </option>
                                    </select>

                                    <div class="asterisco">*</div>
                                    <center>
                                        <input type="submit" name="submit_form" value="Cadastrar" class="button_busca"/>&nbsp;
                                        <input type="submit" onclick="document.form_auto.action='financeiro_boleto.php'"
                                               name="submit_form2" value="Voltar" class="button_busca"/>
                                    </center>
                                </form>
                            </td>
                        </tr>
                    </table>

                    <div id="carrega_dados"></div>

                </td>
            </tr>
        </table>
    </div>
<?php require('footer.php'); ?>