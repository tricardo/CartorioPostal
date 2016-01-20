<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
include_once('../includes/classQuery.php');

$sql 	= "select * from (
	SELECT pa.count_anexo, pi.id_pedido, pi.ordem, pi.departamento, pi.usuario, date_format(pi.operacional,'%d-%m-%Y') as operacional, pi.nome FROM 
		(select pi.id_pedido_item, pi.id_pedido, pi.ordem, pi.id_servico, d.departamento, uu.nome as usuario, pi.operacional, p.nome from 
			vsites_pedido_item as pi, vsites_pedido as p, vsites_servico_departamento as d, vsites_user_usuario as uu where 
			(pi.id_status='10' or pi.id_status='8') and pi.operacional>='2011-01-01' and 
			pi.id_pedido=p.id_pedido and p.nome like '%HSBC%' and pi.id_servico_departamento=d.id_servico_departamento and 
			uu.id_usuario=pi.id_usuario_op) as pi
				LEFT JOIN 
				(select COUNT(0) as count_anexo, pa.id_pedido_item from vsites_pedido_anexo as pa group by pa.id_pedido_item) as pa 
					ON pa.id_pedido_item=pi.id_pedido_item) as pi
				where (pi.count_anexo is NULL or pi.count_anexo='0')";

$query 	= $objQuery->SQLQuery($sql);
$file_path = "../anexos/";
$cont= 0;
while($res = mysql_fetch_array($query)){
		echo '#'.$res['id_pedido'].'-'.$res['ordem'].'  - '.$res['departamento'].' - '.$res['usuario'].'-'.$res['operacional'].' - Cliente: '.$res['nome'].'<br>';
		$cont++;
}
echo $cont;
?>