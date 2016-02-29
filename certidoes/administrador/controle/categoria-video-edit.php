<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'galeria_videos';
$title_pg = 'Editar: Categoria';
require_once('../includes/header.php');
pt_register('GET','id');
pt_register('POST','submit1');
pt_register('POST','st_id');
pt_register('POST','nome_video');
pt_register('POST','url_amigavel');
pt_register('POST','chave');
pt_register('POST','descricao');
pt_register('POST','imagem_video');
if(isset($_POST['acao']) && $_POST['acao']=="cadastrar"){
	if($submit1){
		if($errors!=1){
			if(isset($_FILES['imagem_video']) && $_FILES['imagem_video']['name'] != null){
				$imagem_video = $_FILES['imagem_video'];
				$redim = new Redimensiona();
				$images = array(800);
				$thumbmail = array();
				$folder = "../../upload/";
				for($i = 0; $i < count($images); $i++){
					$thumbmail[$i] = $redim->Redimensionar($imagem_video, $images[$i], $folder);
					$campo_img = str_replace("/","",str_replace($folder,'',$thumbmail[$i]));
					$sql = "UPDATE cp_cat_video SET st_id='$st_id', nome_video='$nome_video', ";
					$sql .= "url_amigavel='$url_amigavel', chave='$chave', descricao='$descricao', ";
					$sql .= "imagem_video='".$campo_img."' ";
					$sql .= "WHERE id_cat_video='$id'";
					$objQuery->SQLQuery($sql);
					$id = $objQuery->ID;
					$done=1;
				}
			} else {
				$sql = "UPDATE cp_cat_video SET st_id='$st_id', nome_video='$nome_video', ";
				$sql .= "url_amigavel='$url_amigavel', chave='$chave', descricao='$descricao' ";
				$sql .= "WHERE id_cat_video='$id'";
				$objQuery->SQLQuery($sql);
				$id = $objQuery->ID;
				$done=1;
			}
		}
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
						EDITAR NOVA CATEGORIA
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
					$sql = $objQuery->SQLQuery("SELECT cv.id_cat_video, cv.st_id, cv.nome_video, cv.url_amigavel, cv.chave, cv.descricao, cv.imagem_video FROM cp_cat_video as cv WHERE cv.id_cat_video='" .$id. "'");
					$res = mysql_fetch_array($sql);
					$st_id	= $res['st_id'];
				?>
				<div id="image_erro">
					<? if($res['imagem_video']==""){?>
					<img src="../images/paginas/image-remove-edit.png" alt="image-remove" />
					<? }else{ ?>
					<img src="../../upload/<? echo $res['imagem_video'];?>" width="100" alt="" />
					<?}?>
				</div>
				<!--/fomulário:permissao-edit/-->
				<form name="form" action="" method="post" enctype="multipart/form-data">
					<!--/tabela:lado-right/-->
					<table width="100%">
						<tr>
							<td><label for="nome_video" accesskey="1">Nome da categoria</label></td>
							<td><label for="url_amigavel" accesskey="2">URL amigável</label></td>
						</tr>
						<tr>
							<td><input name="nome_video" type="text" id="nome_video" value="<?= $res['nome_video'];?>" /></td>
							<td><input name="url_amigavel" type="text" id="url_amigavel" value="<?= $res['url_amigavel'];?>" /></td>
						</tr>
						<tr>
							<td colspan="2"><label for="campo1" accesskey="3">Chave</label></td>
						</tr>
						<tr>
							<td colspan="2">
								<textarea name="chave" id="campo1" cols="" rows="" onkeyup="mostrarResultado(this.value,500,'spcontando1');contarCaracteres(this.value,500,'sprestante1','campo1')" ><?= $res['chave'];?></textarea>
								<span id="spcontando1">Ainda não temos nada digitado..</span><br />
								<span id="sprestante1"></span>
							</td>
						</tr>
						<tr>
							<td colspan="2"><label for="campo2" accesskey="4">Descrição</label></td>
						</tr>
						<tr>
							<td colspan="2">
								<textarea name="descricao" id="campo2" cols="" rows="" onkeyup="mostrarResultado(this.value,200,'spcontando2');contarCaracteres(this.value,200,'sprestante2','campo2')" ><?= $res['descricao'];?></textarea>
								<span id="spcontando2">Ainda não temos nada digitado..</span><br />
								<span id="sprestante2"></span>
							</td>
						</tr>
						<tr>
							<td colspan="2"><label for="imagem_video" accesskey="5">Imagem</label></td>
						</tr>
						<tr>
							<td colspan="2"><input name="imagem_video" type="file" id="imagem_video" style="width:100%;" /></td>
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
							<td colspan="6">
								<input name="submit1" type="submit" value="Atualizar" title="Clique aqui para atualizar o cadastro" />
								<input type="hidden" name="acao" value="cadastrar" />
							</td>
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
					echo '<meta HTTP-EQUIV="refresh" CONTENT="2; URL=categoria-video-list.php" />';
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