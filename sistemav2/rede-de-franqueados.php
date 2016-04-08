<?php include('header.php'); 

$safDAO = new SafDAO();

$c = Post_StdClass($_GET);
$c->busca = isset($c->busca) ? $c->busca : '';
$c->pagina = isset($c->pagina) ? $c->pagina : 1;
$c->estado = isset($c->estado) ? $c->estado : '';

$link = '';
$link .= '?pagina='.$c->pagina;
$link .= strlen($c->busca) > 0 ? '&busca='.$c->busca : '';
$link .= strlen($c->estado) > 0 ? '&estado='.$c->estado : '';

$c = UTF_Encodes($c, 2);
?>

<script>
    menu(3,'bt-01');
    $('#titulo').html('iniciar &rsaquo;&rsaquo; rede de franqueados');
    $('#sub-03').css({'font-weight':'bold'});
</script>
<div class="content-list-forms">
    <form method="get">
        <dl>
            <legend>Buscar Rede de Franqueados</legend>
            <dt>Pesquisar:</dt>
            <dd><input type="text" name="busca" id="busca" value="<?=(isset($c->busca)) ? utf8_encode($c->busca) : ''?>" placeholder="Pesquisar"></dd>
            <dt>Estado:</dt>
            <dd>
                <select id="estado" name="estado" class="chzn-select">
                    <option value="">UF</option>
                    <?php $uf = $safDAO->RedeEstado();
                    foreach($uf AS $l){ ?>
                        <option value="<?=utf8_encode($l->estado)?>"<?=$c->estado == $l->estado ? ' selected="selected"' : ''  ?>><?=utf8_encode($l->estado)?></option>
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
    <?php if($_GET){ 
        $listar = $safDAO->RedeFranqueados($c);
        if(count($listar) > 0){ ?>
        <div class="paginacao">
            <?php $safDAO->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th>razão social / franquia</th>
                    <th>endereço</th>
                    <th>conta bancária</th>
                    <th class="buttons size200">região</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
                foreach ($listar as $f) { 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; 
                    $apelido = $f->apelido <>'' ?  $f->apelido :  $f->bairro; ?>
                <tr <?=TRColor($color)?>>
                    <td><?=utf8_encode($f->empresa . '<br>' . $f->cpf . '<br><strong>' . str_replace('Cartório Postal - ','',$f->fantasia) . '<br>' . $f->nome . '</strong><br>' . $f->email . '<br>' . $f->tel . '<br>Skype: ' . $f->skype)?></td>
                    <td><?=utf8_encode($f->endereco . ', ' . $f->numero . '<br>' . $f->complemento . '<br>' . $f->bairro . '<br>' . $f->cidade . ' - ' . $f->estado)?></td>
                    <td><?=utf8_encode($f->banco . '<br>' . $f->agencia . ' - ' . $f->conta . ' <br><br> ' . $f->favorecido)?></td>
                    <td class="buttons size200"><?=utf8_encode($apelido . '<br>' . $f->cidade_f . '<br>' . $f->estado_f)?></td>
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