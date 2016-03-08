<?php
# UNIDADES QUE ESTAO FORA DO RODIZIO
include('roylties-a-pagar.php');


class EmpresaDAO extends Database{
	
	public function listaEmpresaSiteId(){
		global $_GET;
		$this->sql = "SELECT ue.*, uu.id_usuario FROM vsites_user_empresa as ue, vsites_user_usuario as uu 
			WHERE ue.id_empresa =? AND ue.status in ('Ativo', 'Renovação') AND uu.id_empresa = ue.id_empresa AND uu.email LIKE '%diretoria%'";
		$this->values = array($_GET['id_empresa']);
		$ret = $this->fetch();
		return $ret[0];
	}	
	
	public function listaEmpresaSite($estado,$cidade,$bairro){
		if($bairro<>'') $onde = " and (replace(ue.bairro,' ','')='".$bairro."' or replace(fr.apelido,' ','')='".$bairro."')"; else
		$onde = "";
		#gambiarra
		#
		#centro-riodejaneiro-rj
		switch($cidade.'-'.$bairro){
			case 'riodejaneiro-centro':
			
				$id = 1;
				switch($cidade.'-'.$bairro){
					case 'riodejaneiro-centro': $id = 16; break;
				}
			
				$this->sql = "SELECT ue.*, fr.apelido, p.id_pais, p.pais " .
					"FROM vsites_user_empresa as ue, vsites_franquia_regiao as fr, " .
					"vsites_paises as p WHERE p.id_pais=ue.id_pais AND " .
					"fr.id_empresa=ue.id_empresa AND ue.status in ('Ativo', 'Renovação') AND ue.id_empresa=? group by ue.id_empresa " .
					"ORDER BY ue.id_empresa desc limit 1";
				$this->values = array($id);
				break;
				
			default:
				$this->sql = "SELECT ue.*, fr.apelido, p.id_pais, p.pais FROM vsites_user_empresa as ue, vsites_franquia_regiao as fr, " .
					"vsites_paises as p WHERE fr.estado=? ".$onde." AND replace(fr.cidade,' ','')=? AND p.id_pais=ue.id_pais AND " .
					"fr.id_empresa=ue.id_empresa AND ue.status in ('Ativo', 'Renovação') OR ue.id_empresa=1 group by ue.id_empresa " .
					"ORDER BY ue.id_empresa desc limit 1";
				$this->values = array($estado,$cidade);
		}
		$ret = $this->fetch();
		if($_SERVER["REMOTE_ADDR"] == '200.158.96.210'){
			#echo $this->sql;
			#echo $bairro.'-'.$cidade.'-'.$estado;
		}
		return $ret[0];
	}
        
        public function listaEmpresaAfiliado($id_afiliado){
		$this->sql = "SELECT ue.id_empresa, ue.tel, ue.email FROM vsites_user_empresa as ue, vsites_afiliado as va WHERE va.id_afiliado=? AND va.id_empresa=ue.id_empresa AND ue.status in ('Ativo', 'Renovação') ORDER BY ue.id_empresa desc limit 1";
		$this->values = array($id_afiliado);
                $ret = $this->fetch();
		return $ret[0];
	}

	public function listaEmpresa($estado,$cidade,$bairro){
                

		if($bairro<>''){
			 $onde = " and (trim(ue.bairro)='".$bairro."' or trim(fr.apelido)='".$bairro."')"; 
		} else {
			$onde = "";
		}
		if(($cidade=='Sao Paulo' or $cidade=='Campinas') and $estado=='SP' or $cidade=='Rio de Janeiro' or $cidade=='Belo Horizonte'){
			$this->sql = "SELECT ue.*, fr.apelido, p.id_pais, p.pais FROM vsites_user_empresa as ue, vsites_franquia_regiao as fr, vsites_paises as p WHERE fr.estado=? AND fr.cidade=? AND ue.status in ('Ativo', 'Renovação') ".$onde." AND p.id_pais=ue.id_pais AND fr.id_empresa=ue.id_empresa group by ue.id_empresa ORDER BY ue.id_empresa ASC";
			$this->values = array($estado,$cidade);
						
		} else {
			$this->sql = "SELECT ue.*, fr.apelido, p.id_pais, p.pais FROM vsites_user_empresa as ue, vsites_franquia_regiao as fr, vsites_paises as p WHERE trim(fr.estado)=? AND trim(fr.cidade)=? AND ue.status in ('Ativo', 'Renovação') AND p.id_pais=ue.id_pais AND fr.id_empresa=ue.id_empresa group by ue.id_empresa ORDER BY ue.id_empresa ASC";
			$this->values = array($estado,$cidade);
		}
		$ret = $this->fetch();
		if(COUNT($ret)==0){
			$this->sql = "SELECT ue.*, fr.apelido, p.id_pais, p.pais FROM vsites_user_empresa as ue, vsites_franquia_regiao as fr, vsites_paises as p WHERE fr.id_empresa=1 AND ue.status in ('Ativo', 'Renovação')  AND p.id_pais=ue.id_pais AND fr.id_empresa=ue.id_empresa group by ue.id_empresa ORDER BY ue.id_empresa ASC";
			$this->values = array();
			$ret = $this->fetch();
		}	
		
 		return $ret;
	}

	public function listaEmpresaCidade($id_empresa){
		$this->sql = "SELECT fr.* FROM vsites_franquia_regiao as fr WHERE fr.id_empresa=? group by fr.estado, fr.cidade ORDER BY fr.estado, fr.cidade";
		$this->values = array($id_empresa);
		return $this->fetch();
	}	

	public function listaEmpresas(){
		$this->sql = "SELECT ue.* FROM vsites_user_empresa as ue WHERE ue.status in ('Ativo', 'Renovação') ORDER BY ue.id_empresa";
		$this->values = array();
		return $this->fetch();
	}	
	
	/**
     * busca uma empresa pelo id
     * @param int $id_emrpesa
     */
    public function selectPorId($id_empresa) {
        $this->sql = "SELECT * FROM vsites_user_empresa as ue WHERE id_empresa = ?";
        $this->values = array($id_empresa);
        $ret = $this->fetch();
        return $ret[0];
    }
	
	public function totalUnidadesAtivas(){
		$this->sql = "SELECT count(0) as total FROM vsites_user_empresa as ue where (ue.status in ('Ativo', 'Renovação') || ue.status='Inativo') AND ue.id_empresa!=1";
		$cont = $this->fetch();
		return $cont[0]->total;
	}
	
	public function buscaempresa(){
		global $_GET;
		global $arr;
		global $_POST;
		$estado = isset($_GET['estado']) ? $_GET['estado'] : (isset($_POST['estado']) ? $_POST['estado'] : '');
		#print_r($_GET);
		$c = explode('-', $_GET['cidade']);			
		$b = $c[1];
		$c = $c[0];
	
		$sql = "SELECT uu.id_usuario, ue.* "
			. "FROM vsites_user_empresa AS ue, vsites_user_usuario AS uu WHERE uu.id_empresa = ue.id_empresa "
			. "AND uu.email LIKE '%contato%' AND ue.status in ('Ativo', 'Renovação') "
			. "AND ue.estado LIKE '%".trim(str_replace('', '', str_replace("'","",$estado)))."%'";# limit 1";
		if(count($arr) > 0){
			$sql .= " AND ue.id_empresa NOT IN (".implode(',', $arr).")";
		}
		if(!isset($_GET['estado'])){
			$sql .= " AND ue.cidade LIKE '%".$_POST['cidade']."%'";
		}
		#
		$this->sql = $sql;
		$ret = $this->fetch();
				
		#echo count($ret);
		if(count($ret) > 0){		
			if(count($ret) > 1){
				return array(0);
			}
			foreach($ret AS $valor){
				$cidade = strtolower(limpa_url(str_replace(' ','', $valor->cidade)));	
				#echo $c.'-'.$cidade.'<br>';	
				#print_r($valor).'<br><br>';
				if(isset($_GET['estado'])){
					if($c == $cidade){
						if(substr_count(strtolower($valor->fantasia),"- lj") > 0){
							$f = strtolower(limpa_url(str_replace(' ','', $valor->bairro)));
							#echo $f.'='.$b.'<br>';
							if($f == $b){
								return array(1, $valor->id_empresa, $valor->id_usuario);
							}
						} else {
							$f = explode('-', $valor->fantasia);
							$f = strtolower(limpa_url(str_replace(' ','', $f[0])));
							#echo $f.'='.$b.'<br>';
							if($f == $b){
								return array(1, $valor->id_empresa, $valor->id_usuario);
							}
						}
					}
				} else {
					return array(1, $valor->id_empresa, $valor->id_usuario);
				}
			}
			return array(0);
		}
		return array(0);
	}
	public function buscaempresa2(){
		global $_GET;
		global $arr;
		#print_r($_GET);
		$c = explode('-', $_GET['cidade']);	
		$b = $c[1];
		$c = $c[0];
		
		if(!is_numeric($_GET['id_empresa'])){
			$_GET['id_empresa'] = 1;
		} elseif($_GET['id_empresa'] == 0){
			$_GET['id_empresa'] = 1;
		}
	
		$sql = "SELECT uu.id_usuario, ue.* "
			. "FROM vsites_user_empresa AS ue, vsites_user_usuario AS uu WHERE uu.id_empresa = ue.id_empresa "
			. "AND uu.email LIKE '%contato%' AND ue.status in ('Ativo', 'Renovação') "
			#. "AND ue.estado = '".trim(str_replace('', '', str_replace("'","",$_GET['estado'])))."'";# limit 1";
			. "AND ue.id_empresa = ".$_GET['id_empresa'];# limit 1";
		if(count($arr) > 0){
			$sql .= " AND ue.id_empresa NOT IN (".implode(',', $arr).")";
		}
		#. "AND ue.fantasia LIKE '%".$cidade."%'";
		#echo $sql;
		$this->sql = $sql;
		$ret = $this->fetch();
		if(count($ret) > 0){
			return array(1, $ret->id_empresa, $valor->id_usuario);
		}
		return array(0);
	}
}

?>
