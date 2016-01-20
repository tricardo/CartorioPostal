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
			$imprimir_linha=12;
			if($soma_linha-12>$imprimir_linha or $old_id_pedido!=$id_pedido and $old_id_pedido!=""){	
				while($linha-12<=$imprimir_linha){
					$frase .= '\par';
					$linha++;
				}
			
				if($assinatura==""){
					$assinatura .= " \par ".$nome;
					$assinatura .= " \par ".$contato;
					$assinatura .= " \par ".$endereco." ".$numero." ".$complemento." \par ";
					$assinatura .= $bairro. " - ".$cidade." - ".$estado." - CEP: ".$cep." \par ";
					$assinatura .= $tel." \par \par";			
				}
				
				$frase = str_replace('<servico>',$servico_topo, $frase);
				$frase = str_replace('<data_atual>',$data_atual, $frase);
				$frase_topo = $imprimir_topo;
				$frase_topo = str_replace('<cliente>',$assinatura, $frase_topo);
				
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
				$frase .= $bloco;
				$bloco = '';
				$linha = $linha+$linha_bloco;
				$linha_bloco=0;
			}

			$assinatura = "";
			$assinatura .= " \par ".$nome;
			$assinatura .= " \par ".$contato;
			$assinatura .= " \par ".$endereco.", ".$numero." ".$complemento." \par ";
			$assinatura .= $bairro. " - ".$cidade." - ".$estado." - CEP: ".$cep." \par ";
			$assinatura .= $tel." \par ";			
			
			$impressao_ordem .=  '#'.$id_pedido.'/'.$ordem.' ';
			$old_id_pedido = $id_pedido;
		$cont++;
		$linha_a = $linha-6;
?>