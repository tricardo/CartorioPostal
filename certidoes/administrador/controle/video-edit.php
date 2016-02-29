<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'galeria_videos';
$title_pg = 'Editar: Vídeos';
require_once('../includes/header.php');
pt_register('GET','id');
pt_register('POST','submit1');
pt_register('POST','st_id');
pt_register('POST','id_cat_video');
pt_register('POST','descricao_video');
pt_register('POST','video');
if($submit1){
	if($errors!=1){
		$objQuery->SQLQuery("UPDATE cp_video SET st_id='$st_id', id_cat_video='$id_cat_video', descricao_video='$descricao_video', video='$video' WHERE id_video='$id'");
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
						EDITAR NOVO VÍDEO
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
					$sql = $objQuery->SQLQuery("SELECT cv.id_cat_video, cv.imagem_video, v.id_video, v.st_id, v.descricao_video, v.video FROM cp_cat_video as cv, cp_video as v WHERE v.id_cat_video=cv.id_cat_video AND v.id_video='" .$id. "'");
					$res = mysql_fetch_array($sql);
					$id_video			= $res['id_video'];
					$id_cat_video		= $res['id_cat_video'];
					$st_id				= $res['st_id'];
					$descricao_video	= $res['descricao_video'];
					$video				= $res['video'];
					$imagem_video		= $res['imagem_video'];
				?>
				<div id="image_erro">
					<? if($imagem_video==""){?>
					<img src="../images/paginas/image-remove-edit.png" alt="image-remove" />
					<? }else{ ?>
					<img src="../../upload/<? echo $imagem_video;?>" width="106" alt="" />
					<?}?>
				</div>
				<!--/fomulário:permissao-edit/-->
				<form name="form" action="" method="post" enctype="multipart/form-data">
					<!--/tabela:lado-right/-->
					<table width="100%">
						<tr>
							<td colspan="2"><label for="titulo" accesskey="1">Título da categoria</label></td>
						</tr>
						<tr>
							<td colspan="2">
								<select name="id_cat_video" id="id_cat_video" >
								<option value="">---</option>
								<?
								$sql = $objQuery->SQLQuery("SELECT * FROM cp_cat_video as cv WHERE cv.st_id='1' ORDER BY cv.id_cat_video");
								while($res = mysql_fetch_array($sql)){
									echo '<option value="'.$res['id_cat_video'].'"';
									if($id_cat_video==$res['id_cat_video']) echo 'selected="selected"'; 
									echo '>'.$res['nome_video'].'</option>';
								}
								?>
								</select>
							</td>
						</tr>
						<tr>
							<td><label for="descricao_video" accesskey="1">Descrição do vídeo</label></td>
						</tr>
						<tr>
							<td><input name="descricao_video" type="text" id="descricao" value="<?= $descricao_video;?>" /></td>
						</tr>
						<tr>
							<td><label for="videos1" accesskey="1">Vídeo</label></td>
						</tr>
						<td colspan="2">
							<textarea id="campo1" name="video" onkeyup="mostrarResultado(this.value,800,'spcontando1');contarCaracteres(this.value,800,'sprestante1','campo1')" ><?= $video;?></textarea><br>
							<span id="spcontando1">Ainda não temos nada digitado..</span><br />
							<span id="sprestante1"></span><br><br>
						</td>
						<tr>
							<td><?echo $video;?></td>
						</tr>
						<tr>
							<td colspan="2"><label for="status" accesskey="3">Status</label></td>
						</tr>
						<tr>
							<td colspan="2">
								<select name="st_id" id="status">
								<?
								$sql = $objQuery->SQLQuery("SELECT * FROM cp_status as st ORDER BY st.st_id");
								while($res = mysql_fetch_array($sql)){
									echo '<option value="'.$res['st_id'].'"';
									if($st_id==$res['st_id']) echo 'selected="selected"'; 
									echo '>'.$res['status'].'</option>';
								}
								?>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="6"><input name="submit1" type="submit" value="Atualizar" title="Clique aqui para atualizar o cadastro" /></td>
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
					echo '<meta HTTP-EQUIV="refresh" CONTENT="2; URL=video-list.php" />';
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