<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
pt_register('GET','id_cliente');
$clienteDAO = new ClienteDAO();
$p_valor = '<option value=""></option>';
$clientes = $clienteDAO->listarConveniadoAtivo($controle_id_empresa);
foreach($clientes as $c){
	$p_valor .= '<option value="'.$c->id_cliente.'"';
	if($id_cliente==$c->id_cliente) $p_valor .= ' selected="selected" ';
	$p_valor .=  ' >'.$c->nome.'</option>';
}
echo $p_valor;
?>