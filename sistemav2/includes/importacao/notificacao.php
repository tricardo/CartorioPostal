<?
$erro =='';
$linha_cont=1;
$CONT_NOT=0;
if($handle){
	while( ! feof($handle)){
		$buffer = fgets($handle, 4096);
		$buffer = str_replace ("'",'´',$buffer);
		$qtdd_registros = strlen($buffer);
		$qtdd_linha = strlen($linha_cont);
		$linha_formatada='';
		while ($qtdd_linha<6){
			$linha_formatada .= '0';
			$qtdd_linha++;
		}
		$linha_formatada .= $linha_cont;

		#verifica cabeçalho
		if($linha_cont=='1' and substr($buffer, 0, 1)!='0') $erro.='Início do cabeçalho com erro '.$linha_cont.'<br>';

		#dados do cabeçalho
		if($linha_cont=='1' and substr($buffer, 0, 1)=='0'){
			$H_IDENTIFICACAO = str_replace('  ','',substr($buffer, 1, 7));
			$H_DESCRICAO = str_replace('  ','',substr($buffer, 8, 30));
			$H_BANCO = str_replace('  ','',substr($buffer, 52, 40));
			$H_BANCO_END = str_replace('  ','',substr($buffer, 92, 40));
			$H_BANCO_NUMERO = str_replace('  ','',substr($buffer, 132, 10));
			$H_BANCO_COMP = str_replace('  ','',substr($buffer, 142, 10));
			$H_BANCO_BAIRRO = str_replace('  ','',substr($buffer, 152, 30));
			$H_BANCO_CIDADE = str_replace('  ','',substr($buffer, 182, 30));
			$H_BANCO_CEP = str_replace('  ','',substr($buffer, 212, 8));
			$H_BANCO_ESTADO = str_replace('  ','',substr($buffer, 220, 2));
			$H_TEL = str_replace('  ','',substr($buffer, 222, 10));
			$H_RESP = str_replace('  ','',substr($buffer, 232, 40));
			$H_CARGO = str_replace('  ','',substr($buffer, 272, 40));
			$H_DATA = str_replace('  ','',substr($buffer, 312, 8));
		}

		if(substr($buffer, 0, 1)=='1'){
			$R_COD_AGENCIA = str_replace('  ','',substr($buffer, 1, 3));
			$R_NUMERO_DA_CONTA = str_replace('  ','',substr($buffer, 4, 9));
			$R_IDENTIFICACAO = str_replace('  ','',substr($buffer, 13, 15));
			$R_CLIENTE_NOME = str_replace('  ','',substr($buffer, 28, 40));
			$R_NOT_CPF = str_replace('  ','',substr($buffer, 68, 15));
			$R_NOT_NOME = str_replace('  ','',substr($buffer, 83, 40));
			$R_NOT_ENDERECO = str_replace('  ','',substr($buffer, 123, 40));
			$R_NOT_PRACA = str_replace('  ','',substr($buffer, 163, 40));
			$R_NOT_CEP = str_replace('  ','',substr($buffer, 203, 8));
			$R_NOT_UF = str_replace('  ','',substr($buffer, 211, 2));
			$R_NOT_NUMERO = str_replace('  ','',substr($buffer, 213, 5));
			$R_SEQUENCIA_DO_DOC = str_replace('  ','',substr($buffer, 218, 5));
			#DADOS DA COBRANÇA
			$R_NOSSO_NUMERO = str_replace('  ','',substr($buffer, 223, 8));
			$R_DUPLICATA = str_replace('  ','',substr($buffer, 231, 12));
			$R_EMISSAO_TITULO = str_replace('  ','',substr($buffer, 243, 8));
			$R_AGENCIA_COBRADORA = str_replace('  ','',substr($buffer,251 , 3));
			$R_BANCO_COBRADOR = str_replace('  ','',substr($buffer,254 , 20));
			$R_VENCIMENTO_TITULO = str_replace('  ','',substr($buffer, 274, 8));
			$R_VALOR_TITULO = str_replace('  ','',substr($buffer, 282, 17));
			$R_CARTEIRA_TITULO = str_replace('  ','',substr($buffer, 299, 2));
			#DADOS DE DIREITO CREDITORIO
			$R_NUMERO_CONTRATO = str_replace('  ','',substr($buffer, 361, 20));
			$R_EMISSAO_DIREITO_CRED = str_replace('  ','',substr($buffer, 381, 8));
			$R_NUMERO_DIREITO_CRED = str_replace('  ','',substr($buffer, 389, 10));
			$R_NUMERO_CONTRATO_DIREITO_CRED = str_replace('  ','',substr($buffer, 399, 12));
			$R_EMISSAO_CONTRATO_BIC = str_replace('  ','',substr($buffer, 411, 8));
			$R_MODALIDADE = str_replace('  ','',substr($buffer, 419, 6));
			$R_OBJETO_CONTRATO_DIR_CRED = str_replace('  ','',substr($buffer, 425, 240));
			$R_CPF_CONTRATADO = str_replace('  ','',substr($buffer, 665, 15));
			if($OLD_NOT_NOME!=$R_NOT_NOME) $CONT_NOT++;
			$OLD_NOT_NOME = $R_NOT_NOME;
			#valida documento
			$valida_cpf = validaCPF(str_replace('  ','',substr($R_NOT_CPF, 4, 11)));
			$valida_cnpj = validaCNPJ(str_replace('  ','',substr($R_NOT_CPF, 1, 14)));
			if($valida_cpf=='false' and $valida_cnpj=='false'){
				$erro.="CPF/CNPJ Inválido na linha".$linha_cont."<br>";
			}
			if($valida_cnpj=='true'){
				$R_NOT_CNPJ = $R_NOT_CPF;
				$R_NOT_CPF = "";
			}
			if($erro==''){
				$sql_dupl = $objQuery->SQLQuery("SELECT pi.id_pedido, pi.ordem, pi.certidao_cpf, pi.certidao_cnpj, pi.certidao_cidade, pi.certidao_nome, pi.certidao_estado, s.status from vsites_pedido_item as pi, vsites_status as s, vsites_pedido as p
				where p.cpf='".$cpf."' and pi.id_pedido=p.id_pedido and pi.id_status!='14' and pi.id_status!='10' and pi.id_servico='".$id_servico."' and pi.certidao_numero_not='".$R_NOT_NUMERO."' and (replace(replace(replace(pi.certidao_cpf,'-',''),'.',''),'/','')='".$R_NOT_CPF."' and pi.certidao_cpf!='' or replace(replace(replace(pi.certidao_cnpj,'-',''),'.',''),'/','')='".$R_NOT_CNPJ."' and pi.certidao_cnpj!='') and pi.id_status = s.id_status");
				$duplicidade = mysql_num_rows($sql_dupl);
				if($duplicidade<>0){
					$res_dup = mysql_fetch_array($sql_dupl);
					$erro.="Duplicidade na linha ".$linha_cont.": Confira a ordem #".$res_dup['id_pedido']."/".$res_dup['ordem']." em caso de dúvidas entre em contato com o administrador do sistema<br>";
				}

			}
			$ordem = $linha_cont-1;
			$ARRAY[$linha_cont-2] = "insert into vsites_pedido_item
			(data_atividade,id_atividade,id_status,urgente,ordem,id_pedido, data,id_usuario,id_empresa_atend,id_servico,valor,dias,obs, id_servico_var,id_servico_departamento,
			certidao_cod_agencia,
			certidao_conta,
			certidao_modelo,
			certidao_requerente,
			certidao_cpf,
			certidao_cnpj,
			certidao_nome,
			certidao_endereco,
			certidao_cidade,
			certidao_campo_cep,
			certidao_estado,
			certidao_numero_not,
			certidao_sequencia,
			certidao_nosso_numero,
			certidao_duplicata,
			certidao_emissao,
			certidao_agencia,
			certidao_banco,
			certidao_vencimento,
			certidao_valor,
			certidao_cart_titulo,
			certidao_n_contrato,
			certidao_emissao_dir_cred,
			certidao_num_dir_cred,
			certidao_num_contrato_dir_cred,
			certidao_emissao_contrato,
			certidao_modalidade,
			certidao_objeto_contrato_cred,
			certidao_cpf_contratado) values
			(NOW(),'172','1','".$urgente."','".$ordem."','ID_PEDIDO',NOW(),'".$controle_id_usuario."','".$controle_id_empresa."','".$id_servico."','".$valor."','".$dias."','".$obs."','".$id_servico_var."','".$id_servico_departamento."',
			'".$R_COD_AGENCIA."',
			'".$R_NUMERO_DA_CONTA."',
			'".$R_IDENTIFICACAO."',
			'".$R_CLIENTE_NOME."',
			'".$R_NOT_CPF."',
			'".$R_NOT_CNPJ."',
			'".$R_NOT_NOME."',
			'".$R_NOT_ENDERECO."',
			'".$R_NOT_PRACA."',
			'".$R_NOT_CEP."',
			'".$R_NOT_UF."',
			'".$R_NOT_NUMERO."',
			'".$R_SEQUENCIA_DO_DOC."',
			'".$R_NOSSO_NUMERO."',
			'".$R_DUPLICATA."',
			'".$R_EMISSAO_TITULO."',
			'".$R_AGENCIA_COBRADORA."',
			'".$R_BANCO_COBRADOR."',
			'".$R_VENCIMENTO_TITULO."',
			'".$R_VALOR_TITULO."',
			'".$R_CARTEIRA_TITULO."',
			'".$R_NUMERO_CONTRATO."',
			'".$R_EMISSAO_DIREITO_CRED."',
			'".$R_NUMERO_DIREITO_CRED."',
			'".$R_NUMERO_CONTRATO_DIREITO_CRED."',
			'".$R_EMISSAO_CONTRATO_BIC."',
			'".$R_MODALIDADE."',
			'".$R_OBJETO_CONTRATO_DIR_CRED."',
			'".$R_CPF_CONTRATADO."')";
		}

		#TRAILLER
		if(substr($buffer, 0, 1)=='9'){
			$qtdd_linha = strlen($CONT_NOT);
			$CONT_NOT2='';
			while ($qtdd_linha<6){
				$CONT_NOT2 .= '0';
				$qtdd_linha++;
			}
				
			$CONT_NOT2 .= $CONT_NOT;
			$T_QUANT_NOT = substr($buffer, 1, 6);
			#if($CONT_NOT2!=$T_QUANT_NOT) $erro.='Quantidades de notificações não confere com o número indicado na linha TRAILER '.$linha_cont.'<br>';
			if($CONT_NOT2>'3000') $erro.='O número máximo de importação de registros não pode ultrapassar 3000 registros e o arquivo atual possui '.$CONT_NOT2.'<br>';
				
			$rodape=$T_QUANT_NOT;
		}

		#verifica tamanho da linha
		if ($qtdd_registros<>702) $erro.='Quantidades de campos inválido na linha '.$linha_cont.'<br>';

		#verifica sequencia
		if (substr($buffer, 694, 6)!=$linha_formatada) $erro .= 'Sequência inválida na linha '.$linha_cont.'<br>';

		#verifica se é o final do arquivo
		if (substr($buffer, 0, 1)=='9') break;

		#conta linha
		$linha_cont++;
	}
}
#cabeçalho do arquivo
$cabecalho = '<B>IDENTIFICAÇÃO:</B> '.$H_IDENTIFICACAO.' <BR><B>DESCRIÇÃO:</B> '.$H_DESCRICAO.' <BR><B>NOME DO BANCO:</B> '.$H_BANCO.' <BR><B>ENDEREÇO DO BANCO:</B> '.$H_BANCO_END.' '.$H_BANCO_NUMERO.' '.$H_BANCO_COMP.' '.$H_BANCO_BAIRRO.' '.$H_BANCO_CIDADE.'-'.$H_BANCO_ESTADO.'<BR> <B>CEP DO BANCO:</B> '.$H_BANCO_CEP.'<BR>
<B>TEL: </B>'.$H_TEL.' <BR><B>RESPONSÁVEL: </B>'.$H_RESP.' <B>CARGO:</B> '.$H_CARGO.'<BR> <B>DATA:</B> '.$H_DATA;
?>