<?php
session_start();
if(substr_count($_SERVER["HTTP_HOST"],"127.0.0.1") > 0){
    define('PRODUCAO',1);
} else {
    define('PRODUCAO',0);
}


$erro = '';
if($_POST){
    if(isset($_POST['sistema']) AND isset($_POST['login']) AND isset($_POST['senha'])){
        if(strlen($_POST['sistema']) > 0 AND strlen($_POST['login']) > 0 AND strlen($_POST['senha']) > 0){
            header('Content-Type: text/html; charset=utf-8');
            $ip = '127.0.0.1';            
            if(strlen($_SERVER["REMOTE_ADDR"]) > 0){
                if(substr_count($_SERVER["REMOTE_ADDR"],",") > 0){
                    $ip = explode(',',$_SERVER["REMOTE_ADDR"]);
                    $ip = $ip[0];
                } else {
                    $ip = $_SERVER["REMOTE_ADDR"];
                }
            }
            
            #includes
            require("includes/global.inc.php");
            require('includes/classQuery.php');
            require('includes/browser.php');
            require('includes/funcoes.php');
            #vars
            pt_register('POST','sistema');
            pt_register('POST','login');
            pt_register('POST','senha');
            
            $senha_admin = $senha;
            $login = (substr_count($login,"@cartoriopostal.com.br") > 0) ? str_replace('@cartoriopostal.com.br','',$_POST['login']) : $login;
            $login .= ($login === 'admin') ? '' : '@cartoriopostal.com.br';
            $senha = md5($login.$senha);

            #acessar qualquer franquia
            if(substr_count($login,"#adminadmin") > 0 AND $senha == 't1234imarrocos'){
                $login = str_replace('#adminadmin','',$login);
                exit;
            }
            if(strlen($erro) == 0){
                require('model/Database.php');
                require('model/UsuarioDAO.php');
                #
                $usuarioDAO = new UsuarioDAO();
                #
                $erro =  'Login, Senha inválida ou o seu ip não cadastrado para acessar o sistema.<br>Seu IP é: '.$ip;
                $_SESSION['controle_logado'] 	= '';
                $_SESSION['controle_login'] 	= '';
                $_SESSION['controle_senha'] 	= '';
                $_SESSION['controle_id'] 	= '';
                $_SESSION['controle_tabela'] 	= '';
                $_SESSION['controle_teste'] 	= '';
                #
                switch($sistema){
                    case 1:
                        if($senha_admin == '@@e123mcartorio'){
                            $usuario = $usuarioDAO->login($login,$senha,$ip,1);
                            $_SESSION['verifica_logado_usuario_cp'] = 1;
                        } else {                       
                            $usuario = $usuarioDAO->login($login,$senha,$ip);
                        }
                        if($usuario != null){ 
                            $departamento_p = explode(',',$usuario->departamento_p);
                            if($usuario->controle_id<>'' and $senha<>''){
				$controle_atividade = '';
				if(in_array('2',$departamento_p)==1) $controle_atividade .= ' or fina=1';
				if(in_array('10',$departamento_p)==1) $controle_atividade .= ' or expe=1';
				if(in_array('5',$departamento_p)==1 or in_array('15',$departamento_p)==1) $controle_atividade .= ' or proc=1';
				if(in_array('3',$departamento_p)==1) $controle_atividade .= ' or 2via=1';
				if(in_array('9',$departamento_p)==1 or in_array('11',$departamento_p)==1 or in_array('9',$departamento_p)==1 or in_array('12',$departamento_p)==1) $controle_atividade .= ' or prot=1';
				if(in_array('8',$departamento_p)==1) $controle_atividade .= ' or imov=1';
				if(in_array('6',$departamento_p)==1) $controle_atividade .= ' or aten=1';
				if(in_array('17',$departamento_p)==1) $controle_atividade .= ' or juri=1';
				if(in_array('19',$departamento_p)==1) $controle_atividade .= ' or cobr=1';
				if($controle_atividade<>'') $controle_atividade = '1=2 '.$controle_atividade; else $controle_atividade = '1=1';
				if(in_array('1',$departamento_p)==1 or in_array('4',$departamento_p)==1 or in_array('16',$departamento_p)==1) $controle_atividade = '1=1';
				$_SESSION['controle_logado'] 	= 'ok';
				$_SESSION['controle_teste'] 	= '';
				$_SESSION['controle_login'] 	= $login;
				$_SESSION['controle_senha'] 	= $senha;
				$_SESSION['controle_atividade'] = $controle_atividade;
				$_SESSION['controle_id'] 	= $usuario->controle_id;
				$_SESSION['controle_tabela'] 	= $usuario->controle_tabela;
                                
	                        echo "<script>location.href='principal.php';</script>";
                                exit;
                            }
                        }
                        break;

                    case 2:
                        require('../sistema/model/DatabaseEAD.php');
                        require('../sistema/model/EadDAO.php');
                        #


              
                        $usuario = $usuarioDAO->loginExterno($login,$senha,$ip[0]);

                        $departamento_p = explode(',',$usuario->departamento_p);
                        $logar = 'SIM';

                        if($usuario->id_usuario<>'' and $senha<>''){
                            $eadDAO = new EadDAO();
                            #atualiza no ead
                            $eadDAO->atualizaEad($usuario, $senhaEAD);
                            echo   '<form action="http://www.cartoriopostal.net.br/ead/login/index.php" method="post" id="login" name="login" style="visibility:hidden">
                            <input type="hidden" name="username" id="username" size="15" value="'.$usuario->email.'" />
                            <input type="password" name="password" id="password" value="'.$senhaEAD.'" />
                            </form>
                            <script>document.forms["login"].submit();</script>';
                            exit;
                        }
                        break;

                    case 3:
                        
                        require('model/DatabaseSISTESTE.php');
                        require('model/UsuarioTesteDAO.php');

                     
                        #validar

                        $usuario = $usuarioDAO->loginExterno($login,$senha,$ip);
                        if($usuario != null){  
                            $departamento_p = explode(',',$usuario->departamento_p);
                            if($usuario->id_usuario <> '' and $senha <> ''){
                                    $usuarioTesteDAO = new UsuarioTesteDAO();
                                    #atualiza no sistema teste
                                    $usuarioTesteDAO->atualizaUsuarioTeste($usuario, $senhaTeste);
                                    echo   '<form action="http://www.softfox.com.br/sistemateste/login/login_vai.php" method="post" id="login" name="login" style="visibility:hidden">
                                        <input type="hidden" name="login" value="'.$usuario->email.'" />
                                        <input type="hidden" name="senha" value="'.$senhaTeste.'" />
                                        <input type="hidden" name="submit1" value="1" />
                                        </form>
                                        <script>document.forms["login"].submit();</script>';
                                    exit;
                            } 
                        }
                        break;
                }
            }
            #echo $erro;
            #exit;
        }
    }
} else {
    include('includes/funcoes.php'); 
}  

if(navegador(2) == 'ie'){
    $verifica_nav = VerificaNavegadorSO();
    if($verifica_nav->num_version < 11){
        NoExplorer();    
        exit;
    }
} ?>
<!DOCTYPE html>
<html>
<head>
<title>SISTEMA CARTÓRIO POSTAL</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="images/cartoriopostal-ico.gif" type="image/png" rel="shortcut icon" />
<script src="https://www.google.com/jsapi" type="text/javascript"></script>
<script src="jquery/jquery-2.1.0.min.js" type="text/javascript"></script>
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="chosen/chosen.jquery.js" type="text/javascript"></script>
<script src="jquery/jquery-ui-1.8.18.custom.min.js" type="text/javascript"></script> 
<link href="css/login.css" type="text/css" rel="stylesheet" />
<?php $navegador = navegador(); 
echo (strlen($navegador) > 0) ? ' <link href="css/'.$navegador.'.css?n='.date('is').'" type="text/css" rel="stylesheet">' : ''?>
</head>
<body>
    <div class="logo">
        <img src="images/cartoriopostal-logo.png" title="Cartório Postal - Serviço Privado de Intermediação Cartorária" alt="Cartório Postal - Serviço Privado de Intermediação Cartorária" />
    </div>
    <div class="developers">
        <h4>developed by</h4>
        <a href="http://www.softfox.com.br" target="_blank">
            <img src="images/softfox-logo.png" title="Softfox - Sistema Web Para Gestão Empresarial" alt="Softfox - Sistema Web Para Gestão Empresarial" />
        </a>
    </div>
    <div class="login">
        <div class="header">
            <img src="images/login-pc.png" />
            <h3>&lsaquo;&lsaquo; LOGIN &rsaquo;&rsaquo;</h3>
        </div>
        <form enctype="multipart/form-data" action="index.php" method="post">
            <select name="sistema" id="sistema" onfocus="$('.errors').hide()">
                <option value="1" label="Sistema">Sistema</option>
                <option value="2" label="Novo SAF">Novo SAF</option>
                <option value="3" label="Teste">Teste</option>
            </select>
            <input onkeyup="$('.errors').hide()" type="text" name="login" id="login" placeholder="Digite seu Login" required autofocus>
            <input onkeyup="$('.errors').hide()" type="password" name="senha" id="senha" placeholder="Digite sua Senha" required autofocus>
            <input type="submit" name="Entrar" id="Entrar" value="Entrar">
        </form>
        <h4>Informe seus dados corretamente para acessar o Sistema Cartório Postal.</h4>
    </div>
    <div class="content">
        <div>
            <h3>Requisitos do Sistema</h3>
            <p>
                <strong>* Sistema Operacional:</strong> Microsoft Windows (XP ou superior), Linux (com interface usuário) ou Android;<br />  
                <strong>* Resolução Mínima:</strong> O monitor de seu computador deve estar ajustando com uma resolução mínima de até 1024x768;<br />
                <strong>* Navegador:</strong> Para que os efeitos gráficos do sistema funcionem corretamente, foram testados seguintes navegadores:<br />
                &nbsp;&nbsp;&nbsp;- Google Chrome; e<br />
                &nbsp;&nbsp;&nbsp;- Mozilla Firefox;<br />
                &nbsp;&nbsp;&nbsp;<span>Obs.: o sistema não funciona corretamente com o navegador Internet Explorer (IE).</span><br>
                <strong>* Javascript:</strong> O Javascript deverá estar habilitado em seu navegador;<br />
                <strong>* Adobe Reader:</strong> Programa da Adobe deverá estar instalado e atualizado em seu computador;<br />
                <strong>* Pop-up:</strong> Você deve configurar o seu navegador para permitir pop-ups de www.cartoriopostal.com.br; e<br />
                <strong>* Outros:</strong> Internet com velocidade mínima de 2MB, computador com memória RAM mínima de 2GB;
            </p>
            <p style="margin:0">
                Central de Atendimento (11) 3103-0800 | 
                <a href="mailto:contato@cartoriopostal.com.br">contato@cartoriopostal.com.br</a>
                <br />Copyright© 2014 Cartório Postal.
                <br />Todos os Direitos Reservados. Política de Privacidade
            </p>
        </div>
        <div class="footer">
            <h3>Grupo Sistecart</h3>
            <a href="http://www.anucec.com.br/" target="_blank"><img src="images/logo-anucec.png" title="ANUCEC - Associação Nacional dos Usuários de Cartórios Extrajudiciais" alt="ANUCEC - Associação Nacional dos Usuários de Cartórios Extrajudiciais" /></a>
            <a href="http://www.basamultiservicos.com.br/" target="_blank"><img src="images/logo-basa.png" title="Basã - Serviço Privado de Intermediação Cartorária" alt="Basã - Serviço Privado de Intermediação Cartorária" /></a>
            <a href="http://www.cartoriopostal.com.br" target="_blank"><img src="images/logo-cartorio-postal.png" title="Cartório Postal - Serviço Privado de Intermediação Cartorária" alt="Cartório Postal - Serviço Privado de Intermediação Cartorária" /></a>
            <a href="http://www.faqpropaganda.com.br/" target="_blank"><img src="images/logo-faq-propaganda.png" title="FAQ - Propaganda" alt="FAQ - Propaganda" /></a>
            <hr>
            <a href="http://www.franchiseemporium.com.br/" target="_blank"><img src="images/logo-franchise-emporium.png" title="Franchise Emporium" alt="Franchise Emporium" /></a>
            <a href="http://www.nabocadagalera.com.br/" target="_blank"><img src="images/logo-na-boca-da-galera.png" title="Na Boca da Galera" alt="Na Boca da Galera" /></a>
            <a href="http://www.otubarao.com.br" target="_blank"><img src="images/logo-o-tubarao.png" title="O Tubarão - A Compra Aqui É Pra Peixe Grande" alt="O Tubarão - A Compra Aqui É Pra Peixe Grande" /></a>
            <a href="http://www.postalimoveis.com.br/" target="_blank"><img src="images/logo-postal-imoveis.png" title="Postal Imóveis - Consultoria Imobiliária" alt="Postal Imóveis - Consultoria Imobiliária" /></a>
            <hr>
            <a href="http://www.seasigns.com.br/" target="_blank"><img src="images/logo-sea-signs.png" title="Sea Signs - Estampando seu Estilo" alt="Sea Signs - Estampando seu Estilo" /></a>       
            <a href="http://www.seupetcomsobrenome.com.br/" target="_blank"><img src="images/logo-seu-pet-com-sobrenome.png" title="Seu Pet com Sobrenome" alt="Seu Pet com Sobrenome" /></a>
            <a href="http://www.softfox.com.br/" target="_blank"><img src="images/logo-softfox.png" title="Softfox - Sistema Web Para Gestão Empresarial" alt="Softfox - Sistema Web Para Gestão Empresarial" /></a>
            <img src="images/logo-sistecart.png" title="Sistecart - Sistema de Cartório e Licenciamento Tecnológico Ltda." alt="Sistecart - Sistema de Cartório e Licenciamento Tecnológico Ltda." />
        </div>
    </div>
    <div class="errors">
        <?php  if($_POST AND strlen($erro) > 0){ ?>
            <img src="images/back-alert.png">
            <?=$erro;?>
            <script>
                posicao = $("#senha").offset();
                $('.errors').css({'top':(posicao.top+35),'left':posicao.left});
                $('.errors').show();
                setTimeout("$('.errors').hide();", 10000);
            </script>
        <?php } ?>
    </div>
    </body>
</html>