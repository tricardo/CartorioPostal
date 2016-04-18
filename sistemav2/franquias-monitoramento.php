<?php
require("includes/verifica_logado_controle.inc.php");
$permissao = verifica_permissao('Franquia', $controle_id_departamento_p, $controle_id_departamento_s);
if ($permissao == 'FALSE' or $controle_id_empresa != '1') {
    header('location:pagina-erro.php');
    exit;
}

pt_register('GET', 'login');

if((array_key_exists(28, $controle_depto_p) AND $controle_depto_p[28] == 1) OR $controle_id_usuario == 1){
   
    $usuarioDAO = new UsuarioDAO();
    $login .= '@cartoriopostal.com.br';
    try {
		$monitoramento_nome = $controle_nome;
		$monitoramento_id_empresa = $controle_id_empresa;
		$monitoramento_id_usuario = $controle_id_usuario;
	
        $usuario = $usuarioDAO->login_monitoramento($login,$controle_id_usuario);
        $departamento_p = explode(',', $usuario->departamento_p);
        $logar = 'SIM';

        if ($usuario->id_usuario <> '') {
            $controle_atividade = '';
            if (in_array('2', $departamento_p) == 1){ $controle_atividade .= ' or fina=1'; }
            if (in_array('10', $departamento_p) == 1){ $controle_atividade .= ' or expe=1'; }
            if (in_array('5', $departamento_p) == 1 or in_array('15', $departamento_p) == 1){ $controle_atividade .= ' or proc=1'; }
            if (in_array('3', $departamento_p) == 1){ $controle_atividade .= ' or 2via=1'; }
            if (in_array('9', $departamento_p) == 1 or in_array('11', $departamento_p) == 1 or in_array('9', $departamento_p) == 1 or in_array('12', $departamento_p) == 1){
                $controle_atividade .= ' or prot=1';
            }
            if (in_array('8', $departamento_p) == 1){ $controle_atividade .= ' or imov=1'; }
            if (in_array('6', $departamento_p) == 1){ $controle_atividade .= ' or aten=1'; }
            if (in_array('17', $departamento_p) == 1){ $controle_atividade .= ' or juri=1'; }
            if (in_array('19', $departamento_p) == 1){ $controle_atividade .= ' or cobr=1'; }
            if ($controle_atividade <> ''){
                $controle_atividade = '1=2 ' . $controle_atividade; 
            } else {
                $controle_atividade = '1=1';
            }
            if (in_array('1', $departamento_p) == 1 or in_array('4', $departamento_p) == 1 or in_array('16', $departamento_p) == 1){
                $controle_atividade = '1=1';
            }
            $_SESSION['controle_logado'] = 'ok';
            $_SESSION['controle_teste'] = '';
            $_SESSION['controle_login'] = $login;
            $_SESSION['controle_senha'] = $usuario->senha;
            #$_SESSION['controle_teste'] 	= 'Sim';
            $_SESSION['controle_atividade'] = $controle_atividade;
            $_SESSION['controle_id'] = $usuario->id_usuario; #$usuario->controle_id;
            $_SESSION['controle_id_monitoramento'] = $controle_id_usuario;
            $_SESSION['controle_tabela'] = isset($usuario->controle_tabela) ? $usuario->controle_tabela : '';
            if(isset($_SESSION['monitoramento_id_empresa'])){
                    $_SESSION['monitoramento_nome'] = $monitoramento_nome;
                    $_SESSION['monitoramento_id_empresa'] = $monitoramento_id_empresa;
                    $_SESSION['monitoramento_id_usuario'] = $monitoramento_id_usuario;
            } 
            echo '<meta HTTP-EQUIV="refresh" CONTENT="1;URL=principal.php">';
            
        }
    } catch (Exception $e) {
        echo "Login ou Senha inválida. ou o seu ip não está cadastrado para acessar nosso sistema.<br><br>
			Seu IP é: " . $_SERVER["HTTP_X_FORWARDED_FOR"] . " <br>" . $e->getMessage();
    }
}