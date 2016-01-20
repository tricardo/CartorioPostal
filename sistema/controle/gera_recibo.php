<?
header( "Content-type: application/msword" );
header( "Content-Disposition: inline, filename=oficio.doc");
ini_set('memory_limit', '50M');

require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

pt_register('POST','id_pedido');
pt_register('POST','id_pedido_item');

$sql = $objQuery->SQLQuery("SELECT empresa, endereco, numero, complemento, cidade, estado, tel, cep  from vsites_user_empresa as ue where id_empresa='".$controle_id_empresa."'");
$res = mysql_fetch_array($sql);
$responsavel_empresa    = $res['empresa'];
$responsavel_endereco   = $res['endereco'].' '.$res['numero'].' '.$res['complemento'];
$responsavel_cidade     = $res['cidade'];
$responsavel_estado     = $res['estado'];
$responsavel_cep        = $res['cep'];
$responsavel_tel        = $res['tel'];

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
	
	
$sql = $objQuery->SQLQuery("SELECT * from vsites_impresso as i where tipo_impresso='Recibo'");
$res = mysql_fetch_array($sql);
$imprimir_topo    = $res['topo'];
$id_impresso      = $res['id_impresso'];
$imprimir_timbre  = $res['timbre'];
$imprimir_sub     = $res['sub'];
$imprimir_linha   = $res['linhas'];	
$frase='';

    $impressao_ordem = '';
    $cont = 0;
	$linha = 0;
	while($cont <= 50){
		$cont++;
		pt_register('POST','acao_'.$cont);
		pt_register('POST','acao_sel_'.$cont);
		pt_register('POST','acao_pedido_'.$cont);
        $id_pedido_item = ${'acao_'.$cont};
		
        if(${'acao_sel_'.$cont}=='on'){
		    $bloco = "";
            $sql = $objQuery->SQLQuery("SELECT pi.*, p.nome, p.cpf, pi.valor, s.descricao as servico, uu.nome as responsavel, uu.email as responsavel_email from vsites_pedido_item as pi, vsites_pedido as p, vsites_user_usuario as uu, vsites_servico as s where pi.id_pedido_item='" . $id_pedido_item . "' and pi.id_servico=s.id_servico and uu.id_usuario=pi.id_usuario_op and uu.id_empresa='".$controle_id_empresa."' and pi.id_pedido=p.id_pedido");
     	    $res = mysql_fetch_array($sql);
     	    $num = mysql_num_rows($sql);
		    if($num<>""){
			$linha_bloco = 1;
			$ordem						                   = $res['ordem'];
			$servico                                       = $res['servico'];
			$nome                                          = $res['nome'];
			$cpf                                           = $res['cpf'];
			$valor                                         = $res['valor'];
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


			$bloco = "{ \par <data> \par\par }{ Recebemos de ".$nome." - ".$cpf." \par}{ O valor de R$ ".$valor.", referente Serviço de (".$servico.") \par\par ";
        
        if($certidao_nome	                                <>''){ $bloco .= " \par Nome: ".$certidao_nome; $linha_bloco++; }
        if($certidao_cpf                                    <>''){ $bloco .= " \par CPF/CNPJ: ".$certidao_cpf; $linha_bloco++; }
		if($certidao_cnpj                                   <>''){ $bloco .= " \par CPF/CNPJ: ".$certidao_cnpj; $linha_bloco++; }
		if($certidao_devedor                                <>''){ $bloco .= " \par Nome do devedor: ".$certidao_devedor; $linha_bloco++; }
		if($certidao_pai                                    <>''){ $bloco .= " \par Pai: ".$certidao_pai; $linha_bloco++; }
        if($certidao_mae                                    <>''){ $bloco .= " \par Mãe: ".$certidao_mae; $linha_bloco++; }				
	    if($certidao_esposa                                 <>''){ $bloco .= " \par Esposa: ".$certidao_esposa; $linha_bloco++; }
	    if($certidao_marido                                 <>''){ $bloco .= " \par Marido: ".$certidao_marido; $linha_bloco++; }
	    if($certidao_data_casamento                         <>''){ $bloco .= " \par Data de Casamento: ".$certidao_data_casamento; $linha_bloco++; }
	    if($certidao_data_nascimento                        <>''){ $bloco .= " \par Data de Nascimento: ".$certidao_data_nascimento; $linha_bloco++; }
	    if($certidao_data_obito                             <>''){ $bloco .= " \par Data de Obito: ".$certidao_data_obito; $linha_bloco++; }
	    if($certidao_livro                                  <>''){ $bloco .= " \par Livro: ".$certidao_livro; $linha_bloco++; }
	    if($certidao_folha                                  <>''){ $bloco .= " \par Folha: ".$certidao_folha; $linha_bloco++; }
	    if($certidao_registro                               <>''){ $bloco .= " \par Registro: ".$certidao_registro; $linha_bloco++; }
        if($certidao_cidade	                                <>''){ $bloco .= " \par Cidade: ".$certidao_cidade; $linha_bloco++; }
	    if($certidao_estado                                 <>''){ $bloco .= " \par Estado: ".$certidao_estado; $linha_bloco++; }

        
    	$bloco .= " \par\par } ";
    	$linha_bloco++;

		$soma_linha = $linha+$linha_bloco;
         
			while($linha_bloco<=$imprimir_linha){
			   $bloco .= '{\par}';
			   $linha_bloco++;
			}		
			$impressao_ordem .=  '#'.$id_pedido.'/'.$ordem.' ';
			$frase_sub = str_replace('<responsavel>',$responsavel.$cont, $imprimir_sub).'{\par}';
			$frase_sub = str_replace('<responsavel_email>',$responsavel_email, $frase_sub);
			$frase_sub = str_replace('<responsavel_empresa>',$responsavel_empresa, $frase_sub);
			$frase_sub = str_replace('<responsavel_endereco>',$responsavel_endereco, $frase_sub);
			$frase_sub = str_replace('<responsavel_cidade>',$responsavel_cidade, $frase_sub);
			$frase_sub = str_replace('<responsavel_estado>',$responsavel_estado, $frase_sub);
			$frase_sub = str_replace('<responsavel_cep>',$responsavel_cep, $frase_sub);
			$frase_sub = str_replace('<responsavel_tel>',$responsavel_tel, $frase_sub);			
			$frase_sub = str_replace('<impressao_ordem>',$impressao_ordem, $frase_sub).'{\par}';
			$frase .= $bloco.$frase_sub;
			$impressao_ordem = '';
			$bloco = '';
			
			$linha = $linha_bloco;
			$linha_bloco=0;

           }
        }
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