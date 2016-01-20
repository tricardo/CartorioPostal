<? 
header("Content-Type: text/html; charset=ISO-8859-1",true); 
require( "../includes/funcoes.php" );
require( "../includes/verifica_logado_ajax.inc.php" );
require( "../includes/global.inc.php" );

pt_register('GET','ano');
pt_register('GET','mes');

if(!$ano) $ano = date('Y');
if(!$mes) $mes = date('m');
$dias_mes = ultimoDiaMes('01/'.$mes.'/'.$ano);
if(strlen($mes)==1) $mes2 = '0'.$mes; else $mes2 = $mes;

if($controle_id_usuario != 1 && $controle_id_usuario != 56 && $controle_id_usuario != 272 && $controle_id_usuario != 1245){
	$onde = " and id_user_alt='".$controle_id_usuario."'";
} else {
	$onde='';
}

$sql = "select count(0) as total, date_format(data_reuniao,'%d') as dia from site_ficha_cadastro_historico as e where date_format(data_reuniao,'%Y-%m')='".$ano."-".$mes."' and data_reuniao!='0000-00-00' ".$onde." group by data_reuniao";
$query = $objQuery->SQLQuery($sql);

while($res = mysql_fetch_array($query)){
	$evento_dia[(int)($res['dia'])]=$res['total'];
}

$p_valor = '<ul>';
$cont=0;
$dia_semana = diasemana($ano.'/'.$mes.'/01');
if($dia_semana!=0){
	while($cont<$dia_semana){
		$cont2 = ($cont % 2);
		$p_valor .= '<li></li>';
		$cont++;
	}
}
while($cont<35){
	$cont3=$cont-$dia_semana+1;
	$cont++;
	if($evento_dia[$cont3]<>'') $classe = 'tem_evento'; else $classe="";
	if($cont3<=$dias_mes) $p_valor .= '<li id="dia'.$cont3.'" class="'.$classe.'"><a href="javascript:void();" onclick="carrega_evento(\''.$cont3.'\',\''.$mes.'\',\''.$ano.'\');">'.$cont3.'</a></li>';
	else $p_valor .= '<li></li>';
}
echo $p_valor.'</ul>';
?>