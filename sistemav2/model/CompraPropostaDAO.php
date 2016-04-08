<?php
class CompraPropostaDAO extends Database{

	public function inserir($p){
		$this->table = 'vsites_fin_compra_proposta';
		$this->fields = array(
			'id_compra',
			'id_fornecedor',
			'valor',
			'data',
			'arquivo'
			);
			$this->values = array(
			'id_compra'=>$p->id_compra,
			'id_fornecedor'=>$p->id_fornecedor,
			'valor'=>$p->valor,
			'data'=>date('Y-m-d H:i:s'),
			'arquivo'=>$p->arquivo
			);

			$this->insert();
	}

	public function buscaPorIdCompra($id_compra){
		$this->sql = "SELECT p.*, f.razao as fornecedor FROM vsites_fin_compra_proposta p
		INNER JOIN vsites_fornecedor f ON p.id_fornecedor = f.id_fornecedor 
		WHERE p.id_compra = ? ORDER BY p.id_proposta";
		$this->values = array($id_compra);
		return $this->fetch();
	}
	
	public function aprova($p){
		$this->sql = "UPDATE vsites_fin_compra_proposta SET aprovada=? WHERE id_proposta=? ";
		$this->values = array($p->aprovada,$p->id_proposta);
		$this->exec();
		if($p->aprovada==1){
			echo "CONCLUIDA\n";
			$compraDAO = new CompraDAO();
			$compraDAO->atualizaStatus($p,'Concluída',$id_empresa);
		}
		$this->exec();
	}
	
	
}