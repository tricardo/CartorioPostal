<?php
class CepDAO extends Database{

    public function __construct(){
        parent::__construct();
        $this->table = 'cep';
        $this->maximo=50;
    }
    
    public function listar($arr){
        if(isset($arr['cep']) AND strlen($arr['cep']) == 8 AND $arr['cep'] != '00000000'){
            $this->sql = "SELECT *, CONCAT(logr_tipo,' ',logr_subnome) AS logr_nome "
                    . "FROM cep WHERE logr_cep = ? ORDER BY RAND()";
            $this->values = array($arr['cep']);
            return $this->fetch();
        }
    }
    
    public function ufs(){
        $cachediaCLASS = new CacheDiaCLASS();
        $filename = 'CEPDAO-UFS.csv';
        if(!$cachediaCLASS->VerificaCache($filename)){
            $this->sql = "SELECT estado_sigla FROM cep GROUP BY estado_sigla "
                    . "ORDER BY estado_sigla";
            $this->values = array();
            $ret = $this->fetch();
            $campos = "estado_sigla";
            $cachediaCLASS->ConvertArrayToCsv($filename,$ret,$campos);
        } else {
            $ret = $cachediaCLASS->ConvertCsvToArray($filename, array("to_object" => true));
        }
        return $ret;
    }
    
    public function log_import($c){
        $this->sql = "SELECT COUNT(*) AS total from cep where 1 = 1";
        $this->values = array();
        if(isset($c->cidade)){
            $this->sql .= " AND cidade_nome LIKE ?";
            $this->values[] = $c->cidade.'%';
        }
        if(isset($c->estado)){
            $this->sql .= " AND (estado_nome LIKE ? OR estado_sigla LIKE ?)";
            $this->values[] = $c->estado.'%';
            $this->values[] = $c->estado.'%';
        }
        return $this->fetch();
    }
        
}
