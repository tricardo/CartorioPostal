<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
pt_register('GET','id');
$fornecedorDAO = new FornecedorDAO();
$clientes = $fornecedorDAO->buscaPorId($id,$controle_id_empresa);
echo '
<script>
	 document.pagamento_form.favorecido.value=\''. $clientes->fantasia .'\';
	 document.pagamento_form.cnpj.value=\''. $clientes->cnpj .'\';
</script>
';
?>