<?php
header("Content-Type: text/html; charset=ISO-8859-1",true);
require("../includes/verifica_logado_ajax.inc.php");
require("../includes/funcoes.php");
require("../includes/global.inc.php");
pt_register('GET','cep');
pt_register('GET','cidade');
pt_register('GET','tipo');
pt_register('GET','form');

$enderecoDAO = new EnderecoDAO();
echo '<div style="margin:5px;">';
if($tipo == 1){

} else {
	$cep = str_replace('-', '', $cep);
	$end = $enderecoDAO->buscaPorCep($cep);
	if(count($end) > 0){
		$franquia   = 'Sistecart - Sistema de Cartório Certidões S/C Ltda';
		$idfranquia = 1;
		$end2 = $enderecoDAO->buscaPorEndereco($end->cidade);
		if(count($end2)){
			$franquia   = $end2->fantasia;
			$idfranquia = $end2->id_empresa;
		}
		echo '<table width="100%" border="0" cellspacing="2" cellpadding="2">' ."\n";
		echo '<tr>' ."\n";
		echo '<td bgcolor="#E2E2E2">&nbsp;'.$end->endereco.'</td>';
		echo '<td bgcolor="#E2E2E2">&nbsp;'.$end->bairro.'</td>';
		echo '<td bgcolor="#E2E2E2">&nbsp;'.$_GET['cep'].'</td>';
		echo '<td bgcolor="#E2E2E2">&nbsp;'.$end->cidade.'</td>';
		echo '<td bgcolor="#E2E2E2">&nbsp;'.$end->estado.'</td>';
		echo '<td bgcolor="#E2E2E2" align="center">';
		echo "<a href=\"#endereco_click\" ";
		echo "onclick=\"CarregaEndereco('".$end->endereco."','".$end->bairro."','".$_GET['cep']."','".$end->cidade."','".$end->estado."', '".$idfranquia."', '".$franquia."');\" ";
		echo 'style=\"color:#0066FF\">usar</a>';
		echo '</td></tr>';
		echo '</table>';
	} else {
		echo 'Nenhum endereço encontrado nesta forma de busca.';
	}
}
echo '</div>';
?>