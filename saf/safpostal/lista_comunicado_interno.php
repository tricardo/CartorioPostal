<?
require "../includes/topo.php";
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
    <td align="left" valign="top"><table width="768" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="764" align="center" valign="top" background="../images/paginas/index/barra_de_titulo1.png"><table width="768" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="345" height="20" align="left" valign="middle"><strong>P�gina inicial</strong></td>
            <td width="415" align="left" valign="middle"><span style="font-weight: bold">Franquia: <? echo $safpostal_fantasia ?></span></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="center" valign="middle">
        <table border="0" width="100%"  cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
        <tr>
        <td>
			<table border="0" width="100%" align="center" cellspacing="0" cellpadding="0">
			<tr>
			<td align="left" valign="middle" width="17%" height="30" bgcolor="#E5E5E5"><strong>N� de Comunicado</strong></td>
			<td align="left" valign="middle" width="55%" height="30" bgcolor="#E5E5E5"><strong>Assunto</strong></td>
			<td width="19%" align="center" valign="middle"  bgcolor="#E5E5E5"><strong>Data</strong></td>
			<td width="9%" align="center" valign="middle"  bgcolor="#E5E5E5"><strong>Visualizar</strong></td>
			</tr>
			<?
			$onde ="";
			$condicao = "FROM saf_comunicado_int as m ORDER BY m.id_maladireta DESC ";
			$campo = "m.id_maladireta, m.assunto, m.texto, date_format(m.data, '%d/%m/%y %h:%m:%s') as data";
			pt_register('GET','pagina');
			$url_busca = $_SERVER['REQUEST_URI'];
			$url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
			$url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
			$query = $objQuery->paginacao($campo, $condicao, $pagina, $url_busca, 18);
			$p_valor = "";
			while($res = mysql_fetch_array($query)){
				$p_valor .= '
				<tr>
				<td align="left" bgcolor="#FFFFFF">Comunicado ' . $res["id_maladireta"] . '</td>
				<td align="left" bgcolor="#FFFFFF">' . $res["assunto"] . '</td>
				<td align="center" bgcolor="#FFFFFF">' . $res["data"] . '</td>
				<td align="center"><a href="lista_comunicado_imprimir_int.php?id=' . $res["id_maladireta"] . '" title="Clique aqui" target="_blank"><img src="../images/estrutura/botoes/pesquisar_orcamento.png" border="0" width="30" height="30"/></a></td>
				</tr>';
			}
			echo $p_valor;
			?>
			<tr>
			<td colspan="3" align="center" height="20" bgcolor="#FFFFFF">
			<?
			$objQuery->QTDPagina();
			?>
			</td>
			</tr>
			</table>
        </td>
        </tr>
        </table>
        </td>
      </tr>
    </table></td>
  </tr>
</table>

<?
require "../includes/rodape.php";
?>