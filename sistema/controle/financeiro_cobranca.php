<?
require('header.php');

$departamento_s = explode(',', $controle_id_departamento_s);
$departamento_p = explode(',', $controle_id_departamento_p);

$atividadeDAO = new AtividadeDAO();
$atividadeverificaDAO = new AtividadeVerificaDAO();
$pedidoDAO = new PedidoDAO();
$usuarioDAO = new UsuarioDAO();

$permissao = verifica_permissao('Financeiro Cobrança', $controle_id_departamento_p, $controle_id_departamento_s);

$usuarios = $usuarioDAO->listarAtivosDpto($controle_id_empresa, 19);

if ($permissao == 'FALSE') {
    echo '<div id="meio"><br><br><strong>Você não tem permissão para acessar essa página</strong></div>';
    exit;
}

pt_register('GET', 'busca_submit');
if ($busca_submit <> '') {
    pt_register('GET', 'busca_id_status');
    pt_register('GET', 'busca_autorizacao');
    pt_register('GET', 'busca_id_pedido');
    pt_register('GET', 'busca_id_usuario_cb');
    pt_register('GET', 'busca_ordenar');
    pt_register('GET', 'busca');
    pt_register('GET', 'busca_forma');
    pt_register('GET', 'busca_id_fatura');
    pt_register('GET', 'busca_ord');
    pt_register('GET', 'busca_e_cidade');
    pt_register('GET', 'busca_e_estado');
    pt_register('GET', 'busca_e_inicio');
    pt_register('GET', 'busca_e_prazo');
    pt_register('GET', 'busca_e_agenda');
    pt_register('GET', 'busca_e_data_atividade');
    pt_register('GET', 'busca_e_departamento');
    pt_register('GET', 'busca_e_servico');
    pt_register('GET', 'busca_e_status');
    pt_register('GET', 'busca_e_atividade');
    pt_register('GET', 'busca_e_responsavel');
    pt_register('GET', 'busca_e_atendimento');
    pt_register('GET', 'busca_e_devedor');
    pt_register('GET', 'busca_e_forma');
    pt_register('GET', 'busca_e_cpf');
    pt_register('GET', 'busca_e_valor');
    pt_register('GET', 'busca_e_nome');
    pt_register('GET', 'busca_mes');
    pt_register('GET', 'busca_ano');

    $_SESSION['f_busca_id_status'] = $busca_id_status;
    $_SESSION['f_busca_id_usuario_cb'] = $busca_id_usuario_cb;
    $_SESSION['f_busca_autorizacao'] = $busca_autorizacao;
    $_SESSION['f_busca_id_pedido'] = $busca_id_pedido;
    $_SESSION['f_busca_ordenar'] = $busca_ordenar;
    $_SESSION['f_busca_ord'] = $busca_ord;
    $_SESSION['f_busca'] = $busca;

    setcookie("f_busca_e_inicio", $busca_e_inicio);
    setcookie("f_busca_e_prazo", $busca_e_prazo);
    setcookie("f_busca_e_agenda", $busca_e_agenda);
    setcookie("f_busca_e_data_atividade", $busca_e_data_atividade);
    setcookie("f_busca_e_forma", $busca_e_forma);
    setcookie("f_busca_e_departamento", $busca_e_departamento);
    setcookie("f_busca_e_servico", $busca_e_servico);
    setcookie("f_busca_e_status", $busca_e_status);
    setcookie("f_busca_e_atividade", $busca_e_atividade);
    setcookie("f_busca_e_responsavel", $busca_e_responsavel);
    setcookie("f_busca_e_atendimento", $busca_e_atendimento);
    setcookie("f_busca_e_cpf", $busca_e_cpf);
    setcookie("f_busca_e_valor", $busca_e_valor);
    setcookie("f_busca_e_nome", $busca_e_nome);
    setcookie("f_busca_e_cidade", $busca_e_cidade);
    setcookie("f_busca_e_estado", $busca_e_estado);
    setcookie("f_busca_mes", $busca_mes);
    setcookie("f_busca_ano", $busca_ano);
} else {

    $busca_id_status = $_SESSION['f_busca_id_status'];
    $busca_autorizacao = $_SESSION['f_busca_autorizacao'];
    $busca_id_pedido = $_SESSION['f_busca_id_pedido'];
    $busca_id_usuario_cb = $_SESSION['f_busca_id_usuario_cb'];
    $busca_ordenar = $_SESSION['f_busca_ordenar'];
    $busca = $_SESSION['f_busca'];
    $busca_e_inicio = $_COOKIE['f_busca_e_inicio'];
    $busca_e_prazo = $_COOKIE['f_busca_e_prazo'];
    $busca_e_agenda = $_COOKIE['f_busca_e_agenda'];
    $busca_e_data_atividade = $_COOKIE['f_busca_e_data_atividade'];
    $busca_e_forma = $_COOKIE['f_busca_e_forma'];
    $busca_e_departamento = $_COOKIE['f_busca_e_departamento'];
    $busca_e_servico = $_COOKIE['f_busca_e_servico'];
    $busca_e_status = $_COOKIE['f_busca_e_status'];
    $busca_e_atividade = $_COOKIE['f_busca_e_atividade'];
    $busca_e_responsavel = $_COOKIE['f_busca_e_responsavel'];
    $busca_e_atendimento = $_COOKIE['f_busca_e_atendimento'];
    $busca_e_devedor = $_COOKIE['f_busca_e_devedor'];
    $busca_e_cpf = $_COOKIE['f_busca_e_cpf'];
    $busca_e_valor = $_COOKIE['f_busca_e_valor'];
    $busca_e_nome = $_COOKIE['f_busca_e_nome'];
    $busca_e_cidade = $_COOKIE['f_busca_e_cidade'];
    $busca_e_estado = $_COOKIE['f_busca_e_estado'];
}

if ($busca_e_prazo <> '')
    $busca_e_prazo = ''; else
    $busca_e_prazo = 'on';
if ($busca_e_inicio <> '')
    $busca_e_inicio = ''; else
    $busca_e_inicio = 'on';
if ($busca_e_agenda <> '')
    $busca_e_agenda = ''; else
    $busca_e_agenda = 'on';
if ($busca_e_data_atividade <> '')
    $busca_e_data_atividade = ''; else
    $busca_e_data_atividade = 'on';
if ($busca_e_departamento <> '')
    $busca_e_departamento = ''; else
    $busca_e_departamento = 'on';
if ($busca_e_servico <> '')
    $busca_e_servico = ''; else
    $busca_e_servico = 'on';
if ($busca_e_status <> '')
    $busca_e_status = ''; else
    $busca_e_status = 'on';
if ($busca_e_atividade <> '')
    $busca_e_atividade = ''; else
    $busca_e_atividade = 'on';
if ($busca_e_responsavel <> '')
    $busca_e_responsavel = ''; else
    $busca_e_responsavel = 'on';
if ($busca_e_atendimento <> '')
    $busca_e_atendimento = ''; else
    $busca_e_atendimento = 'on';
if ($busca_e_devedor <> '')
    $busca_e_devedor = ''; else
    $busca_e_devedor = 'on';
if ($busca_e_cpf <> '')
    $busca_e_cpf = ''; else
    $busca_e_cpf = 'on';
if ($busca_e_valor <> '')
    $busca_e_valor = ''; else
    $busca_e_valor = 'on';
if ($busca_e_nome <> '')
    $busca_e_nome = ''; else
    $busca_e_nome = 'on';
if ($busca_e_forma <> '')
    $busca_e_forma = ''; else
    $busca_e_forma = 'on';
if ($busca_e_cidade <> '')
    $busca_e_cidade = ''; else
    $busca_e_cidade = 'on';
if ($busca_e_estado <> '')
    $busca_e_estado = ''; else
    $busca_e_estado = 'on';

if ($busca_ord == 'Decr')
    $busca_ordenar_por_o.= ' DESC ';
$busca_ordenar_por = ' pi.id_pedido ' . $busca_ordenar_por_o . ', pi.ordem ' . $busca_ordenar_por_o;
if ($busca_ordenar == 'Documento de')
    $busca_ordenar_por = ' pi.certidao_nome ' . $busca_ordenar_por_o; else
if ($busca_ordenar == 'Serviço')
    $busca_ordenar_por = ' pi.id_servico ' . $busca_ordenar_por_o; else
if ($busca_ordenar == 'Ordem')
    $busca_ordenar_por = ' pi.id_pedido, pi.ordem ' . $busca_ordenar_por_o; else
if ($busca_ordenar == 'Data')
    $busca_ordenar_por = ' pi.data ' . $busca_ordenar_por_o; else
if ($busca_ordenar == 'Cidade')
    $busca_ordenar_por = ' pi.certidao_estado ' . $busca_ordenar_por_o . ', pi.certidao_cidade ' . $busca_ordenar_por_o; else
if ($busca_ordenar == 'Estado')
    $busca_ordenar_por = ' pi.certidao_estado ' . $busca_ordenar_por_o; else
if ($busca_ordenar == 'Departamento')
    $busca_ordenar_por = ' pi.id_servico_departamento ' . $busca_ordenar_por_o; else
if ($busca_ordenar == 'Fatura')
    $busca_ordenar_por = ' pi.id_fatura ' . $busca_ordenar_por_o; else
if ($busca_ordenar == 'Prazo')
    $busca_ordenar_por = $data_prazo_inc . $busca_ordenar_por_o; else
if ($busca_ordenar == 'Data Status')
    $busca_ordenar_por = ' pi.data_atividade ' . $busca_ordenar_por_o; else
if ($busca_ordenar == 'Agenda')
    $busca_ordenar_por = ' pi.data_i ' . $busca_ordenar_por_o . ', pi.status_hora ' . $busca_ordenar_por_o;
if ($busca_ordenar == 'Devedor')
    $busca_ordenar_por = ' pi.certidao_devedor ' . $busca_ordenar_por_o . ', pi.certidao_nome ' . $busca_ordenar_por_o;

$onde = '';
if ($busca_autorizacao == '')
    $busca_autorizacao = 'À Receber';
if ($busca_id_status != '20' and $busca_id_status != '11')
    $busca_id_status = '20';
#if($busca_id_status=='Todos') $busca_id_status='';
if ($busca_id_status <> '') {
    $onde .= " and pi.id_status='" . $busca_id_status . "'";
}
if ($busca <> '') {
    $onde .= " and (p.nome like '%" . $busca . "%' or pi.certidao_devedor = '" . $busca . "' or pi.certidao_nome like '" . $busca . "%' or pi.certidao_pai like '" . $busca . "%' or pi.certidao_mae like '" . $busca . "%' or pi.certidao_esposa like '" . $busca . "%' or pi.certidao_marido like '" . $busca . "%' or replace(replace(replace(pi.certidao_cpf,'.',''),'-',''),'/','') = replace(replace(replace('" . $busca . "','.',''),'-',''),'/','') or replace(replace(replace(pi.certidao_cnpj,'.',''),'-',''),'/','') = replace(replace(replace('" . $busca . "','.',''),'-',''),'/','') or replace(replace(replace(p.cpf,'.',''),'-',''),'/','') = replace(replace(replace('" . $busca . "','.',''),'-',''),'/','')) ";
}
if ($busca_id_pedido <> '')
    $onde .= " and pi.id_pedido= '" . $busca_id_pedido . "' ";
if ($busca_id_fatura <> '')
    $onde .= " and pi.id_fatura= '" . $busca_id_fatura . "' ";
if ($busca_id_usuario_cb <> '' and $busca_id_usuario_cb != '_')
    $onde .= " and p.id_usuario_cb= '" . $busca_id_usuario_cb . "' ";
if ($busca_id_usuario_cb == '_')
    $onde .= " and p.id_usuario_cb is NULL ";
?>

<div id="topo">
    <img src="../images/tit/tit_recebimento.png" alt="Título" />Cobrança &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
    <a href="#" class="topo">topo</a> <br />
    <hr class="tit" />
</div>
<div id="meio">
    <?php
    pt_register('POST', 'submit_direciona');
    if ($submit_direciona) { //check for errors
        $errors = 0;
        $error = "<b>Ocorreram os seguintes erros:</b><ul>";
        pt_register('POST', 'id_usuario');
        $p_id_pedido_item = explode(',', $_COOKIE["p_id_pedido_item"]);
        foreach ($p_id_pedido_item as $id_pedido_item) {
            $cont_seg++;
            $pedidoItem = $pedidoDAO->buscaPorId($id_pedido_item, $controle_id_empresa);
            if ($pedidoItem != null and ($pedidoItem->id_status == '20' || $pedidoItem->id_status == '11') and $id_usuario <> '' and $pedidoItem->id_pedido) {
                $pedidoDAO->direcionaUserCobranca($pedidoItem->id_pedido, $id_usuario);
            }
        }

        unset($_COOKIE['p_id_pedido_item']);
        unset($_COOKIE['p_id_pedido']);
        echo "
	<script>
		eraseCookie('p_id_pedido_item');
		eraseCookie('p_id_pedido');
	</script>
	";
    }

    pt_register('POST', 'submit');
    pt_register('POST', 'submit_status');
    if ($submit <> '') {
        $dias = 0;
        switch ($submit) {
            case 'Acompanhar':
                $id_atividade = 120;
                $dias = 3;
                break;
            case 'Notificar':
                $id_atividade = 214;
                break;
            case 'Notificado':
                $id_atividade = 215;
                $dias = 12;
                break;
            case 'Apoio Jurídico':
                $id_atividade = 216;
                break;
            case 'Efetuado':
                $id_atividade = 119;
                $id_status = 10;
                break;
        }

        setcookie("atividade_id_pedido_item", $_COOKIE['p_id_pedido_item']);
        setcookie("atividade_id_pedido", $_COOKIE['p_id_pedido']);

        $ext = explode(',', $_COOKIE['p_id_pedido']);
        $ext_num = count($ext) - 1;
        $atividadeDAO = new AtividadeDAO();
        $atividade = $atividadeDAO->selecionaPorID($id_atividade);
        $p_id_pedido_item = explode(',', str_replace(',##', '', $_COOKIE['p_id_pedido_item'] . '##'));
        ?>
        <form enctype="multipart/form-data" method="post" name="pedido_add">
            <input type="hidden" name="id_atividade" value="<?php echo $id_atividade ?>" />
            <input type="hidden" name="id_status" value="<?php echo $id_status ?>" />
            <input type="hidden" name="dias" value="<?php echo $dias ?>" />
            <table width="100%" cellpadding="4" cellspacing="1" class="result_tabela">
                <tr>
                    <td colspan="4" class="tabela_tit">Nova Atividade</td>
                </tr>
                <tr>
                    <td width="150" valign="top">
                        <div align="right"><strong>Referente as ordens: </strong></div>
                    </td>
                    <td width="532" colspan="3"><?= str_replace(',', ' - ', $_COOKIE['p_id_pedido']); ?>
                        <br>
                        <br>
                        <b>Foram selecionados <?= $ext_num ?> pedidos.</b></td>
                </tr>
                <tr>
                    <td width="150" valign="top" align="right"><strong>Atividade:</strong></td>
                    <td><?php echo $atividade->atividade; ?></td>
                </tr>
                <tr>
                    <td width="150" valign="top">
                        <div align="right"><strong>Obs: </strong></div>
                    </td>
                    <td width="532" colspan="3">
                        <textarea name="status_obs" class="form_estilo" style="width: 493px; height: 100px"></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div align="center">
                            <input type="submit" name="submit_status" value=" Enviar " class="button_busca" />&nbsp; 
                            <input type="submit" name="cancelar" value="Cancelar" onclick="document.pedido_add.action='financeiro_cobranca.php'" class="button_busca" />
                        </div>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <?php
} else if ($submit_status) {
    pt_register('POST', 'dias');
    pt_register('POST', 'status_obs');
    pt_register('POST', 'id_atividade');
    pt_register('POST', 'id_status');
    setcookie("rec_id_pedido_item", $_COOKIE['p_id_pedido_item']);
    setcookie("rec_id_pedido", $_COOKIE['p_id_pedido']);
    $p_id_pedido_item = explode(',', str_replace(',##', '', $_COOKIE['p_id_pedido_item'] . '##'));
    $atividadeDAO = new AtividadeDAO();
    #verifica permissão
    foreach ($p_id_pedido_item as $chave => $id_pedido_item) {
        $errors = '';
        $error = '';
        $valida = valida_numero($id_pedido_item);
        if ($valida != 'TRUE') {
            echo 'Ocorreu um erro ao validar o número dos pedido(s) selecionado(s). O número de um dos pedidos não é válido';
        }
        if ($id_atividade != 119)
            $p_verifica = $atividadeverificaDAO->AtividadeVerifica($controle_id_empresa, $id_atividade, '', $departamento_p, $departamento_s, $id_pedido_item);
        if ($p_verifica['error'] == '') {
            $pe = $pedidoDAO->selectPedidoItemPorId($id_pedido_item);

            if ($id_atividade == 120 && $pe->id_status == 11)
                $dias = 10;

            $atividadeDAO->inserir($id_atividade, $status_obs, $controle_id_usuario, $id_pedido_item, $dias);
            $p->id_atividade = $id_atividade;
            $p->id_status = $id_status;
            $p->id_pedido_item = $id_pedido_item;
            $p->dias = $dias;
            $p->data_atividade = date("Y-m-d H:i:s");
            $pedidoDAO->atualizaPedidoItemStatus($p);
        }else {
            echo '<ul class="erro"><li><b></li> ' . $p_verifica['error'] . '</ul><br>';
        }
    }
}

if (!$submit) {
    ?>
    <form name="buscador" action="" method="get"  ENCTYPE="multipart/form-data">
        <div style="float: left; width: 300px; text-align: right">
            <label style="width: 90px; font-weight: bold; padding-top: 5px; float: left">Buscar:
            </label> 
            <input type="text" class="form_estilo" name="busca" value="<?= $busca ?>" style="width: 200px; float: left" /><br />
            <label style="width: 90px; font-weight: bold; padding-top: 5px; float: left">Fatura:
            </label> 
            <input type="text" class="form_estilo" name="busca_id_fatura" value="<?= $busca_id_fatura ?>" style="width: 200px; float: left" /><br />
            <label style="width: 90px; font-weight: bold; padding-top: 5px; float: left">
                Situacao: </label> 
            <select name="busca_autorizacao" style="width: 200px; float: left" class="form_estilo">
                <option value="À Receber" <?php if ($busca_autorizacao == '' or $busca_autorizacao == 'À Receber')
                    echo 'selected="select"'; ?>>À Receber</option>
                <option value="Em Acompanhamento" <?php if ($busca_autorizacao == 'Em Acompanhamento')
                    echo 'selected="select"'; ?>>Em Acompanhamento</option>
                <option value="Notificar" <?php if ($busca_autorizacao == 'Notificar')
                    echo 'selected="select"'; ?>>Notificar</option>
                <option value="Notificado" <?php if ($busca_autorizacao == 'Notificado')
                    echo 'selected="select"'; ?>>Notificado</option>
                <option value="Recebido" <?php if ($busca_autorizacao == 'Recebido')
                    echo 'selected="select"'; ?>>Recebido</option>
            </select> <br />
            <label style="width: 90px; font-weight: bold; padding-top: 5px; float: left">Status:
            </label> 
            <select name="busca_id_status" style="width: 200px; float: left" class="form_estilo">
                <option value="20" <?php if ($busca_id_status == '20')
                    echo 'selected="selected"' ?>>Inadimplente</option>
                <option value="11"
                <?php if ($busca_id_status == '11')
                    echo 'selected="selected"' ?>>Confirmação</option>
            </select> <br />
            <label
                style="width: 90px; font-weight: bold; padding-top: 5px; float: left; text-align: right">Responsável:
            </label> <select name="busca_id_usuario_cb"
                             style="width: 200px; float: left" class="form_estilo">
                <option value="_"
                <? if ($busca_id_usuario_cb == '_')
                    echo ' selected="selected" '; ?>>Não
                    Direcionados</option>
                <option value=""
                <? if ($busca_id_usuario_cb == '')
                    echo ' selected="selected" '; ?>>Todos</option>
                        <?php
                        $p_valor = '';
                        foreach ($usuarios as $u) {
                            $p_valor .= '<option value="' . $u->id_usuario . '"';
                            if ($busca_id_usuario_cb == $u->id_usuario)
                                $p_valor .= ' selected="selected" ';
                            $p_valor .= ' >' . $u->nome . '</option>';
                        }
                        echo $p_valor;
                        ?>
            </select> <br />
            <label style="width: 90px; font-weight: bold; padding-top: 5px; float: left; text-align: right">Data:
            </label> 
            <select name="busca_mes" style="width: 100px; float: left" class="form_estilo">
                <option value="">Todos</option>
                <option <?php echo ($busca_mes == 1) ? 'selected="selected"' : ''; ?>
                    value="1">Janeiro</option>
                <option <?php echo ($busca_mes == 2) ? 'selected="selected"' : ''; ?>
                    value="2">Fevereiro</option>
                <option <?php echo ($busca_mes == 3) ? 'selected="selected"' : ''; ?>
                    value="3">Março</option>
                <option <?php echo ($busca_mes == 4) ? 'selected="selected"' : ''; ?>
                    value="4">Abril</option>
                <option <?php echo ($busca_mes == 5) ? 'selected="selected"' : ''; ?>
                    value="5">Maio</option>
                <option <?php echo ($busca_mes == 6) ? 'selected="selected"' : ''; ?>
                    value="6">Junho</option>
                <option <?php echo ($busca_mes == 7) ? 'selected="selected"' : ''; ?>
                    value="7">Julho</option>
                <option <?php echo ($busca_mes == 8) ? 'selected="selected"' : ''; ?>
                    value="8">Agosto</option>
                <option <?php echo ($busca_mes == 9) ? 'selected="selected"' : ''; ?>
                    value="9">Setembro</option>
                <option <?php echo ($busca_mes == 10) ? 'selected="selected"' : ''; ?>
                    value="10">Outubro</option>
                <option <?php echo ($busca_mes == 11) ? 'selected="selected"' : ''; ?>
                    value="11">Novembro</option>
                <option <?php echo ($busca_mes == 12) ? 'selected="selected"' : ''; ?>
                    value="12">Dezembro</option>
            </select> <select name="busca_ano" style="width: 50px; float: left"
                              class="form_estilo">
                <option value="">Todos</option>
                <option <?php echo ($busca_ano == 2009) ? 'selected="selected"' : ''; ?>
                    value="2009">2009</option>
                <option <?php echo ($busca_ano == 2010) ? 'selected="selected"' : ''; ?>
                    value="2010">2010</option>
            </select> <label
                style="width: 90px; font-weight: bold; padding-top: 5px; float: left">Ordem:
            </label> <input type="text" name="busca_id_pedido"
                            value="<?php echo $busca_id_pedido ?>"
                            style="width: 200px; float: left;" class="form_estilo" /> <br />
            <label
                style="width: 90px; font-weight: bold; padding-top: 5px; float: left">Ordenar
                Por: </label> <select name="busca_ordenar"
                                  style="width: 150px; float: left" class="form_estilo">
                <option value=""
                <? if ($busca_ordenar == '')
                    echo ' selected="selected" '; ?>></option>
                <option value="Ordem"
                <? if ($busca_ordenar == 'Ordem')
                    echo ' selected="selected" '; ?>>Ordem</option>
                <option value="Documento de"
                <? if ($busca_ordenar == 'Documento de')
                    echo ' selected="selected" '; ?>>Documento
                    de</option>
                <option value="Devedor"
                <? if ($busca_ordenar == 'Devedor')
                    echo ' selected="selected" '; ?>>Devedor</option>
                <option value="Data"
                <? if ($busca_ordenar == 'Data')
                    echo ' selected="selected" '; ?>>Data</option>
                <option value="Departamento"
                <? if ($busca_ordenar == 'Departamento')
                    echo ' selected="selected" '; ?>>Departamento</option>
                <option value="Serviço"
                <? if ($busca_ordenar == 'Serviço')
                    echo ' selected="selected" '; ?>>Serviço</option>
                <option value="Cidade"
                <? if ($busca_ordenar == 'Cidade')
                    echo ' selected="selected" '; ?>>Cidade</option>
                <option value="Prazo"
                <? if ($busca_ordenar == 'Prazo')
                    echo ' selected="selected" '; ?>>Prazo</option>
                <option value="Agenda"
                <? if ($busca_ordenar == 'Agenda')
                    echo ' selected="selected" '; ?>>Agenda</option>
                <option value="Fatura"
                <? if ($busca_ordenar == 'Fatura')
                    echo ' selected="selected" '; ?>>Fatura</option>					
                <option value="Data Status"
                <? if ($busca_ordenar == 'Data Status')
                    echo ' selected="selected" '; ?>>Data
                    Status</option>
            </select> <select name="busca_ord"
                              style="width: 50px; padding-top: 5px; float: left" class="form_estilo">
                <option value="" <? if ($busca_ord == '')
                        echo ' selected="selected" '; ?>>Cres</option>
                <option value="Decr"
                <? if ($busca_ord == 'Decr')
                    echo ' selected="selected" '; ?>>Decr</option>
            </select> <br />
            <input type="submit" name="busca_submit" style="clear: left"
                   class="button_busca" value=" Buscar " /></div>
        <div style="float: left; width: 150px; text-align: right"><b><a href="#"
                                                                        onclick="if(document.getElementById('selecionar_campos').style.visibility=='hidden') document.getElementById('selecionar_campos').style.visibility='visible'; else document.getElementById('selecionar_campos').style.visibility='hidden';">Selecionar
                    colunas</a></b><br>
            <div
                style="width: 150px; float: left; text-align: left; height: 140px; visibility: hidden; overflow: scroll"
                class="form_estilo" id="selecionar_campos"><input type="checkbox"
                                                              name="busca_e_nome" <? if ($busca_e_nome == '')
                        echo 'checked' ?> />Documento
                de <br>
                <input type="checkbox" name="busca_e_cpf"
                <? if ($busca_e_cpf == '')
                    echo 'checked' ?> />CPF/CNPJ <br>
                <input type="checkbox" name="busca_e_inicio"
                <? if ($busca_e_inicio == '')
                    echo 'checked' ?> />Início <br>
                <input type="checkbox" name="busca_e_prazo"
                <? if ($busca_e_prazo == '')
                    echo 'checked' ?> />Prazo <br>
                <input type="checkbox" name="busca_e_agenda"
                <? if ($busca_e_agenda == '')
                    echo 'checked' ?> />Agenda <br>
                <input type="checkbox" name="busca_e_data_atividade"
                <? if ($busca_e_data_atividade == '')
                    echo 'checked' ?> />Data do Status <br>
                <input type="checkbox" name="busca_e_departamento"
                <? if ($busca_e_departamento == '')
                    echo 'checked' ?> />Departamento <br>
                <input type="checkbox" name="busca_e_servico"
                <? if ($busca_e_servico == '')
                    echo 'checked' ?> />Serviço <br>
                <input type="checkbox" name="busca_e_cidade"
                <? if ($busca_e_cidade == '')
                    echo 'checked' ?> />Cidade <br>
                <input type="checkbox" name="busca_e_estado"
                <? if ($busca_e_estado == '')
                    echo 'checked' ?> />Estado <br>
                <input type="checkbox" name="busca_e_status"
                <? if ($busca_e_status == '')
                    echo 'checked' ?> />Status <br>
                <input type="checkbox" name="busca_e_atividade"
                <? if ($busca_e_atividade == '')
                    echo 'checked' ?> />Atividade <br>
                <input type="checkbox" name="busca_e_responsavel"
                <? if ($busca_e_responsavel == '')
                    echo 'checked' ?> />Responsável <br>
                <input type="checkbox" name="busca_e_atendimento"
                <? if ($busca_e_atendimento == '')
                    echo 'checked' ?> />Atendimento <br>
                <input type="checkbox" name="busca_e_devedor"
                <? if ($busca_e_devedor == '')
                    echo 'checked' ?> />Devedor <br>
                <input type="checkbox" name="busca_e_forma"
                <? if ($busca_e_forma == '')
                    echo 'checked' ?> />Forma de Pagamento</div>
        </div>
    </form>
    <? if (in_array('19', $departamento_s) == 1) { ?>
        <form name="direciona" action="" method="post" ENCTYPE="multipart/form-data">
            <div style="float: left; width: 150px; margin-left: 20px">
                <label style="width: 100px; font-weight: bold; padding-top: 5px; float: left">
                    Direcionar para: </label> 
                <select name="id_usuario" style="width: 200px; float: left;" class="form_estilo">
                    <option value=""></option>
                    <?php
                    $p_valor = '';
                    foreach ($usuarios as $us) {
                        $p_valor .= '<option value="' . $us->id_usuario . '"';
                        $p_valor.= ' >' . $us->nome . '</option>';
                    }
                    echo $p_valor;
                    ?>
                </select> <input type="submit" name="submit_direciona" class="button_busca" value=" Direcionar " /></div>
        </form>
    <? } ?>
    <br />
    <form name="f1" action="" method="post" ENCTYPE="multipart/form-data">

        <div style="clear: both; padding: 5px"><?php if ($busca_autorizacao == 'À Receber') { ?>
                <input type="submit" name="submit" class="button_busca"
                       value="Acompanhar" />&nbsp; <?php } if ($busca_id_status == '20' && $busca_autorizacao == 'Em Acompanhamento') { ?>
                <input type="submit" name="submit" class="button_busca"
                       value="Notificar" />&nbsp; <?php } elseif ($busca_autorizacao == 'Notificar') { ?>
                <input type="submit" name="submit" class="button_busca"
                       value="Notificado" />&nbsp; <?php } elseif ($busca_autorizacao == 'Recebido') { ?>
                <input type="submit" name="submit" class="button_busca" value="Efetuado" />&nbsp;
            <?php } elseif ($busca_autorizacao == 'Notificado') { ?> <input
                    type="submit" name="submit" class="button_busca"
                    value="Apoio Jurídico" />&nbsp; <?php } ?> <!--  <input type="submit" name="submit_acao" onclick="document.f1.target='_self'; document.f1.action='pedido.php'" class="button_busca" value=" Alterar Status " />&nbsp; -->
        </div>
        <?php
        #recebido ou a receber
        $onde_status = " pi.id_atividade != 120 and pi.id_atividade != 214 and pi.id_atividade != '215' and pi.id_atividade != '216'";
        if ($busca_autorizacao == 'À Receber')
            $tipo_busca = " (pi.valor_rec < pi.valor or pi.valor_rec IS NULL) ";
        else if ($busca_autorizacao == 'Recebido') {
            $tipo_busca = "	pi.valor_rec >= pi.valor";
            $onde_status = " 1=1 ";
        } else if ($busca_autorizacao == 'Em Acompanhamento') {
            $tipo_busca = " (pi.valor_rec < pi.valor or pi.valor_rec IS NULL) ";
            $onde_status = " pi.id_atividade = '120'";
        } else if ($busca_autorizacao == 'Notificar') {
            $tipo_busca = " (pi.valor_rec < pi.valor or pi.valor_rec IS NULL) ";
            $onde_status = " pi.id_atividade = '214' ";
        } else if ($busca_autorizacao == 'Notificado') {
            $tipo_busca = " (pi.valor_rec < pi.valor or pi.valor_rec IS NULL) ";
            $onde_status = " pi.id_atividade = '215' ";
        }

        if ($busca_mes != '' || $busca_ano != '') {
            if ($busca_mes == '') {
                $busca_mes_ini = '01';
                $busca_mes_fim = '12';
            } else {
                $busca_mes_ini = $busca_mes;
                $busca_mes_fim = $busca_mes;
            }
            if ($busca_ano == '')
                $busca_ano = date('Y');
            $onde_status .= " and ( pi.data >= '$busca_ano-$busca_mes_ini-01 00:00:00' and pi.data <= '$busca_ano-$busca_mes_fim-31 23:59:59' ) ";
        }
        $onde_status .= " and pi.id_status != '14' ";
        $condicao = " from vsites_pedido as p, vsites_pedido_item as pi
		 WHERE
						pi.id_empresa_atend = '" . $controle_id_empresa . "' and
						pi.id_pedido=p.id_pedido and
						" . $onde_status . "
						 " . $onde . " and " . $tipo_busca . " 
						order by " . $busca_ordenar_por;
        $campo = "pi.id_fatura, pi.valor_rec as total, pi.certidao_estado, pi.certidao_cidade, pi.certidao_devedor, pi.data_prazo, pi.inicio, p.nome, p.cpf, pi.data_atividade, p.data, pi.id_pedido_item, pi.id_pedido, pi.data_i, pi.ordem, pi.id_usuario_op, pi.certidao_nome, pi.valor, pi.dias, pi.status_hora, pi.id_atividade, pi.notificada ";
        pt_register('GET', 'pagina');

        if ($pagina == '') {
            echo "
	<script>
		eraseCookie('p_id_pedido_item');
		eraseCookie('p_id_pedido');
	</script>
	";
            unset($_COOKIE['p_id_pedido_item']);
            unset($_COOKIE['p_id_pedido']);
        }

        $url_busca = $_SERVER['REQUEST_URI'];
        $url_busca_pos = strpos($_SERVER['REQUEST_URI'], '.php');
        $url_busca = substr(str_replace('pagina=' . $pagina . '&', '', $url_busca), $url_busca_pos + 5);

        $query = $objQuery->paginacao($campo, $condicao, $pagina, $url_busca);
        $_SESSION['pedido_campo'] = $campo;
        $_SESSION['pedido_condicao'] = $condicao;
        $cont = 0;
        ?>
        <table width="100%" cellpadding="4" cellspacing="1"
               class="result_tabela">
            <tr>
                <td colspan="18" class="barra_busca"><?php $objQuery->QTDPagina(); ?>
                </td>
            </tr>
            <?php
            $p_valor = '
	<tr>
		<td align="center" width="20" class="result_menu"><input type="checkbox" name="todos" onclick="if(this.checked==1) { selecionar_tudo_cache(\'p_id_pedido_item\'); selecionar_tudo(); } else { deselecionar_tudo_cache(\'p_id_pedido_item\'); deselecionar_tudo(); }"></td>
		<td align="center" width="60" class="result_menu"><b>Editar</b></td>
		<td align="center" width="50" class="result_menu"><b>Ordem</b></td>
		<td class="result_menu"><b>Solicitante</b></td>
		<td class="result_menu"><b>Fatura</b></td>
		';

            if ($busca_e_cpf == '')
                $p_valor .= '<td class="result_menu"><b>CNPJ/CPF</b></td>';
            if ($busca_e_nome == '')
                $p_valor .= '<td class="result_menu"><b>Documento de</b></td>';
            if ($busca_e_devedor == '')
                $p_valor .= '<td class="result_menu"><b>Devedor</b></td>';
            if ($busca_e_inicio == '')
                $p_valor .= '<td align="center" width="50" class="result_menu"><b>Início</b></td>';
            if ($busca_e_prazo == '')
                $p_valor .= '<td align="center" width="50" class="result_menu"><b>Prazo</b></td>';
            if ($busca_e_agenda == '')
                $p_valor .= '<td align="center" width="50" class="result_menu"><b>Agenda</b></td>';
            if ($busca_e_data_atividade == '')
                $p_valor .= '<td align="center" width="50" class="result_menu"><b>Data Status</b></td>';
            if ($busca_e_forma == '')
                $p_valor .= '<td align="center" width="50" class="result_menu"><b>Forma</b></td>';
            $p_valor .= '
		<td align="center" width="50" class="result_menu"><b>Agenda</b></td>
		<td align="center" width="50" class="result_menu"><b>Valor</b></td>
		<td align="center" width="50" class="result_menu"><b>Recebido</b></td>
		';

            if ($busca_e_departamento == '')
                $p_valor .= '<td align="center" width="80" class="result_menu"><b>Departamento</b></td>';
            if ($busca_e_servico == '')
                $p_valor .= '<td align="center" width="80" class="result_menu"><b>Serviço</b></td>';
            if ($busca_e_atividade == '')
                $p_valor .= '<td align="center" width="80" class="result_menu"><b>Atividade</b></td>';
            if ($busca_e_cidade == '')
                $p_valor .= '<td align="center" width="80" class="result_menu"><b>Cidade</b></td>';
            if ($busca_e_estado == '')
                $p_valor .= '<td align="center" width="40" class="result_menu"><b>UF</b></td>';
            if ($busca_e_status == '')
                $p_valor .= '<td align="center" width="80" class="result_menu"><b>Status</b></td>';
            if ($busca_e_responsavel == '')
                $p_valor .= '<td align="center" width="80" class="result_menu"><b>Responsável</b></td>';
            if ($busca_e_atendimento == '')
                $p_valor .= '<td align="center" width="80" class="result_menu"><b>Atendimento</b></td>';
            $p_valor .= '</tr>';

            $p_id_pedido_item = explode(',', $_COOKIE["p_id_pedido_item"]);

            while ($res = mysql_fetch_array($query)) {
                $cont++;
                $id_pedido_item = $res["id_pedido_item"];
                $atendente = $res["atendente"];
                $id_usuario_op = $res["id_usuario_op"];
                $departamento = $res["departamento"];
                $data_prazo = invert($res["data_prazo"], '/', 'PHP');
                $data_agenda = date("d/m/Y", strtotime(somar_dias_uteis($res["data_i"], $res["dias"])));
                $valor = $res["valor"];
                $financeiro_valor = $res['total'];
                $responsavel = $res['nome_resp'];
                $valor = number_format($valor, 2, ".", "");
                $financeiro_valor = number_format($financeiro_valor, 2, ".", "");
                $valor_total = (float) ($valor_total) + (float) ($valor);
                $financeiro_valor_total = (float) ($financeiro_valor_total) + (float) ($financeiro_valor);
                $valor = 'R$ ' . $valor;
                $financeiro_valor_num = $financeiro_valor;
                $financeiro_valor = 'R$ ' . $financeiro_valor;
                if (in_array($res["id_pedido_item"], $p_id_pedido_item) == 1)
                    $item_checked = ' checked '; else
                    $item_checked = '';
                $class = $res['notificada'] ? 'result_celula_erro' : '';
                $p_valor .= '<tr >
		<td class="result_celula" align="center" nowrap style="background-color: ' . $class . ';">
			<input type="hidden" name="acao_' . $cont . '" value="' . $res["id_pedido_item"] . '"/>
			<input type="hidden" name="acao_pedido_' . $cont . '" value="' . $res["id_pedido"] . '/' . $res["ordem"] . '"/>
			<input type="checkbox" name="acao_sel_' . $cont . '" value="' . $res["id_pedido_item"] . '" onclick="if(this.checked==true) { createCookie(\'p_id_pedido_item\',\'' . $res["id_pedido_item"] . ',\',\'1\',\'1\'); createCookie(\'p_id_pedido\',\'#' . $res["id_pedido"] . '/' . $res["ordem"] . ',\',\'1\',\'1\'); createCookie(\'p_rec\',\'' . $financeiro_valor_num . ',\',\'1\',\'1\'); } else {eraseCookieItem(\'p_id_pedido_item\',\'' . $res["id_pedido_item"] . '\'); eraseCookieItem(\'p_id_pedido\',\'#' . $res["id_pedido"] . '/' . $res["ordem"] . '\'); eraseCookieItem(\'p_rec\',\'' . $financeiro_valor_num . '\'); }" ' . $item_checked . ' /></td>
		</td>
		<td class="result_celula" align="center"><a href="pedido_edit.php?id=' . $res["id_pedido"] . '&ordem=' . $res["ordem"] . '" target="_blank"><img src="../images/botao_editar.png" title="Editar" border="0"/></a></td>
		<td class="result_celula" align="center" nowrap>#' . $res["id_pedido"] . '/' . $res["ordem"] . '</td>
		<td class="result_celula" nowrap>' . $res["nome"] . '</td>';
                if ($res["id_fatura"] <> 0)
                    $p_valor .= '<td class="result_celula" align="center"><a href="rel_baixar_boleto_fat.php?id=' . $res["id_fatura"] . '" target="_blank">' . $res["id_fatura"] . '</a></td>';
                else
                    $p_valor .= '<td class="result_celula" align="center">-</td>';

                if ($busca_e_cpf == '')
                    $p_valor .= '<td class="result_celula" nowrap>' . str_replace('/', '', str_replace('-', '', str_replace('.', '', $res["cpf"]))) . '</td>';
                if ($busca_e_nome == '')
                    $p_valor .= '<td class="result_celula" nowrap>' . $res["certidao_nome"] . '</td>';
                if ($busca_e_devedor == '')
                    $p_valor .= '<td class="result_celula" nowrap>' . $res["certidao_devedor"] . '</td>';
                if ($busca_e_inicio == '')
                    $p_valor .= '<td class="result_celula" align="center" nowrap>' . invert($res["inicio"], '/', 'PHP') . '</td>';
                if ($busca_e_prazo == '')
                    $p_valor .= '<td class="result_celula" align="center" nowrap>' . $data_prazo . '</td>';
                if ($busca_e_agenda == '')
                    $p_valor .= '<td class="result_celula" align="center" nowrap>' . $data_agenda . '</td>';
                if ($busca_e_data_atividade == '')
                    $p_valor .= '<td class="result_celula" align="center" nowrap>' . invert($res["data_atividade"], '/', 'PHP') . '</td>';
                if ($busca_e_forma == '')
                    $p_valor .= '<td class="result_celula" align="center" nowrap>' . $res["forma_pagamento"] . '</td>';
                $p_valor .= '<td class="result_celula ' . $class . '" align="right" nowrap>' . invert($res["data_i"], '/', 'PHP') . '-' . $res["status_hora"] . '</td>
				<td class="result_celula ' . $class . '" align="right" nowrap>' . $valor . '</td>
				<td class="result_celula ' . $class . '" align="right" nowrap>' . $financeiro_valor . '</td>';
                if ($busca_e_departamento == '')
                    $p_valor .= '<td class="result_celula" nowrap>' . $res["departamento"] . '</td>';
                if ($busca_e_servico == '')
                    $p_valor .= '<td class="result_celula" nowrap>' . $res["servico"] . '</td>';
                if ($busca_e_cidade == '')
                    $p_valor .= '<td class="result_celula' . $class . '" align="center" nowrap>' . $res["certidao_cidade"] . '</td>';
                if ($busca_e_estado == '')
                    $p_valor .= '<td class="result_celula' . $class . '" align="center" nowrap>' . $res["certidao_estado"] . '</td>';
                if ($busca_e_atividade == '')
                    $p_valor .= '<td class="result_celula" nowrap>' . $res["atividade"] . '</td>';
                if ($busca_e_status == '')
                    $p_valor .= '<td class="result_celula" nowrap>' . $res["status"] . '</td>';
                if ($busca_e_responsavel == '')
                    $p_valor .= '<td class="result_celula" nowrap>' . $responsavel . '</td>';
                if ($busca_e_atendimento == '')
                    $p_valor .= '<td class="result_celula" nowrap>' . $atendente . '</td>';
                $p_valor .= '</tr>';
            }
            $p_valor .= '<tr>
	<td class="result_celula" align="center" nowrap>
	</td>
	<td class="result_celula" align="center"></td>
	<td class="result_celula" align="center"></td>        
    <td class="result_celula" align="center" nowrap></td>
    <td class="result_celula" nowrap></td>';
            $valor_total = 'R$ ' . number_format($valor_total, 2, ".", ",");

            $financeiro_valor_total = 'R$ ' . number_format($financeiro_valor_total, 2, ".", ",");

            if ($busca_e_cpf == '')
                $p_valor .= '<td class="result_celula" nowrap></td>';
            if ($busca_e_nome == '')
                $p_valor .= '<td class="result_celula" nowrap></td>';
            if ($busca_e_devedor == '')
                $p_valor .= '<td class="result_celula" nowrap></td>';
            if ($busca_e_inicio == '')
                $p_valor .= '<td class="result_celula" align="center" nowrap></td>';
            if ($busca_e_prazo == '')
                $p_valor .= '<td class="result_celula" align="center" nowrap></td>';
            if ($busca_e_agenda == '')
                $p_valor .= '<td class="result_celula" align="center" nowrap></td>';
            if ($busca_e_data_atividade == '')
                $p_valor .= '<td class="result_celula" align="center" nowrap></td>';
            if ($busca_e_forma == '')
                $p_valor .= '<td class="result_celula" align="center" nowrap></td>';

            $p_valor .= '<td class="result_celula" align="right" nowrap>' . $valor_total . '</td>
	<td class="result_celula" align="right" nowrap>' . $financeiro_valor_total . '</td>';
            if ($busca_e_departamento == '')
                $p_valor .= '<td class="result_celula" nowrap></td>';
            if ($busca_e_servico == '')
                $p_valor .= '<td class="result_celula" nowrap></td>';
            if ($busca_e_atividade == '')
                $p_valor .= '<td class="result_celula" nowrap></td>';
            if ($busca_e_status == '')
                $p_valor .= '<td class="result_celula" nowrap></td>';
            if ($busca_e_responsavel == '')
                $p_valor .= '<td class="result_celula" nowrap></td>';
            if ($busca_e_atendimento == '')
                $p_valor .= '<td class="result_celula" nowrap></td>';
            $p_valor .= '</tr>';
            echo $p_valor;
            ?>
            <tr>
                <td colspan="18" class="barra_busca"><?php $objQuery->QTDPagina(); ?></td>
            </tr>
        </table>
    </form>

    <div id="windowMensagem">
        <div id="windowMensagemTop">
            <div id="windowMensagemTopContent"><img
                    src="../images/icon/icon_mensagem.png" style="border: 0" /> Ação</div>
            <img id="windowMensagemClose" src="../images/window_close.jpg"></div>
        <div id="windowMensagemBottom">
            <div id="windowMensagemBottomContent"></div>
        </div>
        <div id="windowMensagemContent">
            <div id="carrega_mensagem_input"></div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#windowMensagemClose').bind('click',function(){
                $('#windowMensagem').hide();
            }
        );
        });
    </script>
    </div>

<?php }
require('footer.php'); ?>