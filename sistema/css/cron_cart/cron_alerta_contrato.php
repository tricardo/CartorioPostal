<?php
require_once("../includes/maladireta/class.Email.php");

$empresaDAO = new EmpresaDAO();

$empresas = $empresaDAO->listarTodas();
$empresas_venc = array();
echo '<pre>';
foreach($empresas as $i=>$e){
//	echo $e->inauguracao_data." ".$e->validade_contrato;
	if($e->inauguracao_data!='' and $e->inauguracao_data!='0000-00-00'){
		$data_fim = strtotime($e->inauguracao_data." +".$e->validade_contrato." months");
		
		$vencimento = new DateTime(date("Y-m-d",$data_fim));
		$hoje = new DateTime(date("Y-m-d"));
		$interval = $hoje->diff($vencimento);
		$meses = $interval->format('%m%');
		if($meses<2 || $hoje>$vencimento){
			$e->vencido = $interval->invert;
			$empresas_venc[]=$e;
			$e->vencimento = $vencimento;
		}
	}
}
echo "\n";
$qtdd = count($empresas_venc);
if($qtdd<>0){
	$html = 'Os seguintes contratos estão perto da sua data de vencimento:<br>
		<ul>';
		foreach($empresas_venc as $e){
			$html.='<li>'.$e->fantasia;
			$html.=' - Vencimento '.$e->vencimento->format("d/m/Y");
			$html.='</li>';		
		}
		$html.='</ul>
			';
	$message = new Email('erika.caceres@cartoriopostal.com.br','ti@cartoriopostal.com.br','Vencimento de Contratos',$CustomHeaders);
	$message->Cc = 'ti@cartoriopostal.com.br';
	$message->Cc = 'claudia.mattos@cartoriopostal.com.br';
	$message->SetHtmlContent($html);
	$message->Send();	
}

echo '</pre>';
?>