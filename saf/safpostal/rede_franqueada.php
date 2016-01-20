<?
require "../includes/topo.php";
pt_register("GET","buscar_cidade");
pt_register("GET","buscar_estado");
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
            <td width="345" height="20" align="left" valign="middle"><strong>Rede Franqueada</strong></td>
            <td width="415" align="left" valign="middle"><span style="font-weight: bold">Franquia: <? echo $safpostal_fantasia ?></span></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>
		<form name="form_unidades" action="" method="GET" enctype="multipart/form-data">
			<table width="100%" border="0" align="left" cellpadding="3" cellspacing="1">
			<tr>
			<td>
			<img src="../images/estrutura/botoes/busca.png" border="0" align="middle" width="20" height="20">
			Busca unidades:<input name="buscar_cidade" style="margin-left:2px;width:206px" type="text" value="<?= $buscar_cidade ?>"/>
			Estado:
			<select name="buscar_estado" id="estado">
				<option value="">UF</option>
				<?
				$sql = $objQuery->SQLQuery("SELECT DISTINCT estado FROM  vsites_cidades as C ORDER BY estado");
				while($res = mysql_fetch_array($sql)){
					echo '<option value="'.$res['estado'].'"';
					if($buscar_estado==$res['estado']) echo 'selected="selected"'; 
					echo '>'.$res['estado'].'</option>';
				}
				?>
			</select>
			<input type="submit" name="submit1" value="Buscar" />
			</td>
			</tr>
			</table>
		</form>
        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#0071B6" style="margin-top:10px">
        <tr>
        <td width="35%" align="left" valign="middle" bgcolor="#CEEDFF"><strong>Razão Social/Franquia</strong></td>
		<td width="15%" align="center" valign="middle" bgcolor="#CEEDFF"><strong>Região</strong></td>
        <td width="30%" align="left" valign="middle" bgcolor="#CEEDFF"><strong>Endereço</strong></td>
        <td width="20%" align="center" valign="middle" bgcolor="#CEEDFF"><strong>Conta Bancária</strong></td>
		</tr>
<?
$onde ="";

if($buscar_cidade<>''){$onde .= " and (fr.cidade like '".$buscar_cidade."%' or ue.bairro like '".$buscar_cidade."%' or fr.apelido like '".$buscar_cidade."%')";}
if($buscar_estado<>''){$onde .= " and fr.estado= '".$buscar_estado."'";}
$condicao = "FROM vsites_user_empresa as ue LEFT JOIN vsites_banco as b ON b.id_banco=ue.id_banco, vsites_franquia_regiao as fr WHERE fr.id_empresa=ue.id_empresa and ue.status='Ativo' ".$onde." group by fr.cidade, fr.estado, fr.id_empresa, ue.bairro ORDER BY fr.cidade, fr.estado ASC";

$campo = "ue. skype, fr.apelido, b.id_banco, b.banco, ue.id_banco, ue.agencia, ue.conta, ue.favorecido, ue.cpf, ue.nome, fr.cidade as cidade_f, fr.estado as estado_f, ue.fantasia, ue.empresa, ue.fantasia, ue.endereco, ue.numero, ue.complemento, ue.cidade, ue.estado, ue.bairro, ue.cep, ue.status, ue.id_empresa, date_format(ue.data, '%d/%m/%y') as data, ue.tel, ue.email";

pt_register('GET','pagina');
$url_busca = $_SERVER['REQUEST_URI'];
$url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
$url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
$query = $objQuery->paginacao( $campo , $condicao, $pagina , $url_busca, 5);
$p_valor = "";
if($safpostal_id_usuario == 1){
	#echo $condicao;
}
while($res = mysql_fetch_array($query)){
	if($res["apelido"]<>'') $apelido = $res["apelido"]; else $apelido = $res["bairro"];
	$p_valor .= '<tr>
	<td class="result_celula" bgcolor="#EAF8FF">' . $res["empresa"] . '<br>' . $res["cpf"] . '<br><b>' . str_replace('Cartório Postal - ','',$res["fantasia"]) . '<br>' . $res["nome"] . '</b><br/>' . $res["email"] . '<br/>' . $res["tel"] . '<br/>Skype: ' . $res["skype"] . '</td>
	<td class="result_celula" bgcolor="#EAF8FF" align="center">' . $apelido . '<br/>' . $res["cidade_f"] . '<br/>' . $res["estado_f"] . '</td>
	<td class="result_celula" bgcolor="#EAF8FF">' . $res["endereco"] . ', ' . $res["numero"] . '<br>' . $res["complemento"] . '<br>' . $res["bairro"] . '<br>' . $res["cidade"] . ' - ' . $res["estado"] . '<br>' . $res["cep"] . '</td>
	<td class="result_celula" bgcolor="#EAF8FF" align="center">' . $res["banco"] . '<br>' . $res["agencia"] . ' - ' . $res["conta"] . ' <br><br> ' . $res["favorecido"] . '</td>
	</tr>';
}
echo $p_valor;
?><tr>
			<td colspan="4" align="center" class="barra_busca" bgcolor="#FFFFFF">
				<?
                    $objQuery->QTDPagina();
                ?>			
            </td>
		</tr>
</table>
</table>
        </td>
      </tr>
    </table></td>
  </tr>
</table>

<?
require "../includes/rodape.php";
?>
