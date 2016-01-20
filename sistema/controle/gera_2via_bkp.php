<?
header( "Content-type: application/msword" );
header( "Content-Disposition: inline, filename=oficio.doc");
ini_set('memory_limit', '50M');

require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

$sql = $objQuery->SQLQuery("SELECT empresa, endereco, numero, complemento, cidade, estado, tel, cep, fax  from vsites_user_empresa as ue where id_empresa='".$controle_id_empresa."'");
$res = mysql_fetch_array($sql);
$responsavel_empresa    = $res['empresa'];
$responsavel_endereco   = $res['endereco'].' '.$res['numero'].' '.$res['complemento'];

$responsavel_cidade     = $res['cidade'];
$responsavel_estado     = $res['estado'];
$responsavel_cep        = $res['cep'];
$responsavel_tel        = $res['tel'];
$responsavel_fax        = $res['fax'];

if($controle_id_empresa=='1') {
	$responsavel_endereco ='Caixa Postal 933';
	$responsavel_cep        = '01031-970';	
}

pt_register('POST','valor1');
pt_register('POST','valor2');
pt_register('POST','valor3');
pt_register('POST','id_cartorio');

        $sql = $objQuery->SQLQuery("SELECT * from vsites_cartorio as c where id_cartorio='" . $id_cartorio . "'");
     	$res = mysql_fetch_array($sql);

    	$cartorio_endereco		= $res['endereco'];
		$cartorio_numero		= $res['numero'];
		$cartorio_complemento	= $res['complemento'];
		$cartorio_bairro		= $res['bairro'];
		$cartorio_cidade		= $res['cidade'];
		$cartorio_estado		= $res['estado'];
    	$cartorio_nome			= $res['nome'];
		if($cartorio_numero<>'') $cartorio_endereco .= ' '.$cartorio_numero;
		if($cartorio_complemento<>'') $cartorio_endereco .= ' '.$cartorio_complemento;
		if($cartorio_bairro<>'') $cartorio_endereco .= ' '.$cartorio_bairro;
		if($cartorio_cidade<>'') $cartorio_endereco .= ' '.$cartorio_cidade;

    $m=date(m);
    if($m == '1') $mes = 'Janeiro';
    if($m == '2') $mes = 'Fevereiro';
    if($m == '3') $mes = 'Março';
    if($m == '4') $mes = 'Abril';
    if($m == '5') $mes = 'Maio';
    if($m == '6') $mes = 'Junho';
    if($m == '7') $mes = 'Julho';
    if($m == '8') $mes = 'Agosto';
    if($m == '9') $mes = 'Setembro';
    if($m == '10') $mes = 'Outubro';
    if($m == '11') $mes = 'Novembro';
    if($m == '12') $mes = 'Dezembro';
    $data_atual = $responsavel_cidade.', '.date(d).' de '.$mes.' de 20'.date(y).'.';
	
	
$sql = $objQuery->SQLQuery("SELECT * from vsites_impresso as i where tipo_impresso='Segunda Via'");
$res = mysql_fetch_array($sql);
$imprimir_topo    = $res['topo'];
$imprimir_timbre  = $res['timbre'];
$imprimir_sub     = $res['sub'];
$imprimir_linha   = $res['linhas'];	
$frase='';

    $impressao_ordem = '';
    $linha = 0;
    $frase.=$imprimir_topo;
	$p_id_pedido_item = explode (',',str_replace(',##','',$_COOKIE['2via_id_pedido_item'].'##'));
	$cont=0;
	#verifica permissão
	foreach ($p_id_pedido_item as $chave => $id_pedido_item) {
		$errors='';
		$error='';
		$valida = valida_numero($id_pedido_item);
		if($valida!='TRUE'){
			echo 'Ocorreu um erro ao validar o número dos pedido(s) selecionado(s). O número de um dos pedidos não é válido';
			exit;
		}

		$bloco = '';
		
        $sql = $objQuery->SQLQuery("SELECT pi.*, s.descricao as servico, uu.nome as responsavel, uu.email as responsavel_email from vsites_pedido_item as pi, vsites_user_usuario as uu, vsites_servico as s where pi.id_servico=s.id_servico and pi.id_pedido_item='" . $id_pedido_item . "' and uu.id_usuario=pi.id_usuario_op and (uu.id_empresa='".$controle_id_empresa."' or pi.id_empresa_resp='".$controle_id_empresa."')");
     	$res = mysql_fetch_array($sql);
		
		$linha_bloco = 1;
        $bloco = '';
		$ordem						                   = $res['ordem'];
        $servico                                       = $res['servico'];
        $responsavel                                   = $res['responsavel'];
        $responsavel_email                             = $res['responsavel_email'];
        $id_servico					                   = $res['id_servico'];
	    $id_pedido					                   = $res['id_pedido'];
	    $obs						                   = $res['obs'];
	    $certidao_cidade		                       = $res['certidao_cidade'];
	    $certidao_estado			                   = $res['certidao_estado'];
	    $certidao_nome		                           = $res['certidao_nome'];
		$certidao_pai		                           = $res['certidao_pai'];
		$certidao_mae		                           = $res['certidao_mae'];
        $certidao_marido			                   = $res['certidao_marido'];
        $certidao_esposa			                   = $res['certidao_esposa'];
        $certidao_livro  			                   = $res['certidao_livro'];
        $certidao_folha  			                   = $res['certidao_folha'];
        $certidao_registro			                   = $res['certidao_registro'];
        $certidao_data_casamento                       = $res['certidao_data_casamento'];
        $certidao_data_nascimento                      = $res['certidao_data_nascimento'];
        $certidao_data_obito                           = $res['certidao_data_obito'];
        $certidao_cpf                                  = $res['certidao_cpf'];
        $certidao_rg                                   = $res['certidao_rg'];
        $certidao_cnpj                                 = $res['certidao_cnpj'];
        $certidao_cartorio                             = $res['certidao_cartorio'];
        
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
        $frase = str_replace("<cartorio>",$cartorio_nome.$id_cartorio, $frase );
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