<?php
require_once('PDOSingleton.php');

/**
 * classe de acesso ao banco de dados
 * nenhma requisição ao BD deve ser executada fora dessa classe
 * controla a conexão com o banco, através da classe PDOSingleton, criando apenas uma conexão
 *
 * @author Caio M Nardi
 * @since 01/03/2008
 */
class Database {

	protected $table;
	protected $fields;
	protected $values;
	protected $sql;
	private $con;
	private $sth;
	private $dbType="mysql";
        
        private $host="localhost";
	private $db="cartorio_homologacao";
	//private $host="200.219.214.126";
	private $user="cartorio_user";
	private $password="flavio1991clau";
       
	
	protected $maximo;
	protected $total;
	protected $pagina;
	protected $link;

	public function __construct() {
            $this->maximo=50;
            $this->pagina=1;
            
            if(PRODUCAO == 1){
                $this->user="cartorio_user";
                $this->password="flavio1991clau";
            }
            
            
            
            $this->connect();
	}
	/**
	 * Conecta no banco
	 */
	protected function connect() {
		try {
                    $this->con = PDOSingleton::getInstance($this->dbType.":host=".$this->host.";dbname=".$this->db, $this->user, $this->password);
		}
		catch (Exception $e ) {
			echo "ERRO ...".$e->getMessage()." ";
			die();
		}
	}
	
	protected function desconnect() {
			$this->con = null;	
	}
	/**
	 * executa uma query sql.
	 *
	 * @param String $sql
	 */
	protected function exec() {
		$this->sth = $this->con->prepare($this->sql);
		if(!$this->sth) {
			throw new GeneralException($this->con->errorInfo());
		}
		$this->sth->execute($this->values);
		$error = $this->sth->errorInfo();
		if($error[0]!="00000") {
			throw new Exception("ERRO em query\n".$error[2]);
		}
		return $this->sth->rowCount();
	}

	/**
	 * insere um registro no banco e retorna o id.
	 *
	 * @uses $this->exec
	 * @return int
	 */
	protected function insert() {
		$this->sql  = "INSERT INTO ".$this->table." (";
		$this->sql .= implode(", ", $this->fields);
		$this->sql .=") VALUES (";
		for($i=0; $i<sizeof($this->fields); $i++) {
			$this->sql.=($i==0)? "" : ",";
			$this->sql .=":".$this->fields[$i];
		}
		$this->sql .= ")";

		$this->exec();
		return $this->con->lastInsertId();

	}

	protected function update() {
		$this->exec();
	}

	protected function delete() {
		$this->exec();
	}


	/**
	 *  Execute a prepared statement
	 *executa o sql
	 * os valores sï¿½o substituidos pelos valores passados no array $values
	 * retorna um array da classe passada em $class ou stdClass se nï¿½o for passado nada.
	 *
	 * @param String $class
	 * @return $class[]
	 */
	protected function fetch($class='stdClass') {
		try {
			$return = array();
			$this->sth = $this->con->prepare($this->sql);
			if(!$this->sth) $this->generateError($this->con->errorInfo());

			$this->sth->execute($this->values);

			$error = $this->sth->errorInfo();
			if($error[0]!="00000") {
				$this->generateError($error[2]);
			}
			while($result = $this->sth->fetchObject($class)){
				$return[] = $result;
			}
			//$this->desconnect();
			return $return;
		}catch (PDOException $erro) {
			$this->generateError("erro ao fazer a consulta");
		}
	}

	public function beginTrans() {
		if(!$this->con->beginTransaction())
		throw new Exception("Problema ao iniciar a transação");
	}

	public function rollBack() {
		if(!$this->con->rollBack())
		throw new Exception("Problema ao retornar a transação");
	}

	public function commit() {
		if(!$this->con->commit())
		throw new Exception("Problema ao comitar a transação");
	}

	public function getLastInsertId() {
		return $this->con->lastInsertId();
	}

	private function generateError($message) {
		echo "DEU ERRO!<br/><br/>".$this->sql."<br/><br/>";
		$this->con = null;
		throw new Exception($message);
	}

	protected function getAffectedRows(){
		return $this->sth->rowCount();
	}

	protected function getInicio(){
		$inicio = $this->pagina - 1;
		return $this->maximo * $inicio;
	}
	
	/**
	 * função para exibir a paginação
	 */
	public function QTDPagina(){
		echo 'Foram encontrados '.$this->total .' registros<br>';
		$menos 	= $this->pagina - 1;
		$mais 	= $this->pagina + 1;

		$pgs = ceil($this->total / $this->maximo);
		if($pgs > 1 ) {
			if($menos>0) {
                            echo "<a href=\"?pagina=1&".$this->link."\">&lsaquo;&lsaquo; primeira</a> | ";
                            echo "<a href=\"?pagina=$menos&".$this->link."\">&lsaquo; anterior</a> | ";
			}
			if($menos>=8) {
				$i=$menos-7;
				$ate = $menos+7;
			} else {
				$i=1;
				$ate = $menos +16;
			}
			for($i;$i <= $ate; $i++) {
                            if($i != $this->pagina) {
                                    echo "  <a href=\"?pagina=".($i)."&".$this->link."\">$i</a> | ";
                            } else {
                                    echo "  <strong>[&nbsp;&nbsp;".$i."&nbsp;&nbsp;]</strong>";
                            }
                            if($pgs==$i) break;
			}
			if($mais <= $pgs) {
                            echo " <a href=\"?pagina=$mais&".$this->link."\">próxima &rsaquo;</a> | ";
                            echo " <a href=\"?pagina=$pgs&".$this->link."\">última &rsaquo;&rsaquo;</a> | ";
			}

		}
	}
	
	public function QTDPaginaAjax(){
		return $this->total;
	}
}
?>