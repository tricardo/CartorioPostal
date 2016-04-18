<?php include('header.php'); 

$permissao = verifica_permissao('Supervisor',$controle_id_departamento_p,$controle_id_departamento_s);
$perm_comp = verifica_permissao('Financeiro Compra',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

$compraDAO = new CompraDAO();
$departamentoDAO = new DepartamentoDAO();



$id_departamentos = explode(',',$controle_id_departamento_s);
if($perm_comp=='TRUE'){
    $departamentos = $departamentoDAO->listar();
} else {
    $departamentos = $departamentoDAO->listar($id_departamentos);
}


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
?>
<script>
    menu(3,'bt-04');
    $('#titulo').html('financeiro &rsaquo;&rsaquo; compras');
    $('#sub-52').css({'font-weight':'bold'});
</script>
<div class="content-list-forms">
    <form method="get">
        
        <dl>
            <legend>Buscar Compras</legend>
            <dt>Pesquisar:</dt>
            <dd>
                <input type="text" name="busca" id="busca" value="<?= $c->busca ?>"> 
            </dd>
            <dt>Departamento:</dt>
            <dd>
                <select name="id_departamento" id="id_departamento" class="chzn-select">
                    <?php
                    if($perm_comp == 'TRUE'){
                        echo '<option value="">Departamento</option>';
                    }
                    $p_valor ='';
                    foreach($departamentos as $dep){
                        $p_valor .= '<option value="'.$dep->id_departamento.'"';
                        if($dep->id_departamento==$c->id_departamento) $p_valor .= ' selected="selected" ';
                        $p_valor .= '>';
                        $p_valor .= utf8_encode($dep->departamento).'</option>';
                    } 
                    echo $p_valor;
                    ?>
            </select>
            </dd>
            <dt>Status:</dt>
            <dd>
                <select name="status" id="status" class="chzn-select">
                    <option value="">Status</option>
                    <?php foreach(TiposDeStatus(11) AS $f){?>
                        <option <?php if($c->status==['id'])echo 'selected="selected"'?>><?=$f['texto']?></option>
                    <?php } ?>
                </select>
            </dd>
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
if($controle_id_empresa == 1){
    AddRegistro('compras-editar.php'.$link.'&id_compra=0');
}

if($_GET){ 
    $listar = $compraDAO->busca($c,$controle_id_empresa,$c->pagina);
    ?>
    <?php if(count($listar) > 0){ ?>
        <div class="paginacao">
            <?php $compraDAO->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="buttons">#</th>
                    <th class="buttons size100">status</th>
                    <th class="buttons">quantidade</th>
                    <th>produto</th>
                    <th>departamento</th>
                    <th>solicitante</th>
                    <th class="buttons">editar</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
                foreach ($listar as $f) { 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; ?>
                <tr <?=TRColor($color)?>>
                    <td class="buttons"><?=$f->id_compra?></td>
                    <td class="buttons size100"><?=utf8_encode($f->status)?></td>
                    <td class="buttons"><?=utf8_encode($f->quantidade)?></td>
                    <td><?=utf8_encode($f->produto)?></td>
                    <td><?=utf8_encode($f->departamento)?></td>
                    <td><?=utf8_encode($f->solicitante)?></td>
                    <td class="buttons"><a href="compras-editar.php<?=$link.'&id_compra='.$f->id_compra ?>"><img src="images/bt-edit.png"></a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="paginacao">
            <?php $compraDAO->QTDPagina(); ?>
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