<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'news';
$title_pg = 'Editar: Comentário';
require_once('../includes/header.php');
pt_register('GET','id');
pt_register('POST','submit1');
pt_register('POST','nome');
pt_register('POST','email');
pt_register('POST','comentario');
pt_register('POST','st_id');

$permissao = verifica_permissao('editar_comentario',$controle_permissao_p,$controle_permissao_s);
if($permissao == 'FALSE'){ 
	require_once('resposta-permissao.php');
	exit;
}

if($submit1){
	if($errors!=1){
		$objQuery->SQLQuery("UPDATE cp_comentario_news SET nome='$nome', email='$email', comentario='$comentario', st_id='$st_id' WHERE id_comentario='$id'");
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
						EDITAR COMENTÁRIO
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
					$sql = $objQuery->SQLQuery("SELECT ns.id_news, ns.titulo_news, cm.id_comentario, cm.st_id, cm.nome, cm.email, cm.comentario FROM cp_news_nova as ns, cp_comentario_news as cm WHERE ns.id_news=cm.id_news AND cm.id_comentario='" .$id. "'");
					$res = mysql_fetch_array($sql);
					$st_id	= $res['st_id'];
				?>
				<!--/fomulário:permissao-edit/-->
				<form name="form" action="" method="post" enctype="multipart/form-data">
					<!--/tabela:lado-right/-->
					<table width="100%">
						<tr>
							<td colspan="2"><label for="titulo_news" accesskey="1">Nóticia</label></td>
						</tr>
						<tr>
							<td colspan="2"><input name="titulo_news" type="text" readonly="true" id="titulo_news" value="<?= $res['titulo_news'];?>" /></td>
						</tr>
						<tr>
							<td><label for="nome" accesskey="1">Nome</label></td>
							<td><label for="email" accesskey="2">Email</label></td>
						</tr>
						<tr>
							<td><input name="nome" type="text" id="nome" value="<?= $res['nome'];?>" /></td>
							<td><input name="email" type="text" id="email" value="<?= $res['email'];?>" /></td>
						</tr>
						<tr>
							<td colspan="2"><label for="comentario" accesskey="3">Comentário</label></td>
						</tr>
						<tr>
							<td colspan="2"><textarea name="comentario" id="comentario" cols="" rows="" ><?= $res['comentario'];?></textarea></td>
						</tr>
						<tr>
							<td colspan="2"><label for="status" accesskey="4">Status</label></td>
						</tr>
						<tr>
							<td colspan="2">
								<select name="st_id" id="status">
								<?
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
						<img src="../images/paginas/resposta-atualizacao.png" alt="resposta-atualizacao" onLoad="voltar();" />';
					echo '	<script language="javascript" type="text/javascript">
								function voltar(){   
									window.setTimeout(function(){
										history.go(-2)
									},2000);   
								}
							</script>
							';
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