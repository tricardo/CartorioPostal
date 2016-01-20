<?

$erro =='';
$linha_cont=1;
$linha_excel=0;
$CONT_NOT=0;
$linha_arq=1;

if($handle){

	pt_register('POST','arquivo');
	pt_register('POST','data');
	pt_register('POST','id_servico');

	$sql_arquivo = "insert into vsites_arquivo (id_conveniado, arquivo, data, status, id_usuario,id_servico) values ('".$id_cliente."','".$file_import_name."',NOW(),'Pendente','".$controle_id_usuario."','".$id_servico."')";
	$result_arquivo = $objQuery->SQLQuery($sql_arquivo);
	$id_arquivo = $objQuery->ID;

    while( ! feof($handle)){
		#trata a linha do buffer
		$erro = '';
		$buffer = fgets($handle, 4096);
		$buffer = limpa_string($buffer);
		$buffer = strtoupper ($buffer); 
		$buffer = str_replace ("'",'',$buffer);
		$buffer = str_replace ('"','',$buffer);		
		$qtdd_registros = strlen($buffer);
		if($linha_cont>1000){
			$erro.="O limite máximo para importação do arquivo é de 1000 linhas<br>";
			break;
		}

		#gera o primeiro array
		$ext_verifica = explode(';',$buffer);
		$tamanho = count($ext_verifica);
				
		#verifica tamanho do array
		if($tamanho<>9 and $qtdd_registros<>''){
			$erro.="Quantidade de campos inválido <br>";
		}
		
		if($ext_verifica['0']=='' and $qtdd_registros<>''){	
			$erro.="Nome em branco <br>";
		}

		if($ext_verifica['2']=='' and $qtdd_registros<>''){	
			$erro.="Data de Obito em branco<br>";
		}

		if($ext_verifica['6']=='' and $qtdd_registros<>''){	
			$erro.="Cartório em branco<br>";
		}

		if($ext_verifica['7']=='' and $qtdd_registros<>''){	
			$erro.="Cidade em branco<br>";
		}

		if($ext_verifica['8']=='' and $qtdd_registros<>''){	
			$erro.="Estado em branco<br>";
		}
		
		$R_NOME		  = $ext_verifica[0];
		$R_MAE		  = $ext_verifica[1];
		$R_DATA_OBITO = $ext_verifica[2];
		$R_LIVRO      = $ext_verifica[3];
		$R_FOLHA 	  = $ext_verifica[4];
		$R_TERMO	  = $ext_verifica[5];
		$R_CARTORIO   = $ext_verifica[6];
		$R_CIDADE     = $ext_verifica[7];
		$R_ESTADO     = $ext_verifica[8];
		
		#verifica cidade e estado
		#$sql = $objQuery->SQLQuery("SELECT cidade from vsites_cidades as e where cidade = '".$R_CIDADE."' and estado = '".$R_ESTADO."'");
		#$num_cidade = mysql_num_rows($sql);
		#if($num_cidade=='0' and $R_NOME<>''){				
		#	$erro.="Cidade ou Estado Inválidos<br>";
		#}
		
		if($qtdd_registros<>0){
			$sql_arquivo_item = "insert into vsites_arquivo_item (id_arquivo, certidao_nome, certidao_mae, certidao_data_obito,certidao_livro,certidao_folha,certidao_termo,certidao_cartorio, certidao_cidade, certidao_estado, erro)
			values('".$id_arquivo."','".$R_NOME."','".$R_MAE."','".$R_DATA_OBITO."','".$R_LIVRO."','".$R_FOLHA."','".$R_TERMO."','".$R_CARTORIO."','".$R_CIDADE."','".$R_ESTADO."','".$erro."')";
			$result_arquivo_item = $objQuery->SQLQuery($sql_arquivo_item);
		}
	}
}
#$sql_arquivo_dup_a = "update vsites_arquivo_item as ai, (select * from vsites_arquivo_item as ai where ai.id_arquivo='".$id_arquivo."') as ai2 set ai.dup='1' where ai.id_arquivo='".$id_arquivo."' and ai.certidao_nome = ai2.certidao_nome and ai.certidao_cpf=ai2.certidao_cpf and ai.certidao_cidade=ai2.certidao_cidade  and ai.certidao_estado=ai2.certidao_estado and ai.id_arquivo_item!=ai2.id_arquivo_item and ai.id_arquivo_item>ai2.id_arquivo_item";
#$result_arquivo_dup = $objQuery->SQLQuery($sql_arquivo_dup_a);
#$enc_dupli = date('Y-m-d');
#$sql_arquivo_dup_a = "update vsites_pedido as p, vsites_pedido_item as pi, vsites_arquivo_item as ai set ai.dup='1', ai.ordem_dup=pi.ordem, ai.id_pedido_dup=pi.id_pedido where ai.id_arquivo='".$id_arquivo."' and ai.erro='' and ai.dup='0' and p.id_conveniado='".$id_cliente."' and pi.id_status!='14' and pi.id_servico='".$id_servico."' and p.id_pedido=pi.id_pedido and  (pi.encerramento='0000-00-00 00:00:00' or pi.encerramento>=DATE_SUB('".$enc_dupli." 00:00:00',INTERVAL 3 MONTH)) and
#ai.certidao_nome = pi.certidao_nome and (ai.certidao_cpf= (replace(replace(replace(pi.certidao_cpf,'-',''),'.',''),'/','')) and pi.certidao_cpf!='' or ai.certidao_cpf = (replace(replace(replace(pi.certidao_cnpj,'-',''),'.',''),'/','')) and pi.certidao_cnpj!='') and ai.certidao_cidade=pi.certidao_cidade  and ai.certidao_estado=pi.certidao_estado";
#$result_arquivo_dup = $objQuery->SQLQuery($sql_arquivo_dup_a);
?>