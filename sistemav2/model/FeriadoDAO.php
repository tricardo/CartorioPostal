<?php
class FeriadoDAO extends Database{
    
    public function DiasUteis($str_data,$str_data_final){
        $this->sql = "select fer.id_feriado from vsites_feriados as fer where fer.data>='" . $str_data . "' "
                . "and fer.data<='" . $str_data_final . "' and (fer.id_empresa='0' or fer.id_empresa='1')";
        return $this->fetch();
    }
    
    
    
}