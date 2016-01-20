<?

function limpa_string($string) {
    $string = str_replace('á', 'a', $string);
    $string = str_replace('à', 'a', $string);
    $string = str_replace('À', 'A', $string);
    $string = str_replace('Á', 'A', $string);
    $string = str_replace('ã', 'a', $string);
    $string = str_replace('Ã', 'A', $string);
    $string = str_replace('Â', 'A', $string);
    $string = str_replace('â', 'a', $string);

    $string = str_replace('é', 'e', $string);
    $string = str_replace('è', 'e', $string);
    $string = str_replace('È', 'E', $string);
    $string = str_replace('É', 'E', $string);
    $string = str_replace('ê', 'e', $string);
    $string = str_replace('Ê', 'E', $string);
    $string = str_replace('Ë', 'E', $string);
    $string = str_replace('ë', 'e', $string);

    $string = str_replace('í', 'i', $string);
    $string = str_replace('ì', 'i', $string);
    $string = str_replace('Ì', 'I', $string);
    $string = str_replace('Í', 'I', $string);
    $string = str_replace('î', 'i', $string);
    $string = str_replace('Î', 'I', $string);
    $string = str_replace('ï', 'i', $string);
    $string = str_replace('Ï', 'I', $string);

    $string = str_replace('ó', 'o', $string);
    $string = str_replace('ò', 'o', $string);
    $string = str_replace('Ò', 'O', $string);
    $string = str_replace('Ó', 'O', $string);
    $string = str_replace('õ', 'o', $string);
    $string = str_replace('Õ', 'O', $string);
    $string = str_replace('Ô', 'O', $string);
    $string = str_replace('ô', 'o', $string);
    $string = str_replace('ö', 'o', $string);
    $string = str_replace('Ö', 'O', $string);

    $string = str_replace('ú', 'u', $string);
    $string = str_replace('ù', 'u', $string);
    $string = str_replace('Ù', 'U', $string);
    $string = str_replace('Ú', 'U', $string);
    $string = str_replace('û', 'u', $string);
    $string = str_replace('Û', 'U', $string);
    $string = str_replace('ü', 'u', $string);
    $string = str_replace('Ü', 'U', $string);

    $string = str_replace('~', '', $string);
    $string = str_replace('^', '', $string);
    $string = str_replace('´', '', $string);
    $string = str_replace('`', '', $string);
    $string = str_replace('"', '', $string);
    $string = str_replace("'", '', $string);
    $string = str_replace('!', '', $string);
    $string = str_replace('@', '', $string);
    $string = str_replace(']', '', $string);
    $string = str_replace('[', '', $string);
    $string = str_replace('}', '', $string);
    $string = str_replace('{', '', $string);
    $string = str_replace('ç', 'c', $string);
    $string = str_replace('Ç', 'C', $string);
    $string = str_replace(',', '', $string);
    $string = str_replace('.', '', $string);
    $string = str_replace('>', '', $string);
    $string = str_replace('<', '', $string);
    $string = str_replace(':', '', $string);
    $string = str_replace('?', '', $string);
    $string = str_replace('/', '', $string);
    $string = str_replace("\\", '', $string);
    $string = str_replace('|', '', $string);
    $string = str_replace('#', '', $string);
    $string = str_replace('$', '', $string);
    $string = str_replace('%', '', $string);
    $string = str_replace('¨', '', $string);
    $string = str_replace('&', '', $string);
    $string = str_replace('*', '', $string);
    $string = str_replace('(', '', $string);
    $string = str_replace(')', '', $string);
    $string = str_replace('=', '', $string);
    $string = str_replace('+', '', $string);

    return $string;
}

function limpa_url($url) {
    $url = str_replace('á', 'a', $url);
    $url = str_replace('à', 'a', $url);
    $url = str_replace('À', 'A', $url);
    $url = str_replace('Á', 'A', $url);
    $url = str_replace('ã', 'a', $url);
    $url = str_replace('Ã', 'A', $url);
    $url = str_replace('Â', 'A', $url);
    $url = str_replace('â', 'a', $url);

    $url = str_replace('é', 'e', $url);
    $url = str_replace('è', 'e', $url);
    $url = str_replace('È', 'E', $url);
    $url = str_replace('É', 'E', $url);
    $url = str_replace('ê', 'e', $url);
    $url = str_replace('Ê', 'E', $url);
    $url = str_replace('Ë', 'E', $url);
    $url = str_replace('ë', 'e', $url);

    $url = str_replace('í', 'i', $url);
    $url = str_replace('ì', 'i', $url);
    $url = str_replace('Ì', 'I', $url);
    $url = str_replace('Í', 'I', $url);
    $url = str_replace('î', 'i', $url);
    $url = str_replace('Î', 'I', $url);
    $url = str_replace('ï', 'i', $url);
    $url = str_replace('Ï', 'I', $url);

    $url = str_replace('ó', 'o', $url);
    $url = str_replace('ò', 'o', $url);
    $url = str_replace('Ò', 'O', $url);
    $url = str_replace('Ó', 'O', $url);
    $url = str_replace('õ', 'o', $url);
    $url = str_replace('Õ', 'O', $url);
    $url = str_replace('Ô', 'O', $url);
    $url = str_replace('ô', 'o', $url);
    $url = str_replace('ö', 'o', $url);
    $url = str_replace('Ö', 'O', $url);

    $url = str_replace('ú', 'u', $url);
    $url = str_replace('ù', 'u', $url);
    $url = str_replace('Ù', 'U', $url);
    $url = str_replace('Ú', 'U', $url);
    $url = str_replace('û', 'u', $url);
    $url = str_replace('Û', 'U', $url);
    $url = str_replace('ü', 'u', $url);
    $url = str_replace('Ü', 'U', $url);

    $url = str_replace('~', '', $url);
    $url = str_replace('^', '', $url);
    $url = str_replace('´', '', $url);
    $url = str_replace('`', '', $url);
    $url = str_replace('"', '', $url);
    $url = str_replace("'", '', $url);
    $url = str_replace('!', '', $url);
    $url = str_replace('@', '', $url);
    $url = str_replace(']', '', $url);
    $url = str_replace('[', '', $url);
    $url = str_replace('}', '', $url);
    $url = str_replace('{', '', $url);
    $url = str_replace('ç', 'c', $url);
    $url = str_replace('Ç', 'C', $url);
    $url = str_replace(',', '', $url);
    $url = str_replace('.', '', $url);
    $url = str_replace('>', '', $url);
    $url = str_replace('<', '', $url);
    $url = str_replace(';', '', $url);
    $url = str_replace(':', '', $url);
    $url = str_replace('?', '', $url);
    $url = str_replace('/', '', $url);
    $url = str_replace("\\", '', $url);
    $url = str_replace('|', '', $url);
    $url = str_replace('#', '', $url);
    $url = str_replace('$', '', $url);
    $url = str_replace('%', '', $url);
    $url = str_replace('¨', '', $url);
    $url = str_replace('&', '', $url);
    $url = str_replace('*', '', $url);
    $url = str_replace('(', '', $url);
    $url = str_replace(')', '', $url);
    $url = str_replace('=', '', $url);
    $url = str_replace('+', '', $url);

    return $url;
}

function diasemana($data) {
    $ano = substr("$data", 0, 4);
    $mes = substr("$data", 5, -3);
    $dia = substr("$data", 8, 9);

    $diasemana = date("w", mktime(0, 0, 0, $mes, $dia, $ano));
    return $diasemana;
}

function traduzMes($m) {
    if ($m == 1)
        return 'Janeiro';
    elseif ($m == 2)
        return 'Fevereiro';
    elseif ($m == 3)
        return 'Março';
    elseif ($m == 4)
        return 'Abril';
    elseif ($m == 5)
        return 'Maio';
    elseif ($m == 6)
        return 'Junho';
    elseif ($m == 7)
        return 'Julho';
    elseif ($m == 8)
        return 'Agosto';
    elseif ($m == 9)
        return 'Setembro';
    elseif ($m == 10)
        return 'Outubro';
    elseif ($m == 11)
        return 'Novembro';
    elseif ($m == 12)
        return 'Dezembro';
}

/**
 * formata uma data
 * se tipo == SQL recebe dd*mm*yyyy e retorna yyyy*mm*dd
 * se tipo!=SQL recebe yyyy*mm*dd e devolve dd*mm*yyy
 *
 * @param $datainv
 * @param $sep separador para retornar
 * @param $tipo
 */
function invert($datainv, $sep, $tipo) {//recebe a data e o separador
    if ($tipo != 'SQL') {
        $ano = substr("$datainv", 0, 4);
        $mes = substr("$datainv", 5, 2);
        $dia = substr("$datainv", 8, 2);
        $datainv = "$dia$sep$mes$sep$ano";
    } else {
        $ano = substr("$datainv", 6, 4);
        $mes = substr("$datainv", 3, 2);
        $dia = substr("$datainv", 0, 2);
        $datainv = $ano . '-' . $mes . '-' . $dia;
    }
    return $datainv;
}

function valida_numero($num) {
    if (ereg('[^0-9]', $num)) {
        return 'FALSE';
    }
    return 'TRUE';
}

#verifica permissao
function verifica_permissao($area, $id_departamento_p, $id_departamento_s) {//recebe a data e o separador
    $departamento_s = explode(',', $id_departamento_s);
    $departamento_p = explode(',', $id_departamento_p);
    if (count($departamento_s)) {
        foreach ($departamento_s as $l) {
            $controle_depto_s[$l] = '1';
        }
    }
    if (count($departamento_p)) {
        foreach ($departamento_p as $l) {
            $controle_depto_p[$l] = '1';
        }
    }

    $id_departamento_p = explode(',', $id_departamento_p);
    $id_departamento_s = explode(',', $id_departamento_s);

    switch ($area) {
        case 'Pedido':
            if ($controle_depto_p['2'] == 1 or $controle_depto_p['3'] == 1 or $controle_depto_p['4'] == 1 or $controle_depto_p['5'] == 1 or $controle_depto_p['6'] == 1 or $controle_depto_p['8'] == 1 or $controle_depto_p['9'] == 1 or $controle_depto_p['10'] == 1 or $controle_depto_p['16'] == 1 or $controle_depto_s['19'] == 1 or $controle_depto_p['1'] == 1)
                return 'TRUE';
        case 'Conta':
            if ($controle_depto_s['2'] == 1 or $controle_depto_p['14'] == 1 or $controle_depto_p['1'] == 1)
                return 'TRUE';
            break;
        case 'Direcao':
            if ($controle_depto_p['16'] == 1 or $controle_depto_p['1'] == 1)
                return 'TRUE';
            break;
        case 'Franquia':
            if ($controle_depto_p['16'] == 1 or $controle_depto_p['17'] == 1 or $controle_depto_p['1'] == 1 or $controle_depto_p['28'] == 1)
                return 'TRUE';
            break;
        case 'Rel_gerencial':
            if ($controle_depto_p['16'] == 1 or $controle_depto_s['17'] == 1 or $controle_depto_p['1'] == 1)
                return 'TRUE';
            break;
        case 'EXPANSAO':
            if ($controle_depto_p['3'] == 1 or $controle_depto_p['26'] == 1 or $controle_depto_p['1'] == 1)
                return 'TRUE';
            break;
        case 'EXPANSAO_S':
            if ($controle_depto_s['3'] == 1 or $controle_depto_s['26'] == 1 or $controle_depto_s['1'] == 1)
                return 'TRUE';
            break;
        case 'Rel_supervisores':
            if ($controle_depto_s['3'] == 1 or $controle_depto_s['5'] == 1 or $controle_depto_s['8'] == 1 or $controle_depto_s['9'] == 1 or $controle_depto_s['11'] == 1 or $controle_depto_s['12'] == 1 or $controle_depto_s['15'] == 1 or $controle_depto_s['16'] == 1 or $controle_depto_p['1'] == 1)
                return 'TRUE';
            break;
        case 'Rel_n_supervisores':
            if ($controle_depto_p['3'] == 1 or $controle_depto_p['5'] == 1 or $controle_depto_p['8'] == 1 or $controle_depto_p['9'] == 1 or $controle_depto_s['11'] == 1 or $controle_depto_s['12'] == 1 or $controle_depto_s['15'] == 1 or $controle_depto_s['16'] == 1 or $controle_depto_p['1'] == 1)
                return 'TRUE';
            break;
        case 'Rel_atendimento':
            if ($controle_depto_s['6'] == 1 or $controle_depto_p['16'] == 1)
                return 'TRUE';
            break;
        case 'Financeiro_rel':
            if ($controle_depto_p['2'] == 1 or $controle_depto_s['16'] == 1)
                return 'TRUE';
            break;
        case 'Rel_financeiro_franquia':
            if ($controle_depto_s['2'] == 1 or $controle_depto_s['16'] == 1)
                return 'TRUE';
            break;
        case 'Imoveis':
            if ($controle_depto_p['8'] == 1 or $controle_depto_p['16'] == 1)
                return 'TRUE';
            break;
        case 'Processos':
            if ($controle_depto_p['5'] == 1 or $controle_depto_p['16'] == 1)
                return 'TRUE';
            break;
        case '2via':
            if ($controle_depto_p['3'] == 1 or $controle_depto_p['16'] == 1)
                return 'TRUE';
            break;
        case 'Financeiro':
            if ($controle_depto_p['2'] == 1)
                return 'TRUE';
            break;
        case 'Financeiro Cobrança':
            if ($controle_depto_p['19'] == 1)
                return 'TRUE';
            break;
        case 'Pontos de Vendas':
            if ($controle_depto_s['14'] == 1)
                return 'TRUE';
            break;
        case 'Empresas':
            if ($controle_depto_p['1'] == 1)
                return 'TRUE';
            break;
        case 'Cartorio':
            if ($controle_depto_p['3'] == 1 or $controle_depto_p['5'] == 1 or $controle_depto_p['8'] == 1 or $controle_depto_p['9'] == 1 or $controle_depto_p['11'] == 1 or $controle_depto_p['1'] == 1 or $controle_depto_p['6'] == 1)
                return 'TRUE';
            break;
        case 'Duplicidade':
            if ($controle_depto_p['1'] == 1 or $controle_depto_s['6'] == 1)
                return 'TRUE';
            break;
        case 'Departamento':
            if ($controle_depto_p['8'] == 1 or $controle_depto_p['3'] == 1 or $controle_depto_p['5'] == 1 or $controle_depto_p['9'] == 1)
                return 'TRUE';
            break;
        case 'Protesto':
            if ($controle_depto_p['9'] == 1 or $controle_depto_p['11'] == 1)
                return 'TRUE';
            break;
        case 'Cliente':
            if ($controle_depto_s['10'] == 1 or $controle_depto_s['2'] == 1 or $controle_depto_p['1'] == 1 or $controle_depto_s['14'] == 1 or $controle_depto_s['6'] == 1)
                return 'TRUE';
            break;
        case 'Parceiro':
            if ($controle_depto_s['10'] == 1 or $controle_depto_s['2'] == 1 or $controle_depto_p['1'] == 1 or $controle_depto_s['14'] == 1 or $controle_depto_s['6'] == 1)
                return 'TRUE';
            break;
        case 'Pedido Add':
            if ($controle_depto_p['6'] == 1)
                return 'TRUE';
            break;
        case 'Pedido Import':
            if ($controle_depto_s['6'] == 1 or $controle_depto_p['16'] == 1)
                return 'TRUE';
            break;
        case 'Pedido Import Cart':
            if ($controle_depto_s['5'] == 1 or $controle_depto_p['16'] == 1)
                return 'TRUE';
            break;
        case 'Direcionamento':
            if ($controle_depto_s['3'] == 1 or $controle_depto_s['4'] == 1 or $controle_depto_s['5'] == 1 or $controle_depto_s['8'] == 1 or $controle_depto_s['9'] == 1 or $controle_depto_s['11'] == 1 or $controle_depto_s['12'] == 1 or $controle_depto_s['18'] == 1)
                return 'TRUE';
            break;
        case 'Direcionamento_site':
            if ($controle_depto_s['6'] == 1)
                return 'TRUE';
            break;
        case 'Financeiro Pedido Edit':
            if ($controle_depto_p['10'] == 1 or $controle_depto_p['2'] == 1)
                return 'TRUE';
            break;
        case 'Financeiro Desembolsado':
            if ($controle_depto_p['2'] == 1)
                return 'TRUE';
            break;
        case 'Financeiro Pedido Edit Valor':
            if ($controle_depto_p['2'] == 1)
                return 'TRUE';
            break;
        case 'Financeiro Pedido Edit Troco':
            if ($controle_depto_p['10'] == 1 or $controle_depto_p['2'] == 1)
                return 'TRUE';
            break;
        case 'Remessa_Retorno':
            if ($controle_depto_s['6'] == 1 or $controle_depto_p['5'] == 1)
                return 'TRUE';
            break;
        case 'Supervisor Atendimento':
            if ($controle_depto_s['6'] == 1)
                return 'TRUE';
            break;
        case 'Supervisor Financeiro':
            if ($controle_depto_s['2'] == 1)
                return 'TRUE';
            break;
        case 'Financeiro Compra':
            if ($controle_depto_s['20'] == 1)
                return 'TRUE';
            break;
        case 'Financeiro Pgto':
            if ($controle_depto_s['21'] == 1)
                return 'TRUE';
            break;
        case 'Financeiro PgtoCont':
            if ($controle_depto_s['21'] == 1 or $controle_depto_p['27'] == 1)
                return 'TRUE';
            break;            
        case 'Supervisor':
            if (COUNT($id_departamento_s) > 0)
                return 'TRUE';
            break;
        case 'Franchising':
            if ($controle_depto_p['17'] == 1)
                return 'TRUE';
            break;
        case 'Rel_comercial':
            if ($controle_depto_s['14'] == 1 or $controle_depto_s['16'] == 1)
                return 'TRUE';
            break;
        case 'FAQ':
            if ($controle_depto_s['6'] == 1)
                return 'TRUE';
            break;
    }

    return 'FALSE';
}

// VERIFICA CPF
function validaCPF($cpf) {
    $soma = 0;
    $cpf = str_replace('.', '', $cpf);
    $cpf = str_replace('-', '', $cpf);
    $cpf = str_replace('/', '', $cpf);
    if (strlen($cpf) <> 11 or $cpf == '11111111111' or $cpf == '22222222222' or $cpf == '33333333333' or $cpf == '44444444444' or $cpf == '55555555555' or $cpf == '66666666666' or $cpf == '77777777777' or $cpf == '88888888888' or $cpf == '99999999999') {
        $valida = 'false';
        return $valida;
    }
    // Verifica 1º digito
    //PEGA O DIGITO VERIFIACADOR
    $dv_informado = substr($cpf, 9, 2);

    for ($i = 0; $i <= 8; $i++) {
        $digito[$i] = substr($cpf, $i, 1);
    }

    //CALCULA O VALOR DO 10º DIGITO DE VERIFICAÇÂO
    $posicao = 10;
    $soma = 0;

    for ($i = 0; $i <= 8; $i++) {
        $soma = $soma + $digito[$i] * $posicao;
        $posicao = $posicao - 1;
    }

    $digito[9] = $soma % 11;

    if ($digito[9] < 2) {
        $digito[9] = 0;
    } else {
        $digito[9] = 11 - $digito[9];
    }

    //CALCULA O VALOR DO 11º DIGITO DE VERIFICAÇÃO
    $posicao = 11;
    $soma = 0;

    for ($i = 0; $i <= 9; $i++) {
        $soma = $soma + $digito[$i] * $posicao;
        $posicao = $posicao - 1;
    }

    $digito[10] = $soma % 11;

    if ($digito[10] < 2) {
        $digito[10] = 0;
    } else {
        $digito[10] = 11 - $digito[10];
    }

    //VERIFICA SE O DV CALCULADO É IGUAL AO INFORMADO
    $dv = $digito[9] * 10 + $digito[10];
    $dv_informado = $dv_informado * 1;
    if ($dv != $dv_informado)
        $valida = 'false';
    else
        $valida = 'true';
    return $valida;
}

/**
 * valida se o telefone está no formato (99) 9999-9999
 * @param $tel
 * @return boolean
 */
function validaTel($tel) {
    $pattern = '/(\(\d\d\)) (\d{4}-\d{4})/';
    return preg_match($pattern, $tel, $matches);
}

function validaEMAIL($email) {
    $mail_correcto = 0;
    //verifico umas coisas
    if ((strlen($email) >= 6) && (substr_count($email, "@") == 1) && (substr($email, 0, 1) != "@") && (substr($email, strlen($email) - 1, 1) != "@")) {
        if ((!strstr($email, "'")) && (!strstr($email, "\"")) && (!strstr($email, "\\")) && (!strstr($email, "\$")) && (!strstr($email, " "))) {
            //vejo se tem caracter .
            if (substr_count($email, ".") >= 1) {
                //obtenho a terminação do dominio
                $term_dom = substr(strrchr($email, '.'), 1);
                //verifico que a terminação do dominio seja correcta
                if (strlen($term_dom) > 1 && strlen($term_dom) < 5 && (!strstr($term_dom, "@"))) {
                    //verifico que o de antes do dominio seja correcto
                    $antes_dom = substr($email, 0, strlen($email) - strlen($term_dom) - 1);
                    $caracter_ult = substr($antes_dom, strlen($antes_dom) - 1, 1);
                    if ($caracter_ult != "@" && $caracter_ult != ".") {
                        $mail_correcto = 1;
                    }
                }
            }
        }
    }

    if ($mail_correcto)
        return 'true';
    else
        return 'false';
}

// VERFICA CNPJ
function validaCNPJ($cnpj) {
    $cnpj = str_replace('.', '', $cnpj);
    $cnpj = str_replace('-', '', $cnpj);
    $cnpj = str_replace('/', '', $cnpj);
    if (strlen($cnpj) <> 14)
        return 'false';

    $soma = 0;

    $soma += ($cnpj[0] * 5);
    $soma += ($cnpj[1] * 4);
    $soma += ($cnpj[2] * 3);
    $soma += ($cnpj[3] * 2);
    $soma += ($cnpj[4] * 9);
    $soma += ($cnpj[5] * 8);
    $soma += ($cnpj[6] * 7);
    $soma += ($cnpj[7] * 6);
    $soma += ($cnpj[8] * 5);
    $soma += ($cnpj[9] * 4);
    $soma += ($cnpj[10] * 3);
    $soma += ($cnpj[11] * 2);

    $d1 = $soma % 11;
    $d1 = $d1 < 2 ? 0 : 11 - $d1;

    $soma = 0;
    $soma += ($cnpj[0] * 6);
    $soma += ($cnpj[1] * 5);
    $soma += ($cnpj[2] * 4);
    $soma += ($cnpj[3] * 3);
    $soma += ($cnpj[4] * 2);
    $soma += ($cnpj[5] * 9);
    $soma += ($cnpj[6] * 8);
    $soma += ($cnpj[7] * 7);
    $soma += ($cnpj[8] * 6);
    $soma += ($cnpj[9] * 5);
    $soma += ($cnpj[10] * 4);
    $soma += ($cnpj[11] * 3);
    $soma += ($cnpj[12] * 2);


    $d2 = $soma % 11;
    $d2 = $d2 < 2 ? 0 : 11 - $d2;

    if ($cnpj[12] == $d1 && $cnpj[13] == $d2) {
        return 'true';
    } else {
        return 'false';
    }
}

function valida_upload($arquivo, $config) {
    // Verifica se o mime-type do arquivo é de imagem
    $error = '';
    if (!eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $arquivo["type"])) {
        $error.="<li><b>Arquivo em formato inválido! A imagem deve ser jpg, jpeg,
				bmp, gif ou png. Envie outro arquivo.</b></li>";
    } else {
        // Verifica tamanho do arquivo
        if ($arquivo["size"] > $config["tamanho"]) {
            $error.="<li><b>Arquivo em tamanho muito grande!
			A imagem deve ser de no máximo " . $config["tamanho"] . " bytes. 
			Envie outro arquivo.</b></li>";
        }

        // Para verificar as dimensões da imagem
        $tamanhos = getimagesize($arquivo["tmp_name"]);

        // Verifica largura
        if ($tamanhos[0] > $config["largura"]) {
            $error.="<li><b>Largura da imagem não deve
					ultrapassar " . $config["largura"] . " pixels.</b></li>";
        }

        // Verifica altura
        if ($tamanhos[1] > $config["altura"]) {
            $error.="<li><b>Altura da imagem não deve
					ultrapassar " . $config["altura"] . " pixels.</b></li>";
        }
    }
    return $error;
}

function valida_upload_pdf($arquivo, $config) {
    // Verifica se o mime-type do arquivo é de imagem
    $error = '';
    if (!eregi("^image\/(pjpeg|jpeg|png|gif|bmp|pdf)$", $arquivo["type"]) and !eregi("^application\/(pdf)$", $arquivo["type"]) and !eregi("text/pdf", $arquivo["type"]) and !eregi("^application/x-www-form-urlencoded$", $arquivo["type"])) {
        $error.="<li><b>Arquivo em formato inválido! O arquivo deve ser jpg, jpeg,
				bmp, gif, pdf ou png. Envie outro arquivo.</b></li>" . $arquivo["type"];
		
    }
    return $error;
}

function valida_upload_csv($arquivo, $config) {
    // Verifica se o mime-type do arquivo é de imagem
    $error = '';
    if (!eregi(".csv$", $arquivo["type"])) {
        $error.="<li><b>Arquivo em formato inválido! O arquivo precisa ser CSV. Envie outro arquivo.</b></li>";
    }
    return $error;
}

function valida_upload_txt($arquivo) {
    // Verifica se o mime-type do arquivo é de imagem
    $error = '';
    if (!eregi("csv$", $arquivo["type"]) and !eregi("text/comma-separated-values$", $arquivo["type"]) and !eregi("text/plain$", $arquivo["type"]) and !eregi("octet/stream$", $arquivo["type"]) and !eregi("application/octet-stream$", $arquivo["type"])) {
        $error.="<li><b>Arquivo em formato inválido! O arquivo precisa ser RET, REM, CSV ou TXT. Envie outro arquivo.</b></li>" . $arquivo["type"];
    }
    return $error;
}

#soma data

function SomarData($data, $dias, $meses, $ano) {
    //passe a data no formato dd/mm/yyyy
    $data = explode("/", $data);
    $newData = date("d/m/Y", mktime(0, 0, 0, $data[1] + $meses, $data[0] + $dias, $data[2] + $ano));
    return $newData;
}

#fim soma data
#soma data

function SubtrairData($data, $dias, $meses, $ano) {
    //passe a data no formato dd/mm/yyyy
    $data = explode("/", $data);
    $newData = date("d/m/Y", mktime(0, 0, 0, $data[1] - $meses, $data[0] - $dias, $data[2] - $ano));
    return $newData;
}

#fim soma data

function ValidaData($dat) {
    $dat = str_replace('.', '', str_replace(' ', '', str_replace('-', '', str_replace('/', '', $dat))));

    $d = substr($dat, 0, 2);
    $m = substr($dat, 2, 2);
    $y = substr($dat, 4, 4);
    if (strlen($dat) < 8 or !is_numeric($d) or !is_numeric($m) or !is_numeric($y))
        return FALSE;

    if (checkdate($m, $d, $y)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

# Gera Thumbnails

function thumbMaker($imagem, $aprox, $destino) {
    if (!file_exists($imagem)) {
        echo "<center><h3>Imagem não encontrada.</h3></center>";
        return false;
    }

    // verifica se está executando sob windows ou unix-like, para a
    // aplicação do separador de diretórios correto.
    $barra = "/";

    // obtém a extensão pelo mime-type
    $ext = getExt($imagem);
    if (!$ext) {
        echo "<center><h3>Tipo inválido</h3></center>";
        return false;
    }
    // separa o nome do arquivo do(s) diretório(s)
    $dir_arq = explode($barra, $imagem);


    // monta o nome do arquivo a ser gerado (thumbnail). O sizeof abaixo obtém o número de itens
    // no array, dessa forma podemos pegar somente o nome do arquivo, não importando em que
    // diretório está.
    $i = sizeof($dir_arq) - 1; // pega o nome do arquivo, sem os diretórios
    $arquivo_miniatura = $destino . $barra . "mini_" . $dir_arq[$i];

    // imagem de origem
    if ($ext == "png")
        $img_origem = imagecreatefrompng($imagem);
    elseif ($ext == "jpg")
        $img_origem = imagecreatefromjpeg($imagem);

    // obtém as dimensões da imagem original
    $origem_x = ImagesX($img_origem);
    $origem_y = ImagesY($img_origem);

    $x = $origem_x;
    $y = $origem_y;

    // Aqui é feito um cálculo para aproximar o tamanho da imagem ao valor passado em $aprox.
    // Não importa se a foto for grande ou pequena, o thumb de todas elas será mais ou menos do
    // mesmo tamanho.
    if ($x >= $y) {
        if ($x > $aprox) {
            $x1 = (int) ($x * ($aprox / $x));
            $y1 = (int) ($y * ($aprox / $x));
        }
        // incluido o else abaixo. Caso a imagem seja menor do que
        // deve ser aproximado, mantém tamanho original para o thumb.
        else {
            $x1 = $x;
            $y1 = $y;
        }
    } else {
        if ($y > $aprox) {
            $x1 = (int) ($x * ($aprox / $y));
            $y1 = (int) ($y * ($aprox / $y));
        }
        // incluido o else abaixo. Caso a imagem seja menor do que
        // deve ser aproximado, mantém tamanho original para o thumb.
        else {
            $x1 = $x;
            $y1 = $y;
        }
    }
    $x = $x1;
    $y = $y1;

    // cria a imagem do thumbnail
    $img_final = ImageCreateTrueColor($x, $y);
    ImageCopyResampled($img_final, $img_origem, 0, 0, 0, 0, $x + 1, $y + 1, $origem_x, $origem_y);

    // o arquivo é gravado
    if ($ext == "png")
        imagepng($img_final, $arquivo_miniatura);
    elseif ($ext == "jpg")
        imagejpeg($img_final, $arquivo_miniatura);

    // a memória usada para tudo isso é liberada.
    ImageDestroy($img_origem);
    ImageDestroy($img_final);

    return true;
}

// getExt - Verifica o mime-type da imagem e retorna a extensão do arquivo
function getExt($imagem) {
    // isso é para obter o mime-type da imagem.
    $mime = getimagesize($imagem);

    if ($mime[2] == 2) {
        $ext = "jpg";
        return $ext;
    } else
    if ($mime[2] == 3) {
        $ext = "png";
        return $ext;
    }
    else
        return false;
}

function somar_dias_uteis($str_data, $int_qtd_dias_somar = 1) {

    $str_data = substr($str_data, 0, 10);
    if ($str_data == '' or $str_data == '0000-00-00' or $str_data == '00-00-0000') {
        return '00/00/0000';
    }

    // Caso seja informado uma data do MySQL do tipo DATETIME - aaaa-mm-dd 00:00:00
    // Transforma para DATE - aaaa-mm-dd
    // Se a data estiver no formato brasileiro: dd/mm/aaaa
    // Converte-a para o padrão americano: aaaa-mm-dd

    if (preg_match("@/@", $str_data) == 1) {
        $str_data = implode("-", array_reverse(explode("/", $str_data)));
    }

    $array_data = explode('-', $str_data);
    $count_days = 0;
    $int_qtd_dias_uteis = 0;

    while ($int_qtd_dias_uteis < $int_qtd_dias_somar) {
        $count_days++;
        $dias_da_semana = gmdate('w', strtotime('+' . $count_days . ' day', mktime(0, 0, 0, $array_data[1], $array_data[2], $array_data[0])));
        if ($dias_da_semana != '0' && $dias_da_semana != '6') {
            $int_qtd_dias_uteis++;
        }
    }

    $str_data_final = gmdate('Y-m-d', strtotime('+' . $count_days . ' day', strtotime($str_data)));
    $array_data = explode('-', $str_data_final);

    $objQuery = new classQuery();
    $sql_data_prazo = $objQuery->SQLQuery("select fer.id_feriado from vsites_feriados as fer where fer.data>='" . $str_data . "' and fer.data<='" . $str_data_final . "' and (fer.id_empresa='0' or fer.id_empresa='1')");
    $num_feriados = mysql_num_rows($sql_data_prazo);

    #Adiciona os feriados
    $count_days = 0;
    $int_qtd_dias_uteis = 0;

    while ($int_qtd_dias_uteis < $num_feriados) {
        $count_days++;
        $dias_da_semana = gmdate('w', strtotime('+' . $count_days . ' day', mktime(0, 0, 0, $array_data[1], $array_data[2], $array_data[0])));
        if ($dias_da_semana != '0' && $dias_da_semana != '6') {
            $int_qtd_dias_uteis++;
        }
    }

    $str_data_final2 = gmdate('Y-m-d', strtotime('+' . $count_days . ' day', strtotime($str_data_final)));
    $array_data = explode('-', $str_data_final2);

    #Adiciona os feriados pela segunda vez caso encontre feriados na primeira busca
    if ($num_feriados <> 0) {
        $sql_data_prazo = $objQuery->SQLQuery("select fer.id_feriado from vsites_feriados as fer where fer.data>'" . $str_data_final . "' and fer.data<='" . $str_data_final2 . "' and (fer.id_empresa='0' or fer.id_empresa='1')");
        $num_feriados = mysql_num_rows($sql_data_prazo);
        $count_days = 0;
        $int_qtd_dias_uteis = 0;
        while ($int_qtd_dias_uteis < $num_feriados) {
            $count_days++;
            $dias_da_semana = gmdate('w', strtotime('+' . $count_days . ' day', mktime(0, 0, 0, $array_data[1], $array_data[2], $array_data[0])));
            if ($dias_da_semana != '0' && $dias_da_semana != '6') {
                $int_qtd_dias_uteis++;
            }
        }
        $str_data_final = $str_data_final2;
        $str_data_final2 = gmdate('Y-m-d', strtotime('+' . $count_days . ' day', strtotime($str_data_final2)));
        $array_data = explode('-', $str_data_final2);

        #Adiciona os feriados pela terceira vez caso encontre feriados na segunda busca
        if ($num_feriados <> 0) {
            $sql_data_prazo = $objQuery->SQLQuery("select fer.id_feriado from vsites_feriados as fer where fer.data>'" . $str_data_final . "' and fer.data<='" . $str_data_final2 . "' and (fer.id_empresa='0' or fer.id_empresa='1')");
            $num_feriados = mysql_num_rows($sql_data_prazo);
            $count_days = 0;
            $int_qtd_dias_uteis = 0;
            while ($int_qtd_dias_uteis < $num_feriados) {
                $count_days++;
                $dias_da_semana = gmdate('w', strtotime('+' . $count_days . ' day', mktime(0, 0, 0, $array_data[1], $array_data[2], $array_data[0])));
                if ($dias_da_semana != '0' && $dias_da_semana != '6') {
                    $int_qtd_dias_uteis++;
                }
            }
            $str_data_final = $str_data_final2;
            $str_data_final2 = gmdate('Y-m-d', strtotime('+' . $count_days . ' day', strtotime($str_data_final2)));
            $array_data = explode('-', $str_data_final2);
        }
    }

    if (gmdate('w', strtotime($str_data_final2)) == '6') {
        $str_data_final2 = gmdate('Y-m-d', strtotime('+2 day', strtotime($str_data_final2)));
    }

    if (gmdate('w', strtotime($str_data_final2)) == '0') {
        $str_data_final2 = gmdate('Y-m-d', strtotime('+1 day', strtotime($str_data_final2)));
    }

    return $str_data_final2;
}

#fim do gera thumbnails
#dias uteis

function dias_uteis($datainicial, $datafinal=null) {
    if (!isset($datainicial))
        return false;
    if (!isset($datafinal))
        $datafinal = date('d/m/Y');

    $segundos_datainicial = strtotime(preg_replace("#(\d{2})/(\d{2})/(\d{4})#", "$3/$2/$1", $datainicial));
    $segundos_datafinal = strtotime(preg_replace("#(\d{2})/(\d{2})/(\d{4})#", "$3/$2/$1", $datafinal));
    $dias = abs(floor(floor(($segundos_datafinal - $segundos_datainicial) / 3600) / 24));
    $uteis = 0;
    for ($i = 1; $i <= $dias; $i++) {
        $diai = $segundos_datainicial + ($i * 3600 * 24);
        $w = date('w', $diai);
        if ($w == 0) {
            //echo date('d/m/Y',$diai)." ? Domingo<br />";
        } elseif ($w == 6) {
            //echo date('d/m/Y',$diai)." ? Sábado<br />";
        } else {
            //echo date('d/m/Y',$diai)." ? dia útil<br />";
            $uteis++;
        }
    }
    return $uteis;
}

function __autoload($classe) {
    $dir = preg_match('/^([A-Z][a-z]+)DAO/i', $classe, $result);
    if (is_file("../model/" . $result[1] . "DAO.php")) {
        require_once("../model/" . $result[1] . "DAO.php");
        return;
    } else {
        $dir = preg_match('/^([A-Z][a-z]+)CLASS/i', $classe, $result);
        if (is_file("../classes/" . $result[1] . "CLASS.php")) {
            require_once("../classes/" . $result[1] . "CLASS.php");
            return;
        }
    }
}

function formatarCPF_CNPJ($campo, $formatado = true) {
    //retira formato
    $codigoLimpo = ereg_replace("[' '-./ t]", '', $campo);
    // pega o tamanho da string menos os digitos verificadores
    $tamanho = (strlen($codigoLimpo) - 2);
    //verifica se o tamanho do código informado é válido
    if ($tamanho != 9 && $tamanho != 12) {
        return false;
    }

    if ($formatado) {
        // seleciona a máscara para cpf ou cnpj
        $mascara = ($tamanho == 9) ? '###.###.###-##' : '##.###.###/####-##';

        $indice = -1;
        for ($i = 0; $i < strlen($mascara); $i++) {
            if ($mascara[$i] == '#')
                $mascara[$i] = $codigoLimpo[++$indice];
        }
        //retorna o campo formatado
        $retorno = $mascara;
    }else {
        //se não quer formatado, retorna o campo limpo
        $retorno = $codigoLimpo;
    }

    return $retorno;
}

function AjaxPaginacao($lista) {
    $total = $lista[0];
    $qtde_pagina = $lista[1];
    $num_pagina = $lista[2];
    $pagina = $lista[3];
    $form = $lista[4];
    $limite = 12;

    if ($total > 1) {
        $paginacao .= '&nbsp;Foram encontrados ' . $total . ' registros nesta forma de busca.<br />';
        if (($total % $qtde_pagina) == 0) {
            $total_loop = $total / $qtde_pagina;
        } else {
            $total_loop = (int) (($total / $qtde_pagina) + 1);
        }
        $paginacao .= '&nbsp;';
        if ($total > $qtde_pagina) {
            $paginacao .= '<a href="#" onclick="AjaxPaginacao(\'' . $pagina . '\',0, \'' . $form . '\');" style="color:#333333; font-weight:bold"><< primeira</a> |&nbsp;&nbsp;';
            for ($i = ($num_pagina - $limite); $i <= ($num_pagina + $limite); $i++) {
                if ($i > 0 && $i < $total_loop) {
                    if ($i == ($num_pagina + 1)) {
                        if ($i < 10) {
                            $paginacao .= '<span style="font-weight:bold">[0' . $i . ']</span> |&nbsp;&nbsp;';
                        } else {
                            $paginacao .= '<span style="font-weight:bold">[' . $i . ']</span> |&nbsp;&nbsp;';
                        }
                        //$i++;
                    } else {
                        $paginacao .= '<a href="#" onclick="AjaxPaginacao(\'' . $pagina . '\',' . ($i - 1) . ', \'' . $form . '\');" style="color:#333333">';
                        if ($i < 10)
                            $paginacao .= '0' . $i;
                        else
                            $paginacao .= $i;

                        $paginacao .= '</a> | ';
                    }
                }
            }
            $paginacao .= ' <a href="#" onclick="AjaxPaginacao(\'' . $pagina . '\',' . ($total_loop - 1) . ', \'' . $form . '\');" style="color:#333333; font-weight:bold">última >></a>&nbsp;&nbsp;';
        }
    } else {
        $paginacao .= '&nbsp;Foi encontrado 01 registro nesta forma de busca.<br />';
    }

    return $paginacao;
}

function FormataNumero($str) {
    for ($i = 0; $i < strlen($str); $i++) {
        if (
                $str[$i] == '0' ||
                $str[$i] == '1' ||
                $str[$i] == '2' ||
                $str[$i] == '3' ||
                $str[$i] == '4' ||
                $str[$i] == '5' ||
                $str[$i] == '6' ||
                $str[$i] == '7' ||
                $str[$i] == '8' ||
                $str[$i] == '9'
        ) {
            $campo .= $str[$i];
        }
    }
    return $campo;
}

function FormataControleId($n) {
    $id_ficha = '';
    for ($i = 0; $i < (6 - strlen($n)); $i++) {
        $id_ficha .= '0';
    }
    $id_ficha .= $n;
    $id_ficha = substr($id_ficha, 0, 3) . '.' . substr($id_ficha, -3, 3);
    return $id_ficha;
}

function FormataInteresse($acao, $field) {
    $retorno = $field;
    switch ($acao) {
        case 1:
            if (strlen($retorno) > 0) {
                $d1 = explode(' ', $retorno);
                $d2 = explode('-', $d1[0]);
                $retorno = $d2[2] . '/' . $d2[1] . '/' . $d2[0];
            }
            break;

        case 2:
            switch ($retorno) {
                case 0: $retorno = 'Aberto';
                    break;
                case 1: $retorno = 'Aprovado';
                    break;
                case 2: $retorno = 'Reprovado';
                    break;
            }
            break;

        case 3:
            $retorno = (strlen($retorno) == 0) ? '&nbsp;' : $retorno;
            break;

        case 4:
            $retorno = ($field->total == 1) ? 'Foi encontrado ' : 'Foram encontrados ';
            $retorno .= $field->total;
            $retorno .= ($field->total == 1) ? ' registro.' : ' registros.<br />';
            $k = (($field->total % $field->paginacao) == 0) ? ($field->total / $field->paginacao) : ($field->total / $field->paginacao) + 1;
            $k = (int) $k;
            if ($k > 1) {
                if ($field->pagina > 0) {
                    $retorno .= '<a href="?pagina=' . $field->pagina . '">anterior</a> ';
                }
                $field->pagina = $field->pagina + 1;
                for ($i = 1; $i <= $k; $i++) {
                    if ($field->pagina == $i) {
                        $retorno .= '<strong>[' . $i . ']</strong> ';
                    } else {
                        $retorno .= '<a href="?pagina=' . $i . '">' . $i . '</a> | ';
                    }
                }
                if ($field->pagina < $k) {
                    $retorno .= '<a href="?pagina=' . ($field->pagina + 1) . '">próxima</a> ';
                }
            }
            break;
    }
    return $retorno;
}

function ultimoDiaMes($data="") {
    if (!$data) {
        $dia = date("d");
        $mes = date("m");
        $ano = date("Y");
    } else {
        $data2 = explode('/', $data);
        $dia = $data2[0];
        $mes = $data2[1];
        $ano = $data2[2];
    }
    $data = mktime(0, 0, 0, $mes + 1, $dia - 1, $ano);
    return date('d', $data);
}

function mes_ext($mes) {
    switch ($mes) {
        case 01:
            return 'Janeiro';
            break;
        case 02:
            return 'Fevereiro';
            break;
        case 3:
            return 'Março';
            break;
        case 4:
            return 'Abril';
            break;
        case 5:
            return 'Maio';
            break;
        case 6:
            return 'Junho';
            break;
        case 7:
            return 'Julho';
            break;
        case 8:
            return 'Agosto';
            break;
        case 9:
            return 'Setembro';
            break;
        case 10:
            return 'Outubro';
            break;
        case 11:
            return 'Novembro';
            break;
        case 12:
            return 'Dezembro';
            break;
    }
}

?>
