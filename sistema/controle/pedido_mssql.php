<?
@ini_set("memory_limit",'500M');
set_time_limit(3000);
require('header.php');
require('../includes/dias_uteis.php');
$p_valor ='';
$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);

$p_valor = '<table width="100%" cellpadding="4" cellspacing="1" class="result_tabela">';
$servidor = "SRV-SISTEMAS\SQLEXPRESS";
$usuario = "vsites";
$senha = "e123m";
$banco = "sistecart";

$con = mssql_connect($servidor, $usuario, $senha) or die("Não foi possivel se conectar a $servidor");

$bd = mssql_select_db($banco, $con) or die("O Banco de dados $banco nao pode ser aberto");

$sql = "select * from ORDSER as pi, ORDEM as p, STATUS as s where p.CliCod='635' and p.OrdCod=pi.OrdCod and (pi.StaCod='10' and pi.OrdSerHorEnc>='01/08/2009 00:00:00' or pi.StaCod!='10' and pi.StaCod!='14') and pi.StaCod=s.StaCod";
$query = mssql_query($sql);
$num = mssql_num_rows($query);
echo $num;

#$sql = "select TOP 50 a.*, pi.* from ORDSER as pi, ANEXO as a, ORDEM as p where p.CliCod='635' and p.OrdCod=pi.OrdCod and pi.OrdCod=a.OrdCod and pi.OrdSerCod = a.OrdSerCod and (pi.StaCod='10' and pi.OrdSerHorEnc>='01/08/2009 00:00:00' or pi.StaCod!='10' and pi.StaCod!='14' and a.DocCod='2')";
$sql_cpf = "select OrdSerAtrVal from ORDSERATR as sa where sa.OrdCod=pi.OrdCod and sa.OrdSerCod=pi.OrdSerCod and sa.AtrCod='31'"; 
$sql_cnpj = "select OrdSerAtrVal from ORDSERATR as sa where sa.OrdCod=pi.OrdCod and sa.OrdSerCod=pi.OrdSerCod and sa.AtrCod='32'";
$sql_nome = "select OrdSerAtrVal from ORDSERATR as sa where sa.OrdCod=pi.OrdCod and sa.OrdSerCod=pi.OrdSerCod and sa.AtrCod='29'"; 
$sql_devedor = "select OrdSerAtrVal from ORDSERATR as sa where sa.OrdCod=pi.OrdCod and sa.OrdSerCod=pi.OrdSerCod and sa.AtrCod='135'"; 
$sql_cidade = "select OrdSerAtrVal from ORDSERATR as sa where sa.OrdCod=pi.OrdCod and sa.OrdSerCod=pi.OrdSerCod and sa.AtrCod='17'"; 
$sql_estado = "select OrdSerAtrVal from ORDSERATR as sa where sa.OrdCod=pi.OrdCod and sa.OrdSerCod=pi.OrdSerCod and sa.AtrCod='18'"; 

$sql = "select (".$sql_cpf.") as cpf,(".$sql_cnpj.") as cnpj,(".$sql_nome.") as nome,(".$sql_devedor.") as devedor,(".$sql_cidade.") as cidade,(".$sql_estado.") as estado, p.CliCod, pi.SerCod, pi.OrdSerCod, pi.OrdCod, CONVERT(CHAR,pi.OrdSerHorAbe,102 ) as OrdSerHorAbe,CONVERT(CHAR,pi.OrdSerHorAbe,108 ) as OrdSerHorAbe2, CONVERT(CHAR,pi.OrdSerHorPra,102 ) as OrdSerHorPra, CONVERT(CHAR,pi.OrdSerHorPra,108 ) as OrdSerHorPra2, pi.StaCod  from ORDSER as pi, ORDEM as p, STATUS as s where p.CliCod='635' and p.OrdCod=pi.OrdCod and (pi.StaCod='10' and pi.OrdSerHorEnc>='01/08/2009 00:00:00' or pi.StaCod!='10' and pi.StaCod!='14') and pi.StaCod=s.StaCod and pi.OrdSerHorAbe>='01/01/2009 00:00:00'";

$query = mssql_query($sql);
while($res = mssql_fetch_array($query)){
	$cont++;
	$OrdSerCod = $res['OrdSerCod'];
	$OrdCod    = $res['OrdCod'];
	$SerCod    = $res['SerCod'];
	$CodCli    = $res['CodCli'];
	$cidade    = str_replace("'",'"',$res['cidade']);
	$estado    = str_replace("'",'"',$res['estado']);
	$StaCod    = $res['StaCod'];
	$OrdSerHorAbe    = $res['OrdSerHorAbe'].' '.$res['OrdSerHorAbe2'];
	$OrdSerHorPra    = $res['OrdSerHorPra'].' '.$res['OrdSerHorPra2'];
	$cpf    	= str_replace("'",'"',$res['cpf']);
	$cnpj    	= str_replace("'",'"',$res['cnpj']);
	$nome    	= str_replace("'",'"',$res['nome']);
	$devedor 	= str_replace("'",'"',$res['devedor']);
	
	$sql_add = "insert into pedidos_antigos(OrdCod, OrdSerCod, SerCod, CliCod, StaCod, OrdSerHorAbe, OrdSerHorPra, cpf, cnpj, nome, devedor, cidade, estado) values('".$OrdCod."','".$OrdSerCod."','".$SerCod."','".$CliCod."','".$StaCod."','".$OrdSerHorAbe."','".$OrdSerHorPra."','".$cpf."','".$cnpj."','".$nome."','".$devedor."','".$cidade."','".$estado."')";
	$query_pedido = $objQuery->SQLQuery($sql_add);

	$sql_anexo = "select a.AneNom, a.AneArq, CONVERT(CHAR,a.AneHorReg,102 ) as AneHorReg,CONVERT(CHAR,a.AneHorReg,108 ) as AneHorReg2 from ANEXO as a where a.OrdCod='".$OrdCod."' and a.OrdSerCod='".$OrdSerCod."' and a.DocCod='2'";
	$query_anexo = mssql_query($sql_anexo);
	$num_anexo = mssql_num_rows($query_anexo);
	echo $OrdCod.'/'.$OrdSerCod.'Qtdd'.$num_anexo.'<br>';
	while($res_anexo = mssql_fetch_array($query_anexo)){
		$anexos .= str_replace("'",'"',$res_anexo["AneNom"].',');
		$AneArq = str_replace("'",'"',$res_anexo["AneArq"]);
		$AneHorReg = $res_anexo["AneHorReg"].' '.$res_anexo["AneHorReg2"];
		$sql_ane = "insert into anexos_antigos (OrdCod, OrdSerCod, AneArq, AneHorReg) values('".$OrdCod."','".$OrdSerCod."','".$AneArq."','".$AneHorReg."')";
		$query_anexo_1 = $objQuery->SQLQuery($sql_ane);
	}
}
	$query = $objQuery->SQLQuery("update pedidos_antigos set cpf=replace(replace(replace(replace(cpf,'  ',''),'.',''),'-',''),'/',''), cnpj = replace(replace(replace(replace(cnpj,'  ',''),'.',''),'-',''),'/',''), nome = replace(nome,'  ',''), devedor = replace(devedor,'  ',''), cidade = replace(cidade,'  ',''), estado = replace(estado,'  ','')");
?>
		</table>
<?php 
	require('footer.php');
?>