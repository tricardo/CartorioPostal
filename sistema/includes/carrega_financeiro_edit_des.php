<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
pt_register('GET','id_pedido_item');
if($id_pedido_item<>''){
	$sql 	= "SELECT f.*, uu.nome FROM vsites_financeiro as f, vsites_user_usuario as uu where f.id_pedido_item='$id_pedido_item' and f.financeiro_tipo='Desembolso' and f.id_usuario=uu.id_usuario and uu.id_empresa='".$controle_id_empresa."'";
	$query 	= $objQuery->SQLQuery($sql);
	?>
<table width="100%" class="tabela">
	<tr>
		<td colspan="6" class="tabela_tit">Desembolsos</td>
	</tr>
	<tr>
		<td width="80">
			<b>Data </b>
		</td>		
		<td width="80">
			<b>Status </b>
		</td>
		<td>
			<b>Descrição </b>
		</td>
		<td width="60">
			<b>Custas </b>
		</td>
		<td width="60">
			<b>Correio </b>
		</td>
		<td width="60">
			<b>Honorários </b>
		</td>
	</tr>
<?
$p_valor = '';
while($res = mysql_fetch_array($query)){
	$p_valor .='
	<tr>
		<td class="result_busca">
			'.invert($res['financeiro_data'],'/','php').'<br>
			'.$res['nome'].'
		</td>
		<td class="result_busca">
			'.$res['financeiro_autorizacao'].'<br>
		</td>
		<td class="result_busca">
			'.$res['financeiro_conta'].'-'.$res['financeiro_favorecido'].'<br>
			'.$res['financeiro_descricao'].'
		</td>
		<td class="result_busca">
			'.number_format((float)($res['financeiro_valor']),2,".","").'<br>
		</td>
		<td class="result_busca">
			'.number_format((float)($res['financeiro_sedex']),2,".","").'<br>
		</td>
		<td class="result_busca">
			'.number_format((float)($res['financeiro_rateio']),2,".","").'<br>
		</td>
	</tr>
';
}
echo $p_valor.'</table>';
}
?>
