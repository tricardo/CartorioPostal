<?
@ini_set("memory_limit",'500M');
set_time_limit(3000);
require('../controle/header.php');
require('../includes/dias_uteis.php');
echo '<br><br><br><br>';
$p_valor ='';

$sql = "select pi.id_pedido_item from vsites_pedido_item_antigo as pi";
$query = $objQuery->SQLQuery($sql);

while($res = mysql_fetch_array($query)){
	$id_pedido_item = $res['id_pedido_item'];
	$query2 = $objQuery->SQLQuery("delete from vsites_pedido_status where id_pedido_item='".$id_pedido_item."'");
	echo $res['id_pedido_item'].'/'.$res['ordem'].' Inicio: '.$res['inicio'].' ---------------- '.$res['data_prazo2'].' --------- '.$data_prazo.'<br>';
	$cont++;
}
echo $cont;

require('../controle/footer.php');
?>