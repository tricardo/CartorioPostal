<?php
header("Content-Type: text/html; charset=UTF-8",true);
require("../includes/verifica_logado_ajax.inc.php");
require("../includes/funcoes.php");
require("../includes/global.inc.php");

$pedidoDAO  = new PedidoDAO();

$mes 	 	= array('','Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
$cpf 		= $_GET['id'];
$total_qtde = 0;
$total_vlr  = (float)0;

$c = new stdClass();
$c->cpf = $cpf;
$c->id_empresa = $controle_id_empresa;

$pedido = $pedidoDAO->BalancoFianceiro($c);
?>
<table width="645" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td width="100" style="border:solid 1px #0D357D; border-bottom:none; font-weight:bold; background-color:#7BB2E4; padding-left:8px;">Mês</td>
    <td width="50" style="border:solid 1px #0D357D; border-bottom:none; border-left:none; font-weight:bold; background-color:#7BB2E4; text-align:center">Qtde.</td>
    <td width="100" style="border:solid 1px #0D357D; border-bottom:none; border-left:none; font-weight:bold; padding-left:8px; background-color:#7BB2E4">Valor (R$)</td>
  </tr>
  <?php if(count($pedido) > 0){
	$total_vlr = 0;
  	foreach($pedido as $ped => $p){
		$nome       = $p->nome;
		$valor      = number_format(((float)$arr_valor + (float)$p->valor), 2, ',', ' ');
		$total_vlr  = (float)$total_vlr + (float)$p->valor;
		$dt1		= explode(' ', $p->data);
		$dt2        = explode('-', $dt1[0]);
		$i          = (int)$dt2[1];
		$arr_qtde++;?>
      <tr bgcolor="<?php echo $bgcolor;?>">
        <td style="border:solid 1px #0D357D; border-right:none; border-bottom:none; padding-left:8px;"><?php echo ucwords(strtolower($nome));?></td>
        <td style="border:solid 1px #0D357D; border-bottom:none; padding-left:8px;"><?php echo $mes[$i];?></td>
        <td style="border:solid 1px #0D357D; border-left:none; border-bottom:none; text-align:center;">1</td>
        <td style="border:solid 1px #0D357D; border-left:none; border-bottom:none; padding-left:8px;">R$ <?php echo $valor;?></td>
      </tr>
  <?php }} else { ?>
  <tr>
  	<td colspan="4">Nenhuma pedido computado.</td>
  </tr>
  <?php } ?>
  <tr>
  	<td style="border:solid 1px #0D357D; background-color:#7BB2E4; border-right:none;">&nbsp;</td>
    <td style="border:solid 1px #0D357D; background-color:#7BB2E4; font-weight:bold; padding-left:8px;">Total</td>
    <td style="border:solid 1px #0D357D; background-color:#7BB2E4; border-left:none; text-align:center"><?php echo $arr_qtde;?></td>
    <td style="border:solid 1px #0D357D; background-color:#7BB2E4; border-left:none; padding-left:8px;">R$ <?php echo number_format($total_vlr, 2, ',', ' ');?></td>
  </tr>
</table>