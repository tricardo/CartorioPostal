<?php include('header.php'); 

$permissao = verifica_permissao('Cliente',$controle_id_departamento_p,$controle_id_departamento_s);
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
    $('#titulo').html('cadastros &rsaquo;&rsaquo; clientes');
    $('#sub-10').css({'font-weight':'bold'});
</script>
<div class="content-list-forms">
    <form method="get">
        
        <dl>
            <legend>Buscar Clientes</legend>
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
AddRegistro('clientes-editar.php'.$link.'&id_cliente=0');
if($_GET){ 
    $clienteDAO = new ClienteDAO();
    $listar = $clienteDAO->busca(isset($c->busca) ? $c->busca : '', $controle_id_empresa,
            isset($c->pagina) ? $c->pagina : 1); ?>
    <?php if(count($listar) > 0){ ?>
        <div class="paginacao">
            <?php $clienteDAO->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="buttons">#</th>
                    <th class="buttons size100">status</th>
                    <th class="buttons">data</th>
                    <th>cliente</th>
                    <th class="buttons">usuários</th>
                    <th class="buttons">conveniado</th>
                    <th class="buttons">Relatório</th>
                    <th class="buttons">editar</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
                foreach ($listar as $f) { 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF';
                    if($f->conveniado=='Sim'){
                        $link_conveniado = 'conveniados-listar.php?id_cliente=' . $f->id_cliente;
                        $conveniados = $clienteDAO->contaConveniados($f->id_cliente);
                    }else{
                        $link_conveniado = '#';
                        $conveniados = 0;
                    }
                    ?>
                <tr <?=TRColor($color)?>>
                    <td class="buttons"><?=$f->id_cliente?></td>
                    <td class="buttons"><?= invert($f->data,'/','PHP')?></td>
                    <td class="buttons"><?= utf8_encode($f->status) ?></td>
                    <td><?= utf8_encode($f->nome) ?></td>
                    <td class="buttons">
                        <a href="<?=$link_conveniado?>"><img src="images/bt-users.png"></a>
			(<?= $conveniados ?>)
                    </td>
                    <td class="buttons"><?= utf8_encode($f->conveniado) ?></td>
                    <td class="buttons"><?=$f->tipo == 'cnpj' ? '<a href="rel-clientes-cnpj.php'.$link.'&cnpj_cliente='.$f->cpf.'&listar=1"><img src="images/bt-relat.png"></a>' : '-'?></td>
                    <td class="buttons"><a href="clientes-editar.php<?=$link.'&id_cliente='.$f->id_cliente ?>"><img src="images/bt-edit.png"></a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="paginacao">
            <?php $clienteDAO->QTDPagina(); ?>
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