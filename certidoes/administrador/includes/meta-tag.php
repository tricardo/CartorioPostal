<?
switch($pg){
	case 'pagina_inicial':
		echo
		'<title>Admin Center - Powered by Softfox</title>
		<meta name="keywords" content="ferramenta on-line, area - administrativa"/>
		<meta name="description" content="Área exclusiva do cliente Softfox"/>';
		break;
	case 'suporte':
		echo
		'<title>Admin Center - Suporte ao cliente</title>
		<meta name="keywords" content="suporte on-line, perguntas frequentes" />
		<meta name="description" content="Área exclusiva do cliente Softfox"/>';
		break;
	default:
		echo
		'<title>Admin Center - Powered by Softfox</title>
		<meta name="keywords" content="ferramenta on-line, area - administrativa, suporte on-line, perguntas frequentes"/>
		<meta name="description" content="Área exclusiva do cliente Softfox"/>';
}
?>
<meta http-equiv="Refresh" content="atualiza" />
<meta name="REVISIT-AFTER" content="3" />
<meta name="ROBOTS" content="all" />
<meta name="GOOGLEBOT" content="INDEX, FOLLOW" />
<meta name="AUDIENCE" content="all" />
<meta name="AUTHOR" content="Softfox" />