<?php require('header.php'); ?>
<div id="topo"><?php
$permissao = verifica_permissao('Financeiro PgtoCont', $controle_id_departamento_p, $controle_id_departamento_s);
if ($permissao == 'FALSE') {
    echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
    exit;
}
pt_register('GET', 'submit');
pt_register('GET', 'pagina');
if ($submit <> '') {
    pt_register('GET', 'busca');
    pt_register('GET', 'id_departamento');
    pt_register('GET', 'situacao');
    pt_register('GET', 'busca_data_i');
    pt_register('GET', 'busca_data_f');
    pt_register('GET', 'id_forma_pagamento');
    #grava secao da busca
    $_SESSION['pgto_busca'] = $busca;
    $_SESSION['pgto_id_departamento'] = $id_departamento;
    $_SESSION['pgto_situacao'] = $situacao;
    $_SESSION['pgto_data_i'] = $busca_data_i;
    $_SESSION['pgto_data_f'] = $busca_data_f;
    $_SESSION['pgto_id_forma_pagamento'] = $id_forma_pagamento;
} else {
    $busca = $_SESSION['pgto_busca'];
    $id_departamento = $_SESSION['pgto_id_departamento'];
    $situacao = $_SESSION['pgto_situacao'];
    $busca_data_i = $_SESSION['pgto_data_i'];
    $busca_data_f = $_SESSION['pgto_data_f'];
    $id_forma_pagamento = $_SESSION['pgto_id_forma_pagamento'];
}

if ($busca_data_i == '')
    $busca_data_i = date('d/m/Y', strtotime("- 1 month"));

if ($busca_data_f == '')
    $busca_data_f = date('d/m/Y', strtotime("+ 1 month"));

$financeiroDAO = new FinanceiroDAO();

$departamentoDAO = new DepartamentoDAO();
$departamentos = $departamentoDAO->listar();
?>
    <h1 class="tit"><img src="../images/tit/tit_cliente.png" alt="Título" />Contas à Pagar</h1>
    <a href="#" class="topo">topo</a>
    <hr class="tit" />
</div>
<div id="meio">
    <table border="0" height="100%" width="100%">
        <tr>
            <td valign="top">
                <form name="f1" action="" method="get" ENCTYPE="multipart/form-data">
                    <div class="busca1">
                        <label>Buscar: </label>
                        <input type="text" class="form_estilo" style="width:200px" name="busca" value="<?= $busca ?>" />
                        <label>Centro de Custo: </label>
                        <select name="id_departamento" class="form_estilo" style="width:200px">
                            <?php
                            $p_valor = '<option value=""></option>';
                            foreach ($departamentos as $dep) {
                                $p_valor .= '<option value="' . $dep->id_departamento . '"';
                                if ($dep->id_departamento == $id_departamento) $p_valor .= ' selected="selected"';
                                $p_valor .= '>' . $dep->departamento . '</option>';
                            }
                            echo $p_valor;
                            ?>
                        </select>
                        <label>Forma: </label>
                        <select name="id_forma_pagamento" class="form_estilo" style="width:200px">
                            <?php
                            $p_valor = '<option value=""></option>';
                            $forma = $financeiroDAO->listarFormaPagamentoCAP();
                            foreach ($forma as $f) {
                                $p_valor .= '<option value="' . $f->id_forma_pagamento . '" ';
                                if ($id_forma_pagamento == $f->id_forma_pagamento)
                                    $p_valor .= 'selected="selected"';
                                $p_valor .= '>' . $f->forma_pagamento . '</option>';
                            }
                            echo $p_valor;
                            ?>
                        </select>
                        <label>Situação: </label>
                        <select name="situacao" class="form_estilo"  style="width:200px" >
                            <option <?php if ($situacao == 'À Pagar') echo 'selected="selected"'; ?> value="À Pagar">À Pagar</option>
                            <option <?php if ($situacao == 'Pagas') echo 'selected="selected"'; ?> value="Pagas">Pagas</option>
                            <option <?php if ($situacao == '') echo 'selected="selected"'; ?> value="">Todas</option>
                        </select>
                        <label>Entre Datas: </label>
                        <input type="text" class="form_estilo" style="width:90px;" value="<?php echo $busca_data_i ?>" name="busca_data_i" onKeyUp="masc_numeros(this,'##/##/####');">
                        <strong>e </strong>
                        <input type="text" class="form_estilo" style="width:90px;" value="<?php echo $busca_data_f ?>" name="busca_data_f" onKeyUp="masc_numeros(this,'##/##/####');">
                        <input type="submit" name="submit" class="button_busca" value=" Buscar " onclick="document.f1.target='_self'; document.f1.action=''"/>
                        <? if ($controle_id_empresa == '1') { ?>
                            <input type="submit" name="submit_exporta_2" onclick="document.f1.target='_blank'; document.f1.action='gera_exporta_pgto.php'" class="button_busca" value=" Exportar Todos " />
                        <? } ?>
                    </div>

                </form>
                <div style="clear: both"><br />
                    <a href="pagamento_add.php">
                        <h3><img src="../images/botao_add.png" border="0" /> Adicionar novo registro</h3>
                    </a>
                </div>
                <?php
                $b->busca = $busca;
                $b->id_departamento = $id_departamento;
                $b->situacao = $situacao;
                $b->id_forma_pagamento = $id_forma_pagamento;
                $b->data_i = ($busca_data_i != "") ? invert($busca_data_i, '-', 'SQL') : '';
                $b->data_f = ($busca_data_f != "") ? invert($busca_data_f, '-', 'SQL') : '';
                $pagamentoDAO = new PagamentoDAO();

                $pagamentos = $pagamentoDAO->busca($b, $controle_id_empresa, $pagina);
                $p_valor = "";
                ?> 
                <br />
                <table width="100%" cellpadding="4" cellspacing="1"
                       class="result_tabela">
                    <tr>
                        <td colspan="13" class="barra_busca">
                        <?php
                        $pagamentoDAO->QTDPagina();
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" width="40" class="result_menu"><b>Editar</b></td>
                        <td class="result_menu" width="40"><b>ID</b></td>
                        <td class="result_menu" width="40"><b>Parc.</b></td>
                        <td class="result_menu"><b>Fornecedor</b></td>
                        <td class="result_menu"><b>Descrição</b></td>
                        <td class="result_menu" width="80"><b>Forma</b></td>
                        <td class="result_menu" width="70" align="right"><b>Doc. Físico</b></td>
                        <td class="result_menu" width="40"><b>Vencimento</b></td>
                        <td class="result_menu" width="70" align="right"><b>Valor</b></td>
                        <td class="result_menu" width="70" align="right"><b>Desconto</b></td>
                        <td class="result_menu" width="70" align="right"><b>Multa/Juros</b></td>
                        <td class="result_menu" width="70"><b>Valor Pg</b></td>
                        <td class="result_menu" width="70"><b>Deletar</b></td>
                    </tr>

                    <?
                    $p_valor = '';
                    if($controle_depto_p['27']!=1)
                        $condicional = "if(confirm('Deseja realmente excluir esse registro?')) excluir_contaapagar('";
                    else
                        $condicional = "alert('Você não tem permissão de realizar essa operação! - ";
                    foreach ($pagamentos as $p) {
                        $classe = ($p->dt_vencimento < date("Y-m-d") && $p->dt_pagamento == '//') ? 'result_celula_erro' : '';
                        
                        if ($p->fisico == '1')
                            $fisico = 'Sim'; else
                            $fisico = 'Não';
                        $p_valor .= '<tr>
                                <td class="result_celula" align="center"><a href="pagamento_edit.php?id_pagamento=' . $p->id_pagamento . '"><img src="../images/botao_editar.png" title="Editar" border="0"/></a></td>
                                <td class="result_celula">' . $p->id_pagamento . '</td>
                                <td class="result_celula">' . $p->parcela . '/' . $p->qt_parcelas . '</td>
                                <td class="result_celula">' . $p->favorecido . '</td>
                                <td class="result_celula">' . $p->descricao . '</td>
                                <td class="result_celula">' . $p->forma_pagamento . '</td>
                                <td class="result_celula ' . $classe . '" align="right">' . $fisico . '</td>
                                <td class="result_celula">' . invert($p->dt_vencimento, '/', 'PHP') . '</td>
                                <td class="result_celula ' . $classe . '" align="right">R$ ' . $p->valor . '</td>
                                <td class="result_celula ' . $classe . '" align="right">R$ ' . $p->desconto . '</td>
                                <td class="result_celula ' . $classe . '" align="right">R$ ' . $p->vlr_multa . '</td>
                                <td class="result_celula ' . $classe . '" align="right">R$ ' . $p->valor_pg . '</td>
                                <td class="result_celula" align="center" id="exc_' . $p->id_pagamento . '">
                                    <a href="javascript:void();" onclick="'.$condicional . $p->id_pagamento . '\');"><img src="../images/botao_delete.png" title="Editar" border="0"/></a>
                                </td>
                            </tr>';
                    }
                    $res = $pagamentoDAO->result();
                    $p_valor .= '<tr>
                                <td class="result_celula" align="center"></td>
                                <td class="result_celula"></td>
                                <td class="result_celula"></td>
                                <td class="result_celula"></td>
                                <td class="result_celula"></td>
                                <td class="result_celula"></td>
                                <td class="result_celula"></td>
                                <td class="result_celula"></td>
                                <td class="result_celula" align="right">R$ ' . $res->valor . '</td>
                                <td class="result_celula" align="right">R$ ' . $res->desconto . '</td>
                                <td class="result_celula" align="right">R$ ' . $res->vlr_multa . '</td>
                                <td class="result_celula" align="right">R$ ' . $res->valor_pg . '</td>
                                <td class="result_celula"></td>
                            </tr>';
                    echo $p_valor;
                    ?>
                    <tr>
                        <td colspan="13" class="barra_busca">
                        <?php
                        $pagamentoDAO->QTDPagina();
                        ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<?php
require('footer.php');
?>