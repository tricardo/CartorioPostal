<?
require "../includes/topo.php";
pt_register("GET","busca_status");
pt_register("GET","busca_id_departamento");
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
            <td width="345" height="20" align="left" valign="middle"><strong>Help Desk</strong></td>
            <td width="415" align="left" valign="middle"><span style="font-weight: bold">Franquia: <? echo $safpostal_fantasia ?></span></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>
         <table align="center" border="0" cellpadding="3" cellspacing="0" width="550">
        <tr>
        <tr>
          <td height="30" colspan="5" align="center" valign="middle">
          <a href="helpdesk_at_add.php" title="Clique aqui"><strong>Cadastrar chamada</strong></a> |
<a href="helpdesk_at_list.php" title="Clique aqui"><strong>Meus chamados</strong></a></td>
        </tr>
        </tr>
        </table>
        <form name="form_helpdesk_at_list" action="" method="GET" enctype="multipart/form-data">
        <table align="center" border="0" cellpadding="3" cellspacing="0" width="550">
        <tr>
       <td height="30" colspan="5" align="center" valign="middle">
        <strong>MEUS CHAMADOS</strong></td>
        </tr>        
        <tr>
        <td height="2px"></td>
        </tr>
        <tr>
        <td width="20">Status:</td>
        <td><select name="busca_status">
        	<option value="">Todos</option>
            <?
        $sql = $objQuery->SQLQuery("SELECT * FROM saf_status as S ORDER BY id_status");
		
		while($res = mysql_fetch_array($sql)){
			echo '<option value="'.$res['status'].'"';
			
				if($busca_status==$res['status']) echo 'selected="selected"'; 
				echo '>'.$res['status'].'</option>';			
			}
		   ?>
          </select></td>
        <td>Departamento:</td>
        <td width="200">
        <select name="busca_id_departamento">
        <option value="">Todos</option>
        <?
        $sql = $objQuery->SQLQuery("SELECT * FROM saf_departamento_permissao as D WHERE id_modulo = '2' ORDER BY departamento");
		
		while($res = mysql_fetch_array($sql)){
			echo '<option value="'.$res['id_departamento_permissao'].'"';
			
				if($busca_id_departamento==$res['id_departamento_permissao']) echo 'selected="selected"'; 
				echo '>'.$res['departamento'].'</option>';			
			}
		?>
          </select>         </td>
        <td width="200"><input type="submit" name="button" id="button" value="Buscar" /></td>
        </tr>
        <tr>
        <td height="2px"></td>
        </tr>
        </table>
    	</form>
        <table align="center" border="0" cellpadding="3" cellspacing="1" width="750" bgcolor="#0071B6">
        <tr>
        <td width="30" align="left" valign="middle" bgcolor="#CEEDFF"><strong>Chamado</strong></td>
        <td width="448" align="left" valign="middle" bgcolor="#CEEDFF"><strong>Título</strong></td>
        <td width="44" align="left" valign="middle" bgcolor="#CEEDFF"><strong>Departamento</strong></td>
        <td width="95" align="center" valign="middle" bgcolor="#CEEDFF"><strong>Status</strong></td>
        <td width="125" align="center" valign="middle" bgcolor="#CEEDFF"><strong>Data</strong></td>
        <td width="49" align="center" valign="middle" bgcolor="#CEEDFF"><strong>Editar</strong></td>
        </tr>
<?
$onde ="";

if($busca_status<>''){$onde .= " and h.status='$busca_status'"; }
if($busca_id_departamento<>''){$onde .= " and h.id_departamento='".$busca_id_departamento."'";}
if($safpostal_id_empresa!="1"){$onde.= " and h.id_usuario = '".$safpostal_id_usuario."'";} 
else { $onde .= " and h.id_departamento IN (".$safpostal_departamento_saf."0) "; }

$condicao = "FROM saf_helpdesk as h, saf_departamento_permissao as dp WHERE h.id_departamento = dp.id_departamento_permissao ".$onde." ORDER BY h.data DESC";

$campo = "h.titulo, dp.departamento, h.status, h.id_helpdesk, date_format(h.data, '%d/%m/%y %h:%m:%s') as data";

pt_register('GET','pagina');
$url_busca = $_SERVER['REQUEST_URI'];
$url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
$url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
$query = $objQuery->paginacao( $campo , $condicao, $pagina , $url_busca);
$p_valor = "";
while($res = mysql_fetch_array($query)){ 
	$p_valor .= '<tr><td class="result_celula" bgcolor="#EAF8FF">' . $res["id_helpdesk"] . '</td>
	<td class="result_celula" bgcolor="#EAF8FF">' . $res["titulo"] . '</td>
	<td class="result_celula" bgcolor="#EAF8FF" align="center">' . $res["departamento"] . '</td>
	<td class="result_celula" bgcolor="#EAF8FF" align="center">' . $res["status"] . '</td>
	<td class="result_celula" bgcolor="#EAF8FF" align="center">' . $res["data"] . '</td>
	<td class="result_celula" bgcolor="#EAF8FF" align="center"><a href="helpdesk_at_edit.php?id=' . $res["id_helpdesk"] . '"><img src="../images/estrutura/botoes/botao_editar.png" title="Clique aqui" border="0"/></a></td>
	</tr>';
}
echo $p_valor;
?>
</table>
        </td>
      </tr>
    </table></td>
  </tr>
</table>

<?
require "../includes/rodape.php";
?>