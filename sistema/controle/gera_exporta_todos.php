<?php

require("../includes/verifica_logado_ajax.inc.php");
require("../includes/funcoes.php");
require("../includes/global.inc.php");
require("../classes/spreadsheet_excel_writer/Writer.php");
$pedidoDAO = new PedidoDAO();
$empresaDAO = new EmpresaDAO();

$lista = $empresaDAO->listarTodas();
foreach ($lista as $l) {
    $vardir[$l->id_empresa] = $l->fantasia;
}

#inicio do código excel
$arquivo = $controle_id_usuario . ".xls";
//monta as abas da planilha
$abas = array('Consulta de Pedidos Sistecart');
$i = 0;
require('../includes/excelstyle.php');
$worksheet = & $workbook->addWorksheet(str_replace(' ', '_', $abas[$i]));

$busca_exibicao = $_SESSION['p_busca_exibicao'];
$busca_e_inicio = $_COOKIE['p_busca_e_inicio'];
$busca_e_prazo = $_COOKIE['p_busca_e_prazo'];
$busca_e_agenda = $_COOKIE['p_busca_e_agenda'];
$busca_e_data_atividade = $_COOKIE['p_busca_e_data_atividade'];
$busca_e_valor = $_COOKIE['p_busca_e_valor'];
$busca_e_departamento = $_COOKIE['p_busca_e_departamento'];
$busca_e_servico = $_COOKIE['p_busca_e_servico'];
$busca_e_cidade = $_COOKIE['p_busca_e_cidade'];
$busca_e_estado = $_COOKIE['p_busca_e_estado'];
$busca_e_status = $_COOKIE['p_busca_e_status'];
$busca_e_atividade = $_COOKIE['p_busca_e_atividade'];
$busca_e_responsavel = $_COOKIE['p_busca_e_responsavel'];
$busca_e_atendimento = $_COOKIE['p_busca_e_atendimento'];

$j = 0;
$worksheet->write(0, $j, '#', $styletitulo3);
$j++;
if ($busca_e_inicio == 'on') {
    $worksheet->write(0, $j, 'Abertura', $styletitulo3);
    $j++;
}

if ($busca_e_prazo == 'on') {
    $worksheet->write(0, $j, 'Prazo', $styletitulo3);
    $j++;
}

if ($busca_e_conclu == 'on') {
    $worksheet->write(0, $j, 'Concluído Oper.', $styletitulo3);
    $j++;
}
if ($busca_e_data_atividade == 'on') {
    $worksheet->write(0, $j, 'Data Status', $styletitulo3);
    $j++;
}

$worksheet->write(0, $j, 'CPF', $styletitulo3);
$j++;
$worksheet->write(0, $j, 'CNPJ', $styletitulo3);
$j++;
$worksheet->write(0, $j, 'Documento de', $styletitulo3);
$j++;
if ($_SESSION['p_busca_id_servico'] == 17) {
    $worksheet->write(0, $j, 'Notificante', $styletitulo3);
    $j++;
}

if ($busca_e_devedor == 'on') {
    $worksheet->write(0, $j, 'Devedor', $styletitulo3);
    $j++;
}

if ($busca_e_servico == 'on') {
    $worksheet->write(0, $j, 'Serviço', $styletitulo3);
    $j++;
}

if ($busca_e_estado == 'on') {
    $worksheet->write(0, $j, 'Estado', $styletitulo3);
    $j++;
}

if ($busca_e_cidade == 'on') {
    $worksheet->write(0, $j, 'Cidade', $styletitulo3);
    $j++;
}

if ($busca_e_atividade == 'on') {
    $worksheet->write(0, $j, 'Atividade', $styletitulo3);
    $j++;
}

if ($busca_e_status == 'on') {
    $worksheet->write(0, $j, 'Status', $styletitulo3);
    $j++;
}

if ($busca_e_agenda == 'on') {
    $worksheet->write(0, $j, 'Agenda', $styletitulo3);
    $j++;
}

if ($busca_e_valor == 'on') {
    $worksheet->write(0, $j, 'Valor', $styletitulo3);
    $j++;
}

if ($busca_e_departamento == 'on') {
    $worksheet->write(0, $j, 'Departamento', $styletitulo3);
    $j++;
}

if ($busca_e_atendimento == 'on') {
    $worksheet->write(0, $j, 'Atendimento', $styletitulo3);
    $j++;
}

if ($busca_e_responsavel == 'on') {
    $worksheet->write(0, $j, 'Responsável', $styletitulo3);
    $j++;
}
$worksheet->write(0, $j, 'Resultado', $styletitulo3);
$j++;
$worksheet->write(0, $j, 'Outra Franquia', $styletitulo3);
$j++;
$worksheet->write(0, $j, 'Direcionado Para', $styletitulo3);
$j++;

$lista = $pedidoDAO->execSession();
foreach ($lista as $l) {

    $i++;
    $j = 0;
    $worksheet->write($i, $j, '#' . $l->id_pedido . '/' . $l->ordem, $styleleft);
    $j++;

    if ($busca_e_inicio == 'on') {
        $worksheet->write($i, $j, invert($l->inicio, '/', 'php'), $stylecenter);
        $j++;
    }

    if ($busca_e_prazo == 'on') {
        $worksheet->write($i, $j, invert($l->data_prazo, '/', 'php'), $stylecenter);
        $j++;
    }

    if ($busca_e_conclu == 'on') {
        $worksheet->write($i, $j, invert($l->operacional, '/', 'php'), $stylecenter);
        $j++;
    }

    if ($busca_e_data_atividade == 'on') {
        $worksheet->write($i, $j, invert($l->data_atividade, '/', 'PHP'), $stylecenter);
        $j++;
    }

    if ($busca_exibicao <> '') {
        $r_nome = $l->nome;
        if ($l->tipo == 'cpf')
            $r_cpf = $l->cpf . ' .';
        else
            $r_cnpj = $l->cpf . ' .';
    }else {
        $r_nome = $l->certidao_nome . $l->certidao_nome_proprietario;
        if ($l->certidao_cpf <> '')
            $r_cpf = $l->certidao_cpf . ' .';
        else
            $r_cpf = '';
        if ($l->certidao_cnpj <> '')
            $r_cnpj = $l->certidao_cnpj . ' .';
        else
            $r_cnpj = '';
    }

    $worksheet->write($i, $j, $r_cpf, $styleleft);
    $j++;
    $worksheet->write($i, $j, $r_cnpj, $styleleft);
    $j++;
    $worksheet->write($i, $j, $r_nome, $styleleft);
    $j++;
    if ($_SESSION['p_busca_id_servico'] == 17) {
        $worksheet->write($i, $j, $l->certidao_requerente, $styleleft);
        $j++;
    }

    if ($busca_e_devedor == 'on') {
        $worksheet->write($i, $j, $l->certidao_devedor, $styleleft);
        $j++;
    }

    if ($busca_e_servico == 'on') {
        $worksheet->write($i, $j, $l->servico, $styleleft);
        $j++;
    }

    if ($busca_e_estado == 'on') {
        $worksheet->write($i, $j, $l->certidao_estado, $styleleft);
        $j++;
    }

    if ($busca_e_cidade == 'on') {
        $worksheet->write($i, $j, $l->certidao_cidade, $styleleft);
        $j++;
    }

    if ($busca_e_atividade == 'on') {
        $worksheet->write($i, $j, $l->atividade, $styleleft);
        $j++;
    }

    if ($busca_e_status == 'on') {
        $worksheet->write($i, $j, $l->status, $styleleft);
        $j++;
    }
    if ($busca_e_agenda == 'on') {
        $worksheet->write($i, $j, invert($l->data_i, '/', 'PHP'), $stylecenter);
        $j++;
    }
    if ($busca_e_valor == 'on') {
        $worksheet->write($i, $j, $l->valor, $stylereal);
        $j++;
    }
    if ($busca_e_departamento == 'on') {
        $worksheet->write($i, $j, $l->departamento, $styleleft);
        $j++;
    }

    if ($busca_e_atendimento == 'on') {
        $worksheet->write($i, $j, $l->atendente, $styleleft);
        $j++;
    }

    if ($busca_e_responsavel == 'on') {
        $worksheet->write($i, $j, $l->responsavel, $styleleft);
        $j++;
    }

    $worksheet->write($i, $j, $l->certidao_resultado, $styleleft);
    $j++;

    if ($l->id_empresa_resp <> 0 and $l->id_empresa_resp == $controle_id_empresa) {
        $worksheet->write($i, $j, $vardir[$l->id_empresa_atend] , $styleleft);
        $j++;
        $worksheet->write($i, $j, '', $styleleft);
        $j++;
    } else {
        $worksheet->write($i, $j, '', $styleleft);
        $j++;
        if ($l->id_empresa_resp <> 0 and $l->id_empresa_resp != $controle_id_empresa)
            $worksheet->write($i, $j, $vardir[$l->id_empresa_resp] , $styleleft);
        else
            $worksheet->write($i, $j, '', $styleleft);
        $j++;
    }
}
$workbook->close();
?>