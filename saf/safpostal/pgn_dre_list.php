<?
require "../includes/topo.php";
pt_register("GET","busca_titulo");
pt_register("GET","busca_id_empresa");
pt_register('POST','deleta');

if ($deleta<>''){
	pt_register('POST','id');
	$query = $objQuery->SQLQuery("SELECT arquivo FROM saf_pgn_dre WHERE id_upload ='".$id."'");
	$num = mysql_num_rows($query);
	
	if($num<>'') {

   	   $res = mysql_fetch_array($query);
	   $arquivo = $res['arquivo'];
	   $file_path = '../pgn_dre_upload/';
	   if (file_exists($file_path.$arquivo) and $arquivo<>'') unlink($file_path.$arquivo);

	$sql = $objQuery->SQLQuery("DELETE FROM saf_pgn_dre WHERE id_upload ='".$id."'");
	}
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
            <td width="345" height="20" align="left" valign="middle"><strong>PGN/DRE</strong></td>
            <td width="415" align="left" valign="middle"><span style="font-weight: bold">Franquia: <? echo $safpostal_fantasia ?></span></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>
        <div id="conteudo">
		
        <form name="form_ftp_list" action="" method="GET" enctype="multipart/form-data">
        <table align="center" border="0" cellpadding="3" cellspacing="0" width="332">
        <tr>
        <td height="50" colspan="5" align="center" valign="middle">
        <strong>PGN/DRE - LISTA DE DOWNLOADS</strong></td>
        </tr>
        <tr>
        <td width="40">Título:</td>
        <td width="187"><input type="text" name="busca_titulo" value="<?= $busca_titulo ?>" style="width:300px"></td>
        <td width="89">Franquia:</td>
        <td width="200">
        <select name="busca_id_empresa" style="width:265px">
        <option value="">Todas</option>
        <?
        $sql = $objQuery->SQLQuery("SELECT id_empresa, fantasia FROM vsites_user_empresa as ue WHERE status = 'Ativo' ORDER BY fantasia ");
		
		while($res = mysql_fetch_array($sql)){
			echo '<option value="'.$res['id_empresa'].'" ';
			
				if($id_empresa==$res['id_empresa']) echo ' selected="selected"'; 
				echo '>'.$res['fantasia'].'</option>';			
			}
		?>
          </select></td>
          <td><input type="submit" name="submit1" value="Buscar" />
        </tr>
        <tr>
          <td height="10" colspan="4"></td>
          </tr>
        </table>
        </form>
<table align="center" border="0" cellpadding="3" cellspacing="1" width="750" bgcolor="#0071B6">
        <tr>
        <td width="520" align="left" valign="middle" bgcolor="#CEEDFF"><strong>Arquivos</strong></td>
        <td align="center" valign="middle" bgcolor="#CEEDFF"><strong>Data  da Inserção</strong></td>
        <td width="10" align="center" valign="middle" bgcolor="#CEEDFF"><strong>Excluir</strong></td>
        <td width="10" align="center" valign="middle" bgcolor="#CEEDFF"><strong>Baixar</strong></td>
        </tr>
<?
$onde ="";

if($busca_titulo<>''){$onde .= " and u.titulo like '%".$busca_titulo."%' ";}
if($busca_id_empresa<>'' and $safpostal_id_empresa=='1'){$onde .= " and u.id_empresa='$busca_id_empresa' ";}
if($safpostal_id_empresa!="1"){$onde.="and (u.id_usuario = '$safpostal_id_usuario' or u.id_usuario='0') ";}

$condicao = "FROM saf_pgn_dre as u WHERE 1=1 ".$onde." ORDER BY titulo ASC ";

$campo = "u.id_usuario, u.arquivo, u.id_upload, u.id_empresa, u.titulo, u.extensao, date_format(data, '%d/%m/%y %h:%m:%s') as data";

pt_register('GET','pagina');
$url_busca = $_SERVER['REQUEST_URI'];
$url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
$url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
$query = $objQuery->paginacao( $campo , $condicao, $pagina , $url_busca);

while($res = mysql_fetch_array($query)){ 

	echo '<tr>';
	echo '<td class="result_celula" bgcolor="#EAF8FF" align="left">' . $res["titulo"] . '</td>';
	echo '<td class="result_celula" bgcolor="#EAF8FF" align="center">' . $res["data"] . '</td>';
	echo '<form action="" method="post" onsubmit="return confirmDelete();" enctype="multipart/form-data" >	
		  <td class="result_celula" bgcolor="#EAF8FF" align="center" valign="middle">
		  <input type="hidden" name="id" value="'.$res["id_upload"].'">
		  <input type="hidden" name="deleta" value="Deletar" /> 
	      <input type="image" src="../images/paginas/ftp/deletar.png" name="deletar" value="Deletar" alt="Deletar" /></td>';
	echo '<td class="result_celula" bgcolor="#EAF8FF" align="center" valign="middle">
	<a href="../ftp_upload/' . $res["arquivo"] . '" title="Clique aqui"><img src="../images/extensoes/' . $res["extensao"] . '.png" border="0"/></a></td>
	      </form>';
	echo '</tr>';
}
?>
</table>
</div>

</div>
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