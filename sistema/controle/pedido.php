<?
require('header.php');
$p_valor = '';
$departamento_s = explode(',', $controle_id_departamento_s);
$departamento_p = explode(',', $controle_id_departamento_p);

$servicoDAO = new ServicoDAO();
$pedidoDAO = new PedidoDAO();
$statusDAO = new StatusDAO();
$atividadeDAO = new AtividadeDAO();
$departamentoDAO = new DepartamentoDAO();
$usuarioDAO = new UsuarioDAO();
$empresaDAO = new EmpresaDAO();

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
    pt_register('GET', 'busca_ord');
    pt_register('GET', 'busca_exibicao');
    pt_register('GET', 'busca_e_conclu');
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
    pt_register('GET', 'busca_sit');

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
    $_SESSION['p_busca_exibicao'] = $busca_exibicao;
    $_SESSION['p_busca_sit'] = $busca_sit;
    setcookie("p_busca_e_inicio", $busca_e_inicio);
    setcookie("p_busca_e_conclu", $busca_e_conclu);
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
    $busca_exibicao = $_SESSION['p_busca_exibicao'];
    $busca_sit = $_COOKIE['p_busca_sit'];
    $busca_e_conclu = $_COOKIE['p_busca_e_conclu'];
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
    $estado_dir2 = $_COOKIE['estado_dir'];
    $estado_dir2 = str_replace('\\', '', $estado_dir2);
}

if ($busca_id_pedido and $busca_ordem) {
    echo '<meta HTTP-EQUIV="refresh" CONTENT="1; URL=pedido_edit.php?id=' . $busca_id_pedido . '&ordem=' . $busca_ordem . '">';
    exit;
}

if ($busca_e_prazo <> '')
    $busca_e_prazo = ''; else
    $busca_e_prazo = 'on';
if ($busca_e_conclu <> '')
    $busca_e_conclu = ''; else
    $busca_e_conclu = 'on';
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

if ($busca_id_usuario == '' and in_array('6', $departamento_p) == 1) {
    $busca_id_usuario = $controle_id_usuario;
}

if ($busca_id_usuario == '_') {
    $busca_id_usuario = '';
}

if (in_array('1', $departamento_p) != 1 and $busca_id_usuario_op == '' and $busca_id_usuario == '' and (in_array('3', $departamento_p) == 1 or in_array('4', $departamento_p) == 1 or in_array('5', $departamento_p) == 1 or in_array('8', $departamento_p) == 1 or in_array('9', $departamento_p) == 1 or in_array('11', $departamento_p) == 1 or in_array('12', $departamento_p) == 1)) {
    $busca_id_usuario_op = $controle_id_usuario;
}

if ($busca_id_usuario_op == '_') {
    $busca_id_usuario_op = '';
}

if ($busca_id_empresa == '_') {
    $busca_id_empresa = '';
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
$buscap->busca_sit = $busca_sit;
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
$buscap->estado_dir = $estado_dir2;

if($busca_id_status=='') $busca_id_status='3';
if($busca_id_status=='Todos') $busca_id_status='';

?>
<div id="topo">
    <h1 class="tit"><img src="../images/tit/tit_pedido.png" alt="Título" /> Pedidos</h1>
    <a href="#" class="topo">topo</a>
    <hr class="tit"/>
</div>
<div id="meio">
    <table border="0" height="100%" width="100%" >
        <tr>
            <td valign="top">
                <?
                pt_register('POST', 'submit_protocolo');
                if ($submit_protocolo <> '') {
                    require('../includes/pedido_protocolo.php');
                    echo '<br><br><a href="pedido.php">Clique aqui para voltar</a>';
                    exit;
                }

                pt_register('POST', 'submit_oficio');
                if ($submit_oficio <> '') {
                    require('../includes/pedido_oficio.php');
                }

                pt_register('POST', 'submit_oficio_imp');
                if ($submit_oficio_imp <> '') {
                    require('../includes/pedido_oficio_imp.php');
                }

                pt_register('POST', 'submit_fax');
                if ($submit_fax <> '') {
                    require('../includes/pedido_fax.php');
                }

                pt_register('POST', 'submit_2via');
                if ($submit_2via <> '') {
                    require('../includes/pedido_2via.php');
                }

                pt_register('POST', 'submit_etiqueta');
                if ($submit_etiqueta <> '') {
                    require('../includes/pedido_etiqueta.php');
                }

                pt_register('POST', 'submit_direcionamento');
                if ($submit_direcionamento <> '') {
                    require('../includes/pedido_direcionamento.php');
                }

                pt_register('POST', 'submit_direcionamento_aplica');
                if ($submit_direcionamento_aplica <> '') {
                    require('../includes/pedido_direcionamento_aplica.php');
                }

                pt_register('POST', 'submit_processos');
                if ($submit_processos <> '') {
                    require('../includes/pedido_processos.php');
                    exit;
                }

                pt_register('POST', 'submit_imoveis_busca');
                if ($submit_imoveis_busca <> '') {
                    require('../includes/pedido_imoveis_busca.php');
                    exit;
                }

                pt_register('POST', 'submit_desembolso');
                if ($submit_desembolso <> '') {
                    require("../includes/pedido_desembolso.php");
                    exit;
                }

                pt_register('POST', 'submit_financeiro');
                if ($submit_financeiro) {
                    require("../includes/pedido_desembolso_conf.php");
                    echo '<a href="pedido.php">Clique aqui para voltar</a>';
                    exit;
                }

                pt_register('POST', 'submit_acao');
                if ($submit_acao <> '') {
                    require("../includes/pedido_atividades.php");
                }

                pt_register('POST', 'submit_status');
                if ($submit_status) {
                    require("../includes/pedido_atividades_aplica.php");
                }
                ?>	
                <form name="buscador" action="" method="get" ENCTYPE="multipart/form-data">
                    <div class="busca1">
                        <label>Buscar: </label>
                        <input type="text" class="form_estilo" name="busca" value="<?= $busca ?>" style="width:200px;" /><br />
                        <label>Serviços: </label>
                        <select name="busca_id_servico" style="width:200px;" class="form_estilo" onchange="carrega_servico_var(this.value,''); carrega_campo_r(this.value,'','');">
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

                        <label>Origem: </label>
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
                        </select>

                        <label>Status: </label>
                        <select name="busca_id_status" style="width:200px;" class="form_estilo">
                            <option value="Todos">Todos</option>
                            <option value="Cad/Sol/Des/Exe/Ret" <? if ($busca_id_status == 'Cad/Sol/Des/Exe/Ret')
                                echo 'selected'; ?>>Cad/Sol/Des/Exe/Ret</option>
                            <option value="Cad/Sol/Des/Exe/Par/Ret" <? if ($busca_id_status == 'Cad/Sol/Des/Exe/Par/Ret')
                                        echo 'selected'; ?>>Cad/Sol/Des/Exe/Par/Ret</option>
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
                        </select>

                        <label>Atividade: </label>
                        <select name="busca_id_atividade" style="width:200px;" class="form_estilo">
                            <option value="" <? if ($busca_id_atividade == '')
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

                        <label>Situação: </label>
                        <select name="busca_sit" style="width:200px;" class="form_estilo">
                            <option value="" <? if ($busca_sit == '')
                                        echo 'selected'; ?>>Todos</option>
                            <option value="1" <? if ($busca_sit == '1')
                                        echo 'selected'; ?>>Executado (De Outras Unidade)</option>
                            <option value="2" <? if ($busca_sit == '2')
                                        echo 'selected'; ?>>Executado (De Minha Unidade)</option>
                            <option value="3" <? if ($busca_sit == '3')
                                        echo 'selected'; ?>>Em Execução</option>
                        </select>

                        <label>Exibição: </label>
                        <select name="busca_exibicao" style="width:200px;" class="form_estilo">
                            <option value="" <? if ($busca_exibicao == '')
                                        echo ' selected="selected" '; ?>>Serviço</option>
                            <option value="Ordem" <? if ($busca_exibicao == 'Ordem')
                                        echo ' selected="selected" '; ?>>Ordem</option>
                            <option value="Atraso" <? if ($busca_exibicao == 'Atraso')
                                        echo ' selected="selected" '; ?>>Atraso</option>
                            <option value="Atraso Operacional" <? if ($busca_exibicao == 'Atraso Operacional')
                                        echo ' selected="selected" '; ?>>Atraso Operacional</option>
                        </select> <br />						

                        <label>Ordem: </label>
                        <input type="text" name="busca_id_pedido" value="<?= $busca_id_pedido ?>" style="width:79px;" class="form_estilo" />
                        <strong>Serviço: </strong>
                        <input type="text" name="busca_ordem" value="<?= $busca_ordem ?>" style="width:64px;" class="form_estilo" />
                        <br><br><br>
                        <?
                        $permissao = verifica_permissao('Pedido Add', $controle_id_departamento_p, $controle_id_departamento_s);
                        if ($permissao == 'TRUE') {
                            ?>
                            <h3><a href="pedido_add.php" style="text-decoration:none"> <img src="../images/botao_add.png" border="0" /> Adicionar novo registro</a></h3>	
                        <? } ?>

                    </div>
                    <div class="busca2">
                        <label>Departamento: </label>
                        <select name="busca_id_departamento" style="width:200px" class="form_estilo">
                            <option value="" <? if ($busca_id_departamento == '')
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
                        </select>
                        <label>Atendente: </label>
                        <select name="busca_id_usuario" style="width:200px" class="form_estilo">
                            <option value="_" <? if ($busca_id_usuario == '')
                                        echo ' selected="selected" '; ?>>Todos</option>
                            <option value="ex" <? if ($busca_id_usuario == 'ex')
                                        echo ' selected="selected" '; ?>>Ex. Funcionários</option>
                                    <?
                                    $p_valor = '';
                                    $var = $usuarioDAO->listarAtendentes($controle_id_empresa);
                                    foreach ($var as $s) {
                                        $p_valor .= '<option value="' . $s->id_usuario . '"';
                                        if ($busca_id_usuario == $s->id_usuario)
                                            $p_valor .= ' selected="selected" ';
                                        $p_valor .= ' >' . $s->nome . '</option>';
                                    }
                                    echo $p_valor;
                                    ?>        
                        </select>

                        <label>Responsável: </label>
                        <select name="busca_id_usuario_op" style="width:200px" class="form_estilo">
                            <option value="_" <? if ($busca_id_usuario_op == '')
                                        echo ' selected="selected" '; ?>>Todos</option>
                                    <?
                                    $p_valor = '';
                                    $var = $usuarioDAO->listarOp($controle_id_empresa);
                                    foreach ($var as $s) {
                                        $p_valor .= '<option value="' . $s->id_usuario . '"';
                                        if ($busca_id_usuario_op == $s->id_usuario)
                                            $p_valor .= ' selected="selected" ';
                                        $p_valor .= ' >' . $s->nome . '</option>';
                                    }
                                    echo $p_valor;
                                    ?>        
                        </select>

                        <label>Unidade: </label>
                        <select name="busca_id_empresa" style="width:200px" class="form_estilo">
                            <option value="" <? if ($busca_id_empresa == '')
                                        echo ' selected="selected" '; ?>>Todas Unidades</option>
                            <option value="minha" <? if ($busca_id_empresa == 'minha')
                                        echo ' selected="selected" '; ?>>Minha Unidade</option>
                            <option value="naominha" <? if ($busca_id_empresa == 'naominha')
                                        echo 'selected="select"'; ?>>Minha Unidade (Enviado)</option>
                            <option value="naominha_r" <? if ($busca_id_empresa == 'naominha_r')
                                        echo 'selected="select"'; ?>>Outras Unidades (Recebido)</option>
                                    <?
                                    $p_valor = '';
                                    $var = $empresaDAO->listarTodasN($controle_id_empresa);
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
                                        echo invert($busca_data_i, '/', 'PHP'); ?>" style="width:90px;" class="form_estilo" />
                        <strong>e </strong>
                        <input type="text" name="busca_data_f"  value="<? if ($busca_data_f <> '')
                                   echo invert($busca_data_f, '/', 'PHP'); ?>" style="width:90px;" class="form_estilo" />
                        <br>
                        <label>Alterado Entre: </label>
                        <input type="text" name="busca_data_i_a" value="<? if ($busca_data_i_a <> '')
                                   echo invert($busca_data_i_a, '/', 'PHP'); ?>" style="width:90px;" class="form_estilo" />
                        <strong>e </strong>
                        <input type="text" name="busca_data_f_a"  value="<? if ($busca_data_f_a <> '')
                                   echo invert($busca_data_f_a, '/', 'PHP'); ?>" style="width:90px;" class="form_estilo" />
                        <label>Conc. Oper.: </label>
                        <input type="text" name="busca_data_i_co" value="<? if ($busca_data_i_co <> '')
                                   echo invert($busca_data_i_co, '/', 'PHP'); ?>" style="width:90px;" class="form_estilo" />
                        <strong>e </strong>
                        <input type="text" name="busca_data_f_co"  value="<? if ($busca_data_f_co <> '')
                                   echo invert($busca_data_f_co, '/', 'PHP'); ?>" style="width:90px;" class="form_estilo" />

                        <label>Ordenar Por: </label>
                        <select name="busca_ordenar" style="width:144px;" class="form_estilo">
                            <option value="" <? if ($busca_ordenar == '')
                                   echo ' selected="selected" '; ?>></option>
                            <option value="Ordem" <? if ($busca_ordenar == 'Ordem')
                                        echo ' selected="selected" '; ?>>Ordem</option>
                            <option value="Documento de" <? if ($busca_ordenar == 'Documento de')
                                        echo ' selected="selected" '; ?>>Documento de</option>
                            <option value="Data" <? if ($busca_ordenar == 'Data')
                                        echo ' selected="selected" '; ?>>Data</option>
                            <option value="Departamento" <? if ($busca_ordenar == 'Departamento')
                                        echo ' selected="selected" '; ?>>Departamento</option>
                            <option value="Serviço" <? if ($busca_ordenar == 'Serviço')
                                        echo ' selected="selected" '; ?>>Serviço</option>
                            <option value="Estado" <? if ($busca_ordenar == 'Estado')
                                        echo ' selected="selected" '; ?>>Estado</option>
                            <option value="Cidade" <? if ($busca_ordenar == 'Cidade')
                                        echo ' selected="selected" '; ?>>Cidade</option>
                            <option value="Prazo" <? if ($busca_ordenar == 'Prazo')
                                        echo ' selected="selected" '; ?>>Prazo</option>
                            <option value="Agenda" <? if ($busca_ordenar == 'Agenda')
                                        echo ' selected="selected" '; ?>>Agenda</option>
                            <option value="Data Status" <? if ($busca_ordenar == 'Data Status')
                                        echo ' selected="selected" '; ?>>Data Status</option>
                        </select>
                        <select name="busca_ord" style="width:50px;" class="form_estilo">
                            <option value="" <? if ($busca_ord == '')
                                        echo ' selected="selected" '; ?>>Cres</option>
                            <option value="Decr" <? if ($busca_ord == 'Decr')
                                        echo ' selected="selected" '; ?>>Decr</option>			
                        </select> 
                        <label></label><label></label><input type="submit" name="busca_submit" class="button_busca" value=" Buscar " />
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

                    <? if ($controle_id_empresa == '1') { ?>
                        <div class="busca_campos2">
                            <b><a href="#" onclick="if(document.getElementById('selecionar_estados').style.visibility=='hidden') document.getElementById('selecionar_estados').style.visibility='visible'; else document.getElementById('selecionar_estados').style.visibility='hidden';">Selecionar Estados</a></b><br>
                            <select multiple="multiple" name="estado_dir[]" id="selecionar_estados" style="visibility:hidden;">
                                <option value="Todos">Todos</option>
                                <option value="AC">AC</option>
                                <option value="AL">AL</option>
                                <option value="AM">AM</option>
                                <option value="AP">AP</option>
                                <option value="BA">BA</option>
                                <option value="CE">CE</option>
                                <option value="DF">DF</option>
                                <option value="ES">ES</option>
                                <option value="GO">GO</option>
                                <option value="MA">MA</option>
                                <option value="MG">MG</option>
                                <option value="MS">MS</option>
                                <option value="MT">MT</option>
                                <option value="PA">PA</option>
                                <option value="PB">PB</option>
                                <option value="PE">PE</option>
                                <option value="PI">PI</option>
                                <option value="PR">PR</option>
                                <option value="RJ">RJ</option>
                                <option value="RN">RN</option>
                                <option value="RO">RO</option>
                                <option value="RR">RR</option>
                                <option value="RS">RS</option>
                                <option value="SC">SC</option>
                                <option value="SE">SE</option>
                                <option value="SP">SP</option>
                                <option value="TO">TO</option>
                            </select>
                        </div>
                    <? } ?>

                </form>

                <br />
                <form name="f1" action="" method="post" ENCTYPE="multipart/form-data">

                    <div style="clear:both; padding:5px">
                        <input type="submit" name="submit_acao" onclick="document.f1.target='_self'; document.f1.action=''" class="button_busca" value=" Alterar Status " />
                        <input type="submit" name="submit_exporta" onclick="document.f1.target='_blank'; document.f1.action='gera_exporta.php'" class="button_busca" value=" Exportar " />
                        <? if ($controle_id_empresa == '1' or $controle_id_empresa == '57') { ?>
                            <input type="submit" name="submit_exporta_2" onclick="document.f1.target='_blank'; document.f1.action='gera_exporta_todos.php'" class="button_busca" value=" Exportar Todos " />
                        <? } ?>
                        <input type="submit" name="submit_exporta_txt" onclick="document.f1.target='_blank'; document.f1.action='gera_exporta_txt.php'" class="button_busca" value=" Dados do Doc. " />
                        <input type="submit" name="submit_desembolso" onclick="document.f1.target='_self'; document.f1.action=''" class="button_busca" value=" Desembolso " />
                        <input type="submit" name="submit_fax" onclick="document.f1.target='_self'; document.f1.action=''" class="button_busca" value=" Fax c/ Depósito " />
                        <input type="submit" name="submit_protocolo" onclick="document.f1.target='_self'; document.f1.action=''" class="button_busca" value=" Protocolo " />
                        <input type="submit" name="submit_etiqueta" onclick="document.f1.target='_self'; document.f1.action=''" class="button_busca" value=" Etiqueta " />

                        <br>
                        <b>Ofícios:</b><br>
                        <? $permissao = verifica_permissao('Departamento', $controle_id_departamento_p, $controle_id_departamento_s);
                        if ($permissao == 'TRUE') { ?>
                            <input type="submit" name="submit_direcionamento" onclick="document.f1.target='_self'; document.f1.action=''" class="button_busca" value=" Direciona p/ Franquia " />
                        <? } ?>
                        <? $permissao = verifica_permissao('2via', $controle_id_departamento_p, $controle_id_departamento_s);
                        if ($permissao == 'TRUE') { ?>
                            <input type="submit" name="submit_2via" onclick="document.f1.target='_self'; document.f1.action=''" class="button_busca" value=" 2 Via " />
                        <? } ?>
                        <? $permissao_im = verifica_permissao('Imoveis', $controle_id_departamento_p, $controle_id_departamento_s);
                        if ($permissao_im == 'TRUE') { ?>
                            <input type="submit" name="submit_oficio" onclick="document.f1.target='_self'; document.f1.action=''" class="button_busca" value=" Ofício Imóveis " />
                            <input type="submit" name="submit_imoveis_busca" onclick="document.f1.target='_self'; document.f1.action=''" class="button_busca" value="Result. Imóveis" />
                        <? } ?>
                        <? $permissao_pro = verifica_permissao('Processos', $controle_id_departamento_p, $controle_id_departamento_s);
                        if ($permissao_pro == 'TRUE') { ?>
                            <input type="submit" name="submit_processos" onclick="document.f1.target='_self'; document.f1.action=''" class="button_busca" value=" N/C Detran " />
                        <? }
                        if (($permissao_pro == 'TRUE' or $permissao_im == 'TRUE') and $controle_id_empresa == 1) { ?>
                            <input type="submit" name="submit_oficio_imp" onclick="document.f1.target='_self'; document.f1.action=''" class="button_busca" value=" Importar Arq " />
                        <? } ?>
                    </div>
                    <?php
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

                    $lista = $empresaDAO->listarTodas();
                    foreach ($lista as $l) {
                        $vardir[$l->id_empresa] = $l->fantasia;
                    }

                    $buscapedido = $pedidoDAO->buscaPedido($buscap, $controle_id_empresa, $controle_id_departamento_p, $controle_id_departamento_s, $pagina);
                    $cont = 0;
                    ?>
                    <table width="100%" cellpadding="4" cellspacing="1" class="result_tabela">
                        <tr>
                            <td colspan="20" class="barra_busca">
                                <? $pedidoDAO->QTDPagina(); ?> 			
                            </td>
                        </tr>
                        <?
                        $hoje = date('Y-m-d');
                        $hoje_prox = date('Y-m-d', strtotime('+3 day'));

                        $p_valor = '<tr>
                        <td align="center" width="20" class="result_menu">
                                <input type="checkbox" name="todos" onclick="if(this.checked==1) { selecionar_tudo_cache(\'p_id_pedido_item\'); selecionar_tudo(); } else { deselecionar_tudo_cache(\'p_id_pedido_item\'); deselecionar_tudo(); }">
                        </td>';

                        $permissao = verifica_permissao('Pedido Add', $controle_id_departamento_p, $controle_id_departamento_s);
                        if ($permissao == 'TRUE') {
                            $p_valor .= '<td align="center" width="60" class="result_menu"><b>Novo Serviço</b></td>';
                        }

                        $p_valor .= '<td align="center" width="60" class="result_menu"><b>Editar</b></td>
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
                        if ($busca_e_conclu == '')
                            $p_valor .= '<td align="center" width="50" class="result_menu"><b>Concluído Oper.</b></td>';
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
                        $p_id_pedido_item = explode(',', $_COOKIE["p_id_pedido_item"]);
                        foreach ($buscapedido as $p) {
                            $cont++;
                            $data_operacional = invert($p->operacional, '/', 'PHP');
                            $data_prazo = invert($p->data_prazo, '/', 'PHP');
                            if ($p->id_empresa_resp != '0' and $p->id_empresa_resp == $controle_id_empresa)
                                $empresa_resp = ' - <b>' . $vardir[$p->id_empresa_atend] . '</b>';
                            else
                                $empresa_resp = "";
                            if ($p->id_empresa_resp <> 0 and $p->id_empresa_resp != $controle_id_empresa)
                                $empresa_dir = ' - <b>' . $vardir[$p->id_empresa_resp] . '</b>';
                            else
                                $empresa_dir = "";

                            $data_prazo_sql = invert($data_prazo, '/', 'SQL');
                            $operacional = invert($p->operacional, '-', 'PHP');
                            $encerramento = invert($p->encerramento, '-', 'PHP');
                            $encerramento = invert($encerramento, '-', 'SQL');
                            $data_agenda = invert($p->data_i, '/', 'PHP');
                            $valor = 'R$ ' . number_format($p->valor, 2, ".", ",");

                            if ($hoje > $data_prazo_sql and $p->id_status != 10 or $encerramento > $data_prazo_sql and $p->id_status == 10) {
                                $erro_atraso = "_erro";
                            } else {
                                if ($hoje_prox >= $data_prazo_sql and $p->id_status != 10)
                                    $erro_atraso = "_erro_aviso";
                                else
                                    $erro_atraso = "";
                            }

                            if ($hoje > $data_prazo_sql and $p->operacional == '0000-00-00' or $p->operacional != '0000-00-00' and $p->operacional > $data_prazo_sql) {
                                $erro_atraso_op = "_erro";
                            } else {
                                if ($hoje_prox >= $data_prazo_sql and $p->operacional == '0000-00-00')
                                    $erro_atraso_op = "_erro_aviso";
                                else
                                    $erro_atraso_op = "";
                            }

                            if ($p->restricao == 'on')
                                $erro_restricao = "_restricao";
                            else
                                $erro_restricao = "";

                            if ($empresa_dir <> '')
                                $class = '_franquia';
                            elseif ($empresa_resp <> '')
                                $class = '_franqueado';
                            else
                                $class = '';

                            if (in_array($p->id_pedido_item, $p_id_pedido_item) == 1)
                                $item_checked = ' checked '; else
                                $item_checked = '';
                            $p_valor .= '<tr>
                            <td class="result_celula' . $class . '" align="center" nowrap>
							<input type="hidden" name="empresa_dir[]" id="empresa_dir'.$cont.'" value="" />
                            <input type="hidden" name="acao_' . $cont . '" value="' . $p->id_pedido_item . '"/>
                            <input type="hidden" name="acao_pedido_' . $cont . '" value="' . $p->id_pedido . '/' . $p->ordem . '"/>
                            <input type="checkbox" name="acao_sel_' . $cont . '" value="' . $p->id_pedido_item . '" onclick="if(this.checked==true) { createCookie(\'p_id_pedido_item\',\'' . $p->id_pedido_item . ',\',\'1\',\'1\'); createCookie(\'p_id_pedido\',\'#' . $p->id_pedido . '/' . $p->ordem . ',\',\'1\',\'1\'); document.getElementById(\'empresa_dir'.$cont.'\').value=\''.$p->id_empresa_dir.'\'; } else {eraseCookieItem(\'p_id_pedido_item\',\'' . $p->id_pedido_item . '\'); eraseCookieItem(\'p_id_pedido\',\'#' . $p->id_pedido . '/' . $p->ordem . '\'); document.getElementById(\'empresa_dir'.$cont.'\').value=\'\'; }" ' . $item_checked . ' /></td>';

                            if ($permissao == 'TRUE') {
                                $p_valor .= '<td class="result_celula' . $class . '" align="center"><a href="pedido_add_servico.php?id=' . $p->id_pedido . '&ordem=' . $p->ordem . '"><img src="../images/botao_editar.png" title="Editar" border="0"/></a></td>';
                            }

                            if ($busca_exibicao == '')
                                $nome = $p->certidao_numero_not . ' ' . $p->certidao_nome . $p->certidao_nome_proprietario;
                            else
                                $nome = $p->nome;

                            if ($nome == '')
                                $nome = $p->certidao_matricula;

                            $p_valor .= '
                            <td class="result_celula' . $class . '" align="center"><a href="pedido_edit.php?id=' . $p->id_pedido . '&ordem=' . $p->ordem . '"><img src="../images/botao_editar.png" title="Editar" border="0"/></a></td>
                            <td class="result_celula' . $class . '" align="center" nowrap>#' . $p->id_pedido . '/' . $p->ordem . '</td>
                            <td class="result_celula' . $class . '" nowrap>' . $nome;
                            if ($p->id_empresa_dir <> 0 and $p->id_empresa_dir != $controle_id_empresa) {
                                $fantasia_dir = $vardir[$p->id_empresa_dir];
                                $p_valor .= '<span class="formInfo"><a href="../help/pedido_dir.php?fantasia=' . str_replace(' ','_',$fantasia_dir) . '" class="jTip" id="help_ativ' . $p->id_pedido_item . '" name="Direcionamento para outra franquia">?</a></span>';
                            }
                            $p_valor .= '</td>';
                            if ($busca_e_devedor == '')
                                $p_valor .= '<td class="result_celula' . $class . '">' . $p->certidao_devedor . '</td>';
                            if ($busca_e_inicio == '')
                                $p_valor .= '<td class="result_celula' . $class . ' result_celula' . $erro_restricao . '" align="center" nowrap>' . invert($p->inicio, '/', 'PHP') . '</td>';
                            if ($busca_e_conclu == '')
                                $p_valor .= '<td class="result_celula' . $class . ' result_celula' . $erro_atraso_op . '" align="center" nowrap>' . $data_operacional . '</td>';
                            if ($busca_e_prazo == '')
                                $p_valor .= '<td class="result_celula' . $class . ' result_celula' . $erro_atraso . '" align="center" nowrap>' . $data_prazo . '</td>';
                            if ($busca_e_agenda == '')
                                $p_valor .= '<td class="result_celula' . $class . '" align="center" nowrap>' . $data_agenda . ' ' . $p->status_hora . '</td>';
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
                                $p_valor .= '<td class="result_celula' . $class . '" nowrap>' . $p->responsavel . $empresa_dir . '</td>';
                            if ($busca_e_atendimento == '')
                                $p_valor .= '<td class="result_celula' . $class . '" align="center">' . $p->atendente . $empresa_resp . '</td>';
                            $p_valor .= '</tr>';
                        }
                        echo $p_valor;
                        ?>
                        <tr>
                            <td colspan="20" class="barra_busca">
                                <? $pedidoDAO->QTDPagina(); ?>
                            </td>
                        </tr>
                    </table>
                </form>
                <br><br>
                <table width="400" cellpadding="4" cellspacing="1" class="result_tabela">
                    <tr>
                        <td colspan="2" class="result_menu"><strong>Legenda</strong></td>
                    </tr>
                    <tr>
                        <td class="result_celula_franquia" width="10">&nbsp;</td>
                        <td class="result_celula">Serviço direcionado para outra Franquia</td>
                    </tr>
                    <tr>
                        <td class="result_celula_franqueado" width="10">&nbsp;</td>
                        <td class="result_celula" nowrap="nowrap">Serviço que veio de outra Franquia</td>
                    </tr>          
                    <tr>
                        <td class="result_celula_restricao" width="10">&nbsp;</td>
                        <td class="result_celula" nowrap="nowrap">Cliente com restrição</td>
                    </tr>          
                    <tr>
                        <td class="result_celula_erro" width="10">&nbsp;</td>
                        <td class="result_celula" nowrap="nowrap">Serviço finalizado após o prazo</td>
                    </tr>          		  
                    <tr>
                        <td class="result_celula_erro_aviso" width="10">&nbsp;</td>
                        <td class="result_celula" nowrap="nowrap">Faltam 3 dias para atingir o prazo</td>
                    </tr>          		  
                </table>	

            </td>
        </tr>
    </table>
</div>
<?php
require('footer.php');
?>