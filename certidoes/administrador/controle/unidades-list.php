<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'unidades';
$title_pg = 'Lista: Unidades';
$mesclar = '15';
require_once('../includes/header.php');
pt_register('POST','id');
pt_register('POST','deleta');
pt_register('GET','pagina');
pt_register('POST','submit1');

$permissao = verifica_permissao('lista_unidades',$controle_permissao_p,$controle_permissao_s);
if($permissao == 'FALSE'){ 
	require_once('resposta-permissao.php');
	exit;
}
if($deleta<>'' and in_array('6', $excluir_permissao_s)){
	$query = $objQuery->SQLQuery("SELECT * FROM cp_unidades as un WHERE un.id_unidades ='".$id."'");
	$num = mysql_num_rows($query);
	if($num<>''){
		$res = mysql_fetch_array($query);
		$sql = $objQuery->SQLQuery("DELETE FROM cp_unidades WHERE id_unidades ='".$id."'");
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
						<tr>
							<?
							$permissao = verifica_permissao('cadastro_treinadores',$cp_permissao_p,$cp_permissao_s);
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
										$permissao = verifica_permissao('cadastro_unidades',$cp_permissao_p,$cp_permissao_s);
										if($permissao == 'TRUE'){
										?>
										<a href="unidades-add.php" title="Clique aqui" class="link_lista">Cadastro: Unidades</a>
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
				
				</td>
				<tr>
					<td colspan="2" class="th_info"></td>
				</tr>
			</table>
			<!--/tabela:fim/-->
			<!--/tabela:lista/-->
			<table width="1000" class="table_list">
				<tr>
					<td width="17" align="center" valign="middle">ID</td>
					<td width="191" align="left" valign="middle">Usuário</td>
					<td width="690" align="left" valign="middle">Total</td>
					<td width="36" align="center" valign="middle">Editar</td>
					<? if(in_array('6', $excluir_permissao_s)){ ?>
					<td width="42" align="center" valign="middle">Excluir</td>
				  <? } ?>
				</tr>
				<tr>
					<td class="td_list" colspan="<?= $mesclar?>"></td>
				</tr>
				<?
				$condicao = "FROM cp_user as uu, cp_unidades as un WHERE un.id_usuario=uu.id_usuario ORDER BY un.id_unidades DESC";
				$campo = "uu.id_usuario, uu.usuario, un.id_unidades, un.total";
				$url_busca = $_SERVER['REQUEST_URI'];
				$url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
				$url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
				$query = $objQuery->paginacao( $campo , $condicao, $pagina , $url_busca, 20);
				$p_valor = "";
				$i = 0;
				while($res = mysql_fetch_array($query)){
					$p_valor .= '
					<tr onmouseover="this.bgColor=\'#EEEEEE\';" onmouseout="this.bgColor=\'#FFFFFF\';">
						<td align="center" valign="middle">' . $res["id_unidades"] . '</td>
						<td align="left" valign="middle">' . $res["usuario"] . '</td>
						<td align="left" valign="middle">' . $res["total"] . '</td>
						<td align="center" valign="middle"><a href="unidades-edit.php?id=' . $res["id_unidades"] . '" title="Clique aqui"><img src="../images/paginas/bt-editar.png" alt="bt-editar" /></a></td>';
						if(in_array('6', $excluir_permissao_s)){
						$p_valor .= '
						<form name="form" action="" method="POST" enctype="multipart/form-data" onsubmit="return confirm(\'Deseja excluir este registro ?\');">
							<td align="center" valign="middle">
								<input type="hidden" name="id" value="'.$res["id_unidades"].'" />
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