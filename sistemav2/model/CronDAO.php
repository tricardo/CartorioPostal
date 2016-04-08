<?php
class CronDAO extends Database{

	public function CronValorPago(){
		$this->sql = "
		SELECT cf.id_empresa, cf.id_fatura, pi.id_pedido_item, 
		cf.valor_pago, pi.valor, pi.valor_rec, cf.tipo
		FROM vsites_conta_fatura AS cf
		INNER JOIN vsites_pedido_item AS pi ON pi.id_fatura = cf.id_fatura
		INNER JOIN vsites_user_usuario AS uu ON pi.id_usuario = uu.id_usuario
		WHERE cf.cron =0
		AND cf.valor_pago !=0
		AND cf.id_fatura !=0
		ORDER BY cf.id_fatura, pi.id_pedido_item";
		$ret = $this->fetch();
		return $ret;
	}
}
?>
