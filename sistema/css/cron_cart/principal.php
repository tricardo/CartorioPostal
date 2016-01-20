<?
ini_set('max_execution_time', '0');
require('../model/Database.php');
require("../includes/classQuery.php");
require("../includes/funcoes.php");
require("../includes/global.inc.php");
require("../includes/geraexcel/excelwriter.inc.php");

$dia_semana = diasemana(date('Y-m-d'));

if(date('H')<20 or $dia_semana==6 or $dia_semana==0){
	echo "Horário inválido para iniciar a aplicação!";
}else{
	$sqlE_principal = $objQuery->SQLQuery("SELECT * FROM vsites_cron as c where proxima<='".date('Y-m-d')."' and status='Ativo' order by id_cron");
	while($res_principal = mysql_fetch_array($sqlE_principal)){
		echo '<br><b>Relatório '.str_replace('_',' ',str_replace('.php','',$res_principal['arquivo'])).'</b> ';
		require_once($res_principal['arquivo']);
		$freq = $res_principal['frequencia'];
		switch($freq){
			case 1 : $uni = 'day';  break;
			case 7 : $uni = 'week';  $freq=1; break;
			case 30: $uni = 'month'; $freq=1; break;
			default: $uni = 'day';
		}
		$prox = date("Y-m-d",strtotime('+'.$freq.' '.$uni));
		$sqlE_principal_u = $objQuery->SQLQuery("update vsites_cron set proxima='".$prox."' where arquivo='".$res_principal['arquivo']."'");
	}
	echo "<br><br>Cron Finalizado com sucesso!";
}
?>