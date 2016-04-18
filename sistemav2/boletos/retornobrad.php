<?php
$contaDAO = new ContaDAO();

$file_import = isset($_FILES["file_import"]) ? $_FILES["file_import"] : FALSE;
// Formulário postado... executa as ações
$error_image = valida_upload_txt($file_import);
if ($error_image){
	$error .= $error_image;
	$errors['import']=1;
}
$file_path = "../boletos/retornobradesco/";
// Pega extensão do file_import
preg_match("/\.(txt|rem){1}$/i", $file_import["name"], $ext);
// Gera um nome único para a imagem
$imagem_nome = $controle_id_usuario.'_'.md5(uniqid(time())) . "." . $ext[1];
// Caminho de onde a imagem ficará
$imagem_dir = $file_path.$imagem_nome;
// Faz o upload da imagem
move_uploaded_file($file_import["tmp_name"], $imagem_dir);
$file_import_name = $imagem_nome;

$fp = $file_path.$imagem_nome;
#abre o arquivo
$handle = @fopen($fp, "r");

$erro =='';
$linha_cont=1;
$CONT_NOT=0;
if($handle){
	while( ! feof($handle)){
		$buffer = fgets($handle, 4096);
		$qtdd_registros = strlen($buffer);
		if($qtdd_registros!=402) $erro.='Quantidades de caracteres inválidos na linha '.$linha_cont.'<br>';

		#dados do cabeçalho
		if($linha_cont=='1'){
			#verifica cabeçalho
			if($linha_cont=='1' and (substr($buffer, 0, 1)!='0' or substr($buffer, 1, 1)!='2' or substr($buffer, 2, 7)!='RETORNO' or substr($buffer, 11, 15)!='COBRANCA       ')) $erro.='Início do cabeçalho com erro '.$linha_cont.'<br>';

			$h->codigo = (INT)(substr($buffer, 26, 20));
			$h->banco = (INT)(substr($buffer, 76, 3));
			$h->retorno = (INT)(substr($buffer, 108, 5));
			$h->aviso = substr($buffer, 108, 5);
			$h->datacredito = substr($buffer, 379, 6);
			if($h->banco!=237) $erro .= 'Banco inválido<br>';
			$verifica = $contaDAO->verificaRetornoBrad($controle_id_empresa, $h->banco,$h->retorno);
			if($verifica->total<>0) {
				$erro .= 'O arquivo já foi importado anteriormente<br>';
			}
		}
		if(substr($buffer, 0, 1)=='1' and $erro==''){
			$r->tipo = (int)(substr($buffer, 1, 2));
			$r->inscricao_emp = substr($buffer, 3, 14);
			$r->cedente = (int)(substr($buffer, 20, 17));
			$r->controle = substr($buffer, 37, 25);
			$r->nosso_numero = substr($buffer, 70, 12);
			$r->carteira = substr($buffer, 107, 1);
			$r->id_conta_fatura = (int)(substr($buffer, 70, 12));
			$r->ocorrencia = (int)(substr($buffer, 108, 2));
			$r->data_ocorrencia = '20'.substr($buffer, 114, 2).'-'.substr($buffer, 112, 2).'-'.substr($buffer, 110, 2);
			$r->id_conta_fatura = substr($buffer, 116, 10);
			$r->titulo_banco = substr($buffer, 126, 20); #mesmo item da coluna 71 a 82
			$r->vencimento = '20'.substr($buffer, 150, 2).'-'.substr($buffer, 148, 2).'-'.substr($buffer, 146, 2);
			$r->valor = (int)(substr($buffer, 152, 11)).'.'.substr($buffer, 163, 2);
			$r->banco_cobrador = substr($buffer, 165, 3);
			$r->agencia_cobradora = substr($buffer, 168, 5);
			$r->especie = substr($buffer, 173, 2);
			$r->despesa_cobranca = (int)(substr($buffer, 175, 11)).'.'.substr($buffer, 186, 2);
			$r->outras_despesas = (int)(substr($buffer, 188, 11)).'.'.substr($buffer, 199, 2);
			$r->juros_atraso = (int)(substr($buffer, 201, 11)).'.'.substr($buffer, 212, 2);
			$r->iof = (int)(substr($buffer, 214, 11)).'.'.substr($buffer, 215, 2);
			$r->valor_pago = (int)(substr($buffer, 253, 11)).'.'.substr($buffer, 264, 2);
			$r->juros_mora = (int)(substr($buffer, 266, 11)).'.'.substr($buffer, 277, 2);
			$r->motivo_protesto = substr($buffer, 294, 1); #A- Aceito D- Desprezado
			$r->motivo_ocorrencia1 = substr($buffer, 318, 2);
			$r->motivo_ocorrencia2 = substr($buffer, 320, 2);
			$r->motivo_ocorrencia3 = substr($buffer, 322, 2);
			$r->motivo_ocorrencia4 = substr($buffer, 324, 2);
			$r->motivo_ocorrencia5 = substr($buffer, 326, 2);
			$r->sequencia = (int)(substr($buffer, 394, 6));

			$contaDAO->inserirOcorrenciaBrad($r,$controle_id_empresa,$controle_id_usuario);

		}

		#verifica se é o final do arquivo
		if (substr($buffer, 0, 1)=='9') break;

		#conta linha
		$linha_cont++;
	}
	if($erro==''){
		#Colocar aqui o script para download do arquivo
		$bradesco = $contaDAO->inserirBradescoRet($controle_id_empresa,$fp,$h->banco,$h->retorno);
		$erro_exibe = 'Arquivo importado com sucesso!!<br><br>';
	} else {
		$erro_exibe = $erro;
	}
}
?>