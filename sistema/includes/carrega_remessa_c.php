<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	include_once( "../includes/verifica_logado_ajax.inc.php");
	include_once( "../includes/funcoes.php" );
	include_once( "../includes/global.inc.php" );
	pt_register('GET','id_arquivo_item');
	pt_register('GET','nome');
	pt_register('GET','cpf');
	pt_register('GET','estado');
	pt_register('GET','cidade');
	$erro="";
	$cpf = str_replace('-','',$cpf);
	$cpf = str_replace('.','',$cpf);
	$cpf = str_replace('/','',$cpf);

	#valida documento
	$valida_cpf = validaCPF($cpf);
	$valida_cnpj = validaCNPJ($cpf);
	if($valida_cpf=='false' and $valida_cnpj=='false'){
		$erro.="CPF/CNPJ Inválido <br>";
	}
		
	if($nome==''){
		$erro.="Nome em branco <br>";
	}

	if($cpf==''){
		$erro.="CPF/CNPJ em branco <br>";
	}

	if($cidade==''){
		$erro.="Cidade em branco <br>";
	}

	if($estado==''){
		$erro.="Estado em branco <br>";
	}

	#verifica cidade e estado
	$sql = $objQuery->SQLQuery("SELECT cidade from vsites_cidades as e where cidade = '".$cidade."' and estado = '".$estado."'");
	$num_cidade = mysql_num_rows($sql);
	if($num_cidade=='0'){
		$erro.="Cidade ou Estado Inválidos<br>";
	}

	$arquivoitemDAO = new ArquivoItemDAO();
	$ret = $arquivoitemDAO->listaRemessaCPorIDItem($id_arquivo_item,$controle_id_empresa);
	$p_valor = '';
	
	if($ret->id_arquivo<>''){
		$aItem->nome= $nome;
		$aItem->cpf= $cpf;
		$aItem->cidade=$cidade;
		$aItem->estado=$estado;
		$aItem->erro=$erro;
		$ret2 = $arquivoitemDAO->atualizaArquivoItem($aItem,$ret,$ret->id_arquivo,$id_arquivo_item,$controle_id_usuario,$controle_id_empresa);
				
		if($ret2<>''){
			echo '<td class="result_celula" colspan="6">Serviço Registrado com sucesso. Protocolo: #'.$ret2.'</td>';
		} else {
			if($erro==''){
				echo '<td class="result_celula" colspan="6">Serviço em duplicidade</td>';
			} else {
				echo '
				<td class="result_celula"> <input type="text" name="nome_'.$id_arquivo_item.'" value = "'.$nome.'"></td>
				<td class="result_celula"> <input type="text" name="cpf_'.$id_arquivo_item.'" value = "'.$cpf.'"></td>
				<td class="result_celula"> <input type="text" name="cidade_'.$id_arquivo_item.'" value = "'.$cidade.'"></td>
				<td class="result_celula"> <input type="text" name="estado_'.$id_arquivo_item.'" value = "'.$estado.'"></td>
				<td class="result_celula" width="150"> '.$erro.'</td>
				<td class="result_celula">
					<input type="button" name="registro_'. $id_arquivo_item.'" onclick="remessa_registra(nome_'. $id_arquivo_item .'.value,cpf_'. $id_arquivo_item .'.value,cidade_'. $id_arquivo_item .'.value,estado_'. $id_arquivo_item .'.value,\''. $id_arquivo_item.'\')" value = "Processar">
				</td>';
			}	
		}

	} else {
		echo '<td class="result_celula" colspan="6">Não foi possível registrar o serviço</td>';	
	}
?>