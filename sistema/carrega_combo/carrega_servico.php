<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
$acesso_conv='ok';
include_once( "../includes/verifica_logado_ajax.inc.php");
include_once( "../includes/funcoes.php" );
include_once( "../includes/global.inc.php" );
pt_register('GET','id_departamento');
pt_register('GET','id_servico');

$servicoDAO = new ServicoDAO();
$servicos = $servicoDAO->listaPorDepartamento($id_departamento);
$combo_1 = '<option></option>';
$combos='';
foreach($servicos as $s){
	if($controle_id_empresa==1 or $controle_id_empresa!=1 and $s->franqueadora==0){
		$combos .= '<option value="'.$s->id_servico.'" >'.$s->descricao.'</option>';
		if($s->id_servico==$id_servico) $combo_1 = '<option value="'.$s->id_servico.'" >'.$s->descricao.'</option>';
	}
}
echo $combo_1.$combos;
?>