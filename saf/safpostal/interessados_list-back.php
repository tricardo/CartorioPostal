<?
require "../includes/topo.php";
$permissao = verifica_permissao('EXPANSAO',$safpostal_departamento_saf);
if($permissao == 'FALSE' or $safpostal_id_empresa!='1'){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
pt_register("GET","busca_estado_interesse");
pt_register("GET","busca_id_cidade_interesse");
pt_register("GET","busca_status");
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
            <td width="345" height="20" align="left" valign="middle"><strong>Lista de Interessados</strong></td>
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
        <td width="60%" align="left" valign="middle">Cadastro preenchidos pelo site</td>
        </tr>
        </table>
         </strong></div>
		 <form name="form_busc" action="" method="get" enctype="multipart/form-data">
		 <table border="0" cellpadding="0" align="center" cellspacing="0" width="750">
		 <tr>
		 <td width="60"><strong>Estado:</strong></td>
		 <td align="left" width="50">
			<select name="busca_estado_interesse" onclick="carrega_cidades(this.value,'');">
			<option value="">UF</option>
        	<?
			$sql = $objQuery->SQLQuery("SELECT DISTINCT estado FROM  vsites_cidades as C ORDER BY estado ");
		
			while($res = mysql_fetch_array($sql)){
			echo '<option value="'.$res['estado'].'"';
			
			if($busca_estado_interesse==$res['estado']) echo 'selected="selected"'; 
			echo '>'.$res['estado'].'</option>';			
			}
		    ?>
			</select>
		</td>
		 <td align="left" width="50"><strong>Cidade:</strong></td>
		 <td align="left" width="350">
			<select name="busca_id_cidade_interesse" id="carrega_cidade">
			</select>
			<script>
				carrega_cidades('<?= $busca_estado_interesse ?>','<?= $busca_id_cidade_interesse ?>');
			</script>
		</td>
		 <td align="left" width="50"><strong>Status:</strong></td>
		 <td align="left" width="50">
		 <select name="busca_status">
        	<option value="">Todos</option>
            <?
        $sql = $objQuery->SQLQuery("SELECT * FROM saf_status_interesse as S ORDER BY id_status");
		
		while($res = mysql_fetch_array($sql)){
			echo '<option value="'.$res['status'].'"';
			
				if($busca_status==$res['status']) echo 'selected="selected"'; 
				echo '>'.$res['status'].'</option>';			
			}
		   ?>
          </select>
		 </td>
		 <td><input type="submit" name="button" id="button" value="Buscar" /></td>
		 </tr>
		 <tr>
		 <td height="10" colspan="7"></td>
		 </tr>
		 </table>
<table align="center" border="0" cellpadding="3" cellspacing="1" width="750" bgcolor="#0071B6">
        <tr>
        <td width="220" align="left" valign="middle" bgcolor="#CEEDFF"><strong>Nome</strong></td>
        <td width="44" align="left" valign="middle" bgcolor="#CEEDFF"><strong>Email</strong></td>
        <td width="100" align="center" valign="middle" bgcolor="#CEEDFF"><strong>Telefone</strong></td>
        <td width="10" align="center" valign="middle" bgcolor="#CEEDFF"><strong>Estado</strong></td>
        <td width="60" align="center" valign="middle" bgcolor="#CEEDFF"><strong>Cidade</strong></td>
		<td width="60" align="center" valign="middle" bgcolor="#CEEDFF"><strong>Data</strong></td>
        <td width="120" align="center" valign="middle" bgcolor="#CEEDFF"><strong>Status</strong></td>
		<td width="20" align="center" valign="middle" bgcolor="#CEEDFF"><strong>Editar</strong></td>
        </tr>
<?
$onde ="";

if($busca_status<>''){$onde .= " and i.status='$busca_status'"; }
if($busca_estado_interesse<>''){$onde .= " and i.estado_interesse='$busca_estado_interesse'"; }
if($busca_id_cidade_interesse<>''){$onde .= " and i.id_cidade_interesse='".$busca_id_cidade_interesse."'";}

$condicao = "FROM saf_interesse as i LEFT JOIN vsites_cidades as c ON c.id_cidade=i.id_cidade_interesse WHERE 1=1 " . $onde . " ORDER BY data DESC ";

$campo = " i.id_interesse, i.data, i.nome, i.email, i.tel, i.estado_interesse, c.cidade, status, date_format(i.data, '%d/%m/%y') as data ";

pt_register('GET','pagina');
$url_busca = $_SERVER['REQUEST_URI'];
$url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
$url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
$query = $objQuery->paginacao( $campo , $condicao, $pagina , $url_busca);
$p_valor = "";
while($res = mysql_fetch_array($query)){ 
	$p_valor .= '<tr><td class="result_celula" bgcolor="#EAF8FF" align="left">' . $res["nome"] . '</td>
	<td class="result_celula" bgcolor="#EAF8FF">' . $res["email"] . '</td>
	<td class="result_celula" bgcolor="#EAF8FF" align="center">' . $res["tel"] . '</td>
	<td class="result_celula" bgcolor="#EAF8FF" align="center">' . $res["estado_interesse"] . '</td>
	<td class="result_celula" bgcolor="#EAF8FF" align="center">' . $res["cidade"] . '</td>
	<td class="result_celula" bgcolor="#EAF8FF" align="center">' . $res["data"] . '</td>
	<td class="result_celula" bgcolor="#EAF8FF" align="center">' . $res["status"] . '</td>
	<td class="result_celula" bgcolor="#EAF8FF" align="center"><a href="interessados_edit.php?id=' . $res["id_interesse"] . '"><img src="../images/estrutura/botoes/botao_editar.png" title="Clique aqui" border="0"/></a></td>
	</tr>';
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