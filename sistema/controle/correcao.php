<?
require('../includes/classQuery.php');
$sql_campo2 	= "SELECT pi.* FROM vsites_pedido_item_erros as pie, vsites_pedido_item as pi where pi.id_pedido_item=pie.id_pedido_item and pi.data_atividade<='2012-03-12 00:00:00' and (pi.id_status=21 or pi.id_status=17)";
$query_campo = $objQuery->SQLQuery($sql_campo2);
while($res 	= mysql_fetch_array($query_campo)){
        $sql_campo = "SELECT a.id_status, ps.id_atividade from vsites_pedido_status as ps, vsites_atividades as a where ps.id_pedido_item='".$res['id_pedido_item']."' and a.id_atividade=ps.id_atividade and a.id_status!='0' and a.id_status!='99' order by ps.id_pedido_status DESC LIMIT 1";
		$query_status = $objQuery->SQLQuery($sql_campo);
		$res_status   = mysql_fetch_array($query_status);
		
		$sql_campo3 = "update vsites_pedido_item set id_status='".$res_status['id_status']."', id_atividade='".$res_status['id_atividade']."' where id_pedido_item='".$res['id_pedido_item']."'";
		echo $sql_campo3.'<br>';
		$query_status3 = $objQuery->SQLQuery($sql_campo3);		
}
require('footer.php');
?>
