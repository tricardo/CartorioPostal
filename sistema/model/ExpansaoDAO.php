<? class ExpansaoDAO extends Database {

	public function verAcessoExec($exp_item){
		return $this->verAcesso($exp_item->acao, $exp_item->id_empresa, $exp_item->id_usuario, $exp_item->id_departamento_p, 
		$exp_item->id_departamento_s, $exp_item->nome);
	}

	public function verAcesso($controle_acao, $controle_id_empresa, $controle_id_usuario, $controle_id_departamento_p, 
		$controle_id_departamento_s, $controle_nome){
		$retorno = new stdClass();
		$retorno->id_empresa = $controle_id_empresa;
		$retorno->id_usuario = $controle_id_usuario;
		$retorno->id_departamento_p = $controle_id_departamento_p;
		$retorno->id_departamento_s = $controle_id_departamento_s;
		$retorno->nome = $controle_nome;
		$retorno->acesso = 0;
		$retorno->id_depto = array(4,17,26,29);
		$retorno->id_users = array(1);
		
		#if(!isset($_SESSION['users_extra_expansao'])){
		#	if($_SESSION['users_extra_expansao'] != ''){
				$_SESSION['users_extra_expansao'] = $this->pegaRelacionamento();
		#	}
		#} 
		
		
		$retorno->id_users_extra = explode(',',$_SESSION['users_extra_expansao']);
		
		if($retorno->id_empresa == 1){
			switch($controle_acao){
				case 2:
					#CARREGAR CONSULTOR
					$retorno->id_depto = array(4);
					 $retorno->id_users_extra[] = 1;
					 $retorno->id_users_extra[] = 56;
					 $retorno->id_users_extra[] = 828;
					 $retorno->id_users_extra[] = 2145;
					 $retorno->id_users_extra[] = 3654;
					 $retorno->id_users_extra[] = 4562;
					 $retorno->id_users_extra[] = 4587;
					 $retorno->id_users_extra[] = 4588;
					 $retorno->id_users_extra[] = 4589;
					 $retorno->id_users_extra[] = 4590;
					$retorno->id_users = $retorno->id_users_extra;
					#$retorno->id_users = array(1,56,828,3106,3107,3108,3146);
					break;
				case 3:
					$retorno->id_depto = array(0);
					 $retorno->id_users = array(1,56,828,2145,3654,4562,4587,4588,4589,4590, 4704);
					break;
				case 4:
					$retorno->id_depto = array(0);
					$retorno->id_users = $retorno->id_users_extra;
					#$retorno->id_users = array(3106,3107,3108,3146);
			}
		}
		if(in_array($retorno->id_usuario,$retorno->id_users)){
			$retorno->acesso = 1;
		} else {
			$depto = explode(',', $retorno->id_departamento_p);
			for($i = 0; $i < count($depto); $i++){
				if(strlen($depto[$i]) > 0){
					if(in_array($depto[$i],$retorno->id_depto)){ 
						$i = count($depto); 
						$retorno->acesso = 1;
					}
				}
			}
		}
		return $retorno;
	}

	public function carregar_consultor($exp_item, $c){
		$combosel = 0;
		if($exp_item->consultor2 == 1){
			$combosel = 1;
		}
		
		$SQL = "SELECT u.id_usuario, u.nome FROM site_ficha_cadastro AS c, vsites_user_usuario AS u 
			WHERE u.id_usuario = c.id_usuario ";				
		switch($exp_item->id_usuario){
			case 1: break;
			default:
				$exp_item->acao = 2;
				$exp_item = $this->verAcessoExec($exp_item);
				if($exp_item->acesso == 0){
					$SQL .= ' AND u.id_usuario = ' . $c->c_id_usuario . ' ';
				}
		}
		if($exp_item->id_usuario != 1){
			$SQL .= 'AND c.id_status != 20 ';
		}
		$SQL .= "GROUP BY c.id_usuario ORDER BY u.nome";
		$this->sql = $SQL;
        $dt = $this->fetch();

		if($combosel == 1){
			echo '<select id="consultor2" name="consultor2" class="form_estilo" style="width:200px;">'."\n";
			foreach($dt as $b => $res){ 
				echo (count($dt) > 1 && $cont == 0) ? '<option value="0">--</option>' . "\n" : ''; 
				$cont++;
				echo "\t\t\t\t\t".'<option value="'.$res->id_usuario.'"'.((((int)$c->consultor2) == $res->id_usuario) ? 
					' selected="selected"' : '').'>'.
					(($exp_item->id_usuario == 1) ? '['.$res->id_usuario.'] - ':'').$res->nome.'</option>' . "\n";
			}
			echo '</select>'."\n";
		} else {
			echo '<select id="consultor" name="consultor" class="form_estilo" style="width:200px;">'."\n";
			foreach($dt as $b => $res){ 
				echo (count($dt) > 1 && $cont == 0) ? '<option value="0">--</option>' . "\n" : ''; 
				echo (count($dt) > 1 && $cont == 0 && $c->sem_consultor == 1) ? '<option value="10000"'.(($c->consultor == 10000) ? ' selected="selected"' : '').'>Nenhum Consultor</option>' . "\n" : '';
				$cont++;
				echo "\t\t\t\t\t".'<option value="'.$res->id_usuario.'"'.((((int)$c->consultor) == $res->id_usuario) ? 
					' selected="selected"' : '').'>'.
					(($exp_item->id_usuario == 1) ? '['.$res->id_usuario.'] - ':'').$res->nome.'</option>' . "\n";
			}
			echo '</select>'."\n";
		}
	}
	
	public function carregar_consultor2($exp_item, $c){
		$combosel = 0;
		if($exp_item->consultor2 == 1){
			$combosel = 1;
		}
		
		$SQL = "SELECT u.id_usuario, u.nome FROM vsites_user_usuario AS u 
			WHERE u.id_empresa = 1 AND u.status = 'Ativo' AND u.departamento_p LIKE '%26%' ORDER BY u.nome";
			$this->sql = $SQL;
        $dt = $this->fetch();
		if($combosel == 1){
			echo '<select id="consultor2" name="consultor2" class="form_estilo" style="width:200px;">'."\n";
			foreach($dt as $b => $res){ 
				echo (count($dt) > 1 && $cont == 0) ? '<option value="0">--</option>' . "\n" : ''; 
				$cont++;
				echo "\t\t\t\t\t".'<option value="'.$res->id_usuario.'"'.((((int)$c->consultor2) == $res->id_usuario) ? 
					' selected="selected"' : '').'>'.
					(($exp_item->id_usuario == 1) ? '['.$res->id_usuario.'] - ':'').$res->nome.'</option>' . "\n";
			}
			echo '</select>'."\n";
		} else {
			echo '<select id="consultor" name="consultor" class="form_estilo" style="width:200px;">'."\n";
			foreach($dt as $b => $res){ 
				echo (count($dt) > 1 && $cont == 0) ? '<option value="0">--</option>' . "\n" : ''; 
				echo (count($dt) > 1 && $cont == 0 && $c->sem_consultor == 1) ? '<option value="10000"'.(($c->consultor == 10000) ? ' selected="selected"' : '').'>Nenhum Consultor</option>' . "\n" : '';
				$cont++;
				echo "\t\t\t\t\t".'<option value="'.$res->id_usuario.'"'.((((int)$c->consultor) == $res->id_usuario) ? 
					' selected="selected"' : '').'>'.
					(($exp_item->id_usuario == 1) ? '['.$res->id_usuario.'] - ':'').$res->nome.'</option>' . "\n";
			}
			echo '</select>'."\n";
		}	
	}
	
	public function carregar_status($exp_item, $c){
		$SQL = "SELECT s.id_status, s.status FROM site_ficha_cadastro AS c, site_ficha_cadastro_status AS s
					WHERE s.id_status = c.id_status ";				
		switch($exp_item->id_usuario){
			case 1: break;
			default:
				$SQL .= ' AND s.id_status != 18 AND s.id_status != 20 ';
		}
		$SQL .= "GROUP BY c.id_status ORDER BY s.status";
		$this->sql = $SQL;
        $dt = $this->fetch();

		echo '<select name="id_status" id="id_status" class="form_estilo" style="width:200px;">'."\n";
		foreach($dt as $b => $res){ 
			echo (count($dt) > 1 && $cont == 0) ? '<option value="0">--</option>' . "\n" : ''; $cont++;
			echo "\t\t\t\t\t".'<option value="'.$res->id_status.'"'.((((int)$c->id_status) == $res->id_status) ? 
				' selected="selected"' : '').'>'.
				(($exp_item->id_usuario == 1) ? '['.$res->id_status.'] - ':'').$res->status.'</option>' . "\n";
		}
		echo '</select>'."\n";
	}

	public function carregar_combo($c){	
		switch($c->acao){
				
			case 'data':
				$SQL = 'SELECT YEAR(c.data) AS data FROM site_ficha_cadastro AS c ORDER BY c.data LIMIT 0,1';
				break;
				
			case 'uf':
				$SQL = "SELECT c.estado_interesse FROM site_ficha_cadastro AS c WHERE c.estado_interesse != '' AND 
					c.estado_interesse != 'NULL' GROUP BY c.estado_interesse ORDER BY c.estado_interesse";
				break;
		}
		$this->sql = $SQL;
        return $this->fetch();
	}

	public function consulta($exp_item, $c){
		$CAMPOS   = "SELECT c.id_ficha, LOWER(c.nome) AS nome, LOWER(c.cidade_interesse) AS cidade, UPPER(c.estado_interesse) AS uf, 
			CONCAT(DAY(c.data),'/',MONTH(c.data),'/',YEAR(c.data)) AS data, u.nome AS consultor, s.status, c.id_usuario, c.email, c.tel_res, c.tel_cel ";
		$TABELA   = "FROM site_ficha_cadastro AS c, vsites_user_usuario AS u, site_ficha_cadastro_status AS s ";
		$CONDICAO = "WHERE u.id_usuario = c.id_usuario AND s.id_status = c.id_status ";
		$LINK     = 'pg=1';
		switch($exp_item->id_usuario){
			case 1: break;
			default:
				$exp_item->acao = 2;
				$exp_item = $this->verAcessoExec($exp_item);
		}
		if($exp_item->acesso == 0){
			$CONDICAO .= ' AND s.id_status != 20';
			$CONDICAO .= ' AND c.id_usuario = ' . $c->c_id_usuario . ' ';
		} else {
			if($exp_item->id_usuario != 1){
				$CONDICAO .= ' AND s.id_status != 20 ';
			}
			if($c->consultor > 0){
				$CONDICAO .= ' AND c.id_usuario = ' . $c->consultor . ' ';
				$LINK 	  .= '&consultor='. $c->consultor;
			}
		}
		
		if($c->id_status > 0){
			if($c->id_status == 14 || $c->id_status == 18){
				$CONDICAO .= ' AND (c.id_status = 14 OR c.id_status = 18) ';
				$LINK 	  .= '&id_status='. $c->id_status;
			} else {
				$CONDICAO .= ' AND c.id_status = ' . $c->id_status . ' ';
				$LINK 	  .= '&id_status='. $c->id_status;
			}
		} else {
			if($exp_item->id_usuario != 1){
				#$CONDICAO .= ' AND c.id_status != 16 ';
				#$LINK 	  .= '&id_status='. $c->id_status;
			}
		}
		
		if(strlen($c->cidade) >= 3){
			$CONDICAO .= " AND c.cidade_interesse LIKE '%". $c->cidade ."%'";
			$LINK 	  .= '&cidade='. $c->cidade;
		}
		
		if(strlen($c->uf) > 0){
			$CONDICAO .= " AND c.estado_interesse LIKE '%". $c->uf ."%'";
			$LINK 	  .= '&uf='. $c->uf;
		}
		
		if(strlen($c->nome) > 3){
			$CONDICAO .= " AND c.nome LIKE '%". $c->nome ."%'";
			$LINK 	  .= '&nome='. $c->nome;
		}
		
		if($c->mes > 0){
			$CONDICAO .= ' AND MONTH(c.data) = ' . $c->mes . ' ';
			$LINK 	  .= '&mes='. $c->mes;
		}
		
		if($c->ano > 0){
			$CONDICAO .= ' AND YEAR(c.data) = ' . $c->ano . ' ';
			$LINK 	  .= '&ano='. $c->ano;
		}
		
		if(strlen($c->id_ficha) > 0){
			$c->id_ficha = (int)$c->id_ficha;
			$CONDICAO .= ' AND c.id_ficha = '.$c->id_ficha;
			$LINK 	  .= '&id_ficha='. $c->id_ficha;
		}		
		
		$ORDER = ' ORDER BY c.data DESC ';

		$this->pagina = ($c->pagina == NULL) ? 1 : $c->pagina;
		$this->sql 	  = 'SELECT COUNT(0) AS total ' . $TABELA . $CONDICAO;	
		$cont 		  = $this->fetch();
		$this->total  = $cont[0]->total;	
		$this->link   =	$LINK;	
		
		$LIMIT = 'LIMIT ' . $this->getInicio() . ", " . $this->maximo;

		$this->sql = $CAMPOS . $TABELA. $CONDICAO . $ORDER . $LIMIT;
		#echo $this->sql; exit;
        return $this->fetch();
	}
	
	public function agenda($acao, $c, $exp_item){
		$exp_item->acao = 4;
		$exp_item = $this->verAcessoExec($exp_item);
		$unset = array();
		for($i = 0; $i < count($exp_item->id_users); $i++){
			if(!strlen($exp_item->id_users[$i]) > 0){
				$unset[] = $i;
			}
		}
		for($i = 0; $i < count($unset); $i++){
			unset($exp_item->id_users[$unset[$i]]);
		}
		if($c->c_id_usuario != 1){
			if($exp_item->acesso == 1){
				if($acao == 1){
					$SQL = "SELECT COUNT(0) AS total, DATE_FORMAT(e.data_reuniao,'%d') AS dia 
						FROM site_ficha_cadastro_historico AS e 
						WHERE e.id_user_alt IN (".implode(",", $exp_item->id_users).") AND e.data_reuniao != '0000-00-00'
						AND DATE_FORMAT(e.data_reuniao,'%Y-%m')='".$c->ano."-".$c->mes."'
						GROUP BY e.data_reuniao
						ORDER BY e.data_reuniao";
				} else {		
					$exp_item->id_users = (count($exp_item->id_users) == 0) ? array(0) : $exp_item->id_users; 
					$SQL = "SELECT u1.nome AS relacionamento, CONCAT(s2.status,' - ', s1.status) AS status1, e.data_reuniao AS agenda, e.observacao AS obs, c.id_ficha, c.nome AS cliente, 
						(CASE WHEN u2.nome IS NULL THEN 'Nenhum Consultor' ELSE u2.nome END) AS consultor
						FROM site_ficha_cadastro_historico AS e, vsites_user_usuario AS u1, site_ficha_cadastro_status AS s1, site_ficha_cadastro_status AS s2, site_ficha_cadastro AS c
						LEFT JOIN vsites_user_usuario AS u2 ON u2.id_usuario = c.id_usuario
						WHERE e.id_user_alt IN (".implode(",", $exp_item->id_users).") AND e.data_reuniao != '0000-00-00' AND u1.id_usuario = e.id_user_alt AND s1.id_status = e.id_status AND c.id_ficha = e.id_ficha AND c.id_status = s2.id_status AND DATE_FORMAT(e.data_reuniao,'%Y-%m-%d')='".$c->ano."-".$c->mes2."-".$c->dia2."' 
						ORDER BY FIELD(e.id_user_alt, ".$c->c_id_usuario.") DESC, FIELD(e.id_user_alt,".implode(',', $exp_item->id_users).")";
				}
			} else {
				if($acao == 1){						
					$SQL = "SELECT COUNT(0) AS total, DATE_FORMAT(e.data_reuniao,'%d') AS dia FROM site_ficha_cadastro AS c, 
						site_ficha_cadastro_historico AS e, vsites_user_usuario AS u1, vsites_user_usuario AS u2, 
						site_ficha_cadastro_status AS s1, site_ficha_cadastro_status AS s2 WHERE c.id_usuario = ".$c->c_id_usuario." AND e.id_ficha = c.id_ficha AND e.data_reuniao != '0000-00-00' AND u1.id_usuario = c.id_usuario AND 
						e.id_user_alt = u2.id_usuario AND DATE_FORMAT(e.data_reuniao,'%Y-%m')='".$c->ano."-".$c->mes."' AND s1.id_status = e.id_status 
						AND s2.id_status = c.id_status GROUP BY e.data_reuniao ORDER BY e.data_reuniao";
						
				} else {
					$exp_item->id_users = (count($exp_item->id_users) == 0) ? array(0) : $exp_item->id_users; 
					$SQL = "SELECT c.id_ficha, c.nome AS cliente, u1.nome AS consultor, e.observacao AS obs, 
						e.data_reuniao AS agenda, u2.nome AS relacionamento, CONCAT(s2.status,' - ',s1.status) AS status1
						FROM site_ficha_cadastro AS c, site_ficha_cadastro_historico AS e, vsites_user_usuario AS u1, 
						vsites_user_usuario AS u2, site_ficha_cadastro_status AS s1,  site_ficha_cadastro_status AS s2 
						WHERE c.id_usuario = ".$c->c_id_usuario." AND e.id_ficha = c.id_ficha AND e.data_reuniao != '0000-00-00' 
						AND u1.id_usuario = c.id_usuario AND e.id_user_alt = u2.id_usuario 
						AND DATE_FORMAT(e.data_reuniao,'%Y-%m-%d')='".$c->ano."-".$c->mes2."-".$c->dia2."' AND s1.id_status = e.id_status 
						AND s2.id_status = c.id_status ORDER BY FIELD(e.id_user_alt, ".$c->c_id_usuario.") DESC, FIELD(e.id_user_alt,".implode(',', $exp_item->id_users).")";
				}
			}
		} else {
			if($acao == 1){
				$SQL = "SELECT COUNT(0) AS total, DATE_FORMAT(e.data_reuniao,'%d') AS dia 
						FROM site_ficha_cadastro_historico AS e 
						WHERE e.data_reuniao != '0000-00-00'
						AND DATE_FORMAT(e.data_reuniao,'%Y-%m')='".$c->ano."-".$c->mes."'
						GROUP BY e.data_reuniao
						ORDER BY e.data_reuniao";
			} else {
				$SQL = "SELECT u1.nome AS relacionamento, CONCAT(s2.status,' - ', s1.status) AS status1, e.data_reuniao AS agenda, e.observacao AS obs, c.id_ficha, c.nome AS cliente, 
						(CASE WHEN u2.nome IS NULL THEN 'Nenhum Consultor' ELSE u2.nome END) AS consultor
						FROM site_ficha_cadastro_historico AS e, vsites_user_usuario AS u1, site_ficha_cadastro_status AS s1, site_ficha_cadastro_status AS s2, site_ficha_cadastro AS c
						LEFT JOIN vsites_user_usuario AS u2 ON u2.id_usuario = c.id_usuario
						WHERE e.data_reuniao != '0000-00-00' AND u1.id_usuario = e.id_user_alt AND s1.id_status = e.id_status AND c.id_ficha = e.id_ficha AND c.id_status = s2.id_status AND DATE_FORMAT(e.data_reuniao,'%Y-%m-%d')='".$c->ano."-".$c->mes2."-".$c->dia2."' 
						ORDER BY u1.nome";
			}
		}
		#echo $SQL;
		$this->sql = $SQL;
		return $this->fetch();
	}
	
	public function pega_usuario($id){
		$this->sql = 'SELECT u.* FROM vsites_user_usuario AS u WHERE u.id_usuario = ?';
		$this->values = array($id);
		return $this->fetch();
	}
	
	public function data_de_cadastro($acao, $c){
		switch($acao){
			case 1:
				$SQL      = "SELECT c.id_ficha, LOWER(c.nome) AS nome, LOWER(c.cidade_interesse) AS cidade, UPPER(c.estado_interesse) AS uf, 
					CONCAT(DAY(c.data),'/',MONTH(c.data),'/',YEAR(c.data)) AS data, u.nome AS consultor, s.status,
					CONCAT(DAY(c.data_cad_updt),'/',MONTH(c.data_cad_updt),'/',YEAR(c.data_cad_updt)) AS data_cad_updt ";
				$CONDICAO = "FROM site_ficha_cadastro AS c, vsites_user_usuario AS u, site_ficha_cadastro_status AS s 
					WHERE u.id_usuario = c.id_usuario AND s.id_status = c.id_status AND c.id_status != 18 
					AND c.id_status != 20 AND c.id_ficha = ".$c->id_ficha;

				$this->sql 	  = 'SELECT COUNT(0) AS total ' . $CONDICAO;	
				$cont 		  = $this->fetch();
				$this->total  = $cont[0]->total;
				$this->sql    = $SQL . $CONDICAO;
				return $this->fetch();
				break;
			case 2:
				$data = explode('/',$c->id_datacad);
				$data = $data[2].'-'.$data[1].'-'.$data[0];
				$SQL = "UPDATE site_ficha_cadastro SET data_cad_updt = '".$data."', data = '".$data."',
					data_cad_user_updt = ".$c->c_id_usuario." WHERE id_ficha = ".$c->id_ficha;
				$this->sql = $SQL;
				$this->exec();				
				$msg = "A data da ficha ".$c->id_ficha." foi alterado para ".$c->id_datacad." com sucesso!";
					echo "<script>openAlertBox('Data de Cadastro','".$msg."','data-de-cadastro.php?id_ficha=".$c->id_ficha."');</script>";
				break;
		}
	}
	
	public function duplicidade($id_ficha, $email){
		for($i = 0; $i < count($id_ficha); $i++){
			$fichas .= $id_ficha[$i].',';
		}
		$fichas .= '0';
		$SQL   = "SELECT c.id_ficha, LOWER(c.nome) AS nome, LOWER(c.cidade_interesse) AS cidade, UPPER(c.estado_interesse) AS uf, 
			CONCAT(DAY(c.data),'/',MONTH(c.data),'/',YEAR(c.data)) AS data, s.status, c.email 
			FROM site_ficha_cadastro AS c, site_ficha_cadastro_status AS s 
			WHERE s.id_status = c.id_status AND c.id_ficha NOT IN (".$fichas.") AND 
			c.email = '".$email."' AND (NOT ISNULL(c.email) AND TRIM(c.email) != '') AND c.id_status NOT IN (14,18,20)
			ORDER BY c.id_ficha DESC";
		$this->sql    = $SQL;
		return $this->fetch();
	}
	
	public function usuario($id_usuario){
		$this->sql = 'SELECT u.nome FROM vsites_user_usuario AS u WHERE u.id_usuario = '.$id_usuario;
		return $this->fetch();
	}
	
	public function excluir_duplicidade($id_usuario, $id_ficha){
		$fichas = explode(';',$id_ficha);
		for($i = 0; $i < count($fichas); $i++){
			if($fichas[$i] != ''){
				$SQL = "UPDATE site_ficha_cadastro SET observacao_expansao = 'duplicidade',
					id_user_alt = ".$id_usuario.", id_status = 20, id_usuario = 1 WHERE id_ficha = ".$fichas[$i];					
				$this->sql = $SQL;
				$this->exec();
			}
		}
	}
	
	public function duplicidades_verifica($exp_item, $c){
		$SQL = "SELECT c1.*, c2.*, (CASE WHEN s.status IS NULL THEN '-' ELSE s.status END) AS status2 ";
		$FROM = "FROM site_ficha_cadastro AS c2, site_ficha_cadastro AS c1
			LEFT JOIN site_ficha_cadastro_status AS s ON c1.id_status = s.id_status
			WHERE c1.id_usuario = 0 AND c1.nome LIKE c2.nome AND c1.email LIKE c2.email
			AND c1.id_status NOT IN (14,16,18,20) AND c2.id_status NOT IN (14,16,18,20) AND c1.id_ficha != c2.id_ficha ";
		$ORDER = "ORDER BY c1.id_ficha DESC, c2.id_ficha DESC";
		$this->pagina = ($c->pagina == NULL) ? 1 : $c->pagina;
		$this->sql 	  = 'SELECT COUNT(0) AS total ' . $FROM;	
		$cont 		  = $this->fetch();
		$this->total  = $cont[0]->total;
		$this->link   =	'pg=1';
		$LIMIT = ' LIMIT ' . $this->getInicio() . ", " . $this->maximo;
		$this->sql = $SQL.$FROM.$ORDER.$LIMIT;
		#echo $this->sql; #exit;
        return $this->fetch();
	}
	
	public function direcionamento($c){
		$CAMPOS   = "SELECT c.id_ficha, LOWER(c.nome) AS nome, LOWER(c.cidade_interesse) AS cidade, UPPER(c.estado_interesse) AS uf, 
			CONCAT(DAY(c.data),'/',MONTH(c.data),'/',YEAR(c.data)) AS data, s.status, c.id_usuario, c.email ";
		$TABELA   = "FROM site_ficha_cadastro_status AS s, site_ficha_cadastro AS c ";
		$LINK     = 'pg=1';
		
		if($c->c_id_usuario == 1){
			$CONDICAO = "LEFT JOIN vsites_user_usuario AS u ON c.id_usuario = u.id_usuario ";
			$CONDICAO .= "WHERE s.id_status = c.id_status ";
			if($c->consultor > 0){
				$c->consultor = ($c->consultor == 10000) ? 0 : $c->consultor;
				$CONDICAO .= ' AND c.id_usuario = ' . $c->consultor . ' ';
				$c->consultor = ($c->consultor == 0) ? 10000 : $c->consultor;
			}
			$CAMPOS   .= ", (CASE WHEN u.nome IS NULL THEN 'Nenhum Consultor' ELSE u.nome END) AS consultor ";
			$LINK 	  .= '&consultor='. $c->consultor;
		} else {
			$consultor = ($c->consultor == 10000) ? 10000 : $c->consultor;
			$c->consultor = ($c->consultor == 10000) ? 0 : $c->consultor;
			if($c->consultor > 0){
				$CONDICAO = "WHERE s.id_status = c.id_status ";
				$CONDICAO .= ' AND s.id_status != 18 AND s.id_status != 20 AND s.id_status != 14 ';
				$CONDICAO .= ' AND u.id_usuario = c.id_usuario AND c.id_usuario = ' . $c->consultor . ' ';
				$CAMPOS   .= ', u.nome AS consultor ';
				$TABELA   .= ', vsites_user_usuario AS u ';
				$LINK 	  .= '&consultor='. $c->consultor;
			} else {
				$CONDICAO = "LEFT JOIN vsites_user_usuario AS u ON c.id_usuario = u.id_usuario ";
				$CONDICAO .= "WHERE s.id_status = c.id_status ";
				$CONDICAO .= ' AND s.id_status != 18 AND s.id_status != 20 AND s.id_status != 14 ';
				$CAMPOS   .= ", (CASE WHEN u.nome IS NULL THEN 'Nenhum Consultor' ELSE u.nome END) AS consultor ";
				if($consultor == 10000){
					$CONDICAO .= ' AND c.id_usuario = 0 ';
					$c->consultor = 10000;
					$LINK 	  .= '&consultor='. $c->consultor;
				} else {
					$LINK 	  .= '&consultor='. $c->consultor;
				}
			}
		}
		if($c->id_status > 0){
			$CONDICAO .= ' AND c.id_status = ' . $c->id_status . ' ';
			$LINK 	  .= '&id_status='. $c->id_status;
		}

		if(strlen($c->cidade) >= 3){
			$CONDICAO .= " AND c.cidade_interesse LIKE '%". $c->cidade ."%'";
			$LINK 	  .= '&cidade='. $c->cidade;
		}
		
		if(strlen($c->uf) > 0){
			$CONDICAO .= " AND c.estado_interesse LIKE '%". $c->uf ."%'";
			$LINK 	  .= '&uf='. $c->uf;
		}
		
		if(strlen($c->nome) > 3){
			$CONDICAO .= " AND c.nome LIKE '%". $c->nome ."%'";
			$LINK 	  .= '&nome='. $c->nome;
		}
		
		if(strlen($c->id_ficha2) > 0){
			$c->id_ficha2 = (int)$c->id_ficha2;
			$CONDICAO .= ' AND c.id_ficha = '.$c->id_ficha2;
			$LINK 	  .= '&id_ficha='. $c->id_ficha2;
		}	
		$ORDER = ' ORDER BY u.nome, c.id_ficha DESC';

		$this->pagina = ($c->pagina == NULL) ? 1 : $c->pagina;
		$this->sql 	  = 'SELECT COUNT(0) AS total ' . $TABELA . $CONDICAO;	
		$cont 		  = $this->fetch();
		$this->total  = $cont[0]->total;	
		$this->link   =	$LINK;	
		
		$LIMIT = 'LIMIT ' . $this->getInicio() . ", " . $this->maximo;
		#echo $CAMPOS . $TABELA. $CONDICAO . $ORDER . $LIMIT;
		$this->sql = $CAMPOS . $TABELA. $CONDICAO . $ORDER .' '.$LIMIT;
		#echo $this->sql; #exit;
        return $this->fetch();
	}
	
	public function direcionar($c){
		for($i = 0; $i < count($c->id_ficha); $i++){
			$this->sql= "UPDATE site_ficha_cadastro SET id_usuario=? WHERE id_ficha =?";	
			$this->values = array($c->consultor2, $c->id_ficha[$i]);
			$this->exec();
		}
	}	
	
	public function estado(){
		$this->sql= 'SELECT DISTINCT estado FROM  vsites_cidades as C ORDER BY estado';
		return $this->fetch();
	}
	
	public function lazer(){
		$this->sql = "SELECT id_lazer, lazer FROM site_ficha_cadastro_lazer WHERE (ativo = 1) ORDER BY lazer";	
		$this->values = array();
		return $this->fetch();
	}
	
	public function relFichaLazer($id){
		$this->sql="SELECT * FROM site_ficha_rel_cadastro_lazer WHERE id_ficha= ?";
		$this->values = array($id);
		return $this->fetch();
	}
	
	public function relFichaLazer2($id, $id2){
		$this->sql="SELECT * FROM site_ficha_cadastro_rel_enum_pergunta WHERE id_ficha= ? AND id_enum_perg=?";
		$this->values = array($id, $id2);
		return $this->fetch();
	}
	
	public function EnumPergunta(){
		$this->sql="SELECT * FROM site_ficha_cadastro_enum_perguntas WHERE (ativo=1) ORDER BY ordem";
		$this->values = array();
		return $this->fetch();
	}
	
	public function relResposta($ficha, $idperg, $resposta){
		$this->sql = "DELETE FROM site_ficha_cadastro_rel_enum_pergunta WHERE id_ficha = ?";
		$this->values = array($ficha);
		$this->exec();
		
		for($i = 0; $i < count($idperg); $i++){
			$this->sql = "INSERT INTO site_ficha_cadastro_rel_enum_pergunta (id_enum_perg, id_ficha, valor) VALUES (?,?,?)";
			$this->values = array($idperg[$i], $ficha, $resposta[$i]);
			$this->exec();
		}
	}
	
	public function buscaRelEnumPergunta($id, $id2){
		$this->sql="SELECT * FROM site_ficha_cadastro_rel_enum_pergunta WHERE id_ficha= ? AND id_enum_perg = ?";
		$this->values = array($id, $id2);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	public function editaRelEnumPergunta($lista){
		$this->sql = "
					UPDATE site_ficha_cadastro_rel_enum_pergunta SET 
					valor=? WHERE id_enum_perg=? AND id_ficha =?
		";
		$arr = array_values($lista);
		$this->values = $arr;
		$this->exec();
	}
	
	public function insereRelEnumPergunta($lista){
		$this->sql = "
					INSERT INTO site_ficha_cadastro_rel_enum_pergunta 
					( valor, id_enum_perg ,id_ficha ) VALUES ( ?, ?, ? );					
		";
		$arr = array_values($lista);
		$this->values = $arr;
		$this->exec();
	}
	
	public function buscaIDStatus($id){
		$this->sql = "SELECT id_usuario, id_user_alt, id_status, observacao_expansao, data_reuniao, 
			data_reuniao_inclusao FROM site_ficha_cadastro WHERE id_ficha =?
		";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	public function buscaDataInclude($id){
		$this->sql = "SELECT c.data FROM site_ficha_cadastro AS c WHERE c.id_ficha = ?";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	public function table_bancario($acao, $c){
		switch($acao){
			
			case 2:
				$b = new stdClass();
				
				if($c->c_id_usuario != 1){
					$this->sql = "SELECT * FROM site_ficha_cadastro AS c WHERE c.id_ficha = ? AND c.id_usuario = ?";
					$this->values = array($c->id_ficha, $c->c_id_usuario);
					$ret = $this->fetch();
					if(count($ret) == 0){
						echo "<script>openAlertBox('Erro','Você não tem permissão para alterar esta ficha!','fichas-editar.php?id_ficha=".$c->id_ficha."');</script>";
						return;
						#return $this->table_cadastro_acao1($c);
					}
				}
							
				#Informações Adicionais
				$this->site_ficha_cadastro(4, $c);
				
				#Referências Bancárias
				$this->sql = "SELECT c.* FROM site_ficha_cadastro_referencias_bancarias AS c WHERE c.id_ficha = ?"; 
				$this->values = array($c->id_ficha);
				$ret = $this->fetch();
				$acao = (count($ret) > 0) ? 1 : 2;
				$this->site_ficha_cadastro_referencias_bancarias($acao, $c);
				
				$this->sql = "SELECT c.* FROM site_ficha_cadastro_referencias_bancarias AS c WHERE c.id_ficha = ?"; 
				$this->values = array($c->id_ficha);
				$ret = $this->fetch();
				if(count($ret) > 0){
					$b->banco = $ret[0]->banco; $b->cartao_credito = $ret[0]->cartao_credito; 
					$b->vencimento = $ret[0]->vencimento; $b->limite = $ret[0]->limite; 
					$b->telefone_banco = $ret[0]->telefone; $b->nome_gerente = $ret[0]->nome_gerente;
					$b->agencia_conta = $ret[0]->agencia_conta;
				}
				
				#Demonstrativo de Rendimento
				$this->sql = "SELECT c.* FROM site_ficha_cadastro_demonstrativo_rendimento AS c WHERE c.id_ficha = ?"; 
				$this->values = array($c->id_ficha);
				$ret = $this->fetch();
				$acao = (count($ret) > 0) ? 1 : 2;
				$this->site_ficha_cadastro_demonstrativo_rendimento($acao, $c);
				
				$this->sql = "SELECT c.* FROM site_ficha_cadastro_demonstrativo_rendimento AS c WHERE c.id_ficha = ?"; 
				$this->values = array($c->id_ficha);
				$ret = $this->fetch();
				if(count($ret) > 0){
					$b->honorarios = $ret[0]->honorarios; $b->salarios = $ret[0]->salarios;
					$b->comissoes = $ret[0]->comissoes; $b->salario_conjuge = $ret[0]->salario_conjuge;
					$b->renda_alugueis = $ret[0]->renda_alugueis; $b->emprestimo_financeiro = $ret[0]->emprestimo_financeiro;
				}
				
				#Bens de Consumo
				$this->sql = "SELECT c.* FROM site_ficha_cadastro_bens_consumo AS c WHERE c.id_ficha = ?"; 
				$this->values = array($c->id_ficha);
				$ret = $this->fetch();
				$acao = (count($ret) > 0) ? 1 : 2;
				$this->site_ficha_cadastro_bens_consumo($acao, $c);
				
				$this->sql = "SELECT c.* FROM site_ficha_cadastro_bens_consumo AS c WHERE c.id_ficha = ?"; 
				$this->values = array($c->id_ficha);
				$ret = $this->fetch();
				if(count($ret) > 0){
					$b->modelo_veiculo = $ret[0]->modelo_veiculo;
					$b->marca_veiculo = $ret[0]->marca_veiculo;
					$b->ano_veiculo = $ret[0]->ano_veiculo;
					$b->placa_veiculo = $ret[0]->placa_veiculo;
					$b->valor_veiculo = $ret[0]->valor_veiculo;
					$b->financiado = $ret[0]->financiado;
					$b->imovel = $ret[0]->imovel;
					$b->valor_venal = $ret[0]->valor_venal;
					$b->somatoria = $ret[0]->somatoria;
				}
				
				return $b;
				break;
		}
	}
	
	public function carrega_todos_forms($c){
		$b = new stdClass();
		
		$b = $this->table_cadastro_acao1($c);
	
		$this->sql = "SELECT c.* FROM site_ficha_cadastro_bens_consumo AS c WHERE c.id_ficha = ?"; 
		$this->values = array($c->id_ficha);
		$ret = $this->fetch();
		if(count($ret) > 0){
			$b->modelo_veiculo = $ret[0]->modelo_veiculo;
			$b->marca_veiculo = $ret[0]->marca_veiculo;
			$b->ano_veiculo = $ret[0]->ano_veiculo;
			$b->placa_veiculo = $ret[0]->placa_veiculo;
			$b->valor_veiculo = $ret[0]->valor_veiculo;
			$b->financiado = $ret[0]->financiado;
			$b->imovel = $ret[0]->imovel;
			$b->valor_venal = $ret[0]->valor_venal;
			$b->somatoria = $ret[0]->somatoria;
		}
		
		$this->sql = "SELECT c.* FROM site_ficha_cadastro_demonstrativo_rendimento AS c WHERE c.id_ficha = ?"; 
		$this->values = array($c->id_ficha);
		$ret = $this->fetch();
		if(count($ret) > 0){
			$b->honorarios = $ret[0]->honorarios; $b->salarios = $ret[0]->salarios;
			$b->comissoes = $ret[0]->comissoes; $b->salario_conjuge = $ret[0]->salario_conjuge;
			$b->renda_alugueis = $ret[0]->renda_alugueis; $b->emprestimo_financeiro = $ret[0]->emprestimo_financeiro;
		}
		
		$this->sql = "SELECT c.* FROM site_ficha_cadastro_referencias_bancarias AS c WHERE c.id_ficha = ?"; 
				$this->values = array($c->id_ficha);
				$ret = $this->fetch();
		if(count($ret) > 0){
			$b->banco = $ret[0]->banco; $b->cartao_credito = $ret[0]->cartao_credito; 
			$b->vencimento = $ret[0]->vencimento; $b->limite = $ret[0]->limite; 
			$b->telefone_banco = $ret[0]->telefone; $b->nome_gerente = $ret[0]->nome_gerente;
			$b->agencia_conta = $ret[0]->agencia_conta;
		}
		
		return $b;
	}
	
	public function table_empresarial($acao, $c){
		switch($acao){
			
			case 2:
				if($c->c_id_usuario != 1){
					$this->sql = "SELECT * FROM site_ficha_cadastro AS c WHERE c.id_ficha = ? AND c.id_usuario = ?";
					$this->values = array($c->id_ficha, $c->c_id_usuario);
					$ret = $this->fetch();
					if(count($ret) == 0){
						echo "<script>openAlertBox('Erro','Você não tem permissão para alterar esta ficha!','fichas-editar.php?id_ficha=".$c->id_ficha."');</script>";
						return;
						#return $this->table_cadastro_acao1($c);
					}
				}
				
				#Experiência com Franquias
				$this->sql = "SELECT c.* FROM site_ficha_cadastro_adicionais AS c WHERE c.id_ficha = ?"; 
				$this->values = array($c->id_ficha);
				$ret = $this->fetch();
				$acao = (count($ret) > 0) ? 1 : 2;
				$this->site_ficha_cadastro_adicionais($acao, 2, $c);
				
				#Histórico Profissional
				$this->site_ficha_cadastro(2, $c);
				
				#Sobre a Franquia Cartório Postal
				$this->site_ficha_cadastro(3, $c);
			
				#Perguntas
				$this->relResposta($c->id_ficha, $c->id_pergunta, $c->perguntas);

				break;
		}
	}
	
	public function table_cadastro($acao, $c){
		switch($acao){
			case 1:
				return $this->table_cadastro_acao1($c);
				break;
				
			case 2:
				if($c->c_id_usuario != 1){
					$this->sql = "SELECT * FROM site_ficha_cadastro AS c WHERE c.id_ficha = ? AND c.id_usuario = ?";
					$this->values = array($c->id_ficha, $c->c_id_usuario);
					$ret = $this->fetch();
					if(count($ret) == 0){
						echo "<script>openAlertBox('Erro','Você não tem permissão para alterar esta ficha!','fichas-editar.php?id_ficha=".$c->id_ficha."');</script>";
						return $this->table_cadastro_acao1($c);
					}
				}
				
				#Validacoes
				$validar = $this->validacoes(1, $c);
				
				if($validar[0] == 0){
					#Cadastro
					$this->site_ficha_cadastro(1, $c);
					
					#Adicionais
					$this->sql = "SELECT c.* FROM site_ficha_cadastro_adicionais AS c WHERE c.id_ficha = ?"; 
					$this->values = array($c->id_ficha);
					$ret = $this->fetch();
					$acao = (count($ret) > 0) ? 1 : 2;
					$this->site_ficha_cadastro_adicionais($acao, 1, $c);
					
					#Conjuge
					$this->sql = "SELECT c.* FROM site_ficha_cadastro_conjuge AS c WHERE c.id_ficha = ?"; 
					$this->values = array($c->id_ficha);
					$ret = $this->fetch();
					$acao = (count($ret) > 0) ? 1 : 2;
					$this->site_ficha_cadastro_conjuge($acao, $c);
					
					#Endereco 2
					$this->sql = "SELECT e.* FROM site_ficha_cadastro_endereco2 AS e WHERE e.id_ficha = ?"; 
					$this->values = array($c->id_ficha);
					$ret = $this->fetch();
					$acao = (count($ret) > 0) ? 1 : 2;
					$this->site_ficha_cadastro_endereco2($acao, $c);
					
					#Lazer
					$this->deleteRelFichaLazer($c->id_ficha);
					if(isset($c->lazer)){
						if(is_array($c->lazer)){
							for($i = 0; $i < count($c->lazer); $i++){
								$this->insereRelFichaLazer($c->id_ficha, $c->lazer[$i]);
							}
						}
					}
					
					return $this->table_cadastro_acao1($c);
				} else {
					$c->erro_js = $validar[1];
				}				
				return $c;				
				break;
		}
	}
	
	public function deleteRelFichaLazer($id){
		$this->sql = "DELETE FROM site_ficha_rel_cadastro_lazer WHERE id_ficha = ?";
		$this->values = array($id);
		$this->exec();
	}
	
	public function insereRelFichaLazer($id, $id2){
		$this->sql = "INSERT INTO site_ficha_rel_cadastro_lazer (id_ficha, id_lazer) VALUES (?, ?)";
		$this->values = array($id, $id2);
		$this->exec();
	}
	
	public function table_cadastro_acao1($c){
		#Cadastro
		$this->sql = "SELECT c.* FROM site_ficha_cadastro AS c WHERE c.id_ficha = ?";
		$this->values = array($c->id_ficha);
		$ret = $this->fetch();
		if(count($ret) > 0){			
			foreach($ret[0] as $nome => $b){ 
				$c->$nome = $b;
			}
		}
		
		#Adicionais
		$this->sql = "SELECT c.* FROM site_ficha_cadastro_adicionais AS c WHERE c.id_ficha = ?"; 
		$this->values = array($c->id_ficha);
		$ret = $this->fetch();
		if(count($ret) > 0){	
			foreach($ret[0] as $nome => $b){ 
				$c->$nome = $b;
			}
		}
		
		#Conjuge
		$this->sql = "SELECT c.* FROM site_ficha_cadastro_conjuge AS c WHERE c.id_ficha = ?"; 
		$this->values = array($c->id_ficha);
		$ret = $this->fetch();
		if(count($ret) > 0){	
			foreach($ret[0] as $nome => $b){ 
				$n = 'conjuge_'.$nome;
				$c->$n = $b;
			}
		}
		
		#Endereco 2
		$this->sql = "SELECT e.* FROM site_ficha_cadastro_endereco2 AS e WHERE e.id_ficha = ?"; 
		$this->values = array($c->id_ficha);
		$ret = $this->fetch();
		if(count($ret) > 0){	
			foreach($ret[0] as $nome => $b){ 
				$n = 'anterior_'.$nome;
				$c->$n = $b;
			}
		}
		
		return $c;
	}
	
	public function site_ficha_cadastro($acao,$c){
		switch($acao){
			case 1:
				$this->sql= "UPDATE site_ficha_cadastro SET nome=?, email=?, rg=?, 
					cpf=?, nascimento=?, tel_res=?, tel_rec=?, tel_cel=?, filhos=?, 
					filhos_quant=?, endereco=?, numero=?, complemento=?, bairro=?, 
					cep=?, estado=?, cidade=?, estado_civil =? WHERE id_ficha=?";	
				$this->values = array($c->nome,$c->email,$c->rg,$c->cpf,$c->nascimento, 
					$c->tel_res,$c->tel_rec,$c->tel_cel,$c->filhos,$c->filhos_quant, 
					$c->endereco,$c->numero,$c->complemento,$c->bairro,$c->cep, 
					$c->estado,$c->cidade,$c->estado_civil,$c->id_ficha);
				break;
				
			case 2:
				$this->sql = "UPDATE site_ficha_cadastro SET empresa_t=?,cargo=?,
					historico=?,periodo=?,funcionarios=?,faturamento=?,ramo_at=?,
					empresa_p=?,cursos=?,escolaridade=?,negocios=? WHERE id_ficha=?";
				$this->values = array($c->empresa_t,$c->cargo,$c->historico,$c->periodo,
					$c->funcionarios,$c->faturamento,$c->ramo_at,$c->empresa_p,$c->cursos,
					$c->escolaridade,$c->negocios,$c->id_ficha);
				break;
				
			case 3:
				$this->sql = "UPDATE site_ficha_cadastro SET conheceu_cp=?,unidades=?,unidades_valor=?,
					comunicados=?,interesse=?,estado_interesse=?,cidade_interesse=?,observacao=? WHERE id_ficha=?";
				$this->values = array($c->conheceu_cp,$c->unidades,$c->unidades_valor,$c->comunicados,
					$c->interesse,$c->estado_interesse,$c->cidade_interesse,$c->observacao,$c->id_ficha);
				break;
				
			case 4:
				$this->sql = "UPDATE site_ficha_cadastro SET capital=?,valor_disp=?,emprestimo=?,
					capital_terc=?,inicio_neg=?,dedicado_franq=?,fonte_renda=?,socios=? WHERE id_ficha=?";
				$this->values = array($c->capital,$c->valor_disp,$c->emprestimo,$c->capital_terc,
					$c->inicio_neg,$c->dedicado_franq,$c->fonte_renda,$c->socios,$c->id_ficha);
		}
		$this->exec();
	}
	
	public function site_ficha_cadastro_bens_consumo($acao, $c){
		$SQL = '';
		$VALUES =array();
		$c->banco = (strlen($c->banco) > 0) ? $c->banco : '';
		if($acao == 1){
			$SQL .= 'UPDATE site_ficha_cadastro_bens_consumo SET modelo_veiculo =?, marca_veiculo =?, 
				ano_veiculo =?, placa_veiculo =?, valor_veiculo =?, financiado =?, imovel =?, valor_venal =?,
				somatoria =? WHERE id_ficha =?';
		} else {
			$SQL .= 'INSERT INTO site_ficha_cadastro_bens_consumo (modelo_veiculo,marca_veiculo,
				ano_veiculo,placa_veiculo,valor_veiculo,financiado,imovel,valor_venal,somatoria,id_ficha) VALUES (?,?,?,?,?,?,?,?,?,?)';
		}
		
		$this->sql = $SQL;
		$this->values = array($c->modelo_veiculo,$c->marca_veiculo,$c->ano_veiculo,$c->placa_veiculo,
			$c->valor_veiculo,$c->financiado,$c->imovel,$c->valor_venal,$c->somatoria,$c->id_ficha);
		$this->exec();
	}
	
	public function site_ficha_cadastro_demonstrativo_rendimento($acao, $c){
		$SQL = '';
		$VALUES =array();
		$c->banco = (strlen($c->banco) > 0) ? $c->banco : '';
		if($acao == 1){
			$SQL .= 'UPDATE site_ficha_cadastro_demonstrativo_rendimento SET honorarios =?,salarios =?,
				comissoes =?,salario_conjuge =?,renda_alugueis =?,emprestimo_financeiro =? WHERE id_ficha =?';
		} else {
			$SQL .= 'INSERT INTO site_ficha_cadastro_demonstrativo_rendimento (honorarios,salarios,comissoes,
			salario_conjuge,renda_alugueis,emprestimo_financeiro,id_ficha) VALUES (?,?,?,?,?,?,?)';
		}
		
		$this->sql = $SQL;
		$this->values = array($c->honorarios,$c->salarios,$c->comissoes,$c->salario_conjuge,
			$c->renda_alugueis,$c->emprestimo_financeiro,$c->id_ficha);
		$this->exec();
	}
	
	public function site_ficha_cadastro_referencias_bancarias($acao, $c){
		$SQL = '';
		$VALUES =array();
		$c->banco = (strlen($c->banco) > 0) ? $c->banco : '';
		if($acao == 1){
			$SQL .= 'UPDATE site_ficha_cadastro_referencias_bancarias SET banco=?, cartao_credito=?, 
				vencimento=?, limite=?, telefone=?, nome_gerente=?, agencia_conta=?
				WHERE id_ficha =?';
		} else {
			$SQL .= 'INSERT INTO site_ficha_cadastro_referencias_bancarias (banco,cartao_credito,vencimento,
				limite,telefone,nome_gerente,agencia_conta,id_ficha) VALUES (?,?,?,?,?,?,?,?)';
		}
		$this->sql = $SQL;
		$this->values = array($c->banco,$c->cartao_credito,$c->vencimento,$c->limite,$c->telefone_banco,
			$c->nome_gerente,$c->agencia_conta,$c->id_ficha);
		$this->exec();
	}
	
	public function site_ficha_cadastro_adicionais($acao, $acao2, $c){
		$SQL = '';
		$VALUES =array();
		if($acao == 1){
			$SQL .= 'UPDATE site_ficha_cadastro_adicionais SET ';
			switch($acao2){
				case 1:
					$SQL .= 'nacionalidade=?,local_nascimento=?,regime=?,data_casamento=?,
						nome_pai=?,nome_mae=?,profissao=?,nome_socio=?,orgao_emissor=?,
						tip_imovel=?,reside_praca=?';
					break;
					
				case 2:
					$SQL .= 'franqueado=?,experiencia=?,motivo=?,funcionarios2=?,
						faturamento2=?,qual_franquia=?,opiniao=?,contato=?,	
						faculdade=?,conclusao=?';
					break;
			}
			$SQL .= ' WHERE id_ficha =?';
		} else {
			$SQL .= 'INSERT INTO site_ficha_cadastro_adicionais (';
			switch($acao2){
				case 1:
					$SQL .= 'nacionalidade,local_nascimento,regime,data_casamento,
						nome_pai,nome_mae,profissao,nome_socio,orgao_emissor,
						tip_imovel,reside_praca,id_ficha) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)';
					break;
					
				case 2:
					$SQL .= 'franqueado,experiencia,motivo,funcionarios2,faturamento2,
						qual_franquia,opiniao,contato,faculdade,conclusao,id_ficha) VALUES (?,?,?,?,?,?,?,?,?,?,?)';
					break;
			}
		}
		switch($acao2){
			case 1:
				$VALUES = array($c->nacionalidade, $c->local_nascimento, $c->regime, $c->data_casamento,
					$c->nome_pai, $c->nome_mae,$c->profissao,  $c->nome_socio, $c->orgao_emissor,
					$c->tip_imovel, $c->reside_praca, $c->id_ficha);
				break;
				
			case 2:
				$VALUES = array($c->franqueado,$c->experiencia,$c->motivo,$c->funcionarios2,$c->faturamento2,
						$c->qual_franquia,$c->opiniao,$c->contato,$c->faculdade,$c->conclusao,$c->id_ficha);
				break;
		}
		$this->sql = $SQL;
		$this->values = $VALUES;
		$this->exec();
	}
	
	public function site_ficha_cadastro_conjuge($acao, $c){
		if($acao == 1){
			$this->sql = 'UPDATE site_ficha_cadastro_conjuge SET 
					nome = ?, rg=?, cpf = ?, email = ?, nascimento = ?, nome_pai = ?,
					nome_mae = ?, profissao = ?, cargo = ?, empresa = ?, telefone = ?,
					admissao = ?, end_empresa = ?, numero = ?, complemento = ?, bairro = ?,
					estado = ?, cidade = ?, cep = ?  
					WHERE id_ficha =?';
		} else {
			$this->sql = 'INSERT INTO site_ficha_cadastro_conjuge(
					nome, rg, cpf, email, nascimento, nome_pai,
					nome_mae, profissao, cargo, empresa, telefone, admissao, end_empresa,
					numero, complemento, bairro, estado, cidade, cep, id_ficha)
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
		}
		$this->values = array($c->conjuge_nome, $c->conjuge_rg, $c->conjuge_cpf, $c->conjuge_email, $c->conjuge_nascimento, $c->conjuge_nome_pai,
			$c->conjuge_nome_mae, $c->conjuge_profissao, $c->conjuge_cargo, $c->conjuge_empresa, $c->conjuge_telefone,
			$c->conjuge_admissao, $c->conjuge_end_empresa, $c->conjuge_numero, $c->conjuge_complemento, $c->conjuge_bairro,
			$c->conjuge_estado, $c->conjuge_cidade, $c->conjuge_cep, $c->id_ficha);
		$this->exec();
	}
	
	public function site_ficha_cadastro_endereco2($acao, $c){
		if($acao == 1){
			$this->sql = 'UPDATE site_ficha_cadastro_endereco2 SET 
					endereco = ?, numero = ?, complemento = ?, bairro = ?, estado = ?, cidade = ?, cep = ? 
					WHERE id_ficha =?';
		} else {
			$this->sql = 'INSERT INTO site_ficha_cadastro_endereco2 (
					endereco, numero, complemento, bairro,
					estado, cidade, cep, id_ficha) VALUES (?,?,?,?,?,?,?,?)';
		}
		$this->values = array($c->anterior_endereco, $c->anterior_numero, $c->anterior_complemento, 
			$c->anterior_bairro, $c->anterior_estado, $c->anterior_cidade, $c->anterior_cep, $c->id_ficha);
		$this->exec();
	}

	public function validacoes($acao, $c){
		$erro  = '';
		$errors= 0;
		$js    = '';
		switch($acao){
			case 1:
				$cp_nome = array('Nome','E-mail','RG','Órgão Emissor','CPF','Data de Nascimento', 
					'Residencial','Nacionalidade','Estado Civil','Profissão','Endereço','Nº.',
					'Bairro','CEP','UF','Cidade','Endereço','Nº.','Bairro','CEP','UF','Cidade'
				);
				$cp_var  = array('nome','email','rg','orgao_emissor','cpf','nascimento','tel_res', 
					'nacionalidade','estado_civil','profissao','endereco','numero','bairro','cep',
					'estado','cidade','anterior_endereco','anterior_numero','anterior_bairro','anterior_cep',
					'anterior_estado','anterior_cidade'
				);
				for($i = 0; $i < count($cp_var); $i++){
					$cp_esp = 0;
					if($cp_var[$i] == 'orgao_emissor'){
						if($c->$cp_var[$i] == 0){
							$cp_esp = 1;
							$errors++;
							$erro .= '<li>O campo '.$cp_nome[$i].' não pode ser vazio!</li>';
							$js   .= "\tdocument.getElementById('".$cp_var[$i]."').className = 'form_estilo_erro'\n";
						}
					} 
					if($cp_esp == 0){
						if(strlen($c->$cp_var[$i]) == 0){ 
							$errors++;
							$erro .= '<li>O campo '.$cp_nome[$i].' não pode ser vazio!</li>';
							$js   .= "\tdocument.getElementById('".$cp_var[$i]."').className = 'form_estilo_erro'\n";
						}
					}
				}
				break;
		}		
		if($errors > 0){
			$erro = '<b>Ocorreram os seguintes erros:</b><ul>'.$erro.'</ul>';
			echo "<script>\n\t"."document.getElementById('erros_exibir').innerHTML = '".$erro."';"."\n\t";
			echo "document.getElementById('erros_exibir').style.display='block'\n";
			echo "</script>\n";
			return array(1,$js);
		} else { return array(0,null); }
	}
	
	public function historico($c){	
		$errors = 0;	
		switch($c->id_status){
			case 5: case 10: case 21: case 19:
			
				if(($c->data_reuniao == '//' || strlen($c->data_reuniao) == 0) && $errors == 0 && $c->id_status != 19
					&& $c->id_status != 21){
					$errors++;
					$erro = '<li>Data digitada é inválida!</li>';
					$cp    = 'data_reuniao';
					$erro_dt= 1;
				} else {
					if($c->data_reuniao<>''){
						$data = explode("/", $c->data_reuniao); 
						$d = $data[0];
						$m = $data[1];
						$y = $data[2];
						
						if(checkdate($m,$d,$y) == 0 && $c->id_status != 21){
							$errors++;
							$erro = '<li>Data digitada '.$d.'/'.$m.'/'.$y.' é inválida!</li>';
							$cp    = 'data_reuniao';
							$erro_dt= 1;
						}
					}
				}
			
				$dt_comp1 = $y.'-'.$m.'-'.$d;
				$dt_ver1  = strtotime($dt_comp1);
				
				$dt_comp2 = date('Y-m-d');
				$dt_ver2  = strtotime($dt_comp2);
				if($errors == 0 && ($dt_ver1 < $dt_ver2) && $c->data_reuniao<>''){
					$errors++;
					$erro = '<li>A data digitada não pode ser inferior a data atual!</li>';
					$cp    = 'data_reuniao';
					$erro_dt= 1;
				}
			
				break;
				
			case 9: case 11: case 13: case 14: case 18:
				$tipo_up = $this->tipo_upload(2, 0);
				for($i = 0; $i < count($tipo_up[0]); $i++){
					if($tipo_up[0][$i] > 0){
						$exc = 1;
						$exc = ($tipo_up[0][$i] == 3 && $c->id_status == 9) ? 0 : $exc;
						if($exc == 1){
							$this->sql = "SELECT a.* FROM site_ficha_anexos AS a WHERE a.id_ficha = ? AND a.tipo_upload = ? AND a.ativo = 1
								AND a.arquivo != ''  AND  a.nome != ''";
							$this->values = array($c->id_ficha, $tipo_up[0][$i]);
							$dt = $this->fetch();
							if(!$dt[0] > 0){
								#$errors++;
								#$erro .= '<li>Vá na aba "Jurídico" e anexe o arquivo "'.$tipo_up[1][$i].'"!</li>';
								#$cp    = 'arquivo';
								#$erro_sb= 1;
							}
						}
					}
				}
				break;
				
			case 2: case 3: case 16: case 17: case 20:
				if(strlen($c->observacao_expansao) == 0){
					$errors++;
					$erro = '<li>O Campo Observações, não pode ser vazio!</li>';
					$cp    = 'observacao_expansao';
					$erro_sb= 1;
				}
				
				break;
				
			case 0:
				$cp = 'id_status'; $errors++;
				$erro = '<li>Você deve selecionar um Status para prosseguir!</li>';				
		}

		$c->dt_comp1 = $dt_comp1;
		if($errors == 0){
			return $this->cadHistorico($c);
		} else {
			$erro = '<b>Ocorreram os seguintes erros:</b><ul>'.$erro.'</ul>';
			echo "<script>\n\t"."document.getElementById('erros_exibir').innerHTML = '".$erro."';"."\n\t";
			echo "document.getElementById('erros_exibir').style.display='block'\n";
			echo "</script>\n";
			return array(1,"\tdocument.getElementById('".$cp."').className = 'form_estilo_erro'\n");
		}
	}
	
	public function editaModificaStatus($lista, $id_status = 0){
		$sql = "UPDATE site_ficha_cadastro SET  id_user_alt=".$lista['id_user_alt'].", ";
		#echo '<br><br>'.$lista['id_usuario'];
		if($lista['id_status']==22 and $lista['id_usuario']<>''){
				$sql .= "id_usuario=".$lista['id_usuario'].",";
		} else {
			if($lista['id_status']){
				$sql .= "id_status=".$lista['id_status'].",";
			} 
			if($lista['data_reuniao'] != '--'){
				$sql .= "data_reuniao='".$lista['data_reuniao']."', ";
			}
		}
		#if($id_status != 19){
			$sql .= " observacao_expansao='".$lista['observacao_expansao']."', ";
		#}
		$sql .= "data_reuniao_inclusao='".$lista['data_reuniao_inclusao']."' WHERE id_ficha=".$lista['id_ficha']."";		
		$this->sql= $sql;
		$this->exec();
	}
	
	public function insereHistorico($lista, $c){	
		global $controle_id_usuario;	
		$lista['id_user_alt'] = $controle_id_usuario;
		
		$this->sql = "INSERT INTO site_ficha_cadastro_historico (
			id_ficha, id_user_alt, id_status, data_reuniao, data_inclusao, observacao, forma_pagto)
			VALUES (?, ?, ?, ?, ?, ?, ?)";
		$arr = array_values($lista);

		$this->values = $arr;
		$this->exec();
	}	
	
	public function cadHistorico($c){
		$e = $this->buscaIDStatus($c->id_ficha);
		$id_status_anterior 			= $e->id_status;
		$data_reuniao_anterior 			= $e->data_reuniao;
		$data_reuniao_inclusao_anterior = $e->data_reuniao_inclusao;
		$id_user_alt_anterior 			= $e->id_user_alt;
		$observacao_anterior 			= $e->observacao_expansao;
		$e->data_reuniao = ($e->data_reuniao<>'') ? explode("/", $e->data_reuniao) : array('01','01','1900');
		$d = $e->data_reuniao[0]; $m = $e->data_reuniao[1]; $y = $e->data_reuniao[2];
		
		$c->dt_comp1 = (strlen($c->dt_comp1) == 0) ? '0000-00-00' : $c->dt_comp1;
		$id_status_anterior = $e->id_status;
		$id_status_atual = $c->id_status;
		
		#laço para atualizar ficha
		if($c->id_status == 19 || $c->id_status == 21){
			$lista = array(
				'id_user_alt'=>$c->c_id_usuario, 'observacao_expansao'=>$c->observacao_expansao,
				'data_reuniao'=>$c->dt_comp1, 'data_reuniao_inclusao'=>date ('Y-m-j') . ' ' . date ('H:i:s'), 
				'id_ficha'=>$c->id_ficha
			);
			$id_status_anterior = $c->id_status;
			$observacao_anterior = $c->observacao_expansao;
			$data_reuniao_anterior = $c->dt_comp1;
		} else {
			$lista = array(
				'id_user_alt'=>$c->c_id_usuario,'id_usuario'=>$e->id_usuario,'id_status'=>$c->id_status,
				'observacao_expansao'=>$c->observacao_expansao,'data_reuniao'=>$c->dt_comp1, 
				'data_reuniao_inclusao'=>date ('Y-m-j H:i:s'), 
				'id_ficha'=>$c->id_ficha
			);
		}
		$this->editaModificaStatus($lista, $c->id_status);
		
		#$lista = array(
		#		'id_ficha'=>$c->id_ficha, 'id_user_alt'=>$id_user_alt_anterior, 
	#			'id_status'=>$id_status_anterior, 'data_reuniao'=>$data_reuniao_anterior, 'data_inclusao'=>$data_reuniao_inclusao_anterior,
	#			'observacao'=>$observacao_anterior,'forma_pagto'=>$c->forma_pagto2
#			);

		
		#if($c->c_id_usuario == 1){
			if($c->id_status == 19 || $c->id_status == 21){
				$this->sql = "SELECT * FROM site_ficha_cadastro_historico WHERE id_ficha = ?";
				$this->values = array($c->id_ficha);
				$ret = $this->fetch();
				#quando não existe histórico
				if(count($ret) == 0){
					#histórico anterior
					$lista = array(
						'id_ficha'=>$c->id_ficha, 'id_user_alt'=>$c->id_user_alt, 
						'id_status'=>$e->id_status, 'data_reuniao'=>$e->data_reuniao[0], 'data_inclusao'=>$e->data_reuniao_inclusao,
						'observacao'=>$e->observacao_expansao,'forma_pagto'=>0
					);
					$this->insereHistorico($lista, $c);
				}
			}
			#histórico atual
			$lista = array(
				'id_ficha'=>$c->id_ficha, 'id_user_alt'=>$c->c_id_usuario, 
				'id_status'=>$c->id_status, 'data_reuniao'=>$c->dt_comp1, 'data_inclusao'=>date('Y-m-d H:i:s'),
				'observacao'=>$c->observacao_expansao,'forma_pagto'=>$c->forma_pagto2
			);						
		#}
		$this->insereHistorico($lista, $c);	

		
		
		if($id_status_atual != 19){
			$html = '';
			switch($c->id_status){
				case 4: 
					$this->email_elaborar_cof($c); 
					break;
				case 9: 
					$this->email_emitir_contrato($c); 
					break;
				case 14: 
					$this->email_finalizar($c); 
					break;
				case 6: case 13:
					$this->email_finalizar_processo($c);
					break;
			}
		}
		
		return array(0,$e);
	}
	
	public function email_finalizar_processo($c){
		$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Sistema Sistecart - Finalizar Processo</title>
		</head>
		<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
		Prezados,<br /><br />
		A ficha de número '.$c->id_ficha.' já pode ser cadastrada como franquia.<br /><br />
		Você deve conferir os dados e clicar no botão "Finalizar"<br /><br />
		
		Obrigado.<br /><br />

		<a href="http://www.cartoriopostal.com.br/sistema/expansao/fichas-editar.php?id_ficha='.$c->id_ficha.'&aba=4" target="_blank">Clique aqui</a><br /><br />

		São Paulo, '.date('d').' de '.$this->mes(date('m')).' de '.date('Y').'.<br />
		Hora: '.date('H').':'.date('i').'. <br /><br />

		Atenciosamente,<br />
		Equipe Cartório Postal.
		</body>
		</html>';
		
		include("../../includes/maladireta/class.PHPMailer.php");
		$mailer = new SMTPMailer();

		$From = 'Sistema Expansão';
		$AddAddress = 'renato.bacin@cartoriopostal.com.br,Renato Bacin;
			priscila.paro@cartoriopostal.com.br,Priscila Paro';
		$AddCC = $c->user_email.','.$c->user_nome;
		$AddBCC = 'ti@cartoriopostal.com.br';
		$Subject = 'Expansão - Finalizar Processo Expansão';
		$mailer->SEND($From, $AddAddress, $AddCC, '', '', $Subject, $html);			
	}
	
	public function verDadosAdm($id){
		$this->sql = "SELECT c.* FROM site_ficha_cadastro_dados_administrativos AS c
			WHERE c.tipo_franquia > 0 AND c.forma_pagto != '' AND c.valor_efetivo > 0 AND c.id_ficha = ?";
		$this->values = array($id);
		return $this->fetch();
	}
	
	public function email_elaborar_cof($c){
		$c = $this->selFicha($c->id_ficha);
		$og = $this->orgao_emissor($c->orgao_emissor);
		switch($c->tipo_franquia){
			case 1: $franquia = 'Master - '.$c->estado_interesse; break;
			case 2: $franquia = 'Unitária - '.$c->cidade_interesse; break;
			case 2: $franquia = 'Subfranquia - '.$c->cidade_interesse; break;
			case 4: $franquia = 'Internacional - Brasil'; break;
		}

		$tel = $c->tel_res;
		if(strlen($c->tel_rec) > 0){ $tel .= ' / '.$c->tel_rec; }
		if(strlen($c->tel_cel) > 0){ $tel .= ' / '.$c->tel_cel; }

		$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Sistema Sistecart - Elaborar COF</title>
		</head>
		<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
		<b>Elaborar COF</b><br /><br /><br />
		<b>Nº. da Ficha:</b>	'.$c->id_ficha.'<br /><br />
		<b>Nome Completo:</b>	'.$c->nome.'<br /><br />
		<b>Forma de Pagamento:</b>	'.$c->forma_pagto.'<br /><br />
		<b>Nome do Sócio:</b>	'.$c->nome_socio.'<br /><br />
		<b>Nacionalidade:</b>	'.$c->nacionalidade.'<br /><br />
		<b>Data de Nascimento:</b>	'.$c->nascimento.'<br /><br />
		<b>Estado Civil:</b>	'.$c->estado_civil.'<br /><br />
		<b>Profissão:</b>	'.$c->profissao.'<br /><br />
		<b>Endereço:</b>	'.$c->endereco.', '.$c->numero.' '.$c->complemento.'<br />
		'.$c->bairro.' - '.$c->cep.' - '.$c->cidade.' - '.$c->estado.'<br /><br />
		<b>RG:</b>	'.$c->rg.' '.$og.'<br /><br />
		<b>CPF:</b>	'.$c->cpf.'<br /><br />
		<b>Telefone:</b>	'.$tel.'<br /><br />
		<b>Tipo Franquia:</b>	'.$franquia.'<br /><br />
		<b>Valor da Franquia:</b>	'.$c->valor_efetivo.'<br /><br />
		<b>Valor do Royaltie:</b>	'.$c->valor_royaltie.'<br /><br />
		<b>Cidade de Interesse:</b>	'.$c->cidade_interesse.'<br /><br /><br />

		São Paulo, '.date('d').' de '.$this->mes(date('m')).' de '.date('Y').'.<br />
		Hora: '.date('H').':'.date('i').'. <br /><br />

		Atenciosamente,<br />
		Equipe Cartório Postal.
		</body>
		</html>';
		
		include("../../includes/maladireta/class.PHPMailer.php");
		$mailer = new SMTPMailer();

		$From = 'Sistema Expansão';
		$AddAddress = 'renato.bacin@cartoriopostal.com.br,Renato Bacin;
			priscila.paro@cartoriopostal.com.br,Priscila Paro;weslley.floriano@cartoriopostal.com.br,Weslley Floriano';
		$AddCC = $c->user_email.','.$c->user_nome;
		$AddBCC = 'ti@cartoriopostal.com.br;suporte@cartoriopostal.com.br';
		$Subject = 'Expansão - Elaborar COF';
		$mailer->SEND($From, $AddAddress, $AddCC, $AddBCC, '', $Subject, $html);		
	}
	
	public function email_emitir_contrato($c){
		$c = $this->selFicha($c->id_ficha);
		$og = $this->orgao_emissor($c->orgao_emissor);
		switch($c->tipo_franquia){
			case 1: $franquia = 'Master - '.$c->estado_interesse; break;
			case 2: $franquia = 'Unitária - '.$c->cidade_interesse; break;
			case 2: $franquia = 'Subfranquia - '.$c->cidade_interesse; break;
			case 4: $franquia = 'Internacional - Brasil'; break;
		}

		$tel = $c->tel_res;
		if(strlen($c->tel_rec) > 0){ $tel .= ' / '.$c->tel_rec; }
		if(strlen($c->tel_cel) > 0){ $tel .= ' / '.$c->tel_cel; }

		$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Sistema Sistecart - Emitir Contrato</title>
		</head>
		<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
		<b>Emitir Contrato</b><br /><br /><br />
		<b>Nº. da Ficha:</b>	'.$c->id_ficha.'<br /><br />
		<b>Nome Completo:</b>	'.$c->nome.'<br /><br />
		<b>Forma de Pagamento:</b>	'.$c->forma_pagto.'<br /><br />
		<b>Nome do Sócio:</b>	'.$c->nome_socio.'<br /><br />
		<b>Nacionalidade:</b>	'.$c->nacionalidade.'<br /><br />
		<b>Data de Nascimento:</b>	'.$c->nascimento.'<br /><br />
		<b>Estado Civil:</b>	'.$c->estado_civil.'<br /><br />
		<b>Profissão:</b>	'.$c->profissao.'<br /><br />
		<b>Endereço:</b>	'.$c->endereco.', '.$c->numero.' '.$c->complemento.'<br />
		'.$c->bairro.' - '.$c->cep.' - '.$c->cidade.' - '.$c->estado.'<br /><br />
		<b>RG:</b>	'.$c->rg.' '.$og.'<br /><br />
		<b>CPF:</b>	'.$c->cpf.'<br /><br />
		<b>Telefone:</b>	'.$tel.'<br /><br />
		<b>Tipo Franquia:</b>	'.$franquia.'<br /><br />
		<b>Valor da Franquia:</b>	'.$c->valor_efetivo.'<br /><br />
		<b>Valor do Royaltie:</b>	'.$c->valor_royaltie.'<br /><br />
		<b>Cidade de Interesse:</b>	'.$c->cidade_interesse.'<br /><br /><br />

		São Paulo, '.date('d').' de '.$this->mes(date('m')).' de '.date('Y').'.<br />
		Hora: '.date('H').':'.date('i').'. <br /><br />

		Atenciosamente,<br />
		Equipe Cartório Postal.
		</body>
		</html>';
		
		include("../../includes/maladireta/class.PHPMailer.php");
		$mailer = new SMTPMailer();

		$From = 'Sistema Expansão';
		$AddAddress = 'renato.bacin@cartoriopostal.com.br,Renato Bacin;
			priscila.paro@cartoriopostal.com.br,Priscila Paro';
		$AddCC = $c->user_email.','.$c->user_nome;
		$AddBCC = 'ti@cartoriopostal.com.br;suporte@cartoriopostal.com.br';
		$Subject = 'Expansão - Emitir Contrato';
		$mailer->SEND($From, $AddAddress, $AddCC, $AddBCC, '', $Subject, $html);
	}
	
	public function email_finalizar($c){
		$b = $c;
		$c = $this->selFicha($c->id_ficha);
		if($c->id_empresa == 0){
			$c->cpf = str_replace('.','', $c->cpf);
			$c->cpf = str_replace(',','', $c->cpf);
			$c->cpf = str_replace('/','', $c->cpf);
			$c->cpf = str_replace('-','', $c->cpf);
			$tipo = (strlen($c->cpf) <= 11) ? 'cpf' : 'cnpj';
			$c->cpf = ($tipo == 'cpf') ? $this->mask($c->cpf,'###.###.###-##') : $this->mask($c->cpf,'##.###.###/####-##');
			$fantasia = $c->cidade_interesse.' - '.$c->estado_interesse;
		
			$this->sql = 'INSERT INTO vsites_user_empresa (empresa,fantasia,tipo,cpf,rg,nome,
				cel,tel,tel_err,email,endereco,complemento,numero,cidade,estado,bairro,cep,
				data,chat,ultima_acao,status,ramal,franquia,ip,imposto,royalties,fax,modalidade,sigla_cidade,
				id_banco,agencia,conta,favorecido,imagem,interrede,adendo_data,adendo,inicio,sem1,sem2,sem3,roy_min,
				roy_min2,inauguracao_data,validade_contrato,modalidade_c,data_cof,precontrato,aditivo,exclusividade,
				notificacao,franquia_tipo,id_recursivo) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,
				?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
			$c->tipo_franquia = ($c->tipo_franquia == '') ? 2 : $c->tipo_franquia;
			$this->values = array($c->empresa_t,$fantasia,$tipo,$c->cpf,$c->rg,$c->nome,
				$c->tel_rec,$c->tel_res,$c->tel_cel,'',$c->endereco,$c->complemento,$c->numero,$c->cidade,$c->estado,$c->bairro,$c->cep,
				null,null,null,'Implantação',null,null,null,'0.00','0.00',null,null,null,
				null,null,null,null,'',0,'0000-00-00',0,'0000-00-00','0.00','0.00','0.00','0.00',
				'0.00','0000-00-00','0000-00-00','','0000-00-00','0000-00-00','0000-00-00',0,
				'',$c->tipo_franquia,0);
			$this->exec();
			
			$this->sql = "SELECT e.* FROM vsites_user_empresa AS e WHERE e.cpf = ?";
			$this->values = array($c->cpf);
			$ret = $this->fetch();
			if(count($ret) > 0){
				$this->sql = "SELECT e.* FROM vsites_user_empresa_implantacao AS e WHERE e.id_empresa = ?";
				$this->values = array($ret[0]->id_empresa);
				$ret1 = $this->fetch();
				if(count($ret1) == 0){
						$this->sql = "INSERT INTO vsites_user_empresa_implantacao (id_empresa,id_ficha,id_usuario,id_consultor1,id_consultor2,franqueado,telefone1,telefone2,
						email,endereco,numero,complemento,bairro,cep,cidade,uf) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
					$this->values = array($ret[0]->id_empresa, $c->id_ficha, $c->id_usuario, 0,0,$c->nome,$c->tel_res, $c->tel_rec,
						$c->email,$c->endereco,$c->numero,$c->complemento, $c->bairro, $c->cep, $c->cidade, $c->uf);
					$this->exec();
				}
				$this->sql = "SELECT a.* FROM site_ficha_anexos AS a WHERE a.id_ficha = ? AND a.ativo = 1";
				$this->values = array($c->id_ficha);
				$ret2 = $this->fetch();
				if(count($ret2) > 0){
					$i = 0;
					foreach($ret2 as $d => $res){
						if(!is_dir("../uploads/".date('Ym'))){
							mkdir("../uploads/".date('Ym'), 0777); 
						} 
						$origem = $res->arquivo;
						$destino = explode('/',$res->arquivo);
						$extensao= explode('.',$destino[count($destino)-1]);
						$extensao= $extensao[1];
						$destino = "../uploads/".date('Ym').'/'.$destino[count($destino)-1];
						copy($origem, $destino);
						$novo_arquivo = date('YmdHis').$i.'.'.$extensao;
						rename($destino, "../uploads/".date('Ym').'/'.$novo_arquivo);
						$this->sql = "INSERT INTO vsites_user_empresa_upload (id_empresa,id_usuario,ativo,arquivo,data) 
							VALUES (?,?,?,?,?)";
						$this->values = array($ret[0]->id_empresa,$b->c_id_usuario,1,date('Ym').'/'.$novo_arquivo,date('Y-m-d H:i:s'));
						$this->exec();
						$i++;
					}
				}
			}

			
			$this->sql = 'UPDATE site_ficha_cadastro SET id_empresa = ?, id_status  = ? WHERE id_ficha = ?';
			$this->values = array($ret[0]->id_empresa, 18, $c->id_ficha);
			$this->exec();
			
			$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
				"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
				<title>Sistema Sistecart - Cadastrar Franquia</title>
				</head>
				<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
				Prezados,<br /><br /> Foi criada a franquia de número '.$ret[0]->id_empresa.' no sistema.<br /><br />
				Para dar continuidade o depto. de TI deve primeiramente seguir os seguintes passos:<br /><br />
				- alterar o status da franquia ('.$ret[0]->fantasia.') de "Implantação" para "Ativo";<br />
				- verifique os dados de cadastros; e <br />
				- crie os e-mails e usuários para a franquia.<br /><br />
				Com isso, o depto. de Implantação pode prosseguir e completar o restante do processo.<br /><br />	
				
				Obrigado.<br /><br />

				<a href="http://www.cartoriopostal.com.br/sistema/controle/franquias_editar.php?id='.$ret[0]->id_empresa.'" target="_blank">Clique aqui</a> 
				e siga os passos abaixo:<br />
				<font size="4" style="font-weight:bold">Escolha a aba que deseja visualizar > 00 - Dados da Franquia</font><br /><br />

				São Paulo, '.date('d').' de '.$mes.' de '.date('Y').'.<br /> 
				Hora: '.date('H').':'.date('i').'. <br /><br />

				Atenciosamente,<br />
				Equipe Cartório Postal.
				</body>
				</html>';
			
			include("../../includes/maladireta/class.PHPMailer.php");
			$mailer = new SMTPMailer();

			$From = 'Sistema Expansão';
			$AddAddress = 'ti@cartoriopostal.com.br,TI;';
			$AddAddress.= 'nivaldo.silva@cartoriopostal.com.br,Nivaldo Silva';
			$AddCC = $c->user_email.','.$c->user_nome;
			$AddBCC = 'suporte@cartoriopostal.com.br';
			$Subject = 'Expansão - Cadastrar Franquia';
			$mailer->SEND($From, $AddAddress, $AddCC, $AddBCC, '', $Subject, $html);			
		}		
		header('Location: fichas-editar.php?id_ficha='.$c->id_ficha.'&aba=4');
	}
	
	public function selFicha($id){
		$c = new stdClass();
	
		$this->sql = "SELECT c.*, u.nome AS user_nome, u.email AS user_email 
			FROM site_ficha_cadastro AS c, vsites_user_usuario AS u WHERE c.id_ficha = ? AND
			c.id_usuario = u.id_usuario";
		$this->values = array($id);
		$ret = $this->fetch();
		if(count($ret) > 0){			
			foreach($ret[0] as $nome => $b){ 
				$c->$nome = $b;
			}
		}
		
		$this->sql = "SELECT c.* FROM site_ficha_cadastro_dados_administrativos AS c WHERE c.id_ficha = ?";
		$this->values = array($id);
		$ret = $this->fetch();
		if(count($ret) > 0){			
			foreach($ret[0] as $nome => $b){ 
				$c->$nome = $b;
			}
		}
		
		$this->sql = "SELECT c.* FROM site_ficha_cadastro_adicionais AS c WHERE c.id_ficha = ?";
		$this->values = array($id);
		$ret = $this->fetch();
		if(count($ret) > 0){			
			foreach($ret[0] as $nome => $b){ 
				$c->$nome = $b;
			}
		}
	
		
		return $c;
	}
	
	public function mask($val, $mask){
		$maskared = '';
		$k = 0;
		for($i = 0; $i<=strlen($mask)-1; $i++){
			if($mask[$i] == '#'){
				if(isset($val[$k]))
					$maskared .= $val[$k++];
			} else {
				if(isset($mask[$i]))
					$maskared .= $mask[$i];
			}
		}
		return $maskared;
	}
	
	public function mes($mes){
		switch($mes){
			case 1: return 'janeiro'; break;
			case 2: return 'fevereiro'; break;
			case 3: return 'março'; break;
			case 4: return 'abril'; break;
			case 5: return 'maio'; break;
			case 6: return 'junho'; break;
			case 7: return 'julho'; break;
			case 8: return 'agosto'; break;
			case 9: return 'setembro'; break;
			case 10: return 'outubro'; break;
			case 11: return 'novembro'; break;
			case 12: return 'dezembro'; break;
		}
	}
	
	public function orgao_emissor($id){
		switch($id){
			case 1: $orgao_emissor='SSP-AC'; break;
			case 2: $orgao_emissor='SSP-AL'; break;
			case 3: $orgao_emissor='SSP-AM'; break;
			case 4: $orgao_emissor='SSP-AP'; break;
			case 5: $orgao_emissor='SSP-BA'; break;
			case 6: $orgao_emissor='SSP-CE'; break;
			case 7: $orgao_emissor='SSP-DF'; break;
			case 8: $orgao_emissor='SSP-ES'; break;
			case 9: $orgao_emissor='SSP-GO'; break;
			case 10: $orgao_emissor='SSP-MA'; break;
			case 11: $orgao_emissor='SSP-MG'; break;
			case 12: $orgao_emissor='SSP-MS'; break;
			case 13: $orgao_emissor='SSP-MT'; break;
			case 14: $orgao_emissor='SSP-PA'; break;
			case 15: $orgao_emissor='SSP-PB'; break;
			case 16: $orgao_emissor='SSP-PE'; break;
			case 17: $orgao_emissor='SSP-PI'; break;
			case 18: $orgao_emissor='SSP-PR'; break;
			case 19: $orgao_emissor='SSP-RJ'; break;
			case 20: $orgao_emissor='SSP-RN'; break;
			case 21: $orgao_emissor='SSP-RO'; break;
			case 22: $orgao_emissor='SSP-RR'; break;
			case 23: $orgao_emissor='SSP-RS'; break;
			case 24: $orgao_emissor='SSP-SC'; break;
			case 25: $orgao_emissor='SSP-SE'; break;
			case 26: $orgao_emissor='SSP-SP'; break;
			case 27: $orgao_emissor='SSP-TO'; break;
			default: $orgao_emissor='Órgão emissor não selecionado'; break;
		}
		return $orgao_emissor;
	}
	
	public function buscarStatus($id){
		$this->sql = "SELECT s.* FROM site_ficha_cadastro_status AS s WHERE s.id_status = ?";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret[0]->status;
	}
	
	public function retornaUltimoStatus($id){
		$this->sql = 'SELECT c.observacao_expansao, c.id_status, c.data_reuniao, c.data_cad_user_updt, 
			c.data_reuniao_inclusao, c.id_user_alt, s.status, u.nome
			FROM site_ficha_cadastro AS c, site_ficha_cadastro_status AS s, vsites_user_usuario AS u
			WHERE c.id_ficha = ? AND c.id_status = s.id_status AND u.id_usuario = c.id_user_alt ';
		$this->values = array($id);
		$ret = $this->fetch();
		if(count($ret) > 0){			
			echo "\n\t".'<tr style="background:#FFFFA8;">'."\n";
			echo "\t\t".'<td style="border:solid 1px #0D357D; border-top:none; border-left:none;font-size:11px;border-bottom:solid 2px #0D357D">&nbsp;'.$ret[0]->status.'</td>'."\n";
			echo "\t\t".'<td style="border:solid 1px #0D357D; border-top:none; border-left:none;font-size:11px;border-bottom:solid 2px #0D357D">&nbsp;'.$ret[0]->nome.'</td>'."\n";
			echo "\t\t".'<td style="border:solid 1px #0D357D; border-top:none; border-left:none;font-size:11px;border-bottom:solid 2px #0D357D">&nbsp;'.$ret[0]->observacao_expansao;
			$data = explode('-', $ret[0]->data_reuniao);
			$d = $data[2].'/'.$data[1].'/'.$data[0];
			echo ($d == '00/00/0000') ? '' : '<br />&nbsp;<b style="font-size:11px;">['.$d.']</b>';
			echo '</td>'."\n";
			echo "\t\t".'<td style="border:solid 2px #0D357D; border-top:none; border-left:none;border-right:none;text-align:center;font-size:11px;border-bottom:solid 2px #0D357D">';
			$d = explode(' ', $ret[0]->data_reuniao_inclusao);
			$data = explode('-', $d[0]);
			$hora = explode(':', $d[1]);
			echo $data[2].'/'.$data[1].'/'.$data[0] . ' ' . $hora[0].':'.$hora[1];
			echo '</td>'."\n";
			echo "\t".'</tr>'."\n";
		}
	}
	
	public function insereAnexo($lista){	
		$this->sql = "INSERT INTO site_ficha_anexos (id_ficha, arquivo, tipo_upload, nome, id_usuario, ativo) VALUES (?,?,?,?,?,1)";
		$arr = array_values($lista);
		$this->values = $arr;
		$this->exec();
	}
	
	public function listaAnexo($id){
		$this->sql="SELECT a.*, (CASE WHEN u.nome IS NULL THEN 'Administrador' ELSE u.nome END) AS consultor 
			FROM site_ficha_anexos AS a LEFT JOIN vsites_user_usuario AS u 
			ON a.id_usuario = u.id_usuario WHERE a.id_ficha=? AND a.ativo=1 ORDER BY a.nome";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret;	
	}
	
	public function excluiAnexo($c){
		$executa = 0;
		$this->sql = "SELECT * FROM site_ficha_anexos AS c WHERE c.id_ficha = ? AND c.id_anexo = ?";
		$this->values = array($c->id_ficha, $c->id_arquivo);
		$ret = $this->fetch();
		if(count($ret) > 0){
			if($c->c_id_usuario == 1){ $executa = 1; }
			if($ret[0]->id_usuario == $c->c_id_usuario && $executa == 0){ $executa = 1; }
		}
		if($executa == 1){
			$this->sql = "UPDATE site_ficha_anexos SET ativo = 0 WHERE id_anexo=".$c->id_arquivo. " AND id_ficha=".$c->id_ficha;			
			$this->exec();
		}
	}
	
	public function cadDadosAdm($c, $_FILES){
		$errors = 0;
		if($c->tipo_franquia == 0){
			$errors++;
			$erro .= '<li>Preencha o Tipo da Franquia!</li>';
			$js   .= "\tdocument.getElementById('tipo_franquia').className = 'form_estilo_erro'\n";
		}
		
		if(strlen($c->forma_pagto) == 0){
			$errors++;
			$erro .= '<li>Preencha a Forma de Pagamento!</li>';
			$js   .= "\tdocument.getElementById('forma_pagto').className = 'form_estilo_erro'\n";
		}
		
		if(strlen($c->valor_efetivo) == 0){
			$errors++;
			$erro .= '<li>Preencha o Valor Efetivo!</li>';
			$js   .= "\tdocument.getElementById('valor_efetivo').className = 'form_estilo_erro'\n";
		}
		
		if($errors == 0){
			if($_FILES['error'] == 0){
				if($c->tipo_upload > 0){
					$ext = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
					$file_path = "../anexos/".date("Ym")."/";
					if(!is_dir($file_path)) mkdir($file_path);
					$arquivo = $file_path.$c->id_ficha.'_'.$c->c_id_usuario.'_'.md5(uniqid(time())).".".$ext;		
					if(move_uploaded_file($_FILES['arquivo']['tmp_name'], $arquivo)){
						$lista = array(
							'id='=>$c->id_ficha,
							'arquivo'=>$arquivo,
							'tipo'=>$c->tipo_upload,
							'nome'=>$_FILES['arquivo']['name'],
							'id_usuario'=>$c->c_id_usuario
						);
						$this->insereAnexo($lista);
					}
					return array(0,$this->buscaDadosAdinistrativo(2,$c));
				} else {
					#$errors++;
					#$erro .= '<li>Preencha tipo de arquivo!</li>';
					#$js   .= "\tdocument.getElementById('tipo_upload').className = 'form_estilo_erro'\n";
				}
			} 
			
		} 
		
		if($errors > 0){
			$erro = '<b>Ocorreram os seguintes erros:</b><ul>'.$erro.'</ul>';
			echo "<script>\n\t"."document.getElementById('erros_exibir').innerHTML = '".$erro."';"."\n\t";
			echo "document.getElementById('erros_exibir').style.display='block'\n";
			echo "</script>\n";
			return array(1,$js);
		}
	}
	
	public function buscaDadosAdinistrativo($acao,$c){
		$this->sql = "SELECT *, num_cof AS num_cof2, origem AS origem2 FROM site_ficha_cadastro_dados_administrativos WHERE id_ficha=?";
		$this->values = array($c->id_ficha);
		$ret = $this->fetch();
		$c->valor_royaltie = strlen($c->valor_royaltie > 0) ? $c->valor_royaltie : '';
		if($acao == 2){
			$c->num_cof_emitida = $c->num_cof_emitida[0];
			if(count($ret) == 0){
				$this->insereDadosAdministrativo($c);
			} else {
				$this->editaDadosAdministrativo($c);
			}	
			$this->sql = "SELECT *, num_cof AS num_cof2, origem AS origem2 FROM site_ficha_cadastro_dados_administrativos WHERE id_ficha=?";
			$this->values = array($c->id_ficha);
			$ret = $this->fetch();
		}
		return $ret[0];
	}
	
	public function editaDadosAdministrativo($c){
		$this->sql = "UPDATE site_ficha_cadastro_dados_administrativos SET
					tipo_franquia=?, num_cof=?,	valor_cof=?, forma_pagto=?,
					origem=?, num_cof_emitida=?, valor_efetivo=?, valor_royaltie=?
					WHERE id_ficha =?";
		$this->values = array($c->tipo_franquia, $c->num_cof2, $c->valor_cof, $c->forma_pagto, $c->origem2, 
			$c->num_cof_emitida, $c->valor_efetivo, $c->valor_royaltie, $c->id_ficha);
		$this->exec();
	}
	
	public function insereDadosAdministrativo($c){
		$this->sql = "
					INSERT INTO site_ficha_cadastro_dados_administrativos 
					( tipo_franquia, num_cof, valor_cof, forma_pagto, origem, 
					num_cof_emitida, valor_efetivo, valor_royaltie, id_ficha) VALUES ( ?,?,?,?,?,?,?,?,? );";
		$this->values = array($c->tipo_franquia, $c->num_cof2, $c->valor_cof, $c->forma_pagto, $c->origem2, 
			$c->num_cof_emitida, $c->valor_efetivo, $c->valor_royaltie, $c->id_ficha);
		$this->exec();
	}
	
	public function listaRelacionamento($c, $data1, $data2){
		/*$this->sql = "SELECT h.*, u.nome AS consultor, s.status, CONCAT(DAY(h.data_reuniao),'/',MONTH(h.data_reuniao),'/',YEAR(h.data_reuniao))
			AS data_reuniao FROM site_ficha_cadastro_historico AS h, vsites_user_usuario AS u,
			site_ficha_cadastro_status AS s WHERE h.id_ficha = ? AND h.id_user_alt = u.id_usuario AND 
			h.data_reuniao != '0000-00-00' AND s.id_status = h.id_status AND h.data_reuniao >= ? AND h.data_reuniao <= ?
			ORDER BY h.data_reuniao";
		$this->values = array($c->id_ficha, $data1, $data2);*/		
		$this->sql = "SELECT h.*, u.nome AS consultor, s.status, CONCAT(DAY(h.data_reuniao),'/',MONTH(h.data_reuniao),'/',YEAR(h.data_reuniao))
			AS data_reuniao FROM site_ficha_cadastro_historico AS h, vsites_user_usuario AS u,
			site_ficha_cadastro_status AS s WHERE h.id_ficha = ? AND h.id_user_alt = u.id_usuario AND 
			h.data_reuniao != '0000-00-00' AND s.id_status = h.id_status
			ORDER BY h.data_reuniao";
		$this->values = array($c->id_ficha);
		if($c->id_administrador == 1){
			#echo $this->sql;
		}
		return $this->fetch();
	}
	
	public function relacionamento($exp_item, $c){
		$unset = array();
		for($i = 0; $i < count($exp_item->id_users); $i++){
			if(!strlen($exp_item->id_users[$i]) > 0){
				$unset[] = $i;
			}
		}
		for($i = 0; $i < count($unset); $i++){
			unset($exp_item->id_users[$unset[$i]]);
		}
		$id_users = $exp_item->id_users;
		if($c->consultor > 0){
			$id_users = array($c->consultor);
		}
		if($c->ano > 0 && (int)$c->mes > 0 && (int)$c->dia > 0){
			$c->dia = ($c->dia < 10) ? '0'.((int)$c->dia) : $c->dia;
			$c->mes = ($c->mes < 10) ? '0'.((int)$c->mes) : $c->mes;
			$WHERE = " AND DATE_FORMAT(h.data_inclusao,'%Y-%m-%d')='".$c->ano."-".$c->mes."-".$c->dia."' ";
		} else {
			if($c->ano > 0 && (int)$c->mes > 0){
				$c->mes = ($c->mes < 10) ? '0'.((int)$c->mes) : $c->mes;
				$WHERE = " AND DATE_FORMAT(h.data_inclusao,'%Y-%m')='".$c->ano."-".$c->mes."' ";
			} else {
				$WHERE = " AND DATE_FORMAT(h.data_inclusao,'%Y')='".$c->ano."' ";
			}
		}
		
$SQL = "
		SELECT h.id_user_alt AS id_consultor, (CASE WHEN u.nome IS NULL THEN 'Nenhum Consultor' ELSE u.nome END) AS consultor, 
		DAY(h.data_inclusao) AS dia, MONTH(h.data_inclusao) AS mes, YEAR(h.data_inclusao) AS ano, DATE_FORMAT(h.data_inclusao,'%d/%m/%Y') AS data,

		(SELECT COUNT(0) AS total FROM site_ficha_cadastro_historico AS h1
		WHERE h1.id_user_alt = h.id_user_alt AND DATE(h1.data_inclusao) = DATE(h.data_inclusao) AND h1.forma_pagto = 1) AS email,

		(SELECT COUNT(0) AS total FROM site_ficha_cadastro_historico AS h1
		WHERE h1.id_user_alt = h.id_user_alt AND DATE(h1.data_inclusao) = DATE(h.data_inclusao) AND h1.forma_pagto = 2) AS telefone,
		
		(SELECT COUNT(0) AS total FROM site_ficha_cadastro_historico AS h1
		WHERE h1.id_user_alt = h.id_user_alt AND DATE(h1.data_inclusao) = DATE(h.data_inclusao) AND h1.forma_pagto = 3) AS skype,
		
		(SELECT COUNT(0) AS total FROM site_ficha_cadastro_historico AS h1
		WHERE h1.id_user_alt = h.id_user_alt AND DATE(h1.data_inclusao) = DATE(h.data_inclusao) AND h1.forma_pagto = 4) AS emtel,
		
		(SELECT COUNT(0) AS total FROM site_ficha_cadastro_historico AS h1
		WHERE h1.id_user_alt = h.id_user_alt AND DATE(h1.data_inclusao) = DATE(h.data_inclusao) AND h1.forma_pagto IN (0,5)) AS outro,
		
		(SELECT COUNT(0) AS total FROM site_ficha_cadastro_historico AS h1
		WHERE h1.id_user_alt = h.id_user_alt AND DATE(h1.data_inclusao) = DATE(h.data_inclusao) AND h1.forma_pagto = 6) AS natend,
		
		(SELECT COUNT(0) AS total FROM site_ficha_cadastro_historico AS h1
		WHERE h1.id_user_alt = h.id_user_alt AND DATE(h1.data_inclusao) = DATE(h.data_inclusao) AND h1.forma_pagto = 7) AS reuniao,

		(SELECT COUNT(0) AS total FROM site_ficha_cadastro_historico AS h1
		WHERE h1.id_user_alt = h.id_user_alt AND DATE(h1.data_inclusao) = DATE(h.data_inclusao) AND h1.forma_pagto = 8) AS agendamento

		FROM site_ficha_cadastro_historico AS h 
		LEFT JOIN vsites_user_usuario AS u ON h.id_user_alt = u.id_usuario
		WHERE h.data_inclusao != '0000-00-00' AND h.id_user_alt IN (".implode(",", $id_users).") ".$WHERE."
		GROUP BY DATE(h.data_inclusao)
		ORDER BY u.nome, data_inclusao";
	
		$this->sql = $SQL;		
		return $this->fetch();
	}
	
	public function fichaCadDia($data){
		$this->sql = "SELECT COUNT(0) AS total FROM site_ficha_cadastro WHERE DATE_FORMAT(data,'%d/%m/%Y') = '".$data."'";
		return $this->fetch();
	}
	
	public function carregar_consultor_relacionamento($exp_item, $c){
		$unset = array();
		for($i = 0; $i < count($exp_item->id_users); $i++){
			if(!strlen($exp_item->id_users[$i]) > 0){
				$unset[] = $i;
			}
		}
		for($i = 0; $i < count($unset); $i++){
			unset($exp_item->id_users[$unset[$i]]);
		}
		$this->sql = "SELECT u.id_usuario, u.nome FROM vsites_user_usuario AS u
			WHERE u.id_usuario IN (".implode(",", $exp_item->id_users).") ORDER BY u.nome";
		return $this->fetch();
	}
	
	public function forma_pagto2(){
		$TEXTO = array('Agendamento','E-mail','Não Atende','Reunião','Skype','Telefone','Telefone/E-mail','Outros');
		$VALOR = array(8,1,6,7,3,2,4,5);
		return array($VALOR, $TEXTO);
	}
	
	public function imprimir_ficha($c){
		$this->sql = "SELECT c.*, s.status, DATE_FORMAT(data, '%d/%m/%Y') AS data FROM site_ficha_cadastro AS c, site_ficha_cadastro_status AS s 
			WHERE c.id_ficha = ? AND c.id_status = s.id_status";
		$this->values = array($c->id_ficha);
		$a = $this->fetch();
		
		$this->sql = "SELECT c.* FROM  site_ficha_cadastro_adicionais AS c WHERE c.id_ficha = ?";
		$b = $this->fetch();
		
		$this->sql = "SELECT c.* FROM site_ficha_cadastro_endereco2 AS c WHERE c.id_ficha = ?"; 
		$c = $this->fetch();
		
		$this->sql = "SELECT c.* FROM site_ficha_cadastro_conjuge AS c WHERE c.id_ficha = ?";
		$d = $this->fetch();
		
		$this->sql = "SELECT l2.* FROM site_ficha_rel_cadastro_lazer AS l1, site_ficha_cadastro_lazer AS l2
			WHERE l1.id_lazer = l2.id_lazer AND l1.id_ficha = ? AND l2.ativo = 1 ORDER BY l2.lazer";
		$e = $this->fetch();
		
		$this->sql = "SELECT p1.valor, p2.* FROM site_ficha_cadastro_rel_enum_pergunta AS p1, site_ficha_cadastro_enum_perguntas AS p2
		WHERE p2.ativo = 1 AND p1.id_enum_perg = p2.id_enum_perg AND p1.id_ficha = ? ORDER BY p2.ordem";
		$f = $this->fetch();
		
		$this->sql = "SELECT c.* FROM site_ficha_cadastro_referencias_bancarias AS c WHERE c.id_ficha = ?";
		$g = $this->fetch();
		
		$this->sql = "SELECT c.* FROM site_ficha_cadastro_demonstrativo_rendimento AS c WHERE c.id_ficha = ?";
		$h = $this->fetch();
		
		$this->sql = "SELECT c.* FROM site_ficha_cadastro_bens_consumo AS c WHERE c.id_ficha = ?";
		$i = $this->fetch();
		
		$this->sql = "SELECT c.* FROM site_ficha_cadastro_dados_administrativos AS c WHERE c.id_ficha = ?";
		$j = $this->fetch();
		
		return array($a, $b, $c, $d, $e, $f, $g, $h, $i, $j);
	}
	
	public function pegaRelacionamento(){
		$this->sql = "SELECT id_usuario FROM vsites_user_usuario WHERE id_empresa=1 AND departamento_p LIKE '%29%' AND status = 'Ativo'";
		$dt = $this->fetch();
		$ret = '';
		for($i = 0; $i < count($dt); $i++){
			$ret .= $dt[$i]->id_usuario;
			if($i < count($dt)-1){
				$ret .= ',';
			}
		}
		return $ret;		
	}
	
	public function pegaInteressadosDia($id, $data){
		$this->sql = "SELECT COUNT(0) AS total FROM site_ficha_cadastro_historico AS h1
			WHERE h1.id_user_alt = ? AND h1.id_status = 17 AND DATE_FORMAT(h1.data_inclusao,'%d/%m/%Y') = ?";
		$this->values = array($id, $data);
		$dt = $this->fetch();
		$total = $dt1[0]->total;
		
		$this->sql = "SELECT COUNT(0) AS total FROM site_ficha_cadastro AS h1
			WHERE h1.id_user_alt = ? AND DATE_FORMAT(h1.data_reuniao_inclusao,'%d/%m/%Y') = ? AND h1.id_status = 17";
		$dt = $this->fetch();
		$total = $total + $dt1[0]->total;
		
		return $total;
	}
	
	public function tipo_upload($acao, $id){
		$valor = array(0,4,7,3,1,2,8,5,6);
			$texto = array('','COF','Comprovante de Residência','Contrato','Cópia do CPF','Cópia do RG','Declaração do recebimento da COF',
				'Formulário de Adesão preenchido e assinado','Serasa');
		if($acao == 1){
			$busca = array_search($id, $valor);
			echo $texto[$busca];
		} else {
			return array($valor, $texto);
		}
	}

	public function relatorioDiretoria($acao, $c){
		switch($acao){
			case 1:
				$this->sql = "SELECT u.id_usuario, u.nome FROM vsites_user_usuario AS u 
					WHERE u.departamento_p LIKE '%26%' AND u.departamento_p NOT LIKE '%29%' AND u.status = 'ativo' 
					AND (u.departamento_s = '' OR ISNULL(u.departamento_s)) AND u.id_usuario NOT IN (2145,3104)
					ORDER BY u.nome";
				$this->sql = "SELECT u.id_usuario, u.nome FROM vsites_user_usuario AS u 
					WHERE u.id_empresa =1 AND u.status = 'Ativo' AND u.departamento_p = '26,' ORDER BY u.nome";
				return $this->fetch();
				break;
		
			case 2:
				$this->sql = "SELECT u.id_usuario, u.nome FROM vsites_user_usuario AS u 
					WHERE u.departamento_p LIKE '%29%' AND u.status = 'ativo' 
					AND (u.departamento_s = '' OR ISNULL(u.departamento_s)) AND u.id_usuario NOT IN (2145,3104)
					ORDER BY u.nome";
				return $this->fetch();
				break;
				
			case 3:
				$this->sql = "SELECT COUNT(0) AS total FROM site_ficha_cadastro_historico AS h 
					WHERE h.id_status = ? AND h.id_user_alt = ? AND DATE_FORMAT(h.data_inclusao,'%Y-%m-%d') = ?";
				$this->values = array($c->id_status, $c->id_usuario, date('Y-m-d'));
				$total1 = $this->fetch();
				$total1 = $total1[0]->total;
				
				$this->sql = "SELECT COUNT(0) AS total FROM site_ficha_cadastro AS c 
					WHERE c.id_status = ? AND c.id_user_alt = ? AND DATE_FORMAT(c.data_reuniao_inclusao,'%Y-%m-%d') = ?";
				$this->values = array($c->id_status, $c->id_usuario, date('Y-m-d'));
				$total2 = $this->fetch();
				$total2 = $total2[0]->total;
				return $total1 + $total2;
				#return $total1;
				break;
				
			case 4:
				$this->sql = "SELECT COUNT(0) AS total FROM site_ficha_cadastro AS c 
					WHERE DATE_FORMAT(c.data,'%Y-%m-%d') = ?";
				$this->values = array(date('Y-m-d'));
				$total = $this->fetch();				
				return $total[0]->total;
				break;
		}
	}
	
	public function listarStatus(){
		$this->sql = "SELECT s.id_status, s.status FROM site_ficha_cadastro_status AS s WHERE s.ativo = 1 ORDER BY s.status";
		return $this->fetch();
	}
	
	public function listarConversa($acao){
		if($acao == 1){
			$this->sql = "SELECT f.estado_interesse, f.cidade_interesse, h.*, (CASE WHEN u.nome IS NULL THEN 'Nenhum Consultor (Sistema)' ELSE u.nome END) AS consultor 
				FROM site_ficha_cadastro AS f, site_ficha_cadastro_historico AS h 
				LEFT JOIN vsites_user_usuario AS u ON h.id_user_alt = u.id_usuario
				WHERE DATE_FORMAT(h.data_inclusao,'%Y-%m-%d') = ? AND f.id_ficha = h.id_ficha ORDER BY h.data_inclusao";
		} else {
			$this->sql = "SELECT f.estado_interesse, f.cidade_interesse, h.*, (CASE WHEN u.nome IS NULL THEN 'Nenhum Consultor (Sistema)' ELSE u.nome END) AS consultor, h.data_reuniao_inclusao AS data_inclusao
				FROM site_ficha_cadastro AS f, site_ficha_cadastro AS h 
				LEFT JOIN vsites_user_usuario AS u ON h.id_user_alt = u.id_usuario
				WHERE DATE_FORMAT(h.data_reuniao_inclusao,'%Y-%m-%d') = ? AND f.id_ficha = h.id_ficha ORDER BY h.data_reuniao_inclusao";
		}
		$this->values = array(date('Y-m-d'));
		return $this->fetch();
	}
	
	public function PegaStatus($id_status){
		$this->sql = "SELECT s.* FROM site_ficha_cadastro_status AS s WHERE s.id_status = ?";
		$this->values = array($id_status);
		return $this->fetch();
	}
	
	public function listaHistoricoPrint($id_ficha){
		$this->sql = "SELECT h.* FROM site_ficha_cadastro_historico AS h WHERE h.id_ficha = ? ORDER BY h.data_inclusao";
		$this->values = array($id_ficha);
		return $this->fetch();
	}
	
	public function relatorio_atividade($id_ficha){
		$this->sql = "SELECT h.* FROM site_ficha_cadastro_historico AS h WHERE h.id_ficha = ? ORDER BY h.data_inclusao DESC";
		$this->values = array($id_ficha);
		return $this->fetch();
	}
	
	public function listarHistorico($id_ficha){
		$this->sql = "SELECT ch.id_ficha, DATE_FORMAT(ch.data_inclusao,'%d/%m/%Y %H:%i:%s') AS data, UPPER(st.status) AS status, 
			UPPER(u.nome) AS consultor, UPPER(ch.observacao) AS observacao 
			FROM site_ficha_cadastro_historico AS ch, vsites_user_usuario AS u, site_ficha_cadastro_status AS st
			WHERE ch.id_ficha = ? AND u.id_usuario = ch.id_user_alt AND st.id_status = ch.id_status
			ORDER BY ch.data_inclusao DESC";
		$this->values = array($id_ficha);
		return $this->fetch();
	}
	
	public function listarfichadia(){
		$this->sql = "SELECT h.id_ficha
			FROM site_ficha_cadastro_historico AS h 
			LEFT JOIN vsites_user_usuario AS u ON h.id_user_alt = u.id_usuario
			WHERE DATE_FORMAT(h.data_inclusao,'%Y-%m-%d') = ?
			GROUP BY h.id_ficha
			ORDER BY h.id_ficha";
		$this->values = array(date('Y-m-d'));
		return $this->fetch();
	}
	
	public function listarfichaiddia(){
		$this->sql = "SELECT h.*, (CASE WHEN u.nome IS NULL THEN 'NENHUM CONSULTOR (SISTEMA)' ELSE UPPER(u.nome) END) AS consultor, 
			DATE_FORMAT(h.data_reuniao_inclusao,'%d/%m/%Y %H:%i:%s') AS data, UPPER(st.status) AS status,
				UPPER(h.observacao_expansao) AS observacao
				FROM site_ficha_cadastro_status AS st, site_ficha_cadastro AS h
				LEFT JOIN vsites_user_usuario AS u ON h.id_user_alt = u.id_usuario
				WHERE DATE_FORMAT(h.data_reuniao_inclusao,'%Y-%m-%d') = ? AND st.id_status = h.id_status ORDER BY h.id_ficha";
		$this->values = array(date('Y-m-d'));
		return $this->fetch();
	}
	
} ?>
