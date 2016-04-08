<?php

#integração com moodle

class EadDAO extends DatabaseEAD {

    public function __construct() {
        parent::__construct();
        $this->table = 'mdl_user';
        $this->maximo = 50;
    }

    public function atualizaEad($p, $senha) {
		$controle_teste = $_SESSION['controle_teste'];
		global $controle_teste;
		if( $_SESSION['controle_teste']!='')return 1;
        $this->sql = "SELECT id
					FROM mdl_user user
					WHERE username=?";
        $this->values = array($p->email);
        $res = $this->fetch();
        #criptografa a senha com a chave do arquivo config.php do EAD

        $senhaead = MD5($senha .'20n@]9Rsoftfox.com.br`y>AIoDIE3T');
        if ($p->status == 'Ativo' and ($p->statusEmp == 'Ativo' or $p->statusEmp == 'Inativo'))
            $suspended = 0; 
        else
            $suspended = 1;

        $nome1=explode(' ',$p->nome);
        if($nome1[0]=='Administrador')$nome1[0]='Admin';
        if($nome1[1]=='')$nome1[1]='Cartório';
        
        if ($res[0]->id <> '') {
            $this->sql = "update mdl_user set password=?, suspended=?, username=?, firstname=?,lastname=?, city=? WHERE id=?";
            $this->values = array($senhaead, $suspended, $p->email, $nome1[0], $nome1[1], $p->bairro . '-' . $p->cidade . '-' . $p->estado, $res[0]->id);
            $valor = $this->exec();
        } else {
            $this->sql = "insert into mdl_user (timemodified,firstaccess,timecreated,confirmed,ajax,mnethostid,password,suspended,username,firstname,lastname, email, city,country,lang,timezone,descriptionformat,mailformat, maildisplay,htmleditor,autosubscribe,trackforums) 
                    values ('1342642560','1342642560','1342642560','1','0','1','".$senhaead."', '".$suspended."', '".$p->email."', '".$nome1[0]."', '".$nome1[1]."', '".$p->email."', '".$p->bairro . '-' . $p->cidade . '-' . $p->estado."','BR','pt_br','99','1','1','2','1','1','1')";
            $this->values = array();
            $valor = $this->exec();
        }

        return $valor;
    }

    public function atualizaStatusEAD($p) {
        $this->sql = "SELECT id
					FROM mdl_user user
					WHERE username=?";
        $this->values = array($p->email);
        $res = $this->fetch();
        #criptografa a senha com a chave do arquivo config.php do EAD

        if ($p->status == 'Ativo' and ($p->statusEmp == 'Ativo' or $p->statusEmp == 'Inativo'))
            $suspended = 0; 
        else
            $suspended = 1;

        $nome1=explode(' ',$p->nome);
        if($nome1[0]=='Administrador')$nome1[0]='Admin';
        if($nome1[1]=='')$nome1[1]='Cartório';
        
        if ($res[0]->id <> '') {
            $this->sql = "update mdl_user set suspended=?, username=?, firstname=?,lastname=?, city=? WHERE id=?";
            $this->values = array($suspended, $p->email, $nome1[0], $nome1[1], $p->bairro . '-' . $p->cidade . '-' . $p->estado, $res[0]->id);
            $valor = $this->exec();
        } else {
            $valor='';
        }
        return $valor;
    }
    
}

?>