<?
require('header.php');
$departamento_s = explode(',', $controle_id_departamento_s);
$departamento_p = explode(',', $controle_id_departamento_p);
?>
    <div id="topo">
        <h1 class="tit"><img src="../images/tit/tit_rel_banco.png" alt="T�tulo"/> Relat�rio de Royalties em Aberto
        </h1>
        <hr class="tit"/>
    </div>
    <div id="meio">
        <table border="0" height="100%" width="100">
            <tr>
                <td valign="top">
                    <form name="buscador" id="buscador" action="gera_rel_royalties_aberto.php" method="post" target="_blank">
                        <center>
                            <table class="tabela" width="450">
                                <tr>
                                    <td class="tabela_tit" colspan="4">Filtro de Pesquisa</td>
                                </tr>
                                <tr>
                                    <td align="right"><b>Status:</b></td>
                                    <td>
                                        <select name="ddlStatus" class="form_estilo" style="width:211px;">
                                            <option value="Todos" selected="selected">Todos</option>
                                            <option value="Todos" selected="selected">Todos</option>
                                            <option value="Ativo">Ativo</option>
                                            <option value="Cancelado">Cancelado</option>
                                            <option value="Encerrando">Encerrando</option>
                                            <option value="Implanta��o">Implanta��o</option>
                                            <option value="Inativo">Inativo</option>
                                            <option value="Jur�dico">Jur�dico</option>
                                            <option value="Renova��o">Renova��o</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right"><b>Campos:</b></td>
                                    <td>
                                        <input type="checkbox" name="c_status"/> Status <br>
                                        <input type="checkbox" name="c_empresa"/> Empresa <br>
                                        <input type="checkbox" name="c_nome"/> Nome <br>
                                        <input type="checkbox" name="c_cpf_cnpj"/> CPF/CNPJ <br>
                                        <input type="checkbox" name="c_telefone"/> Telefone <br>
                                        <input type="checkbox" name="c_celular"/> Celular <br>
                                        <input type="checkbox" name="c_email"/> E-mail <br>
                                        <input type="checkbox" name="c_cep"/> CEP <br>
                                        <input type="checkbox" name="c_endereco"/> Endere�o <br>
                                        <input type="checkbox" name="c_bairro"/> Bairro <br>
                                        <input type="checkbox" name="c_complemento"/> Complemento <br>
                                        <input type="checkbox" name="c_cidade"/> Cidade <br>
                                        <input type="checkbox" name="c_uf"/> UF <br>
                                        <input type="checkbox" name="c_final_contrato"/> Final de Contrato <br>
                                        <input type="checkbox" name="c_observacoes"/> Observa��es <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" colspan="4">
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
                        </center>
                    </form>
                </td>
            </tr>
        </table>
    </div>
<?php
require('footer.php');

?>