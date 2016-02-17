<?
require('header.php');
$permissao = verifica_permissao('Franquia', $controle_id_departamento_p, $controle_id_departamento_s);
if ($permissao == 'FALSE' or $controle_id_empresa != '1') {
    echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
    exit;
}
$permissao = verifica_permissao('Direcao', $controle_id_departamento_p, $controle_id_departamento_s);

$franquia = new FranquiasDAO();
$c = new stdClass();
if($_POST){ foreach($_POST as $cp => $valor){ $c->$cp = $valor; } }
if($_GET){ foreach($_GET as $cp => $valor){ $c->$cp = $valor; } } ?>
<form id="form1" name="form1" method="post" enctype="multipart/form-data">
<div id="topo">
    <h1 class="tit"><img src="../images/tit/tit_empresa.png" alt="Título" /> 
		Franquias 
		<a href="#" class="topo">topo</a> 
		<hr class="tit" />
	</h1>
</div>
<div id="meio">
<?if($c->id > 0){?>
	<div style="position: relative; width: 690px; margin: auto">
		Escolha a aba que deseja visualizar: 
		<select id="implatacacao" name="implatacacao" class="form_estilo" onchange="carregar_implantacao(this.value,<?=$c->id?>);">
			<option value="0" <?=($c->implatacacao == 0) ? ' selected="selected"' : ''?>>00 - Dados da Franquia</option>
			<option value="12" <?=($c->implatacacao == 12) ? ' selected="selected"' : ''?>>00 - Ficha dos Correios</option>
			<option value="13" <?=($c->implatacacao == 13) ? ' selected="selected"' : ''?>>00 - Contratos</option>
			<?if($c->id > 0){?>
				<option value="1" <?=($c->implatacacao == 1) ? ' selected="selected"' : ''?>>01 - Dados do Franqueado</option>
				<option value="2" <?=($c->implatacacao == 2) ? ' selected="selected"' : ''?>>02 - Documentação</option>
				<option value="3" <?=($c->implatacacao == 3) ? ' selected="selected"' : ''?>>03 - Informações sobre o ponto</option>
				<!--<option value="4">04 - Data de Aprovação</option>-->
				<option value="5" <?=($c->implatacacao == 5) ? ' selected="selected"' : ''?>>04 - Layouts</option>
				<option value="6" <?=($c->implatacacao == 6) ? ' selected="selected"' : ''?>>05 - Abertura da Empresa</option>
				<option value="7" <?=($c->implatacacao == 7) ? ' selected="selected"' : ''?>>06 - Faixa de CEPs</option>
				<option value="8" <?=($c->implatacacao == 8) ? ' selected="selected"' : ''?>>07 - Treinamento</option>
				<option value="9" <?=($c->implatacacao == 9) ? ' selected="selected"' : ''?>>08 - Checklist de Inauguração</option>
				<option value="10" <?=($c->implatacacao == 10) ? ' selected="selected"' : ''?>>09 - Início das Atividades</option>
				<option value="11" <?=($c->implatacacao == 11) ? ' selected="selected"' : ''?>>10 - Inauguração</option>
			<? } ?>
		</select> - <a id="bt_voltar" href="franquias-listar.php?status=<?=$c->status?>&busca=<?=$c->busca?>">Voltar</a>
		<input type="hidden" value="<?=$c->id?>" name="empresa" id="empresa" />
	</div><br style="clear:both" />
	<div id="errors" style="display:none;margin-left:20pxwidth: 690px;"></div>
	<div id="retorno" style="position:relative;width:690px;margin:auto;border:solid 1px #0D357D;padding:1px"></div>
	<? $c->implatacacao = (strlen($c->implatacacao) > 0) ? $c->implatacacao : 0;
	if($c->implatacacao == 13){
		if($_FILES['error'] == 0){
			$ext = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
			$nome = date('YmdHis').'.'.$ext;
			$diretorio .= '../uploads/'.$nome;
			if(move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretorio)){
				$franquia->upload_empresa(1,$c->empresa,$controle_id_usuario,$nome);
			}
		}
		if($c->id_upl > 0){
			$franquia->upload_empresa(3,$c->id,$controle_id_usuario,$c->id_upl);			
		}
	}?>
	<script>carregar_implantacao(<?=$c->implatacacao?>,<?=$c->id?>)</script>
<?}else{?>
	<div id="errors" style="display:none;margin-left:20pxwidth: 690px;"></div>
	<div id="retorno" style="position:relative;width:690px;margin:auto;border:solid 1px #0D357D;padding:1px"></div>
	<script>carregar_implantacao(0,0)</script>
<?}?>
</div>
<br /><br />
</form>
<? require('footer.php'); ?>