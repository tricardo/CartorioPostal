<?php
class ChamadoDAO extends Database{
	
	public function __construct(){		
		$this->table = 'vsites_chamado';
		parent::__construct();
	}
	
	public function listar(){
		$this->sql = 'SELECT * FFROM vsites_chamado as c';
		$this->values = array();
		return $this->fetch();
	}
	
	public function listarPorStatus($status){
		$this->sql = 'SELECT * FROM vsites_chamado c WHERE status = ?';
		$this->values = array($status);
		return $this->fetch();		
	}
	
	public function buscaPorId($id_chamado){
		$this->sql = 'SELECT * FROM vsites_chamado c WHERE id_chamado = ?';
		$this->values = array($id_chamado);
		$ret = $this->fetch();		
		return $ret[0];
	}
	
	public function busca($b ,$pagina){
		$this->values = array();
		$where = "WHERE 1=1 ";
		if($b->id_pedido<>""){
			$where .= " AND id_pedido = ?";
			$this->values[]=$b->id_pedido;
		}
		if($b->ordem<>""){
			$where .= " AND ordem = ?";
			$this->values[]=$b->ordem;			
		}
		if($b->id_empresa<>""){
			$where .= " AND c.id_empresa = ?";
			$this->values[]=$b->id_empresa;
		}
		if($b->id_usuario<>""){
			$where .= " AND c.id_usuario = ?";
			$this->values[]=$b->id_usuario;
		}
		if($b->status<>""){
			$where .= " AND c.status = ?";
			$this->values[]=$b->status;
		}
		if($b->data_i<>""){
			$where .= " AND c.data_cadastro >= ?";
			$this->values[]=$b->data_i.' 00:00:00';
		}		
		if($b->data_f<>""){
			$where .= " AND c.data_cadastro <= ?";
			$this->values[]=$b->data_f.'23:59:59';
		}		
		if($b->forma_atend > 0){
			$where .= " AND c.forma_atend = ?";
			$this->values[] = $b->forma_atend;
		}
		$this->sql = "SELECT count(0) as total 
						FROM ".$this->table." as c 
						INNER JOIN vsites_user_empresa e ON 
						c.id_empresa = e.id_empresa ".$where;
		$cont = $this->fetch();
		$this->total = $cont[0]->total;

		$link_busca = 'id_pedido='.$b->id_pedido.'&ordem='.$b->ordem.'&id_empresa='.$b->id_empresa.
			'&id_usuario='.$b->id_usuario.'&data_i='.$b->data_i2.'&data_f='.$b->data_f2.'&status='.
			$b->status.'&forma_atend='.$b->forma_atend;
		$this->link = 'busca='.$link_busca;		
		$this->pagina = $pagina;

		$this->sql = "SELECT c.*,e.fantasia as franquia FROM ".$this->table." as c 
				INNER JOIN vsites_user_empresa e ON 
				c.id_empresa = e.id_empresa ".$where." ORDER BY data_cadastro desc, id_pedido,ordem "
				." LIMIT ".$this->getInicio().", ".$this->maximo;				
		return $this->fetch();
	}
	
	public function inserir($c,$id_usuario){
		$dt = ($c->status == '1') ? date('Y-m-d H:i:s') : '0000-00-00 00:00:00';
		$this->fields = array('id_pedido','ordem','id_empresa','id_usuario','status','pergunta','resposta','data_cadastro','data_atualizacao','forma_atend');
		$this->values = array('id_pedido'=>$c->id_pedido,'ordem'=>$c->ordem,'id_empresa'=>$c->id_empresa,'id_usuario'=>$id_usuario,
						'status'=>$c->status,'pergunta'=>$c->pergunta,'resposta'=>$c->resposta,'data_cadastro'=>date('Y-m-d H:i:s'),'data_atualizacao'=>$dt,'forma_atend'=>$c->forma_atend);
		return $this->insert();
	}
	
	public function acao_mail($acao, $c){
		
		#echo $c->subject.'-'.strlen($c->mensagem); exit;
		if($acao == 1){
			$this->fields = array('id_pedido', 'ordem', 'id_empresa', 'id_usuario', 'status', 'pergunta', 
				'resposta', 'data_cadastro', 'data_atualizacao', 'forma_atend');
			$this->values = array('id_pedido'=>0, 'ordem'=>0, 'id_empresa'=>$c->id_empresa, 'id_usuario'=>$c->id_usuario,
				'status'=>$c->stt, 'pergunta'=>$c->subject, 'resposta'=>$c->mensagem, 'data_cadastro'=>$c->data,
				'data_atualizacao'=>$c->data, 'forma_atend'=>2);
				#print_r($this); exit;
			return $this->insert();
		} else {
			$sql = 'UPDATE '.$this->table.' SET status=?, data_atualizacao=?, resposta=? ';
			$sql .= 'WHERE id_chamado = ?';
			$this->sql = $sql;
			$this->values = array($c->stt, date('Y-m-d H:i:s'), $c->mensagem, $c->id_chamado);
			#print_r($this); exit;
			return $this->exec();
		}
	}
	
	public function atualizar($c){
		$sql = 'UPDATE '.$this->table.' SET id_pedido=?,ordem=?,status=?,pergunta=?,resposta=?,forma_atend=?';
		if(isset($c->data1)){ $sql .= ",data_cadastro='".$c->data1."'"; }
		if(isset($c->data2)){ $sql .= ",data_atualizacao='".$c->data2."'"; }
		$sql .= 'WHERE id_chamado = ?';
		$this->sql = $sql;
		$this->values = array($c->id_pedido,$c->ordem,$c->status,$c->pergunta,$c->resposta,$c->forma_atend,$c->id_chamado);
		$this->exec();
	}
	
	public function rel_chamado($b){
		$this->values = array();
		$where = "WHERE 1=1 ";
		if($b->id_pedido<>""){
			$where .= " AND id_pedido = ?";
			$this->values[]=$b->id_pedido;
		}
		if($b->ordem<>""){
			$where .= " AND ordem = ?";
			$this->values[]=$b->ordem;			
		}
		if($b->id_empresa<>""){
			$where .= " AND c.id_empresa = ?";
			$this->values[]=$b->id_empresa;
		}
		if($b->id_usuario<>""){
			$where .= " AND c.id_usuario = ?";
			$this->values[]=$b->id_usuario;
		}
		if($b->status<>""){
			$where .= " AND c.status = ?";
			$this->values[]=$b->status;
		}
		if($b->ano_i != '' && $b->mes_i != ''){
			$data = $b->ano_i .'-'. $b->mes_i . '-1 00:00:00';
			$where .= " AND c.data_cadastro >= ?";
			$this->values[]=$data;
		}
		if($b->forma_atend != '0'){
			$where .= " AND c.forma_atend = ?";
			$this->values[] = $b->forma_atend;
		}
		if($b->ano_f != '' && $b->mes_f != ''){
			switch($b->mes_f){
				case 1: case 3: case 5: case 7: case 8: case 10: case 12: $dia = 31; break;
				case 2: 
					$dia = ((date('Y')%4) == 0) ? 29 : 28; 
					break;
				default: $dia = 30;
			}
			$data = $b->ano_f .'-'. $b->mes_f . '-'.$dia.' 23:59:59';
			$where .= " AND c.data_cadastro <= ?";
			$this->values[]=$data;
		}
		$this->sql = "SELECT count(0) as total 
						FROM ".$this->table." as c 
						INNER JOIN vsites_user_empresa e ON c.id_empresa = e.id_empresa 
						INNER JOIN vsites_user_usuario u ON c.id_usuario = u.id_usuario
						".$where;
		$cont = $this->fetch();
		$total = $cont[0]->total;


		$this->sql = "SELECT c.*,e.fantasia as franquia, u.nome FROM ".$this->table." as c 
				INNER JOIN vsites_user_empresa e ON c.id_empresa = e.id_empresa 
				INNER JOIN vsites_user_usuario u ON c.id_usuario = u.id_usuario
				".$where." ORDER BY data_cadastro";
				/*print_r($this->sql);
				echo '<br />';
				print_r($b);
				echo '<br />'.$data;
				exit;*/
		return array($total, $this->fetch());
	}
	
	public function f_usuario($email){
		$email = str_replace('rafael.nascimento@cartoriopostal.com.br','ti@cartoriopostal.com.br',$email);
		$email = str_replace('rafael.nascimento@softfox.com.br','ti@cartoriopostal.com.br',$email);
		$email = str_replace('antonio.alves@softfox.com.br','ti@cartoriopostal.com.br',$email);
		$email = str_replace('erick.melo@softfox.com.br','ti@cartoriopostal.com.br',$email);
		
		if($email != 'ti@cartoriopostal.com.br'){
			$this->sql    = "SELECT uu.id_empresa, uu.id_usuario FROM vsites_user_usuario AS uu WHERE uu.email = ?";
			$this->values = array($email);
			$dt = $this->fetch();
			if(count($dt) > 0){
				return array($dt[0]->id_empresa, $dt[0]->id_usuario);
			} else {
				return array(1,1);
			}
		} else {
			return array(1,1);
		}
	}
	
	public function send_mail($total){
		$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
			"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
			<title>Sistema Sistecart - Cron Chamados</title>
			</head>
			<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
			São Paulo, '.date('d').' de '.$mes.' de '.date('Y').'.<br /> 
			Hora: '.date('H').':'.date('i').'. <br /><br />
			
			Foi(ram) cadastrado(s) '.$total.' chamado(s) no sistema.<br /><br />

			Atenciosamente,<br />
			Equipe Cartório Postal.
			</body>
			</html>';
			
	
		include("../../includes/maladireta/class.PHPMailer.php");
		$mailer = new SMTPMailer();

		$From = 'Sistema';
		$AddAddress = 'ti@cartoriopostal.com.br,TI;';
		$Subject = 'TI - Cron Chamados';
		$mailer->SEND($From, $AddAddress, '', '', '', $Subject, $html);			
	}
	
	public function DecodificaMensagem($Mensagem, $Codificacao){
		switch($Codificacao){
			case 0: case 1: $Mensagem   = imap_8bit($Mensagem); break;
			case 2: $Mensagem   = imap_binary($Mensagem); break;
			case 3: case 5: case 6: case 7: $Mensagem   = imap_base64($Mensagem); break;
			case 4: $Mensagem   = imap_qprint($Mensagem); break;
		 }
		 return $Mensagem;
	 }
	
	public function LimparLinha($msg){
		$cont = 0;
		if(substr_count($msg, '_NextPart') > 0 && $cont == 0){ $cont++; }
		if(substr_count($msg, 'Content') > 0 && $cont == 0){ $cont++; }
		if(substr_count($msg, 'charset') > 0 && $cont == 0){ $cont++; }
		if(substr_count($msg, 'name=') > 0 && $cont == 0){ $cont++; }
		if(substr_count($msg, 'This is a multi-part') > 0 && $cont == 0){ $cont++; }
		
		return $cont;
	}
	
	public function buscar_cham_mail($subject, $id_empresa, $_usuario){
		$this->sql = "SELECT c.* FROM vsites_chamado AS c WHERE 
			(c.pergunta LIKE '%".$subject."%') AND c.id_empresa = ? AND c.id_usuario = ? AND c.status = 0";
		$this->values = array($id_empresa, $_usuario);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	public function chamado_mail(){
		function mes($mes){
			switch($mes){
				case 'Jan': $mes = '01'; break;
				case 'Fev': $mes = '02'; break;
				case 'Mar': $mes = '03'; break;
				case 'Apr': $mes = '04'; break;
				case 'May': $mes = '05'; break;
				case 'Jun': $mes = '06'; break;
				case 'Jul': $mes = '07'; break;
				case 'Aug': $mes = '08'; break;
				case 'Sep': $mes = '09'; break;
				case 'Oct': $mes = '10'; break;
				case 'Nov': $mes = '11'; break;
				case 'Dec': $mes = '12'; break;
			}
			return $mes;
		}
			
		global $controle_id_empresa, $controle_id_usuario;
				
		$servidor = "mail.cartoriopostal.com.br";
		$usuario = "suporte@cartoriopostal.com.br";
		$senha = "a123d321";
		
		@ini_set('display_errors', '0');
		$mbox = imap_open("{".$servidor.":143/novalidate-cert}INBOX",$usuario,$senha);
		
		$erro[] = imap_last_error();
		if ($erro[0] == "") {
			for($i = 0; $i < imap_num_msg($mbox); $i++) {
				# **************************************************************
				date_default_timezone_set('America/Sao_Paulo');
				$headers = imap_header($mbox, $i);
				if($controle_id_empresa == 1 && $controle_id_usuario == 1){
					
					print_r($mbox); exit;
				}
					
				$email = $headers->from[0]->mailbox.'@'.$headers->from[0]->host;
				if(substr_count($email, 'cartoriopostal') > 0 || substr_count($email, 'softfox') > 0){
					#***************************************************************
					$data = str_replace(' ',',',$headers ->date);
					$data = explode(',', $data);
					$mes  = mes($data[3]);
					$dia  = ($data[2] < 10) ? '0'.$data[2] : $data[2];
					$data = $data[4].':'.$mes.':'.$dia.' '.$data[5];
				
					# **************************************************************
					$usuario = $headers->from[0]->mailbox.'@'.$headers->from[0]->host;
					$usuario = $this->f_usuario($usuario); 
					$usuario = (count($usuario) == 0) ? 1 : $usuario[1];
					
					# **************************************************************
					$empresa = $headers->to[0]->mailbox.'@'.$headers->to[0]->host;
					$empresa = $this->f_usuario($empresa);
					$empresa = $empresa[0];
					
					# **************************************************************
					$h  = "<b>De: </b>" . $headers->fromaddress . " [".$headers->from[0]->mailbox.'@'.
						$headers->from[0]->host."]<br />\n";
					$h .= "<b>Para: </b>"; 
					for($c = 0; $c < count($headers->to); $c++){
						if(strlen($headers->to[$c]->personal) > 0){
							$h .= $headers->to[$c]->personal . " [".$headers->to[$c]->mailbox.'@'.
								$headers->to[$c]->host."]";
						} else {
							$h .= $headers->to[$c]->mailbox.'@'.$headers->to[$c]->host;
						}
						$h .= ($c < count($headers->to) - 1) ? '; ' : '';
					}
					$h .= "<br />\n";
					if(count($headers->cc) > 0){
						$h .= "<b>Cc: </b>";
						for($c = 0; $c < count($headers->cc); $c++){
							if(strlen($headers->cc[$c]->personal) > 0){
								$h .= $headers->cc[$c]->personal. " [".$headers->cc[$c]->mailbox.'@'.
									$headers->cc[$c]->host."]";
							} else {
								$h .= $headers->cc[$c]->mailbox.'@'.$headers->cc[$c]->host;
							}
							$h .= ($c < count($headers->cc) - 1) ? '; ' : '';
						}
						$h .= "<br />\n";
					}
					$headers->subject = strip_tags($headers->subject);
					#if($controle_id_empresa == 1 && $controle_id_usuario == 1){
						if(substr_count($headers->subject, 'iso-8859-1') > 0){
							$subject = imap_mime_header_decode($headers->subject);
							$headers->subject = $subject[0]->text;
						}
					#}
					$h .= "<b>Enviada em: </b>". $headers->date . "<br />\n";
					$h .= "<b>Assunto: </b>". $headers->subject. "<br /><br />\n\n";
					$msg = imap_qprint(imap_body($mbox, $i));
					$msg = strip_tags($msg);
					if(substr_count($msg, 'Content-ID') > 0){
						$msg = explode("Content-ID", $msg);
						$msg = explode("\n", $msg[0]);
					} else {
						$msg = explode("\n", $msg);
					}
					$mensagem = '';
					for($k = 0; $k < count($msg); $k++){
						$msg[$k] = str_replace('&nbsp;', ' ', $msg[$k]);
						$msg[$k] = trim($msg[$k]);
						if(strlen(trim($msg[$k])) > 0){
							$cont = $this->LimparLinha($msg[$k]);
							if($cont == 0 && strlen(trim($msg[$k])) > 0){
								if(substr_count($msg[$k], 'De: ') > 0){
									if(substr_count($msg[$k], '@cartoriopostal.com.br') > 0 ||
										substr_count($msg[$k], '@softfox.com.br') > 0 ||
										substr_count($msg[$k], '@sistecart.com.br') > 0 ||
										substr_count($msg[$k], '@seupetcomsobrenome.com.br') > 0 ||
										substr_count($msg[$k], '@franchiseemporium.com.br') > 0){
										$k = count($msg);
									} else {
										$mensagem .= $msg[$k]."<br /><br />\n\n";
									}
								} else {
									$mensagem .= $msg[$k]."<br /><br />\n\n";
								}
							}
						}
					}
					# **************************************************************
					if(strlen($mensagem) > 0){
						#if($controle_id_empresa == 1 && $controle_id_usuario == 1){
			
							$mensagem = $h . $mensagem;
							$stt = (substr_count(strtolower($headers->subject), '| aberto') == 0 ||
								ubstr_count(strtolower($headers->subject), '|aberto') == 0) ? 1 : 0;
							$headers->subject = str_replace('| aberto','',$headers->subject);
							$headers->subject = str_replace('|aberto','',$headers->subject);
							$headers->subject = str_replace('RES: ','',$headers->subject);
							$headers->subject = trim($headers->subject);
											
							# **************************************************************
							$this->sql = "SELECT c.* FROM vsites_chamado AS c WHERE 
								(c.pergunta LIKE '%".$headers->subject."%') AND c.id_empresa = ? AND c.id_usuario = ?";
							$this->values = array($empresa, $usuario);
							$dt = $this->fetch();
							if(count($dt) == 0){
								$this->fields = array('id_pedido', 'ordem', 'id_empresa', 'id_usuario', 'status', 'pergunta', 
									'resposta', 'data_cadastro', 'data_atualizacao', 'forma_atend');
								$this->values = array('id_pedido'=>0, 'ordem'=>0, 'id_empresa'=>$empresa, 'id_usuario'=>$usuario,
									'status'=>$stt, 'pergunta'=>$headers->subject, 'resposta'=>$mensagem, 'data_cadastro'=>$data,
									'data_atualizacao'=>$data, 'forma_atend'=>2);
								if($controle_id_empresa == 1 && $controle_id_usuario == 1){
									$dt = $this->insert();
									
								} else {
									$this->insert();#comentar se precisar
								}
							} else {
								if($dt[0]->status == 0){
									$sql = 'UPDATE '.$this->table.' SET status=?, data_atualizacao=?, pergunta=?, resposta=? ';
									$sql .= 'WHERE id_chamado = ?';
									$this->sql = $sql;
									$this->values = array($stt, date('Y-m-d H:i:s'), $headers->subject, $mensagem.$dt[0]->resposta,
										$dt[0]->id_chamado);
									if($controle_id_empresa == 1 && $controle_id_usuario == 1){
										$dt = $this->exec();
									} else {
										$this->exec();#comentar se precisar
									}
								}
							}
						
						#}
					}
					#echo $mensagem."\n\n\n";
				} 
				if($controle_id_empresa == 1 && $controle_id_usuario == 1){
					#$headers = imap_header($mbox, $i);
					#$teste = imap_headerinfo($mbox, $i);
					#print_r($teste); echo "\n\n";
					print_r(imap_errors());
					exit;
					imap_delete($mbox, $i);		
					print_r(imap_errors());
					
					echo $headers->message_id;
				}				
			}
			if($controle_id_empresa == 1 && $controle_id_usuario == 1){ imap_expunge($mbox); }
		}
		if($controle_id_empresa == 1 && $controle_id_usuario == 1){ imap_close($mbox); }
	}
	
	public function chamado_mail2(){
		function mes($mes){
			switch($mes){
				case 'Jan': $mes = '01'; break;
				case 'Fev': $mes = '02'; break;
				case 'Mar': $mes = '03'; break;
				case 'Apr': $mes = '04'; break;
				case 'May': $mes = '05'; break;
				case 'Jun': $mes = '06'; break;
				case 'Jul': $mes = '07'; break;
				case 'Aug': $mes = '08'; break;
				case 'Sep': $mes = '09'; break;
				case 'Oct': $mes = '10'; break;
				case 'Nov': $mes = '11'; break;
				case 'Dec': $mes = '12'; break;
			}
			return $mes;
		}
			
		$servidor = "mail.cartoriopostal.com.br";
		$usuario = "suporte@cartoriopostal.com.br";
		$senha = "a123d321";
		
		@ini_set('display_errors', '0');
		$mbox = imap_open("{".$servidor.":143/novalidate-cert}INBOX",$usuario,$senha);
		
		$erro[] = imap_last_error();
		if ($erro[0] == "") {
			for($i = 1;$i <= imap_num_msg($mbox);$i++) {
				# **************************************************************
				date_default_timezone_set('America/Sao_Paulo');
				$headers = imap_header($mbox, $i);
					
				$email = $headers->from[0]->mailbox.'@'.$headers->from[0]->host;
				if(substr_count($email, 'cartoriopostal') > 0 || substr_count($email, 'softfox') > 0){
					#***************************************************************
					$data = str_replace(' ',',',$headers ->date);
					$data = explode(',', $data);
					$mes  = mes($data[3]);
					$dia  = ($data[2] < 10) ? '0'.$data[2] : $data[2];
					$data = $data[4].':'.$mes.':'.$dia.' '.$data[5];
				
					# **************************************************************
					$usuario = $headers->from[0]->mailbox.'@'.$headers->from[0]->host;
					$usuario = $this->f_usuario($usuario); 
					$usuario = (count($usuario) == 0) ? 1 : $usuario[1];
					
					# **************************************************************
					$empresa = $headers->to[0]->mailbox.'@'.$headers->to[0]->host;
					$empresa = $this->f_usuario($empresa);
					$empresa = $empresa[0];
					
					# **************************************************************
					$h  = "<b>De: </b>" . $headers->fromaddress . " [".$headers->from[0]->mailbox.'@'.
						$headers->from[0]->host."]<br />\n";
					$h .= "<b>Para: </b>" . $headers->to[0]->personal . " [".$headers->to[0]->mailbox.'@'.
						$headers->to[0]->host."]<br />\n";
					$h .= "<b>Enviada em: </b>". $headers->date . "<br />\n";
					$h .= "<b>Assunto: </b>". $headers->subject . "<br /><br />\n\n";
					$msg = imap_qprint(imap_body($mbox, $i));
					$msg = strip_tags($msg);
					if(substr_count($msg, 'Content-ID') > 0){
						$msg = explode("Content-ID", $msg);
						$msg = explode("\n", $msg[0]);
					} else {
						$msg = explode("\n", $msg);
					}
					$mensagem = '';
					for($k = 0; $k < count($msg); $k++){
						$msg[$k] = str_replace('&nbsp;', ' ', $msg[$k]);
						$msg[$k] = trim($msg[$k]);
						if(strlen(trim($msg[$k])) > 0){
							$cont = $this->LimparLinha($msg[$k]);
							if($cont == 0 && strlen(trim($msg[$k])) > 0){
								if(substr_count($msg[$k], 'De: ') > 0){
									if(substr_count($msg[$k], '@cartoriopostal.com.br') > 0){
										$k = count($msg);
									} else {
										$mensagem .= $msg[$k]."<br /><br />\n\n";
									}
								} else {
									$mensagem .= $msg[$k]."<br /><br />\n\n";
								}
							}
						}
					}
					# **************************************************************
					if(strlen($mensagem) > 0){
						$mensagem = $h . $mensagem;
						$this->sql = "SELECT c.id_chamado FROM vsites_chamado AS c WHERE 
							c.pergunta = ? AND c.data_atualizacao = ?";
						$this->values = array($headers->subject, $data);
						$dt = $this->fetch();
						if(count($dt) == 0){
							$headers->subject = utf8_encode($headers->subject);
							$$mensagem        = utf8_encode($mensagem);
							$this->fields = array('id_pedido', 'ordem', 'id_empresa', 'id_usuario', 'status', 'pergunta', 
								'resposta', 'data_cadastro', 'data_atualizacao', 'forma_atend');
							$this->values = array('id_pedido'=>0, 'ordem'=>0, 'id_empresa'=>$empresa, 'id_usuario'=>$usuario,
								'status'=>1, 'pergunta'=>$headers->subject, 'resposta'=>$mensagem, 'data_cadastro'=>$data,
								'data_atualizacao'=>$data, 'forma_atend'=>2);
							return $this->insert();
						}
					}
					#echo $mensagem."\n\n\n";
				}
			}
		}
	}
}

?>
