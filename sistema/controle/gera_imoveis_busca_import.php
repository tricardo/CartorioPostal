<?php
$submit = $_POST['submit'];
$anexar = ($_POST['anexar']=='on');
$arquivo = isset($_FILES["arquivo"]) ? $_FILES["arquivo"] : false;
ini_set('memory_limit',524288000);
$atividadeDAO = new AtividadeDAO();

if($submit){
	
	if(!$anexar){
		require( "../includes/verifica_logado_ajax.inc.php");
		require( "../includes/funcoes.php" );
		require( "../includes/global.inc.php" );
	}else{
		require('header.php');
	}

	$departamento_s = explode(',' ,$controle_id_departamento_s);
	$departamento_p = explode(',' ,$controle_id_departamento_p);

	if($controle_id_empresa!=1 or in_array('8',$departamento_p)!=1){
		#somente o id_empresa 1 com permissão de imoveis pode acessar essa página
		echo 'Somente o departamento de imóveis da franqueadora pode acessar essa página!';
		exit;
	}
	
	pt_register('POST','id_impresso');
	pt_register('POST','anexar');
	pt_register('POST','orgao');

	require("../includes/fpdf/fpdf.php");
	require_once '../includes/Excel/excel_reader.php';

	$pedidoDAO = new PedidoDAO();
	$empresaDAO = new EmpresaDAO();

	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$data->read($arquivo['tmp_name']);
	error_reporting(E_ALL ^ E_NOTICE);
	// Variaveis de Tamanho
	$mesq = "10"; // Margem Esquerda (mm)
	$msup = "10"; // Margem Superior (mm) margem mínima dois pois ficou cortando)

	$emp = $empresaDAO->selectPorId($controle_id_empresa);
	$responsavel_empresa    = $emp->empresa;
	if($controle_id_empresa=='1') $responsavel_empresa    = $emp->fantasia;

	$responsavel_email      = $emp->email;
	$responsavel_endereco   = $emp->endereco.' '.$emp->numero.' '.$emp->complemento;
	$responsavel_cidade     = $emp->cidade;
	$responsavel_estado     = $emp->estado;
	$responsavel_cep        = $emp->cep;
	$responsavel_tel        = $emp->tel;
	$responsavel_fax        = $emp->fax;

	$m=date('m');
	if($m == 1) $mes = 'Janeiro';
	elseif($m == 2 ) $mes = 'Fevereiro';
	elseif($m == 3 ) $mes = 'Março';
	elseif($m == 4 ) $mes = 'Abril';
	elseif($m == 5 ) $mes = 'Maio';
	elseif($m == 6 ) $mes = 'Junho';
	elseif($m == 7 ) $mes = 'Julho';
	elseif($m == 8 ) $mes = 'Agosto';
	elseif($m == 9 ) $mes = 'Setembro';
	elseif($m == 10) $mes = 'Outubro';
	elseif($m == 11) $mes = 'Novembro';
	elseif($m == 12) $mes = 'Dezembro';

	$data_atual = $responsavel_cidade.', '.date(d).' de '.$mes.' de 20'.date(y).'.';

	$id_impresso=30;
	$sql = $objQuery->SQLQuery("SELECT * from vsites_impresso as i where id_impresso='".$id_impresso."'");
	$res = mysql_fetch_array($sql);
	$imprimir_topo    = $res['topo'];
	$id_impresso      = $res['id_impresso'];
	$imprimir_timbre  = $res['timbre'];
	$imprimir_sub     = $res['sub'];
	$imprimir_linha   = $res['linhas'];
	$frase='';
	$impressao_ordem = '';
	$linha = 0;
	$frase.=$imprimir_topo;

	if(!$anexar) $pdf=new FPDF('P','cm', 'A4'); //papel personalizado
	
	foreach($data->sheets as $s=>$sheet){
		if($data->boundsheets[$s]['name']!='Fazer Certificado') continue;

		for ($li = 2; $li <= $data->sheets[$s]['numRows']; $li++) {
			if($li>=500) {
				echo 'O limite para importação é de 500 nomes envie um novo arquivo com o restante dos nomes';
				exit;
			}	
			$item = new stdClass();
			preg_match('/^\#([0-9]+)\/([0-9]+)/', $data->sheets[$s]['cells'][$li][1], $matches, PREG_OFFSET_CAPTURE);
			$item->nr = $data->sheets[$s]['cells'][$li][1];
			$item->id_pedido = $matches[1][0];
			$item->ordem = $matches[2][0];
				
			if($anexar) $pdf=new FPDF('P','cm', 'A4'); //papel personalizado
			
			$pdf->Open();
			$pdf->SetMargins(1, 2); //seta as margens do documento
			$pdf->SetAuthor('Vsites 2009');
			$pdf->SetFont('times','', 7);
			$pdf->SetDisplayMode(100, 'continuous'); //define o nivel de zoom do documento PDF
			$coluna = 0;
			$linha = 0;
			$posicaoH = 0;
			$posicaoV = 0;

			$bloco = '';
			$p = $pedidoDAO->selectPedidoEditPorId($item->id_pedido,$item->ordem, $controle_id_empresa);
			$linha_bloco = 1;
			$id_pedido_item = $p->id_pedido_item;
			if($id_pedido_item<>''){
				if($res['certidao_comarca_forum'])  $certidao_cidade  .= '('.$res['certidao_comarca_forum'].')';

				$impressao_ordem =  $item->nr;

				$topo = str_replace('<certidao_nome>',$p->certidao_nome, $imprimir_topo);
				$topo = str_replace('<certidao_cnpj>',$p->certidao_cnpj, $topo);
				$topo = str_replace('<certidao_cpf>',$p->certidao_cpf, $topo);
				$topo = str_replace('<orgao>',$orgao, $topo);
				$topo = str_replace('<responsavel_empresa>',$responsavel_empresa, $topo);
				$topo = str_replace('<responsavel_endereco>',$responsavel_endereco, $topo);
				$topo = str_replace('<responsavel_cidade>',$responsavel_cidade, $topo);
				$topo = str_replace('<responsavel_estado>',$responsavel_estado, $topo);
				$topo = str_replace('<cidade>',$p->certidao_cidade, $topo);
				$sub = str_replace('<responsavel_empresa>',$responsavel_empresa, $imprimir_sub);
				$sub = str_replace('<responsavel_endereco>',$responsavel_endereco, $sub);
				$sub = str_replace('<responsavel_cidade>',$responsavel_cidade, $sub);
				$sub = str_replace('<responsavel_estado>',$responsavel_estado, $sub);
				$sub = str_replace('<responsavel_cep>',$responsavel_cep, $sub);
				$sub = str_replace('<responsavel_tel>',$responsavel_tel, $sub);
				$sub = str_replace('<responsavel_fax>',$responsavel_fax, $sub);
				$sub = str_replace('<responsavel_email>',$responsavel_email, $sub);
				$custas = ($p->custas!='')?'R$ '.$p->custas:'';
				$sub = str_replace('<impressao_ordem>',$impressao_ordem." 
".$p->nome."
".$custas, $sub);
				$sub = str_replace("<data>", $data_atual, $sub );
				$sub = str_replace("<contato>", $contato, $sub );

				$sub = str_replace("<custas>", 'Custas: R$ '.$p->custas, $sub );
				

				$id_servico = $p->id_servico;
				$pdf->AddPage();

				$pdf->Image('../images/header.jpg','0','0','19','3,04','JPG');
				$pdf->SetFont('times','B',12);
				$pdf->Cell('',2,'NÃO EMITIMOS E NEM VENDEMOS CERTIDÕES E SIM PRAZOS E SOLUÇÕES','',1,'C');

				if($id_impresso==33){
					$prot1  = $data->sheets[$s]['cells'][$li][5];
					$prot2  = $data->sheets[$s]['cells'][$li][6];
					$prot3  = $data->sheets[$s]['cells'][$li][7];
					$prot4  = $data->sheets[$s]['cells'][$li][8];
					$prot5  = $data->sheets[$s]['cells'][$li][9];
					$prot6  = $data->sheets[$s]['cells'][$li][10];
					$prot7  = $data->sheets[$s]['cells'][$li][11];
					$prot8  = $data->sheets[$s]['cells'][$li][12];
					$prot9  = $data->sheets[$s]['cells'][$li][13];
					$prot10 = $data->sheets[$s]['cells'][$li][14];
					$prot11 = $data->sheets[$s]['cells'][$li][15];
					$prot12 = $data->sheets[$s]['cells'][$li][16];
					$prot13 = $data->sheets[$s]['cells'][$li][17];
					$prot14 = $data->sheets[$s]['cells'][$li][18];
					$prot15 = $data->sheets[$s]['cells'][$li][19];
					$prot16 = $data->sheets[$s]['cells'][$li][20];
					$prot17 = $data->sheets[$s]['cells'][$li][21];
					$prot18 = $data->sheets[$s]['cells'][$li][22];
					
				}elseif($id_impresso==30){
					$cart1  = $data->sheets[$s]['cells'][$li][5];
					$prot1  = $data->sheets[$s]['cells'][$li][6];
					$cart2  = $data->sheets[$s]['cells'][$li][7];
					$prot2  = $data->sheets[$s]['cells'][$li][8];
					$cart3  = $data->sheets[$s]['cells'][$li][9];
					$prot3  = $data->sheets[$s]['cells'][$li][10];
					$cart4  = $data->sheets[$s]['cells'][$li][11];
					$prot4  = $data->sheets[$s]['cells'][$li][12];
					$cart5  = $data->sheets[$s]['cells'][$li][13];
					$prot5  = $data->sheets[$s]['cells'][$li][14];
					$cart6  = $data->sheets[$s]['cells'][$li][15];
					$prot6  = $data->sheets[$s]['cells'][$li][16];
					$cart7  = $data->sheets[$s]['cells'][$li][17];
					$prot7  = $data->sheets[$s]['cells'][$li][18];
					$cart8  = $data->sheets[$s]['cells'][$li][19];
					$prot8  = $data->sheets[$s]['cells'][$li][20];
					$cart9  = $data->sheets[$s]['cells'][$li][21];
					$prot9  = $data->sheets[$s]['cells'][$li][22];
					$cart10 = $data->sheets[$s]['cells'][$li][23];
					$prot10 = $data->sheets[$s]['cells'][$li][24];
					$cart11 = $data->sheets[$s]['cells'][$li][25];
					$prot11 = $data->sheets[$s]['cells'][$li][26];
					$cart12 = $data->sheets[$s]['cells'][$li][27];
					$prot12 = $data->sheets[$s]['cells'][$li][28];
					$cart13 = $data->sheets[$s]['cells'][$li][29];
					$prot13 = $data->sheets[$s]['cells'][$li][30];
					$cart14 = $data->sheets[$s]['cells'][$li][31];
					$prot14 = $data->sheets[$s]['cells'][$li][32];
					$cart15 = $data->sheets[$s]['cells'][$li][33];
					$prot15 = $data->sheets[$s]['cells'][$li][34];
					$cart16 = $data->sheets[$s]['cells'][$li][35];
					$prot16 = $data->sheets[$s]['cells'][$li][36];
					$cart17 = $data->sheets[$s]['cells'][$li][37];
					$prot17 = $data->sheets[$s]['cells'][$li][38];
					$cart18 = $data->sheets[$s]['cells'][$li][39];
					$prot18 = $data->sheets[$s]['cells'][$li][40];
				}
				require('gera_imoveis_busca_'.$id_impresso.'.php');

				$pdf->SetFont('times','',12);
				$pdf->setY(20.5);
				$pdf->Write(0.5,$sub,'');
				$pdf->SetFont('times','B',10);
				$pdf->Line(1,25,20,25);
				$pdf->Ln();
				$rodape = $responsavel_empresa;
				$pdf->Cell('',0.5,$rodape,'',1,'C');
				$rodape = $responsavel_endereco.',

	'.$responsavel_cidade.'-'.$responsavel_estado.' CEP: '.$responsavel_cep;

				$pdf->Cell('',0.5,$rodape,'',1,'C');

				$pdf->Cell('',0.5,'Tel/Fax: '.$responsavel_tel.'/'.$responsavel_fax.' E-mail:'.$responsavel_email,'',1,'C');
				$pdf->Cell('',0.5,'www.cartoriopostal.com.br','',1,'C');

				if($anexar and ($id_servico=='11' or $id_servico=='169' or $id_servico=='170')){
					$pdf->Close(); //imprime a saida
					$sql = "select id_pedido_item from vsites_pedido_anexo as pa where
						anexo_nome='Declaração de Busca' and
						id_pedido_item='".$id_pedido_item."'";
					$res_a = $objQuery->SQLQuery($sql);
					$num_a = mysql_num_rows($res_a);
					if($num_a==''){
						$pdf->Output("../anexos/decla_busca_imoveis_".$id_pedido_item.date('msdmYH').".pdf","F");
						//imprime a saida
						$sql = "insert into vsites_pedido_anexo(anexo,anexo_nome,id_pedido_item,id_usuario)
							values('decla_busca_imoveis_".$id_pedido_item.date('msdmYH').".pdf','Declaração de Busca','".$id_pedido_item."','".$controle_id_usuario."')";
						$result = $objQuery->SQLQuery($sql);
						echo 'Declaração anexada para '.$impressao_ordem.'<br>';
						$ativ = $atividadeDAO->inserir('209','',$controle_id_usuario,$id_pedido_item);
					} else {
						echo 'Declaração não pode ser anexada para '.$impressao_ordem.' porque o anexo já existe<br>';
					}
				} else {
					if($anexar and $id_servico!='11' and $id_servico!='169' and $id_servico!='170'){
						echo '<b>Declaração não pode ser anexada para '.$impressao_ordem.' porque o serviço não é "Pesquisa de Imóveis</b>" ['.$id_servico.']<br>';
					}
				}
			} else {
				echo '<b>Declaração não pode ser anexada para '.$impressao_ordem.' porque o pedido é de outra franquia</b><br>';
			}
		}
		if(!$anexar){
			$pdf->Output(); //imprime a saida
		}
	}
}else{
	require('header.php');?>
	<div id="topo">
	<h1 class="tit"><img src="../images/tit/tit_pedido.png" alt="Título" />
	Importar Planilha com Resultados de Busca</h1>
	<hr class="tit" />
	<br />
	</div>
	<div id="meio">
	
	<form action="gera_imoveis_busca_import.php" method="post" name="pedido_add" target="_blank"	enctype="multipart/form-data">
	<table class="tabela">
		<tbody>
			<tr>
				<td class="tabela_tit" colspan="4">Gerar Ofícios</td>
			</tr>
			<tr>
				<td>Arquivo:</td>
				<td><input type="file" name="arquivo" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>Anexar:</td>
				<td><input type="checkbox" name="anexar" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>Modelo do arquivo:</td>
				<td><a href="../downloads/modelo_busca_imoveis.xls">Clique aqui para baixar o modelo do arquivo</a></td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" value="Enviar" name="submit" class="button_busca" />
					<input type="submit" name="cancelar" value="Cancelar" onclick="document.pedido_add.action='pedido.php'" class="button_busca" />
				</td>
			</tr>
		</tbody>
	</table>
	</form>
	</div>
	<?php
	require('footer.php');
}
?>