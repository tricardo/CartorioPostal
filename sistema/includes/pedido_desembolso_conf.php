<?
$error="";
$errors=0;

pt_register('POST','financeiro_divisao');
pt_register('POST','financeiro_classificacao');
pt_register('POST','financeiro_banco');
pt_register('POST','financeiro_agencia');
pt_register('POST','financeiro_conta');
pt_register('POST','financeiro_identificacao');
pt_register('POST','financeiro_favorecido');
pt_register('POST','financeiro_cpf');
pt_register('POST','financeiro_descricao');
pt_register('POST','financeiro_desembolsado');
pt_register('POST','financeiro_troco');
pt_register('POST','financeiro_valor');
pt_register('POST','financeiro_rateio');
pt_register('POST','financeiro_sedex');
pt_register('POST','financeiro_forma');

$f = new stdClass();	
$f->financeiro_classificacao=$financeiro_classificacao;
$f->financeiro_banco=$financeiro_banco;
$f->financeiro_agencia=$financeiro_agencia;
$f->financeiro_conta=$financeiro_conta;
$f->financeiro_identificacao=$financeiro_identificacao;
$f->financeiro_favorecido=$financeiro_favorecido;
$f->financeiro_cpf=$financeiro_cpf;
$f->financeiro_descricao=$financeiro_descricao;
$f->financeiro_forma=$financeiro_forma;

if($financeiro_rateio<>'')	{
	$financeiro_rateio_o = $financeiro_rateio;
	$financeiro_rateio=(float)($financeiro_rateio)/(float)($financeiro_divisao);
	$financeiro_rateio=number_format($financeiro_rateio,2,".","");
	$financeiro_rateio_t =$financeiro_rateio*$financeiro_divisao;
	if($financeiro_rateio_o<>$financeiro_rateio_t){
		$financeiro_rateio_o = (float)($financeiro_rateio_o)-(float)($financeiro_rateio_t);
	} else {
		$financeiro_rateio_o = '0';
	}
	$financeiro_rateio_o=number_format($financeiro_rateio_o,2,".","");
}

if($financeiro_sedex<>'') {
	$financeiro_sedex_o = $financeiro_sedex;
	$financeiro_sedex=(float)($financeiro_sedex)/(float)($financeiro_divisao);
	$financeiro_sedex=number_format($financeiro_sedex,2,".","");
	$financeiro_sedex_t =$financeiro_sedex*$financeiro_divisao;
	if($financeiro_sedex_o<>$financeiro_sedex_t){
		$financeiro_sedex_o = (float)($financeiro_sedex_o)-(float)($financeiro_sedex_t);
	} else {
		$financeiro_sedex_o = '0';
	}
	$financeiro_sedex_o=number_format($financeiro_sedex_o,2,".","");
}

$p_id_pedido_item = explode (',',str_replace(',##','',$_COOKIE['des_id_pedido_item'].'##'));
$p_id_pedido = explode (',',str_replace(',##','',$_COOKIE['des_id_pedido'].'##'));
$cont=0;

$financeiroverificaDAO=new FinanceiroVerificaDAO();
$financeiro_inDAO = new FinanceiroDAO();

$f->financeiro_sedex=$financeiro_sedex;
$f->financeiro_rateio=$financeiro_rateio;

$f->financeiro_data = date('Y-m-d H:i:s');
#verifica permissão
foreach ($p_id_pedido_item as $chave => $id_pedido_item) {
		
	$errors='';
	$error='';
	$valida = valida_numero($id_pedido_item);
	if($valida!='TRUE'){
		echo 'Ocorreu um erro ao validar o número dos pedido(s) selecionado(s). O número de um dos pedidos não é válido';
		exit;
	}

	pt_register('POST','financeiro_valor_'.$id_pedido_item);
	$f->financeiro_valor=${'financeiro_valor_'.$id_pedido_item};

	$errors = $financeiroverificaDAO->inserir($id_pedido_item,$controle_id_empresa,$departamento_p,$departamento_s,$f);
	$f->des2=$errors->des2;

	if($errors->error=='') {
		$done = $financeiro_inDAO->inserirDesembolso($id_pedido_item,$controle_id_usuario,$f,$controle_id_empresa);			
		echo '<div class="sucesso">Desembolso solicitado com sucesso!</div>';
	} else {
		echo '<div class="erro"><b>'.$p_id_pedido[$cont].':</b><ul>'.$errors->error.'</ul></div>';
	}
	
	$id_pedido_item_ant = $id_pedido_item;
	$cont++;
}

if($financeiro_rateio_o<>'0.00' and $financeiro_rateio_o<>'' or $financeiro_sedex_o<>'0.00' and $financeiro_sedex_o<>''){
	$f->financeiro_sedex=$financeiro_sedex_o;
	$f->financeiro_rateio=$financeiro_rateio_o;
	$f->financeiro_valor=0;
	$done = $financeiro_inDAO->inserirDesembolso($id_pedido_item_ant,$controle_id_usuario,$f,$controle_id_empresa);
}
unset( $_COOKIE['des_id_pedido_item'] );
unset( $_COOKIE['des_id_pedido'] );
setcookie ("des_id_pedido_item", '');
setcookie ("des_id_pedido", '');

echo "
	<script>
		eraseCookie('des_id_pedido_item');
		eraseCookie('des_id_pedido');
	</script>
	";

?>