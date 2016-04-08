<?php
class PacoteDAO extends Database{


	public function __construct(){
		parent::__construct();
		$this->table = 'vsites_pacotes';
	}

	/**
	 * lista todos os pacotes ativos
	 */
	public function listar(){
		$this->sql = "SELECT * from vsites_pacotes as p where status='Ativo' order by pacote";
		$this->values = array();
            $cachediaCLASS = new CacheDiaCLASS();
            $filename = 'PacoteDAO-listar.csv';
            if(!$cachediaCLASS->VerificaCache($filename)){
                $ret = $this->fetch();
		$campos = "id_pacote;pacote;status";
		$cachediaCLASS->ConvertArrayToCsv($filename,$ret,$campos);
            } else {
                $ret = $cachediaCLASS->ConvertCsvToArray($filename, array("to_object" => true));
            }
            return $ret;
	}
}

?>