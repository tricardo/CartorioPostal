<?
header( "Content-type: application/msword" );
header( "Content-Disposition: inline, filename=oficio.doc");
ini_set('memory_limit', '50M');

require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

$empresaDAO = new EmpresaDAO();
$emp = $empresaDAO->selectPorId($controle_id_empresa);

$responsavel_empresa    = $emp->empresa;
$responsavel_endereco   = $emp->endereco.' '.$emp->numero.' '.$emp->complemento;
$responsavel_cidade     = $emp->cidade;
$responsavel_estado     = $emp->estado;
$responsavel_cep        = $emp->cep;
$responsavel_tel        = $emp->tel;
$responsavel_fax        = $emp->fax;

if($controle_id_empresa=='1') {
	$responsavel_endereco ='Caixa Postal 933';
	$responsavel_cep        = '01031-970';
}

pt_register('POST','valor1');
pt_register('POST','valor2');
pt_register('POST','valor3');
pt_register('POST','id_cartorio');

$cartorioDAO = new CartorioDAO();
$c = $cartorioDAO->selectPorId($id_cartorio);

$cartorio_endereco		= $c->endereco;
$cartorio_numero		= $c->numero;
$cartorio_complemento	= $c->complemento;
$cartorio_bairro		= $c->bairro;
$cartorio_cidade		= $c->cidade;
$cartorio_estado		= $c->estado;
$cartorio_nome			= $c->nome;
if($cartorio_numero<>'') $cartorio_endereco .= ' '.$cartorio_numero;
if($cartorio_complemento<>'') $cartorio_endereco .= ' '.$cartorio_complemento;
if($cartorio_bairro<>'') $cartorio_endereco .= ' '.$cartorio_bairro;
if($cartorio_cidade<>'') $cartorio_endereco .= ' '.$cartorio_cidade;

$m=date(m);
$mes = traduzMes($m);
$data_atual = $responsavel_cidade.', '.date(d).' de '.$mes.' de 20'.date(y).'.';

$impressoDAO = new ImpressoDAO();
$imp = $impressoDAO->buscaPorTipoImpresso('Segunda Via');
$imprimir_topo    = $imp->topo;
$imprimir_timbre  = $imp->timbre;
$imprimir_sub     = $imp->sub;
$imprimir_linha   = $imp->linhas;
$frase='';

$impressao_ordem = '';
$linha = 0;
$frase.=$imprimir_topo;
$p_id_pedido_item = explode (',',str_replace(',##','',$_COOKIE['2via_id_pedido_item'].'##'));
$cont=0;
#verifica permissão
$pedidoDAO = new PedidoDAO();
foreach ($p_id_pedido_item as $chave => $id_pedido_item) {
	$errors='';
	$error='';
	$valida = valida_numero($id_pedido_item);
	if($valida!='TRUE'){
		echo 'Ocorreu um erro ao validar o número dos pedido(s) selecionado(s). O número de um dos pedidos não é válido';
		exit;
	}

	$bloco = '';
	
	$ped = $pedidoDAO->selectPedidoItemPorId($id_pedido_item,$controle_id_empresa);
	
	$linha_bloco = 1;
	$bloco = '';
	$ordem						                   = $ped->ordem;
	$servico                                       = $ped->servico;
	$responsavel                                   = $ped->responsavel;
	$responsavel_email                             = $ped->responsavel_email;
	$id_servico					                   = $ped->id_servico;
	$id_pedido					                   = $ped->id_pedido;
	$obs						                   = $ped->obs;
	$certidao_cidade		                       = $ped->certidao_cidade;
	$certidao_estado			                   = $ped->certidao_estado;
	$certidao_nome		                           = $ped->certidao_nome;
	$certidao_pai		                           = $ped->certidao_pai;
	$certidao_mae		                           = $ped->certidao_mae;
	$certidao_marido			                   = $ped->certidao_marido;
	$certidao_esposa			                   = $ped->certidao_esposa;
	$certidao_livro  			                   = $ped->certidao_livro;
	$certidao_folha  			                   = $ped->certidao_folha;
	$certidao_registro			                   = $ped->certidao_registro;
	$certidao_data_casamento                       = $ped->certidao_data_casamento;
	$certidao_data_nascimento                      = $ped->certidao_data_nascimento;
	$certidao_data_obito                           = $ped->certidao_data_obito;
	$certidao_cpf                                  = $ped->certidao_cpf;
	$certidao_rg                                   = $ped->certidao_rg;
	$certidao_cnpj                                 = $ped->certidao_cnpj;
	$certidao_cartorio                             = $ped->certidao_cartorio;

	if($servico	                                        <>''){ $bloco .= " {\par \b ".$servico.'}'; $linha_bloco++; }
	if($certidao_nome	                                <>''){ $bloco .= " \par Nome: ".$certidao_nome; $linha_bloco++; }
	if($certidao_esposa                                 <>''){ $bloco .= " \par Esposa: ".$certidao_esposa; $linha_bloco++; }
	if($certidao_marido                                 <>''){ $bloco .= " \par Marido: ".$certidao_marido; $linha_bloco++; }
	if($certidao_pai                                    <>''){ $bloco .= " \par Pai: ".$certidao_pai; $linha_bloco++; }
	if($certidao_mae                                    <>''){ $bloco .= " \par Mãe: ".$certidao_mae; $linha_bloco++; }
	if($certidao_data_casamento                         <>''){ $bloco .= " \par Data de Casamento: ".$certidao_data_casamento; $linha_bloco++; }
	if($certidao_data_nascimento                        <>''){ $bloco .= " \par Data de Nascimento: ".$certidao_data_nascimento; $linha_bloco++; }
	if($certidao_data_obito                             <>''){ $bloco .= " \par Data de Obito: ".$certidao_data_obito; $linha_bloco++; }
	if($certidao_livro                                  <>''){ $bloco .= " \par Livro: ".$certidao_livro; $linha_bloco++; }
	if($certidao_folha                                  <>''){ $bloco .= " \par Folha: ".$certidao_folha; $linha_bloco++; }
	if($certidao_registro                               <>''){ $bloco .= " \par Registro: ".$certidao_registro; $linha_bloco++; }
	if($certidao_cidade	                                <>''){ $bloco .= " \par Cidade: ".$certidao_cidade; $linha_bloco++; }
	if($certidao_estado                                 <>''){ $bloco .= " \par Estado: ".$certidao_estado; $linha_bloco++; }
	if($certidao_cartorio                               <>''){ $bloco .= " \par Cartório: ".$certidao_cartorio; $linha_bloco++; }



	$bloco .= " \par\par ";
	$linha_bloco++;

	$soma_linha = $linha+$linha_bloco;
	if($soma_linha>$imprimir_linha){
		while($linha<=$imprimir_linha){
			$frase .= '{\par}';
			$linha++;
		}
		$frase_sub = str_replace('<responsavel>',$responsavel, $imprimir_sub).'{\par}';
		$frase_sub = str_replace('<responsavel_email>',$responsavel_email, $frase_sub).'{\par}';
		$frase_sub = str_replace('<responsavel_empresa>',$responsavel_empresa, $frase_sub);
		$frase_sub = str_replace('<responsavel_endereco>',$responsavel_endereco, $frase_sub);
		$frase_sub = str_replace('<responsavel_cidade>',$responsavel_cidade, $frase_sub);
		$frase_sub = str_replace('<responsavel_estado>',$responsavel_estado, $frase_sub);
		$frase_sub = str_replace('<responsavel_cep>',$responsavel_cep, $frase_sub);
		$frase_sub = str_replace('<responsavel_tel>',$responsavel_tel, $frase_sub);
		$frase_sub = str_replace('<responsavel_fax>','/'.$responsavel_fax, $frase_sub);
		$frase_sub = str_replace('<impressao_ordem>',$impressao_ordem, $frase_sub).'{\par}';
		$frase .= $frase_sub.$imprimir_topo.$bloco;
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

	$id_servico_var				= $res['id_servico_var'];
	$dias						= $res['dias'];
	$valor						= $res['valor'];
	$id_servico_departamento	= $res['id_servico_departamento'];
	$impressao_ordem .=  '#'.$id_pedido.'/'.$ordem.' ';


	$cont++;
}
if($linha<=$imprimir_linha and $linha!=0){
	while($linha<=$imprimir_linha){
		$frase .= '{\par}';
		$linha++;
	}
	$frase_sub = str_replace('<responsavel>',$responsavel, $imprimir_sub).'{\par}';
	$frase_sub = str_replace('<responsavel_email>',$responsavel_email, $frase_sub).'{\par}';
	$frase_sub = str_replace('<responsavel_empresa>',$responsavel_empresa, $frase_sub);
	$frase_sub = str_replace('<responsavel_endereco>',$responsavel_endereco, $frase_sub);
	$frase_sub = str_replace('<responsavel_cidade>',$responsavel_cidade, $frase_sub);
	$frase_sub = str_replace('<responsavel_estado>',$responsavel_estado, $frase_sub);
	$frase_sub = str_replace('<responsavel_cep>',$responsavel_cep, $frase_sub);
	$frase_sub = str_replace('<responsavel_tel>',$responsavel_tel, $frase_sub);
	$frase_sub = str_replace('<responsavel_fax>','/'.$responsavel_fax, $frase_sub);
	$frase_sub = str_replace('<impressao_ordem>',$impressao_ordem, $frase_sub);
	if($i+1<count($cartorio)){
		$frase .= $frase_sub.'{\par}';
	} else {
		$frase .= $frase_sub;
	}
	$impressao_ordem = '';
}
$frase = str_replace("<cartorio>",'SERVIÇO REGISTRAL DAS PESSOAS NATURAIS', $frase );
$frase = str_replace("<cartorio_endereco>", $cartorio_endereco, $frase );
$frase     = str_replace('<valor1>',$valor1, $frase).'{\par}';
$frase     = str_replace('<valor2>',$valor2, $frase).'{\par}';
$frase     = str_replace('<valor3>',$valor3, $frase).'{\par}';
if($imprimir_timbre=='Não'){
	$arquivo = "templates/modelo.rtf";
} else {
	$arquivo = "templates/modelo_timbre.rtf";
}
$fp = fopen ($arquivo, "r" );
$output = fread($fp,filesize($arquivo));

fclose ($fp);
$output = str_replace('<imprimir_valores>',$frase, $output);
$output = str_replace("<data>", $data_atual, $output );

echo $output;
?>