<?
require "../includes/topo.php";
$permissao = verifica_permissao('FORUM',$safpostal_departamento_saf);
if($permissao == 'FALSE' or $safpostal_id_empresa!='1'){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
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
            <td width="345" height="20" align="left" valign="middle"><strong>Perguntas e Respostas</strong></td>
            <td width="415" align="left" valign="middle"><span style="font-weight: bold">Franquia: <? echo $safpostal_fantasia ?></span></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>
        <div id="conteudo_forum_list">
		
        <div id="titulo_forum_list"><strong>
        <table border="0" width="100%" cellpadding="0" cellspacing="0">
        <tr>
        <td width="60%" align="left" valign="middle">Tópicos</td>
        </tr>
        </table>
         </strong></div>
<table border="0" width="100%" cellpadding="0" cellspacing="0" id="alter">		 
<?
$onde ="";

if($busca_status<>'' and $safpostal_id_empresa=="1"){
	$onde .= " and f.status='$busca_status'"; 
} else {
	$onde .= " and f.status!='Excluído'"; 
} 

if($busca<>''){$onde .= " and (f.titulo like '%$busca%' or pergunta like '%$busca%')";}

$condicao = "FROM saf_forum as f WHERE 1=1 " . $onde . " ORDER BY titulo DESC ";

$campo = "(select COUNT(fr.id_forum_resposta) as pendentes from saf_forum_resposta as fr where fr.id_forum = f.id_forum and fr.status = 'Pendente') as pendente, f.titulo, f.id_forum, date_format(f.data, '%d/%m/%y') as data";

pt_register('GET','pagina');
$url_busca = $_SERVER['REQUEST_URI'];
$url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
$url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
$query = $objQuery->paginacao( $campo , $condicao, $pagina , $url_busca);
$p_valor = "";
while($res = mysql_fetch_array($query)){ 
		$p_valor .= '<tr>
		<td align="left" valign="middle" height="25"><a href="forum_respostas_edit.php?id=' . $res['id_forum'] . '" style="display:block" title="Clique aqui"><b>' . $res['data'] . ' - [' . $res['pendente'] . ']</b> - ' . $res['titulo'] . '</a></td>
		<tr>';
}
echo $p_valor;
?>
</table>
</table>
    </td>
  </tr>
</table>
</td>
      </tr>
    </table>
   </td>
  </tr>
</table>

<?
require "../includes/rodape.php";
?>