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

pt_register('POST','tipo_impresso');
pt_register('POST','cartorio_atribuicao');
pt_register('POST','cartorio_estado');
pt_register('POST','cartorio_cidade');
pt_register('POST','cartorio');
$i=0;
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
	
	
$sql = $objQuery->SQLQuery("SELECT * from vsites_impresso where tipo_impresso='" . $tipo_impresso . "'");
$res = mysql_fetch_array($sql);
$imprimir_topo    = $res['topo'];
$id_impresso      = $res['id_impresso'];
$imprimir_timbre  = $res['timbre'];
$imprimir_sub     = $res['sub'];
$imprimir_linha   = $res['linhas'];	
$frase='';
for ($i=0;$i<count($cartorio);$i++){
$cartorio_atual = $cartorio[$i];
    $impressao_ordem = '';
    $cont = 0;
	$linha = 0;
    $frase.=$imprimir_topo;
	
	$p_id_pedido_item = explode (',',str_replace(',##','',$_COOKIE['imoveis_id_pedido_item'].'##'));
	foreach ($p_id_pedido_item as $chave => $id_pedido_item) {
		$valida = valida_numero($id_pedido_item);
		if($valida!='TRUE'){
			echo 'Ocorreu um erro ao validar o número dos pedido(s) selecionado(s). O número de um dos pedidos não é válido';
			exit;
		}
        
		$bloco = '';
        $sql = $objQuery->SQLQuery("SELECT pi.*, u.nome as responsavel, u.email as responsavel_email from vsites_pedido_item as pi, vsites_user_usuario as u where pi.id_pedido_item='" . $id_pedido_item . "' and u.id_usuario=pi.id_usuario_op and (u.id_empresa='".$controle_id_empresa."' or pi.id_empresa_resp='".$controle_id_empresa."')");
     	$res = mysql_fetch_array($sql);
		
		$linha_bloco = 1;
        $bloco = '';
		$ordem						                   = $res['ordem'];
        $responsavel                                   = $res['responsavel'];
        $responsavel_email                             = $res['responsavel_email'];
        $id_servico					                   = $res['id_servico'];
	    $id_pedido					                   = $res['id_pedido'];
		$certidao_matricula				           = $res['certidao_matricula'];
		#if(($id_impresso==5 or $id_impresso==16 ) and $certidao_matricula<>''){		        
		#    if($certidao_matricula	            <>''){ $bloco .= " \par\par Matrícula: ".$certidao_matricula.'\par\par'; $linha_bloco++; $linha_bloco++; $linha_bloco++; $linha_bloco++; }
   	    #} else {

	    $certidao_cnpj		                           = $res['certidao_cnpj'];
	    $certidao_cpf		                           = $res['certidao_cpf'];
		$certidao_campo_bairro		                   = $res['certidao_campo_bairro'];
	    $certidao_cidade		                       = $res['certidao_cidade'];
	    $certidao_comarca_forum		                   = $res['certidao_comarca_forum'];
		$certidao_campo_cep		                       = $res['certidao_campo_cep'];
	    $certidao_data			                       = $res['certidao_data'];
	    $certidao_endereco			                   = $res['certidao_endereco'];
	    $certidao_estado			                   = $res['certidao_estado'];
	    $certidao_rg				                   = $res['certidao_rg'];
	    $certidao_numero				               = $res['certidao_numero'];
	    $certidao_nome		                           = $res['certidao_nome'].$res['certidao_nome_proprietario'];
    	$certidao_data_emissao				           = $res['certidao_data_emissao'];
    	$certidao_data_expedicao				       = $res['certidao_data_expedicao'];
    	$certidao_edificio				               = $res['certidao_edificio'];
    	$certidao_endereco_empresa				       = $res['certidao_endereco_empresa'];
    	$certidao_endereco_imovel				       = $res['certidao_endereco_imovel'];
    	$certidao_estado_civil				           = $res['certidao_estado_civil'];
    	$certidao_existe_certidao_de2				   = $res['certidao_existe_certidao_de2'];
    	$certidao_inscricao				               = $res['certidao_inscricao'];
    	$certidao_loteamento				           = $res['certidao_loteamento'];
    	$certidao_matricula				               = $res['certidao_matricula'];
    	$certidao_matriculas_encontradas			   = $res['certidao_matriculas_encontradas'];
    	$certidao_n_matricula				           = $res['certidao_n_matricula'];
    	$certidao_nome_proprietario				       = $res['certidao_nome_proprietario'];
    	$certidao_nome_reconhecer				       = $res['certidao_nome_reconhecer'];
    	$certidao_numero_ccm				           = $res['certidao_numero_ccm'];
    	$certidao_numero_contrato				       = $res['certidao_numero_contrato'];
    	$certidao_numero_contribuinte				   = $res['certidao_numero_contribuinte'];
    	$certidao_orgao_emissor				           = $res['certidao_orgao_emissor'];
    	$certidao_outros_familiares				       = $res['certidao_outros_familiares'];
    	$certidao_padre				                   = $res['certidao_padre'];
    	$certidao_pai				                   = $res['certidao_pai'];
    	$certidao_porto_saida				           = $res['certidao_porto_saida'];
    	$certidao_profissao				               = $res['certidao_profissao'];
    	$certidao_proposta				               = $res['certidao_proposta'];
    	$certidao_provincia_regiao				       = $res['certidao_provincia_regiao'];
    	$certidao_qtdd_cartorio			               = $res['certidao_qtdd_cartorio'];
    	$certidao_quadra		                       = $res['certidao_quadra'];
    	$certidao_registro				               = $res['certidao_registro'];
    	$certidao_requerente				           = $res['certidao_requerente'];
    	$certidao_requerido				               = $res['certidao_requerido'];
    	$certidao_responsavel			               = $res['certidao_responsavel'];
    	$certidao_secao				                   = $res['certidao_secao'];
    	$certidao_serie				                   = $res['certidao_serie'];
    	$certidao_subdistrito				           = $res['certidao_subdistrito'];
    	$certidao_tem_copia_doc				           = $res['certidao_tem_copia_doc'];
    	$certidao_termo			                       = $res['certidao_termo'];
    	$certidao_tipo_processo			               = $res['certidao_tipo_processo'];
    	$certidao_transcricao				           = $res['certidao_transcricao'];
    	$certidao_valor				                   = $res['certidao_valor'];
    	$certidao_valor_compra_do_imovel			   = $res['certidao_valor_compra_do_imovel'];
    	$certidao_valor_venal				           = $res['certidao_valor_venal'];
    	$certidao_vara				                   = $res['certidao_vara'];
    	
	    if($certidao_nome<>''){ 
	    	if(strlen($certidao_nome)>=50){
		    	$bloco .= " \par Nome: ".substr($certidao_nome,0,50)." \par ".substr($certidao_nome.' ',51,-1); 
	    		$linha_bloco++;
				$linha_bloco++;
			} else {
				$bloco .= " \par Nome: ".$certidao_nome; $linha_bloco++;
			}
	    }
    	if($certidao_rg	                                    <>''){ $bloco .= " \par RG: ".$certidao_rg;  $linha_bloco++;}
	    if($certidao_cnpj                                   <>''){ $bloco .= " \par CNPJ: ".$certidao_cnpj;  $linha_bloco++;}
	    if($certidao_cpf                                    <>''){ $bloco .= " \par CPF: ".$certidao_cpf;  $linha_bloco++;}
		
	    if($certidao_endereco<>''){ 
	    	if(strlen($certidao_endereco)>=50){
		    	$bloco .= " \par Endereço: ".substr($certidao_endereco,0,50)." \par ".substr($certidao_endereco.' ',51,-1); 
	    		$linha_bloco++;
				$linha_bloco++;
			} else {
				$bloco .= " \par Nome: ".$certidao_endereco; $linha_bloco++;
			}
	    }
		
	    if($certidao_numero	                                <>''){ $bloco .= " \par Número: ".$certidao_numero; $linha_bloco++; }
	    if($certidao_campo_bairro                           <>''){ $bloco .= " \par Bairro: ".$certidao_campo_bairro; $linha_bloco++; }
	    if($certidao_cidade	                                <>''){ $bloco .= " \par Cidade: ".$certidao_cidade; $linha_bloco++; }
	    if($certidao_comarca_forum                          <>''){ $bloco .= " (COMARCA DE ".$certidao_comarca_forum.") "; }
	    if($certidao_estado                                 <>''){ $bloco .= " \par Estado: ".$certidao_estado; $linha_bloco++; }
	    if($certidao_campo_cep                              <>''){ $bloco .= " \par Cep: ".$certidao_campo_cep; $linha_bloco++; }
    	if($certidao_data                                   <>''){ $bloco .= " \par Data: ".$certidao_data; $linha_bloco++; }
//	    if($certidao_comarca_forum				            <>''){ $bloco .= " \par Comarca Fórum: ".$certidao_comarca_forum; $linha_bloco++; }
    	if($certidao_data_expedicao				       	    <>''){ $bloco .= " \par Data de Expedição: ".$certidao_data_expedicao; $linha_bloco++; }
    	if($certidao_data_registro				           	<>''){ $bloco .= " \par Data de Registro: ".$certidao_data_registro; $linha_bloco++; }
    	if($certidao_documento_autenticado				   	<>''){ $bloco .= " \par Documento autenticado: ".$certidao_documento_autenticado; $linha_bloco++; }
    	if($certidao_documento_imigrante				   	<>''){ $bloco .= " \par Documento do Imigrante: ".$certidao_documento_imigrante; $linha_bloco++; }
    	if($certidao_edificio				               	<>''){ $bloco .= " \par Edifício: ".$certidao_edificio; $linha_bloco++; }
    	if($certidao_endereco_empresa				       	<>''){ $bloco .= " \par Endereço da empresa: ".$certidao_endereco_empresa; $linha_bloco++; }
    	if($certidao_endereco_imovel				       	<>''){ $bloco .= " \par Endereço do Imóvel: ".$certidao_endereco_imovel; $linha_bloco++; }
    	if($certidao_n_matricula				           	<>''){ $bloco .= " \par Matrícula: ".$certidao_n_matricula; $linha_bloco++; }
    	if($certidao_matricula				               	<>''){ $bloco .= " \par Matrícula: ".$certidao_matricula; $linha_bloco++; }
    	if($certidao_matriculas_encontradas			   	    <>''){ $bloco .= " \par Matrículas Encontradas: ".$certidao_matriculas_encontradas; $linha_bloco++; }
	    
	    
		if($certidao_existe_certidao_de2				   	<>''){ $bloco .= " \par Existe certidão de: ".$certidao_existe_certidao_de2; $linha_bloco++; }
    	if($certidao_existe_certidao_obito				   	<>''){ $bloco .= " \par Eciste certidão de obito".$certidao_existe_certidao_obito; $linha_bloco++; }
    	if($certidao_filiacao				               	<>''){ $bloco .= " \par Filiação: ".$certidao_filiacao; $linha_bloco++; }
    	if($certidao_finalidade				           	    <>''){ $bloco .= " \par Finalidade: ".$certidao_finalidade; $linha_bloco++; }
    	if($certidao_folha				                   	<>''){ $bloco .= " \par Folha: ".$certidao_folha; $linha_bloco++; }
    	if($certidao_historico_ano				           	<>''){ $bloco .= " \par Histórico ano: ".$certidao_historico_ano; $linha_bloco++; }
    	if($certidao_inscricao				               	<>''){ $bloco .= " \par Inscrição: ".$certidao_inscricao; $linha_bloco++; }
    	if($certidao_livro				                   	<>''){ $bloco .= " \par Livro: ".$certidao_livro; $linha_bloco++; }
    	if($certidao_loteamento				           	    <>''){ $bloco .= " \par Loteamento: ".$certidao_loteamento; $linha_bloco++; }
    	if($certidao_orgao_emissor				           	<>''){ $bloco .= " \par Orgao emissor: ".$certidao_orgao_emissor; $linha_bloco++; }
    	if($certidao_outros_familiares				       	<>''){ $bloco .= " \par Outros familiares".$certidao_outros_familiares; $linha_bloco++; }
    	if($certidao_porto_desembarque				       	<>''){ $bloco .= " \par Porto de desembarque: ".$certidao_porto_desembarque; $linha_bloco++; }
    	if($certidao_profissao				               	<>''){ $bloco .= " \par Profissão: ".$certidao_profissao; $linha_bloco++; }
    	if($certidao_proposta				               	<>''){ $bloco .= " \par Proposta: ".$certidao_proposta; $linha_bloco++; }
    	if($certidao_provincia_regiao				       	<>''){ $bloco .= " \par Provincia: ".$certidao_provincia_regiao; $linha_bloco++; }
    	if($certidao_quadra		                       	    <>''){ $bloco .= " \par Quadra: ".$certidao_quadra; $linha_bloco++; }
    	if($certidao_registro				               	<>''){ $bloco .= " \par Registro: ".$certidao_registro; $linha_bloco++; }
    	if($certidao_requerente				           	    <>''){ $bloco .= " \par Requerente: ".$certidao_requerente; $linha_bloco++; }
    	if($certidao_requerido				               	<>''){ $bloco .= " \par Requerido: ".$certidao_requerido; $linha_bloco++; }
    	if($certidao_resultado				               	<>''){ $bloco .= " \par Resultado: ".$certidao_resultado; $linha_bloco++; }
    	if($certidao_secao				                   	<>''){ $bloco .= " \par Secao: ".$certidao_secao; $linha_bloco++; }
    	if($certidao_serie				                   	<>''){ $bloco .= " \par Serie: ".$certidao_serie; $linha_bloco++; }
    	if($certidao_subdistrito				           	<>''){ $bloco .= " \par Subdistrito".$certidao_subdistrito; $linha_bloco++; }
    	if($certidao_termo			                       	<>''){ $bloco .= " \par Termo: ".$certidao_termo; $linha_bloco++; }
    	if($certidao_tipo_processo			               	<>''){ $bloco .= " \par Tipo de processo: ".$certidao_tipo_processo; $linha_bloco++; }
    	if($certidao_transcricao				           	<>''){ $bloco .= " \par Transcricao: ".$certidao_transcricao; $linha_bloco++; }
    	if($certidao_valor				                   	<>''){ $bloco .= " \par Valor: ".$certidao_valor; $linha_bloco++; }
    	if($certidao_valor_compra_do_imovel			   	    <>''){ $bloco .= " \par Valor de compra do imovel: ".$certidao_valor_compra_do_imovel; $linha_bloco++; }
    	if($certidao_valor_venal				           	<>''){ $bloco .= " \par Valor Venal: ".$certidao_valor_venal; $linha_bloco++; }
    	if($certidao_vara				                   	<>''){ $bloco .= " \par Vara: ".$certidao_vara; $linha_bloco++; }
        #}
    	$bloco .= " \par\par ";
    	$linha_bloco++;

		$soma_linha = $linha+$linha_bloco;
    	if($soma_linha>$imprimir_linha){
			while($linha<=($imprimir_linha)){
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

    	$sql = $objQuery->SQLQuery("SELECT * from vsites_pedido where id_pedido='" . $id_pedido . "'");
    	$res = mysql_fetch_array($sql);
    	$nome						= $res['nome'];
	    $id_conveniado				= $res['id_conveniado'];
    	$cpf						= $res['cpf'];
    	$origem						= $res['origem'];
       	$comissionado				= $res['comissionado'];
    	$rg							= $res['rg'];
    	$tipo						= $res['tipo'];
    	$tel2						= $res['tel2'];
    	$tel						= $res['tel'];
    	$cel						= $res['cel'];
    	$fax						= $res['fax'];
    	$ramal						= $res['ramal'];
    	$ramal2						= $res['ramal2'];
    	$outros						= $res['outros'];
    	$email						= $res['email'];
    	$endereco					= $res['endereco'];
    	$cidade						= $res['cidade'];
    	$estado						= $res['estado'];
    	$bairro						= $res['bairro'];
    	$cep						= $res['cep'];
    	$numero						= $res['numero'];
    	$complemento				= $res['complemento'];
    	$retem_iss					= $res['retem_iss'];


    	$sql = $objQuery->SQLQuery("SELECT departamento from vsites_servico_departamento as sd where id_servico_departamento='$id_servico_departamento' order by departamento");
    	$res = mysql_fetch_array($sql);
    	$departamento				= $res['departamento'];

    	$sql = $objQuery->SQLQuery("SELECT descricao from vsites_servico as s where id_servico='$id_servico'");
    	$res = mysql_fetch_array($sql);
    	$certidao_servico			= $res['descricao'];

    	$sql = $objQuery->SQLQuery("SELECT nome, endereco, numero, complemento, bairro, contato, tel, fax from vsites_cartorio where id_cartorio = '$cartorio_atual'");
    	$res = mysql_fetch_array($sql);
    	$cartorio_endereco		= '';
		$cartorio_tel    	    = $res['tel'];
		$cartorio_cidade	    = $res['cidade'];
		$cartorio_estado	    = $res['estado'];
		$cartorio_numero	    = $res['numero'];
		$cartorio_complemento   = $res['complemento'];
		$cartorio_fax	    	= $res['fax'];
    	$cartorio_contato		= $res['contato'];
		$cartorio_nome			= $res['nome'].' '.$cartorio_cidade.' '.$cartorio_estado;
		if($tipo_impresso>='1' and $tipo_impresso<='11' or $tipo_impresso=='26'){
			$cartorio_endereco .= $res['endereco'].','.$cartorio_numero.' '.$cartorio_complemento;
			if($cartorio_cidade<>'') $cartorio_endereco .= ' - '.$cartorio_cidade;
			if($cartorio_estado<>'') $cartorio_endereco .= ' - '.$cartorio_estado;
		} else {
			if($cartorio_contato<>'') $cartorio_endereco .= $cartorio_contato;
			if($cartorio_tel<>'') $cartorio_endereco .= ' Tel. '.$cartorio_tel;
			if($cartorio_fax<>'') $cartorio_endereco .= ' Fax. '.$cartorio_fax;
		}
		$cont++;
	}
    if($linha<=($imprimir_linha + 1 ) and $linha!=0){
		while($linha <= ($imprimir_linha + 1) ){
		   $frase .= '{\par} . ';
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
	       $frase .= $frase_sub;
        } else {
            $frase .= $frase_sub;
        }
		$impressao_ordem = '';			
	}
    $frase = str_replace("<cartorio>",$cartorio_nome, $frase );
    $frase = str_replace("<cartorio_endereco>", $cartorio_endereco.' '.$cartorio_estado, $frase );	
}		
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