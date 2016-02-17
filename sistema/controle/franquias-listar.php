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
<form id="form1" name="form1" method="post" enctype="multipart/form-data" action="franquias-listar.php">
<div id="topo">
    <h1 class="tit"><img src="../images/tit/tit_empresa.png" alt="Título" /> 
		Franquias
		<a href="#" class="topo">topo</a> 
		<hr class="tit" />
	</h1>
</div>
<div id="meio">
	<div class="busca1">
		<label>Pesquisar:</label> <input type="text" class="form_estilo" name="busca" value="<?= $c->busca ?>" style="width:200px;" /> <br />
		<label>Status:</label> <select class="form_estilo" id="status" name="status" style="width:200px;">
			<option value=""></option>
			<? $dt = $franquia->situacao(); 
				foreach ($dt as $f) { ?>
					<option value="<?=$f->status?>"<?=($f->status == $c->status) ? ' selected="selected"' : ''?>><?=$f->status?></option>
				<? } ?>
		</select><br />
        <input type="submit" name="submit" class="button_busca" value=" Buscar " />

		<? if ($permissao == 'TRUE'){ ?>
			<br /><br /><h3><a href="franquias_editar.php?id=0"><img src="../images/botao_add.png" border="0" /> Adicionar novo registro</a></h3><? } ?>
	</div><br style="clear:both" />
	<div>
		<table width="100%" cellpadding="4" cellspacing="1" class="result_tabela">
		<? $dt = $franquia->listar(1, $c);
			$colspan = ($controle_depto_p[28] == 1) ? 7 : 6;
			if(count($dt) > 0){ ?>
			<tr>
				<td colspan="<?=$colspan?>" class="barra_busca"><? $franquia->QTDPagina(); ?></td>
			</tr>
			<tr>
                <td class="result_menu" style="background-color:#FFF"><b>Unidade</b></td>
				<td class="result_menu" style="background-color:#FFF"><b>Responsável</b></td>
				<td class="result_menu" style="background-color:#FFF;text-align:center;width:80px;"><b>Usuários</b></td>
				<td class="result_menu" style="background-color:#FFF;text-align:center;width:80px;"><b>Status</b></td>
				<td class="result_menu" style="background-color:#FFF;text-align:center;width:80px;"><b>Editar</b></td>
				<td class="result_menu" style="background-color:#FFF;text-align:center;width:80px;"><b>Mensagens</b></td>
				<? if ($controle_depto_p[28] == 1) { ?>
					<td class="result_menu" style="background-color:#FFF;text-align:center;width:80px;"><b>Monitoramento</b></td>
				<? } ?>
			</tr>
			<? foreach ($dt as $f) { 
				$usuarios = $franquia->getQntUsuarios(1, $f->id_empresa, 0); ?>
				<tr>
                    <td class="result_celula"><?= str_replace('Cartório Postal - ', '', ucwords(strtolower($f->fantasia))) ?></td>
                    <td class="result_celula"><?= ucwords(strtolower($f->nome)) . ' - ' . strtolower($f->email) ?></td>
					<td class="result_celula" align="center">
						<a href="usuario.php?id_empresa=<?= $f->id_empresa ?>">
							<img src="../images/icon/icon_cliente.png" alt="Título" border="0" /></a>
						<?= $usuarios ?>
					</td>
					<td class="result_celula" align="center"><?=ucwords(strtolower($f->status)) ?></td>
					<td class="result_celula" align="center">
						<a href="franquias_editar.php?id=<?= $f->id_empresa ?>&status=<?=$c->status?>&busca=<?=$c->busca?>">
							<img src="../images/botao_editar.png" title="Editar" border="0" />
						</a>
					</td>
					<td class="result_celula" align="center">
						<a href="empresa_msg.php?id_empresa=<?= $f->id_empresa ?>"><img src="../images/botao_editar.png" title="Mensagens" border="0" /></a>
					</td>
					<? if ($controle_depto_p[28] == 1) { ?>
						<td class="result_celula" align="center">
							<a href="login_vai_admin.php?login=<?= str_replace('@cartoriopostal.com.br', '', str_replace('diretoria.', '', strtolower($f->email))) ?>">
								<img src="../images/botao_editar.png" title="Mensagens" border="0" /></a>
						</td>
					<? } ?>
				</tr>
				<? } ?>
				<tr>
					<td colspan="<?=$colspan?>" class="barra_busca"><? $franquia->QTDPagina(); ?></td>
				</tr>
			<? } ?>
		</table>
	</div>
</div>
</form>
<? require('footer.php'); ?>