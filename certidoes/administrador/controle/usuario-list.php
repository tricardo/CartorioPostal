<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'administrador';
$title_pg = 'Lista: Usu�rio(s)';
require_once('../includes/header.php');
pt_register("GET","busca_dados");
pt_register("GET","busca_data");
pt_register("GET","busca_status");
pt_register('POST','id');
pt_register('POST','deleta');
pt_register('GET','pagina');
pt_register('POST','submit1');

$permissao = verifica_permissao('lista_usuario',$controle_permissao_p,$controle_permissao_s);
if($permissao == 'FALSE'){ 
	require_once('resposta-permissao.php');
	exit;
}
if($deleta<>'' and in_array('2', $excluir_permissao_s)){
	$query = $objQuery->SQLQuery("SELECT * FROM cp_user as us WHERE us.id_usuario ='".$id."'");
	$num = mysql_num_rows($query);
	if($num<>''){
		$res = mysql_fetch_array($query);
		$sql = $objQuery->SQLQuery("DELETE FROM cp_user WHERE id_usuario ='".$id."'");
	}
}
if($submit1){
	$id_anunc = explode(',', $_POST['id_anunc']);
	for($i = 0; $i < count($id_anunc)-1; $i++){
		pt_register('POST','alterar_status');
		if($errors!=1){
			$objQuery->SQLQuery("UPDATE cp_user SET st_id ='".$alterar_status."' WHERE id_usuario='".$id_anunc[$i]."'");
			$id = $objQuery->ID;
			$done=1;
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
							<img src="../images/paginas/icon-list.png" alt="icon-list" />
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
				<a href="#" title="Clique aqui para avan�ar" class="next"><img src="../images/paginas/proximo.png" alt="proximo" /></a>
			</div>
		</div>
		<div class="pages">
			<!--/tabela:filtro-pesquisa/-->
			<table width="1000" class="table_info">
				<tr>
					<th align="center" valign="middle" colspan="6">
						FILTRO DE PESQUISA
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
								<a href="javascript:history.back()" title="Clique aqui" class="link_normal">Voltar para p�gina anterior</a>
							</td>
						</tr>
						<tr>
							<?
							$permissao = verifica_permissao('cadastro_usuarios',$controle_permissao_p,$controle_permissao_s);
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
										$permissao = verifica_permissao('cadastro_usuarios',$controle_permissao_p,$controle_permissao_s);
										if($permissao == 'TRUE'){
										?>
										<a href="usuario-add.php" title="Clique aqui" class="link_lista">Cadastro: Usu�rios</a>
										<?}?>
									</li>
								</ul>
							</td>
						</tr>
						<?
						$permissao = verifica_permissao('editar_usuario',$controle_permissao_p,$controle_permissao_s);
						if($permissao == 'TRUE'){
						?>
						<!--/fomul�rio:alterar-status/-->
						<form name="form" action="" method="POST" enctype="multipart/form-data">
						<th align="center" valign="middle" colspan="2"><label for="alterar_status" accesskey="1">ALTERAR STATUS</label></th>
						<tr>
							<td align="left" valign="middle" height="25" colspan="2">
							<select name="alterar_status" id="alterar_status" style="margin-top:5px;margin-bottom:5px;">
							<option value="">---</option>
							<?
							$sql = $objQuery->SQLQuery("SELECT * FROM cp_status_user as su ORDER BY su.st_id ASC");
							while($res = mysql_fetch_array($sql)){
								echo '<option value="'.$res['st_id'].'"';
								if($alterar_status==$res['st_id']) echo 'selected="selected"'; 
								echo '>'.$res['status'].'</option>';
							}
							?>
							</select>
							<input type="submit" name="submit1" value="Alterar" onclick="VerificaCheckSel();" style="height:30px" title="Clique aqui para alterar o status" />
							<input type="hidden" name="id_anunc" id="id_anunc" />
							</td>
						</tr>
						</form>
						<!--/fomul�rio:fim/-->
						<?}?>
					</table>
					<!--/tabela:fim/-->
				</td>
				<!--/divis�o/-->
				<td align="center" valign="top" class="td_info" width="75%">
				<!--/fomul�rio:filtro-pesquisa/-->
				<form name="form" action="" method="GET" enctype="multipart/form-data">
					<!--/tabela:lado-right/-->
					<table width="100%" border="0">
						<tr>
							<td colspan="2"><label for="busca_dados" accesskey="1">Busca (ID / Usu�rio / E-mail)</label></td>
							<td width="13%" rowspan="4" align="center" valign="middle"><input type="submit" name="submit1" id="search" value=" " title="Clique aqui para fazer a pesquisa" /></td>
						</tr>
						<tr>
							<td colspan="2" align="left" valign="middle"><input name="busca_dados" type="text" id="busca_dados" value="<?= $busca_dados?>" /></td>
						</tr>
						<tr>
							<td width="45%"><label for="busca_data" accesskey="3">Cadastro</label></td>
							<td width="42%"><label for="busca_status" accesskey="2">Status</label></td>
						</tr>
						<tr>
							<td><input name="busca_data" type="text" id="busca_data" value="<?= $busca_data?>" /></td>
							<td>
								<select name="busca_status" id="busca_status">
									<option value="">Todos</option>
									<?
									$sql = $objQuery->SQLQuery("SELECT * FROM cp_status_user as su ORDER BY su.st_id ASC");
									while($res = mysql_fetch_array($sql)){
										echo '<option value="'.$res['st_id'].'"';
										if($busca_status==$res['st_id']) echo 'selected="selected"'; 
										echo '>'.$res['status'].'</option>';
									}
									?>
								</select>
							</td>
						</tr>
					</table>
				  <!--/tabela:fim/-->
				</form>
				<!--/fomul�rio:fim/-->
				</td>
				<tr>
					<td colspan="2" class="th_info"></td>
				</tr>
			</table>
			<!--/tabela:fim/-->
			<!--/tabela:lista/-->
			<table width="1000" class="table_list">
				<tr>
					<td width="20" align="left" >
					<input type="checkbox" name="" onclick="checkall(1);" id="chk1" title="Clique aqui para selecionar todos os registros" />
					<input type="checkbox" name="" onclick="checkall(0);" id="chk0" style="display:none" title="Clique aqui para selecionar o registro" />
					</td>
					<td width="20" align="center" valign="middle">ID</td>
					<td width="360" align="left" valign="middle">Usu�rio</td>
					<td width="360" align="left" valign="middle">Email</td>
					<?
					$permissao = verifica_permissao('usuario_permissao',$controle_permissao_p,$controle_permissao_s);
					if($permissao == 'TRUE'){
					?>
					<td width="40" align="center" valign="middle">Permiss�o</td>
					<?}?>
					<?
					$permissao = verifica_permissao('enviar_senha',$controle_permissao_p,$controle_permissao_s);
					if($permissao == 'TRUE'){
					?>
					<td width="40" align="center" valign="middle">Senha</td>
					<?}?>
					<td width="40" align="center" valign="middle">Cadastro</td>
					<td width="40" align="center" valign="middle">Status</td>
					<?
					$permissao = verifica_permissao('editar_usuario',$controle_permissao_p,$controle_permissao_s);
					if($permissao == 'TRUE'){
					?>
					<td width="40" align="center" valign="middle">Editar</td>
					<?}?>
					<? if(in_array('2', $excluir_permissao_s)){ ?>
					<td width="40" align="center" valign="middle">Excluir</td>
					<? } ?>
				</tr>
				<tr>
					<td class="td_list" colspan="10"></td>
				</tr>
				<?
				$onde ="";
				if($busca_dados<>''){$onde .= " and (us.id_usuario like '".$busca_dados."' or us.usuario like '".$busca_dados."%' or us.email like '".$busca_dados."%') ";}
				if($busca_data<>''){$onde .= " and date_format(us.data, '%d/%m/%Y') = '".$busca_data."' ";}
				if($busca_status<>''){$onde .= " and su.st_id ='".$busca_status."'";}
				$condicao = "FROM cp_user as us, cp_status_user as su WHERE us.st_id=su.st_id AND us.id_usuario!=1 AND us.id_usuario!='".$controle_id_usuario."' " .$onde. " ORDER BY us.id_usuario DESC";
				$campo = "us.id_usuario, us.usuario, us.email, su.st_id, su.status, date_format(us.data, '%d/%m/%Y') as data";
				$url_busca = $_SERVER['REQUEST_URI'];
				$url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
				$url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
				$query = $objQuery->paginacao( $campo , $condicao, $pagina , $url_busca, 20);
				$p_valor = "";
				$i = 0;
				while($res = mysql_fetch_array($query)){ 
					$p_valor .= '
					<tr onmouseover="this.bgColor=\'#EEEEEE\';" onmouseout="this.bgColor=\'#FFFFFF\';">
						<td align="left" valign="middle"><input value="'.$res["id_usuario"].'" type="checkbox" name="checklister" id="checklister'.$i.'" title="Clique aqui para selecionar o registro" /></td>
						<td align="center" valign="middle">' . $res["id_usuario"] . '</td>
						<td align="left" valign="middle">' . $res["usuario"] . '</td>
						<td align="left" valign="middle">' . $res["email"] . '</td>';
						$permissao = verifica_permissao('usuario_permissao',$controle_permissao_p,$controle_permissao_s);
						if($permissao == 'TRUE'){
						$p_valor .='
						<td align="center" valign="middle"><a href="usuario-permissao.php?id=' . $res["id_usuario"] . '" title="Clique aqui"><img src="../images/paginas/bt-permissao.png" alt="bt-permissao" /></a></td>';
						}
						$permissao = verifica_permissao('enviar_senha',$controle_permissao_p,$controle_permissao_s);
						if($permissao == 'TRUE'){
						$p_valor .='
						<td align="center" valign="middle"><a href="envia-senha-user.php?id=' . $res["id_usuario"] . '" title="Clique aqui"><img src="../images/paginas/bt-enviar-senha.png" alt="bt-enviar-senha" /></a></td>';
						}
						$p_valor .='
						<td align="center" valign="middle">' . $res["data"] . '</td>
						<td align="center" valign="middle">' . $res["status"] . '</td>';
						$permissao = verifica_permissao('editar_usuario',$controle_permissao_p,$controle_permissao_s);
						if($permissao == 'TRUE'){
						$p_valor .='
						<td align="center" valign="middle"><a href="usuario-edit.php?id=' . $res["id_usuario"] . '" title="Clique aqui"><img src="../images/paginas/bt-editar.png" alt="bt-editar"/></a></td>';
						}
						if(in_array('2', $excluir_permissao_s)){
						$p_valor .= '
						<form name="form" action="" method="POST" enctype="multipart/form-data" onsubmit="return confirm(\'Deseja excluir este registro ?\');">
							<td align="center" valign="middle">
								<input type="hidden" name="id" value="'.$res["id_usuario"].'" />
								<input type="hidden" name="deleta" value="Deletar" /> 
								<input type="image" src="../images/paginas/bt-deletar.png" name="deletar" value="Deletar" alt="bt-deletar" title="Clique aqui" />
							</td>
						</form>';
					}
					$p_valor .= '
					</tr>';
					$i++;
				}
				echo $p_valor;
				?>
				<tr>
					<td align="center" valign="middle" colspan="10">
					<?
					$objQuery->QTDPagina();
					?>
					<input type="hidden" value="<?= $i?>" id="totalcheck" />
					</td>
				</tr>
			</table>
			<!--/tabela:fim/-->
		</div>
	</div>
</div>
<?
require_once('../includes/footer.php');
?>