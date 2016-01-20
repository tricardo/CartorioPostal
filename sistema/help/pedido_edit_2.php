<? 
header("Content-Type: text/html; charset=ISO-8859-1",true); 
require('../includes/global.inc.php');
pt_register('GET','id_status');
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1"></head><body>
<ul>
	<?
	switch ($id_status){
		case(1):
			echo '<li>Seu pedido está com status <b>Aberto</b>, a proxima atividade pode ser: <b>Serviço Conferido</b> ou <b>Aguardando Identificação de Depósito</b></li>';
			break;
		case(2):
			echo '<li>Seu pedido está aguardando confirmação de depósito, o financeiro precisa clicar em <b>Aprovar</b> ou <b>Reprovar</b> na tela de <b>Recebimentos</b> que está localizada no menu <b>Financeiro</b></li>';
			break;		
		case(3):
			echo '<li>Seu pedido está com status <b>Cadastrado</b>, o próximo passo é aplicar a atividade <b>Iniciar Serviço</b></li>';
			break;
		case(4):
			echo '<li>O próximo passo pode ser:</li>
			<li>1) <b>Solicitar Desembolso</b></li>
			<li>2) <b>Solicitar o documento no Cartório</b> ou <b>Enviar o documento para a franquia</b> na tela de Direcionamento localizado no menu Cadastros</li>
			<li>3) Aplicar a atividade <b>Concluído Operacional</b></li>
			<li>4) Aplicar a atividade <b>Liberado para Entrega</b> ou <b>Liberado para Faturamento</b></li>';
			break;
		case(5):
			echo '<li>Seu pedido está com status <b>Desembolso</b>, o financeiro precisa aprovar ou reprovar a solicitação do desembolso</li>';
			break;			
		case(6):
			echo '<li>Seu pedido está com status <b>Execução</b> a próxima atividade é <b>Retorno do Protocolo</b></li>';
			break;			
		case(7):
			echo '<li>O próximo passo pode ser:</li>
			<li>1) <b>Solicitar o documento no Cartório</b> ou <b>Enviar o documento para a franquia</b> na tela de Direcionamento localizado no menu Cadastros</li>
			<li>2) Aplicar a atividade <b>Concluído Operacional</b></li>
			<li>3) Aplicar a atividade <b>Liberado para Entrega</b> ou <b>Liberado para Faturamento</b></li>';
			break;			
		case(8):
			echo '<li>Após emitir a nota fiscal e o boleto é preciso aplicar a atividade <b>Liberado para Entrega</b> ou <b>Serviço Concluído</b></li>';
			break;
		case(9):
			echo '<li>Após emitir liberar o documento para entrega é preciso aplicar a atividade <b>Serviço Concluído</b></li>';
			break;
		case(10):
			echo '<li>Após a conclusão do serviço para reabrir é preciso aplicar <b>Retomar Serviço</b></li>';
			break;
		case(11):
			echo '<li>É preciso ligar para o cliente e verificar se o depósito foi feito e quando vai fazer para aplicar a atividade <b>Aguardando Identificação de Depósito</b> ou <b>Serviço Conferido</b></li>';
			break;
		case(12):
			echo '<li>É preciso ligar para o cliente e verificar os dados que estão faltando e depois aplicar a atividade <b>Informação Recebida</b> para voltar ao status anterior</li>';
			break;
		case(13):
			echo '<li>Após receber o apoio do jurídico aplicar <b>Retomar Serviço"</b></li>';
			break;
		case(15):
			echo '<li>A execução do pedido está parada, aplique <b>Retomar Serviço</b></li>';
			break;
		case(16):
			echo '<li>Foi enviado orçamento para o Cliente e agora você pode aplicar <b>Serviço Conferido</b> ou <b>Cancelar o Pedido</b></li>';
			break;
		case(17):
			echo '<li>Próxima atividade é: <b>Liberado para Faturamento</b> ou <b>Liberado para entrega</b></li>';
			break;
		case(18):
			echo '<li>Após receber o documento da franquia a responsável pelo atendimento do pedido precisa aplicar <b>Concluído Operacional</b> e depois <b>Liberado para Faturamento ou Entrega</b> </li>';
			break;
		case(19):
			echo '<li>O financeiro da unidade responsável pela execução do pedido precisa acusar o recebimento dos valores das custas e honorários na tela de <b>Recebimento</b> localizada no menu <b>Financeiro</b></li>';
			break;
		case(20):
			echo '<li>Após o cliente efetuar o pagamento é preciso aplicar Serviço Conferido</li>';
			break;
	}
	?>
	<li><br><b>Obs: A qualquer momento é possível aplicar a atividade <b>Motivo do Cancelamento</b> exceto quando o pedido foi concluído</b></li>	
</ul>
</body></html>