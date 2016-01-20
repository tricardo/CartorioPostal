<?
require('header.php');
$departamento_s = explode(',', $controle_id_departamento_s);
$departamento_p = explode(',', $controle_id_departamento_p);
?>
    <div id="topo">
        <h1 class="tit"><img src="../images/tit/tit_rel_banco.png" alt="TÃ­tulo"/> Relatório de Cadastro de Franquias
        </h1>
        <hr class="tit"/>
    </div>
    <div id="meio">
        <table border="0" height="100%" width="100">
            <tr>
                <td valign="top">
                    <form enctype="multipart/form-data" action="gera_rel_cadastro_franquia.php" method="post" target="_blank" id="form1">

                        <table class="tabela" width="450">
                                <tr>
                                    <td class="tabela_tit" colspan="5">Filtro de Pesquisa</td>
                                </tr>
                                <tr>
                                    <td align="right"><b>Status:</b></td>
                                    <td>
                                        <select name="ddlStatus" class="form_estilo" style="width:211px;">
                                            <option value="Todos" selected="selected">Todos</option>
                                            <option value="Ativo">Ativo</option>
                                            <option value="Cancelado">Cancelado</option>
                                            <option value="Encerrando">Encerrando</option>
                                            <option value="Implantação">Implantação</option>
                                            <option value="Inativo">Inativo</option>
                                            <option value="Jurídico">Jurídico</option>
                                            <option value="Renovação">Renovação</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right"><b>Campos:</b></td>
                                    <td>
                                        <input type="checkbox" name="c_status"/> Status <br>
                                        <input type="checkbox" name="c_tipo_franquia"/> Tipo Franquia <br>
                                        <input type="checkbox" name="c_unidade"/> Unidade <br>
                                        <input type="checkbox" name="c_empresa"/> Empresa <br>
                                        <input type="checkbox" name="c_nome" /> Nome <br>
                                        <input type="checkbox" name="c_cpf_cnpj" /> CPF/CNPJ <br>
                                        <input type="checkbox" name="c_telefone" /> Telefone <br>
                                        <input type="checkbox" name="c_celular" /> Celular <br>
                                        <input type="checkbox" name="c_email" /> E-mail <br>
                                        <input type="checkbox" name="c_cep" /> CEP <br>
                                        <input type="checkbox" name="c_endereco" /> Endereço <br>
                                        <input type="checkbox" name="c_bairro" /> Bairro <br>
                                        <input type="checkbox" name="c_complemento" /> Complemento <br>
                                        <input type="checkbox" name="c_cidade" /> Cidade <br>
                                        <input type="checkbox" name="c_uf" /> UF <br>
                                        <input type="checkbox" name="c_banco" /> Banco <br>
                                        <input type="checkbox" name="c_agencia" /> Agência <br>
                                        <input type="checkbox" name="c_conta" /> Conta <br>
                                        <input type="checkbox" name="c_favorecido" /> Favorecido <br>
                                        <input type="checkbox" name="c_inicio_contrato" /> Início de Contrato
                                        <br>
                                        <input type="checkbox" name="c_final_contrato" /> Final de Contrato <br>
                                        <input type="checkbox" name="c_liberacao_sistema" /> Liberação do Sistema
                                        <br>
                                        <input type="checkbox" name="c_royalties" /> Royalties <br>
                                        <input type="checkbox" name="c_observacoes" /> Observações <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" align="center">
                                        <input type="submit" name="submit_analitico" value="Emitir"
                                               class="button_busca"/>&nbsp;
                                        <input type="reset" name="submit_limpar" value="Limpar"
                                               class="button_busca"/>&nbsp;
                                        <input type="submit" name="cancelar" value="Voltar"
                                               onclick="document.pedido_print.target='_self'; document.pedido_print.action='rels.php'"
                                               class="button_busca"/>
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