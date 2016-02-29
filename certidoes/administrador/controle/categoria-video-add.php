<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'galeria_videos';
$title_pg = 'Cadastro: Nova categoria';
require_once('../includes/header.php');
pt_register('POST','submit1');
pt_register('POST','nome_video');
pt_register('POST','url_amigavel');
pt_register('POST','chave');
pt_register('POST','descricao');
pt_register('POST','imagem_video');

$permissao = verifica_permissao('cadastro_categoria_videos',$controle_permissao_p,$controle_permissao_s);
if($permissao == 'FALSE'){ 
	require_once('resposta-permissao.php');
	exit;
}

if($submit1){
	$errors=array();
		if($nome_video==""){
			if($nome_video=="")	$errors['nome_video']=1;
				$error.="<span style='color:#FF0000;'>Os campos em vermelho são obrigatórios.</span><br />";
		}
		if(isset($_POST['acao']) && $_POST['acao']=="cadastrar"){
			if(isset($_FILES['imagem_video']) && $_FILES['imagem_video']['name'] != null){
				$imagem_video = $_FILES['imagem_video'];
				$redim = new Redimensiona();
				$images = array(800);
				$thumbmail = array();
				$folder = "../../upload/";
				for($i = 0; $i < count($images); $i++){
					$thumbmail[$i] = $redim->Redimensionar($imagem_video, $images[$i], $folder);
					$campo_img = str_replace("/","",str_replace($folder,'',$thumbmail[$i]));
					if(count($errors)<1){
						$query="INSERT INTO cp_cat_video (";
						$query .="st_id, nome_video, url_amigavel, chave, descricao, imagem_video, data)";
						$query .="VALUES";
						$query .="('1','".$nome_video."','".$url_amigavel."','".$chave."','".$descricao."','".$campo_img."',NOW())";
						$result = $objQuery->SQLQuery($query);
						$id = $objQuery->ID;
						$done=1;
					}
				}
			}else{
				if(count($errors)<1){
					$query="INSERT INTO cp_cat_video (";
					$query .="st_id, nome_video, url_amigavel, chave, descricao, data)";
					$query .="VALUES";
					$query .="('1','".$nome_video."','".$url_amigavel."','".$chave."','".$descricao."',NOW())";
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
							<img src="../images/paginas/icon-videos.png" alt="icon-videos" />
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
						ADICIONAR UMA NOVA CATEGORIA DE VÍDEOS
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
							$permissao = verifica_permissao('lista_categoria_videos',$controle_permissao_p,$controle_permissao_s);
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
										$permissao = verifica_permissao('lista_categoria_videos',$controle_permissao_p,$controle_permissao_s);
										if($permissao == 'TRUE'){
										?>
										<a href="categoria-video-list.php" title="Clique aqui" class="link_lista">Lista: Categoria de vídeos</a>
										<?}?>
									</li>
									<li>
										<?
										$permissao = verifica_permissao('lista_videos',$controle_permissao_p,$controle_permissao_s);
										if($permissao == 'TRUE'){
										?>
										<a href="video-list.php" title="Clique aqui" class="link_lista">Lista: Vídeos</a>
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
							<td><label for="nome_video" accesskey="1">Nome da categoria</label></td>
							<td><label for="url_amigavel" accesskey="2">URL amigável</label></td>
						</tr>
						<tr>
							<td><input name="nome_video" type="text" id="nome_video" value="<?= $nome_video?>" <?=($errors['nome_video'])?'style="border:1px solid #FF0000;"':''; ?> /></td>
							<td><input name="url_amigavel" type="text" id="url_amigavel" value="<?= $url_amigavel?>" <?=($errors['url_amigavel'])?'style="border:1px solid #FF0000;"':''; ?> /></td>
						</tr>
						<tr>
							<td colspan="2"><label for="campo1" accesskey="3">Chave</label></td>
						</tr>
						<tr>
							<td colspan="2">
								<textarea name="chave" id="campo1" cols="" rows="" onkeyup="mostrarResultado(this.value,500,'spcontando1');contarCaracteres(this.value,500,'sprestante1','campo1')" <?=($errors['chave'])?'style="border:1px solid #FF0000;"':''; ?>><?= $chave ?></textarea>
								<span id="spcontando1">Ainda não temos nada digitado..</span><br />
								<span id="sprestante1"></span>
							</td>
						</tr>
						<tr>
							<td colspan="2"><label for="campo2" accesskey="4">Descrição</label></td>
						</tr>
						<tr>
							<td colspan="2">
								<textarea name="descricao" id="campo2" cols="" rows="" onkeyup="mostrarResultado(this.value,200,'spcontando2');contarCaracteres(this.value,200,'sprestante2','campo2')" <?=($errors['descricao'])?'style="border:1px solid #FF0000;"':''; ?>><?= $descricao ?></textarea>
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
					echo '<meta HTTP-EQUIV="refresh" CONTENT="2; URL=categoria-video-add.php" />';
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