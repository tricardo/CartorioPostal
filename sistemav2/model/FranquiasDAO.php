<?php

class FranquiasDAO extends Database {

	public function listar($acao, $c){
		
		$dt = array();
		$this->values = array();
                $this->link = 'f=0';
		switch($acao){
			# lista as franquias --------------------------------------------------------
			case 1:				
                                $sql = "FROM vsites_user_empresa AS e
					WHERE 1 = 1 ";
                                if(isset($c->busca)){
                                    if(is_numeric($c->busca)){
                                        $this->values[] = '%'.$c->busca.''; 
                                        $sql = "FROM vsites_user_empresa AS e
						WHERE (e.id_empresa LIKE ?)";
                                    } else {
                                        $this->values[] = '%'.$c->busca.'%'; $this->values[] = '%'.$c->busca.'%';
                                        $this->values[] = '%'.$c->busca.'%'; $this->values[] = '%'.$c->busca.'%';
                                        $this->values[] = '%'.$c->busca.'%'; $this->values[] = '%'.$c->busca.'%';
                                        $sql = "FROM vsites_user_empresa AS e
						WHERE (e.cidade LIKE ? OR e.estado LIKE ? OR e.nome LIKE ? OR 
						e.email LIKE ? OR e.empresa LIKE ? OR e.fantasia LIKE ?)";
                                    }
                                    
                                    
                                    $this->link .= '&busca='.$c->busca;
                                }
				if(isset($c->status) && strlen($c->status) > 0){
					$sql .= " AND e.status=?";
					$this->values[] = $c->status;
                                        $this->link .= '&status='.$c->status;
				}
				$this->sql = "SELECT count(0) AS total " . $sql;
				
				#------------------------------------------------------------------------
				$cont = $this->fetch();
				$this->total = $cont[0]->total;
				$this->pagina = (!isset($c->pagina)) ? 1 : $c->pagina;
				
				$this->sql = "SELECT e.id_empresa, e.nome, e.fantasia, e.franquia, e.status, e.email ";
				$this->sql .= $sql;
				$this->sql .= " ORDER BY e.nome ASC LIMIT " . $this->getInicio() . ", " . $this->maximo;
				return $this->fetch();
				break;
			
			# lista as novas franquias ---------------------------------------------------
			case 2:
				$sql = "FROM site_ficha_cadastro AS s
					WHERE (s.cidade_interesse LIKE ? OR s.estado_interesse LIKE ? OR s.nome LIKE ? OR s.email LIKE ?)
					 AND s.id_status = 18 AND s.id_usuario != 0 AND s.id_usuario != 1 AND s.id_empresa = 0";
					
				$this->sql = "SELECT count(0) AS total " . $sql;
				$this->values = array('%'.$c->busca.'%', '%'.$c->busca.'%', '%'.$c->busca.'%', '%'.$c->busca.'%');
				$cont = $this->fetch();
				$this->total = $cont[0]->total;
				$this->pagina = ($c->pagina == NULL) ? 1 : $c->pagina;
				
				$this->sql = "SELECT s.id_ficha, s.nome, s.email, s.cidade_interesse, s.estado_interesse, s.id_usuario, 
					s.data, s.data_cad_updt ";
				$this->sql .= $sql;
				$this->sql .= " ORDER BY s.nome ASC LIMIT " . $this->getInicio() . ", " . $this->maximo;
				return $this->fetch();
				break;
				
			case 3:
			# seleciona uma franquia ----------------------------------------------------
				$this->sql = 'SELECT * FROM vsites_franquia_regiao WHERE id_empresa = ? ORDER BY cep_i, cep_f, cidade';
				$this->values = array($c);
				return $this->fetch();				
			
			case 4:
				$this->sql = "SELECT e.id_empresa, e.fantasia FROM vsites_user_empresa AS e
					WHERE e.status = 'Ativo' AND e.id_empresa != ? AND e.franquia_tipo = 1 
					ORDER BY FIELD(e.id_empresa, '1') DESC, e.fantasia";
				$this->values = array($c);
				return $this->fetch();
				
			case 5:
				$this->sql = "SELECT e.* FROM vsites_user_empresa_implantacao AS e WHERE e.id_empresa = ?";
				$this->values = array($c);
				return $this->fetch();
                                
                        case 6:
                            $this->sql = 'SELECT * FROM vsites_franquia_regiao WHERE id_franquia_regiao = ?';
                            $this->values = array($c);
                            return $this->fetch();	
		}
		
		
	}
	
	public function insert($acao, $c){
		switch($acao){
			case 1:
				$this->sql = "SELECT s.* FROM site_ficha_cadastro AS s WHERE id_ficha = ".$c->id_ficha;
				$ficha = $this->fetch(); $total = 51;
				for($i = 0; $i < $total; $i++){ $token .= ($i == ($total - 1)) ? '?' : '?,'; }
				
				$this->sql = "INSERT INTO vsites_user_empresa (empresa, fantasia, tipo, cpf, rg, nome, cel, 
					tel, tel_err, email, endereco, complemento, numero, cidade, estado, bairro, cep, data, 
					chat, ultima_acao, status, ramal, franquia, ip, imposto, royalties, fax, modalidade, 
					sigla_cidade, id_banco, agencia, conta, favorecido, imagem, interrede, adendo_data, 
					adendo, inicio, sem1, sem2, sem3, roy_min, roy_min2, inauguracao_data, validade_contrato, 
					modalidade_c, data_cof, precontrato, aditivo, exclusividade, notificacao) VALUES (".$token.")";
				$this->values = array('','Cartório Postal - ','cpf', $ficha[0]->cpf, $ficha[0]->rg,
						ucwords(strtolower($ficha[0]->nome)), $ficha[0]->tel_cel, 
					'','','',ucwords(strtolower($ficha[0]->endereco)),ucwords(strtolower($ficha[0]->complemento)),$ficha[0]->numero,
						ucwords(strtolower($ficha[0]->cidade)),strtoupper($ficha[0]->estado),ucwords(strtolower($ficha[0]->bairro)),
						$ficha[0]->cep,'',
					'','0000-00-00 00:00:00','Implantação','','Sim','','0.00','0.00','','',
					'','0','','','','','0','0000-00-00',
					'','0000-00-00','0.00','0.00','0.00','500.00','0.00','0000-00-00','0000-00-00',
					'','0000-00-00','0000-00-00','0000-00-00','0','');
				$dt = $this->exec();
				if($dt == 1){
					$id_empresa = $this->getLastInsertId();
					if($id_empresa != 0){
						$this->sql = "SELECT e.* FROM vsites_user_empresa_implantacao AS e WHERE id_empresa = ".$id_empresa;
						$dt = count($this->fetch());
						if($dt == 0){
							$total = 16; $token = ''; for($i = 0; $i < $total; $i++){ $token .= ($i == ($total - 1)) ? '?' : '?,'; }
							$this->sql = "INSERT INTO vsites_user_empresa_implantacao (id_empresa, id_ficha, id_usuario, 
								id_consultor1, id_consultor2, franqueado, telefone1, telefone2,
								email, endereco, numero, complemento, bairro, cep, cidade, uf) VALUES (".$token.")";
							$this->values = array($id_empresa, $ficha[0]->id_ficha, $ficha[0]->id_usuario, 
								0,0,ucwords(strtolower($ficha[0]->nome)),$ficha[0]->tel_res,$ficha[0]->tel_rec, 
								strtolower($ficha[0]->email),ucwords(strtolower($ficha[0]->endereco)),$ficha[0]->numero,
									ucwords(strtolower($ficha[0]->complemento)),ucwords(strtolower($ficha[0]->bairro)),
									$ficha[0]->cep, ucwords(strtolower($ficha[0]->cidade)),strtoupper($ficha[0]->estado));
							$dt = $this->exec();
							if($dt == 1){
								$this->sql = "UPDATE site_ficha_cadastro SET id_empresa = ? WHERE id_ficha = ?";
								$this->values = array($id_empresa, $ficha[0]->id_ficha);
								$dt = $this->exec();
								echo "<script>enviar_form()</script>";
								exit;
							}
						}
					}
				}
				break;
		}
	}

    public function getQntUsuarios($acao, $id_empresa, $id_user) {
	$cachediaCLASS = new CacheDiaCLASS();
		switch($acao){
			case 1:
				$this->sql = "SELECT count(0) AS usuarios FROM vsites_user_usuario AS uu WHERE uu.id_empresa=?";
				$this->values = array($id_empresa);
				$dt = $this->fetch();
				return $dt[0]->usuarios;
				
			case 2:
				$this->sql = "SELECT u.nome FROM vsites_user_usuario AS u WHERE id_usuario = ? AND id_empresa = 1";
				$this->values = array($id_user);
				$dt = $this->fetch();
				return $dt[0]->nome;
				
			case 3:
                            
                            
                            $filename = 'FranquiaDAO-getQntUsuarios-3.csv';
                            if(!$cachediaCLASS->VerificaCache($filename)){
				$this->sql = "SELECT u.id_usuario, u.nome FROM vsites_user_usuario AS u WHERE id_empresa = 1
					AND status = 'Ativo' ORDER BY u.nome";
				$this->values = array($id_user);
				$ret = $this->fetch();
                                $campos = "id_usuario;nome";
                                $cachediaCLASS->ConvertArrayToCsv($filename,$ret,$campos);
                            } else {
                                $ret = $cachediaCLASS->ConvertCsvToArray($filename, array("to_object" => true));
                            }
                            return $ret;
                            
		}
    }
	
	public function situacao(){
		$this->sql = "SELECT e.status FROM vsites_user_empresa AS e GROUP BY e.status ORDER BY e.status";
		return $this->fetch();
	}
	
    public function checklist($acao, $lista){
        $cachediaCLASS = new CacheDiaCLASS();
        $filename = 'FranquiaDAO-checklist-'.$acao.'-'.$lista.'.csv';
            if(!$cachediaCLASS->VerificaCache($filename)){
		$this->sql = "SELECT e.* FROM vsites_user_empresa_checklist AS e
			WHERE ativo = 1 AND passo = ? AND lista = ? ORDER BY e.item";
		$this->values = array($acao, $lista);
		$ret = $this->fetch();
                $campos = "id_empresa_chk;ativo;lista;passo;item";
                $cachediaCLASS->ConvertArrayToCsv($filename,$ret,$campos);
            } else {
                $ret = $cachediaCLASS->ConvertCsvToArray($filename, array("to_object" => true));
            }
            return $ret;
	}
	
	public function checklist_edit($passo, $id, $empresa){
		$this->sql = "SELECT e.* FROM vsites_user_empresa_checklist_aprov AS e
			WHERE id_empresa_chk = ? AND passo = ? AND id_empresa = ?";
		$this->values = array($id, $passo, $empresa);
		return $this->fetch();
	}
	
	public function checklist_exec($c, $l = 1){
            global $controle_id_usuario;
            $lista = $this->checklist($c->passo, $l);
            foreach($lista AS $f){
                $obs   = ConcatVar('obs',$f->id_empresa_chk, $c);
                $item  = ConcatVar('item',$f->id_empresa_chk, $c); 
                if($l == 1){
                    $data1 = ConcatVar('datah1',$f->id_empresa_chk, $c);
                    $data2 = ConcatVar('datah2',$f->id_empresa_chk, $c);
                    $ativo = ((int)ConcatVar('ativo',$f->id_empresa_chk, $c, 0) > 0) ? 1 : 0;
                    switch($c->passo){
                        case 2: 
                            $data2 = $data1;
                            break;
                        case 9:
                            $ativo = strlen($item) > 0 ? 1 : $ativo;
                            break;
                        case 10:
                            $data2 = $data1;
                            $ativo = strlen($data1) > 0 ? 1 : $ativo;
                            break;
                        case 7:
                            $ativo = 1;
                            break;
                    }
                } else {
                    switch($c->passo){
                        case 10:
                            $data1 = ConcatVar('datah1',$f->id_empresa_chk, $c);
                            $data2 = $data1;
                            $ativo = strlen($data1) > 0 ? 1 : $ativo;                          
                            break;
                        
                        default:
                            $data1 = ConcatVar('dataf1',$f->id_empresa_chk, $c);
                            $data2 = $data1;
                            $ativo = 1;
                    }
                }               
                
                $this->sql = "SELECT e.* FROM vsites_user_empresa_checklist_aprov AS e
			WHERE e.id_empresa_chk = ? AND e.passo = ? AND e.id_empresa = ?";
		$this->values = array($f->id_empresa_chk, $c->passo, $c->id_empresa);
		$dt = $this->fetch();
                
                if(count($dt) > 0){
                    $this->sql = 'UPDATE vsites_user_empresa_checklist_aprov SET 
                        ativo = ?, data1 = ?, data2 = ?, observacao = ?, id_usuario = ?, item = ?
                        WHERE id_empresa_chk = ? AND passo = ? AND id_empresa = ?';
                    $this->values = array($ativo, $data1, $data2, $obs, $controle_id_usuario, $item,
                        $f->id_empresa_chk, $c->passo, $c->id_empresa);
                } else {
                    $this->sql = 'INSERT INTO vsites_user_empresa_checklist_aprov (id_empresa, passo, 
                        id_empresa_chk, ativo, data1, data2, observacao, id_usuario, item) 
                        VALUES (?,?,?,?,?,?,?,?,?)';
                    $this->values = array($c->id_empresa, $c->passo, $f->id_empresa_chk, $ativo,
                        $data1, $data2, $obs, $controle_id_usuario, $item);
                }
                $this->exec();
                
                if($c->passo == 10 AND $ativo == 1 AND strlen($data1) > 0){
                    if($controle_id_usuario != 1){
                        $this->envia_email(1, 2, $c->empresa, $c->id_usuario);
                    }                    
                    $data1 = invert($data1, '-', 'SQL');
                    $this->sql = 'UPDATE vsites_user_empresa SET inicio = ? WHERE id_empresa = ?';
                    $this->values = array($data1, $c->id_empresa);
                    $this->exec();
                }
            }
	}
	
	public function checklist_valida($passo, $empresa){
		if($passo == 2 || $passo == 4 || $passo == 10){
			$this->sql = 'SELECT COUNT(vuec.id_empresa_chk) AS total1, (
				SELECT COUNT(vuca.id_empresa) 
				FROM vsites_user_empresa_checklist_aprov AS vuca
				WHERE vuca.id_empresa = ? AND vuca.passo = ? AND vuca.ativo = 1
				AND vuca.data1 != "") AS total2 
				FROM vsites_user_empresa_checklist AS vuec
				WHERE vuec.ativo = 1 AND passo = ?';
			$this->values = array($empresa, $passo, $passo);
			$dt = $this->fetch();
			return array($dt[0]->total1,$dt[0]->total2);
		} elseif($passo == 3 || $passo == 5 || $passo == 6){
			$this->sql = 'SELECT COUNT(vuec.id_empresa_chk) AS total1, (
				SELECT COUNT(vuca.id_empresa) 
				FROM vsites_user_empresa_checklist_aprov AS vuca
				WHERE vuca.id_empresa = ? AND vuca.passo = ? AND vuca.ativo = 1
				AND vuca.data1 != "" AND vuca.data2 != "") AS total2 
				FROM vsites_user_empresa_checklist AS vuec
				WHERE vuec.ativo = 1 AND passo = ?';
			$this->values = array($empresa, $passo, $passo);
			$dt = $this->fetch();
			return array($dt[0]->total1,$dt[0]->total2);
		} elseif($passo == 8){
			$this->sql = 'SELECT COUNT(vuec.id_empresa_chk) AS total1, (
				SELECT COUNT(vuca.id_empresa) 
				FROM vsites_user_empresa_checklist_aprov AS vuca
				WHERE vuca.id_empresa = ? AND vuca.passo = ? AND vuca.ativo = 1
				AND vuca.data1 != "") AS total2 
				FROM vsites_user_empresa_checklist AS vuec
				WHERE vuec.ativo = 1 AND passo = ?';
			$this->values = array($empresa, $passo, $passo);
			$dt = $this->fetch();
			return array($dt[0]->total1,$dt[0]->total2);		
		} elseif($passo == 7){
			$this->sql = 'SELECT vfr.* FROM vsites_user_empresa_checklist_aprov AS vfr
			WHERE vfr.id_empresa = ? AND vfr.passo = 7';
			$this->values = array($empresa);
			return $this->fetch();
		} elseif($passo == 9){
			$this->sql = 'SELECT COUNT(vuec.id_empresa_chk) AS total1, (
				SELECT COUNT(vuca.id_empresa) 
				FROM vsites_user_empresa_checklist_aprov AS vuca
				WHERE vuca.id_empresa = ? AND vuca.passo = ? AND vuca.ativo = 1
				AND vuca.item != "") AS total2 
				FROM vsites_user_empresa_checklist AS vuec
				WHERE vuec.ativo = 1 AND passo = ?';
			$this->values = array($empresa, $passo, $passo);
			$dt = $this->fetch();
			return array($dt[0]->total1,$dt[0]->total2);
		} elseif($passo == 11){
			$this->sql = 'SELECT e.* FROM vsites_user_empresa AS e WHERE e.id_empresa = ?';
			$this->values = array($empresa);
			$dt = $this->fetch();
			if($dt[0]->status == 'Implantação'){
                            return array(0,'O TI esta finalizando este processo.<br />Aguarde.');
			} else {
                            $data = explode('-',$dt[0]->inicio);
                            $data = $data[2].'/'.$data[1].'/'.$data[0];
                            return array(1,'A unidade de '.$dt[0]->fantasia.', esta operando desde '.$data.'.');
			}
		}
	}
	
	public function tipo_franquia($empresa){
		$this->sql = 'SELECT vue.* FROM vsites_user_empresa AS vue WHERE id_empresa = ?';
		$this->values = array($empresa);
		return $this->fetch();
	}
	
	public function envia_email($acao, $tipo, $empresa, $usuario){
		switch($acao){
			case 1:
				$this->sql = 'SELECT * FROM vsites_user_empresa_mail AS vuem WHERE
					vuem.id_empresa = ? AND vuem.tipo_env = ?';
				$this->values = array($empresa, $tipo);
				return $this->fetch();
			break;
			case 2:
				$this->sql = 'SELECT u.nome, u.email FROM vsites_user_usuario AS u WHERE u.id_usuario = ? 
					AND u.id_empresa = 1';
				$this->values = array($empresa->usr);
				$dt = $this->fetch();
				
				$ret = new stdClass();
				$ret->nome = $dt[0]->nome;
				$ret->email= $dt[0]->email;
				
				$this->sql = 'SELECT e.fantasia, e.cidade, e.estado FROM vsites_user_empresa AS e WHERE
					e.id_empresa = ?';
				$this->values = array($empresa->emp);
				$dt = $this->fetch();

				$ret->fantasia = $dt[0]->fantasia;
				$ret->cidade = $dt[0]->cidade;
				$ret->estado = $dt[0]->estado;				
				return $ret;
			break;
			case 3:
				$this->sql = 'SELECT m.* FROM vsites_user_empresa_mail AS m WHERE m.id_usuario = ? 
					AND m.id_empresa = ?';
				$this->values = array($usuario, $empresa);
				$dt = $this->fetch();
				if(count($dt) == 0){
					$this->sql = 'INSERT INTO vsites_user_empresa_mail (id_empresa, id_usuario, data, tipo_env) VALUES (?,?,?,?)';
					$this->values = array($empresa, $usuario, date('Y-m-d H:i:s'),$tipo);
					$this->exec();
				}
			break;
		}
	}
	
	public function faixa_cep($c){
		if($c->id_franquia_regiao > 0){
			$this->sql = 'UPDATE vsites_franquia_regiao SET 
				cep_i=?,cep_f=?,apelido=?,cidade=?,estado=?,
				loja=?,latitude=?,longitude=?,cdt=?,distancia=?
				WHERE id_empresa = ? AND id_franquia_regiao = ?';
			$this->values = array($c->cep_i,$c->cep_f,$c->apelido,$c->cidade,$c->estado,
				$c->loja,$c->latitude,$c->longitude,$c->cdt,$c->distancia,$c->empresa,
				$c->id_franquia_regiao);
		} else {
			$this->sql = 'INSERT INTO vsites_franquia_regiao (id_empresa, cep_i,
				cep_f,apelido,cidade,estado,loja,latitude,longitude,cdt,distancia) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?)';
			$this->values = array($c->empresa,$c->cep_i,$c->cep_f,$c->apelido,$c->cidade,$c->estado,
				$c->loja,$c->latitude,$c->longitude,$c->cdt,$c->distancia);
		}
		$this->exec();
	}
	
	public function empresa_implantacao($c){
		$dt = $this->listar(5, $c->id_empresa);
                $dt = $dt[0];
                #print_r($dt);exit;
		if(count($dt) > 0){
			$this->sql = 'UPDATE vsites_user_empresa_implantacao SET id_empresa=?, id_ficha=?, 
				id_usuario=?, id_consultor1=?, id_consultor2=?, franqueado=?, telefone1=?, 
				telefone2=?, email=?, endereco=?, numero=?, complemento=?, bairro=?, cep=?, cidade=?, uf=? 
				WHERE id_empresa_imp = ?';
			$this->values = array($c->id_empresa, $dt->id_ficha, $c->atendente, $c->id_consultor1, 
				$c->id_consultor2, $c->franqueado, $c->telefone1, $c->telefone2, $c->email, $c->endereco, 
				$c->numero, $c->complemento, $c->bairro, $c->cep, $c->cidade, $c->uf, $dt->id_empresa_imp);
		} else {
			$this->sql = 'INSERT INTO vsites_user_empresa_implantacao (id_empresa, id_ficha, id_usuario, id_consultor1, 
				id_consultor2, franqueado, telefone1, telefone2, email, endereco, numero, complemento, 
				bairro, cep, cidade, uf) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
			$this->values = array($c->id_empresa, $c->id_ficha, $c->atendente, $c->id_consultor1, 
				$c->id_consultor2, $c->franqueado, $c->telefone1, $c->telefone2, $c->email, $c->endereco, 
				$c->numero, $c->complemento, $c->bairro, $c->cep, $c->cidade, $c->uf);
		}
		$this->exec();
	}
	
	public function validar_processo($id, $passo){
            $progresso = $this->checklist_valida($passo,$id);
            $parcial   = ($progresso[1] * 100);
            $passo     = ($parcial > 0) ? $parcial / $progresso[0] : 0;
            return $passo;	
	}
	
	public function nome_processo($p){
		switch($p){
			case 2: $p = 'Documentação'; break;
			case 3: $p = 'Informações sobre o ponto'; break;
			case 5: $p = 'Layouts'; break;
			case 6: $p = 'Abertura da Empresa'; break;
			case 7: $p = "Faixa de CEPs"; break;
			case 8: $p = 'Treinamento'; break;
			case 9: $p = 'Checklist de Inauguração'; break;
			case 10: $p = 'Início das Atividades'; break;
			case 11: $p = 'Inauguração'; break;
		}
		return $p;
	}
	
	public function upload_empresa($acao,$empresa,$usuario,$arquivo){
		switch($acao){
			case 1:
				$this->sql = 'INSERT INTO vsites_user_empresa_upload (id_empresa, id_usuario, arquivo, data) VALUES (?,?,?,?);';
				$this->values = array($empresa,$usuario,$arquivo,date('Y-m-d H:i:s'));
				$this->exec();
				break;
			case 2:
				$this->sql = 'SELECT e.*, uu.nome FROM vsites_user_empresa_upload AS e, vsites_user_usuario AS uu '
                                . 'WHERE e.id_empresa = ? AND e.ativo = 1 AND uu.id_usuario = e.id_empresa';
				$this->values = array($empresa);
				return $this->fetch();
				break;
			case 3:
				$this->sql = 'UPDATE vsites_user_empresa_upload SET ativo = 0, id_usuario = ? WHERE id_empresa_upl=? AND id_empresa=?';
				$this->values = array($usuario,$arquivo,$empresa);
				$this->exec();
				break;
		}
	}
	
} ?>