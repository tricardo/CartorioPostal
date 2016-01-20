<?
pt_register('POST','financeiro_divisao');
pt_register('POST','acao');
if($acao!=1 and $acao!=2 and $acao!=3 and $acao!=4){
	echo '<div class="erro">Erro fatal - Contato o administrador</div>';
	exit;
}

pt_register('POST','boleto');
pt_register('POST','id_conta');
pt_register('POST','retem_imposto');
pt_register('POST','id_nota');
pt_register('POST','cpf');
pt_register('POST','tipo');
pt_register('POST','sacado');
pt_register('POST','endereco');
pt_register('POST','bairro');
pt_register('POST','cidade');
pt_register('POST','estado');
pt_register('POST','cep');
pt_register('POST','vencimento');
pt_register('POST','juros_mora');
pt_register('POST','instrucao1');
pt_register('POST','instrucao2');
pt_register('POST','mensagem1');
pt_register('POST','mensagem2');
pt_register('POST','emissao_papeleta');
pt_register('POST','especie');
pt_register('POST','aceite');

$fat_fatura->boleto=$boleto;
$fat_fatura->id_conta=$id_conta;
$fat_fatura->retem_imposto=$retem_imposto;
$fat_fatura->id_nota=$id_nota;
$fat_fatura->cpf=$cpf;
$fat_fatura->tipo=$tipo;
$fat_fatura->sacado=$sacado;
$fat_fatura->endereco=$endereco;
$fat_fatura->bairro=$bairro;
$fat_fatura->cidade=$cidade;
$fat_fatura->estado=$estado;
$fat_fatura->cep=$cep;
$fat_fatura->vencimento=$vencimento;
$fat_fatura->juros_mora=$juros_mora;
$fat_fatura->instrucao1=$instrucao1;
$fat_fatura->instrucao2=$instrucao2;
$fat_fatura->mensagem1=$mensagem1;
$fat_fatura->mensagem2=$mensagem2;
$fat_fatura->emissao_papeleta=$emissao_papeleta;
$fat_fatura->especie=$especie;
$fat_fatura->aceite=$aceite;

if($fat_fatura->id_nota=='' or $fat_fatura->sacado=='' or $fat_fatura->endereco=='' or $fat_fatura->id_conta=='' or $fat_fatura->cep=='' or $fat_fatura->vencimento=='' or $fat_fatura->emissao_papeleta=='' or $fat_fatura->especie=='' or $fat_fatura->aceite==''){
	if($fat_fatura->id_nota=='') $error->id_nota=1;
	if($fat_fatura->sacado=='') $error->sacado=1;
	if($fat_fatura->endereco=='') $error->endereco=1;
	if($fat_fatura->id_conta=='') $error->id_conta=1;
	if($fat_fatura->cep=='') $error->cep=1;
	if($fat_fatura->vencimento=='') $error->vencimento=1;
	if($fat_fatura->emissao_papeleta=='') $error->emissao_papeleta=1;
	if($fat_fatura->especie=='') $error->especie=1;
	if($fat_fatura->aceite=='') $error->aceite=1;
	echo '<center>Os campos com * são obrigatórios. Repita o procedimento e preencha os campos corretamente!</center><br>';
	require('../includes/financeiro_faturar.php');
} else {

$im = str_replace(',',"','",str_replace(',##',"","'".htmlentities($_COOKIE['fat_id_pedido_item'])."##")."'");
$fat_pedido2 = $_SESSION['fat_pedido'];

$lista = $financeiroDAO->listaPedidoIn2($im,$controle_id_empresa);
$cont=0;
$cont_item=0;
if($fat_pedido2){
	unset($p_id_pedido_item);
	foreach ($fat_pedido2 as $l) {
		$p_id_pedido_item[]  = $l->id_pedido_item;
		$cont_item++;
	}
}


foreach($lista as $l){
	$errors='';
	$error='<ul>';
	if($cont_item<>0) {
		$busca_item = array_search($l->id_pedido_item, $p_id_pedido_item);
		if($busca_item <> '' or $l->id_pedido_item==$p_id_pedido_item[0]) {
			unset($_SESSION['fat_pedido'][$busca_item]); //apaga se já houver o registro
		}
	}	

	pt_register('POST','fin_valor_'.$l->id_pedido_item);
	pt_register('POST','fin_custa_'.$l->id_pedido_item);
	pt_register('POST','fin_rec_'.$l->id_pedido_item);
	if(!is_numeric(${'fin_valor_'.$l->id_pedido_item})){
		$error .= '<li>O campo "Valor" da ordem #'.$l->id_pedido.'/'.$l->ordem.' não é válido</li>';
		$errors = 1;			
	}

	if($_SESSION['fat_cpf']!=$l->cpf and $_SESSION['fat_cpf']<>''){
		$error .= '<li>O CPF/CNPJ da ordem #'.$l->id_pedido.'/'.$l->ordem.' é diferente das ordens selecionadas anteriormente</li>';
		$errors = 1;			
	}

	if($l->id_fatura!=0){
		$error .= '<li>A ordem #'.$l->id_pedido.'/'.$l->ordem.' já foi faturada</li>';
		$errors = 1;			
	}

	if(${'fin_valor_'.$l->id_pedido_item}<>''){
		${'fin_valor_'.$l->id_pedido_item}= str_replace(',','.',${'fin_valor_'.$l->id_pedido_item});
		${'fin_valor_'.$l->id_pedido_item}=number_format(${'fin_valor_'.$l->id_pedido_item},2,".","");
	}

	if(${'fin_rec_'.$l->id_pedido_item}<>''){
		${'fin_rec_'.$l->id_pedido_item}= str_replace(',','.',${'fin_rec_'.$l->id_pedido_item});
		${'fin_rec_'.$l->id_pedido_item}=number_format(${'fin_rec_'.$l->id_pedido_item},2,".","");
	}

	if(${'fin_custa_'.$l->id_pedido_item}<>''){
		${'fin_custa_'.$l->id_pedido_item}= str_replace(',','.',${'fin_custa_'.$l->id_pedido_item});
		${'fin_custa_'.$l->id_pedido_item}=number_format(${'fin_custa_'.$l->id_pedido_item},2,".","");
	}

	if ($errors!=1) {
		$fat_pedido_add[$cont]->id_pedido_item	= $l->id_pedido_item;
		$fat_pedido_add[$cont]->id_pedido		= '#'.$l->id_pedido.'-'.$l->ordem;
		$fat_pedido_add[$cont]->custa			= ${'fin_custa_'.$l->id_pedido_item};
		$fat_pedido_add[$cont]->valor			= ${'fin_valor_'.$l->id_pedido_item};
		$fat_pedido_add[$cont]->rec				= ${'fin_rec_'.$l->id_pedido_item};

		$_SESSION['fat_cpf']=$l->cpf;
		$_SESSION['fat_acao']=$acao;
		echo '<div class="sucesso">Pedido #'.$l->id_pedido.'/'.$l->ordem.': Adicionado na lista de faturamento.</div>';
	} else {
		echo '<div class="erro">Pedido #'.$l->id_pedido.'/'.$l->ordem.': '.$error.'</ul></div>';		
	}
	$cont++;
}
if($_SESSION['fat_pedido'] and $fat_pedido_add) {
	$_SESSION['fat_pedido']= array_merge($_SESSION['fat_pedido'],$fat_pedido_add);
} else { 
	if($fat_pedido_add) {
		$_SESSION['fat_pedido']= $fat_pedido_add;
	}	
}

$_SESSION['fat_fatura'] = $fat_fatura;

echo "
	<script>
		eraseCookie('p_id_pedido_item');
		eraseCookie('p_id_pedido');
		eraseCookie('fat_id_pedido_item');
		eraseCookie('fat_id_pedido');
	</script><br>
	<a href=\"financeiro_pagamento.php\">Clique aqui para voltar</a>
	";

unset($_COOKIE['fat_id_pedido_item']);
unset($_COOKIE['fat_id_pedido']);
unset($_COOKIE['p_id_pedido_item']);
unset($_COOKIE['p_id_pedido']);
exit;
}
?>