<?php
class NovoSistemaDAO extends Database {
	
	var $html = '';
	
	public function status($acao = 1, $data){
		switch($acao){
			case 1:
					switch(strtolower($data->status)){
						case 'inativo': $data->status = 0; break;
						case 'ativo': $data->status = 1; break;
						case 'cancelado': $data->status = 2; break;
						case 'implantação': $data->status = 3; break;
						default: $data->status = 4;
					}
					return $data->status;
				break;
		}
	}
	
	public function tr($ret, $total1, $total2, $nome){
		$html = '<tr>
			<td style="border:solid 1px #222; text-align:center;">'.date('d/m/Y H:i:s').'</td>
			<td style="border:solid 1px #222; text-align:center;">'.$ret.'</td>
			<td style="border:solid 1px #222; text-align:center;">'.$total1.'</td>
			<td style="border:solid 1px #222; text-align:center;">'.$total2.'</td>
			<td style="border:solid 1px #222;">'.$nome.'</td>
			</tr>';
			return $html;
	}
	
	public function notnull($data){
		$ret = new stdClass();
		foreach($data AS $nome => $valor){
			$ret->$nome = (is_null($valor)) ? '' : $valor;
		}
		return $ret;
	}
	
	public function FranquiaImplantacao($acao = 1){		
		$sql = "SELECT ei.* FROM cartorio_banco2.vsites_user_empresa_implantacao AS ei";
		if($acao == 1){
			$this->sql = "SELECT e.id_empresa_imp FROM cartorio_banconovo.v_empresa_implantacao AS e 
			ORDER BY e.id_empresa_imp DESC LIMIT 1";
			$ret = $this->fetch();
			if(count($ret) > 0){
				$sql .= ' WHERE ei.id_empresa_imp > '. $ret[0]->id_empresa_imp;
			}
		}
		$this->sql = $sql;
		$ret = $this->fetch();		
		$total1 = 0;
		$total2 = 0;
		foreach($ret AS $data){		
			$data = $this->notnull($data);
			if($acao == 1){
				$this->sql = "INSERT INTO cartorio_banconovo.v_empresa_checklist_aprov (id_empresa_chk_aprov,
					id_empresa, passo, id_empresa_chk, ativo, data, data_e, observacao, id_usuario) VALUES (?,?,
					?,?,?,?,?,?,?)";
				$this->values = array($data->id_empresa_chk_aprov, $data->id_empresa, $data->passo, $data->id_empresa_chk, 
					$data->ativo, $data->data1, $data->data2, $data->observacao, $data->id_usuario);
			} else {
				$this->sql = "UPDATE cartorio_banconovo.v_empresa_checklist_aprov SET
				id_empresa = ?, passo = ?, id_empresa_chk = ?, ativo = ?, data = ?, data_e = ?, observacao = ?, id_usuario = ?
				WHERE id_empresa_chk_aprov = ? ";
				$this->values = array($data->id_empresa, $data->passo, $data->id_empresa_chk, 
					$data->ativo, $data->data1, $data->data2, $data->observacao, $data->id_usuario, $data->id_empresa_chk_aprov);
			}
			$exec = $this->exec();
			if($exec == 1){ $total1 = $total1 + 1; } else { $total2 = $total2 + 1; }
		}
		if($acao == 1){ 
			return $this->tr(count($ret),$total1,$total2,'Franq. Implantacao - Inserir'); 
		}
		return $this->tr(count($ret),$total1,$total2,'Franq. Implantacao - Editar');
	}
	
	public function FranquiaChecklist($acao = 1){
		$sql = "SELECT ec.* FROM cartorio_banco2.vsites_user_empresa_checklist_aprov AS ec";
		if($acao == 1){
			$this->sql = "SELECT ec.* FROM cartorio_banconovo.v_empresa_checklist_aprov AS ec 
				ORDER BY ec.id_empresa_chk_aprov DESC LIMIT 1";
			$ret = $this->fetch();
			if(count($ret) > 0){
				$sql .= ' WHERE ec.id_empresa_chk_aprov > '. $ret[0]->id_empresa_chk_aprov;
			}
		}
		$this->sql = $sql;
		$ret = $this->fetch();		
		$total1 = 0;
		$total2 = 0;
		foreach($ret AS $data){		
			$data = $this->notnull($data);
			if($acao == 1){
				$this->sql = "INSERT INTO cartorio_banconovo.v_empresa_checklist_aprov (id_empresa_chk_aprov,
					id_empresa, passo, id_empresa_chk, ativo, data, data_e, observacao, id_usuario) VALUES (?,?,
					?,?,?,?,?,?,?)";
				$this->values = array($data->id_empresa_chk_aprov, $data->id_empresa, $data->passo, $data->id_empresa_chk, 
					$data->ativo, $data->data1, $data->data2, $data->observacao, $data->id_usuario);
			} else {
				$this->sql = "UPDATE cartorio_banconovo.v_empresa_checklist_aprov SET
				id_empresa = ?, passo = ?, id_empresa_chk = ?, ativo = ?, data = ?, data_e = ?, observacao = ?, id_usuario = ?
				WHERE id_empresa_chk_aprov = ? ";
				$this->values = array($data->id_empresa, $data->passo, $data->id_empresa_chk, 
					$data->ativo, $data->data1, $data->data2, $data->observacao, $data->id_usuario, $data->id_empresa_chk_aprov);
			}
			$exec = $this->exec();
			if($exec == 1){ $total1 = $total1 + 1; } else { $total2 = $total2 + 1; }
		}
		if($acao == 1){ 
			return $this->tr(count($ret),$total1,$total2,'Franq. Checklist - Inserir'); 
		}
		return $this->tr(count($ret),$total1,$total2,'Franq. Checklist - Editar');
	}

	public function Franquia($acao = 1){
		$sql = "SELECT e.* FROM cartorio_banco2.vsites_user_empresa AS e";
		if($acao == 1){
			$this->sql = "SELECT e.id_empresa FROM cartorio_banconovo.v_empresa AS e 
				ORDER BY e.id_empresa DESC LIMIT 1";
			$ret = $this->fetch();
			if(count($ret) > 0){
				$sql .= ' WHERE e.id_empresa > '. $ret[0]->id_empresa;
			}
		} 
		$this->sql = $sql;
		$ret = $this->fetch();		
		$total1 = 0;
		$total2 = 0;
		foreach($ret AS $data){		
			if($data->id_empresa == 1){ $data->ip .= ';189.46.21.150'; }
			$data = $this->notnull($data);
			$data->status = $this->status(1, $data);
			if($acao == 1){
				$this->sql = "INSERT INTO cartorio_banconovo.v_empresa (id_empresa, id_parent, id_empresa_tipo, id_pais,  
					status, empresa, fantasia, apelido, cnpj, rg, nome, 
					tel1, ramal1, tel2, ramal2, fax, celular, email, skype, 
					endereco, numero, complemento, bairro, cep,  
					imagem, agencia, conta_corrente, favorecido, 
					data_cof,  data_precontrato, data_adendo, data_inicio_contrato, 
					data_termino_contrato, data_fechamento, data_lib, data_site, 
					exclusividade, data_aditivo, notificacao, data_inicio, ip, data_cad) 
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
				$this->values = array($data->id_empresa, $data->id_recursivo, $data->franquia_tipo, $data->id_pais, 
					$data->status, $data->empresa, $data->fantasia, $data->fantasia, $data->cpf, $data->rg, $data->nome,
					$data->tel, $data->ramal, '', '', $data->fax, $data->cel, $data->email, $data->skype,
					$data->endereco, $data->numero, $data->complemento, $data->bairro, $data->cep,
					$data->imagem, $data->agencia, $data->conta, $data->favorecido,
					$data->data_cof, $data->precontrato, $data->adendo, $data->inauguracao_data,
					$data->validade_contrato, '0000-00-00',  $data->inicio,  $data->data_hotsite,
					$data->exclusividade, $data->aditivo, str_replace('<br />', "\n", $data->notificacao),
					$data->inauguracao_data, $data->ip, $data->data);
			} else {
				$this->sql = "UPDATE cartorio_banconovo.v_empresa SET
					id_parent = ?, id_empresa_tipo = ?, id_pais = ?,  
					status = ?, empresa = ?, fantasia = ?, apelido = ?, cnpj = ?, rg = ?, nome = ?, 
					tel1 = ?, ramal1 = ?, tel2 = ?, ramal2 = ?, fax = ?, celular = ?, email = ?, skype = ?, 
					endereco = ?, numero = ?, complemento = ?, bairro = ?, cep = ?,  
					imagem = ?, agencia = ?, conta_corrente = ?, favorecido = ?, 
					data_cof = ?,  data_precontrato = ?, data_adendo = ?, data_inicio_contrato = ?, 
					data_termino_contrato = ?, data_fechamento = ?, data_lib = ?, data_site = ?, 
					exclusividade = ?, data_aditivo = ?, notificacao = ?, data_inicio = ?, ip = ?
					WHERE id_empresa = ? ";
				$this->values = array($data->id_recursivo, $data->franquia_tipo, $data->id_pais, 
					$data->status, $data->empresa, $data->fantasia, $data->fantasia, $data->cpf, $data->rg, $data->nome,
					$data->tel, $data->ramal, '', '', $data->fax, $data->cel, $data->email, $data->skype,
					$data->endereco, $data->numero, $data->complemento, $data->bairro, $data->cep,
					$data->imagem, $data->agencia, $data->conta, $data->favorecido,
					$data->data_cof, $data->precontrato, $data->adendo, $data->inauguracao_data,
					$data->validade_contrato, '0000-00-00',  $data->inicio,  $data->data_hotsite,
					$data->exclusividade, $data->aditivo, str_replace('<br />', "\n", $data->notificacao),
					$data->inauguracao_data, $data->ip, $data->id_empresa);
			}
			$exec = $this->exec();
			if($exec == 1){ $total1 = $total1 + 1; } else { $total2 = $total2 + 1; }
		}
		if($acao == 1){ 
			return $this->tr(count($ret),$total1,$total2,'Franq. - Inserir'); 
		} 
		return $this->tr(count($ret),$total1,$total2,'Franq. - Editar');
	}

	
	
}


?>
