<? 
require("../includes/geraexcel/excelwriter.inc.php");
require("../pdfs/PDFFactory.php");

#ESSE ARQUIVO ESTÁ AMARRADO COM O ARQUIVO pedido_add.php
#arquivo de importação do banco BIC para arquivo de remessa
$permissao = verifica_permissao('Pedido Import',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' or ($controle_id_empresa!='1' and $controle_id_empresa!='20' and $controle_id_empresa!='6' and $controle_id_empresa!='192')){ 
	echo '<br><br><strong>Você não tem permissão para importar arquivo</strong>';
	exit;
} 
#$file_import_name é definido no arquivo pedido_add.php
$fp = "./remessa/".$file_import_name;


#abre o arquivo
$handle = @fopen($fp, "r");
#fim do processo de reescrever hsbc. (Deve sumir)

switch ($id_servico){
	#importação de arquivo de notificação
	case '17';
		switch ($id_cliente){
			case '49117';
				require("../includes/importacao/notificacao.php");
				break;
			case '89607';
				require("../includes/importacao/notificacao_89607.php");
				break;
			case '95219';
				require("../includes/importacao/notificacao_95219.php");
				break;
			case '129079';
				require("../includes/importacao/notificacao_129079.php");
				break;
		}
		break;
	#importação de arquivo de obito	
	case '4';
		require("../includes/importacao/obito.php");
		break;
	#importação de arquivo da scania	
	case '181';
		require("../includes/importacao/notificacao_scania.php");
		break;
	#importação de arquivo de imoveis	
	case '11';
		require("../includes/importacao/pesquisadeimoveis.php");
		break;
	#importação de arquivo de detran	
	case '16';
		require("../includes/importacao/pesquisadetran.php");
		break;
	case '155':
		require("../includes/importacao/pesquisamatricula.php");
		break;
	default:
		$erro = "Não é possível importar arquivos para esse tipo de serviço.".$id_servico;
		break;
}

#if o arquivo estiver errado finaliza
if($erro<>''){
	$errors=1;
	$error=$erro;
} else {
		$query="insert into vsites_pedido (cabecalho,rodape,retirada,nome,id_conveniado,id_ponto,id_pacote,email,cpf,rg,tipo,cidade,data,pagamento,id_usuario,origem,endereco, numero, complemento, bairro, cep, estado, tel, tel2, ramal, ramal2, fax, outros, retem_iss,restricao,comissionado,forma_pagamento,contato,omesmo,endereco_f, numero_f, complemento_f, bairro_f, cep_f, estado_f,cidade_f) values ('".$cabecalho."','".$rodape."','".$retirada."','".$nome."','".$id_cliente."','".$id_ponto."','".$id_pacote."','".$email."','".$cpf."','".$rg."','".$tipo."','".$cidade."',NOW(),'".$pagamento."','".$controle_id_usuario."','".$origem."','".$endereco."','".$numero."','".$complemento."','".$bairro."','".$cep."','".$estado."','".$tel."','".$tel2."','".$ramal."','".$ramal2."','".$fax."','".$outros."','".$retem_iss."','".$restricao."','".$comissionado."','".$forma_pagamento."','".$contato."','".$omesmo."','".$endereco_f."','".$numero_f."','".$complemento_f."','".$bairro_f."','".$cep_f."','".$estado_f."','".$cidade_f."')";
		$result = $objQuery->SQLQuery($query);
		$cadastrar_pedido = $id_pedido = $objQuery->ID;
		$ordem='0';

		if($id_servico=='17' || $id_servico=='181'){
			$i=0;
			$id_pedido_item = "";
			foreach ($ARRAY as $i => $value) {
				$result = $objQuery->SQLQuery(str_replace(",'ID_PEDIDO',",",'".$id_pedido."',",$value));
				$id_pedido_item .= ",'".$objQuery->ID."'";
				$id_pedido_itens[$i]=$objQuery->ID;
			}
			$i++;
			
			if(is_array($anexos)){
				foreach($anexos as $j=>$anexo){
					$nome_arquivos[$j] = $id_pedido.$id_pedido_itens[$j].md5(uniqid(time())).".pdf";
					$anexo = str_replace("'ID_PEDIDO_ITEM',","".$id_pedido_itens[$j].",",$anexo);
					$anexo = str_replace("'ANEXO',","'".$nome_arquivos[$j]."',",$anexo);
					$objQuery->SQLQuery($anexo);
				}
				if($id_servico=='181'){
					$pedido->id_pedido = $id_pedido;
					foreach($pedido->itens as $j=>$item)
						$item->id_pedido_item = $id_pedido_itens[$j];
					$notificacao = PDFFactory::retornaPDF($pedido,'scania');
					$notificacao->geraPDF(date("d").' de '.traduzMes(date('m')).' de '.date("Y"),$nome_arquivos);
				}
			}
		} else {	
			$i=0;
			$sql="select * from vsites_arquivo_item as ai where id_arquivo = '".$id_arquivo."' and erro='' and dup='0'";
			$query2 = $objQuery->SQLQuery($sql);
			while($res2	= mysql_fetch_array($query2)){
				$ordem++;
				$i++;
				$certidao_cpf = $res2['certidao_cpf'];
				$id_arquivo_item = $res2['id_arquivo_item'];
				#valida documento
				$valida_cpf = validaCPF($certidao_cpf);
				
				if($valida_cpf=='false'){				
					$certidao_cnpj=$certidao_cpf;
					$certidao_cpf = '';
				} else {
					$certidao_cnpj= '';
				}
				
				$result = $objQuery->SQLQuery("insert into vsites_pedido_item 
				(data_atividade,id_atividade,id_status,urgente,ordem,id_pedido, data,id_usuario,id_empresa_atend,id_servico,valor,dias,obs, id_servico_var,id_servico_departamento,
				certidao_devedor_cpf,
				certidao_devedor,
				certidao_cpf,
				certidao_cnpj,
				certidao_nome,
				certidao_mae,
				certidao_livro,
				certidao_folha,
				certidao_termo,
				certidao_data_obito,
				certidao_cartorio,		
				certidao_rg,
				certidao_conjuge,
				certidao_cidade,
				certidao_estado, certidao_matricula) values
				(NOW(),'172','1','".$urgente."','".$ordem."','".$id_pedido."',NOW(),'".$controle_id_usuario."','".$controle_id_empresa."','".$id_servico."','".$valor."','".$dias."','".$obs."','".$id_servico_var."','".$id_servico_departamento."',
				'".$res2['certidao_devedor_cpf']."',
				'".$res2['certidao_devedor']."',
				'".$certidao_cpf."',
				'".$certidao_cnpj."',
				'".$res2['certidao_nome']."',
				'".$res2['certidao_mae']."',
				'".$res2['certidao_livro']."',
				'".$res2['certidao_folha']."',
				'".$res2['certidao_termo']."',
				'".$res2['certidao_data_obito']."',
				'".$res2['certidao_cartorio']."',
				'".$res2['certidao_rg']."',
				'".$res2['certidao_conjuge']."',
				'".$res2['certidao_cidade']."',
				'".$res2['certidao_estado']."','".$res2['certidao_matricula']."')");
				$id_pedido_item .= ",'".$objQuery->ID."'";
				$sql_pedido_a = "update vsites_arquivo_item set id_pedido_dup='".$id_pedido."', ordem_dup='".$ordem."' where id_arquivo_item='".$id_arquivo_item."'";
				$result_pedido_a = $objQuery->SQLQuery($sql_pedido_a);
			}
		}
		$query="insert into vsites_pedido_status select ('') as id_pedido_status, ('172') as id_atividade,(NOW()) as data_i,('".$controle_id_usuario."') as id_usuario,('') as status_obs, pi.id_pedido_item,('0') as status_dias,('00:00:00') as status_hora from vsites_pedido_item as pi where id_pedido_item IN ('0'".$id_pedido_item.")";
		$result = $objQuery->SQLQuery($query);	

		$importados = ' até '.$i;
		$done=1;
#gera arquivo com protocolo de importação
	if($id_servico=='11' or $id_servico =='16'){
		echo '<a href="download.php" target="_blank">Clique aqui para fazer download do protocolo</a>';
	}	
}
require('footer.php');
?>
