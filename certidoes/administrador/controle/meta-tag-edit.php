<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'administrador';
$title_pg = 'Editar: Keywords';
require_once('../includes/header.php');
pt_register('GET','id');
pt_register('POST','submit1');
pt_register('POST','id_pagina');
pt_register('POST','id_empresa');
pt_register('POST','titulo');
pt_register('POST','url_amigavel');
pt_register('POST','chave');
pt_register('POST','descricao');
pt_register('POST','st_id');

$permissao = verifica_permissao('editar_keyword',$controle_permissao_p,$controle_permissao_s);
if($permissao == 'FALSE'){ 
	require_once('resposta-permissao.php');
	exit;
}

if($submit1){
	if($errors!=1){
		$objQuery->SQLQuery("UPDATE cp_meta_tag SET id_pagina='$id_pagina', id_empresa='$id_empresa', titulo='$titulo', url_amigavel='$url_amigavel', chave='$chave', descricao='$descricao', st_id='$st_id' WHERE id_meta='$id'");
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
						EDITAR PALAVRA CHAVE
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
					$sql = $objQuery->SQLQuery("SELECT m.id_pagina, m.id_empresa, m.titulo, m.url_amigavel, m.chave, m.descricao, ue.id_empresa, st.st_id, st.status FROM cp_meta_tag as m, cp_status as st, cartorio_banco2.vsites_user_empresa as ue WHERE m.id_empresa=ue.id_empresa AND m.st_id=st.st_id AND m.id_meta='" .$id. "'");
					$res = mysql_fetch_array($sql);
					$st_id			= $res['st_id'];
					$id_pagina		= $res['id_pagina'];
					$id_empresa		= $res['id_empresa'];
					$titulo			= $res['titulo'];
					$url_amigavel	= $res['url_amigavel'];
					$chave			= $res['chave'];
					$descricao		= $res['descricao'];
				?>
				<!--/fomulário:permissao-edit/-->
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
							<td><input name="titulo" type="text" id="titulo" value="<?= $titulo;?>" /></td>
						</tr>
						<tr>
							<td><label for="id_pagina" accesskey="1">Páginas</label></td>
							<td><label for="url_amigavel" accesskey="1">URL amigável</label></td>
						</tr>
						<tr>
							<td>
								<select name="id_pagina" id="id_pagina">
									<option>---</option>
									<option value="1" <? if($id_pagina=='1') echo 'selected'; ?>>Produtos/Serviços</option>
									<option value="2" <? if($id_pagina=='2') echo 'selected'; ?>>Parcerias</option>
									<option value="3" <? if($id_pagina=='3') echo 'selected'; ?>>Imprensa</option>
									<option value="4" <? if($id_pagina=='4') echo 'selected'; ?>>Galeria de Fotos</option>
									<option value="5" <? if($id_pagina=='5') echo 'selected'; ?>>Fale Conosco</option>
								</select>
							</td>
							<td><input name="url_amigavel" type="text" id="url_amigavel" value="<?= $url_amigavel;?>" /></td>
						</tr>
						<tr>
							<td colspan="2"><label for="campo2" accesskey="3">Descição</label></td>
						</tr>
						<tr>
							<td colspan="2">
							<textarea name="descricao" id="campo2" cols="" rows="" onkeyup="mostrarResultado(this.value,200,'spcontando2');contarCaracteres(this.value,200,'sprestante2','campo2')" ><?= $descricao;?></textarea>
								<span id="spcontando2">Ainda não temos nada digitado..</span><br />
								<span id="sprestante2"></span>
							</td>
						</tr>
						<tr>
							<td colspan="2"><label for="chave" accesskey="2">Palavra chave</label></td>
						</tr>
						<tr>
							<td colspan="2">
								<textarea name="chave" id="campo1" cols="" rows="" onkeyup="mostrarResultado(this.value,500,'spcontando1');contarCaracteres(this.value,500,'sprestante1','campo1')" ><?= $chave;?></textarea>
								<span id="spcontando1">Ainda não temos nada digitado..</span><br />
								<span id="sprestante1"></span>
							</td>
						</tr>
						<tr>
							<td colspan="2"><label for="status" accesskey="4">Status</label></td>
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
							<td colspan="6"><input name="submit1" type="submit" value="Atualizar" title="Clique aqui para atualizar o cadastro" /></td>
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
					echo '<meta HTTP-EQUIV="refresh" CONTENT="2; URL=meta-tag-list.php" />';
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