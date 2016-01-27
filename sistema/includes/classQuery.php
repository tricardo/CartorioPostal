<?php
class classQuery{
	var $conexao;
	var $host;
	var $user;
	var $pass;
	var $db;
	var $ID;

	var $pagina;
	var $maximo;
	var $total;
	var $link;

	function classQuery(){
		//$this->host = "cartoriopostal.com.br";
        $this->host = "localhost";
		$this->user = "cartorio_user";
		$this->pass = "flavio1991clau";
		$this->db = "cartorio_homologacao";
	}

	function abreConexao(){
		$this->conexao = mysql_connect( $this->host, $this->user, $this->pass ) or die( mysql_error() );
		mysql_select_db($this->db);
	}

	function fechaConexao(){
		mysql_close( $this->conexao ) or die( mysql_error() );
	}

	function SQLQuery( $sql ){
		$this->abreConexao();
		$query = mysql_query( $sql ) or die( mysql_error() );
		$this->ID = mysql_insert_id();
		$this->ID_A = mysql_affected_rows();
		$this->fechaConexao();
		return $query;
	}

	function ID(){
		return $this->ID;
	}

	function QUERY_A(){
		return $this->ID_A;
	}

	function paginacao( $campo, $condicao, $pagina="", $link, $maximo=50 ){
		$campos_query = $campo;
		$final_query  = $condicao;
			
		$this->link		= $link;
		$this->pagina 	= $pagina;
		if( empty( $this->pagina ) ) $this->pagina = "1";

		$this->maximo = $maximo;
			
		$inicio = $this->pagina - 1;
		$inicio = $maximo * $inicio;
			
		$strCount = "SELECT COUNT(*) AS 'num_registros' $final_query";
		$query    = $this->SQLQuery($strCount);
		$row      = mysql_fetch_array($query);
		$this->total    = $row["num_registros"];
			
		$strQuery = "SELECT $campos_query $final_query LIMIT $inicio,$maximo";
		$query    = $this->SQLQuery($strQuery);
		return $query;
	}

	function paginacao12( $campo, $condicao, $pagina="", $link, $maximo=12 ){
		$campos_query = $campo;
		$final_query  = $condicao;
			
		$this->link		= $link;
		$this->pagina 	= $pagina;
		if( empty( $this->pagina ) ) $this->pagina = "1";

		$this->maximo = $maximo;
			
		$inicio = $this->pagina - 1;
		$inicio = $maximo * $inicio;
			
		$strCount = "SELECT COUNT(*) AS 'num_registros' $final_query";
		$query    = $this->SQLQuery($strCount);
		$row      = mysql_fetch_array($query);
		$this->total    = $row["num_registros"];
			
		$strQuery = "SELECT $campos_query $final_query LIMIT $inicio,$maximo";
		$query    = $this->SQLQuery($strQuery);
			
		return $query;
	}

	function QTDPagina(){

		echo 'Foram encontrados '.$this->total .' registros<br>';
		$menos 	= $this->pagina - 1;
		$mais 	= $this->pagina + 1;

		$pgs = ceil($this->total / $this->maximo);
		if($pgs > 1 ) {
			if($menos>0) {
				echo "<a href=\"?pagina=$menos&".$this->link."\" class='link1'>anterior</a> ";
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
					echo "  <a href=\"?pagina=".($i)."&".$this->link."\" class='link1'>$i</a> | ";
				} else {
					echo "  <strong class='link1'>[".$i."]</strong>";
				}
				if($pgs==$i) break;
			}
			if($mais <= $pgs) {
				echo "   <a href=\"?pagina=$mais&".$this->link."\" class='link1'>pr�xima</a>";
			}

		}
	}
}

$objQuery = new classQuery();
?>