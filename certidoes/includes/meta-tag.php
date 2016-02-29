<?
switch($pg){ 
	case 'paginas_hotsite':
		pt_register('GET','id_empresa');
		pt_register('GET','estado');
		pt_register('GET','cidade');
		$cid = explode('-',$cidade);
		$cidade=$cid[0];
		$bairro=$cid[1];
		pt_register('GET','link');
		$empresaDAO = new EmpresaDAO();
		$fr = $empresaDAO->listaEmpresaSiteId();
		$fr->link_estado = strtolower($fr->estado);
		if($fr->apelido=='')
			$fr->link_bairro = strtolower(limpa_url(str_replace(' ','',$fr->bairro)));
		else
			$fr->link_bairro = strtolower(limpa_url(str_replace(' ','',$fr->apelido)));
		$fr->link_cidade = strtolower(limpa_url(str_replace(' ','',$fr->cidade))).'-'.$fr->link_bairro;

		$sql = $objQuery->SQLQuery("SELECT '".$fr->id_empresa."', mt.id_pagina, mt.id_meta, mt.titulo, mt.chave, mt.descricao, mt.url_amigavel FROM cp_meta_tag as mt, cartorio_banco2.vsites_user_empresa as ue WHERE '".$fr->id_empresa."'=mt.id_empresa AND mt.st_id='1' AND ue.id_empresa='".$fr->id_empresa."' AND mt.id_pagina = '".$id_pagina."'");
		$res = mysql_fetch_array($sql);
		echo
		'<title>'.$res['titulo'].' - '.$fr->fantasia.'</title>
		<meta name="description" content="'.$res['descricao'].'"/>
		<meta name="keywords" content="'.$res['chave'].'"/>
		<link rel="canonical" href="'.URL_SITE_H.''.$fr->id_empresa.'/'.$fr->link_estado.'/'.$fr->link_cidade.'/'.$res['url_amigavel'].'" />'."\n";
		break;
	case 'pagina_news_hotsite':
		pt_register('GET','id_empresa');
		pt_register('GET','estado');
		pt_register('GET','cidade');
		$cid = explode('-',$cidade);
		$cidade=$cid[0];
		$bairro=$cid[1];
		pt_register('GET','link');
		$empresaDAO = new EmpresaDAO();
		$fr = $empresaDAO->listaEmpresaSiteId();
		$fr->link_estado = strtolower($fr->estado);
		if($fr->apelido=='')
			$fr->link_bairro = strtolower(limpa_url(str_replace(' ','',$fr->bairro)));
		else
			$fr->link_bairro = strtolower(limpa_url(str_replace(' ','',$fr->apelido)));
		$fr->link_cidade = strtolower(limpa_url(str_replace(' ','',$fr->cidade))).'-'.$fr->link_bairro;

		pt_register('GET','id');
		$sql = $objQuery->SQLQuery("SELECT '".$fr->id_empresa."', ns.id_news, ns.titulo_news, ns.url_amigavel, ns.chave, ns.descricao FROM cartorio_banco2.vsites_user_empresa as ue, cp_news_nova as ns WHERE '".$fr->id_empresa."'=ns.id_empresa AND ns.st_id='1' AND ue.id_empresa='".$fr->id_empresa."' AND ns.id_news = '".$id."'");
		$res = mysql_fetch_array($sql);
		echo
		'<title>'.$res['titulo_news'].'</title>
		<meta name="description" content="'.$res['descricao'].'"/>
		<meta name="keywords" content="'.$res['chave'].'"/>
		<link rel="canonical" href="'.URL_SITE_H.''.$fr->id_empresa.'/'.$fr->link_estado.'/'.$fr->link_cidade.'/noticia/'.$res['id_news'].'/'.$res['url_amigavel'].'" />'."\n";
		break;
	case 'certidao_hotsite': 
		pt_register('GET','id');
		pt_register('GET','id_empresa');
		pt_register('GET','estado');
		pt_register('GET','cidade');
		pt_register('POST','id_servico');
		$cid = explode('-',$cidade);
		$cidade=$cid[0];
		$bairro=$cid[1];
		pt_register('GET','link');
		$empresaDAO = new EmpresaDAO();
		$fr = $empresaDAO->listaEmpresaSiteId();
		$fr->link_estado = strtolower($fr->estado);
		if($fr->apelido=='')
			$fr->link_bairro = strtolower(limpa_url(str_replace(' ','',$fr->bairro)));
		else
			$fr->link_bairro = strtolower(limpa_url(str_replace(' ','',$fr->apelido)));
		$fr->link_cidade = strtolower(limpa_url(str_replace(' ','',$fr->cidade))).'-'.$fr->link_bairro;

		if($id_servico<>'') $id = $id_servico;
		$servicos = $pedidoDAO->selectServicosSite();
		$p_valor='
		<select name="id_servico" id="id_servico"';
		$p_valor .= ($errors['id_servico'])?'_erro':'';
		$p_valor .= '" onchange="carrega_servico_var(this.value,\'\'); carrega_campo(this.value,\'\');">
		<option value="">Selecione o Serviço</option>';
		foreach($servicos as $serv){
			$p_valor .= '<option value="'.$serv->id_servico.'" ';
			if($id==$serv->id_servico) {
				$p_valor .= ' selected="selected"';
				$servico_desc = $serv->servico_desc;
				if($serv->desc_site<>'') $servico = $serv->desc_site; else $servico=$serv->descricao;
				if($servico=='') $servico=  'Solicite agora sua Certidão';
			}
			$p_valor .= '>'.char_upper(strtoupper(strtolower($serv->descricao))).'</option>
			';
		}
		$combo_servico = $p_valor.'</select>';
		if($servico=='') $servico='Certidão é na Cartório Postal - '.$fr->fantasia;
		echo
		'<title>'.str_replace(' (2ª via)','',$servico).'</title>
		<meta name="keywords" content="'.str_replace(' (2ª via)','',$servico).', certidao de nascimento, certidão, certidões, certidao de casamento, certidão forense, certidao on-line, cartório on-line, cartorio online, certidao online, certidao, certidoes" />
		<meta name="description" content="'.str_replace(' (2ª via)','',$servico).' - '.trim(str_replace('<br />','',str_replace('</p>','',str_replace('<p>','',strtolower($servico_desc))))).' Solicite agora sua Certidão on-line ou em uma de nossas unidades." />
		<link rel="canonical" href="'.URL_SITE_H.''.$fr->id_empresa.'/'.$fr->link_estado.'/'.$fr->link_cidade.'/certidao" />'."\n";
		break;
	case 'certidao_parceria': 
		pt_register('GET','id');
		pt_register('GET','id_empresa');
		pt_register('GET','estado');
		pt_register('GET','cidade');
		pt_register('POST','id_servico');
		$cid = explode('-',$cidade);
		$cidade=$cid[0];
		$bairro=$cid[1];
		pt_register('GET','link');
		$empresaDAO = new EmpresaDAO();
		$fr = $empresaDAO->listaEmpresaSiteId();
		$fr->link_estado = strtolower($fr->estado);
		if($fr->apelido=='')
			$fr->link_bairro = strtolower(limpa_url(str_replace(' ','',$fr->bairro)));
		else
			$fr->link_bairro = strtolower(limpa_url(str_replace(' ','',$fr->apelido)));
		$fr->link_cidade = strtolower(limpa_url(str_replace(' ','',$fr->cidade))).'-'.$fr->link_bairro;

		if($id_servico<>'') $id = $id_servico;
		$servicos = $pedidoDAO->selectServicosSite();
		$p_valor='
		<select name="id_servico" id="id_servico"';
		$p_valor .= ($errors['id_servico'])?'_erro':'';
		$p_valor .= '" onchange="carrega_servico_var(this.value,\'\'); carrega_campo(this.value,\'\');">
		<option value="">Selecione o Serviço</option>';
		foreach($servicos as $serv){
			$p_valor .= '<option value="'.$serv->id_servico.'" ';
			if($id==$serv->id_servico) {
				$p_valor .= ' selected="selected"';
				$servico_desc = $serv->servico_desc;
				if($serv->desc_site<>'') $servico = $serv->desc_site; else $servico=$serv->descricao;
				if($servico=='') $servico=  'Solicite agora sua Certidão';
			}
			$p_valor .= '>'.char_upper(strtoupper(strtolower($serv->descricao))).'</option>
			';
		}
		$combo_servico = $p_valor.'</select>';
		if($servico=='') $servico='Certidão é na Cartório Postal - '.$fr->fantasia;
		echo
		'<title>'.str_replace(' (2ª via)','',$servico).'</title>
		<meta name="keywords" content="'.str_replace(' (2ª via)','',$servico).', certidao de nascimento, certidão, certidões, certidao de casamento, certidão forense, certidao on-line, cartório on-line, cartorio online, certidao online, certidao, certidoes" />
		<meta name="description" content="'.str_replace(' (2ª via)','',$servico).' - '.trim(str_replace('<br />','',str_replace('</p>','',str_replace('<p>','',strtolower($servico_desc))))).' Solicite agora sua Certidão on-line ou em uma de nossas unidades." />
		<link rel="canonical" href="'.URL_SITE_H.''.$fr->id_empresa.'/'.$fr->link_estado.'/'.$fr->link_cidade.'/certidao" />'."\n";
		break;
	case 'paginas':
		$sql = $objQuery->SQLQuery("SELECT mt.id_meta, mt.titulo, mt.chave, mt.descricao, mt.url_amigavel FROM cp_meta_tag as mt WHERE mt.st_id='1' AND mt.id_meta = '".$id_meta."'");
		$res = mysql_fetch_array($sql);
		echo
		'<title>'.$res['titulo'].'</title>
		<meta name="description" content="'.$res['descricao'].'"/>
		<meta name="keywords" content="'.$res['chave'].'"/>
		<link rel="canonical" href="'.URL_SITE.''.$res['url_amigavel'].'/" />'."\n";
		break;
	case 'pagina_news':
		pt_register('GET','id');
		$sql = $objQuery->SQLQuery("SELECT ns.id_news, ns.titulo_news, ns.url_amigavel, ns.chave, ns.descricao FROM cp_news_nova as ns WHERE ns.st_id='1' AND ns.id_news = '".$id."'");
		$res = mysql_fetch_array($sql);
		echo
		'<title>'.$res['titulo_news'].'</title>
		<meta name="description" content="'.$res['descricao'].'"/>
		<meta name="keywords" content="'.$res['chave'].'"/>
		<link rel="canonical" href="'.URL_SITE.'noticia/'.$res['id_news'].'/'.$res['url_amigavel'].'/" />';
		break;
	case 'pagina_imagens':
		pt_register('GET','id');
		$sql = $objQuery->SQLQuery("SELECT ci.id_cat_imagem, ci.chave, ci.descricao, ci.url_amigavel, im.id_imagem, ci.nome_imagem, im.imagem, im.st_id FROM cp_cat_imagem as ci, cp_imagem as im WHERE ci.id_cat_imagem=im.id_cat_imagem AND im.st_id='1' AND im.id_cat_imagem='" .$id. "'");
		$res = mysql_fetch_array($sql);
		echo
		'<title>Galeria de fotos da Cartório Postal - '.$res['nome_imagem'].'</title>
		<meta name="description" content="'.$res['descricao'].'"/>
		<meta name="keywords" content="'.$res['chave'].'"/>
		<link rel="canonical" href="'.URL_SITE.'galeria-de-fotos-da-unidade-cartorio-postal/'.$res['id_cat_imagem'].'/'.$res['url_amigavel'].'/" />'."\n";
		break;
	case 'pagina_videos':
		pt_register('GET','id');
		$sql = $objQuery->SQLQuery("SELECT cv.id_cat_video, cv.nome_video, cv.url_amigavel, cv.chave, cv.descricao FROM cp_cat_video as cv WHERE cv.st_id='1' AND cv.id_cat_video = '".$id."'");
		$res = mysql_fetch_array($sql);
		echo
		'<title>'.$res['nome_video'].'</title>
		<meta name="description" content="'.$res['descricao'].'"/>
		<meta name="keywords" content="'.$res['chave'].'"/>
		<link rel="canonical" href="'.URL_SITE.'video/'.$res['id_cat_video'].'/'.$res['url_amigavel'].'/" />'."\n";
		break;
	case 'certidao': 
		pt_register('GET','id');
		pt_register('POST','id_servico');
		if($id_servico<>'') $id = $id_servico;
		$servicos = $pedidoDAO->selectServicosSite();
		$p_valor='
		<select name="id_servico" id="id_servico"';
		$p_valor .= ($errors['id_servico'])?'_erro':'';
		$p_valor .= '" onchange="carrega_servico_var(this.value,\'\'); carrega_campo(this.value,\'\');">
		<option value="">Selecione o Serviço</option>';
		foreach($servicos as $serv){
			$p_valor .= '<option value="'.$serv->id_servico.'" ';
			if($id==$serv->id_servico) {
				$p_valor .= ' selected="selected"';
				$servico_desc = $serv->servico_desc;
				if($serv->desc_site<>'') $servico = $serv->desc_site; else $servico=$serv->descricao;
				if($servico=='') $servico=  'Solicite agora sua Certidão';
			}
			$p_valor .= '>'.char_upper(strtoupper(strtolower($serv->descricao))).'</option>
			';
		}
		$combo_servico = $p_valor.'</select>';
		if($servico=='') $servico='Certidão é na Cartório Postal';
		echo
		'<title>'.str_replace(' (2ª via)','',$servico).'</title>
		<meta name="keywords" content="'.str_replace(' (2ª via)','',$servico).', certidao de nascimento, certidão, certidões, certidao de casamento, certidão forense, certidao on-line, cartório on-line, cartorio online, certidao online, certidao, certidoes" />
		<meta name="description" content="'.str_replace(' (2ª via)','',$servico).' - '.trim(str_replace('<br />','',str_replace('</p>','',str_replace('<p>','',strtolower($servico_desc))))).' Solicite agora sua Certidão on-line ou em uma de nossas unidades." />
		<link rel="canonical" href="http://www.cartoriopostal.com.br/certidao/'.$serv->id_servico.'/'.strtolower(limpa_url($serv->desc_site)).'/" />'."\n";
		break;
	case 'duvidas-frequentes-ver': 
		pt_register('GET','id');
		pt_register('GET','busca_cat');
		pt_register('GET','busca_duvida');
		pt_register('GET','pagina');
		$lista = $siteDAO->selecionaDuvidaPorId((int)($id));
		echo
		'<title>Dúvidas sobre:'.$lista->titulo.' e certidão ou certidões em geral</title>
		<meta name="keywords" content="certidão, certidões, certidao, certidoes, certidão de nascimento, certidões de nascimento, certidão de débitos, certidão de casamento, certidão de óbito, cidadania" />
		<meta name="description" content="Duvida sobre: Certidão, '.$lista->titulo.', tire suas dúvidas sobre certidão, ou certidões diversas ou documentos em geral." />';
		break;
	case 'imprensa': 
		pt_register('GET','id_imprensa_cat');
		pt_register('GET','busca_imprensa');
		$lartigo = $siteDAO->selecionaImprensaCat((int)($id_imprensa_cat));
		echo
		'<title>Artigo da Cartório Postal: '.$lartigo->cat.'</title>
		<meta name="keywords" content="certidao por correio, certidão online, certidões, certidoes, certidao, certidões de nascimento, certidão de débitos, certidão de nascimento, certidão de óbito, cidadania, '.$lartigo->cat.'" />
		<meta name="description" content="'.$lartigo->cat.' Cartório Postal na imprensa, temos parcerias com imobiliarias, receba no conforto de sua casa. Trabalhamos com diversas certidões." />
                <link rel="canonical" href="'.URL_SITE.'certidao-imprensa/'.$lartigo->id_imprensa_cat.'/" />'."\n";
		break;
        case 'duvida': 
            pt_register('GET','id_cat');
            pt_register('GET','busca_duvida');
            $lartigo = $siteDAO->selecionaDuvidaCat((int)($id_cat));
            echo
            '<title>Dúvidas frequentes sobre certidões: '.$lartigo->cat.'</title>
            <meta name="keywords" content="certidao por correio, certidão online, certidões, certidoes, certidao, certidões de nascimento, certidão de débitos, certidão de nascimento, certidão de óbito, cidadania, '.$lartigo->cat.'" />
            <meta name="description" content="'.$lartigo->cat.' Cartório Postal na imprensa, temos parcerias com imobiliarias, receba no conforto de sua casa. Trabalhamos com diversas certidões." />
            <link rel="canonical" href="'.URL_SITE.'duvida-certidao/'.$lartigo->id_cat.'/" />'."\n";
            break;
	case 'imprensa-ver': 
                pt_register('GET','id_imprensa_cat');
                pt_register('GET','id_imprensa');
                $id_imprensa_cat = explode('/',$id_imprensa_cat);
                $id_imprensa = $id_imprensa_cat[2];
                $id_imprensa_cat = $id_imprensa_cat[0];
		$sql = $objQuery->SQLQuery("SELECT c.id_imprensa_cat, i.id_imprensa, i.titulo, i.url_amigavel, i.artigo, i.view, i.status, date_format(i.data, '%d/%m/%Y') as data FROM site_imprensa as i, site_imprensa_cat as c WHERE i.id_imprensa_cat=c.id_imprensa_cat AND i.status='1' AND c.id_imprensa_cat='" .$id_imprensa_cat. "' AND i.id_imprensa='" .$id_imprensa. "'");
		$res = mysql_fetch_array($sql);
		echo
		'<title>'.$res['titulo'].'</title>
		<meta name="description" content="'.$res['descricao'].'"/>
		<meta name="keywords" content="'.$res['chave'].'"/>
		<link rel="canonical" href="'.URL_SITE.'certidao-imprensa-ver/'.$res['id_imprensa_cat'].'/'.$res['url_amigavel'].'/'.$res['id_imprensa'].'/" />'."\n";
		break;
        case 'duvida-ver': 
            pt_register('GET','id_cat');
            pt_register('GET','id_duvida');
            $id_cat = explode('/',$id_cat);
            $id_duvida = $id_cat[2];
            $id_cat = $id_cat[0];
            $sql = $objQuery->SQLQuery("SELECT c.id_cat, i.id_duvida, i.titulo, i.url_amigavel, i.artigo, i.view, i.status, date_format(i.data, '%d/%m/%Y') as data FROM site_duvidas as i, site_duvida_cat as c WHERE i.id_cat=c.id_cat AND i.status='1' AND c.id_cat='" .$id_cat. "' AND i.id_duvida='" .$id_duvida. "'");
            $res = mysql_fetch_array($sql);
            echo
            '<title>'.$res['titulo'].'</title>
            <meta name="description" content="'.$res['descricao'].'"/>
            <meta name="keywords" content="'.$res['chave'].'"/>
            <link rel="canonical" href="'.URL_SITE.'duvida-certidao-ver/'.$res['id_cat'].'/'.$res['url_amigavel'].'/'.$res['id_duvida'].'/" />'."\n";
            break;
	case 'sobre-franquia': 
		pt_register('GET','link');
		switch($link){
			case 'sobre-franquia-galeria':
				echo
				'<title> Galeria de Fotos das Franquias Cartório Postal</title>
				<meta name="keywords" content="fotos da franquia mais procurada, certidões de nascimento, certidão de débitos, certidão de nascimento, certidão de óbito, cidadania" />
				<meta name="description" content="Fotos da franquia mais procurada do Brasil, receba no conforto de sua casa. Solicite sua certidão ou certidões e nós buscamos para você" />';
			case 'sobre-franquia-ver':
				pt_register('GET','id');
				$lgaleria = $siteDAO->selecionaGaleriaPorId((int)($id));
				echo
				'<title>'.$lgaleria[0]->titulo.' Galeria de Fotos das Franquias Cartório Postal</title>
				<meta name="keywords" content="'.$lgaleria[0]->titulo.' fotos da franquia mais procurada, certidões de nascimento, certidão de débitos, certidão de nascimento, certidão de óbito, cidadania" />
				<meta name="description" content="'.$lgaleria[0]->titulo.' Fotos da franquia mais procurada do Brasil, receba no conforto de sua casa. Solicite suas certidões ou certidão e nós buscamos para você." />';
				break;
			case 'porquefranqueado':
				$titulo = 'Porque ser franqueado';
				break;
			case 'vantagens':
				$titulo = 'Vantagens de ser franqueado';
				break;
			case 'contato':
				$titulo = 'Pré-Cadastro da franquia';
				break;
			default:
				$titulo = 'Sobre compra de franquia';
		}
		if($link!='sobre-franquia-ver'){
			echo
			'<title>'.$titulo.' - Cartório Postal </title>
			<meta name="keywords" content="'.$titulo.',franquia mais procurada, franquias abf, abf franchise, venda de franquia, vendas de franquia, venda de franquias" />
			<meta name="description" content="'.$titulo.' - Franquia mais procurada do Brasil, sem investimento em estoque, com suporte para implantação e geo referenciamento, veja nosso diferencial, solicite suas certidões e receba em casa" />';
		}
		echo '<!-- Google Code for Franquia Conversion Page -->
		<script language="javascript" type="text/javascript">
		/* <![CDATA[ */
		var google_conversion_id = 1030969530;
		var google_conversion_language = "pt";
		var google_conversion_format = "2";
		var google_conversion_color = "FFFFFF";
		var google_conversion_label = "Tx8zCMCulQIQurHN6wM";
		var google_conversion_value = 0;
		/* ]]> */
		</script>

		<noscript>
		<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js"></script>
		<img style="border-style: none; width: 0px; height: 0px;" alt="" src="http://www.googleadservices.com/pagead/conversion/1030969530/?label=Tx8zCMCulQIQurHN6wM&amp; guid=ON&amp; script=0"/>
		</noscript>';
		break;
	case 'franquia':
		pt_register('GET','id_empresa');
		pt_register('GET','estado');
		pt_register('GET','cidade');
		$cid = explode('-',$cidade);
		$cidade=$cid[0];
		$bairro=$cid[1];
		pt_register('GET','link');
		$empresaDAO = new EmpresaDAO();
		$fr = $empresaDAO->listaEmpresaSite($estado,$cidade,$bairro);
		
		$fr->link_estado = strtolower($fr->estado);
		if($fr->apelido=='')
			$fr->link_bairro = strtolower(limpa_url(str_replace(' ','',$fr->bairro)));
		else
			$fr->link_bairro = strtolower(limpa_url(str_replace(' ','',$fr->apelido)));
		$fr->link_cidade = strtolower(limpa_url(str_replace(' ','',$fr->cidade))).'-'.$fr->link_bairro;
		if($fr->imagem=='') $fr->imagem='franquia.jpg';
		if($link=='certidao'){
			pt_register('GET','id');
			$servicos = $pedidoDAO->selectServicosSite();
			$p_valor='
			<select name="id_servico" id="id_servico" style="width:340px;" class="form_estilo';
			$p_valor .= ($errors['id_servico'])?'_erro':'';
			$p_valor .= '" onchange="carrega_servico_var(this.value,\'\'); carrega_campo(this.value,\'\');">
			<option value="">Selecione o Serviço</option>';
			foreach($servicos as $serv){
				$p_valor .= '<option value="'.$serv->id_servico.'" ';
				if($id==$serv->id_servico) {
					$p_valor .= ' selected="selected"'; 
					$servico_desc = $serv->servico_desc;
					if($serv->desc_site<>'') $servico = $serv->desc_site; else $servico=$serv->descricao;
					if($servico=='') $servico=  'Solicite agora sua Certidão';
				}
				$p_valor .= '>'.$serv->descricao.'</option>
			';
			}
			$combo_servico = $p_valor.'</select>';
			if($servico=='') $servico = 'Certidão ';
			echo
			'<title>'.$servico.' '.$fr->fantasia.'</title>
			<meta name="keywords" content="'.$servico.' '.$fr->fantasia.','.$link.', certidões de nascimento, certidão de débitos, certidão de nascimento, certidão de óbito, cidadania" />
			<meta name="description" content="'.$servico.','.$fr->fantasia.' Conheça os serviços da Cartório Postal, receba sua certidão no conforto de sua casa. Solicite suas certidões aqui" />';
		} else {
		echo
			'<title>'.$fr->fantasia.' '.$link.'</title>
			<meta name="keywords" content="'.$fr->fantasia.' '.$link.',certidão de casamento, certidões de nascimento, certidão de débitos, certidão de nascimento, certidão de óbito, cidadania" />
			<meta name="description" content="'.$fr->fantasia.' '.$link.'. Solicite seus documentos na Cartório Postal e receba sua certidão no conforto de sua casa. Certidão ou Certidões é na Cartório Postal" />';
		}
		break;
	case 'hotsite':
		pt_register('GET','id_empresa');
		pt_register('GET','estado');
		pt_register('GET','cidade');
		$cid = explode('-',$cidade);
		$cidade=$cid[0];
		$bairro=$cid[1];
		pt_register('GET','link');
		$empresaDAO = new EmpresaDAO();
		$fr = $empresaDAO->listaEmpresaSiteId();
		
		$fr->link_estado = strtolower($fr->estado);
		if($fr->apelido=='')
			$fr->link_bairro = strtolower(limpa_url(str_replace(' ','',$fr->bairro)));
		else
			$fr->link_bairro = strtolower(limpa_url(str_replace(' ','',$fr->apelido)));
		$fr->link_cidade = strtolower(limpa_url(str_replace(' ','',$fr->cidade))).'-'.$fr->link_bairro;
		if($fr->imagem=='') $fr->imagem='franquia.jpg';
		if($link=='certidao'){
			pt_register('GET','id');
			$servicos = $pedidoDAO->selectServicosSite();
			$p_valor='
			<select name="id_servico" id="id_servico" style="width:340px;" class="form_estilo';
			$p_valor .= ($errors['id_servico'])?'_erro':'';
			$p_valor .= '" onchange="carrega_servico_var(this.value,\'\'); carrega_campo(this.value,\'\');">
			<option value="">Selecione o Serviço</option>';
			foreach($servicos as $serv){
				$p_valor .= '<option value="'.$serv->id_servico.'" ';
				if($id==$serv->id_servico) {
					$p_valor .= ' selected="selected"'; 
					$servico_desc = $serv->servico_desc;
					if($serv->desc_site<>'') $servico = $serv->desc_site; else $servico=$serv->descricao;
					if($servico=='') $servico=  'Solicite agora sua Certidão';
				}
				$p_valor .= '>'.$serv->descricao.'</option>
			';
			}
			$combo_servico = $p_valor.'</select>';
			if($servico=='') $servico = 'Certidão ';
			echo
			'<title>'.$servico.' '.$fr->fantasia.'</title>
			<meta name="keywords" content="'.$servico.' '.$fr->fantasia.','.$link.', certidões de nascimento, certidão de débitos, certidão de nascimento, certidão de óbito, cidadania" />
			<meta name="description" content="'.$servico.','.$fr->fantasia.' Conheça os serviços da Cartório Postal, receba sua certidão no conforto de sua casa. Solicite suas certidões aqui" />';
		} else {
		echo
			'<title>'.$fr->fantasia.' '.$link.'</title>
			<meta name="keywords" content="'.$fr->fantasia.' '.$link.',certidão de casamento, certidões de nascimento, certidão de débitos, certidão de nascimento, certidão de óbito, cidadania" />
			<meta name="description" content="'.$fr->fantasia.' '.$link.'. Solicite seus documentos na Cartório Postal e receba sua certidão no conforto de sua casa. Certidão ou Certidões é na Cartório Postal" />
			<link rel="canonical" href="'.URL_SITE.''.$fr->id_empresa.'/'.$fr->link_estado.'/'.$fr->link_cidade.'" />'."\n";
		}
		break;
	default:
		pt_register('GET','id');
		if($id<>''){
			$servicos = $pedidoDAO->selectServicosSite();
			foreach($servicos as $serv){
				if($id==$serv->id_servico) {
					$servico_desc = $serv->servico_desc;
					if($serv->desc_site<>'') $servico = $serv->desc_site; else $servico=$serv->descricao;
				}
			}
		}
		if($servico=='') $servico='Cartório Postal';
		echo
		'<title>'.$servico.', Solicite suas Certidões</title>
		<meta name="keywords" content="certidões,'.$servico.', certidões de nascimento, certidão de débitos, certidão de casamento, certidão de óbito, cidadania, certidão, certidao, certidoes" />
		<meta name="description" content="'.$servico.' Enviamos para todo Brasil, receba sua certidão no conforto de sua casa. Certidões on-line, receba suas certidões pelos correios." />
		';
}
?>
<meta name="REVISIT-AFTER" content="3 Days" />
<meta name="AUDIENCE" content="all" />
<meta name="LANGUAGE" content="pt-BR" />
<meta name="DISTRIBUTION" content="Global" />
<meta name="ROBOTS" content="index,follow" />
<meta name="GOOGLEBOT" content="INDEX, FOLLOW" />
<meta name="AUTHOR" content="Softfox" />
<meta http-equiv="Content-Language" content="pt-br" />
<meta http-equiv="Refresh" content="atualiza" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />