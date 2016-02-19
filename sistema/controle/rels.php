<?
require('header.php');
?>
    <div id="topo">
        <h1 class="tit"><img src="../images/tit/tit_rel.png" alt="T�tulo"/>
            Relat�rios</h1>
        <hr class="tit"/>
    </div>
    <div id="meio">
    <table border="0" height="100%" width="100%">
    <tr>
    <td valign="top">
    <table cellpadding="4" cellspacing="1" class="result_tabela">
    <tr>
        <td align="center" class="result_menu"><b>Departamento</b></td>
        <td align="center" class="result_menu"><b>Relat�rio</b></td>
        <td align="center" width="60" class="result_menu"><b>Visualizar</b></td>
    </tr>
    <? $menu_sequencia = 'first'; ?>
    <? $permissao = verifica_permissao('Financeiro_rel', $controle_id_departamento_p, $controle_id_departamento_s);
    if ($permissao == 'TRUE') {
        ?>
        <tr>
            <td class="result_celula" nowrap>Financeiro</td>
            <td class="result_celula" nowrap>Dep�sito separado por Banco</td>
            <td class="result_celula" align="center" nowrap>
                <a href="rel_desembolso.php"><img src="../images/botao_editar.png" title="Editar" border="0"/></a>
            </td>
        </tr>
        <tr>
            <td class="result_celula" nowrap>Financeiro</td>
            <td class="result_celula" nowrap>Fluxo de Caixa</td>
            <td class="result_celula" align="center" nowrap>
                <a href="rel_fluxocaixa.php"><img src="../images/botao_editar.png" title="Editar" border="0"/></a>
            </td>
        </tr>
        <tr>
            <td class="result_celula" nowrap>Financeiro</td>
            <td class="result_celula" nowrap>Pedidos � faturar</td>
            <td class="result_celula" align="center" nowrap>
                <a href="rel_afaturar.php"><img src="../images/botao_editar.png" title="Editar" border="0"/></a>
            </td>
        </tr>
    <?
    }
    $permissao = verifica_permissao('Financeiro_rel_royalties', $controle_id_departamento_p, $controle_id_departamento_s);
    if ($permissao == 'TRUE' && $controle_id_empresa == 1) {
        ?>

        <tr>
            <td class="result_celula" nowrap>Financeiro</td>
            <td class="result_celula" nowrap>Cadastro de Franquias</td>
            <td class="result_celula" align="center" nowrap>
                <a href="rel_cadastro_franquia.php"><img src="../images/botao_editar.png" title="Editar"
                                                         border="0"/></a>
            </td>
        </tr>
        <tr>
            <td class="result_celula" nowrap>Financeiro</td>
            <td class="result_celula" nowrap>Royalties em Aberto</td>
            <td class="result_celula" align="center" nowrap>
                <a href="rel_royalties_aberto.php"><img src="../images/botao_editar.png" title="Editar"
                                                        border="0"/></a>
            </td>
        </tr>
    <?
    }
    $permissao = verifica_permissao('Franquia', $controle_id_departamento_p, $controle_id_departamento_s);
    if ($permissao == 'TRUE') {
        ?>
        <tr>
            <td class="result_celula" nowrap>Financeiro</td>
            <td class="result_celula" nowrap>Relat�rio de Royalties e Faturamento da(s) Franquia(s)</td>
            <td class="result_celula" align="center" nowrap>
                <a href="rel_royalties_mensal.php"><img src="../images/botao_editar.png" title="Editar" border="0"/></a>
            </td>
        </tr>
        <tr>
            <td class="result_celula" nowrap>Financeiro</td>
            <td class="result_celula" nowrap>Concilia��o Franquia</td>
            <td class="result_celula" align="center" nowrap>
                <a href="rel_geral.php?relatorio=concilia��o franquia">
                    <img src="../images/botao_editar.png" title="Editar" border="0"/> </a></td>
        </tr>
        <tr>
            <td class="result_celula" nowrap>Financeiro</td>
            <td class="result_celula" nowrap>Pedidos Recebidos de outras Franquias</td>
            <td class="result_celula" align="center" nowrap>
                <a href="gera_pedidos_franquia.php">
                    <img src="../images/botao_editar.png" title="Editar" border="0"/>
                </a>
            </td>
        </tr>
        <? $id_departamento_s = explode(',', $controle_id_departamento_s);
        if ($controle_id_empresa == 1 and in_array('17', $id_departamento_s) == 1) {
            ?>
            <tr>
                <td class="result_celula" nowrap>Franquia</td>
                <td class="result_celula" nowrap>Planejamento Econ�mico Financeiro</td>
                <td class="result_celula" align="center" nowrap>
                    <a href="rel_viabilidade.php">
                        <img src="../images/botao_editar.png" title="Editar" border="0"/> </a></td>
            </tr>

            <tr>
                <td class="result_celula" nowrap>Franquia</td>
                <td class="result_celula" nowrap>Relat�rio Mensal Consolidado</td>
                <td class="result_celula" align="center" nowrap>
                    <a href="rel_royalties.php">
                        <img src="../images/botao_editar.png" title="Editar" border="0"/> </a></td>
            </tr>

            <tr>
                <td class="result_celula" nowrap>Franquia</td>
                <td class="result_celula" nowrap>Relat�rio Anual Consolidado</td>
                <td class="result_celula" align="center" nowrap>
                    <a href="rel_royalties_anual.php">
                        <img src="../images/botao_editar.png" title="Editar" border="0"/>
                    </a>
                </td>
            </tr>
        <?
        }
    }
    $permissao = verifica_permissao('EXPANSAO_S', $controle_id_departamento_p, $controle_id_departamento_s);
    if ($permissao == 'TRUE' and $controle_id_empresa == 1) {
        ?>
        <tr>
            <td class="result_celula" nowrap>Expans�o de Franquia</td>
            <td class="result_celula" nowrap>Pipeline Expans�o</td>
            <td class="result_celula" align="center" nowrap>
                <a href="expansao_pipeline.php" target="_blank">
                    <img src="../images/botao_editar.png" title="Editar" border="0"/> </a></td>
        </tr>
    <?
    }
    $permissao = verifica_permissao('Rel_gerencial', $controle_id_departamento_p, $controle_id_departamento_s);
    if ($permissao == 'TRUE') {
        ?>
        <tr>
            <td class="result_celula" nowrap>Diretoria</td>
            <td class="result_celula" nowrap>Despesa por Servi�o</td>
            <td class="result_celula" align="center" nowrap><a
                    href="rel_despesa_servico.php"><img
                        src="../images/botao_editar.png" title="Editar" border="0"/></a></td>
        </tr>
    <?
    }

    if ($permissao == 'TRUE') {
        ?>
        <tr>
            <td class="result_celula" nowrap>Diretoria / Comercial</td>
            <td class="result_celula" nowrap>Relat�rio Gerencial (Completo)</td>
            <td class="result_celula" align="center" nowrap>
                <a href="rel_geral.php?relatorio=geral"><img src="../images/botao_editar.png" title="Editar"
                                                             border="0"/></a>
            </td>
        </tr>
    <? } ?>
    <?php
    if ((verifica_permissao('Supervisor Atendimento', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE')
        or (verifica_permissao('Supervisor Financeiro', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE')
    ) {
        if ($controle_id_empresa == 1) {
            ?>
            <tr>
                <td class="result_celula" nowrap>Atendimento / Franquia</td>
                <td class="result_celula" nowrap>Chamadas</td>
                <td class="result_celula" align="center" nowrap>
                    <a href="rel_chamado.php"><img src="../images/botao_editar.png" title="Editar" border="0"/></a>
                </td>
            </tr>
        <? } ?>
        <tr>
            <td class="result_celula" nowrap>Atendimento / Financeiro</td>
            <td class="result_celula" nowrap>Vendas por Atendente</td>
            <td class="result_celula" align="center" nowrap>
                <a href="rel_vendas.php"><img src="../images/botao_editar.png" title="Editar" border="0"/></a>
            </td>
        </tr>
        <tr>
            <td class="result_celula" nowrap>Atendimento / Financeiro</td>
            <td class="result_celula" nowrap>Aguardando Identifica��o de Dep�sito</td>
            <td class="result_celula" align="center" nowrap>
                <a href="rel_geral.php?relatorio=concilia��o"><img src="../images/botao_editar.png" title="Editar"
                                                                   border="0"/></a></td>
        </tr>
        <tr>
            <td class="result_celula" nowrap>Atendimento / Financeiro</td>
            <td class="result_celula" nowrap>Relat�rio de Pedidos Cancelados</td>
            <td class="result_celula" align="center" nowrap>
                <a href="rel_geral.php?relatorio=cancelados"><img src="../images/botao_editar.png" title="Editar"
                                                                  border="0"/></a></td>
        </tr>
        <tr>
            <td class="result_celula" nowrap>Atendimento / Financeiro</td>
            <td class="result_celula" nowrap>Pedidos Cadastrados no Per�odo</td>
            <td class="result_celula" align="center" nowrap>
                <a href="gera_pedidos_cadastrados.php"><img src="../images/botao_editar.png" title="Editar" border="0"/></a>
            </td>
        </tr>
        <tr>
            <td class="result_celula" nowrap>Atendimento / Financeiro</td>
            <td class="result_celula" nowrap>Pedidos Em Aberto por Per�odo</td>
            <td class="result_celula" align="center" nowrap>
                <a href="rel_geral.php?relatorio=em aberto"><img src="../images/botao_editar.png" title="Editar"
                                                                 border="0"/></a></td>
        </tr>
        <tr>
            <td class="result_celula" nowrap>Atendimento / Financeiro</td>
            <td class="result_celula" nowrap>Or�amentos Enviados</td>
            <td class="result_celula" align="center" nowrap>
                <a href="rel_geral.php?relatorio=or�amento"><img src="../images/botao_editar.png" title="Editar"
                                                                 border="0"/></a></td>
        </tr>
        <tr>
            <td class="result_celula" nowrap>Atendimento / Financeiro</td>
            <td class="result_celula" nowrap>Pedidos Fechados no dia</td>
            <td class="result_celula" align="center" nowrap>
                <a href="rel_operacional.php"><img src="../images/botao_editar.png" title="Editar" border="0"/></a>
            </td>
        </tr>
    <?
    }

    if (verifica_permissao('Rel_comercial', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE' or verifica_permissao('Financeiro_rel', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE' or verifica_permissao('Rel_gerencial', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE') {
        ?>
        <tr>
            <td class="result_celula" nowrap>Atendimento / Financeiro</td>
            <td class="result_celula" nowrap>Faturamento por Cliente Corporativo</td>
            <td class="result_celula" align="center" nowrap>
                <a href="rel_pj.php"><img src="../images/botao_editar.png" title="Editar" border="0"/></a></td>
        </tr>

    <?
    }

    $permissao = verifica_permissao('Rel_supervisores', $controle_id_departamento_p, $controle_id_departamento_s);
    $permissao_n = verifica_permissao('Rel_n_supervisores', $controle_id_departamento_p, $controle_id_departamento_s);
    if ($permissao == 'TRUE') {
        ?>
        <tr>
            <td class="result_celula" nowrap>Operacional</td>
            <td class="result_celula" nowrap>Por Departamento</td>
            <td class="result_celula" align="center" nowrap>
                <a href="rel_dep.php"><img src="../images/botao_editar.png" title="Editar" border="0"/></a></td>
        </tr>
    <?
    }
    if ($permissao_n == 'TRUE') {
        ?>
        <tr>
            <td class="result_celula" nowrap>Operacional</td>
            <td class="result_celula" nowrap>Conclu�do Operacional</td>
            <td class="result_celula" align="center" nowrap><a
                    href="rel_dep_op.php"><img src="../images/botao_editar.png"
                                               title="Editar" border="0"/></a></td>
        </tr>
    <? } ?>
    <?php
    if ($controle_id_empresa == 1 and $controle_depto_p['27'] == '1') {
        ?>
        <tr>
            <td class="result_celula" nowrap>Operacional</td>
            <td class="result_celula" nowrap>Adendo</td>
            <td class="result_celula" align="center" nowrap>
                <a href="gera_rel_franquia_adendo.php"><img src="../images/botao_editar.png" title="Editar" border="0"/></a>
            </td>
        </tr>
    <?php } ?>
    </table>
    </td>
    </tr>

    </table>
    </div>
<?php
require('footer.php');
?>