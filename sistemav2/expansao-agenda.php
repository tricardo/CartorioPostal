<?php include('header.php'); 

$expansaoDAO = new ExpansaoDAO();

$permissao = verifica_permissao('EXPANSAO',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

$exp_item = $expansaoDAO->verAcesso(1, $controle_id_empresa, $controle_id_usuario, 
	$controle_id_departamento_p, $controle_id_departamento_s, $controle_nome);

?>
<script>
    menu(3,'bt-03');
    $('#titulo').html('expansão &rsaquo;&rsaquo; agenda');
    $('#sub-19').css({'font-weight':'bold'});
</script>
<div class="content-list-forms"></div>
<div class="content-list-table">  
    <div class="content-calendario">
        <div id="calendario"></div>
    </div>
    <div id="calendario_evento"></div>
    <script>carrega_calendario('<?=date('m')?>','<?=date('Y')?>');</script>
</div>
<?php include('footer.php'); ?>