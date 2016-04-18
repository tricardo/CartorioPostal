<?php include('header.php'); 
$permissao = verifica_permissao('Franquia', $controle_id_departamento_p, $controle_id_departamento_s);
if ($permissao == 'FALSE' or $controle_id_empresa != '1') {
    header('location:pagina-erro.php');
    exit;
}
$permissao = verifica_permissao('Direcao', $controle_id_departamento_p, $controle_id_departamento_s); 
$franquia = new FranquiasDAO();
$c = new stdClass();
if($_POST){ foreach($_POST as $cp => $valor){ $c->$cp = $valor; } }
if($_GET){ foreach($_GET as $cp => $valor){ $c->$cp = $valor; } } 

$link = '';
$link .= (isset($c->pagina)) ? '?pagina='.$c->pagina : '?pagina=1';
$link .= (isset($c->busca) AND strlen($c->busca) > 0) ? '&busca='.$c->busca : '';
$link .= (isset($c->status) AND strlen($c->status) > 0) ? '&status='.$c->status : '';

$c = UTF_Encodes($c, 2);
$show_msgbox = 0;
?>
<script>
    menu(3,'bt-02');
    $('#titulo').html('cadastros &rsaquo;&rsaquo; franquias');
    $('#sub-08').css({'font-weight':'bold'});
</script>
<div class="content-list-forms">
    <form method="get">
        
        <dl>
            <legend>Buscar Franquias</legend>
            <dt>Pesquisar:</dt>
            <dd><input type="text" name="busca" id="busca" value="<?=(isset($c->busca)) ? utf8_encode($c->busca) : ''?>" placeholder="Pesquisar"></dd>
            <dt>Status:</dt>
            <dd>
                <select id="status" name="status" class="chzn-select">
                    <option value="">Status</option>
                    <?php 
                    $listar = $franquia->situacao(); 
                    foreach ($listar as $f) { ?>
                        <option value="<?=  utf8_encode($f->status)?>"<?=(isset($c->status) AND utf8_encode($f->status) == utf8_encode($c->status)) ? ' selected="selected"' : ''?>><?=utf8_encode($f->status)?></option>
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
AddRegistro('franquias-editar.php'.$link.'&id=0');
if($_GET){ 
    $listar = $franquia->listar(1, $c); ?>
    <?php if(count($listar) > 0){ ?>
        <div class="paginacao">
            <?php $franquia->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="buttons">#</th>
                    <th class="buttons size100">status</th>
                    <th>responsável</th>
                    <th>franquia</th>
                    <th class="buttons">usuários</th>
                    <th class="buttons">mensagens</th>
                    <th class="buttons">monitor.</th>
                    <th class="buttons">editar</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
                foreach ($listar as $f) { 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF';
                    $usuarios = $franquia->getQntUsuarios(1, $f->id_empresa, 0); ?>
                <tr <?=TRColor($color)?>>
                    <td class="buttons"><?=$f->id_empresa?></td>
                    <td class="buttons"><?= utf8_encode(ucwords(strtolower($f->status)))?></td>
                    <td><?= utf8_encode(ucwords(strtolower($f->nome)) . ' - ' . strtolower($f->email)) ?></td>
                    <td><?= utf8_encode(str_replace('Cartório Postal - ', '', ucwords(strtolower($f->fantasia)))) ?></td>
                    <td class="buttons">
                        <a href="usuarios-listar.php?id_empresa=<?= $f->id_empresa ?>"><img src="images/bt-users.png"></a>
			(<?= $usuarios ?>)</td>
                    <td class="buttons"><a href="franquias-msg.php<?=$link.'&id='.$f->id_empresa ?>"><img src="images/bt-message.png"></a></td>
                    <td class="buttons">
                        <?php if ($controle_depto_p[28] == 1) { ?>
                            <a href="franquias-monitoramento.php?login=<?= str_replace('@cartoriopostal.com.br', '', str_replace('diretoria.', '', strtolower($f->email))) ?>"><img src="images/bt-monitor.png"></a>
                        <?php } else { echo '&nbsp;'; } ?>
                    </td>
                    <td class="buttons"><a href="franquias-editar.php<?=$link.'&id='.$f->id_empresa ?>"><img src="images/bt-edit.png"></a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="paginacao">
            <?php $franquia->QTDPagina(); ?>
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