<?
$erro =='';
$linha_cont=1;
$CONT_NOT=0;
if($handle){
	while( ! feof($handle)){
		
		$buffer = fgets($handle, 4096);
		$buffer = str_replace ("'",'´',$buffer);
		$buffer = explode(';',$buffer);
		$qtdd_registros = COUNT($buffer);

		#verifica tamanho da linha
		if ($qtdd_registros<>21 and $qtdd_registros!=0 and $qtdd_registros!=1) $erro.='Quantidades de campos inválido na linha '.$linha_cont.'-'.$qtdd_registros.'<br>';
		if($linha_cont==1) {
			$linha_cont++;
			CONTINUE;
		}
		if($qtdd_registros==1) CONTINUE;
		$R_DATA = trim(str_replace('  ','',$buffer[0]));
		$R_TIPO = trim(str_replace('  ','',$buffer[1]));
		$R_OBRA = trim(str_replace('  ','',$buffer[2]));
		$R_UNIDADE = trim(str_replace('  ','',$buffer[3]));
		$R_DATA_CONTRATO = trim(str_replace('  ','',$buffer[4]));
		$R_NOTIFICANTE = trim(str_replace('  ','',$buffer[5]));
		$R_NOTIFICADO = trim(str_replace('  ','',$buffer[6]));
		$R_ENDERECO = trim(str_replace('  ','',$buffer[7]));
		$R_BAIRRO = trim(str_replace('  ','',$buffer[8]));
		$R_CIDADE = trim(str_replace('  ','',$buffer[9]));
		$R_ESTADO = trim(str_replace('  ','',$buffer[10]));
		$R_CEP = trim(str_replace('  ','',$buffer[11]));
		$R_TELEFONE = trim(str_replace('  ','',$buffer[12]));
		$R_EMPREENDIMENTO = trim(str_replace('  ','',$buffer[13]));
		$R_MENSALIDADE = trim(str_replace('  ','',$buffer[14]));
		$R_VENCIMENTO = trim(str_replace('  ','',$buffer[15]));
		$R_MULTA = trim(str_replace('  ','',$buffer[16]));
		$R_JUROS = trim(str_replace('  ','',$buffer[17]));
		$R_ENCARGOS = trim(str_replace('  ','',$buffer[18]));
		$R_VALOR = trim(str_replace('  ','',$buffer[19]));
		$R_CORRECAO = trim(str_replace('  ','',$buffer[20]));
                if($R_TIPO!='Valores' and $R_TIPO!='DISTRATO - 12.1 e 12.5.1' and $R_TIPO!='DISTRATO - 10.1' and $R_TIPO!='DISTRATO - 10.1 e 10.5.1' and $R_TIPO!='DISTRATO - 12.1'){
                    $erro = 'Tipo de notificação desconhecido:'.$R_TIPO;
                }
		
		if($erro=='' and $qtdd_registros!=0){

			$ordem = $linha_cont-1;
			$ARRAY[$linha_cont-1] = "insert into vsites_pedido_item
			(data_atividade,id_atividade,id_status,urgente,ordem,id_pedido, data,id_usuario,id_empresa_atend,id_servico,valor,dias,obs, id_servico_var,id_servico_departamento,
			certidao_modelo,
			certidao_numero_not,
			certidao_emissao_contrato,
			certidao_requerente,
			certidao_nome,
			certidao_endereco,
			certidao_campo_bairro,
			certidao_cidade,
			certidao_estado,
			certidao_campo_cep,
			certidao_nosso_numero,
			certidao_modalidade,
			certidao_duplicata,
			certidao_vencimento,
			n_parcelas,
			conce_nome,
			certidao_emissao,
			certidao_valor,
			certidao_n_contribuinte,
			certidao_n_deposito) values
			(NOW(),'172','1','".$urgente."','".$ordem."','ID_PEDIDO',NOW(),'".$controle_id_usuario."','".$controle_id_empresa."','".$id_servico."','".$valor."','".$dias."','".$obs."','".$id_servico_var."','".$id_servico_departamento."',
			'".$R_TIPO."',
			'".$R_OBRA."/".$R_UNIDADE."',
			'".$R_DATA_CONTRATO."',
			'".$R_NOTIFICANTE."',
			'".$R_NOTIFICADO."',
			'".$R_ENDERECO."',
			'".$R_BAIRRO."',
			'".$R_CIDADE."',
			'".$R_ESTADO."',
			'".$R_CEP."',
			'".$R_TELEFONE."',
			'".$R_EMPREENDIMENTO."',
			'".$R_MENSALIDADE."',
			'".$R_VENCIMENTO."',
			'".$R_ENCARGOS."',
			'".$R_CORRECAO."',
			'".$R_DATA."',
			'".$R_VALOR."',
			'".$R_JUROS."',
			'".$R_MULTA."')";
			#conta linha
			$linha_cont++;
		}

	}
}


?>