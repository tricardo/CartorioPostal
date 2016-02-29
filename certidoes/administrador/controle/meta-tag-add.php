<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'administrador';
$title_pg = 'Cadastro: Nova Keywords';
require_once('../includes/header.php');
pt_register('POST','submit1');
pt_register('POST','id_pagina');
pt_register('POST','id_empresa');
pt_register('POST','titulo');
pt_register('POST','url_amigavel');
pt_register('POST','chave');
pt_register('POST','descricao');

$permissao = verifica_permissao('cadastro_keyword',$controle_permissao_p,$controle_permissao_s);
if($permissao == 'FALSE'){ 
	require_once('resposta-permissao.php');
	exit;
}

if($submit1){
	$errors=array();
		if($id_empresa=="" || $titulo=="" || $chave=="" || $descricao==""){
			if($id_empresa=="")	$errors['id_empresa']=1;
			if($titulo=="")	$errors['titulo']=1;
			if($chave=="")	$errors['chave']=1;
			if($descricao=="")	$errors['descricao']=1;
				$error.="<span style='color:#FF0000;'>Os campos em vermelho são obrigatórios.</span><br />";
		}
		if(count($errors)<1){
			$query="INSERT INTO cp_meta_tag (id_pagina, id_empresa, titulo, url_amigavel, chave, descricao, data, st_id) values ('".$id_pagina."','".$id_empresa."','".$titulo."','".$url_amigavel."','".$chave."','".$descricao."',NOW(),'1')";
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
							<img src="../images/paginas/icon-keywords.png" alt="icon-keywords" />
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
						ADICIONAR UMA NOVA PALAVRA CHAVE
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
							$permissao = verifica_permissao('lista_usuario',$controle_permissao_p,$controle_permissao_s);
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
										$permissao = verifica_permissao('lista_usuario',$controle_permissao_p,$controle_permissao_s);
										if($permissao == 'TRUE'){
										?>
										<a href="usuario-list.php" title="Clique aqui" class="link_lista">Lista: Usuários</a>
										<?}?>
									</li>
									<li>
										<?
										$permissao = verifica_permissao('lista_permissao',$controle_permissao_p,$controle_permissao_s);
										if($permissao == 'TRUE'){
										?>
										<a href="permissao-list.php" title="Clique aqui" class="link_lista">Lista: Permissão</a>
										<?}?>
									</li>
									<li>
										<?
										$permissao = verifica_permissao('lista_keyword',$controle_permissao_p,$controle_permissao_s);
										if($permissao == 'TRUE'){
										?>
										<a href="meta-tag-list.php" title="Clique aqui" class="link_lista">Lista: Keywords</a>
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
							<td width="50%"><label for="id_empresa" accesskey="1">Nome da unidade</label></td>
							<td><label for="titulo" accesskey="1">Título da página</label></td>
						</tr>
						<tr>
							<td>
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
							<td><input name="titulo" type="text" id="titulo" value="<?= $titulo?>" <?=($errors['titulo'])?'style="border:1px solid #FF0000;"':''; ?> /></td>
						</tr>
						<tr>
							<td><label for="id_pagina" accesskey="1">Páginas</label></td>
							<td><label for="url_amigavel" accesskey="1">URL amigável</label></td>
						</tr>
						<tr>
							<td>
								<select name="id_pagina" id="id_pagina" <?=($errors['id_pagina'])?'style="border:1px solid #FF0000;"':''; ?> >
									<option>---</option>
									<option value="1" <? if($id_pagina=='1') echo 'selected'; ?>>Produtos/Serviços</option>
									<option value="2" <? if($id_pagina=='2') echo 'selected'; ?>>Parcerias</option>
									<option value="3" <? if($id_pagina=='3') echo 'selected'; ?>>Imprensa</option>
									<option value="4" <? if($id_pagina=='4') echo 'selected'; ?>>Galeria de Fotos</option>
									<option value="5" <? if($id_pagina=='5') echo 'selected'; ?>>Fale Conosco</option>
								</select>
							</td>
							<td><input name="url_amigavel" type="text" id="url_amigavel" value="<?= $url_amigavel?>" <?=($errors['url_amigavel'])?'style="border:1px solid #FF0000;"':''; ?> /></td>
						</tr>
						<tr>
							<td colspan="2"><label for="campo2" accesskey="3">Descição</label></td>
						</tr>
						<tr>
							<td colspan="2">
							<textarea name="descricao" id="campo2" cols="" rows="" onkeyup="mostrarResultado(this.value,200,'spcontando2');contarCaracteres(this.value,200,'sprestante2','campo2')" <?=($errors['descricao'])?'style="border:1px solid #FF0000;"':''; ?>><?= $descricao ?></textarea>
								<span id="spcontando2">Ainda não temos nada digitado..</span><br />
								<span id="sprestante2"></span>
							</td>
						</tr>
						<tr>
							<td colspan="2"><label for="campo1" accesskey="2">Palavra chave</label></td>
						</tr>
						<tr>
							<td colspan="2">
								<textarea name="chave" id="campo1" cols="" rows="" onkeyup="mostrarResultado(this.value,500,'spcontando1');contarCaracteres(this.value,500,'sprestante1','campo1')" <?=($errors['chave'])?'style="border:1px solid #FF0000;"':''; ?>><?= $chave ?></textarea>
								<span id="spcontando1">Ainda não temos nada digitado..</span><br />
								<span id="sprestante1"></span>
							</td>
						</tr>
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
					echo '<meta HTTP-EQUIV="refresh" CONTENT="2; URL=meta-tag-add.php" />';
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