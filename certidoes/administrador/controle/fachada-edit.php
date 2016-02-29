<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'galeria_imagens';
$title_pg = 'Editar: Fachada';
require_once('../includes/header.php');
pt_register('GET','id');
pt_register('POST','submit1');
pt_register('POST','id_empresa');
pt_register('POST','imagem');
pt_register('POST','status');
if(isset($_POST['acao']) && $_POST['acao']=="cadastrar"){
	if($submit1){
		if($errors!=1){
			if(isset($_FILES['imagem']) && $_FILES['imagem']['name'] != null){
				$imagem = $_FILES['imagem'];
				$redim = new Redimensiona();
				$images = array(640);
				$thumbmail = array();
				$folder = "../../upload/";
				for($i = 0; $i < count($images); $i++){
					$thumbmail[$i] = $redim->Redimensionar($imagem, $images[$i], $folder);
					$campo_img = str_replace("/","",str_replace($folder,'',$thumbmail[$i]));
					$sql = "UPDATE vsites_user_empresa SET id_empresa='$id_empresa', ";
					$sql .= "imagem='".$campo_img."' ";
					$sql .= "WHERE id_empresa='$id'";
					$t = $objQuery->classQueryMulti(1);
					$objQuery->SQLQuery($sql);
					$id = $objQuery->ID;
					$done=1;
				}
			} else {
				$sql = "UPDATE vsites_user_empresa SET id_empresa='$id_empresa'";
				$sql .= "WHERE id_empresa='$id'";
				$objQuery->classQueryMulti(1);
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
						EDITAR FACHADA
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
					$objQuery->classQueryMulti(1);
					$sql = $objQuery->SQLQuery("SELECT ue.id_empresa, ue.imagem FROM vsites_user_empresa as ue WHERE ue.id_empresa='" .$id. "'");
					$res = mysql_fetch_array($sql);
					$id_empresa			= $res['id_empresa'];
					$imagem				= $res['imagem'];
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
							<td colspan="2"><label for="id_empresa" accesskey="1">Empresa</label></td>
						</tr>
						<tr>
							<td colspan="2">
								<select name="id_empresa" id="id_empresa" >
								<option value="">---</option>
								<?
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
							<td><label for="imagem" accesskey="2">Imagem</label></td>
						</tr>
						<tr>
							<td><input name="imagem" type="file" id="imagem" tabindex="2" style="width:100%;" /></td>
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
					echo '<meta HTTP-EQUIV="refresh" CONTENT="2; URL=fachada-list.php" />';
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