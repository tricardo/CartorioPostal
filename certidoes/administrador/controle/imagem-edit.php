<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'galeria_imagens';
$title_pg = 'Editar: Imagens';
require_once('../includes/header.php');
pt_register('GET','id');
pt_register('POST','submit1');
pt_register('POST','st_id');
pt_register('POST','id_cat_imagem');
pt_register('POST','id_empresa');
pt_register('POST','imagem');
pt_register('POST','descricao');
if(isset($_POST['acao']) && $_POST['acao']=="cadastrar"){
	if($submit1){
		if($errors!=1){
			if(isset($_FILES['imagem']) && $_FILES['imagem']['name'] != null){
				$imagem = $_FILES['imagem'];
				$redim = new Redimensiona();
				$images = array(800);
				$thumbmail = array();
				$folder = "../../upload/";
				for($i = 0; $i < count($images); $i++){
					$thumbmail[$i] = $redim->Redimensionar($imagem, $images[$i], $folder);
					$campo_img = str_replace("/","",str_replace($folder,'',$thumbmail[$i]));
					$sql = "UPDATE cp_imagem SET st_id='$st_id', id_cat_imagem='$id_cat_imagem', id_empresa='$id_empresa', descricao='$descricao', ";
					$sql .= "imagem='".$campo_img."' ";
					$sql .= "WHERE id_imagem='$id'";
					$objQuery->SQLQuery($sql);
					$id = $objQuery->ID;
					$done=1;
				}
			} else {
				$sql = "UPDATE cp_imagem SET st_id='$st_id', id_cat_imagem='$id_cat_imagem', id_empresa='$id_empresa', descricao='$descricao'";
				$sql .= "WHERE id_imagem='$id'";
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
					$sql = $objQuery->SQLQuery("SELECT ci.id_cat_imagem, ue.id_empresa, ue.fantasia, im.id_imagem, im.id_empresa, im.imagem, im.descricao, st.st_id, st.status FROM cp_cat_imagem as ci, cp_imagem as im, cp_status as st, cartorio_banco2.vsites_user_empresa as ue WHERE ci.id_cat_imagem=im.id_cat_imagem AND im.id_empresa=ue.id_empresa AND ue.status!='Cancelado' AND im.st_id=st.st_id AND im.id_imagem='" .$id. "'");
					$res = mysql_fetch_array($sql);
					$id_imagem			= $res['id_imagem'];
					$st_id				= $res['st_id'];
					$id_cat_imagem		= $res['id_cat_imagem'];
					$id_empresa			= $res['id_empresa'];
					$imagem				= $res['imagem'];
					$descricao			= $res['descricao'];
				?>
				<div id="image_erro">
					<? if($res['imagem']==""){?>
					<img src="../images/paginas/image-remove-edit.png" alt="image-remove" />
					<? }else{ ?>
					<img src="../../upload/<? echo $res['imagem'];?>" width="200" alt="" />
					<?}?>
				</div>
				<!--/fomulário:permissao-edit/-->
				<form name="form" action="" method="post" enctype="multipart/form-data">
					<!--/tabela:lado-right/-->
					<table width="100%">
						<tr>
							<td><label for="id_cat_imagem" accesskey="1">Nome da categoria</label></td>
							<td><label for="id_empresa" accesskey="1">Nome da unidade</label></td>
						</tr>
						<tr>
							<td>
								<select name="id_cat_imagem" id="id_cat_imagem" <?=($errors['id_cat_imagem'])?'style="border:1px solid #FF0000;"':''; ?> >
								<option value="">---</option>
								<?
								$sql = $objQuery->SQLQuery("SELECT ci.id_cat_imagem, ci.nome_imagem FROM cp_cat_imagem as ci ORDER BY ci.id_cat_imagem DESC");
								while($res = mysql_fetch_array($sql)){
									echo '<option value="'.$res['id_cat_imagem'].'"';
									if($id_cat_imagem==$res['id_cat_imagem']) echo 'selected="selected"'; 
									echo '>'.$res['nome_imagem'].'</option>';
								}
								?>
								</select>
							</td>
							<td>
								<select name="id_empresa" id="id_empresa" <?=($errors['id_empresa'])?'style="border:1px solid #FF0000;"':''; ?> >
								<option value="">---</option>
								<?
								$objQuery->classQueryMulti(1);
								$sql = $objQuery->SQLQuery("SELECT ue.id_empresa, ue.fantasia, ue.status FROM vsites_user_empresa as ue WHERE ue.status!='Cancelado' ORDER BY ue.id_empresa DESC");
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
							<td colspan="2"><label for="imagem" accesskey="5">Imagem</label></td>
						</tr>
						<tr>
							<td colspan="2"><input name="imagem" type="file" id="imagem" style="width:100%;" /></td>
						</tr>
						<tr>
							<td colspan="2"><label for="campo1" accesskey="4">Descrição</label></td>
						</tr>
						<tr>
							<td colspan="2">
								<textarea name="descricao" id="campo1" cols="" rows="" onkeyup="mostrarResultado(this.value,200,'spcontando3');contarCaracteres(this.value,200,'sprestante3','campo1')" ><?= $descricao;?></textarea>
								<span id="spcontando3">Ainda não temos nada digitado..</span><br />
								<span id="sprestante3"></span>
							</td>
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
					echo '<meta HTTP-EQUIV="refresh" CONTENT="2; URL=imagem-list.php" />';
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