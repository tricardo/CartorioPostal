<?php
class SitemapDAO extends DatabaseSite{
	
	public function __construct(){
		parent::__construct();
	}
	
	/**
	 * atualiza sitemap
	 */
	public function SitemapFotos(){
		$this->sql = "SELECT id_thumbnail FROM site_thumbnails as t where status='Ativo'";
		$this->values = array();
		return $this->fetch();		
	}	

	/**
	 * atualiza sitemap
	 */
	public function SitemapImprensa(){
		$this->sql = "SELECT id_imprensa, id_imprensa_cat FROM site_imprensa as i where status=1";
		$this->values = array();
		return $this->fetch();		
	}	

	/**
	 * atualiza sitemap
	 */
	public function SitemapDuvidas(){
		$this->sql = "SELECT id_duvida, id_cat FROM site_duvidas as i where status=1";
		$this->values = array();
		return $this->fetch();		
	}	
	
}
?>