<?php
require( "../includes/verifica_logado_ajax.inc.php");
$submit = $_POST['submit'];

if ($submit) {
    require( "../includes/global.inc.php" );
    require( "../includes/funcoes.php" );
    require("../includes/geraexcel/excelwriter.inc.php");

    $permissao = verifica_permissao('Financeiro', $controle_id_departamento_p, $controle_id_departamento_s);

    pt_register('POST', 'ano');
    pt_register('POST', 'mes');
    pt_register('POST', 'dia_i');
    pt_register('POST', 'dia_f');
    pt_register('POST', 'tipo');
    pt_register('POST', 'c_cidade');
    pt_register('POST', 'c_estado');
    pt_register('POST', 'c_dpto');
    pt_register('POST', 'c_servico');
    pt_register('POST', 'c_forma');
    pt_register('POST', 'c_programado');
    pt_register('POST', 'c_atendente');
    pt_register('POST', 'c_origem');
    pt_register('POST', 'c_status');
    pt_register('POST', 'c_prazo');
    pt_register('POST', 'c_entrega');
    pt_register('POST', 'id_atendente');
    pt_register('POST', 'origem');
    pt_register('POST', 'departamento');
    $p->origem = $origem;
    $p->departamento = $departamento;
    
    if ($dia_i == '')
        $dia_i = '01';
    if ($dia_f == '')
        $dia_f = '31';

    if (strlen($dia_i) < 2)
        $dia_i = '0' . $dia_i;
    if (strlen($dia_f) < 2)
        $dia_f = '0' . $dia_f;

    $data_i = $ano . '-' . $mes . '-' . $dia_i . ' 00:00:00';
    $data_f = $ano . '-' . $mes . '-' . $dia_f . ' 23:59:59';

    $pedidoDAO = new PedidoDAO();
    $pedidos = $pedidoDAO->listaPedidosCadastrados($controle_id_empresa, $data_i, $data_f, $tipo, $id_atendente,$p);

    $nomeArquivo = 'cadastrados_' . date("Ym") . "_" . $controle_id_empresa . ".xls";
    $arquivoDiretorio = "../relatorios/cadastrados/" . $nomeArquivo;
    $excel = new ExcelWriter($arquivoDiretorio);

    if ($excel == false) {
        echo $excel->error . "????";
        exit;
    }

    $semana = 0;
    $toral = 0;
    $pedidos_conta = 0;
    $campos = array('Data', 'Ordem', 'Cliente');
    $campos_fim = array('Total', '', '');

    if ($c_dpto == 'on') {
        $campos[] = 'Departamento';
        $campos_fim[] = '';
    }
    if ($c_servico == 'on') {
        $campos[] = 'Serviço';
        $campos_fim[] = '';
    }
    if ($c_forma == 'on') {
        $campos[] = 'Forma de pagamento';
        $campos_fim[] = '';
    }
    if ($c_programado == 'on') {
        $campos[] = 'Programado';
        $campos_fim[] = '';
    }
    if ($c_atendente == 'on') {
        $campos[] = 'Atendente';
        $campos_fim[] = '';
    }
    if ($c_origem == 'on') {
        $campos[] = 'Origem';
        $campos_fim[] = '';
    }
    if ($c_status == 'on') {
        $campos[] = 'Status';
        $campos_fim[] = '';
    }
    if ($c_prazo == 'on') {
        $campos[] = 'Prazo';
        $campos_fim[] = '';
    }
    if ($c_entrega == 'on') {
        $campos[] = 'Data da Entrega';
        $campos_fim[] = '';
    }
    if ($c_cidade == 'on') {
        $campos[] = 'Cidade';
        $campos_fim[] = '';
    }
    if ($c_estado == 'on') {
        $campos[] = 'Estado';
        $campos_fim[] = '';
    }

    if ($permissao == 'TRUE') {
        $campos[] = 'Custas';
        $campos[] = 'Correios';
        $campos[] = 'Honorários';
        $campos[] = 'Total de Custo';
        $campos[] = 'Valor Cobrado';
        $campos[] = 'Valor Recebido';
        $campos[] = 'Lucro';
    } else {
        $campos[] = 'Valor Cobrado';
    }
    $excel->writeLine($campos);

    foreach ($pedidos as $i => $p) {
        $data = date('d/m/Y', strtotime($p->data));
        $pedidos_conta++;
        $total = (float) ($p->financeiro_valor) + (float) ($p->financeiro_sedex) + (float) ($p->financeiro_rateio);
        if ($p->id_status != 14) {
            $lucro = (float) ($p->valor) - (float) ($total);
        } else {
            $lucro = 0;
            $p->valor = 0;
        }

        $campos = array($data, $p->id_pedido . '/' . $p->ordem, $p->cliente);
        if ($c_dpto == 'on') {
            $campos[] = $p->departamento;
        }
        if ($c_servico == 'on') {
            $campos[] = $p->servico;
        }
        if ($c_forma == 'on') {
            $campos[] = $p->forma_pagamento;
        }
        if ($c_programado == 'on') {
            $campos[] = invert($p->programado, '/', 'PHP');
        }
        if ($c_atendente == 'on') {
            $campos[] = $p->atendente;
        }
        if ($c_origem == 'on') {
            $campos[] = $p->origem;
        }
        if ($c_status == 'on') {
            $campos[] = $p->status;
        }
        if ($c_prazo == 'on') {
            $campos[] = invert($p->data_prazo, '/', 'PHP');
        }
        if ($c_entrega == 'on') {
            $campos[] = invert($p->encerramento, '/', 'PHP');
        }
        if ($c_cidade == 'on') {
            $campos[] = $p->certidao_cidade;
        }
        if ($c_estado == 'on') {
            $campos[] = $p->certidao_estado;
        }

        if ($permissao == 'TRUE') {
            $campos[] = $p->financeiro_valor;
            $campos[] = $p->financeiro_sedex;
            $campos[] = $p->financeiro_rateio;
            $campos[] = $total;
            $campos[] = $p->valor;
            $campos[] = $p->valor_rec;
            $campos[] = $lucro;
        } else {
            $campos[] = $p->valor;
        }

        $excel->writeLine($campos);
        $valor_total = (float) ($p->valor) + (float) ($valor_total);
        $valor_valor = (float) ($p->financeiro_valor) + (float) ($valor_valor);
        $valor_sedex = (float) ($p->financeiro_sedex) + (float) ($valor_sedex);
        $valor_rateio = (float) ($p->financeiro_rateio) + (float) ($valor_rateio);
        $valor_rec = (float) ($p->valor_rec) + (float) ($valor_rec);
        $valor_lucro = (float) ($lucro) + (float) ($valor_lucro);
    }
    if ($permissao == 'TRUE') {
        $valor_total_t = (float) ($valor_valor) + (float) ($valor_sedex) + (float) ($valor_rateio);
        $campos_fim[] = $valor_valor;
        $campos_fim[] = $valor_sedex;
        $campos_fim[] = $valor_rateio;
        $campos_fim[] = $valor_total_t;
        $campos_fim[] = $valor_total;
        $campos_fim[] = $valor_rec;
        $campos_fim[] = $valor_lucro;
    } else {
        $campos_fim[] = $valor_total;
    }
    $excel->writeLine($campos_fim);

    $excel->close();
    header("Content-type: octet/stream");
    header("Content-disposition: attachment; filename=exporta/" . $nomeArquivo . ";");
    header("Content-Length: " . filesize($arquivoDiretorio));
    readfile($arquivoDiretorio);
    die();
//	echo '</table>';
} else {

    require('header.php');
    $empresaDAO = new EmpresaDAO();
    $empresas = $empresaDAO->listarTodas();
    $pedidoDAO = new PedidoDAO();    
    ?>
    <div id="meio">
        <form method="post">
            <table class="tabela">
                <tr>
                    <td class="tabela_tit" colspan="4">Relatório de pedidos cadastrados</td>
                </tr>
                <tr>
                    <td align="right"><b>Entre dia:</b></td>
                    <td colspan="2"><input type="text" name="dia_i" class="form_estilo" size="1" />
                        <b>e </b><input type="text" name="dia_f" class="form_estilo" size="1" /></td>
                </tr>
                <tr>
                    <td align="right"><b>Mês</b></td>
                    <td colspan="2">
                        <select name="mes" class="form_estilo" style="width:85px" >
                            <option value="01">Janeiro</option>
                            <option value="02">Fevereiro</option>
                            <option value="03">Março</option>
                            <option value="04">Abril</option>
                            <option value="05">Maio</option>
                            <option value="06">Junho</option>
                            <option value="07">Julho</option>
                            <option value="08">Agosto</option>
                            <option value="09">Setembro</option>
                            <option value="10">Outubro</option>
                            <option value="11">Novembro</option>
                            <option value="12">Dezembro</option>
                        </select>
                        <b>Ano:</b>

                        <select name="ano" class="form_estilo">
							<?for($i = 2009; $i <= date('Y'); $i++){?>
                            <option value="<?=$i?>"<?=($i == date('Y')) ? ' selected="selected"':''?>><?=$i?></option>
							<?}?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right"><b>Tipo:</b></td>
                    <td><select name="tipo" class="form_estilo" style="width:200px">
                            <option value="">Todos</option>
                            <option value="cpf">cpf</option>
                            <option value="cnpj">cnpj</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right"><b>Origem:</b></td>
                    <td><select name="origem" class="form_estilo" style="width:200px">
                            <option value="">Todos</option>
                            <?
                            $var = $pedidoDAO->listarOrigem();
                            $p_valor = '';
                            foreach ($var as $s) {
                                $p_valor .= '<option value="' . $s->origem . '"';
                                if ($busca_origem == $s->origem)
                                    $p_valor .= ' selected="selected" ';
                                $p_valor .= ' >' . $s->origem . '</option>';
                            }
                            echo $p_valor;
                            ?>
                        </select>
                    </td>
                </tr>    
                <tr>
                    <td align="right"><b>Departamento:</b></td>
                    <td><select name="departamento" class="form_estilo" style="width:200px">
                            <option value="">Todos</option>
                            <?
                            $departamentoDAO = new DepartamentoDAO();
                            $var = $departamentoDAO->carregarCombo();
                            $p_valor = '';
                            foreach ($var as $s) {
                                $p_valor .= '<option value="' . $s->id_servico_departamento . '"';
                                if ($busca_departamento == $s->id_servico_departamento)
                                    $p_valor .= ' selected="selected" ';
                                $p_valor .= ' >' . $s->departamento . '</option>';
                            }
                            echo $p_valor;
                            ?>
                        </select>
                    </td>
                </tr>        
                
                <tr>
                    <td align="right"><b>Atendente:</b></td>
                    <td>
                        <select name="id_atendente"  class="form_estilo" style="width:200px">
                            <option></option>
                            <?php
                            $usuarioDAO = new UsuarioDAO();
                            $var = $usuarioDAO->listarAtendentes($controle_id_empresa);
                            $p_valor = '';
                            foreach ($var as $s) {
                                $p_valor .= '<option value="' . $s->id_usuario . '"';
                                if ($busca_id_usuario == $s->id_usuario)
                                    $p_valor .= ' selected="selected" ';
                                $p_valor .= ' >' . $s->nome . '</option>';
                            }
                            echo $p_valor;
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right"><b>Campos:</b></td>
                    <td>
                        <input type="checkbox" name="c_atendente" checked/> Atendente <br>
                        <input type="checkbox" name="c_cidade" checked/> Cidade <br>
                        <input type="checkbox" name="c_dpto" checked/> Departamento <br>
                        <input type="checkbox" name="c_entrega" checked/> Entrega <br>
                        <input type="checkbox" name="c_estado" checked/> Estado <br>
                        <input type="checkbox" name="c_forma" checked/> Forma de Pagamento <br>
                        <input type="checkbox" name="c_origem" checked/> Origem <br>
                        <input type="checkbox" name="c_prazo" checked/> Prazo <br>
                        <input type="checkbox" name="c_programado" checked/> Programado <br>
                        <input type="checkbox" name="c_servico" checked/> Serviço <br>
                        <input type="checkbox" name="c_status" checked/> Status <br>
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" name="submit" value="enviar" class="button_busca" /></td>
                </tr>
            </table>
        </form>
    </div>
    <?php
}
?>