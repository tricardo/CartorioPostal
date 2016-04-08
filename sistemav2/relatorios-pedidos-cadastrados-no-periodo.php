<?php
require("includes.php");

$pedidoDAO = new PedidoDAO();
$departamentoDAO = new DepartamentoDAO();
$usuarioDAO = new UsuarioDAO();
if($_POST){
    
    require("includes/geraexcel/excelwriter.inc.php");
    
    $arr = array('dia_i','dia_f','mes','ano','tipo','origem','departamento,','id_atendente','campos');
    $ci = Post_StdClass($_POST);
    for($i = 0; $i < count($arr); $i++){
        if(isset($_POST[$arr[$i]])){
            pt_register('POST', $arr[$i]);
        }
    }
    
    if(isset($campos)){
        foreach($campos AS $f){
            $$f = 'on';
        }
    }
    
    $valor_total = 0;
    $valor_valor = 0;
    $valor_sedex = 0;
    $valor_rateio = 0;
    $valor_rec = 0;
    $valor_lucro = 0;
    
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
       
    
    $permissao = verifica_permissao('Financeiro', $controle_id_departamento_p, $controle_id_departamento_s);

    $arquivoDiretorio = "relatorios/cadastrados/";
    $nomeArquivo = 'cadastrados_' . date("Ym") . "_" . $controle_id_empresa . ".xls";
    $arquivoDiretorio = $arquivoDiretorio . $nomeArquivo;
    $excel = new ExcelWriter($arquivoDiretorio);
    
    $pedidos = $pedidoDAO->listaPedidosCadastrados($controle_id_empresa, $data_i, $data_f, $tipo, $id_atendente, $ci);
    
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
        $campos[] = utf8_decode('Honorários');
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
            $campos[] = ($p->departamento);
        }
        if ($c_servico == 'on') {
            $campos[] = ($p->servico);
        }
        if ($c_forma == 'on') {
            $campos[] = ($p->forma_pagamento);
        }
        if ($c_programado == 'on') {
            $campos[] = invert($p->programado, '/', 'PHP');
        }
        if ($c_atendente == 'on') {
            $campos[] = ($p->atendente);
        }
        if ($c_origem == 'on') {
            $campos[] = ($p->origem);
        }
        if ($c_status == 'on') {
            $campos[] = ($p->status);
        }
        if ($c_prazo == 'on') {
            $campos[] = invert($p->data_prazo, '/', 'PHP');
        }
        if ($c_entrega == 'on') {
            $campos[] = invert($p->encerramento, '/', 'PHP');
        }
        if ($c_cidade == 'on') {
            $campos[] = ($p->certidao_cidade);
        }
        if ($c_estado == 'on') {
            $campos[] = ($p->certidao_estado);
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
    header("Content-type: octet/stream;  charset=utf-8");
    header("Content-disposition: attachment; filename=exporta/" . $nomeArquivo . ";");
    header("Content-Length: " . filesize($arquivoDiretorio));
    readfile($arquivoDiretorio);
    die();
    
} else {
    pt_register('GET','pg');
    $pagina = RelTipTit($pg);
    
    $c = new stdClass();
    $c->ano        = date('Y');
    $c->mes        = date('m');
    $c->dia_i      = '01';
    $c->dia_f      = date('d');
    $c->id_empresa = '';
    
    include('header2.php'); ?>
    <script>
        menu(3,'bt-05');
        $('#titulo').html('relatórios &rsaquo;&rsaquo; <a href="<?=$pagina['retorno']?>" id="voltar"><?=$pagina['titulo']?></a> &rsaquo;&rsaquo; Pedidos Cadastrados no Período');
        $('#sub-<?=$pagina['sub']?>').css({'font-weight':'bold'});
    </script>
    <div class="content-list-forms">
        <form method="post" target="blank">
            <dl>
                <legend>Relatório Pedidos Cadastrados no Período</legend>
                <dt>Entre Dia:</dt>
                <dd><input type="text" class="numero" name="dia_i" id="dia_i" value="<?=$c->dia_i?>" placeholder="Primeira Data"></dd>
                <dt>E:</dt>
                <dd><input type="text" class="numero" name="dia_f" id="dia_f" value="<?=$c->dia_f?>" placeholder="Segunda Data"></dd>
                <dt>Mês:</dt>
                <dd>
                    <select id="mes" name="mes" class="chzn-select">
                        <?php foreach(DataAno() AS $p => $f){ ?>
                        <option value="<?=$p?>"<?=$p==$c->mes ? ' selected="selected"' : ''?>><?=$f?></option>
                        <?php } ?>
                    </select>
                </dd>
                <dt>Ano:</dt>
                <dd>
                    <select id="ano" name="ano" class="chzn-select">
                        <?php foreach(DataAno(2) AS $p => $f){ ?>
                        <option value="<?=$p?>"<?=$p==$c->ano ? ' selected="selected"' : ''?>><?=$f?></option>
                        <?php } ?>
                    </select>
                </dd>
                <dt>Tipo:</dt>
                <dd>
                    <select name="tipo" id="tipo" class="chzn-select">
                        <option value="">Tipo</option>
                        <?php 
                        foreach(TiposDeStatus AS $f){ ?>
                        <option value="<?=$f['id']?>"><?=$f['texto']?></option>
                        <?php } ?>
                    </select>
                </dd>
                <dt>Origem:</dt>
                <dd>
                    <select name="origem" id="origem" class="chzn-select">
                        <option value="">Origem</option>
                        <?php 
                        foreach($pedidoDAO->listarOrigem() AS $f){ ?>
                        <option value="<?=($f->origem)?>"><?=($f->origem)?></option>
                        <?php } ?>
                    </select>
                </dd>
                <dt>Departamento:</dt>
                <dd>
                    <select name="departamento" id="departamento" class="chzn-select">
                        <option value="">Departamento</option>
                        <?php 
                        foreach($departamentoDAO->carregarCombo() AS $f){ ?>
                        <option value="<?=$f->id_servico_departamento?>"><?=($f->departamento)?></option>
                        <?php } ?>
                    </select>
                </dd>
                <dt>Atendente:</dt>
                <dd>
                    <select name="id_atendente" id="id_atendente" class="chzn-select">
                        <option value="">Atendente</option>
                        <?php 
                        foreach($usuarioDAO->listarAtendentes($controle_id_empresa) AS $f){ ?>
                        <option value="<?=$f->id_usuario?>"><?=($f->nome)?></option>
                        <?php } ?>
                    </select>
                </dd>
                <dt>Campos:</dt>
                <dd class="checkbox-inline">
                    <?php
                    $arr = TableFields();
                    sort($arr);
                    foreach($arr AS $f){ ?>
                        <div>
                            <input type="checkbox" id="<?=$f[0]?>" name="campos[]" value="<?=$f[0]?>" checked="checked">
                            <label><?=$f[1]?></label>
                        </div>
                    <?php } ?>
                </dd>
                <div class="buttons">
                    <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
                    <input type="button" value="&lsaquo;&lsaquo; limpar" onclick="location.href=window.location.pathname+'?pg=<?=$pg?>'">
                    <input type="submit" value="buscar &rsaquo;&rsaquo;">
                </div>
            </dl>
        </form>
        <script>preencheCampo()</script>
    </div>
    <div class="content-list-table">
        <?php if($_POST){
            RetornaVazio();
        } else {
            RetornaVazio(2); } ?>
    </div>
    <?php include('footer.php'); 
}?>