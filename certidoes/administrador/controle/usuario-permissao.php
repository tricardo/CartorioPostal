<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'administrador';
$title_pg = 'Permissão: Usuário';
require_once('../includes/header.php');
pt_register('GET','id');
pt_register('POST','id');
pt_register('POST','submit1');

$permissao = verifica_permissao('usuario_permissao',$controle_permissao_p,$controle_permissao_s);
if($permissao == 'FALSE' or ($controle_id_usuario!='1' and $id=='1')){ 
	require_once('resposta-permissao.php');
	exit;
}

if($submit1){
	$permissao_p = '';
	$permissao_s = '';
	$sql = $objQuery->SQLQuery("SELECT * FROM cp_permissao as p WHERE p.id_permissao!= '1' ".$onde." ORDER BY permitir");
	while($res = mysql_fetch_array($sql)){
		$cont_seg++;
		$id_permissao=$res['id_permissao'];
		pt_register('POST','pertence_'.$id_permissao);
		pt_register('POST','supervisor_'.$id_permissao);
		if(${'pertence_'.$id_permissao}=='on'){ $permissao_p .= $id_permissao.','; }
		if(${'supervisor_'.$id_permissao}=='on'){ $permissao_s .= $id_permissao.','; }
	}
	$sql_update ="UPDATE cp_user SET permissao_p = '".$permissao_p."', permissao_s = '".$permissao_s."' WHERE id_usuario='$id'";
	$update = $objQuery->SQLQuery($sql_update);
}
$sql_atual = $objQuery->SQLQuery("SELECT permissao_p, permissao_s FROM cp_user as us WHERE us.id_usuario='".$id."'");
$res_atual = mysql_fetch_array($sql_atual);
$permissao_p = explode(',',$res_atual['permissao_p']);
$permissao_s = explode(',',$res_atual['permissao_s']);

$sql = $objQuery->SQLQuery("SELECT us.usuario FROM cp_user as us WHERE us.id_usuario='" .$id. "'");
$res = mysql_fetch_array($sql);
$id_usuario		= $res['id_usuario'];
$usuario		= $res['usuario'];
?>
<div class="estrutura">
	<div class="conteudo">
		<div class="fundo_menu_add">
			<div class="title_page">
				<!--/tabela:icone-titulo/-->
				<table width="100%" align="center" cellspacing="0" cellpadding="0">
					<tr>
						<td width="10%" align="left" valign="middle">
							<img src="../images/paginas/icon-permissao.png" alt="icon-permissao" />
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
			<!--/tabela:filtro-pesquisa/-->
			<table width="1000" class="table_info">
				<tr>
					<th align="center" valign="middle" colspan="6">
						PERMISSÃO PARA O USUÁRIO
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
				<td align="left" valign="middle" class="td_info" width="75%">
				<strong>USUÁRIO: <span style="text-transform:uppercase;"><?= $usuario ?></span></strong>
				</td>
				<tr>
					<td colspan="2" class="th_info"></td>
				</tr>
			</table>
			<!--/tabela:fim/-->
			<!--/fomulário:usuario-permissão/-->
			<form name="form" action="" method="POST" enctype="multipart/form-data">
				<!--/tabela:lista/-->
				<table width="1000" class="table_list">
					<tr>
						<td width="800" align="left" valign="middle">Permissão</td>
						<td width="100" align="center" valign="middle">Pertence</td>
						<td width="100" align="center" valign="middle">Supervisor</td>
					</tr>
					<tr>
						<td class="td_list" colspan="3"></td>
					</tr>
					<? 
					$cont_seg=0;
					$cont_sub=0;
					$sql = $objQuery->SQLQuery("SELECT * FROM cp_permissao as p WHERE p.st_id='1' AND p.id_permissao!='1' ".$onde." ORDER BY p.id_permissao");
					while($res = mysql_fetch_array($sql)){
					?>
					<tr onmouseover="this.bgColor='#EEEEEE';" onmouseout="this.bgColor='#FFFFFF';">
						<td align="left" valign="middle"><?= $res['permitir'] ?></td>
						<td align="center" valign="middle">
						<input type="checkbox" name="pertence_<?= $res['id_permissao'] ?>" <? if(in_array($res['id_permissao'], $permissao_p)) echo ' checked="checked"'; ?> title="Clique aqui" />
						</td>
						<td align="center" valign="middle">
						<input type="checkbox" name="supervisor_<?= $res['id_permissao'] ?>" <? if(in_array($res['id_permissao'], $permissao_s)) echo ' checked="checked"'; ?> title="Clique aqui" />
						</td>
					</tr>
					<?
					}
					?>
					<tr>
						<td align="center" valign="middle" colspan="3">
						<input type="submit" name="submit1" value=" Atualizar "/>
						<input type="hidden" name="id" value="<?= $id ?>"/>
						</td>
					</tr>
				</table>
				<!--/tabela:fim/-->
			</form>
			<!--/fomulário:fim/-->
		</div>
	</div>
</div>
<?
require_once('../includes/footer.php');
?>