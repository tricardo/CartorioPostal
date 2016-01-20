<?
require("../includes/verifica_logado_ajax.inc.php");
require("../includes/funcoes.php");
require("../includes/global.inc.php");

//aqui fazemos a inclusão da biblioteca FPDF
require("../includes/fpdf/fpdf.php");

ini_set('memory_limit', '50M');

pt_register('POST','id_impresso');
pt_register('POST','prot1');
pt_register('POST','prot2');
pt_register('POST','prot3');
pt_register('POST','prot4');
pt_register('POST','prot5');
pt_register('POST','prot6');
pt_register('POST','prot7');
pt_register('POST','prot8');
pt_register('POST','prot9');
pt_register('POST','prot10');
pt_register('POST','prot11');
pt_register('POST','prot12');
pt_register('POST','prot13');
pt_register('POST','prot14');
pt_register('POST','prot15');
pt_register('POST','prot16');
pt_register('POST','prot17');
pt_register('POST','prot18');

pt_register('POST','cart1');
pt_register('POST','cart2');
pt_register('POST','cart3');
pt_register('POST','cart4');
pt_register('POST','cart5');
pt_register('POST','cart6');
pt_register('POST','cart7');
pt_register('POST','cart8');
pt_register('POST','cart9');
pt_register('POST','cart10');
pt_register('POST','cart11');
pt_register('POST','cart12');
pt_register('POST','cart13');
pt_register('POST','cart14');
pt_register('POST','cart15');
pt_register('POST','cart16');
pt_register('POST','cart17');
pt_register('POST','cart18');

pt_register('POST','anexar');
pt_register('POST','orgao');
pt_register('POST','obs');

// Variaveis de Tamanho
$mesq = "10"; // Margem Esquerda (mm)
$msup = "10"; // Margem Superior (mm) margem mínima dois pois ficou cortando)
/*Uma dica: estes tamanhos você pode verificar com uma régua ou na própria caixa da
etiqueta, seja bem preciso e sugiro que faça o teste na impressora que vai ser
utilizada, pois pode acontecer de na impressão começar a subir ou descer, portanto,
você deverá aumentar ou diminuir a altura da etiqueta.
Outra coisa muito importante é o tamanho do papel, que deve ser bem preciso. Caso
necessário, configure um papel próprio.
*/

$m=date(m);
$mes = traduzMes($m);
$impressoDAO = new ImpressoDAO();
$imp = $impressoDAO->buscaPorId($id_impresso);
$imprimir_topo    = $imp->topo;
$id_impresso      = $imp->id_impresso;
$imprimir_timbre  = $imp->timbre;
$imprimir_sub     = $imp->sub;
$imprimir_linha   = $imp->linhas;
$frase='';

if($anexar!='on'){
	$pdf=new FPDF('P','cm', 'A4'); //papel personalizado
	$pdf->Open();
	$pdf->SetMargins(1, 2); //seta as margens do documento
	$pdf->SetAuthor('Vsites 2009');
	$pdf->SetFont('times','', 7);
	$pdf->SetDisplayMode(100, 'continuous'); //define o nivel de zoom do documento PDF

	$coluna = 0;
	$linha = 0;
	$posicaoH = 0;
	$posicaoV = 0;
}

$impressao_ordem = '';
$linha = 0;
$frase.=$imprimir_topo;
$p_id_pedido_item = explode(',',str_replace(',##','',$_COOKIE['imoveis_d_id_pedido_item'].'##'));

$pedidoDAO = new PedidoDAO();
$atividadeDAO = new AtividadeDAO();
foreach ($p_id_pedido_item as $chave => $id_pedido_item) {
	$valida = valida_numero($id_pedido_item);
	if($valida!='TRUE'){
		echo 'Ocorreu um erro ao validar o número dos pedido(s) selecionado(s). O número
de um dos pedidos não é válido';
		exit;
	}

	if($anexar=='on'){
		$pdf=new FPDF('P','cm', 'A4'); //papel personalizado
		$pdf->Open();
		$pdf->SetMargins(1, 2); //seta as margens do documento
		$pdf->SetAuthor('Vsites 2009');
		$pdf->SetFont('times','', 7);
		$pdf->SetDisplayMode(100, 'continuous'); //define o nivel de zoom do documento PDF

		$coluna = 0;
		$linha = 0;
		$posicaoH = 0;
		$posicaoV = 0;
	}

	$bloco = '';

	$ped = $pedidoDAO->selecPedidoPorIdOficio($id_pedido_item,$controle_id_empresa);
	
	if ($ped->id_pedido<>''){
		
		$linha_bloco = 1;
		$ordem            		        = $ped->ordem;
		$id_pedido                      = $ped->id_pedido;
		$id_servico             	    = $ped->id_servico;
		$id_conveniado             	    = $ped->id_conveniado;
		$contato                        = $ped->contato;
		$custas                     	= $ped->custas;
		$certidao_nome                  = $ped->certidao_nome.$ped->certidao_nome_proprietario;
		$certidao_cpf                   = $ped->certidao_cpf;
		$certidao_cnpj                  = $ped->certidao_cnpj;
		$certidao_cidade                = $ped->certidao_cidade.' - '.$ped->certidao_estado;
		
		$responsavel_empresa    = $ped->empresa;
		if($controle_id_empresa=='1') $responsavel_empresa    = $ped->fantasia;
		$responsavel_email            = $ped->email;
		$responsavel_endereco   = $ped->endereco.', '.$ped->numero.' '.$ped->complemento;
		$responsavel_cidade     = $ped->cidade;
		$responsavel_estado     = $ped->estado;
		$responsavel_cep        = $ped->cep;
		$responsavel_tel        = $ped->tel;
		$responsavel_fax        = $ped->fax;
		$responsavel_cnpj        = $ped->cnpj;

		if($ped->certidao_comarca_forum) $certidao_cidade  .= '('.$ped->certidao_comarca_forum.')';
		$impressao_ordem =  '#'.$id_pedido.'/'.$ordem.' ';

		$topo = str_replace('<certidao_nome>',$certidao_nome, $imprimir_topo);
		$topo = str_replace('<certidao_cnpj>',$certidao_cnpj, $topo);
		$topo = str_replace('<certidao_cpf>',$certidao_cpf, $topo);
		$topo = str_replace('<orgao>',$orgao, $topo);
		$topo = str_replace('<responsavel_empresa>',$responsavel_empresa, $topo);
		$topo = str_replace('<responsavel_cnpj>',$responsavel_cnpj, $topo);
		$topo = str_replace('<responsavel_endereco>',$responsavel_endereco, $topo);
		$topo = str_replace('<responsavel_cidade>',$responsavel_cidade, $topo);
		$topo = str_replace('<responsavel_estado>',$responsavel_estado, $topo);
		$topo = str_replace('<cidade>',$certidao_cidade, $topo);
		if($certidao_cidade!='São Paulo - SP' && $certidao_cidade!='São Paulo')
			$topo = str_replace('18 Cartórios de Registro de Imóveis ','Cartórios de Registro de Imóveis ', $topo);
		$topo = str_replace('<responsavel_cep>',$responsavel_cep, $topo);

		$sub = str_replace('<responsavel_empresa>',$responsavel_empresa, $imprimir_sub);
		$sub = str_replace('<responsavel_endereco>',$responsavel_endereco, $sub);
		$sub = str_replace('<responsavel_cidade>',$responsavel_cidade, $sub);
		$sub = str_replace('<responsavel_estado>',$responsavel_estado, $sub);
		$sub = str_replace('<responsavel_tel>',$responsavel_tel, $sub);
		$sub = str_replace('<responsavel_fax>',$responsavel_fax, $sub);
		$sub = str_replace('<responsavel_email>',$responsavel_email, $sub);
		$sub = str_replace('<responsavel_email>',$responsavel_email, $sub);
		$sub = str_replace('<impressao_ordem>',$impressao_ordem, $sub);
		
		$data_atual = $responsavel_cidade.', '.date(d).' de '.$mes.' de '.date('Y').'.';
		$sub = str_replace("<data>", $data_atual, $sub );
		$sub = str_replace("<contato>", $contato, $sub );

		if($custas<>'' && ($id_conveniado==635 || $id_conveniado==26198 || $id_conveniado==26341 || $id_conveniado==26118 || $id_conveniado==28815))
        $sub = str_replace("<custas>", 'Custas: R$ '.$custas, $sub );
		else $sub = str_replace("<custas>",'', $sub );

		$pdf->AddPage();

		$pdf->Image('../images/header.jpg','0','0','19','3,04','JPG');

		$pdf->SetFont('times','B',12);

		$pdf->Cell(19.2,2.5,'NÃO EMITIMOS E NEM VENDEMOS CERTIDÕES E SIM PRAZOS E SOLUÇÕES',0,1,'C');

		require('gera_imoveis_busca_'.$id_impresso.'.php');

		$pdf->SetFont('times','',12);
		$pdf->Write(0.5,$sub,'');
		$pdf->Write(0.5,'

                        ','');
		$pdf->SetFont('times','B',10);
		$pdf->Line(1,25.5,20,25.5);
		$pdf->SetY(25.5);
		$pdf->Cell(0,0.5,$responsavel_empresa,0,1,'C');

		$rodape = $responsavel_endereco.',
'.$responsavel_cidade.'-'.$responsavel_estado.' CEP: '.$responsavel_cep;

		$pdf->Cell(0,0.5,$rodape,0,1,'C');
		$rodape = 'Tel/Fax: '.$responsavel_tel.'/'.$responsavel_fax.'

E-mail:'.$responsavel_email;
		$pdf->Cell(0,0.5,$rodape,0,1,'C');
		$rodape = 'www.cartoriopostal.com.br';
		$pdf->Cell(0,0.5,$rodape,0,1,'C');

		if($anexar=='on' and ($id_servico=='11' or $id_servico=='169' or $id_servico=='170')){
			$pdf->Close(); //imprime a saida
			$anexoDAO = new AnexoDAO();
			$num_a = $anexoDAO->verifica('Declaração de Busca de Imóveis',$id_pedido_item);
			if($num_a==0){
				$file_path = "../anexosnovos/".date('m').''.date('Y').'/';#alterado => "../anexos/"
				if(! is_dir($file_path)){ mkdir($file_path, 0777); }#alterado
				$pdf->Output($file_path.$anexo->anexo,'F');
				#$pdf->Output('../anexos/'.$anexo->anexo,'F');
				$anexo = new stdClass();
				$anexo->anexo = $file_path.'decla_busca_imoveis_'.$id_pedido_item.'_'.time().'.pdf';
				//imprime a saida
				$anexo->anexo_nome = 'Declaração de Busca de Imóveis';
				$anexo->id_pedido_item = $id_pedido_item;
				$anexo->id_usuario = $controle_id_usuario; 
				$anexoDAO->inserir($anexo);
				if(count($p_id_pedido_item)==1)
					$pdf->Output();
				else
					echo 'Declaração anexada para '.$impressao_ordem.'<br>';
				$ativ = $atividadeDAO->inserir('209','',$controle_id_usuario,$id_pedido_item);
			} else {
				echo 'Declaração não pode ser anexada para '.$impressao_ordem.' porque o anexo já existe<br>';
			}
		} else {
			if($anexar=='on' and $id_servico!='11' and $id_servico!='169' and $id_servico!='170'){
				echo '<b>Declaração não pode ser anexada para '.$impressao_ordem.' porque o serviço não é "Pesquisa de Imóveis</b>"<br>';
			}
		}
	}

}

if($anexar!='on'){
	$pdf->Output(); //imprime a saida
}

?>