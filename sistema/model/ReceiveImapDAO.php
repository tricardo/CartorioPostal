<? class ReceiveImapDAO {

	public $server, $user, $pass, $mail, $box;
	public $subject, $message_id, $body;
	public $mail_to, $mail_from, $mail_cc;
	public $date_received_text, $date_received_number;
	public $send_to, $send_from;
	

	public function ReceiveImapDAO($user, $pass, $mail, $server = 'localhost', $type = 'pop', $port = '100', $ssl = false){
		$conn = '{'.$server.':'.$port. '/pop3'.($ssl ? "/ssl" : "").'}INBOX'; 
		if($type == 'imap'){
			$port = ($port == '') ? '143' : $port; 
			$conn = '{'.$server.':'.$port. '}INBOX'; 
		}
		$this->server= $conn;
		$this->user  = $user;
		$this->pass	 = $pass;
		$this->mail	 = $mail;
	}
	
	public function connect(){
		$this->box= imap_open($this->server, $this->user, $this->pass);		
		if(!$this->box){ echo "Sem conexão com o servidor!"; exit; }
	}
	
	public function disconnect(){
		if(!$this->box){ return false; }
		imap_close($this->box, CL_EXPUNGE);
	}
	
	public function total(){
		if(!$this->box){ 
			return 0; 
		} else {
			return count(imap_headers($this->box));
		}
	}
	
	public function delete($token){
		if(!$this->box){ return false; }
		imap_delete($this->box, $token);
	}
	
	public function headers($token){
		if(!$this->box){ return false; }
		$headers          = imap_header($this->box, $token);
		$this->encode_subject($headers->subject);
		$this->message_id = $headers->message_id;
		$this->send_date($headers->date);
		$this->mail_to_address($headers->to);
		$this->mail_from_address($headers->fromaddress, $headers->from);
		$this->mail_cc_address($headers->cc);
		$this->mail_body($token);
	}
	
	public function format_charset($subject){
		$mime = 0;
		if(substr_count(strtolower($subject), 'iso-88') > 0){ $mime = 1; }
		if(substr_count(strtolower($subject), 'utf-') > 0 && $mime == 0){ $mime = 1; }
		if($mime == 1){
			$subject = strip_tags($subject);
			$subject = imap_mime_header_decode($subject);
			$subject = $subject[0]->text;
		}
		return $subject;
	}
	
	public function encode_subject($subject){
		$this->subject = $this->format_charset($subject);
	}
	
	public function mail_body($token){
		if(!$this->box){ return false; }
		$body = $this->get_part($this->box, $token, "TEXT/HTML");
		if($body == ""){
			$body = $this->get_part($this->box, $token, "TEXT/PLAIN");
		}
		$this->body = $body;
	}
	
	function get_mime_type(&$structure){ 
		$primary_mime_type = array("TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER"); 
		if($structure->subtype) { 
			return $primary_mime_type[(int) $structure->type] . '/' . $structure->subtype; 
		} 
		return "TEXT/PLAIN"; 
	} 
	
	public function get_part($stream, $msg_number, $mime_type, $structure = false, $part_number = false){ 
		$structure = (!$structure) ? imap_fetchstructure($stream, $msg_number) : $structure; 
		if($structure) { 
			if($mime_type == $this->get_mime_type($structure)){ 
				if(!$part_number){ $part_number = "1"; } 
				$text = imap_fetchbody($stream, $msg_number, $part_number); 
				if($structure->encoding == 3){  return imap_base64($text);  } 
				else if($structure->encoding == 4){  return imap_qprint($text); } 
				else {  return $text; } 
			} 
			if($structure->type == 1) { 
				while(list($index, $sub_structure) = each($structure->parts)){ 
					if($part_number){  $prefix = $part_number . '.';  } 
					$data = $this->get_part($stream, $msg_number, $mime_type, $sub_structure, $prefix . ($index + 1)); 
					if($data){ return $data; } 
				} 
			} 
		} 
		return false; 
	} 
	
	public function mail_header(){
		$mail_header = '<strong>Enviada em: </strong>' . $this->dates_types(4, $this->date_received_text)."<br />\n";
		$mail_header .= (strlen($this->mail_from) > 0) ? $this->mail_from : '';
		$mail_header .= (strlen($this->mail_to) > 0) ? $this->mail_to : '';
		$mail_header .= (strlen($this->mail_cc) > 0) ? $this->mail_cc : '';
		$mail_header .= '<strong>Assunto: </strong>'.$this->subject."<br /><br />\n\n";
		return $mail_header;
	}
	
	public function mail_to_address($to){
		for($i = 0; $i < count($to); $i++){
			$to[$i]->personal = $this->format_charset($to[$i]->personal);
			$mail_to .= ($i == 0) ? "<strong>Para: </strong>" : "";
			$mail_to .= (strlen($to[$i]->personal) > $to[$i]->personal) ? str_replace("'", "", $to[$i]->personal) : "";
			$mail_to .= " [".$to[$i]->mailbox.'@'.$to[$i]->host."]";
			$mail_to .= ($i == count($to) - 1) ? "<br />\n" : ', ';
			if($i == 0){ $this->send_to = $to[$i]->mailbox.'@'.$to[$i]->host; }
		}
		$this->mail_to = $mail_to;
	}
	
	public function mail_cc_address($cc){
		for($i = 0; $i < count($cc); $i++){
			$cc[$i]->personal = $this->format_charset($cc[$i]->personal);
			$mail_cc .= ($i == 0) ? "<strong>Cc: </strong>" : "";
			$mail_to .= (strlen($cc[$i]->personal) > $cc[$i]->personal) ? str_replace("'", "", $cc[$i]->personal) : "";
			$mail_cc .= " [".$cc[$i]->mailbox.'@'.$cc[$i]->host."]";
			$mail_cc .= ($i == count($cc) - 1) ? "<br />\n" : ', ';
		}
		$this->mail_cc = $mail_cc;
	}
	
	public function mail_from_address($from_address, $from){
		for($i = 0; $i < count($from); $i++){
			$from[$i]->fromaddress = $this->format_charset($from[$i]->fromaddress);
			$mail_from .= ($i == 0) ? "<strong>De: </strong>" : "";
			$mail_from .= (strlen($from[$i]->fromaddress) > $from[$i]->fromaddress) ? str_replace("'", "", $from[$i]->fromaddress) : "";
			$mail_from .= " [".$from[$i]->mailbox.'@'.$from[$i]->host."]";
			$mail_from .= ($i == count($from) - 1) ? "<br />\n" : ', ';
			if($i == 0){ $this->send_from = $from[$i]->mailbox.'@'.$from[$i]->host; }
		}
		$this->mail_from = $mail_from;
	}
	
	public function send_date($data){
		$this->date_received_text   = $data;
		$this->date_received = $this->dates(1, $data);
	}
	
	public function dates($acao, $data){
		switch($acao){
			case 1:
				$data = explode(' ', $data);
				return $data[3].'-'.$this->dates_types(1, $data[2]).'-'.$data[1].' '.$data[4];
				break;
		}
	}
	
	public function dates_types($acao, $ret){
		switch($acao){
			case 1:
				switch($ret){
					case 'Jan': $ret = '01'; break;
					case 'Fev': $ret = '02'; break;
					case 'Mar': $ret = '03'; break;
					case 'Apr': $ret = '04'; break;
					case 'May': $ret = '05'; break;
					case 'Jun': $ret = '06'; break;
					case 'Jul': $ret = '07'; break;
					case 'Aug': $ret = '08'; break;
					case 'Sep': $ret = '09'; break;
					case 'Oct': $ret = '10'; break;
					case 'Nov': $ret = '11'; break;
					case 'Dec': $ret = '12'; break;
				}
				break;
			
			case 2:
				switch($ret){
					case 'Sun': $ret = 'Domingo'; break;
					case 'Mon': $ret = 'Segunda Feira'; break;
					case 'Tue': $ret = 'Terça Feira'; break;
					case 'Wed': $ret = 'Quarta Feira'; break;
					case 'Thu': $ret = 'Quinta Feira'; break;
					case 'Fri': $ret = 'Sexta Feira'; break;
					case 'Sat': $ret = 'Sábado'; break;
				}
				
			case 3:
				switch($ret){
					case 'Jan': $ret = 'Janeiro'; break;
					case 'Fev': $ret = 'Fevereiro'; break;
					case 'Mar': $ret = 'Março'; break;
					case 'Apr': $ret = 'Abril'; break;
					case 'May': $ret = 'Maio'; break;
					case 'Jun': $ret = 'Junho'; break;
					case 'Jul': $ret = 'Julho'; break;
					case 'Aug': $ret = 'Agosto'; break;
					case 'Sep': $ret = 'Setembro'; break;
					case 'Oct': $ret = 'Outubro'; break;
					case 'Nov': $ret = 'Novembro'; break;
					case 'Dec': $ret = 'Dezembro'; break;
				}
				break;	
				
			case 4:
				$ret = explode(' ', $ret);
				$dia = $this->dates_types(2, trim(str_replace(',', '', $ret[0])));
				$mes = $this->dates_types(3, trim(str_replace(',', '', $ret[2])));
				$ret = $dia.', '.$ret[1].' de '.$mes.' de '.$ret[3].' - '.$ret[4];
				break;
		}
		return $ret;
	}
	
	
} ?>