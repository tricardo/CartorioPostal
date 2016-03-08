<?php
class ConselhoDAO extends Database{
	
	public function campanha($data = array()){
		$this->sql = 'SELECT c.* FROM vsites_conselho_campanha AS c WHERE c.ativo = 1 AND c.data_ini <= ? AND c.data_fim >= ?';
		$this->values = array(date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));
		$dt = $this->fetch();
		return $dt[0];
	}
	
	public function selecionar($campanha){
		$this->sql = 'SELECT c.* FROM vsites_conselho_campanha AS c WHERE c.id_campanha = ?';
		$this->values = array($campanha);
		$dt = $this->fetch();
		return $dt[0];
	}
	
	public function regiao($empresa){
		$this->sql = 'SELECT ue.* FROM vsites_user_empresa AS ue WHERE ue.id_empresa= ?';
		$this->values = array($empresa);
		$data = $this->fetch();
		
		$this->sql = 'SELECT ce.* FROM vsites_conselho_estado AS ce WHERE ce.estado = ?';
		$this->values = array($data[0]->estado);
		$data = $this->fetch();
		$data = count($data) > 0 ? $data[0]->regiao : 0;
		
		return $data;
	}
	
	public function usuario($campanha, $arr = array()){
		$regiao = 0;
		if(count($arr) > 0){
			$regiao = $this->regiao($arr['id_empresa']);
		}
		$this->sql = 'SELECT u.* FROM vsites_conselho_usuario AS u WHERE u.id_campanha = ? ';
		$this->values = array($campanha);
		if(count($arr) > 0){
			$this->sql .= ' AND u.regiao = ? ';
			$this->values[] = $regiao;
		}
		$this->sql .= 'ORDER BY u.regiao, u.nome';	
		return $this->fetch();
	}
	
	public function voto($campanha, $empresa, $usuario){
		$this->sql = 'SELECT v.* FROM vsites_conselho_voto AS v WHERE v.id_campanha = ? AND v.id_empresa = ? AND v.id_usuario = ?';
		$this->values = array($campanha, $empresa, $usuario);
		return $this->fetch();
	}
	
	public function votar($campanha, $voto, $empresa, $usuario){
		$dt = $this->voto($campanha, $empresa, $usuario);
		if(!$dt){		
			$this->sql = 'INSERT INTO vsites_conselho_voto (id_campanha, id_usuarioc, id_empresa, id_usuario, data_cada) VALUES (?,?,?,?,?)';
			$this->values = array($campanha, $voto, $empresa, $usuario, date('Y-m-d H:i:s'));
			$this->exec();
		}
	}
	
	public function apuracao($campanha){
		$dt = $this->selecionar($campanha);
		if($dt){
			$empresa_apta  = $this->unidades_aptas();
			$usuario_apto  =  $this->usuarios_aptos();
			$apurados 	   = $this->votos_apurados($dt->id_campanha);
			$usuarios      = $this->usuario($dt->id_campanha);
			$cores         = array('cc0000','ffcc00','b0bc12','ff9900','3366cc','663399','ff33cc','0066cc');
			$vt            = array();
			for($i = 0; $i < count($usuarios); $i++){
				$votos = $this->votos_apurados_user($dt->id_campanha, $usuarios[$i]->id_usuarioc);
				$vt[$i] = $votos;
				$nome = explode(' -', $usuarios[$i]->nome);
				$nome = $nome[0];
				$nomeclatura .= urlencode(utf8_encode($nome));
				$cor         .= $cores[$i];
				if($votos > 0){
					if(is_float(($votos / $apurados) * 100)){
						$votos_ap_user .= number_format(($votos / $apurados) * 100, 1, '.', '');
						$votos_ap_porc .= number_format(($votos / $apurados) * 100, 1, '.', '');
					} else {
						$votos_ap_user .= ($votos / $apurados) * 100;
						$votos_ap_porc .= ($votos / $apurados) * 100;
					}
				} else {
					$votos_ap_user .= 0;
					$votos_ap_porc .= 0;
				}
				$nomeclatura .= ($i < (count($usuarios) - 1)) ? '|' : '';
				$cor         .= ($i < (count($usuarios) - 1)) ? '|' : '';
				$votos_ap_user .= ($i < (count($usuarios) - 1)) ? ',' : '';
				$votos_ap_porc .= ($i < (count($usuarios) - 1)) ? '%|' : '%';
			}
			
			$html = '
			<html>
			<head>
			 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
			</head>
			<body style="font-family:Arial; font-size:12px;">
				<h1 style="font-size:13px">'.utf8_encode($dt->campanha).'</h1>
				<p>&nbsp;</p>'.utf8_encode($dt->texto).'<p>&nbsp;</p><p>&nbsp;</p><hr />';
			$html .= '<p><b>Número de unidades aptas à votar:</b> '.$empresa_apta.'</p>';
			$html .= '<p><b>Número de votos apurados:</b> '.$apurados.'</p>';
			
			$regiao = 0;
			$arr = array('','Norte','Nordeste','Centro-Oeste','Sudeste','Sul');
			if($apurados > 0){
				if($regiao != $usuarios[$i]->regiao){
					$html .= '<h3>'.$arr[$usuarios[$i]->regiao].'</h3>';
				}
				$html .= '<img src="http://chart.apis.google.com/chart?cht=p&chd=t:'.$votos_ap_user.'&chs=650x300&chl='.$votos_ap_porc.'&chdl='.
					$nomeclatura.'&chco='.$cor.'" /><br /><br /><br />';
				for($i = 0; $i < count($usuarios); $i++){
					$html .= '<b>'.utf8_encode($usuarios[$i]->nome).' ('.$vt[$i].')</b>';
					$html .= ' - '.$arr[$usuarios[$i]->regiao];
					$html .= '<br />';
					$dt2 = $this->votos_user($dt->id_campanha, $usuarios[$i]->id_usuarioc);
					for($j = 0; $j < count($dt2); $j++){
						# iconv("UTF-8","UTF-8//IGNORE",$string);
						$html .= ($j + 1).'º => '.$dt2[$j]->data_cada.' = '.utf8_encode($dt2[$j]->fantasia) 
							.' | ' .utf8_encode($dt2[$j]->nome);
						$html .= '<br />';
					}
					$html .= '<br /><br />';
					if($regiao != $usuarios[$i]->regiao){
						$regiao = $usuarios[$i]->regiao;
						if($i > 0){
								$html .= '<hr /><br /><br />';
						}
					}
				}
				
			}
			
			$html .= '<table style="width:100%; font-size:12px" cellpadding="2" cellspacing="2">
				<tr>
					<td style="background-color:#CAFFB1"></td>
					<td colspan="4">Acessou o sistema no dia e votou</td>
				</tr>
				<tr>
					<td style="background-color:#FFEFBD"></td>
					<td colspan="4">Acessou o sistema no dia e votou em branco</td>
				</tr>
				<tr>
					<td style="background-color:#FFB4A2"></td>
					<td colspan="4">Acessou o sistema no dia e não votou</td>
				</tr>
				<tr>
					<td style="background-color:#F8F8F8"></td>
					<td colspan="4">Não acessou o sistema no dia</td>
				</tr>
				<tr>
					<td style="background-color:#FFF"></td>
					<td colspan="4">&nbsp;</td>
				</tr>
				<tr style="background-color:#CCC">
					<td style="border:solid 1px #222; padding-left: 10px">#ID</td>
					<td style="border:solid 1px #222; padding-left: 10px">Unidade</td>
					<td style="border:solid 1px #222; padding-left: 10px">E-mail</td>
					<td style="border:solid 1px #222; padding-left: 10px">Acesso</td>
					<td style="border:solid 1px #222; padding-left: 10px">Voto</td>
				</tr>';
			
			$dt2 = $this->todas_unidades();
			for($i = 0; $i < count($dt2); $i++){
				$acesso = ''; $voto = ''; $color = '#FFF';
				$dt3 = $this->acessou_sistema($dt2[$i]->id_usuario, $dt->data_ini, $dt->data_fim);
				$dt4 = $this->quem_votou($dt->id_campanha, $dt2[$i]->id_usuario);
				
				if(count($dt3) > 0 && count($dt4) > 0){
					$acesso = $dt3->data_login;
					$voto   = (strlen($dt4->voto) > 0) ? $dt4->voto : 'Abstenção';
					$color  = (strlen($dt4->voto) > 0) ? '#CAFFB1' : '#FFEFBD';
				} elseif(count($dt3) > 0 && count($dt4) == 0){
					$acesso = $dt3->data_login;
					$voto   = 'Não';
					$color  = '#FFB4A2';
				} else {
					$acesso = 'Não';
				    $voto   = 'Não';
				    $color  = '#F8F8F8';
				}
				
				$html .= '<tr style="background-color:'.$color.'">
					<td style="border:solid 1px #222; padding-left: 10px">'.utf8_encode($dt2[$i]->id_usuario).'</td>
					<td style="border:solid 1px #222; padding-left: 10px">'.utf8_encode($dt2[$i]->fantasia).'</td>
					<td style="border:solid 1px #222; padding-left: 10px">'.utf8_encode($dt2[$i]->email).'</td>
					<td style="border:solid 1px #222; padding-left: 10px">'.$acesso.'</td>
					<td style="border:solid 1px #222; padding-left: 10px">'.$voto.'</td>
				</tr>';
			}
			
			$html .= '</table>';
			
				
			$html .= '</body></html>';
			echo $html;
		}
	}
	
	public function acessou_sistema($usuario, $data1, $data2){
		$this->sql = "SELECT l.data_login, l.ip FROM vsites_log_acesso AS l WHERE l.id_usuario = ? AND l.data_login >= ? AND l.data_login <= ?
			ORDER BY l.data_login";
		$this->values = array($usuario, $data1, $data2);
		$dt = $this->fetch();
		return $dt[0];
	}
	
	public function todas_unidades(){
		$this->sql = "SELECT e.fantasia, u.nome, u.email, u.id_usuario 
			FROM vsites_user_empresa AS e, vsites_user_usuario AS u 
			WHERE u.id_empresa = e.id_empresa AND e.status in ('Ativo', 'Renovação') AND u.email LIKE '%diretoria%'
			ORDER BY e.fantasia";#LIMIT 0, 10
		return $this->fetch();
	}
	
	public function unidades_aptas(){
		$this->sql = "SELECT COUNT(0) AS total FROM vsites_user_empresa AS e WHERE e.status in ('Ativo', 'Renovação')";
		$dt = $this->fetch();
		return $dt[0]->total;
	}
	
	public function usuarios_aptos(){
		$this->sql = "SELECT COUNT(0) AS total FROM vsites_user_usuario AS u, vsites_user_empresa AS e WHERE e.status in ('Ativo', 'Renovação') AND u.id_empresa = e.id_empresa AND u.status = 'ativo'";
		$dt = $this->fetch();
		return $dt[0]->total;
	}
	
	public function votos_apurados($campanha){
		$this->sql = "SELECT COUNT(0) AS total FROM vsites_conselho_voto AS v WHERE v.id_campanha = ?";
		$this->values = array($campanha);
		$dt = $this->fetch();
		return $dt[0]->total;
		
	}
	
	public function votos_apurados_user($campanha, $user){
		$this->sql = "SELECT COUNT(0) AS total FROM vsites_conselho_voto AS v WHERE v.id_campanha = ? AND v.id_usuarioc = ?";
		$this->values = array($campanha, $user);
		$dt = $this->fetch();
		return $dt[0]->total;
	}
	
	public function votos_user($campanha, $user){
		$this->sql = "SELECT e.fantasia, u.email AS nome, v.* FROM vsites_conselho_voto AS v, vsites_user_empresa AS e, vsites_user_usuario AS u
			WHERE v.id_campanha = ? AND v.id_usuarioc = ? AND e.id_empresa = v.id_empresa AND u.id_usuario = v.id_usuario ORDER BY v.data_cada";
		$this->values = array($campanha, $user);
		return $this->fetch();
	}
	
	public function quem_votou($campanha, $user){
		$this->sql = "SELECT e.fantasia, u.nome, v.*, 
			(SELECT CONCAT(et.fantasia, ' - ', ut.nome) FROM vsites_user_empresa AS et, vsites_user_usuario AS ut 
			WHERE ut.id_usuario = v.id_usuarioc AND ut.id_empresa = et.id_empresa) AS voto 
			FROM vsites_conselho_voto AS v, vsites_user_empresa AS e, vsites_user_usuario AS u
			WHERE v.id_campanha = ? AND v.id_usuario = ? AND e.id_empresa = v.id_empresa AND u.id_usuario = v.id_usuario ORDER BY v.data_cada";
		$this->values = array($campanha, $user);
		$dt = $this->fetch();
		return $dt[0];
	}

}
?>
