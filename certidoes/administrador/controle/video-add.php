<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'galeria_videos';
$title_pg = 'Cadastro: Novo vídeo';
require_once('../includes/header.php');
pt_register('POST','submit1');
pt_register('POST','st_id');
pt_register('POST','id_cat_video');
pt_register('POST','descricao_video');
pt_register('POST','video');

$permissao = verifica_permissao('cadastro_videos',$controle_permissao_p,$controle_permissao_s);
if($permissao == 'FALSE'){ 
	require_once('resposta-permissao.php');
	exit;
}

if($submit1){
	$errors=array();
		if($id_cat_video=="" || $video==""){
			if($id_cat_video=="")	$errors['id_cat_video']=1;
			if($video=="")			$errors['video']=1;
				$error.="<span style='color:#FF0000;'>Os campos em vermelho são obrigatórios.</span><br />";
		}
		if(count($errors)<1){
			$query="INSERT INTO cp_video (st_id, id_cat_video, descricao_video, video, data) values ('1','".$id_cat_video."','".$descricao_video."','".$video."',NOW())";
			$result = $objQuery->SQLQuery($query);
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
						ADICIONAR UMA NOVO VÍDEO
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
							$permissao = verifica_permissao('lista_videos',$controle_permissao_p,$controle_permissao_s);
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
							<td colspan="2"><label for="id_cat_video" accesskey="1">Nome da categoria</label></td>
						</tr>
						<tr>
							<td colspan="2">
								<select name="id_cat_video" id="id_cat_video" <?=($errors['id_cat_video'])?'style="border:1px solid #FF0000;"':''; ?> >
								<option value="">---</option>
								<?
								$sql = $objQuery->SQLQuery("SELECT * FROM cp_cat_video as cv ORDER BY cv.id_cat_video DESC");
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
							<td><label for="descricao1" accesskey="2">Descrição do vídeo</label></td>
						</tr>
						<tr>
							<td><input name="descricao_video" type="text" id="descricao1" value="<?= $descricao_video?>" <?=($errors['descricao_video'])?'style="border:1px solid #FF0000;"':''; ?> /></td>
						</tr>
						<tr>
							<td><label for="videos1" accesskey="3">Vídeo</label></td>
						</tr>
						<td colspan="2">
							<textarea id="campo1" name="video" onkeyup="mostrarResultado(this.value,800,'spcontando1');contarCaracteres(this.value,800,'sprestante1','campo1')" <?=($errors['video'])?'style="border:1px solid #FF0000;"':''; ?> ><?= $video ?></textarea><br>
							<span id="spcontando1">Ainda não temos nada digitado..</span><br />
							<span id="sprestante1"></span><br><br>
						</td>
						<tr>
							<td colspan="2"><input name="submit1" type="submit" value="Cadastrar" title="Clique aqui para fazer o cadastro" /></td>
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
					echo '<meta HTTP-EQUIV="refresh" CONTENT="2; URL=video-add.php" />';
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