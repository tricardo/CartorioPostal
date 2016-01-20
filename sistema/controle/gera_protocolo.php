<?
header( "Content-type: application/msword" );
header( 'Content-Disposition: attachment; filename="oficio.doc"');
ini_set('memory_limit', '50M');

require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

$sql = $objQuery->SQLQuery("SELECT empresa, endereco, numero, complemento, cidade, estado, tel, cep, email, fax  from vsites_user_empresa as ue where id_empresa='".$controle_id_empresa."'");
$res = mysql_fetch_array($sql);
$responsavel_empresa   = $res['empresa'];
$responsavel_cidade    = $res['cidade'];
$responsavel_email     = $res['email'];
$responsavel_bairro    = $res['bairro'];
$responsavel_cidade    = $res['cidade'];
$responsavel_estado    = $res['estado'];
$responsavel_cep       = $res['cep'];
$responsavel_endereco  = $res['endereco'];
$responsavel_complemento= $res['complemento'];
$responsavel_numero    = $res['numero'];
$responsavel_tel       = $res['tel'];

$responsavel_endereco   = $res['endereco'].','.$res['numero'].' '.$res['complemento'].'-'.$res['cidade'].'-'.$res['estado'].' CEP:'.$res['cep'];
$responsavel_tel        = $res['tel'].'/'.$res['fax'];

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

pt_register('POST','id_impresso');
$sql = $objQuery->SQLQuery("SELECT * from vsites_impresso as i where id_impresso='".$id_impresso."'");
$res = mysql_fetch_array($sql);
$imprimir_topo    = $res['topo'];
$id_impresso  	  = $res['id_impresso'];
$imprimir_timbre  = $res['timbre'];
$imprimir_sub     = $res['sub'];
$imprimir_linha   = $res['linhas'];
$frase='';
$imprimir_topo = str_replace('<responsavel_empresa>',$responsavel_empresa, $imprimir_topo);

$assinatura="";
$impressao_ordem = '';
$cont = 0;
$linha = 0;
$passou = 0;
$old_id_pedido = "";
$frase.=$imprimir_topo;
$p_id_pedido_item = explode (',',str_replace(',##','',$_COOKIE['p_id_pedido_item'].'##'));
#verifica permissão
foreach ($p_id_pedido_item as $chave => $id_pedido_item) {
	$sql = $objQuery->SQLQuery("SELECT pi.id_usuario, pi.certidao_nome_proprietario, p.nome,p.cpf,p.endereco,p.cidade,p.estado,p.bairro,p.cep,p.tel,p.numero,p.complemento, pi.ordem, pi.id_pedido, pi.certidao_nome, pi.certidao_cnpj, pi.certidao_cpf, p.contato, pi.certidao_estado, pi.certidao_cidade, pi.certidao_matricula, s.descricao as servico, u.nome as responsavel, u.email as responsavel_email
			,pi.certidao_transcricao,pi.certidao_cartorio,pi.id_empresa_resp
			from vsites_pedido as p, vsites_pedido_item as pi, vsites_user_usuario as u, vsites_servico as s where
			pi.id_pedido_item='" . $id_pedido_item . "' and
			pi.id_servico=s.id_servico and
			p.id_pedido=pi.id_pedido and
			(u.id_usuario=pi.id_usuario and
			u.id_empresa='".$controle_id_empresa."' or 
			u.id_usuario=pi.id_usuario_op and
			u.id_empresa='".$controle_id_empresa."')");
	$res = mysql_fetch_array($sql);
		
	$linha_bloco = 1;
	$bloco = '';

	$ordem						                   = $res['ordem'];
	$servico                                       = $res['servico'];
	$id_usuario					                   = $res['id_usuario'];
	$id_pedido					                   = $res['id_pedido'];
	$nome    					                   = $res['nome'];
	$contato    					               = $res['contato'];
	$certidao_nome				                   = $res['certidao_nome'].$res['certidao_nome_proprietario'];
	$certidao_cpf				                   = $res['certidao_cpf'];
	$certidao_cnpj				                   = $res['certidao_cnpj'];
	$certidao_endereco			                   = $res['certidao_endereco'];
	$certidao_cidade			                   = $res['certidao_cidade'];
	$certidao_estado			                   = $res['certidao_estado'];
	$cpf    					                   = $res['cpf'];
	$bairro     				                   = $res['bairro'];
	$cidade  					                   = $res['cidade'];
	$estado 					                   = $res['estado'];
	$cep     					                   = $res['cep'];
	$endereco 					                   = $res['endereco'];
	$complemento				                   = $res['complemento'];
	$numero     				                   = $res['numero'];
	$tel        				                   = $res['tel'];
	$certidao_matricula			                   = $res['certidao_matricula'];
	$certidao_cartorio			                   = $res['certidao_cartorio'];
	$certidao_transcricao		                   = $res['certidao_transcricao'];
	
	$sql = $objQuery->SQLQuery("SELECT ue.id_empresa, ue.empresa, ue.endereco,  ue.numero, ue.complemento,  ue.cidade,  ue.estado,  ue.tel,  ue.cep,  ue.email,  ue.fax  
		from vsites_user_empresa as ue, vsites_user_usuario as uu
		where id_usuario='".$res['id_usuario']."'
		and uu.id_empresa = ue.id_empresa");
	$end = mysql_fetch_array($sql);
	if($controle_id_empresa != $end['id_empresa']){
		$nome      = $end['empresa'];
		$cidade    = $end['cidade'];
		$email     = $end['email'];
		$bairro    = $end['bairro'];
		$cidade    = $end['cidade'];
		$estado    = $end['estado'];
		$cep       = $end['cep'];
		$endereco  = $end['endereco'];
		$complemento= $end['complemento'];
		$numero    = $end['numero'];
		$tel       = $end['tel'];
	}
	
	require('gera_protocolo_'.$id_impresso.'.php');
}
if($linha_a<=$imprimir_linha and $linha!=0){
	while($linha_a<=$imprimir_linha){
		$frase .= '\par';
		$linha++;
		$linha_a++;
	}

	$frase_sub = str_replace('<responsavel>',$responsavel, $imprimir_sub).'';
	$frase_sub = str_replace('<responsavel_empresa>',$responsavel_empresa, $frase_sub).'';
	$frase_sub = str_replace('<responsavel_email>',$responsavel_email, $frase_sub).'';
	$frase_sub = str_replace('<responsavel_endereco>',$responsavel_endereco, $frase_sub).'';
	$frase_sub = str_replace('<responsavel_tel>',$responsavel_tel, $frase_sub).'';
	$frase_sub = str_replace('<responsavel_fax>',$responsavel_fax, $frase_sub);
	$frase_sub = str_replace('<responsavel_cep>',$responsavel_cep, $frase_sub).'';
	$frase_sub = str_replace('<responsavel_cidade>',$responsavel_cidade, $frase_sub).'';
	$frase_sub = str_replace('<responsavel_estado>',$responsavel_estado, $frase_sub).'';
	$frase_sub = str_replace('<impressao_ordem>',$impressao_ordem, $frase_sub);
	$frase_sub = str_replace('<contato>',$contato, $frase_sub);
	$frase = str_replace('<servico>',$servico_topo, $frase);
	$frase = str_replace('<data_atual>',$data_atual, $frase);
	$frase = str_replace('<cliente>',$assinatura, $frase);
	$frase = str_replace('<franquia>',$assinatura, $frase);
	if($id_impresso!='32'){
		$frase .= $assinatura.$frase_sub;
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