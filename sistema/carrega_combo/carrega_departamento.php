<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
$acesso_conv='ok';
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
pt_register('GET','id_servico_departamento');
$sDepartamentoDAO = new ServicoDepartamentoDAO();
$departamento = $sDepartamentoDAO->listar();
// Carrega Departamento -----------------------------------
$p_valor = "<option value=''></option>";
foreach($departamento as $dpto){
	$p_valor .= '<option value="'.$dpto->id_servico_departamento.'"';
	if($id_servico_departamento==$dpto->id_servico_departamento) $p_valor .= ' selected="selected" ';
	$p_valor .=  ' >'.$dpto->departamento.'</option>';
}
echo $p_valor;
?>

