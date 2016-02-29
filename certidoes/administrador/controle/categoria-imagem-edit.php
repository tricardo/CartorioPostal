<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'galeria_imagens';
$title_pg = 'Editar: Categoria';
require_once('../includes/header.php');
pt_register('GET','id');
pt_register('POST','submit1');
pt_register('POST','st_id');
pt_register('POST','nome_imagem');
pt_register('POST','url_amigavel');
pt_register('POST','chave');
pt_register('POST','descricao');
pt_register('POST','cat_imagem');
pt_register('POST','id_empresa');
if(isset($_POST['acao']) && $_POST['acao']=="cadastrar"){
	if($submit1){
		if($errors!=1){
			if(isset($_FILES['cat_imagem']) && $_FILES['cat_imagem']['name'] != null){
				$cat_imagem = $_FILES['cat_imagem'];
				$redim = new Redimensiona();
				$images = array(600);
				$thumbmail = array();
				$folder = "../../upload/";
				for($i = 0; $i < count($images); $i++){
					$thumbmail[$i] = $redim->Redimensionar($cat_imagem, $images[$i], $folder);
					$campo_img = str_replace("/","",str_replace($folder,'',$thumbmail[$i]));
					$sql = "UPDATE cp_cat_imagem SET st_id='$st_id', nome_imagem='$nome_imagem', ";
					$sql .= "url_amigavel='$url_amigavel', chave='$chave', descricao='$descricao', id_empresa='$id_empresa',";
					$sql .= "cat_imagem='".$campo_img."' ";
					$sql .= "WHERE id_cat_imagem='$id'";
					$objQuery->SQLQuery($sql);
					$id = $objQuery->ID;
					$done=1;
				}
			} else {
				$sql = "UPDATE cp_cat_imagem SET st_id='$st_id', nome_imagem='$nome_imagem', ";
				$sql .= "url_amigavel='$url_amigavel', chave='$chave', descricao='$descricao', id_empresa='$id_empresa'";
				$sql .= "WHERE id_cat_imagem='$id'";
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
					$sql = $objQuery->SQLQuery("SELECT ci.id_cat_imagem, ci.st_id, ci.nome_imagem, ci.url_amigavel, ci.chave, ci.descricao, ci.cat_imagem, ue.id_empresa, st.st_id, st.status FROM cp_cat_imagem as ci, cp_status as st, cartorio_banco2.vsites_user_empresa as ue WHERE ci.id_empresa=ue.id_empresa AND ue.status!='Cancelado' AND ci.st_id=st.st_id AND ci.id_cat_imagem='" .$id. "'");
					$res = mysql_fetch_array($sql);
					$st_id			= $res['st_id'];
					$nome_imagem	= $res['nome_imagem'];
					$url_amigavel	= $res['url_amigavel'];
					$chave			= $res['chave'];
					$descricao		= $res['descricao'];
					$cat_imagem		= $res['cat_imagem'];
					$id_empresa		= $res['id_empresa'];
				?>
				<div id="image_erro">
					<? if($res['cat_imagem']==""){?>
					<img src="../images/paginas/image-remove-edit.png" alt="image-remove" />
					<? }else{ ?>
					<img src="../../upload/<? echo $res['cat_imagem'];?>" width="150" alt="" />
					<?}?>
				</div>
				<!--/fomulário:permissao-edit/-->
				<form name="form" action="" method="post" enctype="multipart/form-data">
					<!--/tabela:lado-right/-->
					<table width="100%">
						<tr>
							<td colspan="2"><label for="id_empresa" accesskey="1">Nome da unidade</label></td>
						</tr>
						<tr>
							<td colspan="2">
								<select name="id_empresa" id="id_empresa" <?=($errors['id_empresa'])?'style="border:1px solid #FF0000;"':''; ?> >
								<option value="">---</option>
								<?
								$objQuery->classQueryMulti(1);
								$sql = $objQuery->SQLQuery("SELECT ue.id_empresa, ue.fantasia, ue.status FROM vsites_user_empresa as ue WHERE ue.status!='Cancelado' ORDER BY ue.fantasia ASC");
								while($res = mysql_fetch_array($sql)){
									echo '<option value="'.$res['id_empresa'].'"';
									if($id_empresa==$res['id_empresa']) echo 'selected="selected"'; 
									echo '>'.str_replace('Cartório Postal - ','',$res['fantasia']).'</option>';
								}
								?>
								</select>
							</td>
						</tr>
						<tr>
							<td><label for="nome_imagem" accesskey="1">Nome da categoria</label></td>
							<td><label for="url_amigavel" accesskey="2">URL amigável</label></td>
						</tr>
						<tr>
							<td><input name="nome_imagem" type="text" id="nome_imagem" value="<?= $nome_imagem;?>" /></td>
							<td><input name="url_amigavel" type="text" id="url_amigavel" value="<?= $url_amigavel;?>" /></td>
						</tr>
						<tr>
							<td colspan="2"><label for="campo1" accesskey="3">Chave</label></td>
						</tr>
						<tr>
							<td colspan="2">
								<textarea name="chave" id="campo1" cols="" rows="" onkeyup="mostrarResultado(this.value,500,'spcontando1');contarCaracteres(this.value,500,'sprestante1','campo1')" ><?= $chave;?></textarea>
								<span id="spcontando1">Ainda não temos nada digitado..</span><br />
								<span id="sprestante1"></span>
							</td>
						</tr>
						<tr>
							<td colspan="2"><label for="campo2" accesskey="4">Descrição</label></td>
						</tr>
						<tr>
							<td colspan="2">
								<textarea name="descricao" id="campo2" cols="" rows="" onkeyup="mostrarResultado(this.value,200,'spcontando2');contarCaracteres(this.value,200,'sprestante2','campo2')" ><?= $descricao;?></textarea>
								<span id="spcontando2">Ainda não temos nada digitado..</span><br />
								<span id="sprestante2"></span>
							</td>
						</tr>
						<tr>
							<td colspan="2"><label for="cat_imagem" accesskey="5">Imagem</label></td>
						</tr>
						<tr>
							<td colspan="2"><input name="cat_imagem" type="file" id="cat_imagem" style="width:100%;" /></td>
						</tr>
						<tr>
							<td colspan="2"><label for="status" accesskey="3">Status</label></td>
						</tr>
						<tr>
							<td colspan="2">
								<select name="st_id" id="status">
								<?
								$objQuery->classQueryMulti(2);
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
					echo '<meta HTTP-EQUIV="refresh" CONTENT="2; URL=categoria-imagem-list.php" />';
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