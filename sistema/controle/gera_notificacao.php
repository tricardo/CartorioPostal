<?php
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
	
// chama a classe 'class.ezpdf.php' necessária para se gerar o documento
include "gerapdf/class.ezpdf.php";

// instancia um novo documento com o nome de pdf
$pdf = new Cezpdf('A4','landscap');
// seta a fonte que será usada para apresentar os dados
//essas fontes são aquelas dentro do diretório gerapdf/fonts
$pdf->selectFont('gerapdf/fonts/Helvetica.afm');

$cont='0';
$cont_on = '0';
	while($cont <= 50){
		$cont++;
		pt_register('POST','acao_'.$cont);
		pt_register('POST','acao_sel_'.$cont);
		pt_register('POST','acao_pedido_'.$cont);
        
        if(${'acao_sel_'.$cont}=='on'){
		
		$cont_on .= ','.${'acao_'.$cont};
        $sql = $objQuery->SQLQuery("SELECT un.*, n.empresa as n_empresa, n.cpf as n_cpf,n.rg as n_rg,n.nome as n_nome, n.endereco as n_endereco,n.complemento as n_complemento,n.numero as n_numero,n.bairro as n_bairro,n.cidade as n_cidade,n.estado as n_estado,n.cep as n_cep from vsites_user_notificante as un, vsites_notificado as n where 
		n.id_notificado='".${'acao_'.$cont}."' and 
		n.id_notificante=un.id_notificante and 
		un.id_empresa='".$controle_id_empresa."'");
     	$res = mysql_fetch_array($sql);
     	$num = mysql_num_rows($sql);

		if ($num<>''){
          
		$cpf						                   = $res['cpf'];
		$rg                                            = $res['rg'];
        $empresa                                       = $res['empresa'];
		$cel                                           = $res['cel'];
		$tel                                           = $res['tel'];
		$email                                         = $res['email'];
		$assinatura1                                   = $res['assinatura1'];
		$assinatura2                                   = $res['assinatura2'];
		$texto                                         = $res['texto'];
		
		$n_empresa                                        = $res['n_empresa'];
		if($n_empresa=='')
		$n_empresa                                        = $res['n_nome'];
		
		$n_cpf                                            = $res['n_cpf'];
		$n_rg                                             = $res['n_rg'];
		$n_endereco                                       = $res['n_endereco'];
		$n_complemento                                    = $res['n_complemento'];
		$n_numero                                         = $res['n_numero'];
		$n_bairro                                         = $res['n_bairro'];
		$n_cidade                                         = $res['n_cidade'];
		$n_estado                                         = $res['n_estado'];
		
		
	
	$pdf-> ezSetMargins(10,10,25,20);
$pdf->ezText('Notificação',16,array('justification'=>'center'));		
$pdf->ezText('
'.$data_atual,12,array('justification'=>'left'));	
$pdf->ezText('
'.$n_empresa,14);		
       
$pdf->ezText('Documento: '.$n_cpf.'
'.$n_endereco.', '.$n_numero.' '.$n_complemento.'
'.$n_bairro.' - '.$n_cidade.' - '.$n_estado.'

'.$texto.'



',12);

$pdf->ezImage('../assinaturas/'.$assinatura1,0, 100,'','center');

$pdf->ezText('Responsável',12,array('justification'=>'center'));	        

$pdf->ezText($empresa.'
'.$cpf.'
'.$tel.' - '.$email,12,array('justification'=>'center'));
$pdf->ezNewPage();




		}

        }
	}		
	$pdf->ezStream();
	    
        $sql = $objQuery->SQLQuery("update vsites_user_notificante as un, vsites_notificado as n set n.data_envio=NOW(), n.status='Enviado' where 
		un.id_empresa='".$controle_id_empresa."' and
		n.id_notificante=un.id_notificante and
		n.data_envio='0000-00-00' and
		n.id_notificado in(".$cont_on.")");	
?>