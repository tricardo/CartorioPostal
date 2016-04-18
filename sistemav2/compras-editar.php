<?php include('header.php'); 

$permissao = verifica_permissao('Supervisor',$controle_id_departamento_p,$controle_id_departamento_s);
$perm_comp = verifica_permissao('Financeiro Compra',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

$compraDAO = new CompraDAO();
$departamentoDAO = new DepartamentoDAO();
pt_register('GET','id_compra');

$opcoes_form = isset($opcoes_form) ? $opcoes_form : 1;
$show_msgbox = 0;

#
$c = Post_StdClass($_GET);
$c->busca = isset($c->busca) ? $c->busca : '';
$c->id_departamento = isset($c->id_departamento) ? $c->id_departamento : '';
$c->status = isset($c->status) ? $c->status : '';
$c->pagina = isset($c->pagina) ? $c->pagina : 1;

$link = '';
$link .= '?pagina='.$c->pagina;
$link .= strlen($c->busca) > 0 ? '&busca='.$c->busca : '';
$link .= strlen($c->id_departamento) > 0 ? '&id_departamento='.$c->id_departamento : '';
$link .= strlen($c->status) > 0 ? '&status='.$c->status : '';

$id_departamentos = explode(',',$controle_id_departamento_s);
if($perm_comp=='TRUE'){
    $departamentos = $departamentoDAO->listar();
} else {
    $departamentos = $departamentoDAO->listar($id_departamentos);
}

?>
<script>
    menu(3,'bt-04');
    $('#titulo').html('financeiro &rsaquo;&rsaquo; compras  &rsaquo;&rsaquo; <a href="compras-listar.php<?=$link?>" id="voltar">listar</a>');
    $('#sub-52').css({'font-weight':'bold'});
</script>
<div class="content-forms">
    <?php if($id_compra > 0){ ?>
     <div class="opcoes">
        <label>selecione uma opção: </label>
        <select onchange="opcoesForm(this.value)" id="opcoes_form">
            <option value="1"<?=$opcoes_form == 1 ? ' selected="selected"' : ''?>>Informações da Compra</option>
            <option value="2"<?=$opcoes_form == 2 ? ' selected="selected"' : ''?>>Propostas</option>
        </select>
    </div>
    <?php } ?>
    <?php AddRegistro('compras-editar.php'.$link.'&id_compra=0'); 
    $link .= '&id_compra='.$c->id_compra;  ?>  
    <?php CamposObrigatorios(); 
    include('compras-editar-01.php');
    if($id_compra > 0){
        include('compras-editar-02.php');
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