<?
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
require("../includes/geraexcel/excelwriter.inc.php");

$dia='1';
pt_register('POST','mes');
pt_register('POST','ano');
if($ano=='') $ano = date('Y');
if($mes=='') $mes = date('m');

$permissao = verifica_permissao('Rel_supervisores',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}

$arquivoDiretorio = "./exporta/".$controle_id_usuario.".xls";
$nomeArquivo = $controle_id_usuario.".xls";

$excel=new ExcelWriter($arquivoDiretorio);

if($excel==false){
	echo $excel->error;
	exit;
}


//Escreve o nome dos campos de uma tabela
$linha_arq = 'Número de Serviços por Departamento;';
$myArr = explode(';',$linha_arq);
$excel->writeLine($myArr);

$linha_arq = 'Referência:; '.$mes.'/'.$ano;
$myArr = explode(';',$linha_arq);
$excel->writeLine($myArr);

$linha_arq = 'Dia;2via;Processos;Imóveis;Protesto;';
$myArr = explode(';',$linha_arq);
$excel->writeLine($myArr);


$p_valor='';
$dia=1;
$somas=array();
$relatorioDAO = new RelatorioDAO();
$lista = $relatorioDAO->relatorioOperacional($controle_id_empresa,$ano,$mes);

$via=0;
$processos=0;
$imoveis=0;
$protesto=0;
$old_dia='';
$somas =  array();

foreach($lista as $l){
	if($old_dia!=$l->dia and $old_dia<>''){

		$linha_arq = $l->dia.';'.$via.';'.$processos.';'.$imoveis.';'.$protesto;
		$myArr = explode(';',$linha_arq);
		$excel->writeLine($myArr);
		$somas[2] 	= $somas[2]+$via;
		$somas[4] 	= $somas[4]+$processos;
		$somas[7] 	= $somas[7]+$imoveis;
		$somas[8] 	= $somas[8]+$protesto;

		$via=0;
		$processos=0;
		$imoveis=0;
		$protesto=0;
	}
	$old_dia=$l->dia;
	if($l->id_servico_departamento=='2') $via 		= $l->soma;
	if($l->id_servico_departamento=='4') $processos = $l->soma;
	if($l->id_servico_departamento=='7') $imoveis 	= $l->soma;
	if($l->id_servico_departamento=='8') $protesto 	= $l->soma;
}
if($via<>0 or $processos<>0 or $imoveis<>0 or $protesto<>0){
	$linha_arq = $old_dia.';'.$via.';'.$processos.';'.$imoveis.';'.$protesto;
	$myArr = explode(';',$linha_arq);
	$excel->writeLine($myArr);
	$somas[2] 	= $somas[2]+$via;
	$somas[4] 	= $somas[4]+$processos;
	$somas[7] 	= $somas[7]+$imoveis;
	$somas[8] 	= $somas[8]+$protesto;
}

$linha_arq = 'Total;'.$somas[2].';'.$somas[4].';'.$somas[7].';'.$somas[8].';'.$somas[10];
$myArr = explode(';',$linha_arq);
$excel->writeLine($myArr);

header ("Content-type: octet/stream");
header ("Content-disposition: attachment; filename=exporta/".$nomeArquivo.";");
header("Content-Length: ".filesize($arquivoDiretorio));
readfile($arquivoDiretorio);

?>