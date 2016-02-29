<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'pagina_inicial';
$title_pg = 'Página Inicial';
require_once('../includes/header.php');
?>
<script type="text/javascript">
			$(function(){
			$("#fade").cycle({
				fx:'fade',
				speed:2500,
				timeout:5000
			})
		})
		</script>
<div class="estrutura">
	<div class="conteudo">
		<div class="fundo_menu_add">
				<div class="title_page">
					<!--/tabela:icone-titulo/-->
					<table width="100%" align="center" cellspacing="0" cellpadding="0">
						<tr>
							<td width="10%" align="left" valign="middle">
								<img src="../images/paginas/icon-home.png" alt="icon-home" />
							</td>
							<td width="90%" align="left" valign="middle">
								<span style="margin-left:5px;"><?= $title_pg?></span>
							</td>
						</tr>
					</table>
					<!--/tabela:fim/-->
				</div>
			</div>
		<div id="fade">
			<?
			#$d = array(1,2,3,4);
			#for($i = 0; $i < count($d); $i++){
			?>
			<!--<img src="../images/canal/image-<?=$d[$i]?>.png" alt="image-<?=$d[$i]?>" width="665" height="270" />//-->
			<?#}?>
		</div>
	</div>
</div>
<?
require_once('../includes/footer.php');
?>