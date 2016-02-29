<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'treinadores';
$title_pg = 'Editar: Treinadores';
require_once('../includes/header.php');
pt_register('GET','id');
pt_register('POST','submit1');
pt_register('POST','treinador');
pt_register('POST','area');
pt_register('POST','status');
	if($submit1){
		if($errors!=1){
			$objQuery->SQLQuery("UPDATE site_treinadores SET treinador='$treinador', area='$area', status='$status' WHERE id_treinador='$id'");
			$id = $objQuery->ID;
			$done=1;
		}
	}
?>
<div class="estrutura">
	<div class="conteudo">
		<div class="fundo_menu_add">
			<div class="title_page">
				<!--/tabela:icone-titulo/-->
				<table width="100%" align="center" cellspacing="0" cellpadding="0">
					<tr>
						<td width="10%" align="left" valign="middle">
							<img src="../images/paginas/icon-editar.png" alt="icon-editar" />
						</td>
						<td width="90%" align="left" valign="middle">
							<span style="margin-left:5px;"><?= $title_pg?></span>
						</td>
					</tr>
				</table>
				<!--/tabela:fim/-->
			</div>
			<div class="prev">
				<a href="#" title="Clique aqui para voltar" class="prev"><img src="../images/paginas/anterior.png" alt="anterior" /></a>
			</div>
				<? require_once('menu-list.php'); ?>
			<div class="next">
				<a href="#" title="Clique aqui para avançar" class="next"><img src="../images/paginas/proximo.png" alt="proximo" /></a>
			</div>
		</div>
		<div class="pages">
			<!--/tabela:adicionar-usuário/-->
			<table width="1000" class="table_info">
				<tr>
					<th align="center" valign="middle" colspan="6">
						EDITAR NOVA IMAGEM
					</th>
				</tr>
				<td align="center" valign="top" class="td_info">
					<!--/tabela:lado-left/-->
					<table width="100%">
						<tr>
							<td align="center" valign="middle" width="5%">
								<img src="../images/paginas/undo.png" alt="undo" align="center" />
							</td>
							<td align="left" valign="middle" width="50%">
								<a href="javascript:history.back()" title="Clique aqui" class="link_normal">Voltar para página anterior</a>
							</td>
						</tr>
					</table>
					<!--/tabela:fim/-->
				</td>
				<!--/divisão/-->
				<td align="center" valign="top" class="td_info" width="75%">
				<?
				if($done!=1){
					$sql = $objQuery->SQLQuery("SELECT * FROM site_treinadores as tr WHERE tr.id_treinador='" .$id. "'");
					$res = mysql_fetch_array($sql);
					$id_treinador	= $res['id_treinador'];
					$treinador		= $res['treinador'];
					$area			= $res['area'];
					$status			= $res['status'];
				?>
				<!--/fomulário:permissao-edit/-->
				<form name="form" action="" method="post" enctype="multipart/form-data">
					<!--/tabela:lado-right/-->
					<table width="100%">
						<tr>
							<td><label for="treinador" accesskey="1">Treinador(a)</label></td>
							<td><label for="area" accesskey="2">Área</label></td>
						</tr>
						<tr>
							<td><input name="treinador" type="text" id="treinador" tabindex="1" value="<?= $treinador?>" /></td>
							<td><input name="area" type="text" id="area" tabindex="1" value="<?= $area?>" /></td>
						</tr>
						<tr>
							<td colspan="2"><label for="status" accesskey="3">Status</label></td>
						</tr>
						<tr>
							<td colspan="2">
								<select name="status" id="status" tabindex="2" title="Selecione um status">
								<?
								$sql = $objQuery->SQLQuery("SELECT * FROM cp_status as us ORDER BY us.st_id");
								while($res = mysql_fetch_array($sql)){
									echo '<option value="'.$res['status'].'"';
									if($status==$res['status']) echo 'selected="selected"'; 
									echo '>'.$res['status'].'</option>';
								}
								?>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="6"><input name="submit1" type="submit" value="Atualizar" title="Clique aqui para atualizar o cadastro" tabindex="3" /></td>
						</tr>
					</table>
					<!--/tabela:fim/-->
				</form>
				<!--/fomulário:fim/-->
				<?
				}
				?>
				<?
				if($done){
					echo '<div id="load"><img src="../images/paginas/load.gif" alt="load" width="28" /></div>
						<img src="../images/paginas/resposta-atualizacao.png" alt="resposta-atualizacao" />';
					echo '<meta HTTP-EQUIV="refresh" CONTENT="2; URL=treinadores-list.php" />';
				}
				?>
				</td>
				<tr>
					<td colspan="2" class="th_info"></td>
				</tr>
			</table>
			<!--/tabela:fim/-->
		</div>
	</div>
</div>
<?
require_once('../includes/footer.php');
?>