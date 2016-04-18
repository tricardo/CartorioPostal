<?php
require("includes.php");

$permissao = verifica_permissao('Direcionamento',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

if($_GET){
    if(isset($_SESSION['direcionamento']) AND count($_SESSION['direcionamento']) == 0){
        header('location:pagina-erro.php?erro=5');
        exit;
    }
    require("classes/spreadsheet_excel_writer/Writer.php");
    
    $c = Post_StdClass($_GET);
    $busca_exibicao = isset($c->busca_exibicao) ? 1 : 0;
    $busca_e_inicio = isset($c->busca_e_inicio) ? 1 : 0;
    $busca_e_prazo = isset($c->busca_e_prazo) ? 1 : 0;
    $busca_e_agenda = isset($c->busca_e_agenda) ? 1 : 0;
    $busca_e_data_atividade = isset($c->busca_e_data_atividade) ? 1 : 0;
    $busca_e_valor = isset($c->busca_e_valor) ? 1 : 0;
    $busca_e_departamento = isset($c->busca_e_departamento) ? 1 : 0;
    $busca_e_servico = isset($c->busca_e_servico) ? 1 : 0;
    $busca_e_cidade = isset($c->busca_e_cidade) ? 1 : 0;
    $busca_e_estado = isset($c->busca_e_estado) ? 1 : 0;
    $busca_e_status = isset($c->busca_e_status) ? 1 : 0;
    $busca_e_atividade = isset($c->busca_e_atividade) ? 1 : 0;
    $busca_e_responsavel = isset($c->busca_e_responsavel) ? 1 : 0;
    $busca_e_atendimento = isset($c->busca_e_atendimento) ? 1 : 0;
    $busca_id_servico    = isset($c->busca_e_servico) ? $c->busca_e_servico : 0; 
    $busca_e_devedor     = isset($c->busca_e_devedor) ? 1 : 0;
    $busca_e_conclu  = 1;

    $pedidoDAO = new PedidoDAO();
    $empresaDAO = new EmpresaDAO();
    $id_pedido = array();
    $id_pedido_item = array();
    $ordem = array();
    for($i = 0; $i < count($_SESSION['direcionamento']); $i++){
        $items = explode(';',$_SESSION['direcionamento'][$i]);
        $id_pedido_item[]= $items[0];
        $id_pedido[] = $items[1];
        $odem[] = $items[2];
    }

    $lista = $empresaDAO->listarTodas();
    foreach ($lista as $l) {
        $vardir[$l->id_empresa] = $l->fantasia;
    }
    
    $arquivo = "./exporta/".md5(date('YmdHis').$controle_id_usuario) . ".xls";
    $abas = array('Consulta de Pedidos Sistecart');
    $i = 0;
    
    $lista = $pedidoDAO->pedidoExporta($controle_id_empresa, implode(',',$id_pedido_item), $busca_exibicao);
    
    require('includes/excelstyle.php');
    $worksheet = & $workbook->addWorksheet(str_replace(' ', '_', $abas[$i]));
    
    $j = 0;
    $worksheet->write(0, $j, '#', $styletitulo3);
    $j++;
    if ($busca_e_inicio == 1) {
        $worksheet->write(0, $j, 'Abertura', $styletitulo3);
        $j++;
    }

    if ($busca_e_prazo == 1) {
        $worksheet->write(0, $j, 'Prazo', $styletitulo3);
        $j++;
    }

    if ($busca_e_conclu == 1) {
        $worksheet->write(0, $j, utf8_decode('Concluído Oper.'), $styletitulo3);
        $j++;
    }
    
    if ($busca_e_data_atividade == 1) {
        $worksheet->write(0, $j, 'Data Status', $styletitulo3);
        $j++;
    }
    
    $worksheet->write(0, $j, 'CPF', $styletitulo3);
    $j++;
    $worksheet->write(0, $j, 'CNPJ', $styletitulo3);
    $j++;
    $worksheet->write(0, $j, 'Documento de', $styletitulo3);
    $j++;
    if ($busca_id_servico == 17) {
        $worksheet->write(0, $j, 'Notificante', $styletitulo3);
        $j++;
    }

    if ($busca_e_devedor == 1) {
        $worksheet->write(0, $j, 'Devedor', $styletitulo3);
        $j++;
    }

    if ($busca_e_servico == 1) {
        $worksheet->write(0, $j, utf8_decode('Serviço'), $styletitulo3);
        $j++;
    }

    if ($busca_e_estado == 1) {
        $worksheet->write(0, $j, 'Estado', $styletitulo3);
        $j++;
    }

    if ($busca_e_cidade == 1) {
        $worksheet->write(0, $j, 'Cidade', $styletitulo3);
        $j++;
    }

    if ($busca_e_atividade == 1) {
        $worksheet->write(0, $j, 'Atividade', $styletitulo3);
        $j++;
    }

    if ($busca_e_status == 1) {
        $worksheet->write(0, $j, 'Status', $styletitulo3);
        $j++;
    }

    if ($busca_e_agenda == 1) {
        $worksheet->write(0, $j, 'Agenda', $styletitulo3);
        $j++;
    }

    if ($busca_e_valor == 1) {
        $worksheet->write(0, $j, 'Valor', $styletitulo3);
        $j++;
    }

    if ($busca_e_departamento == 1) {
        $worksheet->write(0, $j, 'Departamento', $styletitulo3);
        $j++;
    }

    if ($busca_e_atendimento == 1) {
        $worksheet->write(0, $j, 'Atendimento', $styletitulo3);
        $j++;
    }

    if ($busca_e_responsavel == 1) {
        $worksheet->write(0, $j, utf8_decode('Responsável'), $styletitulo3);
        $j++;
    }
    $worksheet->write(0, $j, 'Resultado', $styletitulo3);
    $j++;
    $worksheet->write(0, $j, 'Outra Franquia', $styletitulo3);
    $j++;
    $worksheet->write(0, $j, 'Direcionado Para', $styletitulo3);
    $j++;
    
    foreach ($lista as $l) {
    if ($l->id_empresa_atend != '') {
        $i++;
        $j = 0;
        $worksheet->write($i, $j, '#' . $l->id_pedido . '/' . $l->ordem, $styleleft);
        $j++;

        if ($busca_e_inicio == 1) {
            $worksheet->write($i, $j, invert($l->inicio, '/', 'php'), $stylecenter);
            $j++;
        }

        if ($busca_e_prazo == 1) {
            $worksheet->write($i, $j, invert($l->data_prazo, '/', 'php'), $stylecenter);
            $j++;
        }

        if ($busca_e_conclu == 1) {
            $worksheet->write($i, $j, invert($l->operacional, '/', 'php'), $stylecenter);
            $j++;
        }

        if ($busca_e_data_atividade == 1) {
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
        if ($busca_id_servico == 17) {
            $worksheet->write($i, $j, $l->certidao_requerente, $styleleft);
            $j++;
        }

        if ($busca_e_devedor == 1) {
            $worksheet->write($i, $j, $l->certidao_devedor, $styleleft);
            $j++;
        }

        if ($busca_e_servico == 1) {
            $worksheet->write($i, $j, $l->servico, $styleleft);
            $j++;
        }

        if ($busca_e_estado == 1) {
            $worksheet->write($i, $j, $l->certidao_estado, $styleleft);
            $j++;
        }

         if ($busca_e_cidade == 1) {
            $worksheet->write($i, $j, $l->certidao_cidade, $styleleft);
            $j++;
        }

        if ($busca_e_atividade == 1) {
            $worksheet->write($i, $j, $l->atividade, $styleleft);
            $j++;
        }

        if ($busca_e_status == 1) {
            $worksheet->write($i, $j, $l->status, $styleleft);
            $j++;
        }
        if ($busca_e_agenda == 1) {
            $worksheet->write($i, $j, invert($l->data_i, '/', 'PHP'), $stylecenter);
            $j++;
        }
        if ($busca_e_valor == 1) {
            $worksheet->write($i, $j, $l->valor, $stylereal);
            $j++;
        }
        if ($busca_e_departamento == 1) {
            $worksheet->write($i, $j, $l->departamento, $styleleft);
            $j++;
        }

        if ($busca_e_atendimento == 1) {
            $worksheet->write($i, $j, $l->atendente, $styleleft);
            $j++;
        }

        if ($busca_e_responsavel == 1) {
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
}
$workbook->close();
    exit;
}

header('location:pagina-erro.php');
exit;