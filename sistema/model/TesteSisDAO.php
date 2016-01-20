<?php class TesteSisDAO extends Database {
	
	public function empresa($id){
			$this->sql = "SELECT empresa, fantasia FROM vsites_user_empresa WHERE id_empresa = ?";
			$this->values = array($id);
			return $this->fetch();
	}

	public function selectEmpresaCEP($cep,$pais='Brazil'){
	
		if($pais=='Brazil'){
			#verifica direcionamento e rodizio exceto são paulo
			$this->sql = "SELECT ue.id_empresa, uu.id_usuario from 
				vsites_user_empresa as ue, vsites_user_usuario as uu, vsites_franquia_regiao as fr where 
					replace(fr.cep_i,'-','') <= replace('".$cep."','-','') and replace(fr.cep_f,'-','') >= replace('".$cep."','-','') and 
					fr.cep_i!='00000-000' and fr.cep_i!='' and 
					fr.cdt_site=0 and
					fr.id_empresa=ue.id_empresa and ue.status='Ativo' and 
					ue.id_empresa = uu.id_empresa and uu.departamento_s like '6,%' limit 1";
			$ret = $this->fetch();
			print_r($ret);
			echo '1 - Verificar direcionamento e rodizio exceto São Paulo<br />';
			if(count($ret) > 0){
				$data = $this->empresa($ret[0]->id_empresa);
				echo 'Encontrei a unidade ' . $data[0]->fantasia.'.';
			} else {
				echo 'Não encontrei.';
			}			
			echo '<p>&nbsp;</p>';
			
			#caso não encontre empresa para direcionar, zera o rodizio exceto são paulo
			if($ret[0]->id_empresa=='' and $cep!='00000-000' and $cep!=''){
				echo '2 - Se chegou aqui, foi porque não encontrou direcionamento fora de São Paulo e agora busca dentro.';
				
				$this->sql = "SELECT ue.id_empresa, uu.id_usuario from 
					vsites_user_empresa as ue, vsites_user_usuario as uu, vsites_franquia_regiao as fr where 
						replace(fr.cep_i,'-','') <= replace('".$cep."','-','') and replace(fr.cep_f,'-','') >= replace('".$cep."','-','') and 
						fr.cep_i!='00000-000' and fr.cep_i!='' and 
						fr.cdt_site=0 and
						fr.id_empresa=ue.id_empresa and ue.status='Ativo' and 
						ue.id_empresa = uu.id_empresa and uu.departamento_s like '6,%' limit 1";
				$ret = $this->fetch();
				print_r($ret);
				if(count($ret) > 0){
					$data = $this->empresa($ret[0]->id_empresa);
					echo 'Encontrei a unidade ' . $data[0]->fantasia.'.';
				} else {
					echo 'Não encontrei.';
				}
			}
			
			#if  encontrar a empresa adiciona o CDT, caso não atribui para a franqueadora
			if($ret[0]->id_empresa<>''){
				print_r($ret);
			} else {
				$ret[0]->id_empresa=1;
				$ret[0]->id_usuario=1;
				echo 'Se chegou aqui foi porque não encontrou nenhuma unidade para ser direcionada, assim, será direcionado para a franqueadroa.';
			}
		} else{
			$pais = strtolower($pais);
			switch($pais){
				case 'England':
					$id_empresa=1;
					break;
				case 'Belgium':
					$id_empresa=274;
					break;
				case 'United Kingdom':
					$id_empresa=288;
					break;	
				default:
					$id_empresa=1;
					
			}
			$this->sql = "SELECT ue.id_empresa, uu.id_usuario from 
				vsites_user_empresa as ue, vsites_user_usuario as uu, vsites_franquia_regiao as fr where 
					ue.id_empresa='".$id_empresa."' and
					fr.id_empresa=ue.id_empresa and ue.status='Ativo' and 
					ue.id_empresa = uu.id_empresa and uu.departamento_s like '6,%' limit 1";
			$ret = $this->fetch();		
			print_r($ret);echo ' => 5<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>';	
		}
		#return $ret[0];
	}
	
	
}
