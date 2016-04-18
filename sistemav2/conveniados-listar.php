<?php include('header.php'); 

$permissao = verifica_permissao('Cliente',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

$c = Post_StdClass($_GET);
$c->pagina = isset($c->pagina) ? $c->pagina : 1;
$c->busca = isset($c->busca) ? $c->busca : '';
#
$link = '';
$link .= (isset($c->pagina)) ? '?pagina='.$c->pagina : '?pagina=1';
$link .= (isset($c->busca) AND strlen($c->busca) > 0) ? '&busca='.$c->busca : '';
$link .= (isset($c->id_cliente) AND strlen($c->id_cliente) > 0) ? '&id_cliente='.$c->id_cliente : '';
$id_cliente = isset($c->id_cliente) ? $c->id_cliente : '';
$id_conveniado = isset($c->id_conveniado) ? $c->id_conveniado : 0;

$conveniadoDAO = new ConveniadoDAO();
$clienteDAO = new ClienteDAO();

?>
<script>
    menu(3,'bt-02');
    $('#titulo').html('cadastros &rsaquo;&rsaquo; clientes &rsaquo;&rsaquo; conveniados');
    $('#sub-10').css({'font-weight':'bold'});
</script>
<div class="content-list-forms">
    <form method="get">
        
        <dl>
            <legend>Buscar Conveniados</legend>
            <dt>Busca:</dt>
            <dd><input type="text" name="busca" id="busca" value="<?=(isset($c->busca)) ? $c->busca : ''?>" placeholder="Pesquisar"></dd>
            <dt>Clientes:</dt>
            <dd>
                 <select name="id_cliente" id="id_cliente" class="chzn-select">
                    <option value="" <?=$id_cliente==''?' selected="selected"':''?>>Clientes</option>
                    <?php
                    $clientes = $clienteDAO->listarPorEmpresa($controle_id_empresa);
                    foreach($clientes as $l){
                        echo '<option value="'.$l->id_cliente.'"'.(($id_cliente==$l->id_cliente) ? ' selected="selected" ' : '').'>'
                            .utf8_encode($l->nome).'</option>';
                    } ?>
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
if($id_cliente > 0){
    AddRegistro('conveniados-editar.php'.$link.'&id_cliente='.$id_cliente.'&id_conveniado=0');
}
if($_GET){ 
    $conveniados = $conveniadoDAO->busca($c->busca,$controle_id_empresa,$id_cliente,$c->pagina); ?>
    <?php if(count($conveniados) > 0){ ?>
        <div class="paginacao">
            <?php $conveniadoDAO->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="buttons">#</th>
                    <th class="buttons size100">status</th>
                    <th>cliente</th>
                    <th>nome</th>
                    <th class="buttons">senha</th>
                    <th class="buttons">editar</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
                foreach ($conveniados as $l) { 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; ?>
                    <tr <?=TRColor($color)?>>
                        <td class="buttons"><?=$l->id_conveniado?></td>
                        <td class="buttons size100"><?=$l->status?></td>
                        <td><?=utf8_encode($l->empresa)?></td>
                        <td><?=utf8_encode($l->nome)?></td>
                        <td class="buttons"><a href="conveniados-senha.php<?=$link.'&id_conveniado='.$l->id_conveniado ?>"><img src="images/bt-pass.png"></a></td>
                        <td class="buttons"><a href="conveniados-editar.php<?=$link.'&id_conveniado='.$l->id_conveniado ?>"><img src="images/bt-edit.png"></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="paginacao">
            <?php $conveniadoDAO->QTDPagina(); ?>
        </div>
    <?php } else {
        RetornaVazio();
    } 
} else {
    RetornaVazio(2);
}
?>
</div>
<?php include('footer.php'); ?>