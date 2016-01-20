<?php
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

pt_register('POST','id_cliente');
pt_register('POST','id_servico');

if($id_cliente==''){
	echo 'Selecione um conveniado';
	exit;
}

$data_hora = date('YmdHis');
$arquivoDiretorio = "./remessa_cart/R".$data_hora.$controle_id_usuario."_".$id_cliente.".TXT";
$nomeArquivo = "R".$data_hora.$controle_id_usuario."_".$id_cliente.".TXT";

$sql = $objQuery->SQLQuery("SELECT c.* from vsites_user_cliente as c where c.id_cliente='".$id_cliente."'");
$res = mysql_fetch_array($sql);

if($id_cliente==49117 or $id_cliente==89607){
	$h_codregistro = '0';#1
	$h_tipo = "REMESSA";#7
	if($id_servico=='17') $h_produto = "NOTIFICAÇÃO ELETRONICA        "; #30
	$h_livre1 = "99999999999999";#14

	$carac = strlen($res['nome']);
	$ESQUERDA = '';
	while($carac<40){
		$ESQUERDA .= ' ';
		$carac++;
	}
	$h_cliente = $res['nome'].$ESQUERDA;#40

	$carac = strlen($res['endereco']);
	$ESQUERDA = '';
	while($carac<40){
		$ESQUERDA .= ' ';
		$carac++;
	}
	$h_endereco = $res['endereco'].$ESQUERDA;#40

	$carac = strlen($res['numero']);
	$ESQUERDA = '';
	while($carac<10){
		$ESQUERDA .= ' ';
		$carac++;
	}
	$h_numero = $res['numero'].$ESQUERDA;#10

	$carac = strlen($res['complemento']);
	$ESQUERDA = '';
	while($carac<10){
		$ESQUERDA .= ' ';
		$carac++;
	}
	$h_complemento = $res['complemento'].$ESQUERDA;#10

	$carac = strlen($res['bairro']);
	$ESQUERDA = '';
	while($carac<30){
		$ESQUERDA .= ' ';
		$carac++;
	}
	$h_bairro = $res['bairro'].$ESQUERDA;#30

	$carac = strlen($res['cidade']);
	$ESQUERDA = '';
	while($carac<30){
		$ESQUERDA .= ' ';
		$carac++;
	}
	$h_cidade = $res['cidade'].$ESQUERDA;#30

	$cep=str_replace('-','',$res['cep']);
	$carac = strlen($cep);
	$ESQUERDA = '';
	while($carac<8){
		$ESQUERDA .= ' ';
		$carac++;
	}
	$h_cep = $ESQUERDA.$cep;#8

	$carac = strlen($cep);
	$ESQUERDA = '';
	while($carac<8){
		$ESQUERDA .= ' ';
		$carac++;
	}
	$h_estado = $res['estado'].$ESQUERDA;#2

	$tel=str_replace('-','',str_replace(')','',str_replace('(','',$res['tel'])));
	$carac = strlen($tel);
	$ESQUERDA = '';
	while($carac<10){
		$ESQUERDA .= ' ';
		$carac++;
	}
	$h_tel = $ESQUERDA.$tel;#10

	$carac = strlen($res['nome']);
	$ESQUERDA = '';
	while($carac<40){
		$ESQUERDA .= ' ';
		$carac++;
	}
	$h_responsavel = $res['nome'].$ESQUERDA;#40

	$carac = strlen($res['cargo']);
	$ESQUERDA = '';
	while($carac<40){
		$ESQUERDA .= ' ';
		$carac++;
	}
	$h_cargo = $res['cargo'].$ESQUERDA;#40

	$h_datagravacao = date('dmY');#8

	$h_livre3 = '                                                                                                                                                                                                                                                                                                                                                                                                ';#384 BRANCOS

	$h_sequencial = '000001';#6
        
	#header
	$arquivoConteudo  = $h_codregistro.$h_tipo.$h_produto.$h_livre1.$h_cliente.$h_endereco.$h_numero.$h_complemento.$h_bairro.$h_cidade.$h_cep.$h_estado.$h_ddd.$h_telefone.$h_responsavel.$h_cargo.$h_datagravacao.$h_livre3.$h_sequencial.'
';

	$R_CODREGISTRO = '1';#1
	$sql = $objQuery->SQLQuery("SELECT pi.* from
	vsites_user_usuario as u, vsites_pedido_item as pi, vsites_pedido as p where
	p.id_conveniado='".$id_cliente."' and
	p.id_pedido = pi.id_pedido and
	pi.id_servico= '17' and
	pi.id_status  = '4' and
	pi.id_usuario=u.id_usuario and
	pi.rem='0'
	order by pi.id_pedido_item");
	$cont='1';
	while($res = mysql_fetch_array($sql)){
		$R_COD_AGENCIA = $res['certidao_cod_agencia'];
		$carac = strlen($R_COD_AGENCIA);
		$ESQUERDA = '';
		while($carac<3){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_COD_AGENCIA = $ESQUERDA.$R_COD_AGENCIA;

		$R_NUMERO_DA_CONTA = $res['certidao_conta'];
		$carac = strlen($R_NUMERO_DA_CONTA);
		$ESQUERDA = '';
		while($carac<9){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_NUMERO_DA_CONTA = $ESQUERDA.$R_NUMERO_DA_CONTA;

		$R_IDENTIFICACAO = $res['certidao_modelo'];
		$carac = strlen($R_IDENTIFICACAO);
		$ESQUERDA = '';
		while($carac<15){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_IDENTIFICACAO = $R_IDENTIFICACAO.$ESQUERDA;

		$R_CLIENTE_NOME = $res['certidao_requerente'];
		$carac = strlen($R_CLIENTE_NOME);
		$ESQUERDA = '';
		while($carac<40){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_CLIENTE_NOME = $R_CLIENTE_NOME.$ESQUERDA;

		$R_NOT_CPF = $res['certidao_cpf'];
		if($R_NOT_CPF=='')$R_NOT_CPF = $res['certidao_cnpj'];
		$carac = strlen($R_NOT_CPF);
		$ESQUERDA = '';
		while($carac<15){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_NOT_CPF = $ESQUERDA.$R_NOT_CPF;

		$R_NOT_NOME = $res['certidao_nome'];
		$carac = strlen($R_NOT_NOME);
		$ESQUERDA = '';
		while($carac<40){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_NOT_NOME = $R_NOT_NOME.$ESQUERDA;

		$R_NOT_ENDERECO = str_replace('  ',' ',str_replace('  ',' ',$res['certidao_endereco']));
		$carac = strlen($R_NOT_ENDERECO);
		$ESQUERDA = '';
		while($carac<40){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_NOT_ENDERECO = $R_NOT_ENDERECO.$ESQUERDA;

		$R_NOT_PRACA = str_replace('  ',' ',$res['certidao_cidade']);
		$carac = strlen($R_NOT_PRACA);
		$ESQUERDA = '';
		while($carac<40){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_NOT_PRACA = $R_NOT_PRACA.$ESQUERDA;

		$R_NOT_CEP = $res['certidao_campo_cep'];
		$carac = strlen($R_NOT_CEP);
		$ESQUERDA = '';
		while($carac<8){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_NOT_CEP = $ESQUERDA.$R_NOT_CEP;

		$R_NOT_UF = $res['certidao_estado'];
		$carac = strlen($R_NOT_UF);
		$ESQUERDA = '';
		while($carac<2){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_NOT_UF = $ESQUERDA.$R_NOT_UF;

		$R_NOT_NUMERO = $res['certidao_numero_not'];
		$carac = strlen($R_NOT_NUMERO);
		$ESQUERDA = '';
		while($carac<5){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_NOT_NUMERO = $ESQUERDA.$R_NOT_NUMERO;

		$R_SEQUENCIA_DO_DOC = $res['certidao_sequencia'];
		$carac = strlen($R_SEQUENCIA_DO_DOC);
		$ESQUERDA = '';
		while($carac<5){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_SEQUENCIA_DO_DOC = $ESQUERDA.$R_SEQUENCIA_DO_DOC;

		$R_NOSSO_NUMERO = $res['certidao_nosso_numero'];
		$carac = strlen($R_NOSSO_NUMERO);
		$ESQUERDA = '';
		while($carac<8){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_NOSSO_NUMERO = $ESQUERDA.$R_NOSSO_NUMERO;

		$R_DUPLICATA = $res['certidao_duplicata'];
		$carac = strlen($R_DUPLICATA);
		$ESQUERDA = '';
		while($carac<12){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_DUPLICATA = $R_DUPLICATA.$ESQUERDA;

		$R_EMISSAO_TITULO = $res['certidao_emissao'];
		$carac = strlen($R_EMISSAO_TITULO);
		$ESQUERDA = '';
		while($carac<8){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_EMISSAO_TITULO = $ESQUERDA.$R_EMISSAO_TITULO;

		$R_AGENCIA_COBRADORA = $res['certidao_agencia'];
		$carac = strlen($R_AGENCIA_COBRADORA);
		$ESQUERDA = '';
		while($carac<3){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_AGENCIA_COBRADORA = $ESQUERDA.$R_AGENCIA_COBRADORA;

		$R_BANCO_COBRADOR = $res['certidao_banco'];
		$carac = strlen($R_BANCO_COBRADOR);
		$ESQUERDA = '';
		while($carac<20){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_BANCO_COBRADOR = $R_BANCO_COBRADOR.$ESQUERDA;

		$R_VENCIMENTO_TITULO = $res['certidao_vencimento'];
		$carac = strlen($R_VENCIMENTO_TITULO);
		$ESQUERDA = '';
		while($carac<8){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_VENCIMENTO_TITULO = $ESQUERDA.$R_VENCIMENTO_TITULO;

		$R_VALOR_TITULO = $res['certidao_valor'];
		$carac = strlen($R_VALOR_TITULO);
		$ESQUERDA = '';
		while($carac<17){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_VALOR_TITULO = $ESQUERDA.$R_VALOR_TITULO;

		$R_CARTEIRA_TITULO = $res['certidao_cart_titulo'];
		$carac = strlen($R_CARTEIRA_TITULO);
		$ESQUERDA = '';
		while($carac<2){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_CARTEIRA_TITULO = $ESQUERDA.$R_CARTEIRA_TITULO;

		$R_NUMERO_CONTRATO = $res['certidao_n_contrato'];
		$carac = strlen($R_NUMERO_CONTRATO);
		$ESQUERDA = '';
		while($carac<20){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_NUMERO_CONTRATO = $R_NUMERO_CONTRATO.$ESQUERDA;

		$R_EMISSAO_DIREITO_CRED = $res['certidao_emissao_dir_cred'];
		$carac = strlen($R_EMISSAO_DIREITO_CRED);
		$ESQUERDA = '';
		while($carac<8){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_EMISSAO_DIREITO_CRED = $ESQUERDA.$R_EMISSAO_DIREITO_CRED;

		$R_NUMERO_DIREITO_CRED = $res['certidao_num_dir_cred'];
		$carac = strlen($R_NUMERO_DIREITO_CRED);
		$ESQUERDA = '';
		while($carac<10){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_NUMERO_DIREITO_CRED = $ESQUERDA.$R_NUMERO_DIREITO_CRED;

		$R_NUMERO_CONTRATO_DIREITO_CRED = $res['certidao_num_contrato_dir_cred'];
		$carac = strlen($R_NUMERO_CONTRATO_DIREITO_CRED);
		$ESQUERDA = '';
		while($carac<12){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_NUMERO_CONTRATO_DIREITO_CRED = $R_NUMERO_CONTRATO_DIREITO_CRED.$ESQUERDA;

		$R_EMISSAO_CONTRATO_BIC = $res['certidao_emissao_contrato'];
		$carac = strlen($R_EMISSAO_CONTRATO_BIC);
		$ESQUERDA = '';
		while($carac<8){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_EMISSAO_CONTRATO_BIC = $ESQUERDA.$R_EMISSAO_CONTRATO_BIC;

		$R_MODALIDADE = $res['certidao_modalidade'];
		$carac = strlen($R_MODALIDADE);
		$ESQUERDA = '';
		while($carac<6){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_MODALIDADE = $ESQUERDA.$R_MODALIDADE;

		$R_NOT_BAIRRO = $res['certidao_campo_bairro'];
		$carac = strlen($R_NOT_BAIRRO);
		$ESQUERDA = '';
		while($carac<60){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_NOT_BAIRRO = $R_NOT_BAIRRO.$ESQUERDA;

		$R_OBJETO_CONTRATO_DIR_CRED = $res['certidao_objeto_contrato_cred'];
		$carac = strlen($R_OBJETO_CONTRATO_DIR_CRED);
		$ESQUERDA = '';
		while($carac<240){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_OBJETO_CONTRATO_DIR_CRED = $R_OBJETO_CONTRATO_DIR_CRED.$ESQUERDA;

		$R_CPF_CONTRATADO = $res['certidao_cpf_contratado'];
		$carac = strlen($R_CPF_CONTRATADO);
		$ESQUERDA = '';
		while($carac<15){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_CPF_CONTRATADO = $ESQUERDA.$R_CPF_CONTRATADO;

		$R_NUMEROPEDIDO = $res['id_pedido'].'-'.$res['ordem'];
		$carac = strlen($R_NUMEROPEDIDO);
		$ESQUERDA = '';
		while($carac<10){
			$ESQUERDA .= ' ';
			$carac++;
		}
		$R_NUMEROPEDIDO = $R_NUMEROPEDIDO.$ESQUERDA;

		$cont++;
		$carac = strlen($cont);
		$cont_='';
		while($carac<6){
			$cont_ .= '0';
			$carac++;
		}
		$cont_ .= $cont;

		$arquivoConteudo  .= $R_CODREGISTRO.$R_COD_AGENCIA.$R_NUMERO_DA_CONTA.$R_IDENTIFICACAO.$R_CLIENTE_NOME.$R_NOT_CPF.$R_NOT_NOME.$R_NOT_ENDERECO.$R_NOT_PRACA.$R_NOT_CEP.$R_NOT_UF.$R_NOT_NUMERO.$R_SEQUENCIA_DO_DOC.$R_NOSSO_NUMERO.$R_DUPLICATA.$R_EMISSAO_TITULO.$R_AGENCIA_COBRADORA.$R_BANCO_COBRADOR.$R_VENCIMENTO_TITULO.$R_VALOR_TITULO.$R_CARTEIRA_TITULO.$R_NOT_BAIRRO.$R_NUMERO_CONTRATO.$R_EMISSAO_DIREITO_CRED.$R_NUMERO_DIREITO_CRED.$R_NUMERO_CONTRATO_DIREITO_CRED.$R_EMISSAO_CONTRATO_BIC.$R_MODALIDADE.$R_OBJETO_CONTRATO_DIR_CRED.$R_CPF_CONTRATADO.$R_NUMEROPEDIDO.'    '.$cont_;
                if($id_cliente==89607){
                    $arquivoConteudo  .= invert($res['data'],'','PHP');
                }
                $arquivoConteudo  .= '
';
}
	#quantidade de registros
	$qtdd = $cont-1;
	$carac = strlen($qtdd);
	$qtdd_='';
	while($carac<6){
		$qtdd_ .= '0';
		$carac++;
	}
	$qtdd_ .= $qtdd;

	$cont++;
	$carac = strlen($cont);
	$cont_='';
	while($carac<6){
		$cont_ .= '0';
		$carac++;
	}
	$cont_ .= $cont;
	$brancos = "                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               "; #

	$arquivoConteudo  .= '9'.$qtdd_.$brancos.$cont_.'
';
} else {
	#arquivo para helbor e bradesco
	$remessacartDAO = new RemessaCartDAO();
	$arquivoConteudo  = 'Cliente;Tipo;Obra;Unidade;Data do Contrato;Notificante;Notificado;Endereço;Bairro;Cidade;Estado;CEP;Telefone;Empreendimento;Mensalidade;Vencimento;Valor;Juros;Multa;Correção
';
	$lista = $remessacartDAO->selectNotificacoes($id_cliente);
	foreach($lista as $l){
		$rr = explode('/',$l->certidao_numero_not);
		$arquivoConteudo  .= $id_cliente.';'.$l->certidao_modelo.';'.$rr[0].';'.$rr[1].';'.$l->certidao_emissao_contrato.';'.$l->certidao_requerente.';'.$l->certidao_nome.';'.$l->certidao_endereco.';'.$l->certidao_campo_bairro.';'.$l->certidao_cidade.';'.$l->certidao_estado.';'.$l->certidao_campo_cep.';'.$l->certidao_nosso_numero.';'.$l->certidao_modalidade.';'.$l->certidao_duplicata.';'.$l->certidao_vencimento.';'.$l->certidao_nome.';'.$l->certidao_valor.';'.$l->certidao_n_contribuinte.';'.$l->certidao_n_deposito.';'.$l->conce_nome.'
';
	}
}

if(is_file($arquivoDiretorio)) {
	unlink($arquivoDiretorio);
}

if(fopen($arquivoDiretorio,"w+")) {

	if (!$handle = fopen($arquivoDiretorio, 'w+')) {
		echo "<BR><font style='color: blue;'>&nbsp;&nbsp;FALHA AO CRIAR O ARQUIVO: <b>".$nomeArquivo."</b>.</font><br />";
		exit;
	}
	if(!fwrite($handle, $arquivoConteudo)) {
		echo"<BR><font style='color: blue;'>&nbsp;&nbsp;FALHA AO ESCREVER NO ARQUIVO: <b>".$nomeArquivo."</b>.</font><br />";
		exit;
	}

	$sql = $objQuery->SQLQuery("insert into vsites_remessa_cart (id_cliente,id_usuario,arquivo,data)
			values('".$id_cliente."','".$controle_id_usuario."','".$nomeArquivo."',NOW())");	

	$sql = $objQuery->SQLQuery("update vsites_pedido_item as pi, vsites_pedido as p
	set pi.rem='1' where
	p.id_conveniado='".$id_cliente."' and
	p.id_pedido = pi.id_pedido and
	pi.id_status = '4' and
	pi.id_servico='17'");
		
	header ("Content-type: octet/stream");
	header ("Content-disposition: attachment; filename=remessa_cart/".$nomeArquivo.";");
	header ("Content-Length: ".filesize($arquivoDiretorio));
	readfile($arquivoDiretorio);
	 
} else {
	echo"<BR><font style='color: blue;'>&nbsp;&nbsp;ERRO AO CRIAR O ARQUIVO: <b>".$nomeArquivo."</b>.</font><br />";
	exit;
}
?>