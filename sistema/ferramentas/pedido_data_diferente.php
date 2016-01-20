<?
@ini_set("memory_limit",'500M');
set_time_limit(3000);
require('../controle/header.php');
require('../includes/dias_uteis.php');
echo '<br><br><br><br>';
$p_valor ='';
$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);

$sql = "select * from (select pi.data_prazo, pi.id_pedido_item, pi.dias, date_format(pi.inicio,'%Y-%m-%d') as inicio, pi.id_pedido, pi.ordem from vsites_pedido_item as pi where inicio != '0000-00-00 00:00:00' and data_prazo='0000-00-00') as pi order by inicio";
$query = $objQuery->SQLQuery($sql);

while($res = mysql_fetch_array($query)){
	$id_pedido_item = $res['id_pedido_item'];
	if($res['inicio']<>'0000-00-00')$data_prazo = somar_dias_uteis($res['inicio'],$res['dias']); else $data_prazo = '';
	$query2 = $objQuery->SQLQuery("update vsites_pedido_item set data_prazo='".$data_prazo."' where id_pedido_item='".$id_pedido_item."'");
	echo $res['id_pedido'].'/'.$res['ordem'].' --- Inicio: '.$res['inicio'].' --- Dias: '.$res['dias'].' ---------------- '.$res['data_prazo2'].' --------- '.$data_prazo.'<br>';
	$cont++;
}
echo '<br>'.$cont;
require('../controle/footer.php');
?>