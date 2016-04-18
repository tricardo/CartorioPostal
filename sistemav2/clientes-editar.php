<?php include('header.php'); 

$permissao = verifica_permissao('Cliente',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

$clienteDAO = new ClienteDAO();
$pacoteDAO = new PacoteDAO();
$usuarioDAO = new UsuarioDAO();
$pedidoDAO = new PedidoDAO();

pt_register('GET','id_cliente');
pt_register('GET','opcoes_form');
$id_cliente = isset($id_cliente) ? $id_cliente : 0;
$opcoes_form = isset($opcoes_form) ? $opcoes_form : 1;
$show_msgbox = 0;

$c = Post_StdClass($_GET);
$c->id_cliente = $id_cliente;

if($id_cliente > 0){
    if ($clienteDAO->verificaId($id_cliente, $controle_id_empresa) == 0) {
        header('location:pagina-erro.php');
        exit;
    }
}

#
$link = '';
$link .= (isset($c->pagina)) ? '?pagina='.$c->pagina : '?pagina=1';
$link .= (isset($c->busca) AND strlen($c->busca) > 0) ? '&busca='.$c->busca : '';
?>

<script>
    menu(3,'bt-02');
    $('#titulo').html('cadastros &rsaquo;&rsaquo; clientes &rsaquo;&rsaquo; <a href="clientes-listar.php<?=$link?>" id="voltar">listar</a>');
    $('#sub-10').css({'font-weight':'bold'});
</script>
<div class="content-forms">
 
    <?php if($id_cliente > 0){ ?>
     <div class="opcoes">
        <label>selecione uma opção: </label>
        <select onchange="opcoesForm(this.value)" id="opcoes_form">
            <option value="1"<?=$opcoes_form == 1 ? ' selected="selected"' : ''?>>Informações do Cliente</option>
            <option value="2"<?=$opcoes_form == 2 ? ' selected="selected"' : ''?>>Arquivos Anexos</option>
        </select>
    </div>
    <?php } ?>
    <?php AddRegistro('clientes-editar.php'.$link.'&id_cliente=0'); 
    $link .= '&id_cliente='.$c->id_cliente;  ?>
    <?php CamposObrigatorios(); 
    include('clientes-editar-01.php');
    if($id_cliente > 0){
        include('clientes-editar-02.php');
    }
    ?>
    <script>
        opcoesForm(<?=$opcoes_form?>);
        preencheCampo();
    </script>
    <?php if(isset($_POST['f_anexo']) OR isset($exc_anexo)){ ?>
    <div class="msgbox">
        <div class="panel"><a href="#" onclick="$('.msgbox').hide()">fechar X</a></div>
        <div class="text"></div>
    </div>
    <script>
        BoxMsg(<?=($_POST) ? 1 : (isset($exc_anexo) ? 1 : 0)?>,<?=$errors?>,'<?=$campos?>','<?=$msgbox?>');
        </script>
    <?php
    }
    $errors=0;
    $campos='';
    $msgbox='';
    ?>
</div>
<?php include('footer.php'); ?>