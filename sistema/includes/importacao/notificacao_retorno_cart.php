<?
$erro =='';
$linha_cont=1;
$CONT_NOT=0;
$qtdd_not = 0;

$imp_cliente = substr($file_import_name,3,6);
switch($imp_cliente){
	case 'Tarraf':
		$id_conveniado='89607';
		break;
	case 'BICBAN':
		$id_conveniado='49117';
		break;
	case 'HELBOR':
		$id_conveniado='95219';
		break;		
}
if($id_conveniado==''){
	echo 'Arquivo inválido, tente novamente!';
	exit;
}


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
			$H_IDENTIFICACAO = substr($buffer, 1, 7);
			$H_DESCRICAO = substr($buffer, 8, 30);
			$H_DATA = substr($buffer, 38, 8);
			$H_TIPO = substr($buffer, 46, 4);
		}
		
		if(substr($buffer, 0, 1)=='1'){			
			$R_NOT_NUMERO = (int)(substr($buffer, 1, 9));
			$R_NOT_PROTOCOLO = (int)(substr($buffer, 10, 8));
			$R_NOT_PROTOCOLO_DATA = substr($buffer, 18, 8);
			$R_NOT_REGISTRO = (int)(substr($buffer, 26, 8));
			$R_NOT_REGISTRO_DATA = substr($buffer, 34, 8);
			$R_AR = str_replace(' ','',substr($buffer, 42, 15));
			$R_OCORRENCIA = (int)substr($buffer, 57, 5);
			$R_OCORRENCIA_DATA = substr($buffer, 62, 8);
			$R_ORDEM = explode('-',str_replace(' ','',substr($buffer, 70, 11)));
			$R_NUMERO_NOT = str_replace(' ','',substr($buffer, 70, 11));
			$R_CUSTAS = explode('-',str_replace(' ','',substr($buffer, 71, 12)));
			$R_SEQUENCIA = (int)substr($buffer, 94, 6);

			$CONT_NOT++;
			$update_campos = '';
			#validacao dos campos
			if($R_NOT_PROTOCOLO<>0 and ValidaData($R_NOT_PROTOCOLO_DATA)!=1) $erro .= 'Linha '.$R_SEQUENCIA.': Data do protocolo inválida<br>';
			if($R_NOT_REGISTRO<>0 and ValidaData($R_NOT_REGISTRO_DATA)!=1) $erro .= 'Linha '.$R_SEQUENCIA.': Data do registro inválida<br>';
			if($R_OCORRENCIA<>0 and ValidaData($R_OCORRENCIA_DATA)!=1) $erro .= 'Linha '.$R_SEQUENCIA.': Data da ocorrencia inválida<br>';
			
			if($H_TIPO=='REGI'){
				if($R_NOT_PROTOCOLO<>0) $update_campos .= "certidao_protocolo='".$R_NOT_PROTOCOLO."',	certidao_data_protocolo='".$R_NOT_PROTOCOLO_DATA."', conf='1',";
				if($R_NOT_REGISTRO<>0) $update_campos .= "certidao_registro='".$R_NOT_REGISTRO."', certidao_data_registro='".$R_NOT_REGISTRO_DATA."', regi='1' ";
				$ARRAY[$linha_cont-1] = "update vsites_pedido_item set 
				data_atividade=NOW(), id_status='8',id_atividade='94', ".$update_campos;

				if($id_conveniado==95219){
					$onde1= " pi.certidao_numero_not='".$R_NUMERO_NOT."' and pi.certidao_numero_not!='' and pi.id_status=4 and id_servico=17 ";
				} else {
					$onde1= " pi.id_pedido='".$R_ORDEM[0]."' and pi.ordem='".$R_ORDEM[1]."' and pi.id_servico=17";
				}

				$sql_id_pedido  = $objQuery->SQLQuery("SELECT pi.certidao_nome, pi.certidao_numero_not, pi.id_pedido_item, pi.id_empresa_atend, pi.id_pedido, pi.ordem from vsites_pedido_item as pi, vsites_pedido as p where ".$onde1." and pi.id_pedido=p.id_pedido and p.id_conveniado='".$id_conveniado."' order by id_pedido_item");
				$res_id_pedido  = mysql_fetch_array($sql_id_pedido);
				$id_pedido_item = $res_id_pedido['id_pedido_item'];
				$id_pedido = $res_id_pedido['id_pedido'];
				$certidao_nome = $res_id_pedido['certidao_nome'];
				$ordem		 = $res_id_pedido['ordem'];
				if($id_empresa=='') $id_empresa=$res_id_pedido['id_empresa_atend'];
				$certidao_numero_not = $res_id_pedido['certidao_numero_not'];
				if($id_conveniado==95219){
					$ARRAY[$linha_cont-1] .= " where certidao_numero_not='".$R_NUMERO_NOT."' and certidao_numero_not!='' and certidao_nome='".$certidao_nome."' and (regi!=2 or regi is NULL) and id_servico=17 ";
				} else {
					$ARRAY[$linha_cont-1] .= " where id_pedido='".$R_ORDEM[0]."' and ordem='".$R_ORDEM[1]."' and (regi!=2 or regi is NULL) and id_servico=17";
				}
				if($id_pedido_item<>''){
					$query="insert into vsites_pedido_status (id_atividade,status_obs,data_i,id_usuario,id_pedido_item,status_dias) values ('94','',NOW(),'".$controle_id_usuario."','".$id_pedido_item."','0')";
					$result = $objQuery->SQLQuery($query);

					$query="update vsites_pedido_item as pi set 
						pi.operacional=NOW(), pi.data_atividade=NOW(), pi.encerramento=NOW(), pi.id_status='10', pi.id_atividade='119', pi.valor='0.01', 
						pi.conf=2, pi.regi=2, pi.ocor=2 where 
						pi.certidao_numero_not='".$certidao_numero_not."' and pi.certidao_numero_not<>'' and pi.id_status=4 and 
						pi.id_servico=17 ";

					if($id_conveniado==95219) {
						$query .= " and pi.id_pedido='".$id_pedido."' and pi.ordem!='".$ordem."' and pi.certidao_nome='".$certidao_nome."'";						
					} else {
						if($id_conveniado==49117) {
							$query .= " and pi.id_pedido='".$R_ORDEM[0]."' and pi.ordem!='".$R_ORDEM[1]."'";
						} else {
							$query .= " and pi.id_pedido='".$R_ORDEM[0]."' and pi.ordem!='".$R_ORDEM[1]."' and pi.certidao_nome='".$certidao_nome."'";
						}
					}
					$result2 = $objQuery->SQLQuery($query);
					$qtdd_not++;
				}
			}else{

				if($R_AR<>'') $update_campos .= "certidao_numero_ar='".$R_AR."',";
				$update_campos .= "certidao_ocorrencia='".$R_OCORRENCIA."', certidao_data_ocorrencia='".$R_OCORRENCIA_DATA."', ocor='1' ";
				$ARRAY[$linha_cont-1] = " update vsites_pedido_item set 
				".$update_campos;
				if($id_conveniado!=95219) $ARRAY[$linha_cont-1] .= " where id_pedido='".$R_ORDEM[0]."' and ordem='".$R_ORDEM[1]."' and id_servico=17";
				else $ARRAY[$linha_cont-1] .= " where certidao_numero_not='".$R_NUMERO_NOT."' and certidao_numero_not!='' and id_servico=17";
			}	
			
			$ordens .= '#'.$id_pedido.'/'.$ordem.' Notificação número '.$R_NUMERO_NOT.',<br>';
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
			if($CONT_NOT2!=$T_QUANT_NOT) $erro.='Quantidades de notificações não confere com o número indicado na linha TRAILER '.$linha_cont.'<br>';
			if($CONT_NOT2>'3000') $erro.='O número máximo de importação de registros não pode ultrapassar 3000 registros e o arquivo atual possui '.$CONT_NOT2.'<br>';
			
			$rodape=$T_QUANT_NOT;
		}

		#verifica tamanho da linha
		if ($qtdd_registros<>102) $erro.='Quantidades de campos inválido na linha '.$linha_cont.'<br>';
		
		#verifica sequencia
		if (substr($buffer, 94, 6)!=$linha_formatada) $erro .= 'Sequencia inválida na linha '.$linha_cont.'<br>';
		
		#verifica se é o final do arquivo
		if (substr($buffer, 0, 1)=='9') break;
		
		#conta linha
		$linha_cont++;

	}
	
	if($qtdd_not<>0 and $id_empresa!=1){
		$sql_id_pedido  = $objQuery->SQLQuery("SELECT * from vsites_user_empresa as ue where ue.id_empresa='".$id_empresa."'");
		$res_id_pedido  = mysql_fetch_array($sql_id_pedido);

		$pedidoDAO = new PedidoDAO();
		
		$p = new stdClass();
		$p->id_usuario=$controle_id_usuario;
		$p->id_empresa_atend=$controle_id_empresa;
		$p->nome='Franquia '.$res_id_pedido['fantasia'];
		$p->origem='Escritórios';
		$p->id_ponto='';
		$p->id_pacote='';
		$p->retem_iss='';
		$p->urgente='';
		$p->restricao='';
		$p->id_conveniado='';
		$p->id_cliente='';
		$p->tel2='';
		$p->tel=''.$res_id_pedido['tel'];
		$p->ramal2='';
		$p->ramal='';
		$p->fax='';
		$p->outros='';
		$p->email=''.$res_id_pedido['email'];
		$p->cpf=''.$res_id_pedido['cpf'];
		$p->rg='';
		$p->tipo=''.$res_id_pedido['tipo'];
		$p->complemento=''.$res_id_pedido['complemento'];
		$p->numero=''.$res_id_pedido['numero'];
		$p->endereco=''.$res_id_pedido['endereco'];
		$p->bairro=''.$res_id_pedido['bairro'];
		$p->cidade=''.$res_id_pedido['cidade'];
		$p->estado=''.$res_id_pedido['estado'];
		$p->cep=''.$res_id_pedido['cep'];
		$p->omesmo='on';
		$p->controle_cliente='';
		$p->complemento_f='';
		$p->numero_f='';
		$p->endereco_f='';
		$p->bairro_f='';
		$p->cidade_f='';
		$p->estado_f='';
		$p->cep_f='';
		$p->forma_pagamento='Faturado';
		$p->dados_bancarios='';
		$p->id_servico=17;
		$p->id_servico_departamento=4;
		$p->id_servico_var=192;
		$p->valor=30*$qtdd_not;
		$p->dias='7';
		$p->obs='Faturamento das notificações do cliente '.$imp_cliente;
		$p->contato='';
		$p->contato_rg='';
		$p->retirada='';
		
		$cadastrar_pedido = $pedidoDAO->inserir($p);
		$pedido = explode('/',str_replace('#','',$cadastrar_pedido));

		$query="update vsites_pedido_item set 
			inicio=NOW(), operacional=NOW(), data_prazo=NOW(), data_atividade=NOW(), encerramento=NOW(), id_status='8', id_atividade='94', 
			conf=2, regi=2, ocor=2 where id_pedido='".$pedido[0]."' and ordem='".$pedido[1]."' ";
		$result2 = $objQuery->SQLQuery($query);
	}
}	
#cabeçalho do arquivo
$cabecalho = '<B>IDENTIFICAÇÃO:</B> '.$H_IDENTIFICACAO.' <BR><B>DESCRIÇÃO:</B> '.$H_DESCRICAO.' <BR>
<B>DATA:</B> '.$H_DATA.' <BR><B>TIPO:</B> '.$H_TIPO;
?>