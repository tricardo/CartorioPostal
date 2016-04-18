<?php include('header.php'); 

$permissao = verifica_permissao('Cliente',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

$fornecedorDAO = new FornecedorDAO();
$bancoDAO      = new BancoDAO();
$regimeDAO     = new RegimeDAO();


pt_register('GET','id_fornecedor');
pt_register('GET','opcoes_form');
$id_fornecedor = isset($id_fornecedor) ? $id_fornecedor : 0;
$opcoes_form = isset($opcoes_form) ? $opcoes_form : 1;
$show_msgbox = 0;


$c = Post_StdClass($_GET);
$c->id_fornecedor = $id_fornecedor;

if($id_fornecedor > 0){
    if (count($fornecedorDAO->buscaPorId($id_fornecedor, $controle_id_empresa)) == 0) {
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
    $('#titulo').html('cadastros &rsaquo;&rsaquo; fornecedores &rsaquo;&rsaquo; <a href="fornecedores-listar.php<?=$link?>" id="voltar">listar</a>');
    $('#sub-12').css({'font-weight':'bold'});
</script>
<div class="content-forms">
    <?php if($id_fornecedor > 0){ ?>
     <div class="opcoes">
        <label>selecione uma opção: </label>
        <select onchange="opcoesForm(this.value)" id="opcoes_form">
            <option value="1"<?=$opcoes_form == 1 ? ' selected="selected"' : ''?>>Informações do Fornecedor</option>
            <option value="2"<?=$opcoes_form == 2 ? ' selected="selected"' : ''?>>Arquivos Anexos</option>
        </select>
    </div>
    <?php } ?>
    <?php AddRegistro('fornecedores-editar.php'.$link.'&id_fornecedor=0'); 
    $link .= '&id_fornecedor='.$c->id_fornecedor;  ?> 
    <?php CamposObrigatorios(); 
    include('fornecedores-editar-01.php');
    if($id_fornecedor > 0){
        include('fornecedores-editar-02.php');
    }
    ?>
    <script>
        opcoesForm(<?=$opcoes_form?>);
        preencheCampo();
    </script>
</div>
<?php include('footer.php'); ?>