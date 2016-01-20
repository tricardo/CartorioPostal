<?
require('header.php');
?>
<div id="topo"><?
$permissao = verifica_permissao('Franquia', $controle_id_departamento_p, $controle_id_departamento_s);
if ($permissao == 'FALSE' or $controle_id_empresa != '1') {
    echo 'Você não tem permissão apra acessar a página';
    exit;
}

$servicoDAO = new ServicoDAO();
$pedidoDAO = new PedidoDAO();
$statusDAO = new StatusDAO();
$atividadeDAO = new AtividadeDAO();
$departamentoDAO = new DepartamentoDAO();
$usuarioDAO = new UsuarioDAO();
$empresaDAO = new EmpresaDAO();

$departamento_s = explode(',', $controle_id_departamento_s);
$departamento_p = explode(',', $controle_id_departamento_p);

pt_register('GET', 'busca_submit');
if ($busca_submit <> '') {
    pt_register('GET', 'busca_id_status');
    pt_register('GET', 'busca_id_usuario');
    pt_register('GET', 'busca_id_usuario_op');
    pt_register('GET', 'busca_id_atividade');
    pt_register('GET', 'busca_id_servico');
    pt_register('GET', 'busca_id_pedido');
    pt_register('GET', 'busca_id_empresa');
    pt_register('GET', 'busca_ordem');
    pt_register('GET', 'busca_ordenar');
    pt_register('GET', 'busca');
    pt_register('GET', 'busca_id_departamento');
    pt_register('GET', 'busca_origem');
    pt_register('GET', 'busca_data_i');
    pt_register('GET', 'busca_data_f');
    pt_register('GET', 'busca_data_i_a');
    pt_register('GET', 'busca_data_f_a');
    pt_register('GET', 'busca_data_i_co');
    pt_register('GET', 'busca_data_f_co');
    pt_register('GET', 'busca_data_i_conc');
    pt_register('GET', 'busca_data_f_conc');
    pt_register('GET', 'busca_ord');
    pt_register('GET', 'busca_exibicao');
    pt_register('GET', 'busca_e_inicio');
    pt_register('GET', 'busca_e_prazo');
    pt_register('GET', 'busca_e_agenda');
    pt_register('GET', 'busca_e_data_atividade');
    pt_register('GET', 'busca_e_valor');
    pt_register('GET', 'busca_e_departamento');
    pt_register('GET', 'busca_e_servico');
    pt_register('GET', 'busca_e_cidade');
    pt_register('GET', 'busca_e_estado');
    pt_register('GET', 'busca_e_status');
    pt_register('GET', 'busca_e_atividade');
    pt_register('GET', 'busca_e_responsavel');
    pt_register('GET', 'busca_e_atendimento');
    pt_register('GET', 'busca_e_devedor');
    pt_register('GET', 'estado_dir');
    pt_register('GET', 'busca_jadirecionados');
    if ($estado_dir[0] != 'Todos') {
        for ($i = 0; $i < count($estado_dir); $i++) {
            $estado_dir2.="'" . $estado_dir[$i] . "',";
        }
    }

    #grava secao da busca
    $_SESSION['p_busca_id_status'] = $busca_id_status;
    $_SESSION['p_busca_id_usuario'] = $busca_id_usuario;
    $_SESSION['p_busca_id_empresa'] = $busca_id_empresa;
    $_SESSION['p_busca_id_usuario_op'] = $busca_id_usuario_op;
    $_SESSION['p_busca_id_atividade'] = $busca_id_atividade;
    $_SESSION['p_busca_id_servico'] = $busca_id_servico;
    $_SESSION['p_busca'] = $busca;
    $_SESSION['p_busca_ordenar'] = $busca_ordenar;
    $_SESSION['p_busca_id_departamento'] = $busca_id_departamento;
    $_SESSION['p_busca_origem'] = $busca_origem;
    $_SESSION['p_busca_ord'] = $busca_ord;
    $_SESSION['p_busca_data_i'] = $busca_data_i;
    $_SESSION['p_busca_data_f'] = $busca_data_f;
    $_SESSION['p_busca_data_i_co'] = $busca_data_i_co;
    $_SESSION['p_busca_data_f_co'] = $busca_data_f_co;
    $_SESSION['p_busca_data_i_conc'] = $busca_data_i_conc;
    $_SESSION['p_busca_data_f_conc'] = $busca_data_f_conc;
    $_SESSION['p_busca_exibicao'] = $busca_exibicao;
    $_SESSION['p_busca_jadirecionados'] = $busca_jadirecionados;
    setcookie("p_busca_e_inicio", $busca_e_inicio);
    setcookie("p_busca_e_prazo", $busca_e_prazo);
    setcookie("p_busca_e_agenda", $busca_e_agenda);
    setcookie("p_busca_e_data_atividade", $busca_e_data_atividade);
    setcookie("p_busca_e_valor", $busca_e_valor);
    setcookie("p_busca_e_departamento", $busca_e_departamento);
    setcookie("p_busca_e_servico", $busca_e_servico);
    setcookie("p_busca_e_cidade", $busca_e_cidade);
    setcookie("p_busca_e_estado", $busca_e_estado);
    setcookie("p_busca_e_status", $busca_e_status);
    setcookie("p_busca_e_atividade", $busca_e_atividade);
    setcookie("p_busca_e_responsavel", $busca_e_responsavel);
    setcookie("p_busca_e_atendimento", $busca_e_atendimento);
    setcookie("p_busca_e_devedor", $busca_e_devedor);
    $_SESSION['estado_dir'] = $estado_dir2;
} else {
    $busca_id_status = $_SESSION['p_busca_id_status'];
    $busca_id_usuario = $_SESSION['p_busca_id_usuario'];
    $busca_id_empresa = $_SESSION['p_busca_id_empresa'];
    $busca_jadirecionados = $_SESSION['p_busca_jadirecionados'];
    $busca_id_usuario_op = $_SESSION['p_busca_id_usuario_op'];
    $busca_id_atividade = $_SESSION['p_busca_id_atividade'];
    $busca_id_servico = $_SESSION['p_busca_id_servico'];
    $busca_ordenar = $_SESSION['p_busca_ordenar'];
    $busca_ord = $_SESSION['p_busca_ord'];
    $busca = $_SESSION['p_busca'];
    $busca_ordem = '';
    $busca_id_departamento = $_SESSION['p_busca_id_departamento'];
    $busca_origem = $_SESSION['p_busca_origem'];
    $busca_data_i = $_SESSION['p_busca_data_i'];
    $busca_data_f = $_SESSION['p_busca_data_f'];
    $busca_data_i_co = $_SESSION['p_busca_data_i_co'];
    $busca_data_f_co = $_SESSION['p_busca_data_f_co'];
    $busca_data_i_conc = $_SESSION['p_busca_data_i_conc'];
    $busca_data_f_conc = $_SESSION['p_busca_data_f_conc'];
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
    $busca_e_devedor = $_COOKIE['p_busca_e_devedor'];
    $estado_dir2 = $_SESSION['estado_dir'];
    $estado_dir2 = str_replace('\\', '', $estado_dir2);
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
if ($busca_e_valor <> '')
    $busca_e_valor = ''; else
    $busca_e_valor = 'on';
if ($busca_e_departamento <> '')
    $busca_e_departamento = ''; else
    $busca_e_departamento = 'on';
if ($busca_e_servico <> '')
    $busca_e_servico = ''; else
    $busca_e_servico = 'on';
if ($busca_e_cidade <> '')
    $busca_e_cidade = ''; else
    $busca_e_cidade = 'on';
if ($busca_e_estado <> '')
    $busca_e_estado = ''; else
    $busca_e_estado = 'on';
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

if ($busca_data_i <> '')
    $busca_data_i = invert($busca_data_i, '-', 'SQL'); else
    $busca_data_i = date('Y-m-d', strtotime("- 1 year"));
if ($busca_data_f <> '')
    $busca_data_f = invert($busca_data_f, '-', 'SQL'); else
    $busca_data_f = date('Y-m-d');

if ($busca_data_i_a <> '')
    $busca_data_i_a = invert($busca_data_i_a, '-', 'SQL'); else
    $busca_data_i_a = date('Y-m-d', strtotime("- 1 year"));
if ($busca_data_f_a <> '')
    $busca_data_f_a = invert($busca_data_f_a, '-', 'SQL'); else
    $busca_data_f_a = date('Y-m-d');


if ($busca_data_i_co <> '')
    $busca_data_i_co = invert($busca_data_i_co, '-', 'SQL');
if ($busca_data_f_co <> '')
    $busca_data_f_co = invert($busca_data_f_co, '-', 'SQL');

if ($busca_data_i_conc <> '')
    $busca_data_i_conc = invert($busca_data_i_conc, '-', 'SQL');
if ($busca_data_f_conc <> '')
    $busca_data_f_conc = invert($busca_data_f_conc, '-', 'SQL');

if ($busca_id_pedido and $busca_ordem) {
    echo '<meta HTTP-EQUIV="refresh" CONTENT="1; URL=pedido_edit_franquia.php?id=' . $busca_id_pedido . '&ordem=' . $busca_ordem . '">';
    exit;
}

if ($busca_id_empresa == '') {
    $busca_id_empresa = '1';
}

$buscap = new stdClass();
$buscap->busca_id_status = $busca_id_status;
$buscap->busca_id_usuario = $busca_id_usuario;
$buscap->busca_id_empresa = $busca_id_empresa;
$buscap->busca_id_usuario_op = $busca_id_usuario_op;
$buscap->busca_id_atividade = $busca_id_atividade;
$buscap->busca_id_servico = $busca_id_servico;
$buscap->busca_ord = $busca_ord;
$buscap->busca_ordem = $busca_ordem;
$buscap->busca = $busca;
$buscap->busca_ordenar = $busca_ordenar;
$buscap->busca_id_pedido = $busca_id_pedido;
$buscap->busca_id_departamento = $busca_id_departamento;
$buscap->busca_origem = $busca_origem;
$buscap->busca_data_i = $busca_data_i;
$buscap->busca_data_f = $busca_data_f;
$buscap->busca_data_i_a = $busca_data_i_a;
$buscap->busca_data_f_a = $busca_data_f_a;
$buscap->busca_data_i_co = $busca_data_i_co;
$buscap->busca_data_f_co = $busca_data_f_co;
$buscap->busca_data_i_conc = $busca_data_i_conc;
$buscap->busca_data_f_conc = $busca_data_f_conc;
$buscap->busca_exibicao = $busca_exibicao;
$buscap->busca_e_conclu = $busca_e_conclu;
$buscap->busca_e_inicio = $busca_e_inicio;
$buscap->busca_e_prazo = $busca_e_prazo;
$buscap->busca_e_agenda = $busca_e_agenda;
$buscap->busca_e_data_atividade = $busca_e_data_atividade;
$buscap->busca_e_valor = $busca_e_valor;
$buscap->busca_e_departamento = $busca_e_departamento;
$buscap->busca_e_servico = $busca_e_servico;
$buscap->busca_e_cidade = $busca_e_cidade;
$buscap->busca_e_estado = $busca_e_estado;
$buscap->busca_e_status = $busca_e_status;
$buscap->busca_e_atividade = $busca_e_atividade;
$buscap->busca_e_responsavel = $busca_e_responsavel;
$buscap->busca_e_atendimento = $busca_e_atendimento;
$buscap->busca_e_devedor = $busca_e_devedor;
$buscap->estado_dir = $estado_dir;
$buscap->busca_jadirecionados = $busca_jadirecionados;


if ($busca_jadirecionados == 'Não direcionados')
    $onde.=' and pi.id_usuario_op=""';
elseif ($busca_jadirecionados == 'Já direcionados')
    $onde.=' and pi.id_usuario_op<>""';
?>
    <h1 class="tit"><img src="../images/tit/tit_pedido.png" alt="Título" />
        Ordem</h1>
    <hr class="tit" />
    <br />
</div>
<div id="meio">
    <table border="0" height="100%" width="100%">
        <tr>
            <td valign="top">
                <form name="buscador" action="" method="get" ENCTYPE="multipart/form-data">

                    <div class="busca1">
                        <label>Buscar: </label> 
                        <input type="text" class="form_estilo" style="width:200px;" name="busca" value="<?= $busca ?>" /><br/>
                        <label>Serviços: </label> 
                        <select name="busca_id_servico" style="width:200px;" class="form_estilo">
                            <option value="">Todos</option>
                            <?
                            $p_valor = '';
                            $var = $servicoDAO->lista();
                            foreach ($var as $s) {
                                $p_valor .= '<option value="' . $s->id_servico . '"';
                                if ($busca_id_servico == $s->id_servico)
                                    $p_valor .= ' selected="selected" ';
                                $p_valor .= ' >' . $s->descricao . '</option>';
                            }
                            echo $p_valor;
                            ?>

                        </select> <br />
                        <label>Origem:</label> 
                        <select name="busca_origem" style="width:200px;" class="form_estilo">
                            <option value="">Todos</option>
                            <?
                            $p_valor = '';
                            $var = $pedidoDAO->listarOrigem();
                            foreach ($var as $s) {
                                $p_valor .= '<option value="' . $s->origem . '"';
                                if ($busca_origem == $s->origem)
                                    $p_valor .= ' selected="selected" ';
                                $p_valor .= ' >' . $s->origem . '</option>';
                            }
                            echo $p_valor;
                            ?>
                        </select> <br />
                        <label>Status:</label> 
                        <select name="busca_id_status" style="width:200px;" class="form_estilo">
                            <option value="Todos">Todos</option>
                            <option value="Cad/Sol/Des/Exe/Ret" <? if ($busca_id_status == 'Cad/Sol/Des/Exe/Ret')
                                echo 'selected'; ?>>Cad/Sol/Des/Exe/Ret</option>
                                    <?
                                    $p_valor = '';
                                    $var = $statusDAO->listarTodos();
                                    foreach ($var as $s) {
                                        $p_valor .= '<option value="' . $s->id_status . '"';
                                        if ($busca_id_status == $s->id_status)
                                            $p_valor .= ' selected="selected" ';
                                        $p_valor .= ' >' . $s->status . '</option>';
                                    }
                                    echo $p_valor;
                                    ?>
                        </select> <br />
                        <label>Atividade: </label>
                        <select name="busca_id_atividade" style="width:200px;" class="form_estilo">
                            <option value=""
                            <? if ($busca_id_atividade == '')
                                echo ' selected="selected" '; ?>>Todos</option>
                                    <?
                                    $p_valor = '';
                                    $var = $atividadeDAO->listaAtividadesTodas();
                                    foreach ($var as $s) {
                                        $p_valor .= '<option value="' . $s->id_atividade . '"';
                                        if ($busca_id_atividade == $s->id_atividade)
                                            $p_valor .= ' selected="selected" ';
                                        $p_valor .= ' >' . $s->atividade . '</option>';
                                    }
                                    echo $p_valor;
                                    ?>
                        </select> <br />

                        <label>Exibição:</label> 
                        <select name="busca_exibicao" style="width:200px;" class="form_estilo">
                            <option value=""
                            <? if ($busca_exibicao == '')
                                echo ' selected="selected" '; ?>>Serviço</option>
                            <option value="Ordem"
                            <? if ($busca_exibicao == 'Ordem')
                                echo ' selected="selected" '; ?>>Ordem</option>
                        </select> <br />

                        <label>Ordem:</label> 
                        <input type="text" name="busca_id_pedido" value="<?= $busca_id_pedido ?>"  style="width:80px;" class="form_estilo"/> 
                        <strong>Serviço:</strong> 
                        <input type="text" name="busca_ordem" value="<?= $busca_ordem ?>"  style="width:50px;" class="form_estilo"/>
                    </div>
                    <div class="busca2">
                        <label>Departamento:</label> 
                        <select name="busca_id_departamento" style="width: 200px" class="form_estilo">
                            <option value=""
                            <? if ($busca_id_departamento == '')
                                echo ' selected="selected" '; ?>>Todos</option>
                                    <?
                                    $p_valor = '';
                                    $var = $departamentoDAO->listarDptoOrdem();
                                    foreach ($var as $s) {
                                        $p_valor .= '<option value="' . $s->id_servico_departamento . '"';
                                        if ($busca_id_departamento == $s->id_servico_departamento)
                                            $p_valor .= ' selected="selected" ';
                                        $p_valor .= ' >' . $s->departamento . '</option>';
                                    }
                                    echo $p_valor;
                                    ?>
                        </select> <br/>
                        <label>Unidade: </label> 
                        <select name="busca_id_empresa" style="width: 200px" class="form_estilo">
                            <?
                            $p_valor = '';
                            $var = $empresaDAO->listarTodas();
                            foreach ($var as $s) {
                                $p_valor .= '<option value="' . $s->id_empresa . '"';
                                if ($busca_id_empresa == $s->id_empresa)
                                    $p_valor .= ' selected="selected" ';
                                $p_valor .= ' >' . str_replace('Cartório Postal - ', '', $s->fantasia) . '</option>';
                            }
                            echo $p_valor;
                            ?>
                        </select> 
                        <label>Aberto Entre: </label> 
                        <input type="text" name="busca_data_i" value="<? if ($busca_data_i <> '')
                                echo invert($busca_data_i, '/', 'PHP'); ?>" style="width: 90px;" class="form_estilo" /> 
                        <strong>e </strong> 
                        <input type="text" name="busca_data_f" value="<? if ($busca_data_f <> '')
                                   echo invert($busca_data_f, '/', 'PHP'); ?>" style="width: 90px;" class="form_estilo" /> <br/>
                        <label>Alterado Entre: </label> 
                        <input type="text" name="busca_data_i_a" value="<? if ($busca_data_i_a <> '')
                                   echo invert($busca_data_i_a, '/', 'PHP'); ?>" style="width: 90px;" class="form_estilo" /> <strong>e </strong> 
                        <input type="text" name="busca_data_f_a" value="<? if ($busca_data_f_a <> '')
                                   echo invert($busca_data_f_a, '/', 'PHP'); ?>" style="width: 90px;" class="form_estilo" /> 
                        <label>Conc. Oper.: </label>
                        <input type="text" name="busca_data_i_co" value="<? if ($busca_data_i_co <> '')
                                   echo invert($busca_data_i_co, '/', 'PHP'); ?>" style="width: 90px;" class="form_estilo" /> 
                        <strong>e </strong> <input type="text" name="busca_data_f_co" value="<? if ($busca_data_f_co <> '')
                                   echo invert($busca_data_f_co, '/', 'PHP'); ?>" style="width: 90px;" class="form_estilo" /><br/>
                        <label>Serv. Conc.: </label>
                        <input type="text" name="busca_data_i_conc" value="<? if ($busca_data_i_conc <> '')
                                                       echo invert($busca_data_i_conc, '/', 'PHP'); ?>" style="width: 90px;" class="form_estilo" /> 
                        <strong>e </strong> 
                        <input type="text" name="busca_data_f_conc" value="<? if ($busca_data_f_conc <> '')
                                   echo invert($busca_data_f_conc, '/', 'PHP'); ?>" style="width: 90px;" class="form_estilo" />
                        <label>Ordenar Por: </label> 
                        <select name="busca_ordenar" style="width: 150px; float: left" class="form_estilo">
                            <option value="" <? if ($busca_ordenar == '')
                                   echo ' selected="selected" '; ?>></option>
                            <option value="Ordem"
                            <? if ($busca_ordenar == 'Ordem')
                                echo ' selected="selected" '; ?>>Ordem</option>
                            <option value="Documento de"
                            <? if ($busca_ordenar == 'Documento de')
                                echo ' selected="selected" '; ?>>Documento
                                de</option>
                            <option value="Data"
                            <? if ($busca_ordenar == 'Data')
                                echo ' selected="selected" '; ?>>Data</option>
                            <option value="Departamento"
                            <? if ($busca_ordenar == 'Departamento')
                                echo ' selected="selected" '; ?>>Departamento</option>
                            <option value="Serviço"
                            <? if ($busca_ordenar == 'Serviço')
                                echo ' selected="selected" '; ?>>Serviço</option>
                            <option value="Estado"
                            <? if ($busca_ordenar == 'Estado')
                                echo ' selected="selected" '; ?>>Estado</option>
                            <option value="Cidade"
                            <? if ($busca_ordenar == 'Cidade')
                                echo ' selected="selected" '; ?>>Cidade</option>
                            <option value="Prazo"
                            <? if ($busca_ordenar == 'Prazo')
                                echo ' selected="selected" '; ?>>Prazo</option>
                            <option value="Agenda"
                            <? if ($busca_ordenar == 'Agenda')
                                echo ' selected="selected" '; ?>>Agenda</option>
                            <option value="Data Status"
                            <? if ($busca_ordenar == 'Data Status')
                                echo ' selected="selected" '; ?>>Data Status</option>
                        </select> 
                        <select name="busca_ord"
                                style="width: 50px; padding-top: 5px; float: left"
                                class="form_estilo">
                            <option value=""
                            <? if ($busca_ord == '')
                                echo ' selected="selected" '; ?>>Cres</option>
                            <option value="Decr"
                            <? if ($busca_ord == 'Decr')
                                echo ' selected="selected" '; ?>>Decr</option>
                        </select> <br />

                        <label>Direcionamento:</label> 
                        <select name="busca_jadirecionados" style="width: 200px" class="form_estilo">
                            <option>Todos</option>
                            <option <?php if ($busca_jadirecionados == "Não direcionados")
                                        echo 'selected="selected"' ?>>Não direcionados</option>
                            <option <?php if ($busca_jadirecionados == "Já direcionados")
                                echo 'selected="selected"' ?>>Já direcionados</option>
                        </select>	


                        <input type="submit" name="busca_submit" class="button_busca" value=" Buscar " />
                    </div>
                    <div class="busca_campos">
                        <div class="form_estilo" id="selecionar_campos">
                            <input type="checkbox" name="busca_e_todos" onclick="if(this.checked==1) { selecionar_campos('pedidos'); } else{ deselecionar_campos('pedidos'); }" />Todos
                            <br><input type="checkbox" name="busca_e_agenda" <? if ($busca_e_agenda == '')
                                echo 'checked' ?> />Agenda
                            <br><input type="checkbox" name="busca_e_atendimento" <? if ($busca_e_atendimento == '')
                                       echo 'checked' ?> />Atendimento
                            <br><input type="checkbox" name="busca_e_atividade" <? if ($busca_e_atividade == '')
                                       echo 'checked' ?> />Atividade
                            <br><input type="checkbox" name="busca_e_cidade" <? if ($busca_e_cidade == '')
                                       echo 'checked' ?> />Cidade
                            <br><input type="checkbox" name="busca_e_conclu" <? if ($busca_e_conclu == '')
                                       echo 'checked' ?> />Concluído Oper.
                            <br><input type="checkbox" name="busca_e_data_atividade" <? if ($busca_e_data_atividade == '')
                                       echo 'checked' ?> />Data do Status
                            <br><input type="checkbox" name="busca_e_departamento" <? if ($busca_e_departamento == '')
                                       echo 'checked' ?> />Departamento
                            <br><input type="checkbox" name="busca_e_devedor" <? if ($busca_e_devedor == '')
                                       echo 'checked' ?> />Devedor
                            <br><input type="checkbox" name="busca_e_estado" <? if ($busca_e_estado == '')
                                       echo 'checked' ?> />Estado
                            <br><input type="checkbox" name="busca_e_inicio" <? if ($busca_e_inicio == '')
                                       echo 'checked' ?> />Início
                            <br><input type="checkbox" name="busca_e_prazo" <? if ($busca_e_prazo == '')
                                       echo 'checked' ?> />Prazo
                            <br><input type="checkbox" name="busca_e_responsavel" <? if ($busca_e_responsavel == '')
                                       echo 'checked' ?> />Responsável
                            <br><input type="checkbox" name="busca_e_servico" <? if ($busca_e_servico == '')
                                       echo 'checked' ?> />Serviço
                            <br><input type="checkbox" name="busca_e_status" <? if ($busca_e_status == '')
                                       echo 'checked' ?> />Status
                            <br><input type="checkbox" name="busca_e_valor" <? if ($busca_e_valor == '')
                                       echo 'checked' ?> />Valor
                        </div>
                    </div>
                </form>
                <br />
                <form name="f1" action="" method="post" ENCTYPE="multipart/form-data">


                    <div style="clear: both; padding: 5px">
                        <input type="submit" value=" Exportar " class="button_busca" onclick="document.f1.target='_blank'; document.f1.action='gera_exporta.php'" name="submit_exporta">
                    </div>
                    <br/>
                    <?php
                    $hoje = date('Y-m-d');
                    $hoje_prox = date('Y-m-d', strtotime('+3 day'));

                    pt_register('GET', 'pagina');
                    $p_valor = "";
                    $buscapedido = $pedidoDAO->buscaPedidoFranquia($buscap, $controle_id_empresa, $pagina);
                    $cont = 0;
                    ?>
                    <table width="100%" cellpadding="4" cellspacing="1"
                           class="result_tabela">
                        <tr>
                            <td colspan="18" class="barra_busca">
                                <? $pedidoDAO->QTDPagina(); ?>
                            </td>
                        </tr>
                        <?
                        $p_valor .= '
			<td align="center" width="20" class="result_menu"><input type="checkbox" name="todos" onclick="if(this.checked==1) { selecionar_tudo_cache(\'p_id_pedido_item\'); selecionar_tudo(); } else { deselecionar_tudo_cache(\'p_id_pedido_item\'); deselecionar_tudo(); }"></td>
			<td align="center" width="60" class="result_menu"><b>Editar</b></td>
			<td align="center" width="50" class="result_menu"><b>Ordem</b></td>';
                        if ($busca_exibicao == '') {
                            $p_valor .= '<td class="result_menu"><b>Documento de</b></td>';
                        } else {
                            $p_valor .= '<td class="result_menu"><b>Solicitante</b></td>';
                        }
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
                        if ($busca_e_valor == '')
                            $p_valor .= '<td align="center" width="50" class="result_menu"><b>Valor</b></td>';
                        if ($busca_e_departamento == '')
                            $p_valor .= '<td align="center" width="80" class="result_menu"><b>Departamento</b></td>';
                        if ($busca_e_servico == '')
                            $p_valor .= '<td align="center" width="80" class="result_menu"><b>Serviço</b></td>';
                        if ($busca_e_cidade == '')
                            $p_valor .= '<td align="center" width="80" class="result_menu"><b>Cidade</b></td>';
                        if ($busca_e_estado == '')
                            $p_valor .= '<td align="center" width="40" class="result_menu"><b>UF</b></td>';
                        if ($busca_e_status == '')
                            $p_valor .= '<td align="center" width="80" class="result_menu"><b>Status</b></td>';
                        if ($busca_e_atividade == '')
                            $p_valor .= '<td align="center" width="80" class="result_menu"><b>Atividade</b></td>';
                        if ($busca_e_responsavel == '')
                            $p_valor .= '<td align="center" width="80" class="result_menu"><b>Responsável</b></td>';
                        if ($busca_e_atendimento == '')
                            $p_valor .= '<td align="center" width="80" class="result_menu"><b>Atendimento</b></td>';

                        $p_valor .= '</tr>';

                        foreach ($buscapedido as $p) {
                            $cont++;
                            $id_pedido_item = $p->id_pedido_item;
                            $atendente = $p->atendente;
                            $restricao = $p->restricao;
                            $id_usuario_op = $p->id_usuario_op;
                            $id_usuario = $p->id_usuario;
                            $id_empresa_resp = $p->id_empresa_resp;
                            $departamento = $p->departamento;
                            $status_hora = $p->status_hora;
                            $data_prazo = invert($p->data_prazo, '/', 'PHP');
                            if ($p->empresa_resp <> '')
                                $empresa_resp = ' - <b>' . $p->empresa_resp . '</b>';
                            else
                                $empresa_resp = "";
                            if ($p->empresa_dir <> '')
                                $empresa_dir = ' - <b>' . $p->empresa_dir . '</b>';
                            else
                                $empresa_dir = "";
                            #$data_prazo	= $p->data_prazo;
                            $data_prazo_sql = invert($data_prazo, '/', 'SQL');
                            $encerramento = invert($p->encerramento, '-', 'PHP');
                            $encerramento = invert($encerramento, '-', 'SQL');
                            $data_agenda = invert($p->data_i, '/', 'PHP');
                            $valor = $p->valor;
                            $valor = 'R$ ' . number_format($valor, 2, ".", ",");
                            $responsavel = $p->responsavel;

                            if ($hoje > $data_prazo_sql and $p->id_status != 10 or $p->id_status == 10 and $encerramento > $data_prazo_sql)
                                $erro_atraso = "_erro";
                            else
                                $erro_atraso = "";

                            if ($restricao == 'on')
                                $erro_restricao = "_restricao";
                            else
                                $erro_restricao = "";

                            if ($empresa_dir <> '' and $p->id_empresa != 0)
                                $class = '_franquia'; else
                            if ($empresa_resp <> '' and $p->id_empresa != 0)
                                $class = '_franqueado'; else
                                $class = '';



                            if ($busca_exibicao == '')
                                $nome = $p->certidao_nome;
                            else
                                $nome = $p->nome;

                            if ($nome == '')
                                $nome = $p->certidao_matricula;

                            $p_valor .= '
				 <td class="result_celula' . $class . '" align="center" nowrap>
					<input type="hidden" name="acao_' . $cont . '" value="' . $p->id_pedido_item . '"/>
	   				<input type="hidden" name="acao_pedido_' . $cont . '" value="' . $p->id_pedido . '/' . $p->ordem . '"/>
       				<input type="checkbox" name="acao_sel_' . $cont . '" value="' . $p->id_pedido_item . '" onclick="if(this.checked==true) { createCookie(\'p_id_pedido_item\',\'' . $p->id_pedido_item . ',\',\'1\',\'1\'); createCookie(\'p_id_pedido\',\'#' . $p->id_pedido . '/' . $p->ordem . ',\',\'1\',\'1\'); } else {eraseCookieItem(\'p_id_pedido_item\',\'' . $p->id_pedido_item . '\'); eraseCookieItem(\'p_id_pedido\',\'#' . $p->id_pedido . '/' . $p->ordem . '\'); }" ' . $item_checked . ' /></td>
				</td>
				<td class="result_celula' . $class . '" align="center"><a href="pedido_edit_franquia.php?id=' . $p->id_pedido . '&ordem=' . $p->ordem . '"><img src="../images/botao_editar.png" title="Editar" border="0"/></a></td>
				<td class="result_celula' . $class . '" align="center" nowrap>#' . $p->id_pedido . '/' . $p->ordem . '</td>
				<td class="result_celula' . $class . '" nowrap>' . $nome . '</td>';
                            if ($busca_e_devedor == '')
                                $p_valor .= '<td class="result_celula' . $class . '">' . $p->certidao_devedor . '</td>';
                            if ($busca_e_inicio == '')
                                $p_valor .= '<td class="result_celula' . $class . ' result_celula' . $erro_restricao . '" align="center" nowrap>' . invert($p->inicio, '/', 'PHP') . '</td>';
                            if ($busca_e_prazo == '')
                                $p_valor .= '<td class="result_celula' . $class . ' result_celula' . $erro_atraso . '" align="center" nowrap>' . $data_prazo . '</td>';
                            if ($busca_e_agenda == '')
                                $p_valor .= '<td class="result_celula' . $class . '" align="center" nowrap>' . $data_agenda . ' ' . $status_hora . '</td>';
                            if ($busca_e_data_atividade == '')
                                $p_valor .= '<td class="result_celula' . $class . '" align="center" nowrap>' . invert($p->data_atividade, '/', 'PHP') . '</td>';
                            if ($busca_e_valor == '')
                                $p_valor .= '<td class="result_celula' . $class . '" align="right" nowrap>' . $valor . '</td>';
                            if ($busca_e_departamento == '')
                                $p_valor .= '<td class="result_celula' . $class . '" nowrap>' . $p->departamento . '</td>';
                            if ($busca_e_servico == '')
                                $p_valor .= '<td class="result_celula' . $class . '" nowrap>' . $p->servico . '</td>';
                            if ($busca_e_cidade == '')
                                $p_valor .= '<td class="result_celula' . $class . '" align="center" nowrap>' . $p->certidao_cidade . '</td>';
                            if ($busca_e_estado == '')
                                $p_valor .= '<td class="result_celula' . $class . '" align="center" nowrap>' . $p->certidao_estado . '</td>';
                            if ($busca_e_status == '')
                                $p_valor .= '<td class="result_celula' . $class . '" nowrap>' . $p->status . '</td>';
                            if ($busca_e_atividade == '')
                                $p_valor .= '<td class="result_celula' . $class . '" nowrap>' . $p->atividade . '</td>';
                            if ($busca_e_responsavel == '')
                                $p_valor .= '<td class="result_celula' . $class . '" nowrap>' . $responsavel . $empresa_dir . '</td>';
                            if ($busca_e_atendimento == '')
                                $p_valor .= '<td class="result_celula' . $class . '" align="center">' . $atendente . $empresa_resp . '</td>';
                            $p_valor .= '</tr>';
                        }
                        echo $p_valor;
                        ?>
                        <tr>
                            <td colspan="18" class="barra_busca">
                                <? $pedidoDAO->QTDPagina(); ?>
                            </td>
                        </tr>
                    </table>
                </form>
                <br>
                <br>
                <table width="400" cellpadding="4" cellspacing="1"
                       class="result_tabela">
                    <tr>
                        <td colspan="2" class="result_menu"><strong>Legenda</strong></td>
                    </tr>
                    <tr>
                        <td class="result_celula_franquia" width="10">&nbsp;</td>
                        <td class="result_celula">Serviço direcionado para outra Franquia</td>
                    </tr>
                    <tr>
                        <td class="result_celula_franqueado" width="10">&nbsp;</td>
                        <td class="result_celula" nowrap="nowrap">Serviço que veio de outra
                            Franquia</td>
                    </tr>
                    <tr>
                        <td class="result_celula_restricao" width="10">&nbsp;</td>
                        <td class="result_celula" nowrap="nowrap">Cliente com restrição</td>
                    </tr>
                    <tr>
                        <td class="result_celula_erro" width="10">&nbsp;</td>
                        <td class="result_celula" nowrap="nowrap">Serviço finalizado após o
                            prazo</td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</div>
<script>deselecionar_tudo_cache('p_id_pedido_item');	</script>
<?php
require('footer.php');
?>