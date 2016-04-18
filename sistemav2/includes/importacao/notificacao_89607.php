<?
$erro =='';
$linha_cont=1;
$CONT_NOT=0;
if($handle){
	while( ! feof($handle)){
		$buffer = fgets($handle, 4096);
		$buffer = str_replace ("'",'´',$buffer);
		$qtdd_registros = strlen($buffer);

		#verifica tamanho da linha
		if ($qtdd_registros<>362 and $qtdd_registros!=0) $erro.='Quantidades de campos inválido na linha '.$linha_cont.'<br>';

		$R_NOSSO_NUMERO = trim(str_replace('  ','',substr($buffer, 0, 5)));
		$R_NOT_NUMERO = trim(str_replace('  ','',substr($buffer, 5, 4)));
		$R_NOT_NOME = trim(str_replace('  ','',substr($buffer, 9, 36)));
		$R_NOT_ENDERECO = trim(substr($buffer, 45, 11)).' '.trim(substr($buffer, 56, 36)).', '.trim(substr($buffer, 92, 28));
		$R_NOT_BAIRRO = str_replace('  ','',substr($buffer, 120, 61));
		$R_NOT_CEP = trim(substr($buffer, 181, 9));
		$R_NOT_PRACA = str_replace('  ','',substr($buffer, 190, 26));
		$R_NOT_UF = trim(substr($buffer, 216, 3));
		$R_VENCIMENTO_TITULO = str_replace('  ','',substr($buffer, 219, 140));
		$R_VENCIMENTO_TITULO = substr($R_VENCIMENTO_TITULO, 6, 2).substr($R_VENCIMENTO_TITULO, 4, 2).substr($R_VENCIMENTO_TITULO, 0, 4);
		
		#$R_NOT_ENDERECO .= ' - '.$R_NOT_BAIRRO;
		if($OLD_NOT_NOME!=$R_NOT_NOME) $CONT_NOT++;
		$OLD_NOT_NOME = $R_NOT_NOME;

		if($erro=='' and $qtdd_registros!=0){
			#	$sql_dupl = $objQuery->SQLQuery("SELECT pi.id_pedido, pi.ordem, pi.certidao_cpf, pi.certidao_cnpj, pi.certidao_cidade, pi.certidao_nome, pi.certidao_estado, s.status from vsites_pedido_item as pi, vsites_status as s, vsites_pedido as p
			#	where p.cpf='".$cpf."' and pi.id_pedido=p.id_pedido and pi.id_status!='14' and pi.id_status!='10' and pi.id_servico='".$id_servico."' and pi.certidao_numero_not='".$R_NOT_NUMERO."' and (replace(replace(replace(pi.certidao_cpf,'-',''),'.',''),'/','')='".$R_NOT_CPF."' and pi.certidao_cpf!='' or replace(replace(replace(pi.certidao_cnpj,'-',''),'.',''),'/','')='".$R_NOT_CNPJ."' and pi.certidao_cnpj!='') and pi.id_status = s.id_status");
			#	$duplicidade = mysql_num_rows($sql_dupl);
			#	if($duplicidade<>0){
			#		$res_dup = mysql_fetch_array($sql_dupl);
			#		$erro.="Duplicidade na linha ".$linha_cont.": Confira a ordem #".$res_dup['id_pedido']."/".$res_dup['ordem']." em caso de dúvidas entre em contato com o administrador do sistema<br>";
			#	}
			#}

			$ordem = $linha_cont;
			$ARRAY[$linha_cont-1] = "insert into vsites_pedido_item
			(data_atividade,id_atividade,id_status,urgente,ordem,id_pedido, data,id_usuario,id_empresa_atend,id_servico,valor,dias,obs, id_servico_var,id_servico_departamento,
			certidao_cod_agencia,
			certidao_conta,
			certidao_modelo,
			certidao_requerente,
			certidao_cpf,
			certidao_cnpj,
			certidao_nome,
			certidao_endereco,
			certidao_campo_bairro,
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
			'".$R_NOT_BAIRRO."',
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
				
			#conta linha
			$linha_cont++;
		}

	}
}
?>