<? 
$id_meta=1;
$pg = 'paginas';
require_once 'includes/url.php';
require_once(URL_SITE_INCLUDE.'header.php');

pt_register('POST','id_afiliado');		
#pt_register('POST','submit_pedido');
if($id_afiliado==5){
	pt_register('POST','id_servico');
	pt_register('GET','id');
	unset($_SESSION['p']);
	unset($_SESSION['id_pedido']);
	$p = $_SESSION['p'];
	//if($id<>'' and $id_servico=='') $id_servico=$id;
	//setcookie("id_afiliado", $id_afiliado);

	$pedidoDAO = new PedidoDAO();
	$servicosDAO = new ServicoDAO();
	$servicocampos = $servicosDAO->listaCamposSite($id_servico);


		$errors=array();
		$error="<b>Ocorreram os seguintes erros:</b><ul>";
		pt_register('POST','nome');
		pt_register('POST','tel2');
		pt_register('POST','tel');
		pt_register('POST','ramal2');
		pt_register('POST','ramal');
		pt_register('POST','fax');
		pt_register('POST','outros');
		pt_register('POST','email');
		pt_register('POST','cpf');
		pt_register('POST','rg');
		pt_register('POST','tipo');
		pt_register('POST','complemento');
		pt_register('POST','numero');
		pt_register('POST','endereco');
		pt_register('POST','bairro');
		pt_register('POST','cidade');
		pt_register('POST','estado');
		pt_register('POST','cep');
		pt_register('POST','id_servico');
		pt_register('POST','id_servico_var');
		pt_register('POST','obs');
		pt_register('POST','contato');
		pt_register('POST','contato_rg');
		if($nome=="" || $id_servico=="" || $id_servico_var=="" || $tel=="" || $email=="" || $cep==""){
			if($nome=="")									$errors['nome']=1;
			if($id_servico=="" or $id_servico=="0")			$errors['id_servico']=1;
			if($id_servico_var=="" or $id_servico_var=="0") $errors['id_servico_var']=1;
			if($tel=="")									$errors['tel']=1;
			if($email=="")									$errors['email']=1;
			if($cep=="")									{
			$errors['cep']=1;
			if($endereco=="") $errors['endereco']=1; 
			if($numero=="") $errors['numero']=1; 
			if($bairro=="") $errors['bairro']=1; 
			if($cidade=="") $errors['cidade']=1; 
			if($estado=="") $errors['estado']=1; 
		}
		$error .= "Os campos em vermelho são obrigatórios.<br>";
	}

	if($tipo=='cpf' and $cpf<>''){
		$valida = validaCPF($cpf);
		if($valida=='false'){
			$errors['cpf']=1;
			$error.="CPF Inválido, digite corretamente.<br>";
		}
	}else{
		if($tipo=='cnpj' and $cpf<>''){
			$valida = validaCNPJ($cpf);
			if($valida=='false'){
				$errors['cpf']=1;
				$error.="CNPJ Inválido, digite corretamente.<br>";
			}
		}
	}

	$controle_id_empresa = 1;
	$controle_id_usuario = 1;

	$res = $pedidoDAO->selectDepartamentoResp($id_servico_var);
	$dias  = $res->{'dias_'.$controle_id_empresa};
	$valor = $res->{'valor_'.$controle_id_empresa};
	$id_servico_departamento = $res->id_departamento;

	if($id_servico_departamento=='' and $id_servico_var<>''){
		if($errors!=1){
			$error.="Erro ao cadastrar o pedido. Por favor entre em contato com nossa central de atendimento (11) 3103-0800";
		}
		$errors['id_servico']=1;
	}

	$p = new stdClass();
	$p->id_usuario=$controle_id_usuario;
	$p->nome=$nome;
	$p->origem='Site';
	$p->id_ponto='';
	$p->id_pacote='';
	$p->retem_iss='';
	$p->urgente='';
	$p->restricao='';
	$p->id_conveniado='';
	$p->id_cliente='';
	$p->tel2=$tel2;
	$p->tel=$tel;
	$p->ramal2=$ramal2;
	$p->ramal=$ramal;
	$p->fax=$fax;
	$p->outros=$outros;
	$p->email=$email;
	$p->cpf=$cpf;
	$p->rg=$rg;
	$p->tipo=$tipo;
	$p->complemento=$complemento;
	$p->numero=$numero;
	$p->endereco=$endereco;
	$p->bairro=$bairro;
	$p->cidade=$cidade;
	$p->estado=$estado;
	$p->cep=$cep;
	$p->omesmo='on';
	$p->controle_cliente='';
	$p->complemento_f=$complemento;
	$p->numero_f=$numero;
	$p->endereco_f=$endereco;
	$p->bairro_f=$bairro;
	$p->cidade_f=$cidade;
	$p->estado_f=$estado;
	$p->cep_f=$cep;
	$p->forma_pagamento='Depósito';
	$p->dados_bancarios='';
	$p->id_servico=$id_servico;
	$p->id_servico_departamento=$id_servico_departamento;
	$p->id_servico_var=$id_servico_var;
	$p->valor=$valor;
	$p->dias=$dias;
	$p->obs=$obs;
	$p->contato=$contato;
	$p->contato_rg=$contato_rg;
	$p->id_afiliado = (int)($id_afiliado);
	$p->retirada='';
	$p->id_empresa_atend = $controle_id_empresa;

	$ip	  = explode(',',$_SERVER["HTTP_X_FORWARDED_FOR"]);
	$p->ip=$ip[0];
	foreach($servicocampos as $servicocampo){
		pt_register('POST',$servicocampo->campo);
		$p->{$servicocampo->campo}=${$servicocampo->campo};
	}
	$_SESSION['p'] = $p;

	if(count($errors)<1){
		$verificacliente = $pedidoDAO->verificaCliente($p);
		$cadastrar_pedido = $pedidoDAO->inserir($p);
		$cadastrar_pedido_exp = explode('/',str_replace('#','',$cadastrar_pedido));
		$_SESSION['id_pedido'] = $cadastrar_pedido_exp[0];
		mail("contato@vsites.com.br","Pedido Afiliado \"".$id_afiliado."\"",'Pedido enviado com sucesso!<br><br>O número da ordem é: '. $cadastrar_pedido ,"from: contato@vsites.com.br\nContent-type: text/html\n");
	}else{
		mail("contato@vsites.com.br","Erro Pedido Afiliado ".$id_afiliado,'erro ao cadastrar pedido: '.$email.'<br>'. $error ,"from: contato@vsites.com.br\nContent-type: text/html\n");		
	}
}else{
		mail("contato@vsites.com.br","Erro Pedido Afiliado ".$id_afiliado,'Afiliado vazio' ,"from: contato@vsites.com.br\nContent-type: text/html\n");		
}
if($id_afiliado==5) echo '<meta HTTP-EQUIV="refresh" CONTENT="1; URL=https://www.falecidosnobrasil.org.br/?pgs_path=main/padrao&msg=certidao_crt">';
#fim do submit
?>
