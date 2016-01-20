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
			echo '<li>Seu pedido est� com status <b>Aberto</b>, a proxima atividade pode ser: <b>Servi�o Conferido</b> ou <b>Aguardando Identifica��o de Dep�sito</b></li>';
			break;
		case(2):
			echo '<li>Seu pedido est� aguardando confirma��o de dep�sito, o financeiro precisa clicar em <b>Aprovar</b> ou <b>Reprovar</b> na tela de <b>Recebimentos</b> que est� localizada no menu <b>Financeiro</b></li>';
			break;		
		case(3):
			echo '<li>Seu pedido est� com status <b>Cadastrado</b>, o pr�ximo passo � aplicar a atividade <b>Iniciar Servi�o</b></li>';
			break;
		case(4):
			echo '<li>O pr�ximo passo pode ser:</li>
			<li>1) <b>Solicitar Desembolso</b></li>
			<li>2) <b>Solicitar o documento no Cart�rio</b> ou <b>Enviar o documento para a franquia</b> na tela de Direcionamento localizado no menu Cadastros</li>
			<li>3) Aplicar a atividade <b>Conclu�do Operacional</b></li>
			<li>4) Aplicar a atividade <b>Liberado para Entrega</b> ou <b>Liberado para Faturamento</b></li>';
			break;
		case(5):
			echo '<li>Seu pedido est� com status <b>Desembolso</b>, o financeiro precisa aprovar ou reprovar a solicita��o do desembolso</li>';
			break;			
		case(6):
			echo '<li>Seu pedido est� com status <b>Execu��o</b> a pr�xima atividade � <b>Retorno do Protocolo</b></li>';
			break;			
		case(7):
			echo '<li>O pr�ximo passo pode ser:</li>
			<li>1) <b>Solicitar o documento no Cart�rio</b> ou <b>Enviar o documento para a franquia</b> na tela de Direcionamento localizado no menu Cadastros</li>
			<li>2) Aplicar a atividade <b>Conclu�do Operacional</b></li>
			<li>3) Aplicar a atividade <b>Liberado para Entrega</b> ou <b>Liberado para Faturamento</b></li>';
			break;			
		case(8):
			echo '<li>Ap�s emitir a nota fiscal e o boleto � preciso aplicar a atividade <b>Liberado para Entrega</b> ou <b>Servi�o Conclu�do</b></li>';
			break;
		case(9):
			echo '<li>Ap�s emitir liberar o documento para entrega � preciso aplicar a atividade <b>Servi�o Conclu�do</b></li>';
			break;
		case(10):
			echo '<li>Ap�s a conclus�o do servi�o para reabrir � preciso aplicar <b>Retomar Servi�o</b></li>';
			break;
		case(11):
			echo '<li>� preciso ligar para o cliente e verificar se o dep�sito foi feito e quando vai fazer para aplicar a atividade <b>Aguardando Identifica��o de Dep�sito</b> ou <b>Servi�o Conferido</b></li>';
			break;
		case(12):
			echo '<li>� preciso ligar para o cliente e verificar os dados que est�o faltando e depois aplicar a atividade <b>Informa��o Recebida</b> para voltar ao status anterior</li>';
			break;
		case(13):
			echo '<li>Ap�s receber o apoio do jur�dico aplicar <b>Retomar Servi�o"</b></li>';
			break;
		case(15):
			echo '<li>A execu��o do pedido est� parada, aplique <b>Retomar Servi�o</b></li>';
			break;
		case(16):
			echo '<li>Foi enviado or�amento para o Cliente e agora voc� pode aplicar <b>Servi�o Conferido</b> ou <b>Cancelar o Pedido</b></li>';
			break;
		case(17):
			echo '<li>Pr�xima atividade �: <b>Liberado para Faturamento</b> ou <b>Liberado para entrega</b></li>';
			break;
		case(18):
			echo '<li>Ap�s receber o documento da franquia a respons�vel pelo atendimento do pedido precisa aplicar <b>Conclu�do Operacional</b> e depois <b>Liberado para Faturamento ou Entrega</b> </li>';
			break;
		case(19):
			echo '<li>O financeiro da unidade respons�vel pela execu��o do pedido precisa acusar o recebimento dos valores das custas e honor�rios na tela de <b>Recebimento</b> localizada no menu <b>Financeiro</b></li>';
			break;
		case(20):
			echo '<li>Ap�s o cliente efetuar o pagamento � preciso aplicar Servi�o Conferido</li>';
			break;
	}
	?>
	<li><br><b>Obs: A qualquer momento � poss�vel aplicar a atividade <b>Motivo do Cancelamento</b> exceto quando o pedido foi conclu�do</b></li>	
</ul>
</body></html>