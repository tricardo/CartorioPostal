<?php include('header.php'); 

$safDAO = new SafDAO();

$c = Post_StdClass($_GET);
$c->busca = isset($c->busca) ? $c->busca : '';
$c->pagina = isset($c->pagina) ? $c->pagina : 1;

$link = '';
$link .= '?pagina='.$c->pagina;
$link .= strlen($c->busca) > 0 ? '&busca='.$c->busca : '';

$c = UTF_Encodes($c, 2);
?>

<script>
    menu(3,'bt-01');
    $('#titulo').html('iniciar &rsaquo;&rsaquo; skype');
    $('#sub-04').css({'font-weight':'bold'});
</script>
<div class="content-list-forms">
    <form method="get">
        <dl>
            <legend>Buscar Skype</legend>
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
    
    if($_GET){ 
        $listar = $safDAO->Skype($c);
        if(count($listar) > 0){ ?>
        <div class="paginacao">
            <?php $safDAO->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Unidade</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Skype</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
                foreach ($listar as $f) { 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; ?>
                <tr <?=TRColor($color)?>>
                    <td><?=utf8_encode($f->fantasia)?></td>
                    <td><?=strlen($f->nome2) > 0 ? utf8_encode($f->nome2) : utf8_encode($f->nome1)?></td>
                    <td><?=strlen($f->email2) > 0 ? utf8_encode($f->email2) : utf8_encode($f->email1)?></td>
                    <td><?=strlen($f->skype2) > 0 ? utf8_encode($f->skype2) : utf8_encode($f->skype1)?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="paginacao">
            <?php $safDAO->QTDPagina(); ?>
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