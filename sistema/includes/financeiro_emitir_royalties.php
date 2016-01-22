<?
$contaDAO = new ContaDAO();
if ($controle_id_empresa == 1) {
    $financeiro_divisao = '';

    $im = str_replace(',', "','", str_replace(',##', "", "'" . htmlentities($_COOKIE['fr_id_rel_royalties']) . "##") . "'");
    $lista = $financeiroDAO->listaRoyIn($im);
    $cont = 0;
    #verifica permissão
    foreach ($lista as $l) {
        $errors = '';
        $error = '';
        $roy = $l->valor_royalties;
        $roy_rec = $l->roy_rec;
        $fpp = $l->valor_propaganda;
        $fpp_rec = $l->fpp_rec;
        if ($roy_rec < $roy) $roy = (float)($roy) - (float)($roy_rec); else $roy = 0;
        if ($fpp_rec < $fpp) $fpp = (float)($fpp) - (float)($fpp_rec); else $fpp = 0;
        $financeiro_divisao++;

    }
    ?>

    <br style="clear:both">
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
                                class="form_estilo<? if ($errors['id_conta'] == 1) echo '_erro' ?>" style="width:110px">
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
                        <input type="text" id="vencimento" maxlength="10" readonly name="vencimento" value=""
                               onKeyUp="masc_numeros(this,'##/##/####');"
                               class="form_estilo<? if ($errors['vencimento'] == 1) echo '_erro' ?> calendario"
                               style="width: 90px;"/>
                        <font color="#FF0000">*</font>
                        <br/>

                        <label for="juros_mora">Multa: </label>
                        <select name="ddlMulta" id="ddlMulta"
                                class="form_estilo<? if ($errors['multa'] == 1) echo '_erro' ?>"
                                style=" width:110px; ">
                            <option value=""></option>
                            <option value="1">Dispensar</option>
                            <option value="2">% ao mes</option>
                        </select>
                        <font style="float:left;color:#FF0000;">*</font>

                        <div id="divValorMulta" style="display: none;">
                            <label for="juros_mora">Valor multa:</label>
                            <input type="text" id="txtValorMulta" maxlength="2" name="txtValorMulta" value=""
                                   class="form_estilo<? if ($errors['valor_multa'] == 1) echo '_erro' ?>"
                                   style=" width:90px; "/>
                            <font style="float:left;color:#FF0000;">*</font>
                        </div>

                        <label for="juros_mora">Data multa: </label>
                        <input type="text" id="txtDataMulta" maxlength="10" readonly name="txtDataMulta"
                               onKeyUp="masc_numeros(this,'##/##/####');" value=""
                               class="form_estilo<? if ($errors['data_multa'] == 1) echo '_erro' ?> calendario"
                               style=" width:90px; "/>
                        <font style="float:left;color:#FF0000;">*</font>
                        <br/>

                        <label for="juros_mora">Pgto. Parcial: </label>
                        <input type="text" id="txtPgtoParcial" maxlength="2" name="txtPgtoParcial" value=""
                               class="form_estilo<? if ($errors['pgto_parcial'] == 1) echo '_erro' ?>"
                               style=" width:110px; "/>
                        <font style="float:left;color:#FF0000;">*</font>

                        <label for="juros_mora">Dias protesto: </label>
                        <input type="text" id="txtDiasProtesto" maxlength="2" name="txtDiasProtesto" value=""
                               class="form_estilo<? if ($errors['dias_protesto'] == 1) echo '_erro' ?>"
                               style=" width:90px; margin-right:11px;"/>

                        <label>Juros: </label>
                        <select name="ddlJuros" id="ddlJuros"
                                class="form_estilo<? if ($errors['juros'] == 1) echo '_erro' ?>"
                                style=" width:91px; ">
                            <option value=""></option>
                            <option value="1">Dispensar</option>
                            <option value="2">% ao mes</option>
                        </select>
                        <font style="float:left;color:#FF0000;">*</font>
                        <br/>
                        <label for="ocorrencia">Ocorrência: </label>
                        <select name="ocorrencia" id="ocorrencia" class="form_estilo_r" readonly style=" width:547px; ">
                            <option value="1" selected="select">Remessa</option>
                        </select>
                        <br/>
                        <label for="instrucao1">Instrução 1: </label>
                        <select name="instrucao1" id="instrucao1"
                                onchange="if(instrucao1.value!=6) instrucao2.value=''; else instrucao2.value=5;"
                                class="form_estilo<? if ($errors['instrucao1'] == 1) echo '_erro' ?>"
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
                        <label for="instrucao2">Instrução 2: </label>
                        <input type="text" id="instrucao2" maxlength="2" name="instrucao2" value="<?= $p->instrucao2 ?>"
                               onKeyUp="masc_numeros(this,'##');"
                               class="form_estilo<? if ($errors['instrucao2'] == 1) echo '_erro' ?>"
                               style=" width:546px; "/>
                        <br/>

                        <label for="mensagem1">Mensagem 1: </label>
                        <input type="text" id="mensagem1" maxlength="12" name="mensagem1" value="<?= $p->mensagem1 ?>"
                               class="form_estilo<? if ($errors['mensagem1'] == 1) echo '_erro' ?>"
                               style=" width:546px; "/>
                        <br/>

                        <label for="mensagem2">Mensagem 2: </label>
                        <input type="text" id="mensagem2" maxlength="60" name="mensagem2" value="<?= $p->mensagem2 ?>"
                               class="form_estilo<? if ($errors['mensagem2'] == 1) echo '_erro' ?>"
                               style=" width:546px; "/>
                        <br/>

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
                            <input type="submit" name="submit_form" value="Emitir" class="button_busca"/>&nbsp;
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
        });
    </script>
    <? #fim da alteração de status
}
exit;
?>