<?
			if($certidao_nome<>'' and $certidao_nome!=$old_certidao_nome){ $bloco .= " \par Nome: ".$certidao_nome; $linha_bloco++; }
			$old_certidao_nome = $certidao_nome;
			
			$bloco .=' \par ';
			$linha_bloco++;
			
			$soma_linha = $linha+$linha_bloco;

			$servico_existente = strpos($servico_topo,$servico);
			
			if($servico_topo=='' and $servico_existente===false){
				$servico_topo = $servico.$servico_existente;			
			} else {
				if($servico_topo<>'' and $servico_existente===false ){
					$servico_topo .= ', '.$servico.$servico_existente;
				}
			}
			
			if($soma_linha-12>$imprimir_linha or $old_id_pedido!=$id_pedido and $old_id_pedido!=""){	
				while($linha-12<=$imprimir_linha){
					$frase .= '\par';
					$linha++;
				}
			
				if($assinatura==""){
					$assinatura .= "\par ".$data_atual." \par \par \par";
					$assinatura .= "_______________________________________\par ";
					$assinatura .= " A/C: ".$nome;
					$assinatura .= " \par ".$endereco.", ".$numero." ".$complemento." \par ";
					$assinatura .= $bairro. " - ".$cidade." - ".$estado." - CEP: ".$cep." \par ";
				}
				
				$frase = str_replace('<servico>',$servico_topo, $frase);
				$frase_topo = $imprimir_topo;
				$topo_servico = "";
				$old_servico  = "";
				
				$frase_sub = str_replace('<responsavel>',$responsavel, $imprimir_sub);
				$frase_sub = str_replace('<responsavel_email>',$responsavel_email, $frase_sub);
				$frase_sub = str_replace('<responsavel_endereco>',$responsavel_endereco, $frase_sub);
				$frase_sub = str_replace('<responsavel_tel>',$responsavel_tel, $frase_sub);
				$frase_sub = str_replace('<impressao_ordem>',$impressao_ordem, $frase_sub);
				
				$frase .= $assinatura.$frase_sub.$frase_topo.$bloco;
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
			$assinatura .= " \par ".$data_atual." \par \par ";
			$assinatura .= "_______________________________________\par ";
			if($contato<>'') $assinatura .= $nome ."\par A/C: ".$contato;
			else $assinatura .= " A/C: ".$nome;
			$assinatura .= " \par ".$endereco.", ".$numero." ".$complemento." \par ";
			$assinatura .= $bairro." - ".$cidade." - ".$estado." - CEP: ".$cep." \par ";
			$assinatura .= " \par ";			
			
			$impressao_ordem .=  '#'.$id_pedido.'/'.$ordem.' ';
			$old_id_pedido = $id_pedido;
		$cont++;
		$linha_a = $linha-11;
?>