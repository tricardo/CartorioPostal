<?
require "../includes/topo.php";
$permissao = verifica_permissao('EXPANSAO',$safpostal_departamento_saf);
if($permissao == 'FALSE' or $safpostal_id_empresa!='1'){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
} 

$dt  = new ListaInteressadosDAO();
$dt1 = new StatusDAO();

pt_register('GET','id');
pt_register('GET','ab');
pt_register('POST','submit1');
pt_register('POST','submit2');

$dsp1 = 'block';
$dsp2 = 'none';
$dsp3 = 'none';
if($ab == '2'){
	$dsp1 = 'none';
	$dsp2 = 'block';
}

if ($submit2){
	$dsp1 = 'none';
	$dsp2 = 'block';
	pt_register('POST','data_reuniao');
	pt_register('POST','id_status');
	pt_register('POST','observacao_expansao');
	$error2  = "Os campos com * são obrigatórios.<br />";
		
	$erro_sub2 = 0;
	if($id_status == 0){
		$erro_sub2 = 1;
		$cp2 = 'id_status';
		$error2 .= 'Você deve selecionar um Status para prosseguir!';
	}
	
	if($id_status == 5 || $id_status == 10 || $id_status == 12){
		$dsp3 = 'block';
	
		if($data_reuniao == '//' || $data_reuniao == ''  && $erro_sub2 == 0){
			$erro_sub2 = 1;
			$cp2 = 'data_reuniao';
			$error2 .= 'Data digitada é inválida!';
		} else {
			$data = explode("/", $data_reuniao); 
			$d = $data[0];
			$m = $data[1];
			$y = $data[2];
		}
		
		if($erro_sub2 == 0){	
			if(checkdate($m,$d,$y) == 0){
				$erro_sub2 = 1;
				$cp2 = 'data_reuniao';
				$error2 .= 'Data digitada é inválida!';
			}
		}
		
		$dt_comp1 = $y.'-'.$m.'-'.$d;
		$dt_ver1  = strtotime($dt_comp1);
		
		$dt_comp2 = date('Y-m-d');
		$dt_ver2  = strtotime($dt_comp2);
		
		if($erro_sub2 == 0 && ($dt_ver1 < $dt_ver2)){
			$erro_sub2 = 1;
			$cp2 = 'data_reuniao';
			$error2 .= 'A data digitada não pode ser inferior a data atual!';			
		}
	}
	
	if($id_status == 2 || $id_status == 3 || $id_status == 16 || $id_status == 17){
		if($observacao_expansao == '' && $erro_sub2 == 0){
			$erro_sub2 = 1;
			$cp2 = 'observacao_expansao';
			$error2 .= 'O campo ANOTAÇÕES SOBRE ESTE CADASTRO, não pode ser vazio!';
		}
	}
	
	
	if($erro_sub2 == 0){
		$e = $dt->buscaIDStatus($id);
		$id_status_anterior = $e->id_status;
		$data_reuniao_anterior = $e->data_reuniao;
		$data_reuniao_inclusao_anterior = $e->data_reuniao_inclusao;
		$id_user_alt_anterior = $e->id_user_alt;
		$observacao_anterior = $e->observacao_expansao;

		$lista = array(
			'id_user_alt'=>$safpostal_id_usuario,'id_status'=>$id_status, 'observacao_expansao'=>$observacao_expansao, 
			'data_reuniao'=>$y.'-'.$m.'-'.$d, 'data_reuniao_inclusao'=>date ('Y-m-j') . ' ' . date ('H:i:s'), 'id_ficha'=>$id
		);	
		$e = $dt->editaModificaStatus($lista);
		
		$lista = array(
			'id_ficha'=>$id, 'id_user_alt'=>$id_user_alt_anterior, 
			'id_status'=>$id_status_anterior, 'data_reuniao'=>$data_reuniao_anterior, 'data_inclusao'=>$data_reuniao_inclusao_anterior,
			'observacao'=>$observacao_anterior
		);
		$e = $dt1->insereHistorico($lista);
		
		//enviar e-mail
		if($id_status == 4 || $id_status == 9){
			//envia email
			set_time_limit(0);
			require("../includes/maladireta/config.inc.php");
			error_reporting(1);
			require("../includes/maladireta/class.Email.php");
			$Sender = "Cartório Postal - SAF <saf@cartoriopostal.com.br>";
			
			$Recipiant = 'rafael.nascimento@cartoriopostal.com.br';//$email;
			$Cc = '';
			$Bcc = ''; 
			
			$Subject = 'Ficha de Novos Interessados - Elaborar COF';
			$html = '';
			if($id_status == 9){
				$Subject = 'Ficha de Novos Interessados - Emitir Contrato';
				$html = '';
			}
			$CustomHeaders= '';
			$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
			$message->Cc = $Cc; 
			$message->Bcc = $Bcc; 
			$message->SetHtmlContent($html);
			$pathToServerFile ="attachments/$at[1]/$at[2]";
			$serverFileMimeType = 'multipart/gased';
			$message->Send();
		}
		
		echo '<img src="../images/null.gif" width="1" height="1" border="0" onload="document.location.href=\'novos_interessados_edit.php?id='.$id.'&ab=2\'" />';
		
	} else {
		$funcao2 = "";
		$funcao2 .= "document.getElementById('".$cp2."').style.borderBottom='2px #CC3300 solid'; ";
		$funcao2 .= "document.getElementById('".$cp2."').focus(); ";
	}
}

if ($submit1){
	$errors = 0;
	$error  = "<b>Ocorreram os seguintes erros:</b> ";
	$done = 1;
	
	//DADOS PESSOAIS
	pt_register('POST','nome');
	pt_register('POST','rg');
	pt_register('POST','cpf');
	pt_register('POST','nascimento');
	pt_register('POST','email');
	pt_register('POST','tel_res');
	pt_register('POST','tel_rec');
	pt_register('POST','tel_cel');
	pt_register('POST','nacionalidade');
	pt_register('POST','local_nascimento');
	pt_register('POST','estado_civil');
	pt_register('POST','filhos');
	pt_register('POST','filhos_quant');
	pt_register('POST','regime');
	pt_register('POST','data_casamento');
	pt_register('POST','nome_pai');
	pt_register('POST','nome_mae');
	
	//DADOS PESSOAIS DO CÔNJUGE SE HOUVER
	pt_register('POST','conjuge_nome');
	pt_register('POST','conjuge_rg');
	pt_register('POST','conjuge_cpf');
	pt_register('POST','conjuge_nasc');
	pt_register('POST','conjuge_email');
	pt_register('POST','conjuge_nome_pai');
	pt_register('POST','conjuge_nome_mae');
	pt_register('POST','conjuge_profissao');
	pt_register('POST','conjuge_cargo');
	pt_register('POST','conjuge_empresa');
	pt_register('POST','conjuge_tel');
	pt_register('POST','conjuge_admissao');
	pt_register('POST','conjuge_end_empres');	
	pt_register('POST','conjuge_end_num');
	pt_register('POST','conjuge_end_compl');
	pt_register('POST','conjuge_end_bairro'); 	
	pt_register('POST','conjuge_estado');
	pt_register('POST','conjuge_end_cidade');
	pt_register('POST','conjuge_end_cep');
	
	//ENDEREÇO ATUAL DO SOLICITANTE
	pt_register('POST','endereco');
	pt_register('POST','numero');
	pt_register('POST','complemento');
	pt_register('POST','bairro');
	pt_register('POST','cep');
	pt_register('POST','estado');
	pt_register('POST','cidade');
	pt_register('POST','tip_imovel');
	pt_register('POST','reside_praca');
	
	//ENDEREÇO ANTERIOR DO SOLICITANTE
	pt_register('POST','endereco2');
	pt_register('POST','numero2');
	pt_register('POST','complemento2');
	pt_register('POST','bairro2');
	pt_register('POST','cep2');
	pt_register('POST','estado2');
	pt_register('POST','cidade2');
	
	//LAZER
	pt_register('POST','lazer');
	
	//EXPERIÊNCIA COM FRANQUIAS
	pt_register('POST','franqueado');
	pt_register('POST','experiencia');
	pt_register('POST','motivo');
	pt_register('POST','funcionarios');
	pt_register('POST','faturamento');
	pt_register('POST','periodo');
	pt_register('POST','qual_franquia');
	pt_register('POST','opiniao');

	//HISTÓRICO PROFISSIONAL
	pt_register('POST','empresa_t');
	pt_register('POST','cargo');
	pt_register('POST','historico');
	pt_register('POST','periodo');
	pt_register('POST','funcionarios');
	pt_register('POST','faturamento');
	pt_register('POST','contato');
	pt_register('POST','ramo_at');
	pt_register('POST','empresa_p');
	pt_register('POST','escolaridade');
	pt_register('POST','cursos');
	pt_register('POST','negocios');
	pt_register('POST','faculdade');
	pt_register('POST','conclusao');
	
	//SOBRE A FRANQUIA CARTÓRIO POSTAL
	pt_register('POST','id_pergunta_total');
	for($i = 0; $i < (int)$id_pergunta_total; $i++){
		pt_register('POST','id_pergunta'.$i);
		pt_register('POST','pergunta'.$i);
		$arr_id_pergunta[$i] = ${'id_pergunta'.$i};
		$arr_pergunta[$i]    = ${'pergunta'.$i};
	}
	pt_register('POST','conheceu_cp');
	pt_register('POST','unidades_valor');
	pt_register('POST','unidades');
	pt_register('POST','comunicados');
	pt_register('POST','interesse');
	pt_register('POST','estado_interesse');
	pt_register('POST','cidade_interesse');
	pt_register('POST','observacao');
	
	//INFORMAÇÕES FINANCEIRAS
	pt_register('POST','capital');
	pt_register('POST','valor_disp');
	pt_register('POST','capital_terc');
	pt_register('POST','emprestimo');
	pt_register('POST','inicio_neg');
	pt_register('POST','dedicado_franq');
	pt_register('POST','fonte_renda');
	pt_register('POST','socios');
	
	//REFERÊNCIAS BANCÁRIAS
	pt_register('POST','banco');
	pt_register('POST','cartao_credito');
	pt_register('POST','vencimento');
	pt_register('POST','limite');
	pt_register('POST','telefone_banco');
	pt_register('POST','nome_gerente');
	pt_register('POST','agencia_conta');
	
	//DEMONSTRATIVO DE RENDIMENTO
	pt_register('POST','honorarios');
	pt_register('POST','salarios');
	pt_register('POST','comissoes');
	pt_register('POST','salario_conjuge');
	pt_register('POST','renda_alugueis');
	pt_register('POST','emprestimo_financeiro');
	
	//BENS DE CONSUMO
	pt_register('POST','modelo_veiculo');
	pt_register('POST','marca_veiculo');
	pt_register('POST','ano_veiculo');
	pt_register('POST','placa_veiculo');
	pt_register('POST','valor_veiculo');
	pt_register('POST','financiado');
	pt_register('POST','imovel');
	pt_register('POST','valor_venal');
	pt_register('POST','somatoria');
		
	pt_register('POST','observacao_expansao');
	pt_register('POST','status');
	pt_register('POST','ficha_enviada');
	
	$errors = 0;
	$error  = "Os campos com * são obrigatórios.<br />";
	
	$verifica_cp   = array(
		'nome','cpf','email','tel_res','endereco','numero','bairro','estado','cidade','cep',
		'endereco2','numero2','bairro2','estado2','cidade2','cep2','empresa_t','cargo',
		'historico','periodo','contato','cursos'
	);
	$verifica_nome = array(
		'Nome','CPF','Email','Residencial','Endereço','Número','Bairro','Estado','Cidade','CEP',
		'Endereço','Número','Bairro','Estado','Cidade','CEP','Empresa','Cargor',
		'Histórico','Período','Contato','Cursos'
	);
	
	for($i = 0; $i < count($verifica_cp); $i++){
		if($errors == 0){
			if(
				${$verifica_cp[$i]} == "" || 
				${$verifica_cp[$i]} == "(__) ____-____" ||
				${$verifica_cp[$i]} == "_____-___" ||
				${$verifica_cp[$i]} == "__/____" ||
				${$verifica_cp[$i]} == "__/__/____" 
				){
				$errors  = $errors + 1;
				$error  .= 'O campo '.$verifica_nome[$i].' não pode ser vazio!';
				$cp      = $verifica_cp[$i];
			}
		}
	}
	
	if($errors == 0){
		$valida = validaCPF($cpf);
		if($valida == 'false'){
			$errors  = $errors + 1;
			$error   = '';
			$error  .= 'CPF digitado é inválido!';
			$cp      = 'cpf';
		}
	
		$valida = validaEMAIL($email);
		if($valida == 'false' && $errors == 0){
			$errors  = $errors + 1;
			$error   = '';
			$error  .= 'Email digitado é inválido!';
			$cp      = 'email';
		}
	}
	
	if($errors == 0){

		//site_ficha_cadastro
		$lista = array(
			'nome'=>$nome, 'rg'=>$rg, 'cpf'=>$cpf, 'nascimento'=>$nascimento, 'email'=>$email, 
			'tel_res'=>$tel_res, 'tel_rec'=>$tel_rec, 'tel_cel'=>$tel_cel, 'estado_civil'=>$estado_civil,	
			'filhos'=>$filhos, 'filhos_quant'=>$filhos_quant, 'endereco'=>$endereco, 'numero'=>$numero,
			'complemento'=>$complemento, 'bairro'=>$bairro, 'cep'=>$cep, 'estado'=>$estado, 'cidade'=>$cidade,
			'cargo'=>$cargo, 'empresa_t'=>$empresa_t, 'historico'=>$historico, 'escolaridade'=>$escolaridade, 'cursos'=>$cursos,
			'formado'=>$formado, 'negocios'=>$negocios, 'empresa_p'=>$empresa_p, 'ramp_at'=>$ramo_at, 'periodo'=>$periodo,
			'funcionarios'=>$funcionarios, 'faturamento'=>$faturamento, 'capital'=>$capital, 'valor_disp'=>$valor_disp, 'emprestimo'=>$emprestimo,
			'capital_terc'=>$capital_terc, 'inicio_neg'=>$inicio_neg, 'dedicado_franq'=>$dedicado_franq, 'fonte_renda'=>$fonte_renda, 'socios'=>$socios,
			'caixa_empresa'=>$caixa_empresa, 'conheceu_cp'=>$conheceu_cp, 'unidades'=>$unidades, 'unidades_valor'=>$unidades_valor, 'comunicados'=>$comunicados,
			'interesse'=>$interesse, 'estado_interesse'=>$estado_interesse, 'cidade_interesse'=>$cidade_interesse, 'observacao'=>$observacao, 
			'data_impressao'=>date("Y-m-d"), 'id'=>$id
		);
		$e = $dt->editaFichaCadastros($lista);
		
		//site_ficha_cadastro_adicionais
		$e = $dt->buscaCadastroAdicionais($id);
		$lista = array(
				'nacionalidade'=>$nacionalidade, 'local_nascimento'=>$local_nascimento, 
				'regime'=>$regime, 'data_casamento'=>$data_casamento, 'nome_pai'=>$nome_pai, 
				'nome_mae'=>$nome_mae, 'tip_imovel'=>$tip_imovel, 'reside_praca'=>$reside_praca, 
				'franqueado'=>$franqueado, 'experiencia'=>$experiencia, 'motivo'=>$motivo,
				'qual_franquia'=>$qual_franquia, 'opiniao'=>$opiniao, 'contato'=>$contato, 
				'faculdade'=>$faculdade, 'conclusao'=>$conclusao, 'id_ficha'=>$id
			);
		if(count($e) == 0){
			$e = $dt->insereCadastroAdicionais($lista);
		} else {
			$e = $dt->editaCadastroAdicionais($lista);
		}
		
		//site_ficha_cadastro_conjuge
		$e = $dt->buscaConjuge($id);
		$lista = array(
				'nome'=>$conjuge_nome, 'rg'=>$conjuge_rg,'cpf'=>$conjuge_cpf, 'email'=>$conjuge_email, 'nascimento'=>$conjuge_nasc, 'nome_pai'=>$conjuge_nome_pai,
				'nome_mae'=>$conjuge_nome_mae, 'profissao'=>$conjuge_profissao, 'cargo'=>$conjuge_cargo, 'empresa'=>$conjuge_empresa, 'telefone'=>$conjuge_tel,
				'admissao'=>$conjuge_admissao, 'end_empresa'=>$conjuge_end_empres, 'numero'=>$conjuge_end_num, 'complemento'=>$conjuge_end_compl, 'conjuge_bairro'=>$conjuge_end_bairro, 'estado'=>$conjuge_estado, 'cidade'=>$conjuge_end_cidade, 'cep'=>$conjuge_end_cep, 'id_ficha'=>$id
			);			
		if(count($e) == 0){
			$e = $dt->insereConjuge($lista);
		} else {
			$e = $dt->editaConjuge($lista);
		}

		//site_ficha_cadastro_demonstrativo_rendimento
		$e = $dt->buscaDemonstrativoRendimento($id);
		$lista = array(		
				'honorarios'=>$honorarios, 'salarios'=>$salarios, 'comissoes'=>$comissoes, 'salario_conjuge'=>$salario_conjuge, 
				'renda_alugueis'=>$renda_alugueis, 'emprestimo_financeiro'=>$emprestimo_financeiro, 'id_ficha'=>$id
			);
		if(count($e) == 0){
			$e = $dt->insereDemonstrativoRendimento($lista);
		} else {
			$e = $dt->editaDemonstrativoRendimento($lista);
		}
		
		//site_ficha_cadastro_bens_consumo
		$e = $dt->buscaBensConsumo($id);
		$lista = array(	
			'modelo_veiculo'=>$modelo_veiculo, 'marca_veiculo'=>$marca_veiculo, 'ano_veiculo'=>$ano_veiculo, 'placa_veiculo'=>$placa_veiculo, 
			'valor_veiculo'=>$valor_veiculo, 'financiado'=>$financiado, 'imovel'=>$imovel, 'valor_venal'=>$valor_venal,
			'somatoria'=>$somatoria, 'id_ficha'=>$id
			);
		if(count($e) == 0){
			$e = $dt->insereCadastroBensConsumo($lista);
		} else {
			$e = $dt->editaCadastroBensConsumo($lista);
		}
		
		//site_ficha_cadastro_endereco2
		$e = $dt->buscaEndereco2($id);
		$lista = array(						
				'endereco'=>$endereco, 'numero'=>$numero, 'complemento'=>$complemento, 'bairro'=>$bairro, 
				'estado'=>$estado, 'cidade'=>$cidade, 'cep'=>$cep, 'id_ficha'=>$id
			);
		if(count($e) == 0){
			$e = $dt->insereEndereco2($lista);
		} else {
			$e = $dt->editaEndereco2($lista);
		}
		
		//site_ficha_cadastro_referencias_bancarias
		$e = $dt->buscaReferenciaBancaria($id);
		$lista = array(						
				'banco'=>$banco, 'cartao_credito'=>$cartao_credito, 'vencimento'=>$vencimento, 'limite'=>$limite, 
				'telefone_banco'=>$telefone_banco, 'nome_gerente'=>$nome_gerente, 
				'agencia_conta'=>$agencia_conta, 'id_ficha'=>$id
			);
		if(count($e) == 0){
			$e = $dt->insereReferenciaBancaria($lista);
		} else {
			$e = $dt->editaReferenciaBancaria($lista);
		}
		
		for($i = 0; $i < count($arr_id_pergunta); $i++){
			$e = $dt->buscaRelEnumPergunta($id, $arr_id_pergunta[$i]);
			$lista = array(						
				'valor'=>$arr_pergunta[$i], 'id_enum_perg'=>$arr_id_pergunta[$i], 'id_ficha'=>$id
			);
			if(count($e) == 0){
				$e = $dt->insereRelEnumPergunta($lista);
			} else {
				$e = $dt->editaRelEnumPergunta($lista);
			}
		}
		
		$e = $dt->deleteRelFichaLazer($id);
		for($i = 0; $i < count($lazer); $i++){
			$e = $dt->insereRelFichaLazer($id, $lazer[$i]);
			
		}
		
		$done = 1;
		echo '<img src="../images/null.gif" width="1" height="1" border="0" onload="CadNovInter('.$id.');" />';
	} else {
		$funcao = "";
		$funcao .= "document.getElementById('".$cp."').style.borderBottom='2px #CC3300 solid'; ";
		$funcao .= "document.getElementById('".$cp."').focus(); ";
	}
}

if($done != 1){
	$e = $dt->buscaFichaCadastros($id);
	$f = $dt->buscaCadastroAdicionais($id);
	$g = $dt->buscaConjuge($id);
	$h = $dt->buscaEndereco2($id);
	$n = $dt->buscaReferenciaBancaria($id);
	$o = $dt->buscaDemonstrativoRendimento($id);
	$p = $dt->buscaBensConsumo($id);
	
	//DADOS PESSOAIS
	$id_ficha		   = $e->id_ficha;
	$nome			   = $e->nome;
	$rg				   = $e->rg;
	$cpf			   = $e->cpf;
	$nascimento		   = $e->nascimento;
	$email   		   = $e->email;
	$tel_res   		   = $e->tel_res;
	$tel_rec   		   = $e->tel_rec;
	$tel_cel   		   = $e->tel_cel;
	$nacionalidade	   = $f->nacionalidade;
	$local_nascimento  = $f->local_nascimentoimento;
	$estado_civil  	   = $e->estado_civil;
	$filhos     	   = $e->filhos;
	$filhos_quant  	   = $e->filhos_quant;
	$regime   	   	   = $f->regime;
	$data_casamento    = $f->data_casamento;
	$nome_pai   	   = $f->nome_pai;
	$nome_mae	       = $f->nome_mae;
	$id_status   	   = $e->id_status;
	
	//DADOS PESSOAIS DO CÔNJUGE SE HOUVER
	$conjuge_nome	   = $g->nome;
	$conjuge_rg		   = $g->rg;
	$conjuge_cpf	   = $g->cpf;
	$conjuge_nasc  	   = $g->nascimento;
	$conjuge_email     = $g->email;
	$conjuge_nome_pai  = $g->nome_pai;
	$conjuge_nome_mae  = $g->nome_mae;
	$conjuge_profissao = $g->profissao;
	$conjuge_cargo	   = $g->cargo;
	$conjuge_empresa   = $g->empresa;
	$conjuge_tel  	   = $g->telefone;
	$conjuge_admissao  = $g->admissao;
	$conjuge_end_empres= $g->end_empresa; 	
	$conjuge_end_num   = $g->numero;
	$conjuge_end_compl = $g->complemento;
	$conjuge_end_bairro= $g->bairro; 	
	$conjuge_estado    = $g->estado;	
	$conjuge_end_cidade= $g->cidade;
	$conjuge_end_cep   = $g->cep;
	
	//ENDEREÇO ATUAL DO SOLICITANTE
	$endereco 		   = $e->endereco;
	$numero 		   = $e->numero;
	$complemento 	   = $e->complemento;
	$bairro 		   = $e->bairro;
	$cep 			   = $e->cep;
	$estado 		   = $e->estado;
	$cidade 		   = $e->cidade;
	$tip_imovel 	   = $f->tip_imovel;
	$reside_praca 		   = $f->reside_praca;
	
	//ENDEREÇO ANTERIOR DO SOLICITANTE
	$endereco2         = $h->endereco;
	$numero2		   = $h->numero;
	$complemento2	   = $h->complemento;
	$bairro2		   = $h->bairro;
	$cep2			   = $h->cep;
	$estado2		   = $h->estado;
	$cidade2		   = $h->cidade;
	
	//LAZER
	$m = $dt->relFichaLazer($id);
	$i = 0;
	foreach($m as $j => $rfl){
		$rel_lazer[$i] = $rfl->id_lazer;
		$i++;
	}
	
	//EXPERIÊNCIA COM FRANQUIAS
	$franqueado  = $f->franqueado;
	$experiencia = 3;
	if($f->experiencia != ''){
		$experiencia = (int) $f->experiencia;
	}
	
	$motivo = $f->motivo;
	$funcionarios   = $e->funcionarios;
	$faturamento    = $e->faturamento;
	$periodo		= $e->periodo;
	$qual_franquia  = $f->qual_franquia;
	$opiniao 		= $f->opiniao;
	
	//HISTÓRICO PROFISSIONAL
	$empresa_t   	= $e->empresa_t;
	$cargo		    = $e->cargo;
	$historico		= $e->historico;
	$periodo		= $e->periodo;
	$funcionarios   = $e->funcionarios;
	$faturamento    = $e->faturamento;
	$contato		= $f->contato;
	$empresa_p      = $e->empresa_p;
	$ramo_at        = $e->ramo_at;
	$escolaridade   = $e->escolaridade;
	$cursos			= $e->cursos;
	$negocios		= $e->negocios;
	$faculdade		= $f->faculdade;
	$conclusao      = $f->conclusao;
	
	//SOBRE A FRANQUIA CARTÓRIO POSTAL
	$conheceu_cp    = $e->conheceu_cp;
	$unidades_valor = $e->unidades_valor;
	$unidades       = $e->unidades;
	$comunicados    = $e->comunicados;
	$interesse      = $e->interesse;
	$estado_interesse=$e->estado_interesse;
	$cidade_interesse=$e->cidade_interesse;
	$observacao     = $e->observacao;
	
	//INFORMAÇÕES FINANCEIRAS
	$capital		= $e->capital;
	$valor_disp     = $e->valor_disp;
	$capital_terc   = $e->capital_terc;
	$emprestimo     = $e->emprestimo;
	$capital_terc   = $e->capital_terc;
	$inicio_neg     = $e->inicio_neg;
	$dedicado_franq = $e->dedicado_franq;
	$fonte_renda	= $e->fonte_renda;
	$socios        = $e->socios;
	
	//REFERÊNCIAS BANCÁRIAS
	$banco 			= $n->banco;
	$cartao_credito = $n->cartao_credito;
	$vencimento     = $n->vencimento;
	$limite  	    = $n->limite;
	$telefone_banco = $n->telefone;
	$nome_gerente   = $n->nome_gerente;
	$agencia_conta  = $n->agencia_conta;
	
	//DEMONSTRATIVO DE RENDIMENTO
	$honorarios 		   = $o->honorarios;
	$salarios 			   = $o->salarios;
	$comissoes 			   = $o->comissoes;
	$salario_conjuge 	   = $o->salario_conjuge;
	$renda_alugueis 	   = $o->renda_alugueis;
	$emprestimo_financeiro = $o->emprestimo_financeiro;
	
	//BENS DE CONSUMO
	$modelo_veiculo = $p->modelo_veiculo;
	$marca_veiculo  = $p->marca_veiculo;
	$ano_veiculo    = $p->ano_veiculo;
	$placa_veiculo  = $p->placa_veiculo;
	$valor_veiculo  = $p->valor_veiculo;
	$financiado     = $p->financiado;
	$imovel			= $p->imovel;
	$valor_venal	= $p->valor_venal;
	$somatoria		= $p->somatoria;
}
?>
<table width="920" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="3" height="2"></td>
  </tr>
  <tr>
    <td width="150" align="left" valign="top">
    <table width="150" border="0" cellspacing="0" cellpadding="0" align="left">
      <tr>
        <td><? require "menu_lateral.php"; ?></td>
      </tr>
    </table>
    </td>
    <td width="2"></td>
    <td align="left" valign="top"><table width="768" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="764" align="center" valign="top" background="../images/paginas/index/barra_de_titulo1.png"><table width="768" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="345" height="20" align="left" valign="middle"><strong>&nbsp;Novos Interessados</strong></td>
            <td width="415" align="left" valign="middle">
				<span style="font-weight: bold">Franquia: <? echo $safpostal_fantasia ?></span></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td align="left" valign="middle" class="interessados" id="form_interessados" style="display:<?=$dsp1?>">
            <form name="form_interesse" action="novos_interessados_edit.php?id=<?= $id;?>" method="post" enctype="multipart/form-data">
                <div style="margin-left:10px;">	
                	<div style="width:199px; margin-top:10px;">
               		  <img src="../images/aba_novos_interessados_cadastro.png" border="0" usemap="#MapAba1" style="margin-left:0;" width="199" />                    
                    </div>	
                    <div style="width:559px; margin-top:10px; height:27px; border-bottom:solid 1px #666666">&nbsp;</div>
                    <div style="background:#0071B6; width:758px; color:#FFF; height:30px;">
                        <p style="margin-top:10px; text-align:center; width:100%;">
                            CADASTRO DE NOVOS INTERESSADOS
                            <?php
                            for($i = 1; $i <= 3; $i++){ $escondeAbas  .= 'EscondeAbas('.$i.', 1); '; }
                            for($i = 1; $i <= 12; $i++){ $escondeAbasInterna  .= 'EscondeAbasInterna('.$i.', 1); '; }
                            ?>
                            <img src="../images/null.gif" border="0" onload="<?=$escondeAbas?>" />
                            <img src="../images/null.gif" border="0" onload="<?=$escondeAbasInterna?>" />					
                        </p>
                    </div>	
                    <? if($errors > 0){?>
                    <div style="color:#FF0000; border:solid 1px #0071B6; border-top:none; width:756px;">
                        <p style="margin:10px; width:746px;"><?= $error ?><img src="../images/null.gif" border="0" height="1" width="1" onload="<?=$funcao?>" /></p>
                    </div>			
                    <? } ?>
                    <!--DADOS DO SOLICITANTE-->
                    <a name="ancor1"></a>
                    <div style="margin-top:10px; width:756px; border:solid 1px #0071B6;">
                        <div class="styler1">
                            <p id="tt1" class="styler3" style="margin-top:10px;"></p>
                        </div>
                        <div id="dt1">
                            <!--DADOS PESSOAIS-->
                            <a name="ancor11"></a>
                            <div class="styler2" style="margin-top:10px;">
                                <p id="tt21" class="styler3" style="margin-top:10px;"></p>
                            </div>
                            <div id="dt21">
                                <div style="height:10px; width:756px;"></div>
                                <div style="width:400px; margin-left:14px;"><? 
									echo ' Nome: <span style="color:#FF0000;">*</span><br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$nome.'</span>';
									else
										echo '<input name="nome" type="text" class="form_estilo" id="nome" style="width:384px" value="'.$nome.'" maxlength="100" />';
								?></div>
                                <div style="width:170px"><?
                                    echo 'RG:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$rg.'</span>';
									else
										echo '<input name="rg" type="text" class="form_estilo" id="rg" style="width:154px" value="'.$rg.'" maxlength="13" />';
                                ?></div>					
                                <div style="width:170px"><?
                                    echo 'CPF: <span style="color:#FF0000;">*</span><br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$cpf.'</span>';
									else
                                    	echo '<input name="cpf" type="text" class="form_estilo" id="cpf" style="width:154px" value="'.$cpf.'" maxlength="15" />';
                                ?></div>
                                <div style="height:10px; width:756px;"></div>
                                
                                <div style="width:370px; margin-left:14px;"><?
                                    echo 'Data de Nascimento:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$nascimento.'</span>';
									else
	                                    echo '<input name="nascimento" type="text" class="form_estilo" id="nascimento" style="width:354px" value="'.$nascimento.'" maxlength="10" />';
                                ?></div>
                                <div style="width:370px"><?
                                    echo 'E-mail: <span style="color:#FF0000;">*</span><br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal; text-transform:lowercase">'.$email.'</span>';
									else
	                                    echo '<input name="email" type="text" class="form_estilo" id="email" style="width:354px" value="'.$email.'" maxlength="50" />';
                                ?></div>
                                <div style="height:10px; width:756px;"></div>
                        
                                <div style="width:246px; margin-left:14px;"><?
                                    echo 'Residencial: <span style="color:#FF0000;">*</span><br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$tel_res.'</span>';
									else
	                                    echo '<input name="tel_res" type="text" class="form_estilo" id="tel_res" style="width:230px" value="'.$tel_res.'" maxlength="25" />';
                                ?></div>
                                <div style="width:247px"><?
                                	echo 'Recado:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$tel_rec.'</span>';
									else
	                                    echo '<input name="tel_rec" type="text" class="form_estilo" id="tel_rec" style="width:231px" value="'.$tel_rec.'" maxlength="25" />';
                                ?></div>
                                <div style="width:247px"><?
                                    echo 'Celular:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$tel_cel.'</span>';
									else
	                                    echo '<input name="tel_cel" type="text" class="form_estilo" id="tel_cel" style="width:232px" value="'.$tel_cel.'" maxlength="25" />';
                                ?></div>
                                <div style="height:10px; width:756px;"></div>
                        
                                <div style="width:370px; margin-left:14px;"><?
                                    echo 'Nacionalidade:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$nacionalidade.'</span>';
									else
	                                    echo '<input name="nacionalidade" type="text" class="form_estilo" id="nacionalidade" style="width:354px" value="'.$nacionalidade.'" maxlength="40" />';
                                ?></div>
                                <div style="width:370px"><?
                                    echo 'Local de Nascimento: <br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$local_nascimento.'</span>';
									else
	                                    echo '<input name="local_nascimento" type="text" class="form_estilo" id="local_nascimento" style="width:354px" value="'.$local_nascimento.'" maxlength="70" />';
                                ?></div>
                                <div style="height:10px; width:756px;"></div>
                        
                                <div style="width:430px; margin-left:14px;"><?
                                    echo 'Estado Civil:<br />';
									if($id_status == 14){
										echo '<span style="font-weight:normal">'.$estado_civil.'</span>';
									}else{?>
                                        <select name="estado_civil" class="form_estilo" id="estado_civil" style="width:414px">
                                            <option value="">.:SELECIONE:.</option>								
                                            <option value="Casado(a)" <? if($estado_civil=='Casado(a)') echo 'selected'; ?>>Casado(a)</option>
                                            <option value="Solteiro(a)" <? if($estado_civil=='Solteiro(a)') echo 'selected'; ?>>Solteiro(a)</option>
                                            <option value="Viuvo(a)" <? if($estado_civil=='Viuvo(a)') echo 'selected'; ?>>Viuvo(a)</option>
                                            <option value="Separado(a)" <? if($estado_civil=='Separado(a)') echo 'selected'; ?>>Separado(a)</option>
                                            <option value="Divorciado(a)" <? if($estado_civil=='Divorciado(a)') echo 'selected'; ?>>Divorciado(a)</option>
                                            <option value="Amasiado(a)" <? if($estado_civil=='Amasiado(a)') echo 'selected'; ?>>Amasiado(a)</option>
                                        </select>
                                <? }?></div>
                                <div style="width:210px"><?
                                    echo 'Possui Filhos?<br />';
									if($id_status == 14){
										echo '<span style="font-weight:normal">'.$filhos.'</span>';
									}else{?>
                                    <p style="margin-top:2px; width:20px;"><input id="filhos1" name="filhos" type="radio" value="Sim" <? if($filhos=='Sim') echo 'checked'; ?> /></p>
                                    <p style="margin-top:4px; width:85px;"><label for="filhos1">Sim</label></p>
                                    <p style="margin-top:2px; width:20px;"><input id="filhos2" name="filhos" type="radio" value="Não" <? if($filhos=='Não') echo 'checked'; ?>/></p>
                                    <p style="margin-top:4px; width:85px;"><label for="filhos2">Não</label></p>
                                <? }?></div>
                                <div style="width:100px"><?
                                    echo 'Quantos?<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$filhos_quant.'</span>';
									else
	                                    echo '<input name="filhos_quant" type="text" class="form_estilo" id="filhos_quant" style="width:84px" value="'.$filhos_quant.'" maxlength="10" />';
                                ?></div>
                                <div style="height:10px; width:756px;"></div>
                        
                                <div style="width:370px; margin-left:14px;"><?
                                    echo 'Regime de Casamento:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$regime.'</span>';
									else
	                                    echo '<input name="regime" type="text" class="form_estilo" id="regime" style="width:354px" value="'.$regime.'" maxlength="120" />';
                                ?></div>
                                <div style="width:370px"><?
                                    echo 'Data do Casamento:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$data_casamento.'</span>';
									else
	                                    echo '<input name="data_casamento" type="text" class="form_estilo" id="data_casamento" style="width:354px" value="'.$data_casamento.'" maxlength="10" />';
                                ?></div>
                                <div style="height:10px; width:756px;"></div>
                        
                                <div style="width:370px; margin-left:14px;"><?
                                    echo 'Nome do nome pai:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$nome_pai.'</span>';
									else
	                                    echo '<input name="nome_pai" type="text" class="form_estilo" id="nome_pai" style="width:354px" value="'.$nome_pai.'" maxlength="120" />';
                                ?></div>
                                <div style="width:370px"><?
                                    echo 'Nome da Mãe:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$nome_mae.'</span>';
									else
	                                    echo '<input name="nome_mae" type="text" class="form_estilo" id="nome_mae" style="width:354px" value="'.$nome_mae.'" maxlength="120" />';
                                ?></div>
                            </div>
                            <!--FIM DADOS PESSOAIS-->
                            
                            <!--DADOS PESSOAIS DO CÔNJUGE SE HOUVER-->
                            <a name="ancor12"></a>
                            <div class="styler2" style="margin-top:10px;">
                                <p id="tt22" class="styler3" style="margin-top:10px;"></p>
                            </div>
                            <div id="dt22">
                                <div style="height:10px; width:756px;"></div>
                                <div style="width:400px; margin-left:14px;"><?
                                    echo 'Nome:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$conjuge_nome.'</span>';
									else
	                                    echo '<input name="conjuge_nome" type="text" class="form_estilo" id="conjuge_nome" style="width:384px" value="'.$conjuge_nome.'" maxlength="100" />';
                                ?></div>
                                <div style="width:170px"><?
                                    echo 'RG:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$conjuge_rg.'</span>';
									else
	                                    echo '<input name="conjuge_rg" type="text" class="form_estilo" id="conjuge_rg" style="width:154px" value="'.$conjuge_rg.'" maxlength="13" />';
                                ?></div>					
                                <div style="width:170px"><?
                                    echo 'CPF:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$conjuge_cpf.'</span>';
									else
	                                    echo '<input name="conjuge_cpf" type="text" class="form_estilo" id="conjuge_cpf" style="width:154px" value="'.$conjuge_cpf.'" maxlength="15" />';
                              	?></div>
                                <div style="height:10px; width:756px;"></div>
                                
                                <div style="width:370px; margin-left:14px;"><?
                                    echo 'Data de Nascimento:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$conjuge_nasc.'</span>';
									else
	                                    echo '<input name="conjuge_nasc" type="text" class="form_estilo" id="conjuge_nasc" style="width:354px" value="'.$conjuge_nasc.'" maxlength="10" />';
                                ?></div>
                                <div style="width:370px"><?
                                    echo 'E-mail:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal; text-transform:lowercase">'.$conjuge_email.'</span>';
									else
	                                    echo '<input name="conjuge_email" type="text" class="form_estilo" id="conjuge_email" style="width:354px" value="'.$conjuge_email.'" maxlength="50" />';
                                ?></div>
                                <div style="height:10px; width:756px;"></div>
                                
                                <div style="width:370px; margin-left:14px;"><?
                                    echo 'Nome do nome pai:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$conjuge_nome_pai.'</span>';
									else
	                                    echo '<input name="conjuge_nome_pai" type="text" class="form_estilo" id="conjuge_nome_pai" style="width:354px" value="'.$conjuge_nome_pai.'" maxlength="70" />';
                                ?></div>
                                <div style="width:370px"><?
                                    echo 'Nome da Mãe:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$conjuge_nome_mae.'</span>';
									else
	                                    echo '<input name="conjuge_nome_mae" type="text" class="form_estilo" id="conjuge_nome_mae" style="width:354px" value="'.$conjuge_nome_mae .'" maxlength="70" />';
                                ?></div>
                                <div style="height:10px; width:756px;"></div>
                                
                                <div style="width:370px; margin-left:14px;"><?
                                    echo 'Profissão:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$conjuge_profissao.'</span>';
									else
	                                    echo '<input name="conjuge_profissao" type="text" class="form_estilo" id="conjuge_profissao" style="width:354px" value="'.$conjuge_profissao.'" maxlength="50" />';
                                ?></div>
                                <div style="width:370px"><?
                                    echo 'Cargo:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$conjuge_cargo.'</span>';
									else
	                                    echo '<input name="conjuge_cargo" type="text" class="form_estilo" id="conjuge_cargo" style="width:354px" value="'.$conjuge_cargo.'" maxlength="50" />';
                                ?></div>
                                <div style="height:10px; width:756px;"></div>
                                
                                <div style="width:440px; margin-left:14px;"><?
                                    echo 'Empresa:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$conjuge_empresa.'</span>';
									else
	                                    echo '<input name="conjuge_empresa" type="text" class="form_estilo" id="conjuge_empresa" style="width:424px" value="'.$conjuge_empresa.'" maxlength="50" />';
                                ?></div>
                                <div style="width:110px"><?
                                    echo 'Telefone:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$conjuge_tel.'</span>';
									else
	                                    echo '<input name="conjuge_tel" type="text" class="form_estilo" id="conjuge_tel" style="width:94px" value="'.$conjuge_tel.'" maxlength="15" />';
                                ?></div>
                                <div style="width:190px"><?
                                    echo 'Admissão:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$conjuge_admissao.'</span>';
									else
	                                    echo '<input name="conjuge_admissao" type="text" class="form_estilo" id="conjuge_admissao" style="width:174px" value="'.$conjuge_admissao .'" maxlength="10" />';
                                ?></div>
                                <div style="height:10px; width:756px;"></div>
                                
                                <div style="width:350px; margin-left:14px;"><?
                                    echo 'Endereço da Empresa:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$conjuge_end_empres.'</span>';
									else
	                                    echo '<input name="conjuge_end_empres" type="text" class="form_estilo" id="conjuge_end_empres" style="width:334px" value="'. $conjuge_end_empres.'" maxlength="60" />';
                                ?></div>
                                <div style="width:70px"><?
                                    echo 'Nº:<br/>';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$conjuge_end_num.'</span>';
									else
	                                    echo '<input name="conjuge_end_num" type="text" class="form_estilo" id="conjuge_end_num" style="width:54px" value="'.$conjuge_end_num.'" maxlength="10" />';
                                ?></div>
                                <div style="width:120px"><?
                                    echo 'Complemento:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$conjuge_end_compl.'</span>';
									else
	                                    echo '<input name="conjuge_end_compl" type="text" class="form_estilo" id="conjuge_end_compl" style="width:104px" value="'. $conjuge_end_compl.'" maxlength="40" />';
                                ?></div>
                                <div style="width:200px"><?
                                    echo 'Bairro:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$conjuge_end_bairro.'</span>';
									else
	                                    echo '<input name="conjuge_end_bairro" type="text" class="form_estilo" id="conjuge_end_bairro" style="width:184px" value="'.$conjuge_end_bairro.'" maxlength="70" />';
                                ?></div>
                                <div style="height:10px; width:756px;"></div>
                                
                                <div style="width:100px; margin-left:14px;"><?
                                    echo 'Estado:<br />';
									if($id_status == 14){
										echo '<span style="font-weight:normal">'.$conjuge_estado.'</span>';
									}else{?>
                                    <select style="width:84px" class="form_estilo" id="conjuge_estado" name="conjuge_estado">
                                        <option value="<?= $conjuge_estado ?>">UF</option>
                                        <?
                                        $sql = $objQuery->SQLQuery("SELECT DISTINCT estado FROM  vsites_cidades as C ORDER BY estado");
                                        while($res = mysql_fetch_array($sql)){
                                            echo '<option value="'.$res['estado'].'"';
                                            if($conjuge_estado==$res['estado']) echo 'selected="selected"'; 
                                            echo '>'.$res['estado'].'</option>';
                                        }
                                        ?>
                                    </select>
                                <? }?></div>
                                <div style="width:440px"><?
                                    echo 'Cidade:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$conjuge_end_cidade.'</span>';
									else
	                                    echo '<input name="conjuge_end_cidade" type="text" class="form_estilo" id="conjuge_end_cidade" style="width:424px" value="'.$conjuge_end_cidade.'" maxlength="100" />';
                                ?></div>
                                <div style="width:200px"><?
                                    echo 'CEP:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$conjuge_end_cep.'</span>';
									else
	                                    echo '
                                    <input name="conjuge_end_cep" type="text" class="form_estilo" id="conjuge_end_cep" style="width:184px" value="'.$conjuge_end_cep.'" maxlength="9" />';
                                ?></div>
                            </div>
                            <!--FIM DADOS PESSOAIS DO CÔNJUGE SE HOUVER-->
                            
                            <!--ENDEREÇO ATUAL DO SOLICITANTE-->
                            <a name="ancor13"></a>
                            <div class="styler2" style="margin-top:10px;">
                                <p id="tt23" class="styler3" style="margin-top:10px;"></p>
                            </div>
                            <div id="dt23">
                                <div style="height:10px; width:756px;"></div>
                                <div style="width:350px; margin-left:14px;"><?
                                    echo 'Endereço: <span style="color:#FF0000;">*</span><br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$endereco.'</span>';
									else
	                                    echo '<input name="endereco" type="text" class="form_estilo" id="endereco" style="width:334px" value="'.$endereco.'" maxlength="100" />';
                                ?></div>
                                <div style="width:70px"><?
                                    echo 'Nº: <span style="color:#FF0000;">*</span><br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$numero.'</span>';
									else
	                                    echo '<input name="numero" type="text" class="form_estilo" id="numero" style="width:54px" value="'.$numero.'" maxlength="10" />';
                                ?></div>
                                <div style="width:120px"><?
                                    echo 'Complemento:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$complemento.'</span>';
									else
	                                    echo '<input name="complemento" type="text" class="form_estilo" id="complemento" style="width:104px" value="'.$complemento.'" maxlength="40" />';
                                ?></div>
                                <div style="width:200px"><?
                                    echo 'Bairro: <span style="color:#FF0000;">*</span><br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$bairro.'</span>';
									else
	                                    echo '<input name="bairro" type="text" class="form_estilo" id="bairro" style="width:184px" value="'.$bairro.'" maxlength="50" />';
                                ?></div>
                                <div style="height:10px; width:756px;"></div>
                                
                                <div style="width:100px; margin-left:14px;"><?
                                    echo 'Estado: <span style="color:#FF0000;">*</span><br />';
									if($id_status == 14){
										echo '<span style="font-weight:normal">'.$estado.'</span>';
									}else{?>
                                    <select style="width:84px" class="form_estilo" id="estado" name="estado">
                                        <option value="<?= $estado ?>">UF</option>
                                        <?
                                        $sql = $objQuery->SQLQuery("SELECT DISTINCT estado FROM  vsites_cidades as C ORDER BY estado");
                                        while($res = mysql_fetch_array($sql)){
                                            echo '<option value="'.$res['estado'].'"';
                                            if($estado==$res['estado']) echo 'selected="selected"'; 
                                            echo '>'.$res['estado'].'</option>';
                                        }
                                        ?>
                                    </select>
                                <? }?></div>
                                <div style="width:440px"><?
                                    echo 'Cidade: <span style="color:#FF0000;">*</span><br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$cidade.'</span>';
									else
	                                    echo '<input name="cidade" type="text" class="form_estilo" id="cidade" style="width:424px" value="'.$cidade.'" maxlength="120" />';
                                ?></div>
                                <div style="width:200px"><?
                                    echo 'CEP: <span style="color:#FF0000;">*</span><br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$cep.'</span>';
									else
	                                    echo '<input name="cep" type="text" class="form_estilo" id="cep" style="width:184px" value="'.$cep.'" maxlength="9" />';
                                ?></div>
                                <div style="height:10px; width:756px;"></div>
                                
                                <div style="width:370px; margin-left:14px;"><?
                                    echo 'Tipo do Imóvel:<br />';
									if($id_status == 14){
										switch($tip_imovel){
											case 1: echo '<span style="font-weight:normal">Própria</span>'; break;
											case 2: echo '<span style="font-weight:normal">Alugada</span>'; break;
											case 3: echo '<span style="font-weight:normal">Familiares</span>'; break;
										}
									}else{?>
                                    <select style="width:354px" class="form_estilo" name="tip_imovel" id="tip_imovel">
                                        <option value="0">.:SELECIONE:.</option>
                                        <option value="1" <? if($tip_imovel == 1){ ?> selected="selected" <? } ?>>Própria</option>
                                        <option value="2" <? if($tip_imovel == 2){ ?> selected="selected" <? } ?>>Alugada</option>
                                        <option value="3" <? if($tip_imovel == 3){ ?> selected="selected" <? } ?>>Familiares</option>
                                    </select>
                                <? }?></div>
                                <div style="width:370px"><?
                                    echo 'Reside na Praça Desde:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$reside_praca.'</span>';
									else
	                                    echo '<input name="reside_praca" type="text" class="form_estilo" id="reside_praca" style="width:354px" value="'.$reside_praca.'" maxlength="25" />';
                                ?></div>
                            </div>
                            <!--FIM ENDEREÇO ATUAL DO SOLICITANTE-->
                            
                            <!--ENDEREÇO ANTERIOR DO SOLICITANTE-->
                            <a name="ancor14"></a>
                            <div class="styler2" style="margin-top:10px;">
                                <p id="tt24" class="styler3" style="margin-top:10px;"></p>
                            </div>
                            <div id="dt24">
                                <div style="height:10px; width:756px;"></div>
                                <div style="width:350px; margin-left:14px;"><?
                                    echo 'Endereço: <span style="color:#FF0000;">*</span><br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$endereco2.'</span>';
									else
	                                    echo '<input name="endereco2" type="text" class="form_estilo" id="endereco2" style="width:334px" value="'.$endereco2.'" maxlength="100" />';
                                ?></div>
                                <div style="width:70px"><?
                                    echo 'Nº: <span style="color:#FF0000;">*</span><br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$numero2.'</span>';
									else
	                                    echo '<input name="numero2" type="text" class="form_estilo" id="numero2" style="width:54px" value="'.$numero2.'" maxlength="10" />';
                                ?></div>
                                <div style="width:120px"><?
                                    echo 'Complemento:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$coplemento2.'</span>';
									else
	                                    echo '<input name="complemento2" type="text" class="form_estilo" id="complemento2" style="width:104px" value="'.$complemento2.'" maxlength="40" />';
                                ?></div>
                                <div style="width:200px"><?
                                    echo 'Bairro: <span style="color:#FF0000;">*</span><br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$bairro2.'</span>';
									else
	                                    echo '
                                    <input name="bairro2" type="text" class="form_estilo" id="bairro2" style="width:184px" value="'.$bairro2.'" maxlength="50" />';
                                ?></div>
                                <div style="height:10px; width:756px;"></div>
                                
                                <div style="width:100px; margin-left:14px;"><?
                                    echo 'Estado: <span style="color:#FF0000;">*</span><br />';
									if($id_status == 14){
										echo '<span style="font-weight:normal">'.$estado2.'</span>';
									}else{?>
                                    <select style="width:84px" class="form_estilo" id="estado2" name="estado2">
                                        <option value="<?= $estado2 ?>">UF</option>
                                        <?
                                        $sql = $objQuery->SQLQuery("SELECT DISTINCT estado FROM  vsites_cidades as C ORDER BY estado");
                                        while($res = mysql_fetch_array($sql)){
                                            echo '<option value="'.$res['estado'].'"';
                                            if($estado2==$res['estado']) echo 'selected="selected"'; 
                                            echo '>'.$res['estado'].'</option>';
                                        }
                                        ?>
                                    </select>
                                <? }?></div>
                                <div style="width:440px"><?
                                    echo 'Cidade: <span style="color:#FF0000;">*</span><br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$cidade2.'</span>';
									else
	                                    echo '<input name="cidade2" type="text" class="form_estilo" id="cidade2" style="width:424px" value="'.$cidade2.'" maxlength="120" />';
                                ?></div>
                                <div style="width:200px"><?
                                    echo 'CEP: <span style="color:#FF0000;">*</span><br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$cep2.'</span>';
									else
	                                    echo '<input name="cep2" type="text" class="form_estilo" id="cep2" style="width:184px" value="'.$cep2.'" maxlength="9" />';
                                ?></div>
                            </div>
                            <!--FIM ENDEREÇO ANTERIOR DO SOLICITANTE-->
                            
                            <!--LAZER-->
                            <a name="ancor15"></a>
                            <div class="styler2" style="margin-top:10px;">
                                <p id="tt25" class="styler3" style="margin-top:10px;"></p>
                            </div>
                            <div id="dt25">
                                <div style="height:10px; width:756px;"></div>
                                <div style="width:756px; margin-left:14px;">
                                    <?
                                    $e = $dt->Lazer();
                                    $i = 0;
                                    if(count($rel_lazer) == 0){
                                        $rel_lazer = $lazer;
                                    }
                                    foreach($e as $j => $lz){
                                        $id_lazer[$i] = $lz->id_lazer;
                                        $lazer[$i]    = $lz->lazer;
                                        $i++;
                                    }
                                    
                                    $k = 1;
                                    
                                    
                                    for($i = 0; $i < count($id_lazer); $i++){
                                        for($j = 0; $j < 3; $j++){
                                            if($k <= count($id_lazer)){
                                                $check = 0;
                                                for($z = 0; $z < count($rel_lazer); $z++){
                                                    if($rel_lazer[$z] == $id_lazer[$k-1])
                                                        $check = 1;
                                                }
                                                echo '<div style="width:20px">';
                                                if($check == 1){
													if($id_status == 14){
                                                    	echo '';	
													} else	{
														echo '<input style="margin-top:-2px;" class="form_estilo" value="'.$id_lazer[$k-1].'" ';
                                                    	echo 'name="lazer[]" id="lazer'.$k.'" type="checkbox" checked="checked" />';
													}
                                                } else {
													if($id_status == 14){
														echo '';													
													} else {
														echo '<input style="margin-top:-2px;" class="form_estilo" value="'.$id_lazer[$k-1].'" ';
														echo 'name="lazer[]" id="lazer'.$k.'" type="checkbox" />';
													}
                                                }
                                                echo '</div>';
                                                echo '<div style="width:226px">';
												if($id_status == 14){
													if($check == 1)
														echo '<span style="font-weight:normal">'.$lazer[$k-1].'</span>';
												}else{
                                                	echo '<label for="lazer'.$k.'">'.$lazer[$k-1].'</label>';
                                                }
												echo '</div>';
                                                $k = $k + 1;
                                            }
                                        }
                                        echo '<div style="height:1px; width:740px;"></div>';									
                                    }?>				 
                                </div>
                            </div>
                            <!--FIM LAZER-->
                        </div>	
                    </div>
                    <!--FIM DADOS DO SOLICITANTE-->
                    <!--HISTÓRICO PROFISSIONAL E EMPRESARIAL-->
                    <a name="ancor2"></a>
                    <div style="margin-top:20px; width:756px; border:solid 1px #0071B6;">
                        <div class="styler1">
                            <p id="tt2" class="styler3" style="margin-top:10px;"></p>
                        </div>			
                        <div id="dt2" style="margin-top:5px;">
                            <!--EXPERIÊNCIA COM FRANQUIAS-->
                            <a name="ancor16"></a>
                            <div class="styler2" style="margin-top:4px;">
                                <p id="tt26" class="styler3" style="margin-top:10px;"></p>
                            </div>
                            <div id="dt26">
                                <div style="height:10px; width:756px;"></div>
                                <div style="width:370px; margin-left:14px;"><?
                                    echo 'DESEJA SER FRANQUEADO, SÓCIO E OU FIADOR?<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$franqueado.'</span>';
									else
	                                    echo '<input name="franqueado" type="text" class="form_estilo" id="franqueado" style="width:354px" value="'.$franqueado.'" maxlength="80" />';
                                ?></div> 
                                <div style="width:370px;"><?
                                    echo 'TEM EXPERIÊNCIA COM FRANQUIA?<br />';
									if($id_status == 14){
										if($experiencia == 1)
											echo '<span style="font-weight:normal">Sim</span>';
										else
											echo '<span style="font-weight:normal">Não</span>';
									}else{?>
                                    
                                    <p style="margin-top:2px; width:20px;"><input value="1" id="experiencia1" name="experiencia" type="radio" <? if($experiencia==1){ echo 'checked="checked"'; } ?> /></p>
                                    <p style="margin-top:4px; width:85px;"><label for="experiencia1">Sim</label></p>
                                    <p style="margin-top:2px; width:20px;"><input value="2" id="experiencia2" name="experiencia" type="radio" <? if($experiencia==2){ echo 'checked="checked"'; } ?>/></p>
                                    <p style="margin-top:4px; width:85px;"><label for="experiencia2">Não</label></p>
                                <? }?></div>
                                <div style="height:10px; width:756px;"></div>
                                <div style="width:370px; margin-left:14px;"><?
                                    echo '<br />SE NÃO QUAL O MOTIVO DE NÃO POSSUIR O NEGÓCIO?<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$motivo.'</span>';
									else
	                                    echo '<input name="motivo" type="text" class="form_estilo" id="motivo" style="width:354px" value="'.$motivo.'" maxlength="50" />';
                                ?></div>
                                <div style="width:370px;"><?
                                    echo 'SE SIM RESPONDA AS PERGUNTAS ABAIXO<br /> NÚMERO DE FUNCIONÁRIOS:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$funcionarios.'</span>';
									else
	                                    echo '<input name="funcionarios" type="text" class="form_estilo" id="funcionarios" style="width:354px" value="'.$funcionarios.'" maxlength="50" />';
                                ?></div>
                                <div style="height:10px; width:756px;"></div>
                                <div style="width:370px; margin-left:14px;"><?
                                    echo 'FATURAMENTO:<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$faturamento.'</span>';
									else
	                                    echo '<input name="faturamento " type="text" class="form_estilo" id="faturamento " style="width:354px" value="'.$faturamento.'" maxlength="50" />';
                                ?></div>
                                <div style="width:370px;"><?
                                    echo 'QUAL FRANQUIA?<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$qual_franquia.'</span>';
									else
	                                    echo '<input name="qual_franquia" type="text" class="form_estilo" id="qual_franquia" style="width:354px" value="'.$qual_franquia.'" maxlength="50" />';
                                ?></div>
                                <div style="height:10px; width:756px;"></div>
    
                                <div style="width:724px; margin-left:14px;"><?
                                    echo 'NA SUA OPINIÃO QUAIS OS FATORES DETERMINANTES PARA O SUCESSO DE UM NEGÓCIO?<br />';
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$opiniao.'</span>';
									else
	                                    echo '<input name="opiniao" type="text" class="form_estilo" id="opiniao" style="width:724px" value="'.$opiniao.'" maxlength="50" />';
                                ?></div>						
                            </div>
                            <!--FIM EXPERIÊNCIA COM FRANQUIAS-->
                            <!--HISTÓRICO PROFISSIONAL-->
                            <a name="ancor17"></a>
                            <div class="styler2" style="margin-top:10px;">
                                <p id="tt27" class="styler3" style="margin-top:10px;"></p>
                            </div>
                            <div id="dt27">
                                <div style="height:10px; width:756px;"></div>
                                <div style="width:756px;">
                                    <div style="width:370px; margin-left:14px;"><?
                                        echo 'EMPRESA: <span style="color:#FF0000;">*</span><br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$empresa_t.'</span>';
										else
	                                    	echo '<input name="empresa_t" type="text" class="form_estilo" id="empresa_t" style="width:354px" value="'.$empresa_t.'" maxlength="25" />';
                                    ?></div>
                                    <div style="width:370px;"><?
                                        echo 'CARGO ATUAL: <span style="color:#FF0000;">*</span><br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$cargo.'</span>';
										else
											echo '<input name="cargo" type="text" class="form_estilo" id="cargo" style="width:354px" value="'.$cargo.'" maxlength="25" />';
                                    ?></div> 
                                    <div style="height:10px; width:756px;"></div>
                                    
                                    <div style="width:756px; margin-left:14px;"><?
                                        echo 'FAÇA UM BREVE RELATO SOBRE SEU HISTÓRICO: <span style="color:#FF0000;">*</span><br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$historico.'</span>';
										else
											echo '<textarea id="historico" name="historico" class="form_estilo" style="width:724px; height:90px;">'.$historico.'</textarea>';
                                    ?></div> 
                                    <div style="height:10px; width:756px;"></div>
                                    
                                    <div style="width:247px; margin-left:14px;"><?
                                        echo 'PERÍODO: <span style="color:#FF0000;">*</span><br />';
										if($id_status == 14){
											echo '<span style="font-weight:normal">'.$periodo.'</span>';
										}else{?>
                                        <select style="width:231px;" class="form_estilo" name="periodo" id="periodo">
                                            <option value="">.:SELECIONE:.</option>
                                            <option value="6 meses a 1 ano" <? if($periodo=='6 meses a 1 ano') echo 'selected'; ?>>6 meses a 1 ano</option>
                                            <option value="1 ano a 5 anos" <? if($periodo=='1 ano a 5 anos') echo 'selected'; ?>>1 ano a 5 anos</option>
                                            <option value="5 anos a 10 anos" <? if($periodo=='5 anos a 10 anos') echo 'selected'; ?>>5 anos a 10 anos</option>
                                            <option value="acima de 10 anos" <? if($periodo=='acima de 10 anos') echo 'selected'; ?>>acima de 10 anos</option>
                                        </select>
                                    <? }?>
                                    </div>
                                    <div style="width:246px;"><?
                                        echo 'FUNCIONÁRIOS:<br />';
										if($id_status == 14){
											echo '<span style="font-weight:normal">'.$funcionarios.'</span>';
										}else{?>
                                        <select style="width:230px" class="form_estilo" name="funcionarios" id="funcionarios">
                                            <option value="">.:SELECIONE:.</option>
                                            <option value="1 a 5" <? if($funcionarios=='1 a 5') echo 'selected'; ?>>1 a 5</option>
                                            <option value="de 5 a 10" <? if($funcionarios=='de 5 a 10') echo 'selected'; ?>>de 5 a 10</option>
                                            <option value="de 10 a 50" <? if($funcionarios=='de 10 a 50') echo 'selected'; ?>>de 10 a 50</option>
                                            <option value="de 50 a 100" <? if($funcionarios=='de 50 a 100') echo 'selected'; ?>>de 50 a 100</option>
                                            <option value="acima de 100" <? if($funcionarios=='acima de 100') echo 'selected'; ?>>acima de 100</option>
                                        </select>
                                    <? }?></div>
                                    <div style="width:247px;"><?
                                        echo 'FATURAMENTO:<br />';
										if($id_status == 14){
											echo '<span style="font-weight:normal">'.$faturamento.'</span>';
										}else{?>
                                        <select style="width:231px" class="form_estilo" name="faturamento" id="faturamento">
                                            <option value="">.:SELECIONE:.</option>
                                            <option value="Até R$ 50 mil" <? if($faturamento=='Até R$ 50 mil') echo 'selected'; ?>>Até R$ 50 mil</option>
                                            <option value="R$ 50 a R$ 100 mil" <? if($faturamento=='R$ 50 a R$ 100 mil') echo 'selected'; ?>>R$ 50 a R$ 100 mil</option>
                                            <option value="R$ 100 a R$ 300 mil" <? if($faturamento=='R$ 100 a R$ 300 mil') echo 'selected'; ?>>R$ 100 a R$ 300 mil</option>
                                            <option value="R$ 300 a R$ 500 mil" <? if($faturamento=='R$ 300 a R$ 500 mil') echo 'selected'; ?>>R$ 300 a R$ 500 mil</option>
                                            <option value="Acima de R$ 500 mil" <? if($faturamento=='Acima de R$ 500 mil') echo 'selected'; ?>>Acima de R$ 500 mil</option>
                                        </select>
                                    <? }?></div>				
                                    <div style="height:10px; width:756px;"></div>
                                                
                                    <div style="width:247px; margin-left:14px;"><?
                                        echo 'CONTATO: <span style="color:#FF0000;">*</span><br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$contato.'</span>';
										else
											echo '<input name="contato" type="text" class="form_estilo" id="contato" style="width:231px" value="'.$contato.'" maxlength="50" />';
                                    ?></div>
                                    <div style="width:246px;"><?
                                        echo 'RAMO DE ATUAÇÃO:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$ramo_at.'</span>';
										else
											echo '<input id="ramo_at" maxlength="40" name="ramo_at" value="'.$ramo_at.'" type="text" style="width:230px" class="form_estilo" />';
                                    ?></div>
                                    <div style="width:247px;"><?
                                        echo 'NOME DA EMPRESA:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$empresa_p.'</span>';
										else
											echo '<input name="empresa_p" type="text" class="form_estilo" id="empresa_p" style="width:230px" value="'.$empresa_p.'" maxlength="50" />';
                                    ?></div>
                                    <div style="height:10px; width:756px;"></div>								
                                    
                                    <div style="width:370px; margin-left:14px;"><?
                                        echo 'CURSOS: <span style="color:#FF0000;">*</span><br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$cursos.'</span>';
										else
											echo '<input type="text" style="width:354px" class="form_estilo" maxlength="50" id="cursos" name="cursos" value="'.$cursos.'" />';
                                    ?></div> 
                                    <div style="width:370px;"><?
                                        echo 'GRAU DE ESCOLARIDADE:<br />';
									if($id_status == 14){
										echo '<span style="font-weight:normal">'.$escolaridade.'</span>';
									}else{?>
                                        <select style="width:354px" class="form_estilo" id="escolaridade" name="escolaridade">
                                            <option value="">.:SELECIONE:.</option>
                                              <option value="Ensino fundamental: Incompleto" <? if($escolaridade=='Ensino fundamental: Incompleto') echo 'selected'; ?>>Ensino fundamental: Incompleto</option>
                                              <option value="Ensino fundamental: Completo" <? if($escolaridade=='Ensino fundamental: Completo') echo 'selected'; ?>>Ensino fundamental: Completo</option>
                                              <option value="">----------------------------------------------------------</option>
                                              <option value="Ensino médio: Incompleto" <? if($escolaridade=='Ensino médio: Incompleto') echo 'selected'; ?>>Ensino médio: Incompleto</option>
                                              <option value="Ensino médio: Completo" <? if($escolaridade=='Ensino médio: Completo') echo 'selected'; ?>>Ensino médio: Completo</option>
                                              <option value="">----------------------------------------------------------</option>
                                              <option value="Ensino superior: Incompleto" <? if($escolaridade=='Ensino superior: Incompleto') echo 'selected'; ?>>Ensino superior: Incompleto</option>
                                              <option value="Ensino superior: Completo" <? if($escolaridade=='Ensino superior: Completo') echo 'selected'; ?>>Ensino superior: Completo</option>
                                              <option value="">----------------------------------------------------------</option>
                                              <option value="Pós graduação" <? if($escolaridade=='Pós graduação') echo 'selected'; ?>>Pós graduação</option>
                                              <option value="Mestrado" <? if($escolaridade=='Mestrado') echo 'selected'; ?>>Mestrado</option>
                                              <option value="Doutorado" <? if($escolaridade=='Doutorado') echo 'selected'; ?>>Doutorado</option>
                                              <option value="MBA" <? if($escolaridade=='MBA') echo 'selected'; ?>>MBA</option>
                                        </select>	
                                    <? }?></div> 
                                    <div style="height:10px; width:756px;"></div>
                                    
                                    <div style="width:295px; margin-left:14px;"><?
                                        echo 'QUAL FACULDADE:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$faculdade.'</span>';
										else
											echo '<input name="faculdade" type="text" class="form_estilo" id="faculdade" style="width:279px" value="'.$faculdade.'" maxlength="45" />';
                                    ?></div>
                                    <div style="width:150px;"><?
                                       echo 'ANO DE CONCLUSÃO:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$conclusao.'</span>';
										else
											echo '<input name="conclusao" type="text" class="form_estilo" id="conclusao" style="width:134px" value="'.$conclusao.'" maxlength="7" />';
                                    ?></div>  
                                    <div style="width:295px;"><?
                                        echo 'JÁ TEM OU TEVE NEGÓCIO PRÓPRIO?<br />';
                                        if($id_status == 14){
                                            echo '<span style="font-weight:normal">'.$negocios.'</span>';
                                        }else{?>
                                        <p style="margin-top:2px; width:20px;"><input id="negocios1" name="negocios" type="radio" value="Sim" <? if($negocios=='Sim') echo 'checked'; ?> /></p>
                                        <p style="margin-top:4px; width:85px;"><label for="negocios1">Sim</label></p>
                                        <p style="margin-top:2px; width:20px;"><input id="negocios2" name="negocios" type="radio" value="Não" <? if($negocios=='Não') echo 'checked'; ?> /></p>
                                        <p style="margin-top:4px; width:85px;"><label for="negocios2">Não</label></p>
                                    <? }?></div>
                                </div>
                            </div>
                            <!--FIM HISTÓRICO PROFISSIONAL-->
                            <!--SOBRE A FRANQUIA CARTÓRIO POSTAL-->
                            <a name="ancor18"></a>
                            <div class="styler2" style="margin-top:10px;">
                                <p id="tt28" class="styler3" style="margin-top:10px;"></p>
                            </div>
                            <div id="dt28">
                                <div style="height:10px; width:740px;"></div>
                                <div style="width:756px; margin-left:14px;">
                                    <div style="width:740px;">
                                        ENUMERE O QUE VOCÊ CONSIDERA IMPORTANTE NA FRANQUIA CARTÓRIO POSTAL SENDO QUE 
                                        O NÚMERO 1 É O MAIS IMPORTANTE:								
                                    </div> 
                                    <div style="height:10px; width:740px;"></div>
    
                                    <div style="width:66px;">
                                        <?php
                                        $e = $dt->EnumPergunta();
                                        $i = 0;
                                        foreach($e as $j => $ep){
                                            $id_pergunta[$i] = $ep->id_enum_perg;
                                            $pergunta[$i]    = $ep->pergunta;
                                            $i++;
                                        }
                                    	
                                        for($i = 0; $i < count($id_pergunta); $i++){
                                            $e = $dt->buscaRelEnumPergunta($id, $id_pergunta[$i]);
											if($id_status == 14){
												echo '<input readonly="readonly" value="'.$e->valor.'" type="text" class="form_estilo" style="text-align:center; width:50px; border:none; background-color:#FFFFFF; background:none; margin-top:3px" />';
											}else{?>
                                            <input type="hidden" value="<?=$id_pergunta[$i]?>" name="id_pergunta<?=$i?>" id="id_pergunta<?=$i?>" />
                                            <input onKeyUp="masc_numeros(this,'#');" name="pergunta<?=$i?>" id="pergunta<?=$i?>" value="<?=$e->valor?>" type="text" class="form_estilo" maxlength="1" style="text-align:center; width:50px" /><br />		
                                        <? }} ?>
                                            <input type="hidden" value="<?=$i?>" name="id_pergunta_total" id="id_pergunta_total" />
                                    </div>
                                    <div style="width:670px;">
                                        <? for($i = 0; $i < count($id_pergunta); $i++){?>
                                            <p style="margin-top:6px; margin-bottom:5px;"><?=$pergunta[$i]?></p>
                                        <? } ?>									
                                    </div>
                                    <div style="height:10px; width:740px;"></div>
    
                                    <div style="width:740px;"><?
                                        echo 'COMO CONHECEU AS FRAQUIAS CARTÓRIO POSTAL:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$conheceu_cp.'</span>';
										else
											echo '<textarea class="form_estilo" style="width:724px; height:90px;" id="conheceu_cp" name="conheceu_cp">'.$conheceu_cp.'</textarea>';
                                    ?></div>
                                    <div style="height:10px; width:740px;"></div>
    
                                    <div style="width:290px;"><?
                                        echo '<br />JÁ ESTEVE EM UMA DE NOSSAS UNIDADES?<br />';
										if($id_status == 14){
											echo '<span style="font-weight:normal">'.$unidades.'</span>';
										}else{?>
                                        <p style="margin-top:2px; width:20px;"><input id="unidades1" name="unidades" type="radio" value="Sim" <? if($unidades=='Sim') echo 'checked'; ?> /></p>
                                        <p style="margin-top:4px; width:85px;"><label for="unidades1">Sim</label></p>
                                        <p style="margin-top:2px; width:20px;"><input id="unidades2" name="unidades" type="radio" value="Não" <? if($unidades=='Não') echo 'checked'; ?> /></p>
                                        <p style="margin-top:4px; width:85px;"><label for="unidades2">Não</label></p>
                                    <? }?></div>
                                    <div style="width:166px;"><?
                                        echo '<br />QUAL?<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$unidades_valor.'</span>';
										else
	                                    	echo '<input type="text" style="width:150px" class="form_estilo" id="unidades_valor" name="unidades_valor" maxlength="25" value="'.$unidades_valor.'" />';
                                    ?></div>
                                    <div style="width:280px;"><?
                                        echo'DESEJA RECEBER COMUNICADOS DE OUTRAS EMPRESAS DA REDE?<br />';
										if($id_status == 14){
											echo '<span style="font-weight:normal">'.$comunicados.'</span>';
										}else{?>
                                        <p style="margin-top:2px; width:20px;"><input id="comunicados1" name="comunicados" type="radio" value="Sim" <? if($comunicados=='Sim') echo 'checked'; ?> /></p>
                                        <p style="margin-top:4px; width:85px;"><label for="comunicados1">Sim</label></p>
                                        <p style="margin-top:2px; width:20px;"><input id="comunicados2" name="comunicados" type="radio" value="Não" <? if($comunicados=='Não') echo 'checked'; ?> /></p>
                                        <p style="margin-top:4px; width:85px;"><label for="comunicados2">Não</label></p>
                                    <? }?></div>
    
                                    <div style="width:370px;"><?
                                        echo '<br />PORQUE O INTERESSE EM SER UM FRANQUEADO?<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$interesse.'</span>';
										else
	                                    	echo '<textarea class="form_estilo" style="width:724px; height:90px;" id="interesse" name="interesse">'.$interesse.'</textarea>';
                                    ?></div>
                                    <div style="height:10px; width:740px;"></div>
    
                                    <div style="width:740px;">SELECIONE O ESTADO E A CIDADE DE INTERESSE:</div>
                                    <div style="width:100px;"><?
										if($id_status == 14){
											echo '<span style="font-weight:normal">'.$estado_interesse.'</span>';
										}else{?>
                                        <select style="width:84px" class="form_estilo" name="estado_interesse" id="estado_interesse">
                                        <option value="<?= $estado_interesse ?>">UF</option>
                                            <?
                                            $sql = $objQuery->SQLQuery("SELECT DISTINCT estado FROM  vsites_cidades as C ORDER BY estado");
                                            while($res = mysql_fetch_array($sql)){
                                                echo '<option value="'.$res['estado'].'"';
                                                if($estado_interesse==$res['estado']) echo 'selected="selected"'; 
                                                echo '>'.$res['estado'].'</option>';
                                            }
                                        ?></select>
                                    <? }?></div>
                                    <div style="width:650px;"><?
									if($id_status == 14)
										echo '<span style="font-weight:normal">'.$cidade_interesse.'</span>';
									else
	                                    echo '<input type="text" style="width:624px" class="form_estilo" id="cidade_interesse" name="cidade_interesse" value="'.$cidade_interesse.'" maxlength="120" />';
                                    ?></div>
                                    <div style="height:10px; width:740px;"></div>
    
                                    <div style="width:740px;"><?
                                        echo 'SEU ESPAÇO PARA OBSERVAÇÕES?<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$observacao.'</span>';
										else
	                                    	echo '<textarea class="form_estilo" style="width:724px; height:90px;" id="observacao" name="observacao">'.$observacao.'</textarea>';
                                    ?></div>
                                    <div style="height:10px; width:740px;"></div>
                                </div>
                            </div>
                            <!--FIM SOBRE A FRANQUIA CARTÓRIO POSTAL-->
                        </div>
                    </div>
                    <!--FIM HISTÓRICO PROFISSIONAL E EMPRESARIAL-->
                    <!--INFORMAÇÕES FINANCEIRAS E ADICIONAIS-->
                    <a name="ancor3"></a>
                    <div style="margin-top:20px; width:756px; border:solid 1px #0071B6;">
                        <div class="styler1">
                            <p id="tt3" class="styler3" style="margin-top:10px;"></p>
                        </div>
                        <div id="dt3" style="margin-top:5px;">
                            <!--INFORMAÇÕES FINANCEIRAS-->
                            <a name="ancor19"></a>
                            <div class="styler2" style="margin-top:4px;">
                                <p id="tt29" class="styler3" style="margin-top:10px;"></p>
                            </div>
                            <div id="dt29">
                                <div style="height:10px; width:756px;"></div>
                                <div style="width:756px; margin-left:14px;">
                                    <div style="width:370px;"><?
                                        echo 'TEM CAPITAL IMEDIATO DISPONÍVEL PARA INVESTIR?<br />';
										if($id_status == 14){
											echo '<span style="font-weight:normal">'.$capital.'</span>';
										}else{?>
	                                    	echo '
                                        <p style="margin-top:2px; width:20px;"><input id="capital1" name="capital" type="radio" value="Sim" <? if($capital=='Sim') echo 'checked'; ?> /></p>
                                        <p style="margin-top:4px; width:85px;"><label for="capital1">Sim</label></p>
                                        <p style="margin-top:2px; width:20px;"><input id="capital2" name="capital" type="radio" value="Não" <? if($capital=='Não') echo 'checked'; ?> /></p>
                                        <p style="margin-top:4px; width:85px;"><label for="capital2">Não</label></p>
                                    <? }?></div>
                                    <div style="width:370px;"><?
                                        echo 'VALOR DISPONÍVEL:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$valor_disp.'</span>';
										else
	                                    	echo '<input onKeyPress="moeda(this);" type="text" style="width:354px" id="valor_disp" name="valor_disp" class="form_estilo" maxlength="14" value="'.$valor_disp.'" />';
                                    ?></div>
                                    <div style="height:10px; width:740px;"></div>
                                    <div style="width:740px;"><?
                                        echo 'INFORME SE DEPENDE DE EMPRÉSTIMO OU VENDA DE BENS PARA INVESTIR ';
                                        echo 'EM SUA FRANQUIA CARTÓRIO POSTAL:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$emprestimo.'</span>';
										else
	                                    	echo '<textarea style="width:724px" class="form_estilo" id="emprestimo" name="emprestimo">'.$emprestimo.'</textarea>';
                                    ?></div>
                                    <div style="height:10px; width:740px;"></div>
                                    <div style="width:740px;"><?
                                        echo 'INFORME SE O CAPITAL CITADO FOR DE TERCEIROS:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$capital_terc.'</span>';
										else
	                                    	echo '<textarea class="form_estilo" style="width:724px; height:90px;" id="capital_terc" name="capital_terc">'.$capital_terc.'</textarea>';
                                    ?></div>  
                                    <div style="height:10px; width:740px;"></div>								
                                    <div style="width:370px;"><?
                                        echo 'QUANDO PRETENDE DAR INÍCIO AO NEGÓCIO?<br />';
										if($id_status == 14){
											echo '<span style="font-weight:normal">'.$inicio_neg.'</span>';
										}else{?>
                                        <select class="form_estilo" style="width:354px" id="inicio_neg" name="inicio_neg">
                                            <option value="">.:SELECIONE:.</option>
                                            <option value="Imediato" <? if($inicio_neg=='Imediato') echo 'selected'; ?>>Imediato</option>
                                            <option value="2 meses" <? if($inicio_neg=='2 meses') echo 'selected'; ?>>2 meses</option>
                                            <option value="4 meses" <? if($inicio_neg=='4 meses') echo 'selected'; ?>>4 meses</option>
                                            <option value="6 meses" <? if($inicio_neg=='6 meses') echo 'selected'; ?>>6 meses</option>
                                            <option value="8 meses" <? if($inicio_neg=='8 meses') echo 'selected'; ?>>8 meses</option>
                                            <option value="acima de 8 meses" <? if($inicio_neg=='acima de 8 meses') echo 'selected'; ?>>acima de 8 meses</option>
                                        </select>
                                    <? }?></div>   
                                    <div style="width:370px;"><?
                                        echo 'QUAL O SEU TEMPO DEDICADO A FRANQUIA?<br />';
										if($id_status == 14){
											echo '<span style="font-weight:normal">'.$dedicado_franq.'</span>';
										}else{?>
                                        <p style="margin-top:2px; width:20px;"><input id="dedicado_franq1" name="dedicado_franq" type="radio" value="Integral" <? if($dedicado_franq=='Integral') echo 'checked'; ?> /></p>
                                        <p style="margin-top:4px; width:70px;"><label for="dedicado_franq1">Integral</label></p>
                                        <p style="margin-top:2px; width:20px;"><input id="dedicado_franq2" name="dedicado_franq" type="radio" value="Parcial" <? if($dedicado_franq=='Parcial') echo 'checked'; ?> /></p>
                                        <p style="margin-top:4px; width:70px;"><label for="dedicado_franq2">Parcial</label></p>
                                        <p style="margin-top:2px; width:20px;"><input id="dedicado_franq3" name="dedicado_franq" type="radio" value="Como Investidor" <? if($dedicado_franq=='Como Investidor') echo 'checked'; ?> /></p>
                                        <p style="margin-top:4px; width:120px;"><label for="dedicado_franq3">Como Investidor</label></p>
                                    <? }?></div> 
                                    <div style="height:10px; width:740px;"></div>
                                    <div style="width:370px;"><?
                                        echo 'A FRANQUIA SERÁ A PRINCIPAL FONTE DE RENDA?<br />';
										if($id_status == 14){
											echo '<span style="font-weight:normal">'.$fonte_renda.'</span>';
										}else{?>
                                        <p style="margin-top:2px; width:20px;"><input id="fonte_renda1" name="fonte_renda" type="radio" value="Sim" <? if($fonte_renda=='Sim') echo 'checked'; ?> />
                                        </p>
                                        <p style="margin-top:4px; width:70px;"><label for="fonte_renda1">Sim</label></p>
                                        <p style="margin-top:2px; width:20px;"><input id="fonte_renda2" name="fonte_renda" type="radio" value="Não" <? if($fonte_renda=='Não') echo 'checked'; ?> />
                                      </p>
                                        <p style="margin-top:4px; width:70px;"><label for="fonte_renda2">Não</label></p>
                                        <p style="margin-top:2px; width:20px;"><input id="fonte_renda3" name="fonte_renda" type="radio" value="Temporariamente" <? if($fonte_renda=='Temporariamente') echo 'checked'; ?> /></p>
                                        <p style="margin-top:4px; width:120px;">
                                          <label for="fonte_renda3">Temporariamente</label>
                                        </p>
                                    <? }?></div> 
                                    <div style="width:370px;"><?
                                        echo 'PRETENDE TER SÓCIOS? ESPECIFIQUE:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$socios.'</span>';
										else
	                                    	echo '<input type="text" style="width:354px" class="form_estilo" id="socios" name="socios" value="'.$socios.'" maxlength="50" />';
                                    ?></div>
                                    <div style="height:7px; width:740px;"></div>
                                </div>
                            </div>
                            <!--FIM INFORMAÇÕES FINANCEIRAS-->
                            <!--REFERENCIAS BANCÁRIAS-->
                            <a name="ancor110"></a>
                            <div class="styler2" style="margin-top:10px;">
                                <p id="tt210" class="styler3" style="margin-top:10px;"></p>
                            </div>
                            <div id="dt210">
                                <div style="height:10px; width:756px;"></div>
                                <div style="width:756px; margin-left:14px;">
                                    <div style="width:260px;"><?
                                        echo 'BANCO:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$banco.'</span>';
										else
	                                    	echo '<input type="text" style="width:244px" class="form_estilo" maxlength="60" id="banco" name="banco" value="'.$banco.'" />';
                                    ?></div>   
                                    <div style="width:180px;"><?
                                        echo 'CARTÃO DE CRÉDITO:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$cartao_credito.'</span>';
										else
	                                    	echo '<input type="text" style="width:164px" class="form_estilo" maxlength="40" id="cartao_credito" name="cartao_credito" value="'.$cartao_credito.'" />';
                                    ?></div>
                                    <div style="width:150px;"><?
                                        echo 'VENCIMENTO:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$vencimento.'</span>';
										else
	                                    	echo '<input type="text" maxlength="7" style="width:134px" class="form_estilo" id="vencimento" name="vencimento" value="'.$vencimento.'" />';
                                    ?></div> 
                                    <div style="width:150px;"><?
                                        echo 'LIMITE:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$limite.'</span>';
										else
	                                    	echo '<input type="text" style="width:134px" class="form_estilo" id="limite" name="limite" value="'.$limite.'" maxlength="14" />';
                                    ?></div> 								
                                    <div style="height:10px; width:740px;"></div>							  
                                    <div style="width:120px;"><?
                                        echo 'TELEFONE:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$telefone_banco.'</span>';
										else
	                                    	echo '<input type="text" style="width:104px" maxlength="14" class="form_estilo" id="telefone_banco" name="telefone_banco" value="'.$telefone_banco.'" />';
                                    ?></div>   
                                    <div style="width:370px;"><?
                                        echo 'NOME DO GERENTE:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$nome_gerente.'</span>';
										else
	                                    	echo '<input type="text" style="width:354px" class="form_estilo" id="nome_gerente" name="nome_gerente" value="'.$nome_gerente.'" maxlength="50" />';
                                    ?></div>
                                    <div style="width:250px;"><?
                                        echo 'AGENCIA E CONTA:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$agencia_conta.'</span>';
										else
	                                    	echo '<input type="text" style="width:234px" class="form_estilo" maxlength="25" id="agencia_conta" name="agencia_conta" value="'.$agencia_conta.'" />';
                                    ?></div>
                                    <div style="height:7px; width:740px;"></div>
                                </div>
                            </div>
                            <!--FIM REFERENCIAS BANCÁRIAS-->
                            <!--DEMONSTRATIVO DE RENDIMENTO-->
                            <a name="ancor111"></a>
                            <div class="styler2" style="margin-top:10px;">
                                <p id="tt211" class="styler3" style="margin-top:10px;"></p>
                            </div>
                            <div id="dt211">
                                <div style="height:10px; width:756px;"></div>
                                <div style="width:756px; margin-left:14px;">
                                    <div style="width:247px;"><?
                                        echo 'HONORÁRIOS:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$honorarios.'</span>';
										else
	                                    	echo '<input type="text" style="width:231px" class="form_estilo" maxlength="50" id="honorarios" name="honorarios" value="'.$honorarios.'" />';
                                    ?></div>
                                    <div style="width:236px;"><?
                                        echo 'SALÁRIOS:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$salarios.'</span>';
										else
	                                    	echo '<input type="text" style="width:220px" class="form_estilo" maxlength="50" id="salarios" name="salarios" value="'.$salarios.'" />';
                                    ?></div>   
                                    <div style="width:257px;"><?
                                        echo 'COMISSÕES:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$comissoes.'</span>';
										else
	                                    	echo '<input type="text" style="width:241px" class="form_estilo" maxlength="50" id="comissoes" name="comissoes" value="'.$comissoes.'" />';
                                    ?></div> 
                                    <div style="height:10px; width:740px;"></div>
                                    
                                    <div style="width:247px;"><?
                                        echo 'SALÁRIO DO CONJUGE:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$salario_conjuge.'</span>';
										else
	                                    	echo '<input type="text" style="width:231px" class="form_estilo" maxlength="50" id="salario_conjuge" name="salario_conjuge" value="'.$salario_conjuge.'" />';
                                    ?></div>   
                                    <div style="width:236px;"><?
                                        echo 'RENDA DE ALUGUÉIS:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$renda_alugueis.'</span>';
										else
	                                    	echo '<input type="text" style="width:220px" class="form_estilo" maxlength="50" id="renda_alugueis" name="renda_alugueis" value="'.$renda_alugueis.'" />';
                                    ?></div>   
                                    <div style="width:257px;"><?
                                        echo 'POSSUI EMPRESTIMOS FINANCEIROS:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$emprestimo_financeiro.'</span>';
										else
	                                    	echo '<input type="text" style="width:241px" class="form_estilo" maxlength="50" id="emprestimo_financeiro" name="emprestimo_financeiro" value="'.$emprestimo_financeiro.'" />';
                                    ?></div>
                                    <div style="height:7px; width:740px;"></div>
                                </div>
                            </div>
                            <!--FIM DEMONSTRATIVO DE RENDIMENTO-->
                            <!--BENS DE CONSUMO-->
                            <a name="ancor112"></a>
                            <div class="styler2" style="margin-top:10px;">
                                <p id="tt212" class="styler3" style="margin-top:10px;"></p>
                            </div>
                            <div id="dt212">
                                <div style="height:10px; width:756px;"></div>
                                <div style="width:756px; margin-left:14px;">
                                    <div style="width:247px;"><?
                                        echo 'MODELO DO VEÍCULO:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$modelo_veiculo.'</span>';
										else
	                                    	echo '<input type="text" style="width:231px" class="form_estilo" maxlength="50" name="modelo_veiculo" id="modelo_veiculo" value="'.$modelo_veiculo.'" />';
                                    ?></div>  
                                    <div style="width:246px;"><?
                                        echo 'MARCA DO VEÍCULO:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$marca_veiculo.'</span>';
										else
	                                    	echo '<input type="text" style="width:230px" class="form_estilo" maxlength="50" name="marca_veiculo" id="marca_veiculo" value="'.$marca_veiculo.'" />';
                                    ?></div>   
                                    <div style="width:247px;"><?
                                        echo 'ANO DO VEÍCULO:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$ano_veiculo.'</span>';
										else
	                                    	echo '<input type="text" style="width:231px" class="form_estilo" maxlength="10" name="ano_veiculo" id="ano_veiculo" value="'.$ano_veiculo.'" />';
                                    ?></div>   
                                    <div style="height:10px; width:740px;"></div>
                                    <div style="width:247px;"><?
                                        echo 'PLACA DO VEÍCULO:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$placa_veiculo.'</span>';
										else
	                                    	echo '<input type="text" style="width:231px; text-transform:uppercase;" class="form_estilo" maxlength="10" name="placa_veiculo" id="placa_veiculo" value="'.$placa_veiculo.'" />';
                                    ?></div>   
                                    <div style="width:246px;"><?
                                        echo 'VALOR DO VEÍCULO:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$valor_veiculo.'</span>';
										else
	                                    	echo '<input type="text" style="width:230px" class="form_estilo" maxlength="25" name="valor_veiculo" id="valor_veiculo" value="'.$valor_veiculo.'" />';
                                    ?></div>   
                                    <div style="width:247px;"><?
                                        echo 'FINANCIADO?<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$financiado.'</span>';
										else
	                                    	echo '<input type="text" style="width:231px" class="form_estilo" maxlength="50" name="financiado" id="financiado" value="'.$financiado.'" />';
                                    ?></div>   
                                    <div style="height:10px; width:740px;"></div>
                                    <div style="width:247px;"><?
                                        echo 'IMÓVEL:<br />';
										if($id_status == 14){
											echo '<span style="font-weight:normal">'.$comissoes.'</span>';
										}else{?>
                                        <select style="width:231px" class="form_estilo" name="imovel" id="imovel">
                                            <option value="">:.Selecione</option>
                                            <option value="Própria" <? if($imovel == 'Própria'){ ?> selected="selected" <? } ?> >Próprio</option>
                                            <option value="Alugada" <? if($imovel == 'Alugada'){ ?> selected="selected" <? } ?> >Alugado</option>
                                        </select>
                                    <? }?></div>
                                    <div style="width:246px;"><?
                                        echo 'VALOR VENAL:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$valor_venal.'</span>';
										else
	                                    	echo '<input type="text" style="width:230px" class="form_estilo" maxlength="25" name="valor_venal" id="valor_venal" value="'.$valor_venal.'" />';
                                    ?></div>     
                                    <div style="width:247px;"><?
                                        echo 'SOMATÓRIA DO VALOR FINANCIADO:<br />';
										if($id_status == 14)
											echo '<span style="font-weight:normal">'.$somatoria.'</span>';
										else
	                                    	echo '<input type="text" style="width:231px" class="form_estilo" maxlength="25" name="somatoria" id="somatoria" value="'.$somatoria.'" />';
                                    ?></div>
                                    <div style="height:10px; width:740px;"></div>
                                </div>
                            </div>
                            <!--FIM BENS DE CONSUMO-->
                        </div>
                    </div>
                    <!--FIM INFORMAÇÕES FINANCEIRAS E ADICIONAIS-->
                </div>		
                <? if($id_status != 14) {?>
                <div style="margin-top:10px; margin-left:9px; margin-bottom:20px;">              	
                   	<input name="submit1" id="submit1" type="submit" value="Alterar" style="width:90px; margin-left:669px;" />
                </div>
                <? }?>
            </form>
         </td>
        </tr>
        <tr>
       	  <td align="left" valign="middle" class="interessados" id="form_status" style="display:<?=$dsp2?>;">
          	<form name="form_interesse" action="novos_interessados_edit.php?id=<?= $id;?>" method="post" enctype="multipart/form-data">
                <div style="margin-left:10px;">		
                    <div style="width:199px; margin-top:10px;">
                        <img src="../images/aba_novos_interessados_status.png" border="0" usemap="#Map" style="margin-left:0;" width="199" />                    
                    </div>	
                    <div style="width:559px; margin-top:10px; height:27px; border-bottom:solid 1px #666666">&nbsp;</div>
                    <div style="background:#0071B6; width:758px; color:#FFF; height:30px;">
                        <p style="margin-top:10px; text-align:center; width:98.7%;">
                            CADASTRO DE NOVOS INTERESSADOS		
                        </p>
                    </div>	
                    <div style="width:756px; margin-top:10px;">
                        <div  style="border: solid 1px #0071B6;">
                            <div class="styler1">
                            <p class="styler3" style="margin-top:10px; margin-left:14px; font-weight:normal">Status</p>
                            </div>
                            <? if($erro_sub2 > 0){?>
                            <div style="color:#FF0000; border-bottom:solid 1px #0071B6; width:756px;">
                            <p style="margin:10px; width:746px;"><?= $error2 ?><img src="../images/null.gif" border="0" height="1" width="1" onload="<?=$funcao2?>" /></p>
                            </div>			
                            <? } ?>
                            <div style="margin-top:10px;">
                            <div class="styler2">
                            <p class="styler3" style="margin-top:10px; margin-left:14px; font-weight:normal"><?	
                            $d = $dt->buscaIDStatus($id);							
                            $e = $dt1->buscaStatus($d->id_status);
                            echo $e->status;
                            if(!$submit2){
                            $observacao_expansao = $d->observacao_expansao;
                            }
                            ?></p>
                            </div>
                            <? if($id_status != 14){ ?>
                            <div style="margin-left:14px; margin-top:10px; width:356px;">
                            ALTERAR STATUS: <span style="color:#FF0000;">*</span><br />
                            <select id="id_status" name="id_status" class="form_estilo" style="width:354px;" onchange="VerificaStatus(this.value)">
                            <? if($id_status != 14 && $id_status != 13){?>
                            <option value="0">.:SELECIONE:.</option>
                            <?
                            }
                            $e = $dt1->buscaRelStatus($d->id_status);									
                            foreach($e as $j => $brs){?>
                            <option value="<?= $brs->id_status?>" <? if($id_status == $brs->id_status){?> selected="selected" <? } ?>><?=$brs->status?></option>
                            <? }									
                            if($id_status != 16 && $id_status != 14 && $id_status != 13){?>
                            <option value="16">Cancelar</option>
                            <? } ?>
                            </select>
                            </div>
                            <div style="margin-left:14px; margin-top:10px; width:356px; display:<?=$dsp3?>;" id="reuniao_agendada">
                            Data da Reunião: <span style="color:#FF0000;">*</span><br />
                            <input type="text" style="width:356px;" class="form_estilo" maxlength="10" id="data_reuniao" name="data_reuniao" value="<?=$data_reuniao?>" />
                            </div>
                            <div style="height:10px; width:756px;"></div>
                            <div style="margin-left:14px; margin-top:10px;">
                            ANOTAÇÕES SOBRE ESTE CADASTRO: <span style="color:#FF0000;" id="anotacao_obrigatoria"></span><br />
                            <textarea id="observacao_expansao" name="observacao_expansao" class="form_estilo" style="width:726px; height:120px;"><?
                            if($id_status == 14){
                            echo $observacao_expansao;
                            }?></textarea>
                            </div>
                            <div style="height:10px; width:756px;"></div>
                            <? }?>
                            </div>
                        </div>
                        <div style="margin-top:10px;"><? 
							if($id_status == 14) 
								echo '<p style="margin-top:10px; margin-bottom:0; margin-left:669px; width:90px;">&nbsp;</p>';
							else 
								echo '<input name="submit2" id="submit2" type="submit" value="Alterar" style="width:90px; margin-left:669px;" />';
                        ?></div>
                        <div style="font-weight:normal;">
                        	<div id="abre_historico"><a href="#historico" onclick="VisualizarHistorico(1, <?=$id?>);">+ Visualizar Histórico</a><a name="historico"></a><br /></div>
                            <div id="hist" style="margin-top:10px; font-weight:normal; text-transform:none;"></div>
                        </div>
                     </div>
                </div>
          	</form>
          </td>
        </tr>
        </table>
    </td>
  </tr>
</table></td>
  </tr>
</table>
<map name="MapAba1" id="MapAba1">
<area shape="rect" coords="100,0,199,31" href="#Status" title="Status" onclick="document.getElementById('form_interessados').style.display='none'; document.getElementById('form_status').style.display='block';" />
</map>
<map name="Map" id="Map">
<area shape="rect" coords="-100,0,101,31" href="#Cadastro" title="Cadastro" onclick="document.getElementById('form_interessados').style.display='block'; document.getElementById('form_status').style.display='none';" />
</map>
<?
require "../includes/rodape.php";
?>