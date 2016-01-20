<?
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
require("../includes/geraexcel/excelwriter.inc.php");
if($controle_id_empresa!=1){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
//
$empresaDAO = new EmpresaDAO();
$empresas = $empresaDAO->listaAdendo();

//Você pode colocar aqui o nome do arquivo que você deseja salvar.
$arquivoDiretorio = "./exporta/adendo_".md5(time()).".xls";

$excel=new ExcelWriter($arquivoDiretorio);
if($excel==false){
	echo $excel->error;
}

$excel->writeLine(array('Cidades','Estado','Fone/Loja','Endereço','CEP','E-MAIL','Razão Social','CNPJ','Dados Bancários','Data adendo'));
foreach($empresas as $e){
	$cidades='';
	
	$excel->writeCol($e->regioes[0]->cidade);
	$excel->writeCol($e->regioes[0]->estado);
	$excel->writeCol($e->tel.' '.$e->ramal);
	$excel->writeCol($e->endereco.','.$e->numero.' '.$e->complemento);
	$excel->writeCol($e->cep);	
	$excel->writeCol($e->email);	
	$excel->writeCol($e->empresa);	
	$excel->writeCol($e->cpf);	
	$excel->writeCol('Ag.:'.$e->agencia.'|Conta:'.$e->conta.'|Banco:'.$e->banco.'|'.$e->favorecido);	
	$excel->writeCol(invert($e->adendo_data,'/','php'));
	foreach($e->regioes as $i=>$r){
		if($i>0){
			$excel->writeRow();			
			$excel->writeCol($r->cidade,2);
			$excel->writeCol($r->estado);
		}
	}
	$excel->writeRow();
}
$excel->close();

header ("Content-type: octet/stream");
header ("Content-disposition: attachment; filename=adendo.xls;");
header("Content-Length: ".filesize($arquivoDiretorio));
readfile($arquivoDiretorio);
?>