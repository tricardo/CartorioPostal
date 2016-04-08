<?php
class RegimeDAO extends Database{
	
	
	public function listar(){
            $this->sql = 'SELECT * FROM vsites_fin_regime';
            $this->values = array();

            $cachediaCLASS = new CacheDiaCLASS();
            $filename = 'RegimeDAO-listar.csv';
            if(!$cachediaCLASS->VerificaCache($filename)){
                $ret = $this->fetch();
                $campos = "id_regime;nome;ir;pis;cofins;margem";
                $cachediaCLASS->ConvertArrayToCsv($filename,$ret,$campos);
            } else {
                $ret = $cachediaCLASS->ConvertCsvToArray($filename, array("to_object" => true));
            }
            return $ret;
	}
	
	public function buscaPorID($id){
            $this->sql = 'SELECT * FROM vsites_fin_regime as r where id_regime=? limit 1';
            $this->values = array($id);
            $ret = $this->fetch();
            return $ret[0];
	}	
	
}