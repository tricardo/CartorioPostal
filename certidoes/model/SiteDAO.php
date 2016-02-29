<?php
class SiteDAO extends DatabaseSite{
	
	public function __construct(){
		parent::__construct();
		$this->table = 'site_usuarios_cartorio_online';		
	}


	/**
	 * verifica usuarios online
	 * @param string $session
	 * @param string $ip
	 */
	public function usuariosOnline($sessao,$ip){	
	
		$timestamp = time();
		$timeout = time() - 2000;
		
		#deleta usuários com sessao expirada
		$this->sql = "DELETE FROM site_usuarios_cartorio_online WHERE tempo < ?";
		$this->values = array($timeout);
		$this->delete();

		#verifica se é um novo visitante
		$this->sql = "SELECT COUNT(0) as total FROM site_usuarios_cartorio_online as co WHERE sessao = ?";
		$this->values = array($sessao);
		$cont = $this->fetch();

		if($cont[0]->total == 0){
			#caso seja um novo usuário adiciona no banco
			$this->fields = array('sessao','tempo','ip');
			$this->values = array('sessao'=>$sessao,'tempo'=>$timestamp,'ip'=>$ip);
			$this->insert();
		}else{
			#atualiza tempo do usuário
			$this->sql = "update site_usuarios_cartorio_online set tempo=? WHERE sessao = ?";
			$this->values = array($timestamp,$sessao);
			$this->update();
		}

		#conta usuários
		$this->sql = "SELECT count(0) as online FROM site_usuarios_cartorio_online as uc";
		$this->values = array();
		$cont_on = $this->fetch();
		return $cont_on[0]->online;
	}

	/*
	 * busca dúvidas
	 * @param String $busca
	 * @param int $pagina
	 */
	public function buscaDuvidas($busca='',$busca_cat, $pagina=1){
		$this->maximo = 25;
		$url_busca = $_SERVER['REQUEST_URI'];
		$url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
		$url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
		$this->values = array();
		if($busca!=''){
			$where.=" d.titulo like ? AND ";
			$this->values[] = '%'.$busca.'%';
		}
		if($busca_cat=='') $busca_cat=1;
		
		$where.=" d.id_cat = ? AND ";
		$this->values[] = $busca_cat;

		$where.=" 1=1";

		$this->sql = "SELECT count(0) as total FROM site_duvidas as d where ".$where;
		$cont = $this->fetch();
		$this->total = $cont[0]->total;
		
		$where.=" ORDER BY d.titulo ASC ";
		$this->link = $url_busca;
		$this->pagina = ($pagina==NULL)?1:$pagina;

		$this->sql = "SELECT d.id_duvida, d.titulo, d.view FROM site_duvidas as d where ".$where." LIMIT ".$this->getInicio().", ".$this->maximo; 
		return $this->fetch();
	}
	
	/**
	 * seleciona duvida por id
	 * @param int $id
	 */
	public function selecionaDuvidaPorId($id){
	
		#seleciona duvida
		$this->sql = "SELECT * FROM site_duvidas as d where id_duvida=? limit 1";
		$this->values = array($id);
		$ret = $this->fetch();
		
		if($ret[0]->id_duvida<>''){
			#atualiza view
			$this->sql = "update site_duvidas set view=view+1 WHERE id_duvida = ?";
			$this->values = array($id);
			$this->update();
		}
		return $ret[0];
	}
	
	 /*
	 * adiciona formulário fale conosco
	 * @param array $p
	 */
	public function inserirFaleConosco($p){
		$this->table = 'site_fale_conosco';
		$p->data = date('Y-m-d');
		$this->fields = array('nome','email','assunto','data');
		$this->values = array('nome'=>$p->fale_nome,'email'=>$p->fale_email,'assunto'=>$p->fale_assunto,'data'=>$p->data);
		return $this->insert();
	}

	 /*
	 * adiciona formulário depoimento
	 * @param array $p
	 */
	public function inserirDepoimento($p){
		$this->table = 'site_depoimento';
		$p->data = date('Y-m-d');
		$this->fields = array('nome', 'email', 'depoimento', 'data');
		$this->values = array('nome'=>$p->nome,'email'=>$p->email,'depoimento'=>$p->depoimento,'data'=>$p->data);
		return $this->insert();
	}	

	 /*
	 * adiciona formulário depoimento
	 * @param array $p
	 */
	public function inserirDepoimentoFranquia($p){
		$this->table = 'site_depoimento';
		$p->data = date('Y-m-d');
		$this->fields = array('nome', 'email', 'depoimento', 'data', 'id_empresa');
		$this->values = array('nome'=>$p->nome,'email'=>$p->email,'depoimento'=>$p->depoimento,'data'=>$p->data,'id_empresa'=>$p->id_empresa);
		return $this->insert();
	}
        
        public function totalFranquias(){
		$this->sql = "SELECT un.total FROM cp_unidades as un";
		$this->values = array();
		return $this->fetch();
	}
	
	/**
	 * seleciona depoimento sequencial
	 * @param int $pagina
	 */
	public function listaDepoimento($pagina){
	
		$this->maximo = 4;
		$where.=" status=1 and id_empresa=0";

		$this->sql = "SELECT count(0) as total FROM site_depoimento as d where ".$where;
		$cont = $this->fetch();
		$this->total = $cont[0]->total;
		
		$where.=" ORDER BY d.id_depoimento DESC ";
		$this->link = $url_busca;
		$this->pagina = ($pagina==NULL)?1:$pagina;

		$this->sql = "SELECT d.* FROM site_depoimento as d where ".$where." LIMIT ".$this->getInicio().", ".$this->maximo; 
		return $this->fetch();
	}

	/**
	 * seleciona depoimento sequencial
	 * @param int $pagina
	 */
	public function listaDepoimentoFranquia($id_empresa,$pagina){
	
		$this->maximo = 4;
		$where.=" status=1 and id_empresa=?";
		$this->values[] = $id_empresa;

		$this->sql = "SELECT count(0) as total FROM site_depoimento as d where ".$where;
		$cont = $this->fetch();
		$this->total = $cont[0]->total;
		
		$where.=" ORDER BY d.id_depoimento DESC ";
		$this->link = $url_busca;
		$this->pagina = ($pagina==NULL)?1:$pagina;

		$this->sql = "SELECT d.* FROM site_depoimento as d where ".$where." LIMIT ".$this->getInicio().", ".$this->maximo; 
		return $this->fetch();
	}
	 /*
	 * adiciona formulário imprensa
	 * @param array $p
	 */
	public function inserirImprensa($p){
		$this->table = 'site_assessor';
		$p->data = date('Y-m-d');
		$this->fields = array('nome', 'email', 'assunto', 'data');
		$this->values = array('nome'=>$p->nome,'email'=>$p->email,'assunto'=>$p->assunto,'data'=>$p->data);
		return $this->insert();
	}	

	/*
	 * busca noticias
	 * @param String $busca
	 * @param int $pagina
	 */
	public function buscaImprensa($busca='',$id_imprensa_cat, $pagina=1){
		$this->maximo = 25;
		$url_busca = $_SERVER['REQUEST_URI'];
		$url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
		$url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
		$this->values = array();
		if($busca<>''){
			$where.=" i.titulo like ? AND ";
			$this->values[] = '%'.$busca.'%';
		}
		if($id_imprensa_cat<>''){
			$where.=" i.id_imprensa_cat = ? AND ";
			$this->values[] = $id_imprensa_cat;
		}
		
		$where.=" status=1 ";

		$this->sql = "SELECT count(0) as total FROM site_imprensa as i where ".$where;
		$cont = $this->fetch();
		$this->total = $cont[0]->total;
		
		$where.=" ORDER BY i.titulo ASC ";
		$this->link = $url_busca;
		$this->pagina = ($pagina==NULL)?1:$pagina;

		$this->sql = "SELECT * FROM site_imprensa as i where ".$where." LIMIT ".$this->getInicio().", ".$this->maximo; 
		return $this->fetch();
	}

	/**
	 * conta artigos por categoria
	 */
	public function contaArtigos(){	
		#seleciona duvida
		$this->sql = "SELECT COUNT(0) as total, ic.* FROM site_imprensa as i INNER JOIN site_imprensa_cat as ic ON ic.id_imprensa_cat=i.id_imprensa_cat where i.status='1' group by ic.id_imprensa_cat order by ic.cat";
		$this->values = array();
		return $this->fetch();
	}
        
        public function contaDuvidas(){	
		#seleciona duvida
		$this->sql = "SELECT COUNT(0) as total, ic.* FROM site_duvidas as i INNER JOIN site_duvida_cat as ic ON ic.id_cat=i.id_cat where i.status='1' group by ic.id_cat order by ic.cat";
		$this->values = array();
		return $this->fetch();
	}

	/**
	 * conta artigos por categoria
	 */
	public function selecionaImprensaCat($id){	
		#seleciona duvida
		$this->sql = "SELECT * FROM site_imprensa_cat as ic where ic.id_imprensa_cat=? limit 1";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret[0];
	}
        
        public function selecionaDuvidaCat($id){	
		#seleciona duvida
		$this->sql = "SELECT * FROM site_duvida_cat as ic where ic.id_cat=? limit 1";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret[0];
	}
        
        public function selecionaImprensaCat2($id){	
		#seleciona duvida
		$this->sql = "SELECT c.id_imprensa_cat, i.id_imprensa, i.titulo, i.url_amigavel, i.artigo, i.view, i.status FROM site_imprensa as i, site_imprensa_cat as c WHERE i.id_imprensa_cat=c.id_imprensa_cat AND c.id_imprensa_cat=? AND i.id_imprensa=?";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret[0];
	}

	/**
	 * seleciona imprensa por id
	 * @param int $id
	 */
	public function selecionaImprensaPorId($id){
	
		#seleciona imprensa
		$this->sql = "SELECT * FROM site_imprensa as i where id_imprensa=? limit 1";
		$this->values = array($id);
		$ret = $this->fetch();
		
		if($ret[0]->id_imprensa<>''){
			#atualiza view
			$this->sql = "update site_imprensa set view=view+1 WHERE id_imprensa = ?";
			$this->values = array($id);
			$this->update();
		}
		return $ret[0];
	}

	/*
	 * busca franquia galeria
	 * @param String $busca
	 * @param int $pagina
	 */
	public function buscaFranquiaGaleria($busca='', $pagina=1){
		$this->maximo = 25;
		$url_busca = $_SERVER['REQUEST_URI'];
		$url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
		$url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
		$this->values = array();
		if($busca<>''){
			$where.=" t.titulo like ? AND ";
			$this->values[] = '%'.$busca.'%';
		}
		
		$where.=" t.status='Ativo' ";

		$this->sql = "SELECT count(0) as total FROM site_thumbnails as t where ".$where;
		$cont = $this->fetch();
		$this->total = $cont[0]->total;
		
		$where.=" ORDER BY t.id_thumbnail DESC ";
		$this->link = $url_busca;
		$this->pagina = ($pagina==NULL)?1:$pagina;

		$this->sql = "SELECT * FROM site_thumbnails as t where ".$where." LIMIT ".$this->getInicio().", ".$this->maximo; 
		return $this->fetch();
	}

	/**
	 * seleciona galeria por id
	 * @param int $id
	 */
	public function selecionaGaleriaPorId($id){
		$this->sql = "SELECT t.id_thumbnail, g.id_galeria_fotos, g.id_thumbnail, g.imagem, g.status, t.titulo FROM site_thumbnails as t INNER JOIN site_galeria_fotos as g ON g.id_thumbnail=t.id_thumbnail where g.id_thumbnail=? and g.status='Ativo' and t.status='Ativo'";
		$this->values = array($id);
		
		return $this->fetch();
	}

	/**
	 * seleciona galeria por id
	 * @param int $id_empresa
	 */
	public function selecionaFranquiaGaleriaPorId($id_empresa){	
		$this->sql = "SELECT ci.id_cat_imagem, im.id_imagem, ci.nome_imagem, ci.url_amigavel, im.imagem, im.id_empresa, im.descricao, im.st_id FROM cp_cat_imagem as ci, cp_imagem as im WHERE ci.id_cat_imagem=im.id_cat_imagem AND im.st_id='1' AND im.id_empresa=? ORDER BY im.id_imagem desc limit 8";
		$this->values = array($id_empresa);
		
		return $this->fetch();
	}
	
	public function selecionaFranquiaGaleriaPorIdH($id_empresa){
		$this->sql = "SELECT ci.id_cat_imagem, im.id_imagem, ci.nome_imagem, ci.url_amigavel, im.imagem, im.id_empresa, im.descricao, im.st_id FROM cp_cat_imagem as ci, cp_imagem as im WHERE ci.id_cat_imagem=im.id_cat_imagem AND im.st_id='1' AND im.id_empresa=? ORDER BY im.id_imagem desc";
		$this->values = array($id_empresa);
		
		return $this->fetch();
	}
	
	/**
	 * seleciona noticias por id
	 * @param int $id_empresa
	 */
	public function selecionaNoticiaPorId($id_empresa){
		$this->sql = "SELECT ue.id_empresa, ns.id_news, ns.st_id, ns.titulo_news, ns.url_amigavel, ns.imagem_news, ns.texto_chamada, ns.ordem FROM cartorio_banco2.vsites_user_empresa as ue, cp_news_nova as ns WHERE ns.id_empresa=ue.id_empresa AND ns.st_id='1' AND ns.id_empresa=? ORDER BY ns.ordem DESC LIMIT 4";
		$this->values = array($id_empresa);
		
		return $this->fetch();
	}

	/**
	 * seleciona minisite por id
	 * @param int $id_empresa
	 */
	public function listaMinisite($id_empresa){	
		$this->sql = "SELECT * FROM site_minisite as m where m.id_empresa=? limit 1";
		$this->values = array($id_empresa);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	/**
	 * lista operadora
	 */
	public function listaOperadora(){
		$this->sql = "SELECT * FROM site_operadora as op ORDER BY op.id_operadora";
		$this->values = array();
		return $this->fetch();
	}


}
?>