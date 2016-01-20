<? require('header.php');
$permissao = verifica_permissao('Franquia', $controle_id_departamento_p, $controle_id_departamento_s);
if ($permissao == 'FALSE' or $controle_id_empresa != '1') {
    echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
    exit;
}
$permissao = verifica_permissao('Direcao', $controle_id_departamento_p, $controle_id_departamento_s);
$franquia = new FranquiasDAO();
$c = new stdClass();
if($_POST){ foreach($_POST as $cp => $valor){ $c->$cp = $valor; } }
if($_GET){ foreach($_GET as $cp => $valor){ $c->$cp = $valor; } } 
if ($permissao == 'TRUE'){ ?> 
<form id="form1" name="form1" method="post" enctype="multipart/form-data">
<div id="topo">
    <h1 class="tit"><img src="../images/tit/tit_empresa.png" alt="Título" /> 
		Novas Franquias
		<label style="margin-left:30px"><strong>|</strong>&nbsp;&nbsp;&nbsp;&nbsp;<a href="franquias-listar.php">Franquias</a></label>
		<a href="#" class="topo">topo</a> 
		<hr class="tit" />
	</h1>
</div>
<div id="meio">
	<div class="busca1">
		<label>Pesquisar:</label> <input type="text" class="form_estilo" name="busca" id="busca" value="<?= $c->busca ?>" style="width:200px;" /> <br />
        <input type="submit" name="submit" class="button_busca" value=" Buscar " /><br />
	</div><br style="clear:both" />
	<div><div id="retorno"></div>
		<table width="100%" cellpadding="4" cellspacing="1" class="result_tabela">
		<?$dt = $franquia->listar(2, $c); $colspan = 6; 
		if(count($dt) > 0){ ?>
			<tr>
				<td colspan="<?=$colspan;?>" class="barra_busca"><? $franquia->QTDPagina(); ?></td>
			</tr>
			<tr>
				<td class="result_menu" style="background-color:#FFF;text-align:center;width:40px;"><b>Ficha</b></td>
				<td class="result_menu" style="background-color:#FFF;"><b>Responsável</b></td>
				<td class="result_menu" style="background-color:#FFF;"><b>Franquia</b></td>
				<td class="result_menu" style="background-color:#FFF;"><b>Atendente</b></td>
				<td class="result_menu" style="background-color:#FFF;text-align:center;width:100px;"><b>Data de Cadastro</b></td>
				<td class="result_menu" style="background-color:#FFF;text-align:center;width:60px;"><b>Ativar</b></td>
			</tr>
			<? foreach ($dt as $f) { 
				$usuarios = $franquia->getQntUsuarios(2, 0, $f->id_usuario); 
				$data = ($f->data_cad_updt != '0000-00-00') ? $f->data_cad_updt : $f->data;
				$data = explode('-',$data);
				$data = $data[2].'/'.$data[1].'/'.$data[0];?>
				<tr>
					<td align="center" class="result_celula"><?= $f->id_ficha?></td>
					<td class="result_celula"><?= ucwords(strtolower($f->nome)) . ' - ' . strtolower($f->email) ?></td>
					<td class="result_celula"><?= ucwords(strtolower($f->cidade_interesse)) . ' - ' . strtoupper($f->estado_interesse) ?></td>
					<td class="result_celula"><?= $usuarios?></td>
					<td align="center" class="result_celula"><?= $data?></td>
					<td align="center" class="result_celula"><img src="../images/tick.png" style="cursor:pointer" onclick="ativar_implantacao(<?= $f->id_ficha?>);" /></td>
				</tr>
				<? } ?>
				<tr>
					<td colspan="<?=$colspan;?>" class="barra_busca"><? $franquia->QTDPagina(); ?></td>
				</tr>
			<? } ?>
		</table>
	</div>
</div>
</form>
<? } else { echo '<br><br><br><br><strong>Você não tem permissão para acessar essa página</strong>'; } require('footer.php'); ?>