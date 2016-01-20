<?
@ini_set("memory_limit",'500M');
set_time_limit(3000);
require( "../includes/classQuery.php" );
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
require( "../includes/dias_uteis.php");
require( "../afiliados/classQuery_omelhordobairro.php");
$p_valor ='';

$sql = "select pi.*, p.* from vsites_pedido_item as pi, vsites_pedido as p where pi.id_pedido=p.id_pedido and pi.id_pedido_p = '' and pi.id_status!='14'";
$query = $objQuery_Outros->SQLQuery($sql);
while($res = mysql_fetch_array($query)){
	$cont++;
	$id_pedido_item = $res['id_pedido_item'];
	#identifica departamento
	$sql_ser = "select * from vsites_servico as s where s.id_servico='".$res['id_servico']."'";
	$query_ser = $objQuery->SQLQuery($sql_ser);
	$res_ser = mysql_fetch_array($query_ser);
	$id_servico_departamento=$res_ser['id_departamento'];
	
	if($res['id_servico']=='' or $res['id_servico_var']=='' or $id_servico_departamento==''){
		$error .= ' Erro: Servico e/ou variação inválida'.$id_servico_departamento;
		$errors = 1;
	}
	
	#verifica CNPJ, remove campos como '
	if($errors!=1){
		#insert cartorio postal pedido
		$sql_pedido = "insert into vsites_pedido (id_afiliado,id_usuario,origem,nome,email,cpf,rg,tipo,cidade,data,endereco,numero,complemento,bairro,estado,cep,tel,tel2,ramal,ramal2,fax,outros,retem_iss,forma_pagamento,contato) values('1','1','Site','".str_replace("'",'',$res['nome'])."','".str_replace("'",'',$res['email'])."','".str_replace("'",'',$res['cpf'])."','".str_replace("'",'',$res['rg'])."','".str_replace("'",'',$res['tipo'])."','".str_replace("'",'',$res['cidade'])."','".str_replace("'",'',$res['data'])."','".str_replace("'",'',$res['endereco'])."','".str_replace("'",'',$res['numero'])."','".str_replace("'",'',$res['complemento'])."','".str_replace("'",'',$res['bairro'])."','".str_replace("'",'',$res['estado'])."','".str_replace("'",'',$res['cep'])."','".str_replace("'",'',$res['tel'])."','".str_replace("'",'',$res['tel2'])."','".str_replace("'",'',$res['ramal'])."','".str_replace("'",'',$res['ramal2'])."','".str_replace("'",'',$res['fax'])."','".str_replace("'",'',$res['outros'])."','".str_replace("'",'',$res['retem_iss'])."','Faturado','".str_replace("'",'',$res['contato'])."')";
		$query_pedido = $objQuery->SQLQuery($sql_pedido);
		$id_pedido_p = $objQuery->ID;

		#insert cartorio postal pedido item
		$sql_pedido_item = "insert into vsites_pedido_item (id_usuario,id_pedido,id_pedido_a,ordem_a,ordem,data,atendimento,id_servico,id_servico_var,id_servico_departamento,id_atividade,id_status,valor,dias,data_atividade,data_status,obs,certidao_averbacao,certidao_banco_sacado,certidao_campo_bairro,certidao_campo_cep,certidao_cidade,certidao_praca,certidao_cnpj,certidao_cpf,certidao_data,certidao_endereco,certidao_estado,certidao_nome,certidao_numero,certidao_rg,certidao_cartorio,certidao_cartorio_cep,certidao_cartorio_do_registro,certidao_cartorio_endereco,certidao_cartorio_tel,certidao_cidade_do_estrangeiro,certidao_comarca_forum,certidao_conjuge,certidao_data_batismo,certidao_data_casamento,certidao_data_desembarque,certidao_data_emissao,certidao_data_expedicao,certidao_data_nascimento,certidao_data_naturalizacao,certidao_data_obito,certidao_data_registro,certidao_devedor,certidao_documento_autenticado,certidao_documento_imigrante,certidao_edificio,certidao_endereco_empresa,certidao_endereco_imovel,certidao_esposa,certidao_estado_civil,certidao_existe_certidao_de1,certidao_existe_certidao_de2,certidao_existe_certidao_obito,certidao_filiacao,certidao_finalidade,certidao_folha,certidao_historico_ano,certidao_inscricao,certidao_livro,certidao_loteamento,certidao_mae,certidao_marido,certidao_matricula,certidao_matriculas_encontradas,certidao_n_contrato,certidao_n_contribuinte,certidao_n_deposito,certidao_n_matricula,certidao_n_processo,certidao_n_titulo_eleitor,certidao_nacionalidade,certidao_naturalizado,certidao_navio,certidao_nome_escola,certidao_nome_estrangeiro,certidao_nome_imigrante,certidao_nome_proprietario,certidao_nome_reconhecer,certidao_numero_ccm,certidao_numero_cheque,certidao_numero_contrato,certidao_numero_contribuinte,certidao_outros_familiares,certidao_padre,certidao_pai,certidao_porto_desembarque,certidao_porto_saida,certidao_profissao,certidao_proposta,certidao_protocolo,certidao_provincia_regiao,certidao_qtdd_cartorio,certidao_quadra,certidao_registro,certidao_requerente,certidao_requerido,certidao_responsavel,certidao_secao,certidao_serie,certidao_subdistrito,certidao_tem_copia_doc,certidao_termo,certidao_tipo_processo,certidao_transcricao,certidao_valor,certidao_valor_compra_do_imovel,certidao_valor_venal,certidao_vara,certidao_cod_agencia,certidao_conta,certidao_modelo,certidao_numero_not,certidao_nosso_numero,certidao_duplicata,certidao_emissao,certidao_agencia,certidao_banco,certidao_vencimento,certidao_cart_titulo,certidao_emissao_contrato,certidao_modalidade,certidao_cpf_contratado,certidao_devedor_cpf) 
		values('1','".$id_pedido_p."','".str_replace("'",'',$res['id_pedido'])."','1','1','".str_replace("'",'',$res['data'])."',NOW(),'".str_replace("'",'',$res['id_servico'])."','".str_replace("'",'',$res['id_servico_var'])."','".$id_servico_departamento."','','','0.01','15',NOW(),'','".str_replace("'",'',$res['obs'])."','".str_replace("'",'',$res['certidao_averbacao'])."','".str_replace("'",'',$res['certidao_banco_sacado'])."','".str_replace("'",'',$res['certidao_campo_bairro'])."','".str_replace("'",'',$res['certidao_campo_cep'])."','".str_replace("'",'',$res['certidao_cidade'])."','".str_replace("'",'',$res['certidao_praca'])."','".str_replace("'",'',$res['certidao_cnpj'])."','".str_replace("'",'',$res['certidao_cpf'])."','".str_replace("'",'',$res['certidao_data'])."','".str_replace("'",'',$res['certidao_endereco'])."','".str_replace("'",'',$res['certidao_estado'])."','".str_replace("'",'',$res['certidao_nome'])."','".str_replace("'",'',$res['certidao_numero'])."','".str_replace("'",'',$res['certidao_rg'])."','".str_replace("'",'',$res['certidao_cartorio'])."','".str_replace("'",'',$res['certidao_cartorio_cep'])."','".str_replace("'",'',$res['certidao_cartorio_do_registro'])."','".str_replace("'",'',$res['certidao_cartorio_endereco'])."','".str_replace("'",'',$res['certidao_cartorio_tel'])."','".str_replace("'",'',$res['certidao_cidade_do_estrangeiro'])."','".str_replace("'",'',$res['certidao_comarca_forum'])."','".str_replace("'",'',$res['certidao_conjuge'])."','".str_replace("'",'',$res['certidao_data_batismo'])."','".str_replace("'",'',$res['certidao_data_casamento'])."','".str_replace("'",'',$res['certidao_data_desembarque'])."','".str_replace("'",'',$res['certidao_data_emissao'])."','".str_replace("'",'',$res['certidao_data_expedicao'])."','".str_replace("'",'',$res['certidao_data_nascimento'])."','".str_replace("'",'',$res['certidao_data_naturalizacao'])."','".str_replace("'",'',$res['certidao_data_obito'])."','".str_replace("'",'',$res['certidao_data_registro'])."','".str_replace("'",'',$res['certidao_devedor'])."','".str_replace("'",'',$res['certidao_documento_autenticacao'])."','".str_replace("'",'',$res['certidao_documento_imigrante'])."','".str_replace("'",'',$res['certidao_edificio'])."','".str_replace("'",'',$res['certidao_endereco_empresa'])."','".str_replace("'",'',$res['certidao_endereco_imovel'])."','".str_replace("'",'',$res['certidao_esposa'])."','".str_replace("'",'',$res['certidao_estado_civil'])."','".str_replace("'",'',$res['certidao_existe_certidao_de1'])."','".str_replace("'",'',$res['certidao_existe_certidao_de2'])."','".str_replace("'",'',$res['certidao_existe_certidao_obito'])."','".str_replace("'",'',$res['certidao_filiacao'])."','".str_replace("'",'',$res['certidao_finalidade'])."','".str_replace("'",'',$res['certidao_folha'])."','".str_replace("'",'',$res['certidao_historico_ano'])."','".str_replace("'",'',$res['certidao_inscricao'])."','".str_replace("'",'',$res['certidao_livro'])."','".str_replace("'",'',$res['certidao_loteamento'])."','".str_replace("'",'',$res['certidao_mae'])."','".str_replace("'",'',$res['certidao_marido'])."','".str_replace("'",'',$res['certidao_matricula'])."','".str_replace("'",'',$res['certidao_matriculas_encontradas'])."','".str_replace("'",'',$res['certidao_n_contrato'])."','".str_replace("'",'',$res['certidao_n_contribuinte'])."','".str_replace("'",'',$res['certidao_n_deposito'])."','".str_replace("'",'',$res['certidao_n_matricula'])."','".str_replace("'",'',$res['certidao_n_processo'])."','".str_replace("'",'',$res['certidao_n_titulo_eleitor'])."','".str_replace("'",'',$res['certidao_nacionalidade'])."','".str_replace("'",'',$res['certidao_naturalizado'])."','".str_replace("'",'',$res['certidao_navio'])."','".str_replace("'",'',$res['certidao_nome_escola'])."','".str_replace("'",'',$res['certidao_nome_estrangeiro'])."','".str_replace("'",'',$res['certidao_nome_imigrante'])."','".str_replace("'",'',$res['certidao_nome_proprietario'])."','".str_replace("'",'',$res['certidao_nome_reconhecer'])."','".str_replace("'",'',$res['certidao_numero_ccm'])."','".str_replace("'",'',$res['certidao_numero_cheque'])."','".str_replace("'",'',$res['certidao_numero_contrato'])."','".str_replace("'",'',$res['certidao_numero_contribuinte'])."','".str_replace("'",'',$res['certidao_outros_familiares'])."','".str_replace("'",'',$res['certidao_padre'])."','".str_replace("'",'',$res['certidao_pai'])."','".str_replace("'",'',$res['certidao_porto_desembarque'])."','".str_replace("'",'',$res['certidao_porto_saida'])."','".str_replace("'",'',$res['certidao_profissao'])."','".str_replace("'",'',$res['certidao_proposta'])."','".str_replace("'",'',$res['certidao_protocolo'])."','".str_replace("'",'',$res['certidao_provincia_regiao'])."','".str_replace("'",'',$res['certidao_qtdd_cartorio'])."','".str_replace("'",'',$res['certidao_quadra'])."','".str_replace("'",'',$res['certidao_registro'])."','".str_replace("'",'',$res['certidao_requerente'])."','".str_replace("'",'',$res['certidao_requerido'])."','".str_replace("'",'',$res['certidao_responsavel'])."','".str_replace("'",'',$res['certidao_secao'])."','".str_replace("'",'',$res['certidao_serie'])."','".str_replace("'",'',$res['certidao_subdistrito'])."','".str_replace("'",'',$res['certidao_tem_copia_doc'])."','".str_replace("'",'',$res['certidao_termo'])."','".str_replace("'",'',$res['certidao_tipo_processo'])."','".str_replace("'",'',$res['certidao_transcricao'])."','".str_replace("'",'',$res['certidao_valor'])."','".str_replace("'",'',$res['certidao_valor_compra_do_imovel'])."','".str_replace("'",'',$res['certidao_valor_venal'])."','".str_replace("'",'',$res['certidao_vara'])."','".str_replace("'",'',$res['certidao_cod_agencia'])."','".str_replace("'",'',$res['certidao_conta'])."','".str_replace("'",'',$res['certidao_modelo'])."','".str_replace("'",'',$res['certidao_numero_not'])."','".str_replace("'",'',$res['certidao_nosso_numero'])."','".str_replace("'",'',$res['certidao_duplicata'])."','".str_replace("'",'',$res['certidao_emissao'])."','".str_replace("'",'',$res['certidao_agencia'])."','".str_replace("'",'',$res['certidao_banco'])."','".str_replace("'",'',$res['certidao_vencimento'])."','".str_replace("'",'',$res['certidao_cart_titulo'])."','".str_replace("'",'',$res['certidao_emissao_contrato'])."','".str_replace("'",'',$res['certidao_modalidade'])."','".str_replace("'",'',$res['certidao_cpf_contratado'])."','".str_replace("'",'',$res['certidao_devedor_cpf'])."')";
		$query_pedido_item = $objQuery->SQLQuery($sql_pedido_item);
	
		#atualiza afiliado
		$sql_update = "update vsites_pedido_item as pi set id_pedido_p='".$id_pedido_p."', ordem_p='1' where id_pedido_item='".$id_pedido_item."'";
		$query_update = $objQuery_Outros->SQLQuery($sql_update);

	}
	$p_valor .= 'Item Importado: '.str_replace("'",'',$res['id_pedido_item']).' Pedido: '.str_replace("'",'',$res['id_pedido']).'/'.str_replace("'",'',$res['ordem']).' Protocolo: '.$id_pedido_p.' Solicitante: '.str_replace("'",'',$res['nome'].' '.$res['tel'].' '.$res['email']).'/1 '.$error.'<br>';
	$error='';
	$errors='';
}

#atualiza alterações
$sql = "select pi.id_servico_var, pi.valor, pi.dias, pi.id_status, pi.id_atividade, pi.ordem, pi.id_pedido from vsites_pedido_item as pi, vsites_pedido as p where p.id_afiliado='1' and pi.id_pedido=p.id_pedido and pi.id_status!='1' and pi.id_status!='3' and pi.id_status!='' and pi.data_atividade>='".date('Y-m-d', strtotime('-5 day'))." 00:00:00'";
$query = $objQuery->SQLQuery($sql);
$atualizacao='';
while($res = mysql_fetch_array($query)){
		$sql_update = "update vsites_pedido_item as pi set id_servico_var='".$res['id_servico_var']."', valor='".$res['valor']."', dias='".$res['dias']."', id_status='".$res['id_status']."', id_atividade='".$res['id_atividade']."' where id_pedido_p='".$res['id_pedido']."' and ordem_p='".$res['ordem']."'";
		$query_update = $objQuery_Outros->SQLQuery($sql_update);
		$atualizacao .= $res['id_pedido'].'-'.$res['ordem'].'<br>';
}

#atualiza motivo de cancelamento
$sql = "select ps.status_obs, pi.ordem, pi.id_pedido from vsites_pedido_item as pi, vsites_pedido as p, vsites_pedido_status as ps where p.id_afiliado='1' and pi.id_pedido=p.id_pedido and pi.id_status='14' and ps.id_atividade='124' and pi.id_pedido_item=ps.id_pedido_item and pi.data_atividade>='".date('Y-m-d', strtotime('-5 day'))." 00:00:00'";
$query = $objQuery->SQLQuery($sql);
$cancelamentos='';
while($res = mysql_fetch_array($query)){
		$sql_update = "update vsites_pedido_item as pi set motivo_canc='".$res['status_obs']."' where id_pedido_p='".$res['id_pedido']."' and ordem_p='".$res['ordem']."'";
		$query_update = $objQuery_Outros->SQLQuery($sql_update);
		$cancelamentos .= $res['id_pedido'].'-'.$res['ordem'].'<br>';
}

#atualiza liberação de pagamento
$recebimentos='';
$sql = "select pi.ordem, pi.id_pedido, pi.valor from vsites_pedido as p, vsites_pedido_item as pi, vsites_financeiro as f where p.id_afiliado='1' and pi.id_pedido=p.id_pedido and pi.id_status!='14' and pi.id_pedido_item=f.id_pedido_item and f.financeiro_tipo='Recebimento' and f.financeiro_autorizacao='Aprovado' group by f.id_pedido_item";
$query = $objQuery->SQLQuery($sql);
while($res = mysql_fetch_array($query)){
		$sql_update = "update vsites_pedido_item as pi set data_pagamento=NOW() where id_pedido_p='".$res['id_pedido']."' and ordem_p='".$res['ordem']."' and data_pagamento='0000-00-00'";
		$query_update = $objQuery_Outros->SQLQuery($sql_update);
		$recebimentos .= $res['id_pedido'].'-'.$res['ordem'].'<br>';
}

			//error_reporting(0);
			set_time_limit(0);
			require("../includes/maladireta/config.inc.php");
			require("../includes/maladireta/class.Email.php");
			error_reporting(1);
			
			  $Sender = "Captura Melhor do Bairro <webmaster@cartoriopostal.com.br>";
			  $Recipiant = 'contato@vsites.com.br';
			  $Cc = ''; 
			  $Bcc = ''; 
$subject = 'Captura melhor do bairro';
$html = 'Dia: '.date('d/m/Y h:m:s').',<br><br>

Relação de pedidos importados do Melhor do Bairro.<br><br>

'.$p_valor.'<br><br>

Relação de pedidos atualizados<br><br>
'.$atualizacao.'<br><br>

Relação de pedidos cancelados<br><br>
'.$cancelamento.'<br><br>

Relação de comissionamento liberado<br><br>
'.$recebimentos.'<br><br>
Att,<br>
Cartório Postal<br>
';			
			//** you can still specify custom headers as long as you use the constant
			//** 'EmailNewLine' to separate multiple headers.
			
			  $CustomHeaders= '';
			
			//** create the new email message. All constructor parameters are optional and
			//** can be set later using the appropriate property.
			
			  $message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
			  $message->Cc = $Cc; 
			  $message->Bcc = $Bcc; 
					// $text=$row[5];
					// $html=$row[5];
					//$content=$content;

			  $message->SetHtmlContent($html);
			
			  $pathToServerFile ="attachments/$at[1]/$at[2]";        //** attach this very PHP script.
			  $serverFileMimeType = 'multipart/mixed';  //** this PHP file is plain text.
			
			//** attach the given file to be sent with this message. ANy number of
			//** attachments can be associated with an email message. 
			
			//** NOTE: If the file path does not exist or cannot be read by PHP the file
			//** will not be sent with the email message.
			  $message->Send();

/* envia uma mensagem */
			
echo 'Tarefa concluída com sucesso!';

?>