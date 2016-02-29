<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'news';
$title_pg = 'Editar: Nova notícia';
require_once('../includes/header.php');
require_once('../js/fckeditor/fckeditor.php');
pt_register('GET','id');
pt_register('POST','submit1');
pt_register('POST','id_cat_imagem');
pt_register('POST','id_empresa');
pt_register('POST','url_amigavel');
pt_register('POST','titulo_news');
pt_register('POST','chave');
pt_register('POST','descricao');
pt_register('POST','fonte');
pt_register('POST','escrito');
pt_register('POST','ordem');
pt_register('POST','imagem_news');
pt_register('POST','texto_chamada');
pt_register('POST','texto');
pt_register('POST','destaque');
pt_register('POST','st_id');
if(isset($_POST['acao']) && $_POST['acao']=="cadastrar"){
	if($submit1){
		if($errors!=1){
			if(isset($_FILES['imagem_news']) && $_FILES['imagem_news']['name'] != null){
				$imagem_news = $_FILES['imagem_news'];
				$redim = new Redimensiona();
				$images = array(690);
				$thumbmail = array();
				$folder = "../../upload/";
				for($i = 0; $i < count($images); $i++){
					$thumbmail[$i] = $redim->Redimensionar($imagem_news, $images[$i], $folder);
					$campo_img = str_replace("/","",str_replace($folder,'',$thumbmail[$i]));
					$sql = "UPDATE cp_news_nova SET id_cat_imagem='$id_cat_imagem', id_empresa='$id_empresa', titulo_news='$titulo_news', url_amigavel='$url_amigavel',";
					$sql .= "chave='$chave', descricao='$descricao', fonte='$fonte', escrito='$escrito', ordem='$ordem', ";
					$sql .= "texto_chamada='$texto_chamada', texto='$texto', destaque='$destaque', atualizacao=NOW(), ";
					$sql .= "st_id='$st_id', imagem_news='".$campo_img."' ";
					$sql .= "WHERE id_news='$id'";
					$objQuery->SQLQuery($sql);
					$id = $objQuery->ID;
					$done=1;
				}
			} else {
				$sql = "UPDATE cp_news_nova SET id_cat_imagem='$id_cat_imagem', id_empresa='$id_empresa', titulo_news='$titulo_news', url_amigavel='$url_amigavel', ";
				$sql .= "chave='$chave', descricao='$descricao', fonte='$fonte', escrito='$escrito', ordem='$ordem', ";
				$sql .= "texto_chamada='$texto_chamada', texto='$texto', destaque='$destaque', atualizacao=NOW(), ";
				$sql .= "st_id='$st_id'";
				$sql .= "WHERE id_news='$id'";
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
						EDITAR NOVA NOTÍCIA
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
					$sql = $objQuery->SQLQuery("SELECT ci.id_cat_imagem, ue.id_empresa, ns.id_news, ns.st_id, ns.titulo_news, ns.url_amigavel, ns.chave, ns.descricao, ns.fonte, ns.imagem_news, ns.texto_chamada, ns.texto, ns.destaque, ns.escrito, ns.ordem FROM cp_news_nova as ns LEFT JOIN cp_cat_imagem as ci ON ci.id_cat_imagem=ns.id_cat_imagem LEFT JOIN cartorio_banco2.vsites_user_empresa as ue ON ue.id_empresa=ns.id_empresa, cp_status as st WHERE ns.id_news='" .$id. "'");
					$res = mysql_fetch_array($sql);
					$id_news		= $res['id_news'];
					$st_id			= $res['st_id'];
					$id_cat_imagem	= $res['id_cat_imagem'];
					$id_empresa		= $res['id_empresa'];
					$titulo_news	= $res['titulo_news'];
					$url_amigavel	= $res['url_amigavel'];
					$chave			= $res['chave'];
					$descricao		= $res['descricao'];
					$fonte			= $res['fonte'];
					$escrito		= $res['escrito'];
					$ordem			= $res['ordem'];
					$imagem_news	= $res['imagem_news'];
					$texto_chamada	= $res['texto_chamada'];
					$texto			= $res['texto'];
					$destaque		= $res['destaque'];
				?>
				<div id="image_erro">
					<? if($res['imagem_news']==""){?>
					<img src="../images/paginas/image-remove-edit.png" alt="image-remove" />
					<? }else{ ?>
					<img src="../../upload/<? echo $res['imagem_news'];?>" width="200" alt="" />
					<?}?>
				</div>
				<!--/fomulário:permissao-edit/-->
				<form name="form" action="" method="post" enctype="multipart/form-data">
					<!--/tabela:lado-right/-->
					<table width="100%">
						<tr>
							<td><label for="id_cat_imagem" accesskey="1">Galeria de fotos</label></td>
							<td><label for="id_empresa" accesskey="1">Nome da unidade</label></td>
						</tr>
						<tr>
							<td>
								<select name="id_cat_imagem" id="id_cat_imagem" <?=($errors['id_cat_imagem'])?'style="border:1px solid #FF0000;"':''; ?> >
								<option value="">---</option>
								<?
								$sql = $objQuery->SQLQuery("SELECT ci.id_cat_imagem, ci.nome_imagem, ci.st_id FROM cp_cat_imagem as ci WHERE ci.st_id='1' ORDER BY ci.id_cat_imagem DESC");
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
							<td colspan="2"><label for="titulo_news" accesskey="1">Título</label></td>
						</tr>
						<tr>
							<td colspan="2">
								<textarea name="titulo_news" id="campo1" cols="" rows="" onkeyup="mostrarResultado(this.value,300,'spcontando1');contarCaracteres(this.value,300,'sprestante1','campo1')" ><?= $titulo_news;?></textarea>
								<span id="spcontando1">Ainda não temos nada digitado..</span><br />
								<span id="sprestante1"></span>
							</td>
						</tr>
						<tr>
							<td><label for="url_amigavel" accesskey="2" colspan="2">URL amigável</label></td>
						</tr>
						<tr>
							<td colspan="2"><input name="url_amigavel" type="text" id="url_amigavel" value="<?= $url_amigavel;?>" /></td>
						</tr>
						<tr>
							<td colspan="2"><label for="campo2" accesskey="3">Chave</label></td>
						</tr>
						<tr>
							<td colspan="2">
								<textarea name="chave" id="campo2" cols="" rows="" onkeyup="mostrarResultado(this.value,500,'spcontando2');contarCaracteres(this.value,500,'sprestante2','campo2')" ><?= $chave;?></textarea>
								<span id="spcontando2">Ainda não temos nada digitado..</span><br />
								<span id="sprestante2"></span>
							</td>
						</tr>
						<tr>
							<td colspan="2"><label for="campo3" accesskey="4">Descrição</label></td>
						</tr>
						<tr>
							<td colspan="2">
								<textarea name="descricao" id="campo3" cols="" rows="" onkeyup="mostrarResultado(this.value,200,'spcontando3');contarCaracteres(this.value,200,'sprestante3','campo3')" ><?= $descricao;?></textarea>
								<span id="spcontando3">Ainda não temos nada digitado..</span><br />
								<span id="sprestante3"></span>
							</td>
						</tr>
						<tr>
							<td><label for="fonte" accesskey="5">Fonte da notícia</label></td>
							<td><label for="escrito" accesskey="6">Escrito por</label></td>
						</tr>
						<tr>
							<td><input name="fonte" type="text" id="fonte" value="<?= $fonte;?>" /></td>
							<td><input name="escrito" type="text" id="escrito" value="<?= $escrito;?>" /></td>
						</tr>
						<tr>
							<td><label for="destaque" accesskey="7">Destaque</label></td>
							<td><label for="ordem" accesskey="8">Ordem</label></td>
						</tr>
						<tr>
							<td>
								<select name="destaque" id="destaque" >
									<option>---</option>
									<option value="1" <? if($destaque=='1') echo 'selected'; ?>>Sim</option>
									<option value="2" <? if($destaque=='2') echo 'selected'; ?>>Não</option>
								</select>
							</td>
							<td>
								<select name="ordem" id="ordem">
									<option>---</option>
									<option value="1" <? if($ordem=='1') echo 'selected'; ?>>1º</option>
									<option value="2" <? if($ordem=='2') echo 'selected'; ?>>2º</option>
									<option value="3" <? if($ordem=='3') echo 'selected'; ?>>3º</option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="2"><label for="imagem_news" accesskey="9">Imagem</label></td>
						</tr>
						<tr>
							<td colspan="2"><input name="imagem_news" type="file" id="imagem_news" style="width:100%;" /></td>
						</tr>
						<tr>
							<td colspan="2"><label for="campo4" accesskey="10">Chamada da notícia</label></td>
						</tr>
						<tr>
							<td colspan="2">
								<textarea name="texto_chamada" id="campo4" cols="" rows="" onkeyup="mostrarResultado(this.value,300,'spcontando4');contarCaracteres(this.value,300,'sprestante4','campo4')" ><?= $texto_chamada;?></textarea>
								<span id="spcontando4">Ainda não temos nada digitado..</span><br />
								<span id="sprestante4"></span>
							</td>
						</tr>
						<tr>
							<td colspan="2"><label for="texto" accesskey="11">Texto da notícia</label></td>
						</tr>
						<tr>
							<td colspan="2">
								<?
								$oFCKeditor = new FCKeditor('texto');
								$oFCKeditor->voltarConfig['AutoDetectLanguage'] = false; 
								$oFCKeditor->Config['DefaultLanguage'] = 'pt';
								$oFCKeditor->BasePath = '../js/fckeditor/';
								$oFCKeditor->Value = $texto;
								$oFCKeditor->ToolbarSet = 'Default';
								$oFCKeditor->Width = '100%';
								$oFCKeditor->Height = '300px';
								$oFCKeditor->Create();
								?>
							</td>
						</tr>
						<tr>
							<td colspan="2"><label for="status" accesskey="12">Status</label></td>
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
					echo '<meta HTTP-EQUIV="refresh" CONTENT="2; URL=news-list.php" />';
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