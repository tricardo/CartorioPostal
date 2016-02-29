<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'depoimento';
$title_pg = 'Editar: Comentário';
require_once('../includes/header.php');
pt_register('GET','id');
pt_register('POST','submit1');
pt_register('POST','nome');
pt_register('POST','email');
pt_register('POST','depoimento');
pt_register('POST','status');

$permissao = verifica_permissao('editar_depoimento',$controle_permissao_p,$controle_permissao_s);
if($permissao == 'FALSE'){ 
	require_once('resposta-permissao.php');
	exit;
}

if($submit1){
	if($errors!=1){
		$objQuery->SQLQuery("UPDATE cp_depoimento SET nome='$nome', email='$email', depoimento='$depoimento', status='$status' WHERE id_depoimento='$id'");
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
						EDITAR DEPOIMENTO
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
					$sql = $objQuery->SQLQuery("SELECT dp.id_depoimento, dp.status, dp.nome, dp.email, dp.depoimento FROM cp_depoimento as dp WHERE dp.id_depoimento='" .$id. "'");
					$res = mysql_fetch_array($sql);
					$status	= $res['status'];
					$depoimento	= $res['depoimento'];
				?>
				<!--/fomulário:permissao-edit/-->
				<form name="form" action="" method="post" enctype="multipart/form-data">
					<!--/tabela:lado-right/-->
					<table width="100%">
						<tr>
							<td><label for="nome" accesskey="1">Nome</label></td>
							<td><label for="email" accesskey="2">Email</label></td>
						</tr>
						<tr>
							<td><input name="nome" type="text" id="nome" value="<?= $res['nome'];?>" /></td>
							<td><input name="email" type="text" id="email" value="<?= $res['email'];?>" /></td>
						</tr>
						<tr>
							<td colspan="2"><label for="depoimento" accesskey="3">Depoimento</label></td>
						</tr>
						<tr>
							<td colspan="2">
								<textarea name="depoimento" id="campo1" cols="" rows="" onkeyup="mostrarResultado(this.value,300,'spcontando1');contarCaracteres(this.value,300,'sprestante1','campo1')" <?=($errors['depoimento'])?'style="border:1px solid #FF0000;"':''; ?>><?= $depoimento;?></textarea><br />
								<span id="spcontando1">Ainda não temos nada digitado..</span><br />
								<span id="sprestante1"></span>
							</td>
						</tr>
						<tr>
							<td colspan="2"><label for="status" accesskey="4">Status</label></td>
						</tr>
						<tr>
							<td colspan="2">
								<select name="status" id="status">
									<option value="">Todos</option>
									<option value="1" <? if($status=='1') echo 'selected'; ?>>Ativar</option>
									<option value="0" <? if($status=='0') echo 'selected'; ?>>Inativo</option>
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