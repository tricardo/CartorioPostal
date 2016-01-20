<? include('../base/variaveis.php')?>
<? if(!$ajax && !$is_mobile){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/> 
	<meta name="description" content="description"/>
	<meta name="keywords" content="keywords"/> 
	<meta name="author" content="author"/> 

    <link rel="stylesheet" type="text/css" href="<?=$urlBase?>/css/calendario.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="<?=$urlBase?>/css/transparentia.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="<?=$urlBase?>/css/datePicker.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="<?=$urlBase?>/css/abas.css" media="screen"/>
	<link type="text/css" href="<?=$urlBase?>/css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?=$urlBase?>/css/transparentia_ext.css" media="screen"/>

        <script type="text/javascript" language="javascript">
            var urlBase = '<?=$urlBase?>';
        </script>

	<script src="<?=$urlBase?>/mjs/jquery.min" language="javascript" type="text/javascript"></script>
	<script src="<?=$urlBase?>/mjs/jquery.ui.min" language="javascript" type="text/javascript"></script>
	<script src="<?=$urlBase?>/mjs/jquery.form" language="javascript" type="text/javascript"></script>
    <script src="<?=$urlBase?>/mjs/date" language="javascript" type="text/javascript"></script>
    <script src="<?=$urlBase?>/mjs/jquery.datePicker" language="javascript" type="text/javascript"></script>
	<script src="<?=$urlBase?>/mjs/main" language="javascript" type="text/javascript"></script>
	<script src="<?=$urlBase ?>/mjs/mascaras" language="javascript" type="text/javascript"></script>

	<title>cadastros auxiliares</title>
</head>

<body>

<div class="container">
	
	<div class="main">
		<div class="header">
                    <h2>sistema auxiliar de cadastros</h2>
                    <? if($_SESSION['usuario']!=''){?>
	                    <h4>
                        Olá <?=$_SESSION['usuario']?>.<a href="<?=$urlBase?>/usuario/logoff">sair</a>
	                    </h4>
                    <? } ?>
		</div>
		<div class="content">
			<div class="item">
				<? include_once("erro.list.php"); ?>
				<? foreach ($includes as $include){ 
					$submit = $include->getSubmit();
					$acao = $include->getAcao();?>
                   	<div class="bloco">
                    	<? include($include->getInclude());?>
                    </div>
				<? } ?>
			</div>
		</div>
		<? include('menu.php')?>
		<div class="clearer"><span></span></div>
	</div>

	
</div>
</body>
</html>
<?php
}else if($ajax && !$is_mobile){?>
	<?php include_once("erro.list.php"); 
	foreach ($includes as $include){ 
		$submit = $include->getSubmit();
		$acao = $include->getAcao();
		include($include->getInclude());	
	} ?>
<?php
}else if($is_mobile) { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">	
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/> 
    <link rel="stylesheet" type="text/css" href="<?=$urlBase?>/css/transparentia_ext_m.css" media="screen"/>
    <script src="<?=$urlBase?>/mjs/jquery.min" language="javascript" type="text/javascript"></script>
    <script type="text/javascript" language="javascript">
        var urlBase = '<?=$urlBase?>';
    </script>
	<title>cadastros auxiliares</title>
</head>
<body>

<div class="container">
	
	<div class="main">
		<div class="header">
                    <h2>sistema auxiliar de cadastros mobile</h2>
                    <? if($_SESSION['usuario']!=''){?>
	                    <h4>
                        Olá <?=$_SESSION['usuario']?>.<a href="<?=$urlBase?>/usuario/logoff">sair</a>
	                    </h4>
                    <? } ?>
		</div>
		<div class="content">
			<div class="item">
				<? include_once("erro.list.php"); ?>
				<? foreach ($includes as $include){ 
					$submit = $include->getSubmit();
					$acao = $include->getAcao();?>
                   	<div class="bloco">
                    	<? include($include->getInclude());?>
                    </div>
				<? } ?>
			</div>
		</div>
		<? //include('menu.php')?>
		<div class="clearer"><span></span></div>
	</div>

	
</div>
</body>
</html>

<?php } ?>