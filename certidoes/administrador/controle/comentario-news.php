<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'news';
$title_pg = 'Lista: Comentários';
$mesclar = '15';
require_once('../includes/header.php');
pt_register("GET","busca_dados");
pt_register("GET","busca_data");
pt_register("GET","busca_status");
pt_register('GET','id');
pt_register('POST','id');
pt_register('POST','deleta');
pt_register('GET','pagina');
pt_register('POST','submit1');

$permissao = verifica_permissao('lista_comentario',$controle_permissao_p,$controle_permissao_s);
if($permissao == 'FALSE'){ 
	require_once('resposta-permissao.php');
	exit;
}
if($deleta<>'' and in_array('9', $excluir_permissao_s)){
	$query = $objQuery->SQLQuery("SELECT * FROM cp_comentario_news as cm WHERE cm.id_comentario ='".$id."'");
	$num = mysql_num_rows($query);
	if($num<>''){
		$res = mysql_fetch_array($query);
		$file_path = "../../upload/".$res['imagem'];
		if(file_exists($file_path)) unlink($file_path);
		$sql = $objQuery->SQLQuery("DELETE FROM cp_comentario_news WHERE id_comentario ='".$id."'");
	}
}
if($submit1){
	$id_anunc = explode(',', $_POST['id_anunc']);
	for($i = 0; $i < count($id_anunc)-1; $i++){
		pt_register('POST','alterar_status');
		if($errors!=1){
			$objQuery->SQLQuery("UPDATE cp_comentario_news SET st_id='".$alterar_status."' WHERE id_comentario='".$id_anunc[$i]."'");
			$id = $objQuery->ID;
			$done=1;
		}
	}
	$id = $_GET['id_news'];
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
				<a href="#" title="Clique aqui para avançar" class="next"><img src="../images/paginas/proximo.png" alt="proximo" /></a>
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
								<a href="javascript:history.back()" title="Clique aqui" class="link_normal">Voltar para página anterior</a>
							</td>
						</tr>
						<?
						$permissao = verifica_permissao('editar_comentario',$controle_permissao_p,$controle_permissao_s);
						if($permissao == 'TRUE'){
						?>
						<!--/fomulário:alterar-status/-->
						<form name="form" action="?id_news=<?=$id?>" method="POST" enctype="multipart/form-data">
						<th align="center" valign="middle" colspan="2"><label for="alterar_status" accesskey="1">ALTERAR STATUS</label></th>
						<tr>
							<td align="left" valign="middle" height="25" colspan="2">
							<select name="alterar_status" id="alterar_status" style="margin-top:5px;margin-bottom:5px;" title="Selecione um status">
							<option value="">---</option>
							<?
							$sql = $objQuery->SQLQuery("SELECT * FROM cp_status as st ORDER BY st.st_id");
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
						<!--/fomulário:fim/-->
						<?}?>
					</table>
					<!--/tabela:fim/-->
				</td>
				<!--/divisão/-->
				<td align="center" valign="top" class="td_info" width="75%">
				<!--/fomulário:filtro-pesquisa/-->
				<form name="form" action="" method="GET" enctype="multipart/form-data">
					<!--/tabela:lado-right/-->
					<table width="100%" border="0">
						<tr>
							<td colspan="2"><label for="busca_dados" accesskey="1">Busca (ID / Título da notícia)</label></td>
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
				<!--/fomulário:fim/-->
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
					<td width="440" align="left" valign="middle">Título da notícia</td>
					<td width="220" align="left" valign="middle">Nome</td>
					<td width="200" align="left" valign="middle">Email</td>
					<td width="40" align="center" valign="middle">Cadastro</td>
					<td width="40" align="center" valign="middle">Status</td>
					<td width="40" align="center" valign="middle">Editar</td>
					<? if(in_array('9', $excluir_permissao_s)){ ?>
					<td width="40" align="center" valign="middle">Excluir</td>
					<? } ?>
				</tr>
				<tr>
					<td class="td_list" colspan="<?= $mesclar?>"></td>
				</tr>
				<?
				$onde ="";
				if($busca_dados<>''){$onde .= " and (ns.id_news like '".$busca_dados."' or ns.titulo_news like '".$busca_dados."%') ";}
				if($busca_data<>''){$onde .= " and date_format(cm.data, '%d/%m/%Y') = '".$busca_data."' ";}
				if($busca_status<>''){$onde .= " and cm.st_id='".$busca_status."'";}
				$condicao = "FROM cp_news_nova as ns, cp_comentario_news as cm, cp_status as st WHERE ns.id_news=cm.id_news AND cm.st_id=st.st_id AND ns.id_news='".$id."' " .$onde. " ORDER BY cm.id_comentario DESC";
				$campo = "ns.id_news, ns.titulo_news, st.st_id, st.status, cm.id_comentario, cm.nome, cm.email, date_format(cm.data, '%d/%m/%Y') as data, cm.st_id";
				$url_busca = $_SERVER['REQUEST_URI'];
				$url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
				$url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
				$query = $objQuery->paginacao( $campo , $condicao, $pagina , $url_busca, 20);
				$p_valor = "";
				$i = 0;
				while($res = mysql_fetch_array($query)){ 
					$p_valor .= '
					<tr onmouseover="this.bgColor=\'#EEEEEE\';" onmouseout="this.bgColor=\'#FFFFFF\';">
						<td align="left" valign="middle"><input value="'.$res["id_comentario"].'" type="checkbox" name="checklister" id="checklister'.$i.'" title="Clique aqui para selecionar o registro" /></td>
						<td align="center" valign="middle">' . $res["id_comentario"] . '</td>
						<td align="left" valign="middle">' . $res["titulo_news"] . '</td>
						<td align="left" valign="middle">' . $res["nome"] . '</td>
						<td align="left" valign="middle">' . $res["email"] . '</td>
						<td align="center" valign="middle">' . $res["data"] . '</td>
						<td align="center" valign="middle">' . $res["status"] . '</td>
						<td align="center" valign="middle"><a href="comentario-news-edit.php?id=' . $res["id_comentario"] . '" title="Clique aqui"><img src="../images/paginas/bt-editar.png" alt="bt-editar" /></a></td>';
						if(in_array('7', $excluir_permissao_s)){
						$p_valor .= '
						<form name="form" action="" method="POST" enctype="multipart/form-data" onsubmit="return confirm(\'Deseja excluir este registro ?\');">
							<td align="center" valign="middle">
								<input type="hidden" name="id" value="'.$res["id_comentario"].'" />
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
					<td align="center" valign="middle" colspan="<?= $mesclar?>">
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