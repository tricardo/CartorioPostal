<?
$errors = 0;
foreach($_POST as $cp => $valor){ $c->$cp = valida($valor); }
$verifica_cp   = array(
	'tipo_franquia','orgao_emissor'
);
$verifica_nome = array(
	'Tipo de Franquia','Orgão Emissor'
);
for($i = 0; $i < count($verifica_cp); $i++){
	if($errors == 0 && $c->$verifica_cp[$i] == 0){
		$errors++;
		$error  .= 'O campo '.$verifica_nome[$i].' não pode ser vazio!';
		$cp      = $verifica_cp[$i]; 
		$i 		 = count($verifica_cp);
	}
}
$verifica_cp   = array(
	'tipo_franquia','forma_pagto','valor_efetivo','nome','cpf','email','profissao','tel_res',
	'endereco','numero','bairro','estado','cidade','cep',
	'anterior_endereco','anterior_numero','anterior_bairro','anterior_estado',
	'anterior_cidade','anterior_cep','empresa_t','cargo',
	'historico','periodo','contato','cursos','estado_interesse','cidade_interesse'
);
$verifica_nome = array(
	'Tipo de Franquia','Forma de Pagto.','Valor Efetivo','Nome','CPF','Email','Profissão',
	'Residencial','Endereço','Número','Bairro','Estado','Cidade','CEP',
	'Endereço','Número','Bairro','Estado','Cidade','CEP','Empresa','Cargo',
	'Histórico','Período','Contato','Cursos','Estado de Interesse','Cidade de Interesse'
);
for($i = 0; $i < count($verifica_cp); $i++){
	if($errors == 0 && strlen($c->$verifica_cp[$i]) == 0){ 
		$errors++;
		$error  .= 'O campo '.$verifica_nome[$i].' não pode ser vazio!';
		$cp      = $verifica_cp[$i]; 
		$i 		 = count($verifica_cp);
	}
}
if($errors == 0){
	$valida = validaCPF($c->cpf);
	if($valida == 'false'){
		$errors++;
		$error  .= 'CPF digitado é inválido!';
		$cp      = 'cpf';
	}
	$valida = validaEMAIL($c->email);
	if($valida == 'false' && $errors == 0){
		$errors++;
		$error  .= 'Email digitado é inválido!';
		$cp      = 'email';
	}		
}
if($errors == 0){
	#incluir/excluir => arquivos
	$i = 0;
	$msg = array( );
	$arquivos = array( array( ) );
	foreach(  $_FILES as $key=>$info ) {
		foreach( $info as $key=>$dados ) {
			for( $i = 0; $i < sizeof( $dados ); $i++ ) { $arquivos[$i][$key] = $info[$key][$i]; }
		}
	}
	$i = 1;
	$k = 1;
	foreach( $arquivos as $file ) {
		if( $file['name'] != '' ) {	
			if(
				strpos($file['name'], 'jpg') ||
				strpos($file['name'], 'jpeg') ||
				strpos($file['name'], 'pjpeg') ||
				strpos($file['name'], 'gif') ||
				strpos($file['name'], 'bmp') ||
				strpos($file['name'], 'pdf')
			){
				preg_match("/\.(gif|bmp|png|jpg|jpeg|pdf){1}$/i", $file['name'], $ext);
				$file_path = "../anexos/".date("Ym")."/";
				if(!is_dir($file_path)) mkdir($file_path);
				$arquivo = $file_path.$id.'_'.$controle_id_usuario.'_'.md5(uniqid(time())).'_'.$k.".".$ext[1]; 
				move_uploaded_file( $file['tmp_name'], $arquivo );
				$k++;
				$lista = array(
					'id='=>$id,
					'arquivo'=>$arquivo,
					'nome'=>utf8_encode($file['name'])
				);
				$e = $dt->insereAnexo($lista);
			}
		}
		$i++;
	}
	
	
	#incluir/alterar => peguntas
	for($i = 0; $i < $c->id_pergunta_total; $i++){
		pt_register('POST','id_pergunta'.$i);
		pt_register('POST','pergunta'.$i);	
		$e = $dt->buscaRelEnumPergunta($id, ${'id_pergunta'.$i});
		$lista = array('valor'=>${'pergunta'.$i}, 'id_enum_perg'=>${'id_pergunta'.$i}, 'id_ficha'=>$id);
		if(count($e) == 0){ $e = $dt->insereRelEnumPergunta($lista); } 
		else { $e = $dt->editaRelEnumPergunta($lista); }
	}
	$e = $dt->deleteRelFichaLazer($id);
	
	
	#incluir/alterar => lazer
	for($i = 0; $i < count($c->lazer); $i++){ $e = $dt->insereRelFichaLazer($id, $c->lazer[$i]); }
	
	#alterar => site_ficha_cadastro_dados_administrativos
	$e = $dt->buscaCadastroAdicionais($id);
	$lista = array(
		'tipo_franquia'=>$c->tipo_franquia, 'num_cof'=>$c->num_cof,	
		'valor_cof'=>$c->valor_cof, 'forma_pagto'=>$c->forma_pagto,
		'origem'=>$c->origem, 'num_cof_emitida'=>$c->num_cof_emitida, 
		'valor_efetivo'=>$c->valor_efetivo, 'id_ficha'=>$id
	);
	if(count($e) == 0){ $dt->insereDadosAdministrativo($lista); } 
	else { $dt->editaDadosAdministrativo($lista); }
	
	
	#alterar => site_ficha_cadastro
	$lista = array(
		'nome'=>$c->nome, 'rg'=>$c->rg, 'cpf'=>$c->cpf, 'nascimento'=>$c->nascimento, 'email'=>$c->email, 
		'tel_res'=>$c->tel_res, 'tel_rec'=>$c->tel_rec, 'tel_cel'=>$c->tel_cel, 'estado_civil'=>$c->estado_civil,	
		'filhos'=>$c->filhos, 'filhos_quant'=>$c->filhos_quant, 'endereco'=>$c->endereco, 'numero'=>$c->numero,
		'complemento'=>$c->complemento, 'bairro'=>$c->bairro, 'cep'=>$c->cep, 'estado'=>$c->estado, 'cidade'=>$c->cidade,
		'cargo'=>$c->cargo, 'empresa_t'=>$c->empresa_t, 'historico'=>$c->historico, 'escolaridade'=>$c->escolaridade, 'cursos'=>$c->cursos,
		'formado'=>$c->escolaridade, 'negocios'=>$c->negocios, 'empresa_p'=>$c->empresa_p, 'ramp_at'=>$c->ramo_at, 'periodo'=>$c->periodo,
		'funcionarios'=>$c->funcionarios, 'faturamento'=>$c->faturamento, 'capital'=>$c->capital, 'valor_disp'=>$c->valor_disp, 'emprestimo'=>$c->emprestimo,
		'capital_terc'=>$c->capital_terc, 'inicio_neg'=>$c->inicio_neg, 'dedicado_franq'=>$c->dedicado_franq, 'fonte_renda'=>$c->fonte_renda, 'socios'=>$c->socios,
		'caixa_empresa'=>$c->caixa_empresa, 'conheceu_cp'=>$c->conheceu_cp, 'unidades'=>$c->unidades, 'unidades_valor'=>$c->unidades_valor, 'comunicados'=>$c->comunicados,
		'interesse'=>$c->interesse, 'estado_interesse'=>$c->estado_interesse, 'cidade_interesse'=>$c->cidade_interesse, 'observacao_expansao'=>$c->observacao, 
		'data_impressao'=>date("Y-m-d"), 'num_cof'=>$c->num_cof,'cof_emitido'=>$c->num_cof_emitida,'origem'=>$c->origem, 'id'=>$id
	);
	$dt->editaFichaCadastros($lista);
	
	
	#incluir/alterar => site_ficha_cadastro_adicionais
	$e = $dt->buscaCadastroAdicionais($id);
	if(strlen($c->experiencia) == 0){ $c->experiencia = 0; }
	$lista = array(
			'nacionalidade'=>$c->nacionalidade, 'local_nascimento'=>$c->local_nascimento, 
			'regime'=>$c->regime, 'data_casamento'=>$c->data_casamento, 'nome_pai'=>$c->nome_pai, 
			'nome_mae'=>$c->nome_mae, 'tip_imovel'=>$c->tip_imovel, 'reside_praca'=>$c->reside_praca, 
			'franqueado'=>$c->franqueado, 'experiencia'=>$c->experiencia, 'motivo'=>$c->motivo,
			'qual_franquia'=>$c->qual_franquia, 'opiniao'=>$c->opiniao, 'contato'=>$c->contato, 
			'faculdade'=>$c->faculdade, 'conclusao'=>$c->conclusao, 'orgao_emissor'=>$c->orgao_emissor,
			'nome_socio'=>$c->nome_socio, 'faturamento2'=>$c->faturamento2, 'funcionarios2'=>$c->funcionarios2, 
			'profissao'=>$c->profissao,'id_ficha'=>$id
		);
	if(count($e) == 0){ $dt->insereCadastroAdicionais($lista); } 
	else { $dt->editaCadastroAdicionais($lista); }
	
	
	#incluir/alterar => site_ficha_cadastro_conjuge
	$e = $dt->buscaConjuge($id);
	$lista = array(
			'nome'=>$c->conjuge_nome, 'rg'=>$c->conjuge_rg,'cpf'=>$c->conjuge_cpf, 'email'=>$c->conjuge_email, 
			'nascimento'=>$c->conjuge_nascimento, 'nome_pai'=>$c->conjuge_nome_pai,
			'nome_mae'=>$c->conjuge_nome_mae, 'profissao'=>$c->conjuge_profissao, 'cargo'=>$c->conjuge_cargo, 
			'empresa'=>$c->conjuge_empresa, 'telefone'=>$c->conjuge_telefone,
			'admissao'=>$c->conjuge_admissao, 'end_empresa'=>$c->conjuge_end_empresa, 'numero'=>$c->conjuge_numero, 
			'complemento'=>$c->conjuge_complemento, 'conjuge_bairro'=>$c->conjuge_bairro, 'estado'=>$c->conjuge_estado, 
			'cidade'=>$c->conjuge_cidade, 'cep'=>$c->conjuge_cep, 'id_ficha'=>$id
		);					
	if(count($e) == 0){ $dt->insereConjuge($lista); } 
	else { $dt->editaConjuge($lista); }
	
	
	//incluir/alterar => site_ficha_cadastro_demonstrativo_rendimento
	$e = $dt->buscaDemonstrativoRendimento($id);
	$lista = array(		
			'honorarios'=>$c->honorarios, 'salarios'=>$c->salarios, 'comissoes'=>$c->comissoes, 'salario_conjuge'=>$c->salario_conjuge, 
			'renda_alugueis'=>$c->renda_alugueis, 'emprestimo_financeiro'=>$c->emprestimo_financeiro, 'id_ficha'=>$id
		);
	if(count($e) == 0){ $dt->insereDemonstrativoRendimento($lista); } 
	else { $dt->editaDemonstrativoRendimento($lista); }
	
	
	//incluir/alterar => site_ficha_cadastro_bens_consumo
	$e = $dt->buscaBensConsumo($id);
	$lista = array(	
		'modelo_veiculo'=>$c->modelo_veiculo, 'marca_veiculo'=>$c->marca_veiculo, 'ano_veiculo'=>$c->ano_veiculo, 'placa_veiculo'=>$c->placa_veiculo, 
		'valor_veiculo'=>$c->valor_veiculo, 'financiado'=>$c->financiado, 'imovel'=>$c->imovel, 'valor_venal'=>$c->valor_venal,
		'somatoria'=>$c->somatoria, 'id_ficha'=>$id
		);
	if(count($e) == 0){ $dt->insereCadastroBensConsumo($lista); } 
	else { $dt->editaCadastroBensConsumo($lista); }
	
	
	//incluir/alterar => site_ficha_cadastro_endereco2
	$e = $dt->buscaEndereco2($id);
	$lista = array(						
			'endereco'=>$c->anterior_endereco, 'numero'=>$c->anterior_numero, 'complemento'=>$c->anterior_complemento, 'bairro'=>$c->anterior_bairro, 
			'estado'=>$c->anterior_estado, 'cidade'=>$c->anterior_cidade, 'cep'=>$c->anterior_cep, 'id_ficha'=>$id
		);
	if(count($e) == 0){ $dt->insereEndereco2($lista); } 
	else { $dt->editaEndereco2($lista); }
	
	
	//incluir/alterar => site_ficha_cadastro_referencias_bancarias
	$e = $dt->buscaReferenciaBancaria($id);
	$lista = array(						
			'banco'=>$c->banco, 'cartao_credito'=>$c->cartao_credito, 'vencimento'=>$c->vencimento, 'limite'=>$c->limite, 
			'telefone_banco'=>$c->telefone_banco, 'nome_gerente'=>$c->nome_gerente, 
			'agencia_conta'=>$c->agencia_conta, 'id_ficha'=>$id
		);
	if(count($e) == 0){ $dt->insereReferenciaBancaria($lista); } 
	else { $dt->editaReferenciaBancaria($lista); }
	
	
	//recarregar página
	echo "<script>location.href='expansao_interessados_edit.php?id=".$id."';</script>";
	exit();
}
?>