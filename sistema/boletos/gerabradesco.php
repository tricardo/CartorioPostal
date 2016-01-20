<? 
require("includes/funcoes_bradesco.php");
$contaDAO = new ContaDAO();

$id_conta=2;
#variaveis importantes
#id_conta

function tamanho_string($str,$var=' ',$lado='e',$tamanho){
	if($lado=='e'){
		$carac=strlen($str);
		while ($carac < $tamanho ){
			$str=$var.$str;
			$carac++;
		}
	} else {
		$carac=strlen($str);
		while ($carac < $tamanho ){
			$str=$str.$var;
			$carac++;
		}	
	}
	return $str;
}

pt_register('GET','submit');
if ($submit) {

	#captura as informações do ultimo envio
	$bradesco = $contaDAO->selectPorId($id_conta,$controle_id_empresa);

	#conta corrente e agencia
	$bradesco->codigo = tamanho_string(trim($bradesco->codigo),'0','e','20');
	
	#nome do favorecido
	$bradesco->favorecido = tamanho_string(trim(strtoupper($bradesco->favorecido)),' ','d','30');
	
	#versao do documento incrementada é contada por envio
	$bradesco->versao++;
	$bradesco->versao = tamanho_string($bradesco->versao,'0','e','7');
		
	#dia e mes para o nome do arquivo
	$diames 	= date("dm");
	$ano 		= date("y");

	#data atual e ultima data de envio
	$bradesco->ultima = str_replace('-', '', $bradesco->ultima);
	$data 		= date("dmy");

	#calcula o numero da remessa para definir o nome do arquivo
	if ($bradesco->ultima==$data)	$bradesco->remessa++; else $bradesco->remessa=0;
	$bradesco->remessa_ = tamanho_string($bradesco->remessa,'0','e','2');

	#escreve o header do arquivo de remessa
	$nomeArquivo = "CB".$diames.$bradesco->remessa_.".REM";
	$arquivoDiretorio = "../boletos/remessabradesco/".date('Y').'/'.$nomeArquivo;
	$file_path = "../boletos/remessabradesco/".date("Y")."/";
    $arquivoConteudo  = "01REMESSA01COBRANCA       ".$bradesco->codigo.$bradesco->favorecido."237BRADESCO       ".$data."        MX".$bradesco->versao."                                                                                                                                                                                                                                                                                     000001\r\n";

	#variavel do numero de linhas
	$linha=2;
	$i=0;

	#carteira
	$bradesco->carteira = tamanho_string($bradesco->carteira,'0','e','3');

	#separação de agencia e digito
	$pos = strpos($bradesco->agencia, '-');
	$bradesco->agencia = tamanho_string(substr($bradesco->agencia,0,$pos),'0','e','5');

	#conta e digito
	$bradesco->conta = tamanho_string(str_replace('-','',$bradesco->conta),'0','e','8');



	#captura as informações do ultimo envio
	$brad = $contaDAO->selectBoletosBrad($controle_id_empresa, $id_conta);
	$cont=0;
	foreach($brad as $b){
		$cont++;
		//nosso número (sem dv) é 11 digitos
		$nnum = formata_numero($bradesco->carteira,2,0).formata_numero($b->id_conta_fatura,11,0);
		//dv do nosso número
		$dv_nosso_numero = digitoVerificador_nossonumero($nnum);

		$b->juros_mora = number_format(((float)($b->valor)/100*(float)($b->juros_mora)/30),2,".","");

		#nosso numero
		$b->nossonumero = tamanho_string($b->id_conta_fatura,'0','e','11').$dv_nosso_numero;

		#numero do documento
		$b->controle_empresa = tamanho_string($controle_id_empresa.'-'.$b->id_conta_fatura,' ','d','25');

		#valor de desconto por dia (opcional)
		$b->valor_desc_dia = tamanho_string(str_replace('.','',$b->valor_desc_dia),'0','e','10');

		#valor cobrado
		$b->valor = tamanho_string(str_replace('.','',$b->valor),'0','e','13');

		#valor de mora por dia (opcional)
		$b->juros_mora = tamanho_string(str_replace('.','',$b->juros_mora),'0','e','13');
		
		#valor de desconto até a data (opcional)
		$b->valor_desc = tamanho_string(str_replace('.','',$b->valor_desc),'0','e','13');

		#valor de abatimento concedido ou cancelado
		$b->abatimento = tamanho_string(str_replace('.','',$b->abatimento),'0','e','13');

		#numero do documento que é igual a fatura
		$b->documento = tamanho_string($b->id_conta_fatura,' ','d','10');

		$b->ocorrencia = tamanho_string($b->ocorrencia,'0','e','2');
		$b->tipo = tamanho_string($b->tipo,'0','e','2');

		#banco e agencia depositária
		#if($b->ocorrencia=='01') {
		$b->banco_enc = '000';
		$b->agencia_enc = '00000';
		#}
		
		$b->instrucao1 = tamanho_string($b->instrucao1,'0','e','2');
		$b->instrucao2 = tamanho_string($b->instrucao2,'0','e','2');

		#dados do sacado
		$b->cpf = tamanho_string(str_replace('-','',str_replace('/','',str_replace('.','',$b->cpf))),'0','e','14');
		$b->sacado = tamanho_string($b->sacado,' ','d','40');
		$b->endereco = tamanho_string($b->endereco,' ','d','40');
		$b->mensagem1 = tamanho_string($b->mensagem1,' ','d','12');
		$b->cep = tamanho_string(str_replace('-','',$b->cep),'0','e','8');
		$b->mensagem2 = tamanho_string($b->mensagem2,' ','d','60');
		$sequencia = tamanho_string($linha,'0','e','6');
		
		$arquivoConteudo .= "1                   0".$bradesco->carteira.$bradesco->agencia.$bradesco->conta.$b->controle_empresa."00000000".$b->nossonumero.$b->valor_desc_dia.$b->emissao_papeleta."               ".$b->ocorrencia.$b->documento.$b->vencimento.$b->valor.$b->banco_enc.$b->agencia_enc.$b->especie.$b->aceite.$b->emissao.$b->instrucao1.$b->instrucao2.$b->juros_mora.$b->data_desc.$b->valor_desc."0000000000000".$b->abatimento.$b->tipo.$b->cpf.$b->sacado.$b->endereco.$b->mensagem1.$b->cep.$b->mensagem2.$sequencia."\r\n";
		$brad_update = $contaDAO->atualizaBoletosBrad($controle_id_empresa,$b->id_conta_fatura);
		
		$linha++;
	}

	
#lista ocorrencias
	$brad = $contaDAO->selectBoletosBradOco($controle_id_empresa, $id_conta);
	foreach($brad as $b){
		$cont++;
		if($b->ocorrencia==31){
			$b->valor 		= $b->valor_o;
			$b->juros_mora 	= $b->juros_mora_o;
			$b->instrucao1 	= $b->instrucao1_o;
			$b->instrucao2 	= $b->instrucao2_o;
			$b->cpf 		= $b->cpf_o;
			$b->sacado 		= $b->sacado_o;
			$b->endereco 	= $b->endereco_o;
			$b->mensagem1 	= $b->mensagem1_o;
			$b->cep 		= $b->cep_o;
			$b->mensagem2 	= $b->mensagem2_o;
			$b->tipo 		= $b->tipo_o;
		}
		//nosso número (sem dv) é 11 digitos
		$nnum = formata_numero($bradesco->carteira,2,0).formata_numero($b->id_conta_fatura,11,0);
		//dv do nosso número
		$dv_nosso_numero = digitoVerificador_nossonumero($nnum);
		
		#nosso numero
		$b->nossonumero = tamanho_string($b->id_conta_fatura,'0','e','11').$dv_nosso_numero;

		#numero do documento
		$b->controle_empresa = tamanho_string($controle_id_empresa.'-'.$b->id_conta_fatura,' ','d','25');

		#valor de desconto por dia (opcional)
		$b->valor_desc_dia = tamanho_string(str_replace('.','',$b->valor_desc_dia),'0','e','10');

		#valor cobrado
		$b->valor = tamanho_string(str_replace('.','',$b->valor),'0','e','13');

		#valor de mora por dia (opcional)
		$b->juros_mora = tamanho_string(str_replace('.','',$b->juros_mora),'0','e','13');

		#valor de desconto até a data (opcional)
		$b->valor_desc = tamanho_string(str_replace('.','',$b->valor_desc),'0','e','13');

		#valor de abatimento concedido ou cancelado
		$b->abatimento = tamanho_string(str_replace('.','',$b->abatimento),'0','e','13');

		#numero do documento que é igual a fatura
		$b->documento = tamanho_string($b->id_conta_fatura,' ','d','10');

		$b->ocorrencia = tamanho_string($b->ocorrencia,'0','e','2');
		$b->tipo = tamanho_string($b->tipo,'0','e','2');

		#banco e agencia depositária
		#if($b->ocorrencia=='01') {
		$b->banco_enc = '000';
		$b->agencia_enc = '00000';
		#}
		
		$b->instrucao1 = tamanho_string($b->instrucao1,'0','e','2');
		$b->instrucao2 = tamanho_string($b->instrucao2,'0','e','2');

		#dados do sacado
		$b->cpf = tamanho_string(str_replace('-','',str_replace('/','',str_replace('.','',$b->cpf))),'0','e','14');
		$b->sacado = tamanho_string($b->sacado,' ','d','40');
		$b->endereco = tamanho_string($b->endereco,' ','d','40');
		$b->mensagem1 = tamanho_string($b->mensagem1,' ','d','12');
		$b->cep = tamanho_string(str_replace('-','',$b->cep),'0','e','8');
		$b->mensagem2 = tamanho_string($b->mensagem2,' ','d','60');
		$sequencia = tamanho_string($linha,'0','e','6');
		
		$arquivoConteudo .= "1                   0".$bradesco->carteira.$bradesco->agencia.$bradesco->conta.$b->controle_empresa."00000000".$b->nossonumero.$b->valor_desc_dia.$b->emissao_papeleta."               ".$b->ocorrencia.$b->documento.$b->vencimento.$b->valor.$b->banco_enc.$b->agencia_enc.$b->especie.$b->aceite.$b->emissao.$b->instrucao1.$b->instrucao2.$b->juros_mora.$b->data_desc.$b->valor_desc."0000000000000".$b->abatimento.$b->tipo.$b->cpf.$b->sacado.$b->endereco.$b->mensagem1.$b->cep.$b->mensagem2.$sequencia."\r\n";
		$brad_update = $contaDAO->atualizaBoletosBradOco($controle_id_empresa,$b->id_conta_fatura_oco);
		
		$linha++;
	}

#escreve a ultima linha 
	$sequencia = tamanho_string($linha,'0','e','6');
	$arquivoConteudo .= "9                                                                                                                                                                                                                                                                                                                                                                                                         ".$sequencia;

	if($cont==0){
			echo"<BR><font style='color: blue;'>&nbsp;&nbsp;Todos os Boletos já foram registrados</font><br />";
	} else {
		if (!is_dir($file_path)) {
			mkdir($file_path, 0777);
		}#alterado
	
		if(!is_file($arquivoDiretorio)) {
			if(fopen($arquivoDiretorio,"w+")) {
				if (!$handle = fopen($arquivoDiretorio, 'w+')) {
				   echo "<BR><font style='color: blue;'>&nbsp;&nbsp;FALHA AO CRIAR O ARQUIVO: <b>".$nomeArquivo."</b>.</font><br />";
				   exit;
				}
				if(!fwrite($handle, $arquivoConteudo)) {
				   echo"<BR><font style='color: blue;'>&nbsp;&nbsp;FALHA AO ESCREVER NO ARQUIVO: <b>".$nomeArquivo."</b>.</font><br />";
				   exit;
				}
				echo '<br><br>Arquivo criado com sucesso!<br>Transmita o arquivo pelo site do banco!<br><br>';
			} else {
				echo"<BR><font style='color: blue;'>&nbsp;&nbsp;ERRO AO CRIAR O ARQUIVO: <b>".$nomeArquivo."</b>.</font><br />";
				exit;
			}
		} else {
			echo"<BR><font style='color: blue;'>&nbsp;&nbsp;O ARQUIVO <b>".$nomeArquivo."</b> JÁ EXISTE.</font><br />";
			exit;
		}

		#Colocar aqui o script para download do arquivo
		$bradesco = $contaDAO->atualizarBradesco($id_conta,$controle_id_empresa,$bradesco->versao,$bradesco->remessa,$arquivoDiretorio);
	}

}
?>