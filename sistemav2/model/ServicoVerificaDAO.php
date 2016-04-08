<? class ServicoVerificaDAO extends Database {

	public function verUFCid($acao, $servico, $cidade, $estado){
		$erro 		= 0;
		switch($servico){
			case 17:
			case 105:
				$erro = 1;
				break;
		}
		$err_est    = 0;
		$err_cid    = 0;
		$err_est_li = '';
		$err_cid_li = '';
		switch($acao){
			case 1:
				if($erro == 0){
					if(strlen($estado) == 0 OR strlen($cidade) == 0){
						if(strlen($estado) == 0){
							$err_est = 1;
							$err_est_li = "<li><b>Preencha o campo UF.</b></li>";
						}
						if(strlen($cidade) == 0){
							$err_cid = 1;
							$err_cid_li = "<li><b>Preencha o campo Cidade.</b></li>";
						}
					} return array($err_est, $err_cid, $err_est_li, $err_cid_li);
				}
				break;
			
			case 2:
				if($erros == 0){
					if(strlen($estado) == 0 OR strlen($cidade) == 0){
						if(strlen($estado) == 0){ $err_est = 1; }
						if(strlen($cidade) == 0){ $err_cid = 1; }
					} return array($err_est, $err_cid, $err_est_li, $err_cid_li);
				}
				break;
		}
		return array(0,0,'','');
	}


} ?>