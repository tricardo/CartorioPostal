<?
require "../includes/topo.php";
pt_register('GET','id');

?>
<table width="920" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
<td colspan="3" height="2"></td>
</tr>
<tr>
<td width="150" align="left" valign="top">
	<table width="150" border="0" cellspacing="0" cellpadding="0" align="left">
	<tr>
	<td><? require "menu_lateral.php"; ?></td>
	</tr>
	</table>
</td>
<td width="2"></td>
<td align="left" valign="top">
	<table width="768" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td width="764" align="center" valign="top" background="../images/paginas/index/barra_de_titulo1.png">
		<table width="768" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td width="345" height="20" align="left" valign="middle"><strong>Vídeo de Treinamento</strong></td>
		<td width="415" align="left" valign="middle"><span style="font-weight: bold">Franquia: <? echo $safpostal_fantasia ?></span></td>
		</tr>
		</table>
	</td>
	</tr>
	<tr>
	<td>
		<div id="conteudo_forum_list">

		<?
		$p_valor = "";
		$sql = $objQuery->SQLQuery("SELECT * FROM saf_treinamento as n WHERE n.id_treinamento='". $id ."' and n.status='1'");
		$num = mysql_num_rows($sql);
		$res = mysql_fetch_array($sql);

		$p_valor .= '
		<table border="0" width="100%" cellpadding="0" cellspacing="0" id="alter">
		<tr>
		<td width="100%" align="left" valign="middle" height="25" bgcolor="#0099FF">Assunto: <b>' . $res['titulo'] . '</b></td>
		</tr>
		<tr>
		<td width="100%" align="left" valign="middle" height="25" bgcolor="#0099FF"><h1>Obs:</h1>' . $res['obs'] . '<br><br></td>
		</tr>		
		<tr class="dif">
		<td width="100%" align="left" valign="middle">' . $res['video'] . '<a href="treino_video.php"><h2>Clique aqui para voltar</h2></a></td>
		</tr>
		</table>';
		echo $p_valor;
		?>
		</div>
	</td>
	</tr>
	</table>

</td>
</tr>    
</table>

<?
require "../includes/rodape.php";
?>