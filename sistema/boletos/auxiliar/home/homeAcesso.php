<?php

class homeAcesso extends Acesso{
	public function __call($metodo, $args){
		return true;
	}
}
?>