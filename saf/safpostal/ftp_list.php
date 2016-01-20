<?
require "../includes/topo.php";
pt_register("GET","busca_titulo");
pt_register("GET","busca_id_empresa");
pt_register("GET","busca_id_ftp_categoria");
pt_register('POST','deleta');

if ($deleta<>'' and in_array('5', $ext_departamento_saf) ){
	pt_register('POST','id');
	$query = $objQuery->SQLQuery("SELECT arquivo FROM saf_ftp as f WHERE id_upload ='".$id."'");
	$num = mysql_num_rows($query);
	
	if($num<>'') {

   	   $res = mysql_fetch_array($query);
	   $arquivo = $res['arquivo'];
	   $file_path = '../ftp_upload/';
	   if (file_exists($file_path.$arquivo) and $arquivo<>'') unlink($file_path.$arquivo);

	$sql = $objQuery->SQLQuery("DELETE FROM saf_ftp WHERE id_upload ='".$id."'");
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
            <td width="345" height="20" align="left" valign="middle"><strong>FTP</strong></td>
            <td width="415" align="left" valign="middle"><span style="font-weight: bold">Franquia: <? echo $safpostal_fantasia ?></span></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>
        <div id="conteudo">
		
        <form name="form_ftp_list" action="" method="GET" enctype="multipart/form-data">
        <table align="center" border="0" cellpadding="3" cellspacing="0" width="100%">
        
        <tr>
          <td colspan="6" align="center" valign="middle"><strong>FTP - LISTA DE DOWNLOADS</strong></td>
          </tr>
        <tr>
        <td width="40">Título:</td>
        <td width="187"><input type="text" name="busca_titulo" value="<?= $busca_titulo ?>" style="width:150px"></td>
        <td width="89" align="right"><? if($safpostal_id_empresa=='1'){ ?> Franquia: <? } ?></td>
        <td width="200">
		<? 
		if($safpostal_id_empresa=='1'){
		?>
        <select name="busca_id_empresa" style="width:315px">
        <option value="">Todas</option>
		<option value="0" <? if($busca_id_empresa=='0') echo ' selected="selected"'; ?> >Arquivos Comuns</option>
        <?
        $sql = $objQuery->SQLQuery("SELECT id_empresa, fantasia FROM vsites_user_empresa as ue WHERE status = 'Ativo' or status = 'Inativo' ORDER BY fantasia ");
		
		while($res = mysql_fetch_array($sql)){
			echo '<option value="'.$res['id_empresa'].'" ';
			
			if($busca_id_empresa==$res['id_empresa']) echo ' selected="selected"'; 
			echo '>'.$res['fantasia'].'</option>';			
		}
		?>
        </select>
		</td>
		 <td>
		  <? } ?>
		  <select name="busca_id_ftp_categoria">
		  <option value="">Todas</option>
        	<?
        $sql = $objQuery->SQLQuery("SELECT * FROM  saf_ftp_categoria as fc ORDER BY id_ftp_categoria");
		
		while($res = mysql_fetch_array($sql)){
			echo '<option value="'.$res['id_ftp_categoria'].'"';
			
				if($busca_id_ftp_categoria==$res['id_ftp_categoria']) echo 'selected="selected"'; 
				echo '>'.$res['ftp_categoria'].'</option>';			
			}
		   ?>
          </select>		  </td>
          <td><input type="submit" name="submit1" value="Buscar" />        </tr>
        <tr>
          <td height="6" colspan="6"></td>
          </tr>
        </table>
        </form>
<table align="center" border="0" cellpadding="3" cellspacing="1" width="750" bgcolor="#0071B6">
        <tr>
        <td width="520" align="left" valign="middle" bgcolor="#CEEDFF"><strong>Arquivos</strong></td>
		<td width="100" align="center" valign="middle" bgcolor="#CEEDFF"><strong>Departamento</strong></td>
        <td align="center" valign="middle" bgcolor="#CEEDFF"><strong>Data  da Inserção</strong></td>
        <td width="10" align="center" valign="middle" bgcolor="#CEEDFF"><strong>Baixar</strong></td>
		<? 	if(in_array('5', $ext_departamento_saf)){ ?>
		<td width="10" align="center" valign="middle" bgcolor="#CEEDFF"><strong>Excluir</strong></td>
		<? } ?>
        </tr>
<?
$onde ="";

if($busca_titulo<>''){$onde .= " and f.titulo like '%".$busca_titulo."%' ";}
if($busca_id_empresa<>'' and $safpostal_id_empresa=='1'){$onde .= " and f.id_empresa='$busca_id_empresa' ";}
if($busca_id_ftp_categoria<>''){$onde .= " and fc.id_ftp_categoria='".$busca_id_ftp_categoria."'"; }
if($safpostal_id_empresa!="1"){$onde.=" and (f.id_empresa = '".$safpostal_id_empresa."' or f.id_empresa='0') ";}

$condicao = "FROM saf_ftp as f LEFT JOIN saf_ftp_categoria AS fc ON f.id_ftp_categoria=fc.id_ftp_categoria WHERE 1=1 ".$onde." ORDER BY date_format(data, '%y-%m-%d') DESC ";

$campo = "fc.ftp_categoria, f.id_usuario, f.arquivo, f.id_upload, f.id_empresa, f.id_ftp_categoria, f.titulo, f.extensao, date_format(data, '%d/%m/%y') as data";

pt_register('GET','pagina');
$url_busca = $_SERVER['REQUEST_URI'];
$url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
$url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
$query = $objQuery->paginacao( $campo , $condicao, $pagina , $url_busca);
$p_valor = "";
while($res = mysql_fetch_array($query)){ 

	$p_valor .= '<tr>
	<td class="result_celula" bgcolor="#EAF8FF" align="left">' . $res["titulo"] . '</td>
	<td class="result_celula" bgcolor="#EAF8FF" align="center">' . $res["ftp_categoria"] . '</td>
	<td class="result_celula" bgcolor="#EAF8FF" align="center">' . $res["data"] . '</td>
    <td class="result_celula" bgcolor="#EAF8FF" align="center" valign="middle">
	<a href="../ftp_upload/' . $res["arquivo"] . '" title="Clique aqui"><img src="../images/extensoes/' . $res["extensao"] . '.png" border="0"/></a></td>';
	
	if(in_array('5', $ext_departamento_saf)){
	$p_valor .= '<form action="" method="post" onsubmit="return confirmDelete();" enctype="multipart/form-data" >	
		<td class="result_celula" bgcolor="#EAF8FF" align="center" valign="middle">
		  <input type="hidden" name="id" value="'.$res["id_upload"].'">
		  <input type="hidden" name="deleta" value="Deletar" /> 
	      <input type="image" src="../images/paginas/ftp/deletar.png" name="deletar" value="Deletar" alt="Deletar" /></td>
	      </form>
		  ';
	}	  
	$p_valor .= '</tr>';
}
echo $p_valor;
?><tr>
			<td colspan="9" align="center" class="barra_busca" bgcolor="#FFFFFF">
				<?
                    $objQuery->QTDPagina();
                ?>			
            </td>
		</tr>
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