<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'galeria_imagens';
$title_pg = 'Cadastro: Nova imagem';
require_once('../includes/header.php');
pt_register('POST','submit1');
pt_register('POST','st_id');
pt_register('POST','id_cat_imagem');
pt_register('POST','id_empresa');
pt_register('POST','imagem');
pt_register('POST','descricao');

$permissao = verifica_permissao('cadastro_imagens',$controle_permissao_p,$controle_permissao_s);
if($permissao == 'FALSE'){ 
	require_once('resposta-permissao.php');
	exit;
}

if($submit1){
	$errors=array();
		if($id_cat_imagem==""){
			if($id_cat_imagem=="")	$errors['id_cat_imagem']=1;
				$error.="<span style='color:#FF0000;'>Os campos em vermelho são obrigatórios.</span><br />";
		}
		if(isset($_POST['acao']) && $_POST['acao']=="cadastrar"){
			if(isset($_FILES['imagem']) && $_FILES['imagem']['name'] != null){
				$imagem = $_FILES['imagem'];
				$redim = new Redimensiona();
				$images = array(800);
				$thumbmail = array();
				$folder = "../../upload/";
				for($i = 0; $i < count($images); $i++){
					$thumbmail[$i] = $redim->Redimensionar($imagem, $images[$i], $folder);
					$campo_img = str_replace("/","",str_replace($folder,'',$thumbmail[$i]));
					if(count($errors)<1){
						$query="INSERT INTO cp_imagem (";
						$query .="st_id, id_cat_imagem, id_empresa, imagem, descricao, data)";
						$query .="VALUES";
						$query .="('1','".$id_cat_imagem."','".$id_empresa."','".$campo_img."','".$descricao."',NOW())";
						$result = $objQuery->SQLQuery($query);
						$id = $objQuery->ID;
						$done=1;
					}
				}
			}else{
				if(count($errors)<1){
					$query="INSERT INTO cp_imagem (";
					$query .="st_id, id_cat_imagem, id_empresa, descricao, data)";
					$query .="VALUES";
					$query .="('1','".$id_cat_imagem."','".$id_empresa."','".$descricao."',NOW())";
					$result = $objQuery->SQLQuery($query);
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
							<img src="../images/paginas/icon-images.png" alt="icon-images" />
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
				<? require_once('menu-add.php'); ?>
			<div class="next">
				<a href="#" title="Clique aqui para avançar" class="next"><img src="../images/paginas/proximo.png" alt="proximo" /></a>
			</div>
		</div>
		<div class="pages">
			<!--/tabela:adicionar-usuário/-->
			<table width="1000" class="table_info">
				<tr>
					<th align="center" valign="middle" colspan="6">
						ADICIONAR UMA NOVA IMAGENS
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
						<?
						if($error!=''){
							echo'<tr>
									<td align="center" valign="middle" class="td_info">
										<img src="../images/paginas/info.png" alt="info" align="center" />
									</td>
									<td align="left" valign="bottom" class="td_info">
										<strong>Ocorreram os seguintes erros:</strong>
									</td>
								</tr>
								<tr>
									<td align="left" valign="middle" colspan="2">';
										if($errors){
											echo $error;
										}
								echo'</td>
								</tr>';
						}?>
						<tr>
							<?
							$permissao = verifica_permissao('lista_imagens',$controle_permissao_p,$controle_permissao_s);
							if($permissao == 'TRUE'){
							?>
							<td align="center" valign="top" class="td_info">
								<img src="../images/paginas/list.png" alt="list" align="center" />
							</td>
							<?}?>
							<td align="left" valign="top" class="td_info">
								<ul id="lista">
									<li>
										<?
										$permissao = verifica_permissao('lista_categoria_imagens',$controle_permissao_p,$controle_permissao_s);
										if($permissao == 'TRUE'){
										?>
										<a href="categoria-imagem-list.php" title="Clique aqui" class="link_lista">Lista: Categoria de imagens</a>
										<?}?>
									</li>
									<li>
										<?
										$permissao = verifica_permissao('lista_imagens',$controle_permissao_p,$controle_permissao_s);
										if($permissao == 'TRUE'){
										?>
										<a href="imagem-list.php" title="Clique aqui" class="link_lista">Lista: Imagens</a>
										<?}?>
									</li>
								</ul>
							</td>
						</tr>
					</table>
					<!--/tabela:fim/-->
				</td>
				<!--/divisão/-->
				<td align="center" valign="top" class="td_info" width="75%">
				<?
				if($done!=1){
				?>
				<!--/fomulário:keywords-add/-->
				<form name="form" action="" method="post" enctype="multipart/form-data">
					<!--/tabela:lado-right/-->
					<table width="100%">
						<tr>
							<td width="50%"><label for="id_cat_imagem" accesskey="1">Nome da categoria</label></td>
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
								<textarea name="descricao" id="campo1" cols="" rows="" onkeyup="mostrarResultado(this.value,200,'spcontando3');contarCaracteres(this.value,200,'sprestante3','campo1')" <?=($errors['descricao'])?'style="border:1px solid #FF0000;"':''; ?>><?= $descricao ?></textarea>
								<span id="spcontando3">Ainda não temos nada digitado..</span><br />
								<span id="sprestante3"></span>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<input name="submit1" type="submit" value="Cadastrar" title="Clique aqui para fazer o cadastro" />
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
						<img src="../images/paginas/resposta-confirmacao.png" alt="resposta-confirmacao" />';
					echo '<meta HTTP-EQUIV="refresh" CONTENT="2; URL=imagem-add.php" />';
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