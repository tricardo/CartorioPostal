<?php

#integração com moodle

class UsuarioTesteDAO extends DatabaseSISTESTE {

    public function __construct() {
        parent::__construct();
        $this->table = 'vsites_user_empresa';
        $this->maximo = 50;
    }

    public function atualizaUsuarioTeste($p, $senha) {
		
		$this->sql = "SELECT * FROM vsites_user_empresa as ue WHERE ue.id_empresa='".$p->id_empresa."'";
        $resEmp = $this->fetch();
		
        $this->sql = "SELECT * FROM vsites_user_usuario as uu where uu.email=?";
        $this->values = array($p->email);
        $res = $this->fetch();
        
		#cria empresa
        if ($resEmp[0]->id_empresa == '') {
            $this->sql = "insert into vsites_user_empresa (id_empresa,status,empresa,fantasia,email,tel,cep,endereco,numero,bairro,cidade,estado) 
                    values ('".$p->id_empresa."','Ativo','".$p->empresa."','".$p->fantasia."','seuemail@cartoriopostal.com.br','(11) 1111-1111','00000-000', 'Rua da sua unidade', '001', 'Seu Bairro', 'Sua Cidade', 'SP')";
            $this->values = array();
            $valor = $this->exec();
        }
		#cria usuario
        if ($res[0]->id_usuario <> '') {
            $this->sql = "update vsites_user_usuario set senha=?, departamento_s=?, departamento_p=? WHERE id_usuario=?";
            $this->values = array($p->senha,$p->departamento_s,$p->departamento_p, $p->id_usuario);
            $valor = $this->exec();
        } else {
            $this->sql = "replace into 
					vsites_user_usuario (id_empresa,id_usuario,status,nome,cpf,rg,tel,cel,email,cep,endereco,numero,bairro,cidade,estado,senha,departamento_s,departamento_p)
                    values('".$p->id_empresa."','".$p->id_usuario."','Ativo','".$p->nome."','".$p->cpf."','".$p->rg."','".$p->tel."','".$p->cel."','".$p->email."','".$p->cep."','".$p->endereco."','".$p->numero."','".$p->bairro."','".$p->cidade."','".$p->estado."','".$p->senha."','".$p->departamento_s."','".$p->departamento_p."')";
					$this->values = array();
            $valor = $this->exec();
        }

        return 1;
    }
    
}

?>