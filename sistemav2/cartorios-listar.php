<?php include('header.php'); 

$permissao = verifica_permissao('Cartorio',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

$cartorioDAO = new CartorioDAO();


$c = Post_StdClass($_GET);
$c->atribuicao = isset($c->atribuicao) ? $c->atribuicao : '';
$c->estado = isset($c->estado) ? $c->estado : '';
$c->cidade = isset($c->cidade) ? $c->cidade : '';
$c->pagina = isset($c->pagina) ? $c->pagina : 1;

$link = '';
$link .= '?pagina='.$c->pagina;
$link .= strlen($c->atribuicao) > 0 ? '&atribuicao='.$c->atribuicao : '';
$link .= strlen($c->estado) > 0 ? '&estado='.$c->estado : '';
$link .= strlen($c->cidade) > 0 ? '&cidade='.$c->cidade : '';

$c = UTF_Encodes($c, 2);
$show_msgbox = 0;
?>
<script>
    menu(3,'bt-02');
    $('#titulo').html('cadastros &rsaquo;&rsaquo; cartórios');
    $('#sub-13').css({'font-weight':'bold'});
</script>
<div class="content-list-forms">
    <form method="get">
        
        <dl>
            <legend>Buscar Cartórios</legend>
            <dt>Atribuição:</dt>
            <dd>
                <select name="atribuicao" id="atribuicao" class="chzn-select">
                    <option value="">Atribuição</option>
                    <?php $atribuicoes = $cartorioDAO->listaAtribuicoes();
                    foreach($atribuicoes as $atr){
                        echo '<option value="'.$atr->id_atribuicao.'" '.
                        (($c->atribuicao==$atr->id_atribuicao)?' selected="selected"':'').'>';
                        echo utf8_encode($atr->atribuicao).'</option>';
                    }
                    ?>
		</select>
            </dd>
            <dt>Estado:</dt>
            <dd>
                <select name="estado" id="estado" class="chzn-select" onchange="carregar_cartorio_cidade('atribuicao', this.value, 'cidade','cid_valor')">
			<option value="">Estado</option>
			<?php $estados = $cartorioDAO->listaEstados();
			$p_valor='';
			foreach($estados as $uf){
                            $p_valor.='<option value="'.$uf->estado.'" ';
                            $p_valor.=($c->estado==$uf->estado)?' selected ':'';
                            $p_valor.= '>'.utf8_encode(strtoupper($uf->estado)).'</option>';
			}
			echo $p_valor;
			?>
                </select>
            </dd>
            <dt>Cidade:</dt>
            <dd>
                <select name="cidade" id="cidade" class="chzn-select">
                    <option value="">Cidade</option>
                </select>
                <input type="hidden" value="<?=$c->cidade?>" name="cid_valor" id="cid_valor">
                <script>carregar_cartorio_cidade('atribuicao', $('#estado option:selected').val(), 'cidade','cid_valor')</script>
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
    AddRegistro('clientes-editar.php'.$link.'&id_cartorio=0');
}

if($_GET){ 
    $cartorioDAO = new CartorioDAO();
    $listar = $cartorioDAO->buscar($c->atribuicao,$c->estado,$c->cidade,$c->pagina); 
    ?>
    <?php if(count($listar) > 0){ ?>
        <div class="paginacao">
            <?php $cartorioDAO->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="buttons">#</th>
                    <th class="buttons size100">status</th>
                    <th>cartório</th>
                    <th>atribuição</th>
                    <th>comarca</th>
                    <th>distrito</th>
                    <th>cidade</th>
                    <th class="buttons">estado</th>
                    <th class="buttons">editar</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
                foreach ($listar as $f) { 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; ?>
                <tr <?=TRColor($color)?>>
                    <td class="buttons"><?=$f->id_cartorio?></td>
                    <td class="buttons size100"><?=utf8_encode($f->status)?></td>
                    <td><?=utf8_encode($f->nome)?></td>
                    <td><?=utf8_encode($f->atrib)?></td>
                    <td><?=utf8_encode($f->comarca)?></td>
                    <td><?=utf8_encode($f->distrito)?></td>
                    <td><?=utf8_encode($f->cidade)?></td>
                    <td class="buttons"><?=utf8_encode($f->estado)?></td>
                    <td class="buttons"><a href="cartorios-editar.php<?=$link.'&id_cartorio='.$f->id_cartorio ?>"><img src="images/bt-edit.png"></a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="paginacao">
            <?php $cartorioDAO->QTDPagina(); ?>
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