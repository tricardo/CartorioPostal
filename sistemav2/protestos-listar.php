<?php include('header.php'); 

$permissao = verifica_permissao('Protesto',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

$protestoDAO = new ProtestoDAO();

$c = Post_StdClass($_GET);
$c->busca = isset($c->busca) ? $c->busca : '';
$c->pagina = isset($c->pagina) ? $c->pagina : 1;

$link = '';
$link .= '?pagina='.$c->pagina;
$link .= strlen($c->busca) > 0 ? '&busca='.$c->busca : '';

$c = UTF_Encodes($c, 2);
$show_msgbox = 0;
?>

<script>
    menu(3,'bt-02');
    $('#titulo').html('cadastros &rsaquo;&rsaquo; protestos');
    $('#sub-15').css({'font-weight':'bold'});
</script>

<div class="content-list-forms">
    <form method="get">
        <dl>
            <legend>Buscar Protestos</legend>
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
    AddRegistro('protestos-editar.php'.$link.'&id_protesto=0');

    if($_GET){ 
        $listar = $protestoDAO->busca($c->busca, $controle_id_empresa, $c->pagina);
        if(count($listar) > 0){ ?>
        <div class="paginacao">
            <?php $protestoDAO->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="buttons">#</th>
                    <th>portador</th>
                    <th class="buttons size100">movimento</th>
                    <th class="buttons">devedores</th>
                    <th class="buttons">gerar</th>
                    <th class="buttons">editar</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
                foreach ($listar as $f) { 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; ?>
                <tr <?=TRColor($color)?>>
                    <td class="buttons"><?=$f->id_protesto?></td>
                    <td><?=utf8_encode($f->portador.' -'.$f->portador_nome)?></td>
                    <td class="buttons size100"><?=invert($f->data_movimento,'/','PHP')?></td>
                    <td class="buttons"><a href="protestos-devedor-listar.php<?=$link.'&id_protesto='.$f->id_protesto ?>"><img src="images/bt-edit.png"></a></td>
                    <td class="buttons"><a href="rel-protestos-rem.php<?=$link.'&id_protesto='.$f->id_protesto ?>"><img src="images/bt-download.png"></a></td>
                    <td class="buttons"><a href="protestos-editar.php<?=$link.'&id_protesto='.$f->id_protesto ?>"><img src="images/bt-edit.png"></a></td>
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