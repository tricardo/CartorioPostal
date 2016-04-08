<?php include('header.php'); 

$permissao = verifica_permissao('Protesto',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

$protestoDAO = new ProtestoDAO();

pt_register('GET','id_protesto');

$c = Post_StdClass($_GET);
$c->busca = isset($c->busca) ? $c->busca : '';
$c->pagina = isset($c->pagina) ? $c->pagina : 1;

$link = '';
$link .= '?pagina='.$c->pagina;
$link .= strlen($c->busca) > 0 ? '&busca='.$c->busca : '';
?>

<script>
    menu(3,'bt-02');
    $('#titulo').html('cadastros &rsaquo;&rsaquo; protestos &rsaquo;&rsaquo; devedores');
    $('#sub-15').css({'font-weight':'bold'});
</script>

<div class="content-list-forms">
    <form method="get">
        <dl>
            <legend>Buscar Protestos Devedor</legend>
            <dt>Pesquisar:</dt>
            <dd><input type="text" name="busca" id="busca" value="<?=(isset($c->busca)) ? $c->busca : ''?>" placeholder="Pesquisar"></dd>
            <div class="buttons">
                <input type="button" value="&lsaquo;&lsaquo; limpar" onclick="location.href=window.location.pathname+'?id_protesto=<?=$id_protesto?>'">
                <input type="submit" value="buscar &rsaquo;&rsaquo;">
                <input type="hidden" id="id_protesto" name="id_protesto" value="<?=$id_protesto?>">
            </div>
        </dl>
    </form>
    <script>preencheCampo()</script>
</div>
<div class="content-list-table">   
    <?php
    AddRegistro('protestos-devedor-editar.php'.$link.'&id_protesto_rem=0&id_protesto='.$id_protesto);

    if($_GET){ 
        $listar = $protestoDAO->buscaDevedores($c->busca,$id_protesto,$controle_id_empresa,$c->pagina);
        if(count($listar) > 0){ ?>
        <div class="paginacao">
            <?php $protestoDAO->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="buttons">#</th>
                    <th class="buttons">sequência</th>
                    <th>devedor</th>
                    <th class="buttons">editar</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
                foreach ($listar as $f) { 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; ?>
                <tr <?=TRColor($color)?>>
                    <td class="buttons"><?=$f->id_protesto?></td>
                    <td class="buttons"><?=$f->id_protesto_rem?></td>
                    <td><?=utf8_encode($f->dev_nome)?></td>
                    <td class="buttons"><a href="protestos-devedor-editar.php<?=$link.'&id_protesto_rem='.$f->id_protesto_rem.'&id_protesto='.$f->id_protesto?>"><img src="images/bt-edit.png"></a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="paginacao">
            <?php $protestoDAO->QTDPagina(); ?>
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