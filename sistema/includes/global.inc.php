<?php

function pt_register() {
    $num_args = func_num_args();
    $vars = array();

    if ($num_args >= 2) {
        $method = strtoupper(func_get_arg(0));

        if (($method != 'SESSION') && ($method != 'GET') && ($method != 'POST') && ($method != 'SERVER') && ($method != 'COOKIE') && ($method != 'ENV')) {
            die('The first argument of pt_register must be one of the following: GET, POST, SESSION, SERVER, COOKIE, or ENV');
        }
        if ($method == 'POST') {
            $urlanterior = $_SERVER['HTTP_REFERER'];
            $urloficial = 'http://www.cartoriopostal.com.br';
            $urloficial2 = 'https://www.cartoriopostal.com.br';
            $urlanterior2 = substr($urlanterior, 0, strlen($urloficial2));
            $urlanterior = substr($urlanterior, 0, strlen($urloficial));

            $ip = getenv("REMOTE_ADDR");

            //if ($urlanterior != $urloficial and $urlanterior2 != $urloficial2 and $urlanterior <> '' and $_SERVER['SERVER_NAME'] == 'www.cartoriopostal.com.br') {
            //    echo '<b>Comando Ilegal</b><br><br>Seu comando foi bloqueado no nosso servidor!!!<br><br>
           //Seu IP é: ' . $ip . '<br><br>
           //<a href="' . $urloficial . '">Clique aqui para voltar para a página inicial</a><br><br><br>';
           //     exit;
            //}
        }
        $varname = "_{$method}";
        global ${$varname};

        for ($i = 1; $i < $num_args; $i++) {
            $parameter = func_get_arg($i);

            if (isset(${$varname}[$parameter])) {
                global $$parameter;
                $$parameter = str_replace("\'", "´", ${$varname}[$parameter]);
            }
        }
    } else {
        die('You must specify at least two arguments');
    }
}

?>