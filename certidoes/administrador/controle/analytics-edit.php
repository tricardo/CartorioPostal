<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'hotsite';
$title_pg = 'Editar: Analytics';
require_once('../includes/header.php');
require_once('../js/fckeditor/fckeditor.php');
pt_register('GET','id');
pt_register('POST','submit1');
pt_register('POST','st_id');
pt_register('POST','id_empresa');
pt_register('POST','descricao');

$permissao = verifica_permissao('editar_hotsite',$controle_permissao_p,$controle_permissao_s);
if($permissao == 'FALSE'){ 
	require_once('resposta-permissao.php');
	exit;
}

if($submit1){
	if($errors!=1){
		$objQuery->SQLQuery("UPDATE cp_analytics SET id_empresa='$id_empresa', descricao='$descricao', st_id='$st_id' WHERE id_analytics='$id'");
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
						EDITAR SCRIPT
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
					$sql = $objQuery->SQLQuery("SELECT an.id_analytics, an.descricao, an.st_id, ue.id_empresa, st.st_id, st.status FROM cp_analytics as an, cp_status as st, cartorio_banco2.vsites_user_empresa as ue WHERE an.id_empresa=ue.id_empresa AND ue.status='Ativo' AND an.st_id=st.st_id AND an.id_analytics='" .$id. "'");
					$res = mysql_fetch_array($sql);
					$st_id			= $res['st_id'];
					$id_empresa		= $res['id_empresa'];
					$descricao		= $res['descricao'];
				?>
				<!--/fomulário:permissao-edit/-->
				<form name="form" action="" method="post" enctype="multipart/form-data">
					<!--/tabela:lado-right/-->
					<table width="100%">
						<tr>
							<td><label for="id_empresa" accesskey="1">Nome da unidade</label></td>
						</tr>
						<tr>
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
							<td>
								<?
								$oFCKeditor = new FCKeditor('descricao');
								$oFCKeditor->voltarConfig['AutoDetectLanguage'] = false; 
								$oFCKeditor->Config['DefaultLanguage'] = 'pt';
								$oFCKeditor->BasePath = '../js/fckeditor/';
								$oFCKeditor->Value = $descricao;
								$oFCKeditor->ToolbarSet = 'Default';
								$oFCKeditor->Width = '100%';
								$oFCKeditor->Height = '300px';
								$oFCKeditor->Create();
								?>
							</td>
						</tr>
						<tr>
							<td><label for="status" accesskey="2">Status</label></td>
						</tr>
						<tr>
							<td>
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
					echo '<meta HTTP-EQUIV="refresh" CONTENT="2; URL=analytics-list.php" />';
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