<?
//aqui fazemos a inclusão da biblioteca FPDF
require("../includes/fpdf/fpdf.php");

ini_set('memory_limit', '50M');

require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

pt_register('POST','resultado');
pt_register('POST','orgao');
pt_register('POST','orgao_regiao');
pt_register('POST','anexar');

// Variaveis de Tamanho
$mesq = "10"; // Margem Esquerda (mm)
$msup = "10"; // Margem Superior (mm) margem mínima dois pois ficou cortando)
/*Uma dica: estes tamanhos você pode verificar com uma régua ou na própria caixa da etiqueta, seja bem preciso e sugiro que faça o teste na impressora que vai ser utilizada, pois pode acontecer de na impressão começar a subir ou descer, portanto, você deverá aumentar ou diminuir a altura da etiqueta.

Outra coisa muito importante é o tamanho do papel, que deve ser bem preciso. Caso necessário, configure um papel próprio.

*/
#$sql = $objQuery->SQLQuery("SELECT empresa, endereco, numero, email, complemento, cidade, estado, tel, cep, fax  from vsites_user_empresa as ue where id_empresa='".$controle_id_empresa."'");
#$res = mysql_fetch_array($sql);
#$responsavel_empresa    = $res['empresa'];
#$responsavel_email	    = $res['email'];
#$responsavel_endereco   = $res['endereco'].' '.$res['numero'].' '.$res['complemento'];
#
#$responsavel_cidade     = $res['cidade'];
#$responsavel_estado     = $res['estado'];
#$responsavel_cep        = $res['cep'];
#$responsavel_tel        = $res['tel'];
#$responsavel_fax        = $res['fax'];


    $m=date(m);
    if($m == '1') $mes = 'Janeiro';
    if($m == '2') $mes = 'Fevereiro';
    if($m == '3') $mes = 'Março';
    if($m == '4') $mes = 'Abril';
    if($m == '5') $mes = 'Maio';
    if($m == '6') $mes = 'Junho';
    if($m == '7') $mes = 'Julho';
    if($m == '8') $mes = 'Agosto';
    if($m == '9') $mes = 'Setembro';
    if($m == '10') $mes = 'Outubro';
    if($m == '11') $mes = 'Novembro';
    if($m == '12') $mes = 'Dezembro';
    $data_atual = $responsavel_cidade.', '.date(d).' de '.$mes.' de 20'.date(y).'.';
	
	
$sql = $objQuery->SQLQuery("SELECT * from vsites_impresso as i where tipo_impresso='Banco BIC'");
$res = mysql_fetch_array($sql);
$imprimir_topo    = $res['topo'];
$id_impresso      = $res['id_impresso'];
$imprimir_timbre  = $res['timbre'];
$imprimir_sub     = $res['sub'];
$imprimir_linha   = $res['linhas'];	
$frase='';

if($anexar!='on'){
	$pdf=new FPDF('P','cm', 'A4'); //papel personalizado
	$pdf->Open();
	$pdf->SetMargins(1, 2); //seta as margens do documento
	$pdf->SetAuthor('Vsites 2009');
	$pdf->SetFont('Arial','', 7);
	$pdf->SetDisplayMode(100, 'continuous'); //define o nivel de zoom do documento PDF

	$coluna = 0;
	$linha = 0;
	$posicaoH = 0;
	$posicaoV = 0;
}
    $impressao_ordem = '';
    $cont = 0;
	$linha = 0;
    $frase.=$imprimir_topo;
	while($cont <= 50){
		$cont++;
		pt_register('POST','acao_'.$cont);
		pt_register('POST','acao_sel_'.$cont);
		pt_register('POST','acao_pedido_'.$cont);
        $id_pedido_item = ${'acao_'.$cont};
        
        if(${'acao_sel_'.$cont}=='on'){

		if($anexar=='on'){
			$pdf=new FPDF('P','cm', 'A4'); //papel personalizado
			$pdf->Open();
			$pdf->SetMargins(1, 2); //seta as margens do documento
			$pdf->SetAuthor('Vsites 2009');
			$pdf->SetFont('Arial','', 7);
			$pdf->SetDisplayMode(100, 'continuous'); //define o nivel de zoom do documento PDF

			$coluna = 0;
			$linha = 0;
			$posicaoH = 0;
			$posicaoV = 0;
		}
		$bloco = '';
        $sql = $objQuery->SQLQuery("SELECT pi.id_pedido, pi.id_servico, pi.ordem, pi.certidao_nome, pi.certidao_cnpj, pi.certidao_cpf, s.descricao as servico, uu.nome as responsavel, uu.email as responsavel_email from vsites_pedido_item as pi, vsites_user_usuario as uu, vsites_servico as s where pi.id_servico=s.id_servico and pi.id_pedido_item='" . $id_pedido_item . "' and uu.id_usuario=pi.id_usuario and (uu.id_empresa='".$controle_id_empresa."' or pi.id_empresa_resp='".$controle_id_empresa."')");
     	$res = mysql_fetch_array($sql);
     	$num = mysql_num_rows($sql);
		if ($num<>''){
			$linha_bloco = 1;
			$ordem						                   = $res['ordem'];
			$id_pedido					                   = $res['id_pedido'];	    
			$id_servico					                   = $res['id_servico'];	    
			$certidao_nome		                           = $res['certidao_nome'];
			$certidao_cpf                                  = $res['certidao_cpf'];
			$certidao_cnpj                                 = $res['certidao_cnpj'];
			$impressao_ordem =  '#'.$id_pedido.'/'.$ordem.' ';
		
			$topo = str_replace('<certidao_nome>',$certidao_nome, $imprimir_topo);
			$topo = str_replace('<certidao_cnpj>',$certidao_cnpj, $topo);
			$topo = str_replace('<certidao_cpf>',$certidao_cpf, $topo);
			$topo = str_replace('<orgao>',$orgao, $topo);
			$topo = str_replace("<resultado>", $resultado, $topo );
			$topo = str_replace("<orgao_regiao>", $orgao_regiao, $topo );
			$topo = str_replace('<responsavel_empresa>',$responsavel_empresa, $topo);
			$topo = str_replace('<responsavel_endereco>',$responsavel_endereco, $topo);
			$topo = str_replace('<responsavel_cidade>',$responsavel_cidade, $topo);
			$topo = str_replace('<responsavel_estado>',$responsavel_estado, $topo);
			$topo = str_replace("<data>", $data_atual, $topo );
			$topo = str_replace('<impressao_ordem>',$impressao_ordem, $topo);
			
			$sub = str_replace('<responsavel_empresa>',$responsavel_empresa, $imprimir_sub);
			$sub = str_replace('<responsavel_endereco>',$responsavel_endereco, $sub);
			$sub = str_replace('<responsavel_cidade>',$responsavel_cidade, $sub);
			$sub = str_replace('<responsavel_estado>',$responsavel_estado, $sub);
			$sub = str_replace('<responsavel_cep>',$responsavel_cep, $sub);
			$sub = str_replace('<responsavel_tel>',$responsavel_tel, $sub);
			$sub = str_replace('<responsavel_fax>',$responsavel_fax, $sub);
			$sub = str_replace('<responsavel_email>',$responsavel_email, $sub);
			$pdf->AddPage();
		
			$pdf->Image('../images/header.jpg','0','0','19','3,04','JPG');
			$pdf->SetFont('','B',20);
			$pdf->Cell('',8,'Declaração de Busca','',1,'C');
		
			$pdf->SetFont('','',16);
			$pdf->Write(1,$topo,'');
			$pdf->SetFont('','',10);
			$pdf->ln();
			$pdf->ln();
		
			$pdf->Write(0.5,$sub,'');
		
			if($anexar=='on' and $id_servico=='16'){
				$pdf->Close(); //imprime a saida
				$sql = "select id_pedido_item from vsites_pedido_anexo as pa where anexo_nome='Notificação' and id_pedido_item='".$id_pedido_item."'";
				$res_a = $objQuery->SQLQuery($sql);	
				$num_a = mysql_num_rows($res_a);
				if($num_a==''){
					$pdf->Output('../anexos/decla_notifica_'.$id_pedido_item.'.pdf','F'); //imprime a saida
					$sql = "insert into vsites_pedido_anexo (anexo,anexo_nome,id_pedido_item,id_usuario) values('../anexos/decla_busca_".$id_pedido_item.".pdf','Notificação','".$id_pedido_item."','".$controle_id_usuario."')";
					$result = $objQuery->SQLQuery($sql);	
					echo 'Declaração anexada para '.$impressao_ordem.'<br>';
				} else	{
					echo 'Declaração não pode ser anexada para '.$impressao_ordem.' porque o anexo já existe<br>';
				}
			} else {
				if($anexar=='on' and ($id_servico!='17' or $id_servico!='63')){
					echo '<b>O notificação não pode ser anexada para '.$impressao_ordem.' porque o serviço não é de "Notificação</b>"<br>';
				}
			}
		
		
		}

        }
	}
	if($anexar!='on'){
		$pdf->Output(); //imprime a saida
	}	
?>