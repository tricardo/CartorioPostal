<? 
header("Content-Type: text/html; charset=ISO-8859-1",true); 
require( "../includes/funcoes.php" );
require( "../includes/verifica_logado_ajax.inc.php" );
require( "../includes/global.inc.php" );

pt_register('GET','dia');
pt_register('GET','mes');
pt_register('GET','ano');

if(!$dia) $dia = date('d');
if(!$mes) $mes = date('m');
if(!$ano) $ano = date('Y');

if(strlen($mes)==1) $mes2 = '0'.$mes; else $mes2 = $mes;
if(strlen($dia)==1) $dia2 = '0'.$dia; else $dia2 = $dia;
if($controle_id_usuario != 1 && $controle_id_usuario != 56 && $controle_id_usuario != 272 && $controle_id_usuario != 1245){
	$onde = " and id_user_alt='".$controle_id_usuario."'";
} else {
	$onde='';
}

$sql = "select id_ficha, id_user_alt as id_usuario, observacao as obs, data_reuniao as agenda from site_ficha_cadastro_historico as e where date_format(data_reuniao,'%Y-%m-%d')='".$ano."-".$mes2."-".$dia2."' and data_reuniao!='0000-00-00' ".$onde;
$query = $objQuery->SQLQuery($sql);
?>
<h2>Dia <?= (int)($dia) ?> de <?= mes_ext($mes) ?> de <?= (int)($ano) ?></h2>
<ul>
<? 
while($res = mysql_fetch_array($query)){
	echo '<li><a href="expansao_interessados_edit.php?id='.$res['id_ficha'].'"><b>'.invert($res['agenda'],'/','PHP').'</b></a> - '.$res['obs'].'</li>';
}
?>
</ul>