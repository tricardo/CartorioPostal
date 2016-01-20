<?php
ini_set('max_execution_time', '0');
require('../model/Database.php');
require("../includes/classQuery.php");
require("../includes/funcoes.php");
require("../includes/global.inc.php");
require("../includes/geraexcel/excelwriter.inc.php");


header ("Content-type: octet/stream");
header ("Content-disposition: attachment; filename=pj2010.csv;");
//header("Content-Length: ".filesize($arquivoDiretorio));

$sql = "SELECT sum(valor) as valor, count(0) as pedidos,  p.nome,p.contato,p.cpf,p.tel,
		DATE_FORMAT(pi.data,'%m') as mes
		FROM vsites_pedido_item pi
		INNER JOIN  vsites_pedido p on pi.id_pedido = p.id_pedido
		WHERE p.tipo='cnpj' and pi.id_status<>14
			and p.data >= '2010-01-01 00:00:00' and p.data <= '2010-12-31 23:59:59'
		GROUP BY mes,p.nome  ORDER BY nome,mes";
$sql = $objQuery->SQLQuery($sql);

$nome_aux="xx";

echo "nome;cnpj;contato;telefone;";
for($i=1; $i<=12; $i++){
	echo traduzmes($i).";";
	echo "pedidos;";
}
$j=12;
while($res = mysql_fetch_array($sql)){
	$cpf 		= $res['cpf'];
	$pedidos 	= $res['pedidos'];
	$valor 		= $res['valor'];
	$nome 		= $res['nome'];
	$contato	= $res['contato'];
	$tel 		= $res['tel'];
	$mes		= $res['mes'];

	if($nome!=$nome_aux){
		for($i=$j; $i<=12; $i++){
			echo ";;";
		}
		if($nome_aux!='xx'){
			echo ";".number_format($total,2,",","");
			echo ";".$conta;
			$total=0;
			$conta=0;
		}
		echo "\n".$nome.";".$cpf.";".$contato.";".$tel;
		$j=1;
		$nome_aux=$nome;
	}
	for($i=$j; $i<=12; $i++){
		$j=$i+1;
		if($mes==$i){
			echo ";".number_format($valor,2,",","");
			echo ";".$pedidos;
			$total+=$valor;
			$conta+=$pedidos;
			break;
		}
		else echo ";;";
	}
}

for($i=$j; $i<=12; $i++){
	echo ";;";
}
echo ";".number_format($total,2,",","");
echo ";".$conta;
$total=0;
$conta=0;


$j=1;
$total=0;
$conta=0;
$cpf_aux=$cpf;

?>