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
	$arquivoitemDAO = new ArquivoItemDAO();
	
	$id_arquivo = $arquivoitemDAO->inserirArquivo($controle_id_empresa,$controle_id_usuario,$id_cliente,$file_import_name,$id_servico);

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
		
		#substitui as abreviações
		$ext_verifica['9'] = str_replace('S PAULO','SAO PAULO',$ext_verifica['9']);
		$ext_verifica['9'] = str_replace('S JOSE DOS CAMPOS','SAO JOSE DOS CAMPOS',$ext_verifica['9']);
		$ext_verifica['9'] = str_replace('STA RITA D OEST','SANTA RITA D OESTE',$ext_verifica['9']);		
		$ext_verifica['9'] = str_replace('S JOSE DO RIO PRETO','SAO JOSE DO RIO PRETO',$ext_verifica['9']);
		$ext_verifica['9'] = str_replace('S LEOPOLDO','SAO LEOPOLDO',$ext_verifica['9']);
		$ext_verifica['9'] = str_replace('S VICENTE','SAO VICENTE',$ext_verifica['9']);
		$ext_verifica['9'] = str_replace('S CARLOS','SAO CARLOS',$ext_verifica['9']);
		$ext_verifica['9'] = str_replace('JUAZ DO NORTE','JUAZEIRO DO NORTE',$ext_verifica['9']);
		$ext_verifica['9'] = str_replace('STO ANDRE','SANTO ANDRE',$ext_verifica['9']);
		$ext_verifica['9'] = str_replace('FLORIDA PTA','FLORIDA PAULISTA',$ext_verifica['9']);
		$ext_verifica['9'] = str_replace('SAO GABRILE D OESTE','SAO GABRIEL DO OESTE',$ext_verifica['9']);
		$ext_verifica['9'] = str_replace('S SEBASTIAO','SAO SEBASTIAO',$ext_verifica['9']);
		$ext_verifica['9'] = str_replace('F DE SANTANA','FEIRA DE SANTANA',$ext_verifica['9']);
		$ext_verifica['9'] = str_replace('CAMPINA GRAN DO SUL','CAMPINA GRANDE DO SUL',$ext_verifica['9']);
		$ext_verifica['9'] = str_replace('S GONCALO','SAO GONCALO',$ext_verifica['9']);
		$ext_verifica['9'] = str_replace('STA RTA PARDO','SANTA RITA PARDO',$ext_verifica['9']);
		$ext_verifica['9'] = str_replace('BARRA RIBEIRO','BARRA DO RIBEIRO',$ext_verifica['9']);
		$ext_verifica['9'] = str_replace('FCO BELTRAO','FRANCISCO BELTRAO',$ext_verifica['9']);
		$ext_verifica['9'] = str_replace('S LUIS','SAO LUIS',$ext_verifica['9']);
		
		#limpa caracteres do cpf, cnpj
		
		$ext_verifica['2'] = str_replace('-','',$ext_verifica['2']);
		$ext_verifica['2'] = str_replace('.','',$ext_verifica['2']);
		$ext_verifica['2'] = str_replace('/','',$ext_verifica['2']);
		
		$ext_verifica['0'] = str_replace('-','',$ext_verifica['0']);
		$ext_verifica['0'] = str_replace('.','',$ext_verifica['0']);
		$ext_verifica['0'] = str_replace('/','',$ext_verifica['0']);

		
		$qtdd_linha = strlen($ext_verifica['2']);
		$linha_formatada='';
		if($qtdd_linha<=11){
			while ($qtdd_linha<11){
				$linha_formatada .= '0';
				$qtdd_linha++;
			}
		} else {
			while ($qtdd_linha<14){
				$linha_formatada .= '0';
				$qtdd_linha++;
			}
		}
		$ext_verifica['2'] = $linha_formatada.$ext_verifica['2'];			

		$qtdd_linha = strlen($ext_verifica['0']);
		$linha_formatada='';
		if($qtdd_linha<=11){
			while ($qtdd_linha<11){
				$linha_formatada .= '0';
				$qtdd_linha++;
			}
		} else {
			while ($qtdd_linha<14){
				$linha_formatada .= '0';
				$qtdd_linha++;
			}
		}
		$ext_verifica['0'] = $linha_formatada.$ext_verifica['0'];

		
		#verifica tamanho do array
		if($tamanho<>11 and $qtdd_registros<>''){				
			$erro.="Quantidade de campos inválido <br>";
		}
		
		#valida os campos
		if(str_replace('0','',$ext_verifica['0'])=='' and $qtdd_registros<>''){	
			$erro.="CPF/CNPJ do devedor em branco<br>";
		}

		if($ext_verifica['1']=='' and $qtdd_registros<>''){	
			$erro.="Nome do devedor em branco <br>";
		}

		if(str_replace('0','',$ext_verifica['2'])=='' and $qtdd_registros<>''){	
			$erro.="CPF/CNPJ em branco <br>";
		}
		
		if($ext_verifica['3']=='' and $qtdd_registros<>''){	
			$erro.="NOME em branco<br>";
		}		
		
		#$ext_verifica[0] = '';
		#$ext_verifica[1] = '';
		#$ext_verifica[4] = '';
		#$ext_verifica[5] = '';
		#$ext_verifica[6] = '';
		#$ext_verifica[7] = '';
		#$ext_verifica[8] = '';
		
		#recupera dados para verificacao
		$R_DEVEDOR_CPF= $ext_verifica[0];
		$R_DEVEDOR	  = $ext_verifica[1];
		$R_CPF 	   	  = $ext_verifica[2];
		$R_NOME       = $ext_verifica[3];
		$R_RG 	      = $ext_verifica[4].' '.$ext_verifica[5].' '.$ext_verifica[6];
		$R_CONJUGE    = $ext_verifica[8];
		$R_CIDADE     = $ext_verifica[9];
		$R_ESTADO     = substr($ext_verifica[10], 0, 2);
		
		#valida documento
		$valida_cpf = validaCPF($R_CPF);
		$valida_cnpj = validaCNPJ($R_CPF);
		if($valida_cpf=='false' and $valida_cnpj=='false'){				
			$erro.="CPF/CNPJ Inválido <br>";
		}
		
		#if($valida_cnpj=='true'){
		#	$R_CNPJ = $R_CPF;
		#	$R_CPF = "";
		#} else {
		#	$R_CNPJ = "";
		#}
		
		#verifica cidade e estado
		$sql = $objQuery->SQLQuery("SELECT cidade from vsites_cidades as e where cidade = '".$R_CIDADE."' and estado = '".$R_ESTADO."'");
		$num_cidade = mysql_num_rows($sql);
		if($num_cidade=='0' and $R_NOME<>''){				
			$erro.="Cidade ou Estado Inválidos<br>";
		}

		
		if($qtdd_registros<>0){		
			$r->devedor_cpf = $R_DEVEDOR_CPF.'';
			$r->devedor = $R_DEVEDOR.'';
			$r->cpf = $R_CPF.'';
			$r->nome = $R_NOME.'';
			$r->rg = $R_RG.'';
			$r->conjuge = $R_CONJUGE.'';
			$r->cidade = $R_CIDADE.'';
			$r->estado = $R_ESTADO.'';
			$r->erro = $erro.'';
			$result_arquivo_item = $arquivoitemDAO->inserirArquivoImoveisDetran($controle_id_empresa,$id_arquivo,$r);
		}
	}
}

	$result_arquivo_dup = $arquivoitemDAO->verificaDuplicidadeImoveisDetran($id_arquivo,$id_cliente,$id_servico);
?>