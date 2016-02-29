<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'administrador';
$title_pg = 'Editar: Usuário';
require_once('../includes/header.php');
pt_register('GET','id');
pt_register('POST','submit1');
pt_register('POST','usuario');
pt_register('POST','st_id');

$permissao = verifica_permissao('editar_usuario',$controle_permissao_p,$controle_permissao_s);
if($permissao == 'FALSE' or ($controle_id_usuario!='1' and $id=='1')){ 
	require_once('resposta-permissao.php');
	exit;
}

if($submit1){
	if($errors!=1){
		$objQuery->SQLQuery("UPDATE cp_user SET usuario='$usuario', st_id='$st_id' WHERE id_usuario='$id'");
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
						EDITAR USUÁRIO
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
					$sql = $objQuery->SQLQuery("SELECT * FROM cp_user as us WHERE us.id_usuario='" .$id. "'");
					$res = mysql_fetch_array($sql);
					$id_usuario		= $res['id_usuario'];
					$usuario		= $res['usuario'];
					$email			= $res['email'];
					$st_id			= $res['st_id'];
				?>
				<!--/fomulário:usuario-edit/-->
				<form name="form" action="" method="post" enctype="multipart/form-data">
					<!--/tabela:lado-right/-->
					<table width="100%">
						<tr>
							<td><label for="usuario" accesskey="1">Nome do usuário</label></td>
							<td><label for="email" accesskey="2">Email do usuário</label></td>
						</tr>
						<tr>
							<td><input name="usuario" type="text" id="usuario" value="<?= $usuario?>" /></td>
							<td><input name="email" type="text" id="email" readonly="true" value="<?= $email?>" /></td>
						</tr>
						<tr>
							<td><label for="status" accesskey="3">Status</label></td>
							<td></td>
						</tr>
						<tr>
							<td>
								<select name="st_id" id="status">
								<?
								$sql = $objQuery->SQLQuery("SELECT * FROM cp_status_user as su ORDER BY su.st_id");
								while($res = mysql_fetch_array($sql)){
									echo '<option value="'.$res['st_id'].'"';
									if($st_id==$res['st_id']) echo 'selected="selected"'; 
									echo '>'.$res['status'].'</option>';
								}
								?>
								</select>
							</td>
							<td></td>
						</tr>
						<tr>
							<td colspan="6"><input name="submit1" type="submit" value="Atualizar" title="Clique aqui para atualizar o cadastro" tabindex="4" /></td>
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
					echo '<meta HTTP-EQUIV="refresh" CONTENT="2; URL=usuario-list.php" />';
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