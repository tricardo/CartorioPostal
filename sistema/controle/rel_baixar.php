<?
require("../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
require("../includes/dias_uteis.php");
pt_register('GET','relatorio');

if(verifica_permissao('Rel_gerencial',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'
	&& verifica_permissao('Rel_comercial',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'
	&& verifica_permissao('Supervisor Atendimento',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'
	&& verifica_permissao('Supervisor Financeiro',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE' 
	){
	if($relatorio=='royalties'){
		if(verifica_permissao('Franquia',$controle_id_departamento_p,$controle_id_departamento_s)=='FALSE'){
			echo '<br><br><strong>Você não tem permissão para acessar essa página de royalties</strong>';
			exit;
		}
	}else{
		echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
		exit;
	}
}

pt_register('GET','id_relatorio');

$relatorioDAO = new RelatorioDAO();
$relatorio = $relatorioDAO->selectPorId($id_relatorio);
if($controle_id_empresa != $relatorio->id_empresa && $controle_id_empresa!=1){
	echo '<div id="topo">';
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	echo '</div>';
	exit;
}if(!is_file($relatorio->arquivo)){
	echo '<div id="topo">';
	echo '<br><br><strong>arquivo não encontrado</strong>';
	echo '</div>';
	exit;
}

header ("Content-type: octet/stream");
header ("Content-disposition: attachment; filename=exporta/".$relatorio->arquivo.";");
header("Content-Length: ".filesize($relatorio->arquivo));
readfile($relatorio->arquivo);
?>