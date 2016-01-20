<?php

function simple_curl($url,$post=array(),$get=array()){
		$url = explode('?',$url,2);
		if(count($url)===2){
			$temp_get = array();
			parse_str($url[1],$temp_get);
			$get = array_merge($get,$temp_get);
		}

		$ch = curl_init($url[0]."?".http_build_query($get));
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query($post));
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		return curl_exec ($ch);
	}
	
class TesteDAO extends Database{
		
	public function faixa_cep($estado){
		global $_GET;
		$html = simple_curl('http://m.correios.com.br/movel/buscaCepConfirma.do',array(
			'cepEntrada'=>$_GET['cep'],
			'tipoCep'=>'',
			'cepTemp'=>'',
			'metodo'=>'buscarCep'
		));
		
		$html = simple_curl('http://www.buscacep.correios.com.br/servicos/dnec/menuAction.do', array(
			/*'UF'=>'SP',
			'Localidade'=>'São Paulo',
			'cfm'=>1,
			'metodo'=>'listaFaixaCep',
			'TipoConsulta'=>'faixaCep',
			'StartRow'=>1,
			'EndRow'=>10*/
			'ufEntrada'=> $_GET['estado'],
			'cidadeEntrada'=>$_GET['cidade'],
			'tipoCep'=>'',
			'cepTemp'=>'',
			'metodo'=>'listaFaixaCep'
		));
	
		phpQuery::newDocumentHTML($html, $charset = 'utf-8');
		
		$dados = 
		array(
			'logradouro'=> trim(pq('.caixacampobranco .resposta:contains("Logradouro: ") + .respostadestaque:eq(0)')->html()),
			'bairro'=> trim(pq('.caixacampobranco .resposta:contains("Bairro: ") + .respostadestaque:eq(0)')->html()),
			'cidade/uf'=> trim(pq('.caixacampobranco .resposta:contains("Localidade / UF: ") + .respostadestaque:eq(0)')->html()),
			'cep'=> trim(pq('.caixacampobranco .resposta:contains("CEP: ") + .respostadestaque:eq(0)')->html())
		);

		$dados['cidade/uf'] = explode('/',$dados['cidade/uf']);
		$dados['cidade'] = trim($dados['cidade/uf'][0]);
		$dados['uf'] = trim($dados['cidade/uf'][1]);
		unset($dados['cidade/uf']);

		die(json_encode($dados));
		
		#$this->estado($estado);
	}
	
	public function menu_faixa_cep($uf, $localidade){
		$html = simple_curl('http://www.buscacep.correios.com.br/servicos/dnec/menuAction.do', array(
			'UF'=>$uf,
			'Localidade'=>$localidade,
			'cfm'=>1,
			'Metodo'=>'listaFaixaCep',
			'TipoConsulta'=>'faixaCep',
			'StartRow'=>1,
			'EndRow'=>10
		));
	}
	
	public function estado($estado){
		if(strlen($estado) > 0){
			$this->sql = 'SELECT c.cidade FROM cep_logr AS c WHERE c.estado = ? GROUP BY c.cidade ORDER BY c.cidade';
			$this->values = array($estado);
			$dt = $this->fetch();
			echo '<table>';
			for($i = 0; $i < count($dt); $i++){
				echo '<tr>';
				echo '<td>'.$this->busca_cep_cidade($dt[$i]->cidade, $estado).'</td>';
				echo '<td>'.$this->busca_cep_cidade($dt[$i]->cidade, $estado, 'desc').'</td>';
				echo '<td>'.utf8_encode($dt[$i]->cidade).'</td>';
				echo '</tr>';
			}
			echo '</table>';
		}
	}
	
	public function busca_cep_cidade($cidade, $estado, $order = 'asc'){
		$this->sql = 'SELECT c.cep FROM cep_logr AS c WHERE c.estado = ? AND c.cidade = ? ORDER BY c.cep '.$order.' Limit 0, 1';
		$this->values = array($estado, $cidade);
		$dt = $this->fetch();
		return $dt[0]->cep;
	}
	
	function simple_curl($url,$post=array(),$get=array()){
		$url = explode('?',$url,2);
		if(count($url)===2){
			$temp_get = array();
			parse_str($url[1],$temp_get);
			$get = array_merge($get,$temp_get);
		}
		$ch = curl_init($url[0]."?".http_build_query($get));
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query($post));
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		return curl_exec ($ch);
	}
	
	function royaltie_mensal($dt){
			$this->sql = "SELECT r.*,e.fantasia as empresa, rr.valor_propaganda as fpp, 
			rr.valor_royalties as roy, cf.id_conta_fatura, cf.valor, cf.valor_pago FROM vsites_relatorios r 
			INNER JOIN vsites_user_empresa e ON e.id_empresa=r.id_empresa LEFT JOIN vsites_rel_royalties as rr on 
			rr.id_empresa=e.id_empresa and date_format(rr.data,'%Y-%m')='".$dt."' LEFT JOIN vsites_conta_fatura as 
			cf on cf.id_empresa_franquia=e.id_empresa and cf.id_relatorio=r.id_relatorio WHERE r.data_relatorio LIKE '".$dt."%' 
			AND r.descricao = 'royalties' group by r.id_empresa ORDER BY e.fantasia ASC";
			#echo $this->sql;
			return $this->fetch();
	}
	
	function royaltie_inativa($id = 0, $ano = 2014){
		$this->sql = "SELECT rr.id_rel_royalties, date_format(rr.data,'%m/%Y') as ref, ue.id_empresa, 
		ue.fantasia as fantasia, rr.valor_propaganda as fpp, valor_royalties as roy, rr.roy_rec, rr.fpp_rec 
			FROM vsites_user_empresa ue INNER JOIN vsites_rel_royalties as rr on rr.id_empresa=ue.id_empresa 
			WHERE rr.id_empresa!=1 and date_format(rr.data,'%Y')='".$ano."' and rr.id_empresa = ".$id." 
			and rr.valor_royalties+rr.valor_propaganda>rr.roy_rec+rr.fpp_rec and (rr.valor_propaganda>0 or rr.valor_royalties>0) 
			ORDER BY ue.fantasia, date_format(rr.data,'%m/%Y')";
		return $this->fetch();
	}
}
?>
