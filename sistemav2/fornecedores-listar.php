<?php include('header.php'); 
$permissao = verifica_permissao('Cliente',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

$fornecedorDAO = new FornecedorDAO();
$c = new stdClass();
if($_POST){ foreach($_POST as $cp => $valor){ $c->$cp = $valor; pt_register('POST', $cp); } }
if($_GET){ foreach($_GET as $cp => $valor){ $c->$cp = $valor;  pt_register('GET', $cp); } } 

$link = '';
$link .= (isset($c->pagina)) ? '?pagina='.$c->pagina : '?pagina=1';
$link .= (isset($c->busca) AND strlen($c->busca) > 0) ? '&busca='.$c->busca : '';

$c = UTF_Encodes($c, 2);
$show_msgbox = 0;
?>
<script>
    menu(3,'bt-02');
    $('#titulo').html('cadastros &rsaquo;&rsaquo; fornecedores');
    $('#sub-12').css({'font-weight':'bold'});
</script>
<div class="content-list-forms">
    <form method="get">
        
        <dl>
            <legend>Buscar Fornecedores</legend>
            <dt>Pesquisar:</dt>
            <dd><input type="text" name="busca" id="busca" value="<?=(isset($c->busca)) ? utf8_encode($c->busca) : ''?>" placeholder="Pesquisar"></dd>
            <div class="buttons">
                <input type="button" value="&lsaquo;&lsaquo; limpar" onclick="location.href=window.location.pathname">
                <input type="submit" value="buscar &rsaquo;&rsaquo;">
            </div>
        </dl>
    </form>
    <script>preencheCampo()</script>
</div>
<div class="content-list-table">   
<?php
AddRegistro('fornecedores-editar.php'.$link.'&id_fornecedor=0');
if($_GET){ 
    $fornecedores = $fornecedorDAO->busca(((isset($c->busca)) ? $c->busca : ''),$controle_id_empresa,((isset($c->pagina)) ? $c->pagina : 1)); ?>
    <?php if(count($fornecedores) > 0){ ?>
        <div class="paginacao">
            <?php $fornecedorDAO->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="buttons">#</th>
                    <th>razão social</th>
                    <th>fantasia</th>
                    <th class="buttons">editar</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
                foreach ($fornecedores as $f) { 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; ?>
                <tr <?=TRColor($color)?>>
                    <td class="buttons"><?=$f->id_fornecedor?></td>
                    <td><?= utf8_encode($f->razao)?></td>
                    <td><?= utf8_encode($f->fantasia) ?></td>
                    <td class="buttons"><a href="fornecedores-editar.php<?=$link.'&id_fornecedor='.$f->id_fornecedor ?>"><img src="images/bt-edit.png"></a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="paginacao">
            <?php $fornecedorDAO->QTDPagina(); ?>
        </div>
        <script>PaginacaoWidth()</script>
    <?php } else { 
        RetornaVazio();
    } 
} else {
    RetornaVazio(2);
} ?>
</div>
<?php include('footer.php'); ?>