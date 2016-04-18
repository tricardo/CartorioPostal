<?php include('header.php'); 

if ($controle_id_empresa != 1) {
    header('location:pagina-erro.php');
    exit;
}

$correioDAO = new CorreioDAO();
$empresaDAO = new EmpresaDAO();

$c = Post_StdClass($_GET);
$c->busca = isset($c->busca) ? $c->busca : '';
$c->id_empresa = isset($c->id_empresa) ? $c->id_empresa : '';
$c->pagina = isset($c->pagina) ? $c->pagina : 1;

$link = '';
$link .= '?pagina='.$c->pagina;
$link .= strlen($c->busca) > 0 ? '&busca='.$c->busca : '';
$link .= strlen($c->id_empresa) > 0 ? '&id_empresa='.$c->id_empresa : '';

$c = UTF_Encodes($c, 2);
$show_msgbox = 0;
?>

<script>
    menu(3,'bt-02');
    $('#titulo').html('cadastros &rsaquo;&rsaquo; correios');
    $('#sub-14').css({'font-weight':'bold'});
</script>

<div class="content-list-forms">
    <form method="get">
        <dl>
            <legend>Buscar Correios</legend>
            <dt>Pesquisar:</dt>
            <dd><input type="text" name="busca" id="busca" value="<?=(isset($c->busca)) ? utf8_encode($c->busca) : ''?>" placeholder="Pesquisar"></dd>
            <dt>Unidade:</dt>
            <dd>
                <select name="id_empresa" id="id_empresa" class="chzn-select">
                        <option value="" <?php if($c->id_empresa=='') echo 'selected="selected"'; ?>>Unidade</option>
                        <?php 
                        $empresas = $empresaDAO->listarTodasFranquias();
                        $p_valor = '';
                        foreach($empresas as $emp){
                            $p_valor .= '<option value="'.$emp->id_empresa.'" ';
                            if(isset($c->id_empresa)){
                                $p_valor .= ($c->id_empresa==$emp->id_empresa)?' selected="selected"':'';
                            }
                            $p_valor .= '>'.str_ireplace('Cartório Postal - ','',  utf8_encode($emp->fantasia)).'</option>';
                        }
                        echo $p_valor; ?>
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
    if($controle_id_empresa == 1 AND $controle_id_usuario == 1){
        AddRegistro('correios-editar.php'.$link.'&id_correio=0');
    }

    if($_GET){ 
        $listar = $correioDAO->listar($c->id_empresa, $c->busca, $c->pagina);
        if(count($listar) > 0){ ?>
        <div class="paginacao">
            <?php $correioDAO->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="buttons">#</th>
                    <th class="buttons size100">status</th>
                    <th>unidade</th>
                    <th>nome</th>
                    <th class="buttons size100">data do cartaz</th>
                    <th class="buttons">editar</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
                foreach ($listar as $f) { 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; ?>
                <tr <?=TRColor($color)?>>
                    <td class="buttons"><?=$f->id_agcorreios?></td>
                    <td class="buttons size100"><?=$f->status == 1 ? 'Ativo' : 'Cancelado'?></td>
                    <td><?=utf8_encode($f->fantasia)?></td>
                    <td><?=utf8_encode($f->nome)?></td>
                    <td class="buttons size100"><?=invert($f->data_cartaz, '/', 'PHP')?></td>
                    <td class="buttons"><?php if($controle_id_empresa == 1 AND $controle_id_usuario == 1){?><a href="correios-editar.php<?=$link.'&id_correio='.$f->id_agcorreios ?>"><img src="images/bt-edit.png"></a><?php } ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="paginacao">
            <?php $correioDAO->QTDPagina(); ?>
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