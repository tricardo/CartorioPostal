<?
$ip = explode(',', $_SERVER["HTTP_X_FORWARDED_FOR"]);
$ip2 = $ip[0];
$ip = $ip2;
switch ($_POST['sistema']) {
    case 1:
        session_start();
        header('Content-Type: text/html; charset=utf-8');
        require('../saf/includes/classQuery.php');
        require('../saf/includes/browser.php');

        $_SESSION['safpostal_logado'] = '';
        $_SESSION['safpostal_login'] = '';
        $_SESSION['safpostal_senha'] = '';
        $_SESSION['safpostal_id'] = '';
        $_SESSION['safpostal_tabela'] = '';
        $_SESSION['safpostal_teste'] = '';

        $browser2 = new MyBrowser();
        $versao = $browser2->browser('version');
        $browser = $browser2->browser('browser');
        if ($browser == 'MSIE' and $versao <= '6.0') {
            $erro = '<div id="erro_login">Seu internet explorer está desatualizado e está vulnerável a invasão.<br><br>
			Atualize seu internet explorer para a versão 7 ou instale o Firefox.</div>';
            break;
        }
        $login = str_replace("\'", "", $_POST['login']);
        $senha = str_replace("\'", "", $_POST['senha']);
        $senha = $login . $senha;
        $senha = md5($senha);
        $ip = $ip;
        $logar = '';
        $sql = "SELECT uu.id_usuario, uu.email, ue.franquia FROM vsites_user_usuario as uu, vsites_user_empresa as ue
		WHERE uu.email = '" . $login . "' AND uu.senha = '" . $senha . "' and uu.status!='Cancelado'
		and ue.status!='Cancelado' and ue.id_empresa=uu.id_empresa";
        $query = $objQuery->SQLQuery($sql);
        $row = mysql_num_rows($query);
        $res = mysql_fetch_array($query);
        $id_usuario = $res['id_usuario'];
        if ($row <> '') {
            $logar = 'SIM';
            $safpostal_tabela = 'vsites_user_usuario';
            $safpostal_id = 'id_usuario';
            $sql = "insert into vsites_log_acesso set data_login=NOW(), id_usuario = '" . $id_usuario . "', ip='" . $ip . "'";
            $query = $objQuery->SQLQuery($sql);
        }

        if ($logar == '' || $login == '' || $senha == '') {
            $erro .= '<div id="erro_login">Login ou Senha inválida, ou o seu ip não está cadastrado para acessar nosso sistema.<br><br>
			Seu IP Ã©: ' . $ip . '</div>';
            break;
        } else {
            if ($safpostal_id <> '') {
                $_SESSION['safpostal_logado'] = 'ok';
                $_SESSION['safpostal_teste'] = '';
                $_SESSION['safpostal_login'] = $login;
                $_SESSION['safpostal_senha'] = $senha;
                $_SESSION['safpostal_id'] = $safpostal_id;
                $_SESSION['safpostal_tabela'] = $safpostal_tabela;
                echo 'aguarde...';
                echo "<script>setTimeout(\"location.href='../saf/safpostal/index.php'\", 1000);</script>" . " ";
                exit;
            }
        }
        break;

    case 2:
        session_start();
        header('Content-Type: text/html; charset=utf-8');
        require('../sistema/includes/classQuery.php');
        require('../sistema/includes/browser.php');
        require('../sistema/model/Database.php');
        require('../sistema/model/UsuarioDAO.php');
        require('../sistema/includes/funcoes.php');

        $_SESSION['controle_logado'] = '';
        $_SESSION['controle_login'] = '';
        $_SESSION['controle_senha'] = '';
        $_SESSION['controle_id'] = '';
        $_SESSION['controle_tabela'] = '';
        $_SESSION['controle_teste'] = '';

        $browser2 = new MyBrowser();
        $versao = $browser2->browser('version');
        $browser = $browser2->browser('browser');
        if ($browser == 'MSIE' and $versao <= '6.0') {
            $erro .= '<div id="erro_login">Seu internet explorer está desatualizado e está vulnerável a invasão.<br /><br />
					 Atualize seu internet explorer para a versão 7 ou instale o Firefox.</div>';
            break;
        }
        $login = str_replace("\'", "", $_POST['login']);
        $senha = str_replace("\'", "", $_POST['senha']);

        $login = str_replace('#', '', $login);
        $cliente = explode('/', $login);
        if (is_numeric($login) != 1 and COUNT($cliente) == 1) {
            $senha = $login . $senha;
            $senha = md5($senha);
        }
        $ip = explode(',', $ip);
        $logar = '';

        $usuarioDAO = new UsuarioDAO();

        try {
            $usuario = $usuarioDAO->login($login, $senha, $ip[0]);
            $departamento_p = explode(',', $usuario->departamento_p);
            $logar = 'SIM';

            if ($usuario->controle_id <> '' and $senha <> '') {
                $controle_atividade = '';
                if (in_array('2', $departamento_p) == 1) $controle_atividade .= ' or fina=1';
                if (in_array('10', $departamento_p) == 1) $controle_atividade .= ' or expe=1';
                if (in_array('5', $departamento_p) == 1 or in_array('15', $departamento_p) == 1) $controle_atividade .= ' or proc=1';
                if (in_array('3', $departamento_p) == 1) $controle_atividade .= ' or 2via=1';
                if (in_array('9', $departamento_p) == 1 or in_array('11', $departamento_p) == 1 or in_array('9', $departamento_p) == 1 or in_array('12', $departamento_p) == 1) $controle_atividade .= ' or prot=1';
                if (in_array('8', $departamento_p) == 1) $controle_atividade .= ' or imov=1';
                if (in_array('6', $departamento_p) == 1) $controle_atividade .= ' or aten=1';
                if (in_array('17', $departamento_p) == 1) $controle_atividade .= ' or juri=1';
                if (in_array('19', $departamento_p) == 1) $controle_atividade .= ' or cobr=1';
                if ($controle_atividade <> '') $controle_atividade = '1=2 ' . $controle_atividade; else $controle_atividade = '1=1';
                if (in_array('1', $departamento_p) == 1 or in_array('4', $departamento_p) == 1 or in_array('16', $departamento_p) == 1) $controle_atividade = '1=1';
                $_SESSION['controle_logado'] = 'ok';
                $_SESSION['controle_teste'] = '';
                $_SESSION['controle_login'] = $login;
                $_SESSION['controle_senha'] = $senha;
                #$_SESSION['controle_teste'] 	= 'Sim';
                $_SESSION['controle_atividade'] = $controle_atividade;
                $_SESSION['controle_id'] = $usuario->controle_id;
                $_SESSION['controle_tabela'] = $usuario->controle_tabela;
                #if($usuario->id_empresa==16 and $usuario->id_rede==''){
                #	echo '<meta HTTP-EQUIV="refresh" CONTENT="1; URL=./index_erro.php">';
                #}else {


                //COLOCAR REGRA QUE O SISTEMA ALTERA A 70 DIAS DO FINAL DO CONTRATO - THAUAN

                $usuarioDAO->atualiza_status_para_renovacao_empresa();


                echo 'aguarde...';
                echo "<script>setTimeout(\"location.href='../sistema/controle/index.php'\", 1000);</script>" . " ";
                exit;
                #}
            } else {
                $erro .= '<div id="erro_login">Login ou Senha inválida. ou o seu ip não está cadastrado para acessar nosso sistema.<br><br>
					Seu IP Ã©: ' . $ip[0] . ' <br></div>';
                break;
            }

        } catch (Exception $e) {
            $erro = '<div id="erro_login">Sistema, Login ou Senha inválida. ou o seu ip não está cadastrado para acessar nosso sistema.<br><br>
				Seu IP Ã©: ' . $ip[0] . ' <br>' . utf8_encode($e->getMessage()) . '</div>';
            break;
        }
        break;

    case 3:
        session_start();
        header('Content-Type: text/html; charset=utf-8');
        require('../sistema/includes/classQuery.php');
        require('../sistema/includes/browser.php');
        require('../sistema/model/Database.php');
        require('../sistema/model/DatabaseEAD.php');
        require('../sistema/model/UsuarioDAO.php');
        require('../sistema/model/EadDAO.php');
        require('../sistema/includes/funcoes.php');

        $_SESSION['controle_logado'] = '';
        $_SESSION['controle_login'] = '';
        $_SESSION['controle_senha'] = '';
        $_SESSION['controle_id'] = '';
        $_SESSION['controle_tabela'] = '';
        $_SESSION['controle_teste'] = '';

        $browser2 = new MyBrowser();
        $versao = $browser2->browser('version');
        $browser = $browser2->browser('browser');
        if ($browser == 'MSIE' and $versao <= '6.0') {
            $erro .= '<div id="erro_login">Seu internet explorer está desatualizado e está vulnerável a invasão.<br /><br />
					 Atualize seu internet explorer para a versão 7 ou instale o Firefox.</div>';
            break;
        }
        $login = str_replace("\'", "", $_POST['login']);
        $senha = str_replace("\'", "", $_POST['senha']);
        $senhaEAD = $senha;
        $login = str_replace('#', '', $login);
        $cliente = explode('/', $login);
        if (is_numeric($login) != 1 and COUNT($cliente) == 1) {
            $senha = $login . $senha;
            $senha = md5($senha);
        }
        $ip = explode(',', $ip);
        $logar = '';

        $usuarioDAO = new UsuarioDAO();

        try {
            $usuario = $usuarioDAO->loginExterno($login, $senha, $ip[0]);

            $departamento_p = explode(',', $usuario->departamento_p);
            $logar = 'SIM';

            if ($usuario->id_usuario <> '' and $senha <> '') {
                $eadDAO = new EadDAO();

                #atualiza no ead
                $eadDAO->atualizaEad($usuario, $senhaEAD);
                echo '<form action="http://www.cartoriopostal.net.br/ead/login/index.php" method="post" id="login" name="login" style="visibility:hidden">
						<input type="hidden" name="username" id="username" size="15" value="' . $usuario->email . '" />
						<input type="password" name="password" id="password" value="' . $senhaEAD . '" />
						</form>
						<script>document.forms["login"].submit();</script>';
                exit;
            } else {
                $erro .= '<div id="erro_login">Login ou Senha inválida. ou o seu ip não está cadastrado para acessar nosso sistema.<br><br>
					Seu IP Ã©: ' . $ip[0] . ' <br></div>';
                break;
            }

        } catch (Exception $e) {
            $erro = '<div id="erro_login">Sistema, Login ou Senha inválida. ou o seu ip não está cadastrado para acessar nosso sistema.<br><br>
				Seu IP Ã©: ' . $ip[0] . ' <br>' . utf8_encode($e->getMessage()) . '</div>';
            break;
        }
        break;
    case 4:
        session_start();
        header('Content-Type: text/html; charset=utf-8');
        require('../sistema/includes/classQuery.php');
        require('../sistema/includes/browser.php');
        require('../sistema/model/Database.php');
        require('../sistema/model/DatabaseSISTESTE.php');
        require('../sistema/model/UsuarioDAO.php');
        require('../sistema/model/UsuarioTesteDAO.php');
        require('../sistema/includes/funcoes.php');

        $_SESSION['controle_logado'] = '';
        $_SESSION['controle_login'] = '';
        $_SESSION['controle_senha'] = '';
        $_SESSION['controle_id'] = '';
        $_SESSION['controle_tabela'] = '';
        $_SESSION['controle_teste'] = '';

        $browser2 = new MyBrowser();
        $versao = $browser2->browser('version');
        $browser = $browser2->browser('browser');
        if ($browser == 'MSIE' and $versao <= '6.0') {
            $erro .= '<div id="erro_login">Seu internet explorer está desatualizado e está vulnerável a invasão.<br /><br />
					 Atualize seu internet explorer para a versão 7 ou instale o Firefox.</div>';
            break;
        }
        $login = str_replace("\'", "", $_POST['login']);
        $senha = str_replace("\'", "", $_POST['senha']);
        $senhaTeste = $senha;
        $login = str_replace('#', '', $login);
        $cliente = explode('/', $login);
        if (is_numeric($login) != 1 and COUNT($cliente) == 1) {
            $senha = $login . $senha;
            $senha = md5($senha);
        }
        $ip = explode(',', $ip);
        $logar = '';

        $usuarioDAO = new UsuarioDAO();

        try {
            $usuario = $usuarioDAO->loginExterno($login, $senha, $ip[0]);

            $departamento_p = explode(',', $usuario->departamento_p);
            $logar = 'SIM';

            if ($usuario->id_usuario <> '' and $senha <> '') {
                $usuarioTesteDAO = new UsuarioTesteDAO();

                #atualiza no sistema teste
                $usuarioTesteDAO->atualizaUsuarioTeste($usuario, $senhaTeste);
                echo '<form action="http://www.softfox.com.br/sistemateste/login/login_vai.php" method="post" id="login" name="login" style="visibility:hidden">
						<input type="hidden" name="login" value="' . $usuario->email . '" />
						<input type="hidden" name="senha" value="' . $senhaTeste . '" />
						<input type="hidden" name="submit1" value="1" />
						</form>
						<script>document.forms["login"].submit();</script>';
                exit;
            } else {
                $erro .= '<div id="erro_login">Login ou Senha inválida. ou o seu ip não está cadastrado para acessar nosso sistema.<br><br>
					Seu IP Ã©: ' . $ip[0] . ' <br></div>';
                break;
            }

        } catch (Exception $e) {
            $erro = '<div id="erro_login">Sistema, Login ou Senha inválida. ou o seu ip não está cadastrado para acessar nosso sistema.<br><br>
				Seu IP Ã©: ' . $ip[0] . ' <br>' . utf8_encode($e->getMessage()) . '</div>';
            break;
        }
        break;
} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Cartório Postal - Solicite suas Certidões</title>
    <link rel="shortcut icon" href="../certidoes/images/icone.gif"/>
    <style type="text/css">
        <!--
        body {
            background-color: #1C1D60;
            margin: 0;
            margin-top: 5px;
            font-family: normal x-small Verdana, Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #000000;
        }

        img {
            width: auto;
            height: auto;
            border: 0;
        }

        a {
            color: #000000;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        #container {
            width: 955px;
            position: absolute;
            left: 50%;
            margin-left: -477px;
            top: 50%;
            margin-top: -287px;
        }

        #header {
            width: 955px;
            height: 40px;
            background-image: url(images/header1.png);
            background-position: left top;
            background-repeat: no-repeat;
            float: left;
        }

        #mainContent {
            width: 955px;
            background-image: url(images/header3.png);
            background-repeat: repeat;
            float: left;
        }

        #marca {
            width: 955px;
            text-align: center;
            text-transform: uppercase;
            color: #0B1665;
            font-weight: bold;
            margin-top: 40px;
        }

        input {
            border: solid 1px #666666;
            margin-top: 7px;
        }

        select {
            border: solid 1px #666666;
            margin-top: 7px;
            width: 222px;
        }

        #login {
            width: 286px;
            margin-left: 335px;
            margin-top: 15px;
        }

        #login label {
            text-transform: uppercase;
            font-weight: bold;
            width: 60px;
            display: inline-block;
            margin-top: 7px;
        }

        #login input[type="text"] {
            width: 220px;
        }

        #login input[type="password"] {
            width: 168px;
        }

        #menu {
            width: 955px;
            height: 141px;
            background-image: url(images/line1.png);
            background-position: center;
            background-repeat: repeat-x;
            margin-top: -20px;
            margin-bottom: 30px;
        }

        #menu div {
            float: left;
        }

        #pagina_inicial {
            margin-top: -47px;
            margin-left: 60px;
            float: left;
            text-align: center;
            font-weight: bold;
        }

        #erro_login {
            position: absolute;
            top: 210px;
            right: 40px;
            width: 250px;
            height: 100px;
            font-weight: bold;
            color: #ff0000;
            padding: 5px;
            border: 1px solid #ff0000;
        }

        #franqueado {
            width: 120px;
            margin-top: 10px;
            margin-left: 300px;
            text-align: center;
            font-weight: bold;
        }

        #produtos {
            width: 120px;
            margin-top: 10px;
            text-align: center;
            font-weight: bold;
        }

        #footer {
            width: 955px;
            height: 51px;
            background-image: url(images/header2.png);
            background-position: left top;
            background-repeat: no-repeat;
            float: left;
            text-align: center;
        }

        -->
    </style>
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-58589188-20', 'auto');
        ga('send', 'pageview');

    </script>
</head>
<body>
<form method="post" action="index.php">
    <div id="container">
        <div id="header"></div>
        <div id="mainContent">
            <div id="marca">
                <img src="images/logo.png" alt="Cartório Postal"/><br/>
                <br/>acesso ao sistema on-line
            </div>
            <div id="login">
                <label>sistema:</label> <select name="sistema" style="width:215px">
                    <option value="2">Sistema</option>
                    <option value="4">Sistema Teste</option>
                    <option value="1">SAF</option>
                    <option value="3">Novo SAF</option>
                </select><br/>
                <label>Login:</label> <input name="login" style="width:211px" type="text" value=""/><br/>
                <label>Senha:</label> <input name="senha" style="width:163px" type="password" value=""/>
                <input type="submit" name="submit1" value="login"/><br/><br/>
            </div>
            <div id="menu">
                <div id="pagina_inicial">
                    <a href="http://www.cartoriopostal.com.br/certidoes/">
                        <img src="images/pagina_inicial1.png" alt="Cartório Postal"
                             onmouseover="this.src='images/pagina_inicial2.png'"
                             onmouseout="this.src='images/pagina_inicial1.png'"/></a><br/>
                    PÁGINA INICIAL
                </div>
                <div id="franqueado">
                    <a href="http://www.cartoriopostal.com.br/franquia/">
                        <img src="images/franqueado1.png" alt="Seja um Franqueado"
                             onmouseover="this.src='images/franqueado2.png'"
                             onmouseout="this.src='images/franqueado1.png'"/></a><br/>
                    SEJA UM<br/> FRANQUEADO
                </div>
                <div id="produtos">
                    <a href="http://www.cartoriopostal.com.br/certidoes/">
                        <img src="images/produtos1.png" alt="Produtos e Serviços"
                             onmouseover="this.src='images/produtos2.png'"
                             onmouseout="this.src='images/produtos1.png'"/></a><br/>
                    PRODUTOS E<br/> SERVIÇOS
                </div>
                <?= $erro ?>
            </div>
        </div>
        <div id="footer">
            Central de Atendimento <strong>(11) 3103-0800</strong> <br/>
            Copyright© 2009. Cartório Postal. Todos os Direitos Reservados. <strong><a href="#">Política de
                    Privacidade</a></strong> <br/>
            Desenvolvido por <strong><a href="http://www.canaldosprofissionais.com.br" target="_blank">CANAL DOS
                    PROFISSIONAIS</a></strong>
        </div>
    </div>
</form>
</body>
</html>
