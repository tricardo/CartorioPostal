<?php include('header.php'); 

$permissao = verifica_permissao('Conta',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

$c = Post_StdClass($_GET);
$link = '';
$link .= (isset($c->pagina)) ? '?pagina='.$c->pagina : '?pagina=1';
$link .= (isset($c->busca) AND strlen($c->busca) > 0) ? '&busca='.$c->busca : '';

$c = UTF_Encodes($c, 2);
$show_msgbox = 0;
?>
<script>
    menu(3,'bt-02');
    $('#titulo').html('cadastros &rsaquo;&rsaquo; contas');
    $('#sub-50').css({'font-weight':'bold'});
</script>
<div class="content-list-forms">
    <form method="get">
        
        <dl>
            <legend>Buscar Contas</legend>
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
AddRegistro('contas-editar.php'.$link.'&id_conta=0');
if($_GET){ 
    $contaDAO = new ContaDAO();
    define('MOSTRAR_CONTAS','TODAS');
    $listar = $contaDAO->listar( $controle_id_empresa, isset($c->busca) ? $c->busca : '',
            isset($c->pagina) ? $c->pagina : 1); ?>
    <?php if(count($listar) > 0){ ?>
        <div class="paginacao">
            <?php $contaDAO->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="buttons">#</th>
                    <th class="buttons size100">status</th>
                    <th>banco</th>
                    <th>sigla</th>
                    <th>agência</th>
                    <th>conta</th>
                    <th class="buttons">editar</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
                foreach ($listar as $f) { 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; ?>
                <tr <?=TRColor($color)?>>
                    <td class="buttons"><?=$f->id_conta?></td>
                    <td class="buttons"><?= utf8_encode($f->status) ?></td>
                    <td><?= utf8_encode($f->banco) ?></td>
                    <td><?= utf8_encode($f->sigla) ?></td>
                    <td><?= utf8_encode($f->agencia) ?></td>
                    <td><?= utf8_encode($f->conta) ?></td>
                    <td class="buttons"><a href="contas-editar.php<?=$link.'&id_conta='.$f->id_conta ?>"><img src="images/bt-edit.png"></a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="paginacao">
            <?php $contaDAO->QTDPagina(); ?>
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