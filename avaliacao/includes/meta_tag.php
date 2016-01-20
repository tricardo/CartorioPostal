<?
switch ($pg) { 
	case 'quem-somos': 
		echo
	'<title>Buscamo e enviamos suas certidões</title>
	<meta name="keywords" content="certidão de nascimento, certidão de casamento, certidão de imovel, cartório 24 horas, protesto de títulos, protesto de cheques, protesto de duplicata, limpeza de nome, certidões de nascimento, certidão de débitos, certidão de nascimento, certidão de óbito, cidadania" />
	<meta name="description" content="Solicite suas certidões ou certidão on-line e receba no conforto de sua casa. Buscamos e enviamos para todo brasil." />';
		break;

	case 'fale-conosco': 
		echo
	'<title>Fale conosco sobre busca de Certidões da Cartório Postal Japão</title>
	<meta name="keywords" content="certidões de casamento, certidões de nascimento, certidão de débitos, certidão de nascimento, certidão de óbito, cidadania" />
	<meta name="description" content="Buscamos e Enviamos para todo Brasil, receba no conforto de sua casa. Trabalhamos com diversas certidões. Inclusive de casamento" />';
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
	<meta name="keywords" content="certidões,'.$servico.', certidões de nascimento, certidão de débitos, certidão de casamento, certidão de óbito, cidadania" />
	<meta name="description" content="'.$servico.' Enviamos para todo Brasil, receba sua certidão no conforto de sua casa. Trabalhamos com diversas certidões." />
';
}
?>
	<meta http-equiv="Refresh" content="atualiza" />
	<meta name="REVISIT-AFTER" content="3" />
	<meta name="ROBOTS" content="all" />
	<meta name="GOOGLEBOT" content="INDEX, FOLLOW" />
	<meta name="AUDIENCE" content="all" />
	<meta name="AUTHOR" content="Canal dos Profissionais" />
 