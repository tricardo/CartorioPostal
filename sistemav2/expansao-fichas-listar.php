<?php include('header.php'); 

$expansaoDAO = new ExpansaoDAO();

$permissao = verifica_permissao('EXPANSAO',$controle_id_departamento_p,$controle_id_departamento_s);
$permissao2 = verifica_permissao('Franquia', $controle_id_departamento_p, $controle_id_departamento_s);


if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

$exp_item = $expansaoDAO->verAcesso(1, $controle_id_empresa, $controle_id_usuario, 
	$controle_id_departamento_p, $controle_id_departamento_s, $controle_nome);


$arr = array('consultor','id_status','cidade','mes','nome','uf','ano','id_ficha');
$c = Post_StdClass($_GET);
for($i = 0; $i < count($arr); $i++){
    $c->$arr[$i] = isset($c->$arr[$i]) ? $c->$arr[$i] : '';
}
$c->pagina = isset($c->pagina) ? $c->pagina : 1;
$c->sem_consultor = 0;

$link = '';
$link .= (isset($c->pagina)) ? '?pagina='.$c->pagina : '?pagina=1';
$link .= (isset($c->busca) AND strlen($c->busca) > 0) ? '&busca='.$c->busca : '';
?>
<script>
    menu(3,'bt-03');
    $('#titulo').html('expansão &rsaquo;&rsaquo; fichas');
    $('#sub-21').css({'font-weight':'bold'});
</script>
<div class="content-list-forms">
    <form method="get">
        
        <dl>
            <legend>Buscar Ficha</legend>
            <dt>Consultor: </dt>
            <dd>
                <?php $expansaoDAO->carregar_consultor($exp_item, $c); ?>
            </dd>
            <dt>Nome: </dt>
            <dd>
                <input value="<?=$c->nome?>" type="text" name="nome" id="nome" placeholder="Nome">
            </dd>
            <dt>Status: </dt>
            <dd>
                <?php $expansaoDAO->carregar_status($exp_item, $c); ?>
            </dd>
            <dt>Nº Ficha: </dt>
            <dd>
                <input value="<?=$c->id_ficha?>" type="text" name="id_ficha" id="id_ficha">
            </dd>
            <dt>Estado:</dt>
            <dd>
                <select class="chzn-select required" name="uf" id="uf">
                    <option value="">Estado</option>
                    <?php $estado = UFs();
                    for($i = 0; $i < count($estado); $i++){ ?>
                            <option value="<?=$estado[$i]?>" <?=($estado[$i] == $c->uf) ? 'selected="selected"' : ''?>><?=$estado[$i]?></option>
                    <?php } ?>
                </select>
            </dd>
            <dt>Cidade:</dt>
            <dd>
                <input value="<?=$c->cidade?>" type="text" name="cidade" id="cidade" placeholder="Cidade">
            </dd>
            <dt>Mês:</dt>
            <dd>
                <select id="mes" name="mes" class="chzn-select">
                    <option value="">Mês</option>
                    <?php foreach(DataAno() AS $p => $f){ ?>
                        <option value="<?=$p?>"<?=$p==$c->mes ? ' selected="selected"' : ''?>><?=$f?></option>
                    <?php } ?>
                </select>
            </dd>
            <dt>Ano:</dt>
            <dd>
                <select id="ano" name="ano" class="chzn-select">
                    <option value="">Ano</option>
                    <?php foreach(DataAno(2) AS $p => $f){ ?>
                    <option value="<?=$p?>"<?=$p==$c->ano ? ' selected="selected"' : ''?>><?=$f?></option>
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
AddRegistro('expansao-fichas-editar.php'.$link.'&id_ficha=0');
if($_GET){ 
    $listar = $expansaoDAO->consulta($exp_item, $c); ?>
    <?php if(count($listar) > 0){ ?>
        <div class="paginacao">
            <?php $expansaoDAO->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="buttons">#</th>
                    <th class="buttons size100">cadastro</th>
                    <th class="buttons size150">status</th>
                    <th>nome</th>
                    <th>cidade/estado</th>
                    <th>consultor</th>
                    <th class="buttons">imprimir</th>
                    <th class="buttons">editar</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
                foreach ($listar as $res) { 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; ?>
                <tr <?=TRColor($color)?>>
                    <td class="buttons"><?=$res->id_ficha?></td>
                    <td class="buttons size100"><?=$res->data?></td>
                    <td class="buttons size150"><?=utf8_encode(ucwords($res->status))?></td>
                    <td><?=utf8_encode(ucwords($res->nome))?></td>
                    <td><?=utf8_encode(ucwords(substr($res->cidade,0,100)).' / '.$res->uf)?></td>
                    <td><?=utf8_encode($res->consultor)?></td>
                    <td class="buttons">
                        <a href="expansao-fichas-imprimir.php?id_ficha=<?=$res->id_ficha?>" target="_blank"><img src="images/bt-print.png"></a>
                    </td>
                    <td class="buttons">
                        <a href="expansao-fichas-editar.php?id_ficha=<?=$res->id_ficha?>"><img src="images/bt-edit.png"></a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="paginacao">
            <?php $expansaoDAO->QTDPagina(); ?>
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