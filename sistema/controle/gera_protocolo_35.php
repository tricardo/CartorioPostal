<?
			if($certidao_nome	                                <>''){ 
					$bloco .= " \par Nome: ".$certidao_nome; $linha_bloco++; 
			}else{
				if($certidao_matricula                              <>''){ $bloco .= " \par Matricula: ".$certidao_matricula; $linha_bloco++; }
				if($certidao_cnpj	                                <>''){ $bloco .= " \par CNPJ: ".$certidao_cnpj; $linha_bloco++; }
				if($certidao_cpf	                                <>''){ $bloco .= " \par CPF: ".$certidao_cpf; $linha_bloco++; }
				if($certidao_endereco                               <>''){ $bloco .= " \par Endereço: ".$certidao_endereco; $linha_bloco++; }
				if($certidao_cidade	                                <>''){ $bloco .= " \par Cidade: ".$certidao_cidade; $linha_bloco++; }
				if($certidao_estado	                                <>''){ $bloco .= " \par Estado: ".$certidao_estado; $linha_bloco++; }
				if($certidao_cartorio                               <>''){ $bloco .= " \par Cartório: ".$certidao_cartorio; $linha_bloco++; }
				if($certidao_transcricao                            <>''){ $bloco .= " \par Transcrição: ".$certidao_transcricao; $linha_bloco++; }
			}

			$bloco .=' \par \par ';
			$linha_bloco++;
			
			$soma_linha = $linha+$linha_bloco;

			$sql = $objQuery->SQLQuery("SELECT ue.fantasia franquia_fantasia, ue.endereco franquia_endereco, ue.numero franquia_numero, ue.complemento franquia_complemento, ue.bairro franquia_bairro, ue.cidade franquia_cidade, ue.estado franquia_estado, ue.cep franquia_cep, ue.tel franquia_tel from vsites_user_usuario as uu, vsites_user_empresa as ue where
			uu.id_usuario='" . $id_usuario . "' and
			uu.id_empresa=ue.id_empresa");
			$res_f = mysql_fetch_array($sql);
			$franquia_fantasia			                   = $res_f['franquia_fantasia'];
			$franquia_endereco			                   = $res_f['franquia_endereco'];
			$franquia_numero			                   = $res_f['franquia_numero'];
			$franquia_complemento		                   = $res_f['franquia_complemento'];
			$franquia_bairro			                   = $res_f['franquia_bairro'];
			$franquia_cidade			                   = $res_f['franquia_cidade'];
			$franquia_estado			                   = $res_f['franquia_estado'];
			$franquia_cep				                   = $res_f['franquia_cep'];
			$franquia_tel				                   = $res_f['franquia_tel'];
			
			if($soma_linha-12>$imprimir_linha or $old_id_pedido!=$id_pedido and $old_id_pedido!=""){	
				while($linha-12<=$imprimir_linha){
					$frase .= '\par';
					$linha++;
				}
				
				if($assinatura==""){
					$assinatura .= " \par ".$franquia_fantasia;
					$assinatura .= " \par ".$franquia_endereco." ".$franquia_numero." ".$franquia_complemento." \par ";
					$assinatura .= $franquia_bairro. " - ".$franquia_cidade." - ".$franquia_estado." - CEP: ".$franquia_cep." \par ";
					$assinatura .= $franquia_tel." \par \par";			
				}
				
				$frase = str_replace('<servico>',$servico_topo, $frase);
				$frase = str_replace('<data_atual>',$data_atual, $frase);
				$frase = str_replace('<franquia>',$assinatura, $frase);
				$frase_topo = $imprimir_topo;
				
				$topo_servico = "";
				$old_servico  = "";
				
				$frase_sub = str_replace('<responsavel>',$responsavel, $imprimir_sub);
				$frase_sub = str_replace('<responsavel_empresa>',$responsavel_empresa, $frase_sub);
				$frase_sub = str_replace('<responsavel_email>',$responsavel_email, $frase_sub);
				$frase_sub = str_replace('<responsavel_endereco>',$responsavel_endereco, $frase_sub);
				$frase_sub = str_replace('<responsavel_tel>',$responsavel_tel, $frase_sub);
				$frase_sub = str_replace('<impressao_ordem>',$impressao_ordem, $frase_sub);
				
				$frase .= $frase_sub.$frase_topo.$bloco;
				$impressao_ordem = '';
				$bloco = '';
				$linha = $linha_bloco;
				$linha_bloco=0;
			} else {
				
				$frase = str_replace('<servico>',$servico_topo, $frase);
				$frase = str_replace('<data_atual>',$data_atual, $frase);
				$frase = str_replace('<franquia>',$franquia_fantasia, $frase);
				
				$frase .= $bloco;
				$bloco = '';
				$linha = $linha+$linha_bloco;
				$linha_bloco=0;
			}

			$assinatura = "";

			$assinatura .= " \par ".$franquia_fantasia;
			$assinatura .= " \par ".$franquia_endereco." ".$franquia_numero." ".$franquia_complemento." \par ";
			$assinatura .= $franquia_bairro. " - ".$franquia_cidade." - ".$franquia_estado." - CEP: ".$franquia_cep." \par ";
			$assinatura .= $franquia_tel." \par ";			
			
			$impressao_ordem .=  '#'.$id_pedido.'/'.$ordem.' ';
			$old_id_pedido = $id_pedido;
		$cont++;
		$linha_a = $linha-6;
?>