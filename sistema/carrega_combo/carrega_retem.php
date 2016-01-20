<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
pt_register('GET','valor');
pt_register('GET','id_regime');
$regimeDAO = new RegimeDAO();
$regime = $regimeDAO->buscaPorId($id_regime);
$ir = $valor/100*$regime->ir;

if((float)($regime->margem)<(float)($valor)){
	$pis = (float)($valor)/100*(float)($regime->pis);
	$cofins = (float)($valor)/100*(float)($regime->cofins);
}

$pis = number_format($pis,2,".","");
$ir = number_format($ir,2,".","");
$cofins = number_format($cofins,2,".","");
echo '
<script>
	document.pagamento_form.valor_ir.value=\''. $ir .'\';
	document.pagamento_form.valor_pis.value=\''. $pis .'\';
	document.pagamento_form.valor_cofins.value=\''. $cofins .'\';
</script>';
?>