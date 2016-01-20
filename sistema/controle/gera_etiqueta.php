<?
//aqui fazemos a inclusão da biblioteca FPDF
require("../includes/fpdf/fpdf.php");

ini_set('memory_limit', '50M');

require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

pt_register('POST','linha');
pt_register('POST','coluna');

// Variaveis de Tamanho
$mesq = "11"; // Margem Esquerda (mm)
$msup = "11"; // Margem Superior (mm) margem mínima dois pois ficou cortando
$leti = "99"; // Largura da Etiqueta (mm)
$aeti = "26.6"; // Altura da Etiqueta (mm)
/*Uma dica: estes tamanhos você pode verificar com uma régua ou na própria caixa da etiqueta, seja bem preciso e sugiro que faça o teste na impressora que vai ser utilizada, pois pode acontecer de na impressão começar a subir ou descer, portanto, você deverá aumentar ou diminuir a altura da etiqueta.

Outra coisa muito importante é o tamanho do papel, que deve ser bem preciso. Caso necessário, configure um papel próprio.

*/
$pdf=new FPDF('P','mm', array(209.97, 296.93)); //papel personalizado
$pdf->Open();
$pdf->AddPage();
$pdf->SetMargins(0, 2); //seta as margens do documento
$pdf->SetAuthor('Vsites 2009');
$pdf->SetFont('Arial','', 7);
$pdf->SetDisplayMode(100, 'continuous'); //define o nivel de zoom do documento PDF

#$coluna = 0;
#$linha = 0;
$posicaoH = 0;
$posicaoV = 0;

    $cont = 0;
	$p_id_pedido_item = explode (',',str_replace(',##','',$_COOKIE['eti_id_pedido_item'].'##'));
	#verifica permissão
	foreach ($p_id_pedido_item as $chave => $id_pedido_item) {
        
			$sql = $objQuery->SQLQuery("SELECT p.id_pedido, p.nome, p.endereco, p.numero, p.complemento, p.bairro, p.cidade, p.estado, p.cep from vsites_pedido_item as pi, vsites_pedido as p, vsites_user_usuario as u where 
			pi.id_pedido_item='" . $id_pedido_item . "' and 
			pi.id_pedido=p.id_pedido and u.id_usuario=pi.id_usuario and 
			(u.id_empresa='".$controle_id_empresa."' or pi.id_empresa_resp='".$controle_id_empresa."')");
			$res = mysql_fetch_array($sql);
			
			$nome = strtoupper(substr($res["nome"], 0, 45));
			$ende = strtoupper(substr($res["endereco"], 0, 45)).','.strtoupper(substr($res["numero"], 0, 45)).' '.strtoupper(substr($res["complemento"], 0, 45));
			$bairro = strtoupper($res["bairro"]);
			$estado = strtoupper($res["estado"]);
			$cida = strtoupper($res["cidade"]);
			$local = $bairro;
			$local2 = $cida . ' – ' . $estado;
			$cep = 'CEP: ' . $res["cep"];
			$protocolo = $res["id_pedido"];

			//Para etiqueta com 11 por página
			if($linha == '11') {
				$pdf->AddPage();
				$linha = 0;
			}

			if($coluna == '2') { // Se for a segunda coluna
				$coluna = 0; // $coluna volta para o valor inicial
				$linha++;
			}

			if($linha == '11') { // Se for a última linha da página
				$pdf->AddPage(); // Adiciona uma nova página
				$linha = 0; // $linha volta ao seu valor inicial
			}

			$posicaoV = $linha*$aeti;
			$posicaoH = $coluna*$leti;

			if($coluna == '0') { // Se a coluna for 0
				$somaH = $mesq; // Soma Horizontal recebe a margem da esquerda inicial
			} else {
				$somaH = $mesq+$posicaoH; // Soma Horizontal recebe a margem inicial mais a posiçãoH
			}

			if($linha == '0') { // Se a linha for 0
				$somaV = $msup; // Soma Vertical é apenas a margem superior inicial
			} else {
				$somaV = $msup+$posicaoV; // Soma Vertical é a margem superior inicial mais a posição
			}

			$pdf->Text($somaH,$somaV,$nome);
			$pdf->Text($somaH,$somaV+4,$ende);
			$pdf->Text($somaH,$somaV+7,$local);
			$pdf->Text($somaH,$somaV+10,$local2);
			$pdf->Text($somaH,$somaV+13,$cep);
			$pdf->Text($somaH,$somaV+16,'ORDEM: #'.$protocolo);
			$coluna++;

			unset($posicaoH);
			unset($posicaoV);
			unset($somaH);
			unset($somaV);
		$cont++;
	}
	
	$pdf->Output(); //imprime a saida
?>