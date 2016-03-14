<?php
ini_set('memory_limit','128M'); 
include('funcoes.php');


$chm = new ChamadoDAO();
$box = new ReceiveImapDAO('suporte+cartoriopostal.com.br','a123d321','suporte@cartoriopostal.com.br', 'mail.cartoriopostal.com.br',
	'imap', '143/novalidate-cert', false);

$box->connect();
$total = $box->total();
$cont = 0;

#$total = 10;

for($i = 1; $i <= $total; $i++){
	#exit;
	
	
	#******************************
	$box->headers($i);
	$size = (float)((float)mb_strwidth($box->body)) / 1024;
	
	if($size <= 15000){
			
		#verifica se o email que enviou foi cartorio, softfox, senão exclui
		if(substr_count($box->send_from, 'cartoriopostal') > 0 || substr_count($box->send_from, 'softfox') > 0){
			$subject = $box->subject;
			$subject = str_replace('Res:', '', $subject);
			$subject = str_replace('RES:', '', $subject);
			$subject = str_replace('Enc:', '', $subject);
			$subject = str_replace('Enc.', '', $subject);
			$subject = str_replace('enc:', '', $subject);
			$subject = str_replace('enc.', '', $subject);
			$subject = str_replace('ENC.', '', $subject);
			$subject = str_replace('ENC:', '', $subject);
			$subject = str_replace('Re:', '', $subject);
			$subject = str_replace('|aberto', '| aberto', $subject);
			$subject = str_replace('/aberto', '| aberto', $subject);
			$subject = str_replace('/ aberto', '| aberto', $subject);
			$stt = (substr_count(strtolower($subject), '| aberto') == 0) ? 1 : 0;
			$subject = str_replace('| aberto', '', $subject);
			
			$dt = $chm->f_usuario($box->send_from);
			$empresa = $dt[0];
			$id_usuario = $dt[1];
			$dt = $chm->f_usuario($box->send_to);
			$id_empresa = $dt[0];
			$mensagem   = $box->mail_header() . $box->body;
			

			if($empresa == 1){
				$dt = $chm->buscar_cham_mail(str_replace("'", "\'", trim($subject)), $id_empresa, $id_usuario);
				$c = new stdClass();
				$c->stt = $stt;
				if($dt != ''){
					$c->mensagem   = $dt->mensagem. "<br /><br /><br />\n\n\n" . $mensagem;
					$c->id_chamado = $dt->id_chamado;
					#
					$ret = $chm->acao_mail(2, $c);
				} else {
					$c->id_empresa = $id_empresa;
					$c->id_usuario = $id_usuario;
					$c->subject    = $subject;
					$c->mensagem   = $mensagem;
					$c->data	   = $box->date_received;
					#
					$ret = $chm->acao_mail(1, $c);
				}
			}
			
			#print_r($ret); echo '<br /><br />'; exit;
			#
			$box->delete($i); 
			$cont++;
		} else {
			#
			$box->delete($i); 
		}

	} else {
		$box->delete($i);
	}
}
if($cont > 0){
	#$chm->send_mail($cont);
}
$box->disconnect(); ?>
