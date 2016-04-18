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
    $('#titulo').html('iniciar &rsaquo;&rsaquo; comunicados');
    $('#sub-05').css({'font-weight':'bold'});
</script>
<div class="content-list-forms">
    <form method="get">
        <dl>
            <legend>Buscar Comunicados</legend>
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
    $permissao = verifica_permissao('Mala Direta', $controle_id_departamento_p, $controle_id_departamento_s);
    if ($permissao != 'FALSE' AND $controle_id_empresa == '1') {
        AddRegistro('comunicados-editar.php'.$link.'&id_comunicado=0');
    }
    
    if($_GET){ 
        $listar = $safDAO->Comunicados($c);
        if(count($listar) > 0){ ?>
        <div class="paginacao">
            <?php $safDAO->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="buttons">#</th>
                    <th>comunicados</th>
                    <th class="buttons size150">data</th>
                    <th class="buttons">visualizar</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
                foreach ($listar as $f) { 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; ?>
                <tr <?=TRColor($color)?>>
                    <td class="buttons"><?=$f->id_maladireta?></td>
                    <td><?=utf8_encode($f->assunto)?></td>
                    <td class="buttons size150"><?=$f->data?></td>
                    <td class="buttons"><a target="_blank" href="comunicados-visualizar.php<?=$link.'&id_comunicado='.$f->id_maladireta?>"><img src="images/bt-message.png"></a></td>
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