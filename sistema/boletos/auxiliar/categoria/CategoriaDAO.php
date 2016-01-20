<?php

class CategoriaDAO extends Database {
/**
 * Lista todas as categorias com sua hierarquia
 * @return Categoria[]
 */
    public function listar() {
        $this->sql = "SELECT * FROM categoria WHERE idSupCategoria is null AND ativo=1";
        $categorias = $this->fetch("Categoria");
        foreach($categorias as $categoria) {
            $categoria->subCategorias = $this->listarSubCategorias($categoria->id);
        }

        return $categorias;
    }

    public function listaSupCategorias() {
        $this->sql = "SELECT * FROM categoria WHERE idSupCategoria is null AND ativo=1";
        return $this->fetch("Categoria");
    }

    public function listarSubCategorias($id) {
        $this->sql = "SELECT * FROM categoria WHERE idSupCategoria = ? AND ativo=1";
        $this->values = array($id);
        return $this->fetch("Categoria");
    }

    public function inserir(Categoria $categoria) {
        $this->valida($categoria);
        $this->sql = 'INSERT INTO categoria (nome ';
        if($categoria->idSupCategoria!="") {
            $this->sql.=', idSupCategoria ';
        }
        $this->sql.=', ativo ';
        $this->sql.=') VALUES (?';
        $this->values=array($categoria->nome);
        if($categoria->idSupCategoria!="") {
            $this->sql.=', ?';
            $this->values[]=$categoria->idSupCategoria;
        }
        $this->sql.=',1)';
        $this->exec();
        return $this->getLastInsertId();
    }

    public function atualizar(Categoria $categoria) {
        $this->sql = "UPDATE categoria SET nome = ? ";
        $this->values = array($categoria->nome);
        if($categoria->idSupCategoria!="") {
            $this->sql.=', idSupCategoria=? ';
            $this->values[]=$categoria->idSupCategoria;
        }
        $this->sql.=' WHERE id = ?';
        $this->values[]=$categoria->id;

        return $this->exec();
    }

    public function selectById($id) {
        $this->sql = "SELECT * FROM categoria WHERE id = ?";
        $this->values = array($id);
        $cat = $this->fetch("Categoria");
        return $cat[0];
    }

    public function desativar(Categoria $categoria) {
        $this->values = array();
        $this->sql = "UPDATE categoria SET ativo = 0 ";
        $this->sql.=' WHERE id = ?';
        $this->values[]=$categoria->id;
        $this->exec();
    }

    private function valida(Categoria $categoria) {
        $this->sql = 'SELECT * FROM categoria WHERE nome = ? AND idSupCategoria = ? ';
        $this->values = array($categoria->nome,$categoria->idSupCategoria);
        $cat = $this->fetch('Categoria');
        if(sizeof($cat)>=1) throw new ExceptionList('Categoria já foi cadastrada');
    }
}
?>
