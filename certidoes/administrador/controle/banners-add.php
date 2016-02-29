<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'hotsite';
$title_pg = 'Cadastro: Banners';
require_once('../includes/header.php');
pt_register('POST','submit1');
pt_register('POST','nome_imagem');
pt_register('POST','url_amigavel');
pt_register('POST','chave');
pt_register('POST','descricao');
pt_register('POST','cat_imagem');
pt_register('POST','id_empresa');
pt_register('POST','destaque');

$permissao = verifica_permissao('cadastro_hotsite',$controle_permissao_p,$controle_permissao_s);
if($permissao == 'FALSE'){ 
	require_once('resposta-permissao.php');
	exit;
}

if($submit1){
	$errors=array();
		if($nome_imagem==""){
			if($nome_imagem=="")	$errors['nome_imagem']=1;
				$error.="<span style='color:#FF0000;'>Os campos em vermelho são obrigatórios.</span><br />";
		}
		if(isset($_POST['acao']) && $_POST['acao']=="cadastrar"){
			if(isset($_FILES['cat_imagem']) && $_FILES['cat_imagem']['name'] != null){
				$cat_imagem = $_FILES['cat_imagem'];
				$redim = new Redimensiona();
				$images = array(990);
				$thumbmail = array();
				$folder = "../../upload/";
				for($i = 0; $i < count($images); $i++){
					$thumbmail[$i] = $redim->Redimensionar($cat_imagem, $images[$i], $folder);
					$campo_img = str_replace("/","",str_replace($folder,'',$thumbmail[$i]));
					if(count($errors)<1){
						$query="INSERT INTO cp_banners (";
						$query .="st_id, nome_imagem, url_amigavel, chave, descricao, cat_imagem, id_empresa, destaque, data)";
						$query .="VALUES";
						$query .="('1','".$nome_imagem."','".$url_amigavel."','".$chave."','".$descricao."','".$campo_img."','".$id_empresa."','".$destaque."',NOW())";
						$result = $objQuery->SQLQuery($query);
						$id = $objQuery->ID;
						$done=1;
					}
				}
			}else{
				if(count($errors)<1){
					$query="INSERT INTO cp_banners (";
					$query .="st_id, nome_imagem, url_amigavel, chave, descricao, id_empresa, destaque, data)";
					$query .="VALUES";
					$query .="('1','".$nome_imagem."','".$url_amigavel."','".$chave."','".$descricao."','".$id_empresa."','".$destaque."',NOW())";
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
						ADICIONAR UMA NOVO BANNER
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
							$permissao = verifica_permissao('lista_hotsite',$controle_permissao_p,$controle_permissao_s);
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
										$permissao = verifica_permissao('lista_hotsite',$controle_permissao_p,$controle_permissao_s);
										if($permissao == 'TRUE'){
										?>
										<a href="produtos-list.php" title="Clique aqui" class="link_lista">Lista: Produtos</a>
										<?}?>
									</li>
									<li>
										<?
										$permissao = verifica_permissao('lista_hotsite',$controle_permissao_p,$controle_permissao_s);
										if($permissao == 'TRUE'){
										?>
										<a href="parcerias-list.php" title="Clique aqui" class="link_lista">Lista: Parcerias</a>
										<?}?>
									</li>
									<li>
										<?
										$permissao = verifica_permissao('lista_hotsite',$controle_permissao_p,$controle_permissao_s);
										if($permissao == 'TRUE'){
										?>
										<a href="banners-list.php" title="Clique aqui" class="link_lista">Lista: Banners</a>
										<?}?>
									</li>
									<li>
										<?
										$permissao = verifica_permissao('lista_hotsite',$controle_permissao_p,$controle_permissao_s);
										if($permissao == 'TRUE'){
										?>
										<a href="analytics-list.php" title="Clique aqui" class="link_lista">Lista: Analytics</a>
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
							<td colspan="2"><label for="id_empresa" accesskey="1">Nome da unidade</label></td>
						</tr>
						<tr>
							<td colspan="2">
								<select name="id_empresa" id="id_empresa" <?=($errors['id_empresa'])?'style="border:1px solid #FF0000;"':''; ?> >
								<option value="">---</option>
								<?
								$objQuery->classQueryMulti(1);
								$sql = $objQuery->SQLQuery("SELECT ue.id_empresa, ue.fantasia, ue.status FROM vsites_user_empresa as ue WHERE ue.status='Ativo' ORDER BY ue.fantasia ASC");
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
							<td width="50%"><label for="nome_imagem" accesskey="1">Nome do banner</label></td>
							<td><label for="destaque" accesskey="2">Destaque</label></td>
						</tr>
						<tr>
							<td><input name="nome_imagem" type="text" id="nome_imagem" value="<?= $nome_imagem?>" <?=($errors['nome_imagem'])?'style="border:1px solid #FF0000;"':''; ?> /></td>
							<td>
								<select name="destaque" id="destaque" <?=($errors['destaque'])?'style="border:1px solid #FF0000;"':''; ?> >
									<option>---</option>
									<option value="1" <? if($destaque=='1') echo 'selected'; ?>>Sim</option>
									<option value="2" <? if($destaque=='2') echo 'selected'; ?>>Não</option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="2"><label for="cat_imagem" accesskey="5">Imagem</label></td>
						</tr>
						<tr>
							<td colspan="2"><input name="cat_imagem" type="file" id="cat_imagem" style="width:100%;" /></td>
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
					echo '<meta HTTP-EQUIV="refresh" CONTENT="2; URL=banners-add.php" />';
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