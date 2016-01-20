<?
header( "Content-type: application/msword" );
header( "Content-Disposition: inline, filename=oficio.doc");
ini_set('memory_limit', '50M');

require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );



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
    $data_atual = 'São Paulo, '.date(d).' de '.$mes.' de 20'.date(y).'.';
	
	
$sql = $objQuery->SQLQuery("SELECT * from vsites_impresso where tipo_impresso='Protocolo Entrega'");
$res = mysql_fetch_array($sql);
$imprimir_topo    = $res['topo'];
$imprimir_timbre  = $res['timbre'];
$imprimir_sub     = $res['sub'];
$imprimir_linha   = $res['linhas'];	
$frase='';

    $impressao_ordem = '';
    $cont = 0;
	$linha = 0;
    $frase.=$imprimir_topo;
	while($cont <= 50){
		$cont++;
		pt_register('POST','acao_'.$cont);
		pt_register('POST','acao_sel_'.$cont);
		pt_register('POST','acao_pedido_'.$cont);
        $id_pedido_item = ${'acao_'.$cont};
        
        if(${'acao_sel_'.$cont}=='on'){
		$bloco = '';

        $sql = $objQuery->SQLQuery("SELECT p.nome,p.cpf,p.endereco,p.cidade,p.estado,p.bairro,p.cep,p.tel,p.numero,p.complemento, pi.*, s.descricao as servico, u.nome as responsavel, u.email as responsavel_email from vsites_pedido as p, vsites_pedido_item as pi, vsites_user_usuario as u, vsites_servico as s where
        pi.id_servico=s.id_servico and
        pi.id_pedido_item='" . $id_pedido_item . "' and
        p.id_pedido=pi.id_pedido and
        u.id_usuario=pi.id_usuario and
        u.id_empresa='$controle_id_empresa'");
     	$res = mysql_fetch_array($sql);
		
		$linha_bloco = 1;
        $bloco = '';
		$ordem						                   = $res['ordem'];
        $servico                                       = $res['servico'];
        $responsavel                                   = $res['responsavel'];
        $responsavel_email                             = $res['responsavel_email'];
        $id_servico					                   = $res['id_servico'];
	    $id_pedido					                   = $res['id_pedido'];
	    $nome    					                   = $res['nome'];
	    $certidao_nome				                   = $res['certidao_nome'];
	    $certidao_cpf				                   = $res['certidao_cpf'];
	    $certidao_cnpj				                   = $res['certidao_cnpj'];
	    $cpf    					                   = $res['cpf'];
	    $bairro     				                   = $res['bairro'];
	    $cidade  					                   = $res['cidade'];
	    $estado 					                   = $res['estado'];
	    $cep     					                   = $res['cep'];
	    $endereco 					                   = $res['endereco'];
	    $complemento				                   = $res['complemento'];
	    $numero     				                   = $res['numero'];
	    $tel        				                   = $res['tel'];

        
        if($servico	                                        <>''){ $bloco .= " {\par \b ".$servico.'}'; $linha_bloco++; }
        if($certidao_nome	                                <>''){ $bloco .= " \par Nome: ".$certidao_nome; $linha_bloco++; }
	    if($certidao_cpf                                    <>''){ $bloco .= " \par CPF: ".$certidao_cpf; $linha_bloco++; }
	    if($certidao_cnpj                                   <>''){ $bloco .= " \par CNPJ: ".$certidao_cnpj; $linha_bloco++; }

        $bloco .= '\par\par\par\par\par\par \par \par \par '.$data_atual.'\par\par\par';
    	$bloco .= " \par\par\par\par \par\par ";
    	$linha_bloco=$linha_bloco+18;
    	$bloco .= "_______________________________________\par ";
    	$bloco .= " \par A/C: ".$nome; $linha_bloco++;
    	$bloco .= $endereco.' '.$numero.' '.$complemento.' \par '; $linha_bloco++;
    	$bloco .= $bairro. ' '.$cidade.' '.$estado.' '.$cep.'\par'; $linha_bloco++;
    	$bloco .= $tel.' \par '; $linha_bloco++;

		$soma_linha = $linha+$linha_bloco;
    	if($soma_linha>$imprimir_linha){
			while($linha<=$imprimir_linha){
			   $frase .= '{\par}';
			   $linha++;
			}		
			$frase_sub = str_replace('<responsavel>',$responsavel, $imprimir_sub).'{\par}';
			$frase_sub = str_replace('<responsavel_email>',$responsavel_email, $frase_sub).'{\par}';
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

		

        }
	}
    	if($linha<=$imprimir_linha and $linha!=0){
			while($linha<=$imprimir_linha){
			   $frase .= '{\par}';
			   $linha++;
			}
     		$frase_sub = str_replace('<responsavel>',$responsavel, $imprimir_sub).'{\par}';
			$frase_sub = str_replace('<responsavel_email>',$responsavel_email, $frase_sub).'{\par}';
			$frase_sub = str_replace('<impressao_ordem>',$impressao_ordem, $frase_sub);
			if($i+1<count($cartorio)){
		       $frase .= $frase_sub.'{\par}';
            } else {
               $frase .= $frase_sub;
            }
			$impressao_ordem = '';			
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

echo $output;
?>
