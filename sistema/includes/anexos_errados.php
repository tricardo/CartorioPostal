<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
include_once('../includes/classQuery.php');

$sql 	= "SELECT pa.*,pi.id_pedido, pi.ordem, sd.departamento, uu.nome as usuario FROM vsites_pedido_anexo as pa, vsites_pedido_item as pi, vsites_servico_departamento sd, vsites_user_usuario as uu, vsites_pedido as p where pa.data>='2010-07-21 00:00:00' and pa.id_pedido_item=pi.id_pedido_item and pa.id_usuario=uu.id_usuario and uu.id_empresa=1 and pi.id_pedido=p.id_pedido and pi.id_servico_departamento=sd.id_servico_departamento order by pi.id_pedido, pi.ordem ASC";

$query 	= $objQuery->SQLQuery($sql);
$file_path = "../anexos/";
$cont= 0;
while($res = mysql_fetch_array($query)){
	#$data = strtotime($res['data']);
	#$anexo = 'decla_busca_'.$res['id_pedido_item'].'_'.$data.'pdf';
	if(!file_exists($file_path.$res['anexo']) and !file_exists($res['anexo']) and $res['anexo']<>'') {
		echo '#'.$res['id_pedido'].'-'.$res['ordem'].'  - '.$res['departamento'].' - '.$res['usuario'].'-'.$res['anexo'].'-'.$res['data'].'<br>';
		$cont++;
		$sql2 	= "delete from vsites_pedido_anexo where id_pedido_anexo='".$res['id_pedido_anexo']."'";
		echo $sql2.'<br>';
		$query2 = $objQuery->SQLQuery($sql2);
	}
}
echo $cont;
?>