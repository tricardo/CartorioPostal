<?php

class SafDAO extends Database {
    
    public function RedeEstado(){
        $this->sql = "SELECT DISTINCT estado FROM  vsites_cidades as C ORDER BY estado";
        return $this->fetch();
    }
    
    public function Skype($c){
        $campos = 'SELECT 
            ue.fantasia, ue.nome AS nome1, ue.email AS email1, ue.skype AS skype1, 
            uu.nome AS nome2, uu.email AS email2, uu.skype AS skype2 ';
        $sql = " FROM vsites_user_empresa AS ue, vsites_user_usuario AS uu
            WHERE (ue.skype != '' OR uu.skype != '') AND ue.id_empresa = uu.id_empresa AND ue.status = 'Ativo' AND uu.status = 'Ativo'";
        $group = " GROUP BY ue.skype, uu.skype";
        $order = " ORDER BY ue.id_empresa";
        $this->values = array();
        if(isset($c->busca) AND strlen($c->busca) > 0){
            $sql .= " and (ue.fantasia like ? or ue.nome like ? or ue.email like ? or ue.skype like ?
                    or uu.nome like ? or uu.email like ? or uu.skype like ?)";
            $this->values[] = $c->busca."%";
            $this->values[] = $c->busca."%";
            $this->values[] = $c->busca."%";
            $this->values[] = $c->busca."%";
            $this->values[] = $c->busca."%";
            $this->values[] = $c->busca."%";
            $this->values[] = $c->busca."%";
            $this->link .= 'busca='.$c->busca;
        }  
        $this->link   = '';
        
        
        $this->sql = "SELECT count(0) as total ".$sql.$group;
        $cont = $this->fetch();
        $this->pagina = ($c->pagina==NULL)?1:$c->pagina;
	$this->total = count($cont);
       
        
        $this->sql = $campos.$sql.$group.$order." LIMIT ".$this->getInicio().", ".$this->maximo;
        
        return $this->fetch();
    }
    
    public function Comunicados($c){
        $campos = "SELECT m.id_maladireta, m.assunto, m.texto, date_format(m.data, '%d/%m/%y %H:%m') as data ";
        $sql = " FROM saf_maladireta as m WHERE m.id_empresa='0' and m.status=1 ";
        $order = 'ORDER BY m.id_maladireta DESC';
        $this->values = array();
        $this->link   = '';
        if(isset($c->busca) AND strlen($c->busca) > 0){
            $sql .= " and m.id_maladireta like ? or m.assunto like ? or m.texto like ? ";
            $this->values[] = "%".$c->busca."%";
            $this->values[] = "%".$c->busca."%";
            $this->values[] = "%".$c->busca."%";
            $this->link .= 'busca='.$c->busca;
        }        
        
        $this->sql = "SELECT count(0) as total ".$sql;
        $cont = $this->fetch();
        $this->pagina = ($c->pagina==NULL)?1:$c->pagina;
	$this->total = $cont[0]->total;
       
        
        $this->sql = $campos.$sql.$order." LIMIT ".$this->getInicio().", ".$this->maximo;
        
        return $this->fetch();
    }
    
    public function excluirDownload($c){
        $this->sql = "DELETE FROM saf_ftp WHERE id_upload = ?";
        $this->values = array($c->id_download);
        $this->exec();
    }
    
    public function selectDownload($c){
        $this->sql = "SELECT * FROM saf_ftp WHERE id_upload = ?";
        $this->values = array($c->id_download);
        $ret = $this->fetch();
        return count($ret) > 0 ? $ret[0] : FALSE;
    }
    
    public function inserirDonwload($c){
        global $controle_id_usuario;
        $this->sql = "INSERT INTO saf_ftp (id_usuario, id_empresa, id_ftp_categoria, arquivo, "
                . "titulo, extensao, data) values (?,?,?,?,?,?,NOW())";
        $this->values = array($controle_id_usuario, $c->id_empresa, $c->id_categoria, $c->arquivo,
            $c->titulo, $c->extensao);
        $this->exec();
    }
    
    public function Downloads($c){
        global $controle_id_empresa;
        $campos = "SELECT fc.ftp_categoria, f.id_usuario, f.arquivo, f.id_upload, f.id_empresa, 
            f.id_ftp_categoria, f.titulo, f.extensao, date_format(data, '%d/%m/%y') as data";
        $sql = " FROM saf_ftp as f LEFT JOIN saf_ftp_categoria AS fc ON f.id_ftp_categoria=fc.id_ftp_categoria "
                . "WHERE 1=1 ";
        $sql .= strlen($c->titulo) > 0 ? " AND f.titulo LIKE '%".$c->titulo."%'" : '';
        $sql .= strlen($c->id_categoria) > 0 ? " AND f.id_ftp_categoria = ".$c->id_categoria."" : '';
        $sql .= (strlen($c->id_empresa) > 0 AND $controle_id_empresa == 1) ? " AND f.id_empresa = ".$c->id_empresa."" : '';
        $sql .= $controle_id_empresa != 1 ? ' AND (f.id_empresa = '.$controle_id_empresa.' OR f.id_empresa=0)' : '';
        $order = " ORDER BY date_format(data, '%y-%m-%d') DESC";
        
        $this->link   = '';
        $this->sql = "SELECT count(0) as total ".$sql;
        $cont = $this->fetch();
        $this->pagina = ($c->pagina==NULL)?1:$c->pagina;
	$this->total = $cont[0]->total;
       
        
        $this->sql = $campos.$sql.$order." LIMIT ".$this->getInicio().", ".$this->maximo;
        
        return $this->fetch();
    }
    
    public function CategoriaFTP(){
        $this->sql = "SELECT * FROM  saf_ftp_categoria as fc ORDER BY ftp_categoria";
        
        $cachediaCLASS = new CacheDiaCLASS();
        $filename = 'SafDAO-CategoriaFTP.csv';
        if(!$cachediaCLASS->VerificaCache($filename)){
            $ret = $this->fetch();
            $campos = "id_ftp_categoria;ftp_categoria;ftp_status";
            $cachediaCLASS->ConvertArrayToCsv($filename,$ret,$campos);
        } else {
            $ret = $cachediaCLASS->ConvertCsvToArray($filename, array("to_object" => true));
        }
        return $ret;
        
        
    }
    
    public function ListUserDepto($c){
        $c->depto      = isset($c->depto) ? $c->depto : '';
        $c->id_empresa = isset($c->id_empresa) ? $c->id_empresa : 0;
        $this->sql = "SELECT uu.email, uu.nome, LENGTH(uu.email) FROM vsites_user_usuario as uu, vsites_user_empresa as ue WHERE 
                            (ue.status='Ativo' OR ue.status='Inativo') AND 
                            ue.id_empresa=uu.id_empresa AND
                            uu.status='Ativo'  AND uu.email LIKE '%diretoria%' AND
                            uu.id_empresa!=1 ";
        if($c->depto != ''){
            $this->sql .= "AND (";
            for($i = 0; $i < count($c->depto); $i++){
                $this->sql .= "uu.departamento_p like '%,".$c->depto[$i].",%'";
                $this->sql .= ($i < count($c->depto) - 1) ? ' OR ' : '';
            }
            $this->sql .= ") ";
        }
        if($c->id_empresa > 0){
            $this->sql .= " AND uu.id_empresa = ".$c->id_empresa;
        }
        return $this->fetch();
    }
    
    public function inserirMalaDireta($c){
        $c->id_empresa = isset($c->id_empresa) ? $c->id_empresa : 0;
        $c->depto      = isset($c->depto) ? implode(',', $c->depto) : '';
        $this->sql = "INSERT INTO saf_maladireta(data,status,id_news,id_empresa,departamento, 
            assunto, texto, id_usuario) values(NOW(),1,0,?,?,?,?,?)";
        $this->values = array($c->id_empresa,$c->depto,$c->assunto,$c->texto,$c->id_usuario);
        $this->exec();
        
        $this->sql = "SELECT id_maladireta FROM saf_maladireta ORDER BY id_maladireta DESC";
        $ret = $this->fetch();
        return $ret[0]->id_maladireta;
    }
    
    public function ListDepartamentos(){
        $this->sql = "SELECT * FROM vsites_departamento WHERE id_departamento!='1' ORDER BY departamento";
        $cachediaCLASS = new CacheDiaCLASS();
        $filename = 'SafDAO-ListDepartamentos.csv';
        if(!$cachediaCLASS->VerificaCache($filename)){
            $ret = $this->fetch();
            $campos = "id_departamento;departamento";
            $cachediaCLASS->ConvertArrayToCsv($filename,$ret,$campos);
        } else {
            $ret = $cachediaCLASS->ConvertCsvToArray($filename, array("to_object" => true));
        }
        return $ret;
    }
    
    public function ComunicadoId($id_comunicado){
        $this->sql = "SELECT *,m.id_maladireta, m.assunto, m.texto, date_format(m.data, '%d/%m/%y %h:%m:%s') as data
            FROM saf_maladireta as m WHERE m.id_maladireta=?";
        $this->values = array($id_comunicado);
        return $this->fetch();
    }
        
    public function RedeFranqueados($c){
        $campos = "SELECT ue. skype, fr.apelido, b.id_banco, b.banco, ue.id_banco, ue.agencia, ue.conta, "
                . "ue.favorecido, ue.cpf, ue.nome, fr.cidade as cidade_f, fr.estado as estado_f, ue.fantasia, "
                . "ue.empresa, ue.fantasia, ue.endereco, ue.numero, ue.complemento, ue.cidade, ue.estado, "
                . "ue.bairro, ue.cep, ue.status, ue.id_empresa, date_format(ue.data, '%d/%m/%y') as data, "
                . "ue.tel, ue.email ";
        $sql = " FROM vsites_user_empresa as ue LEFT JOIN vsites_banco as b ON b.id_banco=ue.id_banco, "
                . "vsites_franquia_regiao as fr WHERE fr.id_empresa=ue.id_empresa and ue.status='Ativo' ";
        $this->values = array();
        $this->link   = '';
        if(isset($c->busca) AND strlen($c->busca) > 0){
            $sql .= "and (fr.cidade like ? or ue.bairro like ? or fr.apelido like ?)";
            $this->values[] = $c->busca."%";
            $this->values[] = $c->busca."%";
            $this->values[] = $c->busca."%";
            $this->link .= 'busca='.$c->busca;
        }        
        if(isset($c->estado) AND strlen($c->estado) > 0){
            $sql .= " and fr.estado= ?";
            $this->values[] = $c->estado;
            $this->link .= 'estado='.$c->estado;
        }
        $group = " group by fr.cidade, fr.estado, fr.id_empresa, ue.bairro ORDER BY fr.cidade, fr.estado ASC";
        
        $this->sql = "SELECT count(0) as total ".$sql;
        $cont = $this->fetch();
	$this->total = $cont[0]->total;
        
        $this->pagina = ($c->pagina==NULL)?1:$c->pagina;
        
        $this->sql = $campos.$sql.$group." LIMIT ".$this->getInicio().", ".$this->maximo;
        
        return $this->fetch();
        
    }
    
    
}