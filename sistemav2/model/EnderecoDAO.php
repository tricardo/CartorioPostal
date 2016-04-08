<?php
class EnderecoDAO extends Database{
	
	public function buscaPorCep($cep){
		$this->sql = 'SELECT endereco, bairro,cidade,estado from cep_logr where cep=? limit 1';
		$this->values = array($cep);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	public function buscaPorEndereco($cidade){
		$this->sql = 'SELECT f.*, e.empresa, e.fantasia
			FROM vsites_franquia_regiao AS f
			INNER JOIN vsites_user_empresa AS e ON f.id_empresa = e.id_empresa
			WHERE f.cidade = ?';
		$this->values = array($cidade);
		$ret = $this->fetch();
		return $ret[0];
	}
	
}