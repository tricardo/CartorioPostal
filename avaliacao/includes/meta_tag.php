<?
switch ($pg) { 
	case 'quem-somos': 
		echo
	'<title>Buscamo e enviamos suas certid�es</title>
	<meta name="keywords" content="certid�o de nascimento, certid�o de casamento, certid�o de imovel, cart�rio 24 horas, protesto de t�tulos, protesto de cheques, protesto de duplicata, limpeza de nome, certid�es de nascimento, certid�o de d�bitos, certid�o de nascimento, certid�o de �bito, cidadania" />
	<meta name="description" content="Solicite suas certid�es ou certid�o on-line e receba no conforto de sua casa. Buscamos e enviamos para todo brasil." />';
		break;

	case 'fale-conosco': 
		echo
	'<title>Fale conosco sobre busca de Certid�es da Cart�rio Postal Jap�o</title>
	<meta name="keywords" content="certid�es de casamento, certid�es de nascimento, certid�o de d�bitos, certid�o de nascimento, certid�o de �bito, cidadania" />
	<meta name="description" content="Buscamos e Enviamos para todo Brasil, receba no conforto de sua casa. Trabalhamos com diversas certid�es. Inclusive de casamento" />';
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
		if($servico=='') $servico='Cart�rio Postal';
		echo
	'<title>'.$servico.', Solicite suas Certid�es</title>
	<meta name="keywords" content="certid�es,'.$servico.', certid�es de nascimento, certid�o de d�bitos, certid�o de casamento, certid�o de �bito, cidadania" />
	<meta name="description" content="'.$servico.' Enviamos para todo Brasil, receba sua certid�o no conforto de sua casa. Trabalhamos com diversas certid�es." />
';
}
?>
	<meta http-equiv="Refresh" content="atualiza" />
	<meta name="REVISIT-AFTER" content="3" />
	<meta name="ROBOTS" content="all" />
	<meta name="GOOGLEBOT" content="INDEX, FOLLOW" />
	<meta name="AUDIENCE" content="all" />
	<meta name="AUTHOR" content="Canal dos Profissionais" />
 