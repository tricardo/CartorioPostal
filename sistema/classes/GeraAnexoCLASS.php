<?php
require_once("../includes/fpdf/fpdf.php");
class GeraAnexoCLASS extends Database{
	
	public function __construct(){
		parent::__construct();
	}
	

	/**
	* valida email
	* @param string $email
	*/
	public function geraProcessosDetran($orgao,$resultado,$anexar,$id_empresa,$id_usuario,$id_pedido,$ordem,$res_oficio){
		if($orgao=='') $orgao='Detran';
		if($resultado=='') $resultado='Nada Constou';

		// Variaveis de Tamanho
		$mesq = "10"; // Margem Esquerda (mm)
		$msup = "10"; // Margem Superior (mm) margem mínima dois pois ficou cortando)
		/*Uma dica: estes tamanhos você pode verificar com uma régua ou na própria caixa da etiqueta, seja bem preciso e sugiro que faça o teste na impressora que vai ser utilizada, pois pode acontecer de na impressão começar a subir ou descer, portanto, você deverá aumentar ou diminuir a altura da etiqueta.
		*/

		$m=date(m);
		$mes = traduzMes($m);
		$anexoDAO = new AnexoDAO();
		$impressoDAO = new ImpressoDAO();
		$atividadeDAO = new AtividadeDAO();
		
		$res = $impressoDAO->buscaPorId(28);
		$imprimir_topo    = $res->topo;
		$id_impresso      = $res->id_impresso;
		$imprimir_timbre  = $res->timbre;
		$imprimir_sub     = $res->sub;
		$imprimir_linha   = $res->linhas;
		$frase='';
		
		#if($anexar!='on'){
			$pdf=new FPDF('P','cm', 'A4'); //papel personalizado
			$pdf->Open();
			$pdf->SetMargins(1, 2); //seta as margens do documento
			$pdf->SetAuthor('Softfox 2011');
			$pdf->SetFont('times','', 7);
			$pdf->SetDisplayMode(100, 'continuous'); //define o nivel de zoom do documento PDF

			$coluna = 0;
			$linha = 0;
			$posicaoH = 0;
			$posicaoV = 0;
		#}		

		$impressao_ordem = '';
		$linha = 0;
		$frase.=$imprimir_topo;
		$bloco = '';
		
		if ($res_oficio->id_pedido<>''){
			$linha_bloco = 1;
			$orgao_regiao                                  = $res_oficio->certidao_cidade;
			$orgao_regiao                                 .= '-'.$res_oficio->certidao_estado;
			$impressao_ordem =  '#'.$res_oficio->id_pedido.'/'.$res_oficio->ordem.' ';
		
			$responsavel_endereco   = $res_oficio->endereco.' '.$res_oficio->numero.' '.$res_oficio->complemento;
			$data_atual = $res_oficio->cidade.', '.date(d).' de '.$mes.' de 20'.date(y).'.';

			$topo = str_replace('<certidao_nome>',$res_oficio->certidao_nome, $imprimir_topo);
			$topo = str_replace('<certidao_cnpj>',$res_oficio->certidao_cnpj, $topo);
			$topo = str_replace('<certidao_cpf>',$res_oficio->certidao_cpf, $topo);
			$topo = str_replace('<orgao>',$orgao, $topo);
			$topo = str_replace("<resultado>", $resultado, $topo );
			$topo = str_replace("<orgao_regiao>", $orgao_regiao, $topo );
			$topo = str_replace('<responsavel_empresa>',$res_oficio->fantasia, $topo);
			$topo = str_replace('<responsavel_endereco>',$responsavel_endereco, $topo);
			$topo = str_replace('<responsavel_cidade>',$res_oficio->cidade, $topo);
			$topo = str_replace('<responsavel_estado>',$res_oficio->estado, $topo);
			$topo = str_replace("<data>", $data_atual, $topo );
			$topo = str_replace('<impressao_ordem>',$impressao_ordem, $topo);
				
			$sub = str_replace('<responsavel_empresa>',$res_oficio->fantasia, $imprimir_sub);
			$sub = str_replace('<responsavel_endereco>',$responsavel_endereco, $sub);
			$sub = str_replace('<responsavel_cidade>',$res_oficio->cidade, $sub);
			$sub = str_replace('<responsavel_estado>',$res_oficio->estado, $sub);
			$sub = str_replace('<responsavel_cep>',$res_oficio->cep, $sub);
			$sub = str_replace('<responsavel_tel>',$res_oficio->tel, $sub);
			$sub = str_replace('<responsavel_fax>',$res_oficio->fax, $sub);
			$sub = str_replace('<responsavel_email>',$res_oficio->email, $sub);

			$pdf->AddPage();

			$pdf->Image('../images/header.jpg','0','0','19','3,04','JPG');
			$pdf->SetFont('','B',12);
			$pdf->Cell('',2,'NÃO EMITIMOS E NEM VENDEMOS CERTIDÕES E SIM PRAZOS E SOLUÇÕES','',1,'C');

			$pdf->SetFont('','B',14);
			$pdf->Cell('',2,'Declaração de Busca','',1,'C');

			$pdf->SetFont('','',12);
			$pdf->Write(1,$topo,'');
			$pdf->SetFont('','',12);
			$pdf->Cell('',1,'','',1,'C');
			$pdf->Cell('',1,'','',1,'C');
			$pdf->Cell('',1,'','',1,'C');
			$pdf->Cell('',1,'','',1,'C');
			$pdf->Cell('',1,'','',1,'C');
			$pdf->Cell('',1,'','',1,'C');
			$pdf->Cell('',1,$data_atual,'',1,'C');
			$pdf->Cell('',1,$impressao_ordem,'',1,'R');
			$pdf->ln();
			$pdf->ln();
			$pdf->ln();
			$pdf->ln();


			$pdf->Cell('',1,$res_oficio->fantasia,'',1,'C');

			$pdf->ln();

			$pdf->ln();

			$pdf->Write(0.5,$sub,'');

			$pdf->Line(1,25,20,25);
			$pdf->Ln();
			$pdf->Cell('',0.5,$rodape,'',1,'C');
			$rodape = $responsavel_endereco.', '.$res_oficio->cidade.'-'.$res_oficio->estado.' CEP: '.$res_oficio->cep;
			$pdf->Cell('',0.5,$rodape,'',1,'C');
			$rodape = 'Tel/Fax: '.$res_oficio->tel.'/'.$res_oficio->fax.' E-mail:'.$res_oficio->email;
			$pdf->Cell('',0.5,$rodape,'',1,'C');
			$rodape = 'www.cartoriopostal.com.br';
			$pdf->Cell('',0.5,$rodape,'',1,'C');
			
			if($anexar=='on' and $res_oficio->id_servico=='16'){
				$pdf->Close(); //imprime a saida
				$num_a = $anexoDAO->listaAnexoPedidoNome($res_oficio->id_pedido_item,'Declaração de Busca');
				if(COUNT($num_a)==0){
					$file_path = "../anexosnovos/".date('m').''.date('Y').'/';#alterado => "../anexos/"
					if(! is_dir($file_path)){ mkdir($file_path, 0777); }#alterado
					$arq_anexo = $file_path.'decla_busca_'.$res_oficio->id_pedido_item.'_'.time().'.pdf';
					$pdf->Output($arq_anexo,'F'); //imprime a saida
					$anexo->anexo=$arq_anexo;
					$anexo->anexo_nome='Declaração de Busca';
					$anexo->id_pedido_item=$res_oficio->id_pedido_item;
					$anexo->id_usuario=$id_usuario;
					$anexoDAO->inserir($anexo);
					$ativ = $atividadeDAO->inserir('209','',$id_usuario,$res_oficio->id_pedido_item);
					return 'Declaração anexada para '.$impressao_ordem.'<br>';
				} else	{
					return 'Declaração não pode ser anexada para '.$impressao_ordem.' porque o anexo já existe<br>';
				}
			} else {
				if($anexar=='on' and $res_oficio->id_servico!='16'){
					return '<b>Declaração não pode ser anexada para '.$impressao_ordem.' porque o serviço não é "Pesquisa Detran</b>"<br>';
				}
			}
		}

		if($anexar!='on'){
			return $pdf->Output(); //imprime a saida
		} else {
			return 1;
		}	
	}
	
}
?>